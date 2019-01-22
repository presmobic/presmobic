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
$comment_name = (string)Tools::getValue('comment_name');
$comment_descriprtion = (string)Tools::getValue('comment_descriprtion');
$rating_value = (string)Tools::getValue('rating_value');
$comment_customname = (string)Tools::getValue('comment_customname');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context = Context::getContext();
$date_add = date('Y-m-d H:i:s');
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$id_guest = $context->cart->id_guest;
$date_add = date('Y-m-d H:i:s');
$cart = $core->presMobicartresult();
$id_custommer = 0;
$comment = array(
    'comment' => array(
        'id_product' => $id_product,
        'comment_name' =>$comment_name,
        'comment_descriprtion' => $comment_descriprtion,
        'rating_value' =>$rating_value,
        'comment_customname' => $comment_customname
    )
);
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
    $presmobicSubmitComment = $core->mobiexec172('presmobicSubmitComment', array(), $comment);
} elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
    $presmobicSubmitComment = $core->mobiexec17('presmobicSubmitComment', array(), $comment);
} else {
    $presmobicSubmitComment = $core->mobiexec('presmobicSubmitComment', array(), $comment);
}
if (is_array($presmobicSubmitComment)) {
    $id_product = $presmobicSubmitComment['comment']['id_product'];
    $comment_name = $presmobicSubmitComment['comment']['comment_name'];
    $comment_descriprtion = $presmobicSubmitComment['comment']['comment_descriprtion'];
    $rating_value = $presmobicSubmitComment['comment']['rating_value'];
    $comment_customname = $presmobicSubmitComment['comment']['comment_customname'];
}
if ($cart['logged']) {
    $sql = "INSERT INTO " . _DB_PREFIX_ . "product_comment";
    $sql .= " VALUES('','".(int)$id_product."','".(int)$cart['id_customer']."',";
    $sql .= "'".(int)$id_guest."','".pSQL($comment_name)."',";
    $sql .= "'".pSQL($comment_descriprtion)."',";
    $sql .= "'".pSQL($cart['customerName'])."','".(int)$rating_value."',";
    $sql .= "'0','0','".pSQL($date_add)."')";
    $db->query($sql);
} else {
    $sql = "INSERT INTO " . _DB_PREFIX_ . "product_comment";
    $sql .= " VALUES('','".(int)$id_product."','0','".(int)$id_guest."',";
    $sql .= "'".pSQL($comment_name)."','".pSQL($comment_descriprtion)."',";
    $sql .= "'".pSQL($comment_customname)."','".(int)$rating_value."',";
    $sql .= "'0','0','".pSQL($date_add)."')";
    $db->query($sql);
}
$presmobileapp = new PresMobileApp();
$result = array(
    'status' =>200,
    'messeger' =>$presmobileapp->l('Successfully added to Comment'),
);
$context->cookie->checkcomment1 = date('H:i:s');
echo json_encode($result);
die;
