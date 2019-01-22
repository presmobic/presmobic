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
$email = (string)Tools::getValue('email');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context = Context::getContext();
$date_add = date('Y-m-d H:i:s');
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$newsletter_date_add = date('Y-m-d H:i:s');
$id_shop_group = Context::getContext()->shop->id_shop_group;
$email_arr = array();
$email = rtrim($email, ',');
$email_arr = explode(',', $email);
$sendwishlist = array(
    'sendwishlist' => array(
        'id_wishlist' => $id_wishlist,
        'email_arr' =>$email_arr
    )
);
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
    $presmobicBeforeSendWishlistById = $core->mobiexec172('presmobicBeforeSendWishlistById', array(), $sendwishlist);
} elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
    $presmobicBeforeSendWishlistById = $core->mobiexec172('presmobicBeforeSendWishlistById', array(), $sendwishlist);
} else {
    $presmobicBeforeSendWishlistById = $core->mobiexec172('presmobicBeforeSendWishlistById', array(), $sendwishlist);
}
if (is_array($presmobicBeforeSendWishlistById)) {
    $id_wishlist = $presmobicBeforeSendWishlistById['addwishlist']['id_wishlist'];
    $email_arr = $presmobicBeforeSendWishlistById['addwishlist']['email_arr'];
}
foreach ($email_arr as $key => $value) {
    $sql = "INSERT INTO " . _DB_PREFIX_ . "wishlist_email ";
    $sql .= " VALUES('".(int)$id_wishlist."','".pSQL($value)."','".pSQL($newsletter_date_add)."')";
    $db->query($sql);
}
$sql = "SELECT *FROM " . _DB_PREFIX_ . "wishlist ";
$sql .= "WHERE id_shop=".(int)$id_shop." AND id_shop_group=".(int)$id_shop_group." ";
$sql .= "AND id_wishlist=".(int)$id_wishlist."";
$wishlist = $db->Executes($sql);
foreach ($email_arr as $key => $value) {
    $tokena = array('token' => $wishlist[0]['token']);
    Mail::Send(
        $context->language->id,
        'wishlink',
        Mail::l('Your wishlist\'s link', $context->language->id),
        array(
            '{wishlist}' => $wishlist[0]['name'],
            '{message}' => $context->link->getModuleLink('blockwishlist', 'view', $tokena)
        ),
        $value,
        $context->customer->firstname.' '.$context->customer->lastname,
        $context->customer->email,
        (string)Configuration::get('PS_SHOP_NAME'),
        null,
        null,
        _PS_MODULE_DIR_.'/blockwishlist/mails/'
    );
}
$presmobileapp = new PresMobileApp();
$result = array(
    'messenger'=>$presmobileapp->l('Send Wishlist success.'),
    'status'=>200
);
echo json_encode($result);
die;
