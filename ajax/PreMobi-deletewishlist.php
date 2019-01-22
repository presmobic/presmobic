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
$id_wishlist = (int)Tools::getValue('id_wishlist');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context = Context::getContext();
$date_add = date('Y-m-d H:i:s');
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$newsletter_date_add = date('Y-m-d H:i:s');
$id_shop_group = Context::getContext()->shop->id_shop_group;
$token = Tools::strtoupper(Tools::substr(sha1(uniqid(rand(), true)._COOKIE_KEY_.$context->customer->id), 0, 16));
$cart_r = $core->presMobicartresult();
$deletewishlist = array(
    'deletewishlist' => array(
        'id_wishlist' => $id_wishlist
    )
);
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
    $presmobicBeforeDeleteWishlist = $core->mobiexec172('presmobicBeforeDeleteWishlist', array(), $deletewishlist);
} elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
    $presmobicBeforeDeleteWishlist = $core->mobiexec172('presmobicBeforeDeleteWishlist', array(), $deletewishlist);
} else {
    $presmobicBeforeDeleteWishlist = $core->mobiexec172('presmobicBeforeDeleteWishlist', array(), $deletewishlist);
}
if (is_array($presmobicBeforeDeleteWishlist)) {
    $id_wishlist = $presmobicBeforeDeleteWishlist['deletewishlist']['id_wishlist'];
}
$sql2 = "SELECT *FROM " . _DB_PREFIX_ . "wishlist ";
$sql2 .= "WHERE id_shop=".(int)$id_shop." AND id_shop_group=".(int)$id_shop_group." ";
$sql2 .= "AND id_wishlist=".(int)$id_wishlist."";
$wishlist = $db->Executes($sql2);
if ($wishlist[0]['default'] == '1') {
    $sql3 = "SELECT *FROM " . _DB_PREFIX_ . "wishlist ";
    $sql3 .= "WHERE id_shop=".(int)$id_shop." AND id_shop_group=".(int)$id_shop_group." ";
    $sql3 .= "AND id_customer=".(int)$cart_r['id_customer']."";
    $wishlist_t = $db->Executes($sql3);
    $count_wishlist = count($wishlist_t);
    if ($count_wishlist >=2) {
        $ab = $wishlist_t[$count_wishlist-1]['id_wishlist'];
        $sql = "UPDATE "._DB_PREFIX_."wishlist SET `default`=1 WHERE id_wishlist=".(int)$ab."";
        $db->query($sql);
    }
}
$sql = "DELETE FROM "._DB_PREFIX_."wishlist WHERE id_wishlist=".(int)$id_wishlist."";
$sql1 = "DELETE FROM "._DB_PREFIX_."wishlist_product WHERE id_wishlist=".(int)$id_wishlist."";
$db->query($sql);
$db->query($sql1);
$presmobileapp = new PresMobileApp();
$result = array(
    'messenger'=>$presmobileapp->l('Delete Wishlist success.'),
    'status'=>200
);
echo json_encode($result);
die;
