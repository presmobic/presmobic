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
$id_product = (int)Tools::getValue('id_product');
$id_customer = (int)Tools::getValue('id_customer');
$type = (int)Tools::getValue('type');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context = Context::getContext();
$date_add = date('Y-m-d H:i:s');
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$presmobileapp = new PresMobileApp();
$favorite_product_array = array(
    'favorites' => array(
        'id_product' => $id_product,
        'id_customer' =>$id_customer
    )
);
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
    $presmobic_favorites = $core->mobiexec172('presmobic_favorites', $favorite_product_array);
} elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
    $presmobic_favorites = $core->mobiexec17('presmobic_favorites', $favorite_product_array);
} else {
    $presmobic_favorites = $core->mobiexec('presmobic_favorites', $favorite_product_array);
}
if (is_array($presmobic_favorites)) {
    $id_product = $presmobic_favorites['favorites']['id_product'];
    $id_customer = $presmobic_favorites['favorites']['id_customer'];
}
if ($type == '0') {
    $select = "SELECT *FROM  " . _DB_PREFIX_ . "favorite_product WHERE id_product=".(int)$id_product."";
    $select .= " AND id_customer=".(int)$id_customer."";
    $select .= " AND id_shop=".(int)$id_shop."";
    $param = $db->Executes($select);
    if (empty($param)) {
        $sql = "REPLACE INTO " . _DB_PREFIX_ . "favorite_product";
        $sql .= " VALUES('','".(int)$id_product."','".(int)$id_customer."','".(int)$id_shop."',";
        $sql .= "'".pSQL($date_add)."','".pSQL($date_add)."')";
        $db->query($sql);
        $result =  array(
            'status'=>200,
            'typer' => 0,
            'messeger' =>$presmobileapp->l('Successfully added to Wishlist')
        );
    }
} else {
    $delete = "DELETE FROM  " . _DB_PREFIX_ . "favorite_product WHERE id_product=".(int)$id_product."";
    $delete .= " AND id_customer=".(int)$id_customer."";
    $delete .= " AND id_shop=".(int)$id_shop."";
    $db->query($delete);
    $result =  array(
            'status'=>200,
            'typer' => 1,
            'messeger' =>$presmobileapp->l('Successfully removed from Wishlist'),
        );
}
echo json_encode($result);
die;
