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
$wishlist = (string)Tools::getValue('wishlist');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context = Context::getContext();
$date_add = date('Y-m-d H:i:s');
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$newsletter_date_add = date('Y-m-d H:i:s');
$id_shop_group = Context::getContext()->shop->id_shop_group;
$token = Tools::strtoupper(Tools::substr(sha1(uniqid(rand(), true)._COOKIE_KEY_.$context->customer->id), 0, 16));
$addwishlist = array(
    'addwishlist' => array(
        'wishlist' => $wishlist,
        'token' =>$token
    )
);
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
    $presmobicBeforeAddNewWishlist = $core->mobiexec172('presmobicBeforeAddNewWishlist', array(), $addwishlist);
} elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
    $presmobicBeforeAddNewWishlist = $core->mobiexec172('presmobicBeforeAddNewWishlist', array(), $addwishlist);
} else {
    $presmobicBeforeAddNewWishlist = $core->mobiexec172('presmobicBeforeAddNewWishlist', array(), $addwishlist);
}
if (is_array($presmobicBeforeAddNewWishlist)) {
    $wishlist = $presmobicBeforeAddNewWishlist['addwishlist']['wishlist'];
    $token = $presmobicBeforeAddNewWishlist['addwishlist']['token'];
}
$sql = "INSERT INTO " . _DB_PREFIX_ . "wishlist ";
$sql .= " VALUES('','".(int)$context->customer->id."','".pSQL($token)."','".pSQL($wishlist)."',";
$sql .= "'','".(int)$id_shop."','".(int)$id_shop_group."','".pSQL($newsletter_date_add)."',";
$sql .= "'".pSQL($newsletter_date_add)."','0')";
$db->query($sql);
$presmobileapp = new PresMobileApp();
$result = array(
    'messenger'=>$presmobileapp->l('Add new Wishlist success.'),
    'status'=>200
);
echo json_encode($result);
die;
