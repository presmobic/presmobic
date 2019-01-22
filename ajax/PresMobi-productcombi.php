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
$mobi_token = (string)Tools::getValue('token_pres');
$checktoken = $core->cookiekeymodule();
if ($mobi_token != $checktoken) {
    echo $core->transbv();
    die;
}
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context=Context::getContext();
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$id_product = Tools::getValue('id_product');
$data_attribute = Tools::getValue('selected_attribute');
$data_attribute = rtrim($data_attribute, ',');
$combination = explode(',', $data_attribute);
if ($data_attribute == '') {
    $id_product_attribute = 0;
} else {
    $sql = "SELECT  pa.`id_product_attribute` AS id_pro,a.`id_attribute`";
    $sql .= "  AS id_attribute,agl.`name` AS group_name, al.`name` AS attribute_name";
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
    $checkstock = Configuration::get('PS_ORDER_OUT_OF_STOCK');
    $checkqties = Configuration::get('PS_LAST_QTIES');
    if ($id_product_attribute == 0) {
        if ($checkstock == 1) {
            echo '2';
            die;
        }
        echo '1';
        die;
    } else {
        $quantity_combi = StockAvailable::getQuantityAvailableByProduct($id_product, $id_product_attribute, $id_shop);
        if ($checkqties >= $quantity_combi) {
            $check = 1;
        } else {
            $check = 2;
        }
        $price_static = Product::getPriceStatic($id_product, true, $id_product_attribute);
        $price_static = Tools::displayPrice($price_static);
        $data = array(
            'qty' => $quantity_combi,
            'price' => $price_static,
            'checkqties' => $check,
        );
    }
    echo json_encode($data);
    die;
}
