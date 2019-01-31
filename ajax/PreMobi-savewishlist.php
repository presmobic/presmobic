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
$quantity = (int)Tools::getValue('quantity');
$privoty = (string)Tools::getValue('privoty');
$id_wishlist_product = Tools::getValue('id_wishlist_product');
$type = Tools::getValue('type');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context = Context::getContext();
$date_add = date('Y-m-d H:i:s');
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$newsletter_date_add = date('Y-m-d H:i:s');
$id_shop_group = Context::getContext()->shop->id_shop_group;
if ($type == '1') {
    $uppr = array(
        'updateishlistproduct' => array(
            'quantity' => $quantity,
            'privoty' =>$privoty,
            'id_wishlist_product' =>$id_wishlist_product
        )
    );
    if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
        $presmobicBeforeSaveWishlistById = $core->mobiexec172('presmobicBeforeSaveWishlistById', $uppr);
    } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
        $presmobicBeforeSaveWishlistById = $core->mobiexec172('presmobicBeforeSaveWishlistById', $uppr);
    } else {
        $presmobicBeforeSaveWishlistById = $core->mobiexec172('presmobicBeforeSaveWishlistById', $uppr);
    }
    if (is_array($presmobicBeforeSaveWishlistById)) {
        $quantity = $presmobicBeforeSaveWishlistById['updateishlistproduct']['quantity'];
        $privoty = $presmobicBeforeSaveWishlistById['updateishlistproduct']['privoty'];
        $id_wishlist_product = $presmobicBeforeSaveWishlistById['updateishlistproduct']['id_wishlist_product'];
    }
    $sql = "UPDATE " . _DB_PREFIX_ . "wishlist_product SET quantity=".(int)$quantity.",";
    $sql .= "priority=".(int)$privoty."";
    $sql .= " WHERE id_wishlist_product=".(int)$id_wishlist_product."";
    $db->query($sql);
} else {
    $deletep = array(
        'deletewishlistpr' => array(
            'quantity' => $quantity,
            'privoty' =>$privoty,
            'id_wishlist_product' =>$id_wishlist_product
        )
    );
    if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
        $presmobicBeforeDeleteWishlistById = $core->mobiexec172('presmobicBeforeDeleteWishlistById', $deletep);
    } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
        $presmobicBeforeDeleteWishlistById = $core->mobiexec172('presmobicBeforeDeleteWishlistById', $deletep);
    } else {
        $presmobicBeforeDeleteWishlistById = $core->mobiexec172('presmobicBeforeDeleteWishlistById', $deletep);
    }
    if (is_array($presmobicBeforeDeleteWishlistById)) {
        $quantity = $presmobicBeforeDeleteWishlistById['deletewishlistpr']['quantity'];
        $privoty = $presmobicBeforeDeleteWishlistById['deletewishlistpr']['privoty'];
        $id_wishlist_product = $presmobicBeforeDeleteWishlistById['deletewishlistpr']['id_wishlist_product'];
    }
    $sql = "DELETE FROM " . _DB_PREFIX_ . "wishlist_product";
    $sql .= " WHERE id_wishlist_product=".(int)$id_wishlist_product."";
    $db->query($sql);
}
$presmobileapp = new PresMobileApp();
$result = array(
    'messenger'=>$presmobileapp->l('Update Wishlist success.'),
    'status'=>200
);
echo json_encode($result);
die;
