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
$url_fodel = _PS_MODULE_DIR_;
$context = Context::getContext();
$id_shop = $context->shop->id;
$email = (string)Tools::getValue('email');
$ip_registration = Tools::getRemoteAddr();
$date_add = date('Y-m-d H:i:s');
$presmobileapp = new PresMobileApp();
if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
    $sql_checkmail = "SELECT *FROM "._DB_PREFIX_."emailsubscription WHERE email= '".pSQL($email)."'";
    $checkmail = $db->ExecuteS($sql_checkmail);
    if (empty($checkmail)) {
        $sql = "INSERT INTO "._DB_PREFIX_."emailsubscription";
        $sql .= " (id_shop, id_shop_group, email, newsletter_date_add, ip_registration_newsletter,";
        $sql .= "http_referer, active) VALUES ('".(int)$id_shop."','".(int)$id_shop."',";
        $sql .= "'".pSQL($email)."','".pSQL($date_add)."','".pSQL($ip_registration)."','','1')";
        $db->query($sql);
    } else {
        $result = array(
            'status' => 401,
            'messenger'=>$presmobileapp->l('This email address is already registered.'),
        );
        echo json_encode($result);
        die;
    }
} else {
    $sql_checkmail = "SELECT *FROM "._DB_PREFIX_."newsletter WHERE email= '".pSQL($email)."'";
    $checkmail = $db->ExecuteS($sql_checkmail);
    if (empty($checkmail)) {
        $sql = "INSERT INTO "._DB_PREFIX_."newsletter";
        $sql .= " (id_shop, id_shop_group, email, newsletter_date_add,";
        $sql .= "ip_registration_newsletter, http_referer, active)";
        $sql .= " VALUES ('".(int)$id_shop."','".(int)$id_shop."','".pSQL($email)."',";
        $sql .= "'".pSQL($date_add)."','".pSQL($ip_registration)."','','1')";
        $db->query($sql);
    } else {
        $result = array(
            'status' => 401,
            'messenger'=>$presmobileapp->l('This email address is already registered.'),
        );
        echo json_encode($result);
        die;
    }
}
$result = array(
        'status' => 200,
        'messenger'=>$presmobileapp->l('You have successfully subscribed to this newsletter.'),
    );
echo json_encode($result);
die;
