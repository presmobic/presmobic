<?php
/**
* 2017-2019 Buy Addons Team
*
* NOTICE OF LICENSE
*
* This source file is subject to the GNU General Public License version 3
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://www.opensource.org/licenses/gpl-3.0.html
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@buy-addons.com so we can send you a copy immediately.
*
* @author Buy Addons Team <hatt@buy-addons.com>
* @copyright  2017-2019 Buy Addons Team
* @license   http://www.opensource.org/licenses/gpl-3.0.html  GNU General Public License version 3
* International Registered Trademark & Property of Buy Addons Team
*/

include_once('../../../config/config.inc.php');
include_once('../../../init.php');
include_once('./../presmobileapp.php');
$url_fodel = _PS_MODULE_DIR_;
include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
$core = new BaCore();
$mobi_token = Tools::getValue('token_pres');
$checktoken = $core->cookiekeymodule();
if ($mobi_token != $checktoken) {
    echo $core->transbv();
    die;
}
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context = Context::getContext();
$date_add = date('Y-m-d H:i:s');
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$id_shop_group = Context::getContext()->shop->id_shop_group;
$token = Tools::strtoupper(Tools::substr(sha1(uniqid(rand(), true)._COOKIE_KEY_.$context->customer->id), 0, 16));
$newsletter_date_add = date('Y-m-d H:i:s');
$id_product = Tools::getValue('id_product');
$type = Tools::getValue('type');
$id_wishlist = Tools::getValue('id_wishlist');
$data_attribute = Tools::getValue('data_attribute');
$data_attribute = rtrim($data_attribute, ',');
$combination = explode(',', $data_attribute);
$wishlist_product_array = array(
    'wishlist' => array(
        'id_product' => $id_product,
        'id_wishlist' =>$id_wishlist
    )
);
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
    $presmobic_bookmark = $core->mobiexec172('presmobic_bookmark', $wishlist_product_array);
} elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
    $presmobic_bookmark = $core->mobiexec17('presmobic_bookmark', $wishlist_product_array);
} else {
    $presmobic_bookmark = $core->mobiexec('presmobic_bookmark', $wishlist_product_array);
}
$id_product = $presmobic_bookmark['wishlist']['id_product'];
$id_wishlist = $presmobic_bookmark['wishlist']['id_wishlist'];
if ($data_attribute == '') {
    $id_product_attribute = 0;
} else {
    $sql = "SELECT  pa.`id_product_attribute` AS id_pro,a.`id_attribute` ";
    $sql .= " AS id_attribute,agl.`name` AS group_name, al.`name` AS attribute_name";
    $sql .= " FROM `" . _DB_PREFIX_ . "product_attribute` pa";
    $sql .= " INNER JOIN " . _DB_PREFIX_ . "product_attribute_shop product_attribute_shop";
    $sql .= " ON (product_attribute_shop.id_product_attribute ";
    $sql .= "= pa.id_product_attribute AND product_attribute_shop.id_shop = ".(int)$id_shop.")";
    $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "product_attribute_combination` pac ";
    $sql .= " ON pac.`id_product_attribute` = pa.`id_product_attribute`";
    $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "attribute` a ON a.`id_attribute` = pac.`id_attribute`";
    $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "attribute_group` ag ";
    $sql .= " ON ag.`id_attribute_group` = a.`id_attribute_group` ";
    $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "attribute_lang` al ";
    $sql .= "ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = ".(int)$id_lang.")";
    $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "attribute_group_lang` agl ";
    $sql .= "ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = ".(int)$id_lang.")";
    $sql .= " WHERE pa.`id_product` = ".(int)$id_product."";
    $sql .= " GROUP BY pa.`id_product_attribute`, ag.`id_attribute_group`";
    $sql .= " ORDER BY pa.`id_product_attribute`";
    $result = $db->Executes($sql);
    $attribute = array();
    foreach ($result as $key => $value) {
        $key;
        $attribute[$value['id_pro']][] =  $value['id_attribute'];
    }
    $aeb = array();
    $id_product_attribute = 0;
    foreach ($attribute as $key => $value) {
        $aeb =  array_diff($combination, $attribute[$key]);
        if (empty($aeb)) {
            $id_product_attribute = $key;
            break;
        }
    }
}
$priority = 1;
$quantity = 1;
if ($type == 1) {
    $select = "SELECT *FROM  " . _DB_PREFIX_ . "wishlist_product WHERE id_product=".(int)$id_product."";
    $select .= " AND id_product_attribute=".(int)$id_product_attribute."";
    $select .= " AND id_wishlist=".(int)$id_wishlist."";
    $select .= " AND id_product=".(int)$id_product."";
    $param = $db->Executes($select);
    if (empty($param)) {
        $sql = "INSERT INTO " . _DB_PREFIX_ . "wishlist_product ";
        $sql .= " VALUES('','".(int)$id_wishlist."','".(int)$id_product."',";
        $sql .= "'".(int)$id_product_attribute."','".(int)$quantity."','".(int)$priority."')";
        $db->query($sql);
    } else {
        $quantity = $param[0]['quantity'] + 1;
        $sql = "UPDATE " . _DB_PREFIX_ . "wishlist_product";
        $sql .= " SET quantity='".(int)$quantity."'";
        $sql .= " WHERE id_wishlist=".(int)$id_wishlist."";
        $sql .= " AND id_product=".(int)$id_product."";
        $db->query($sql);
    }
} else {
    $wishlist = "My wishlist";
    $sql = "INSERT INTO " . _DB_PREFIX_ . "wishlist ";
    $sql .= " VALUES('','".(int)$context->customer->id."','".pSQL($token)."'";
    $sql .= "'".pSQL($wishlist)."','','".(int)$id_shop."','".(int)$id_shop_group."',";
    $sql .= "'".pSQL($newsletter_date_add)."','".pSQL($newsletter_date_add)."','1')";
    $db->query($sql);
    $select = "SELECT *FROM  " . _DB_PREFIX_ . "wishlist ORDER BY id_wishlist DESC LIMIT 1";
    $param = $db->Executes($select);
    $select1 = "SELECT *FROM  " . _DB_PREFIX_ . "wishlist_product WHERE id_product=".(int)$id_product."";
    $select1 .= " AND id_product_attribute=".(int)$id_product_attribute."";
    $select1 .= " AND id_wishlist=".(int)$param[0]['id_wishlist']."";
    $select1 .= " AND id_product=".(int)$id_product."";
    $param1 = $db->Executes($select1);
    if (empty($param1)) {
        $sql1 = "INSERT INTO " . _DB_PREFIX_ . "wishlist_product ";
        $sql1 .= " VALUES('','".(int)$param[0]['id_wishlist']."','".(int)$id_product."',";
        $sql1 .= "'".(int)$id_product_attribute."','".(int)$quantity."','".(int)$priority."')";
        $db->query($sql1);
    } else {
        $quantity = $param[0]['quantity'] + 1;
        $sql = "UPDATE " . _DB_PREFIX_ . "wishlist_product";
        $sql .= " SET quantity='".(int)$quantity."'";
        $sql .= " WHERE id_wishlist=".(int)$param[0]['id_wishlist']."";
        $sql .= " AND id_product=".(int)$id_product."";
        $db->query($sql);
    }
}
$presmobileapp = new PresMobileApp();
$result =  array(
    'messenger' =>$presmobileapp->l('Added to your wishlist.'),
);
echo json_encode($result);
die;
