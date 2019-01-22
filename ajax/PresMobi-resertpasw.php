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
$email = (string)Tools::getValue('email');
$sql = "SELECT *FROM " . _DB_PREFIX_ . "customer";
$sql .= " WHERE email='".pSQL($email)."'";
$paarm = $db->Executes($sql);
if (!empty($paarm)) {
    $customer = new Customer();
    $customer->getByemail($email);
    $url = $core->getMobiBaseLink();
    $mail_params = array(
        '{email}' => $customer->email,
        '{lastname}' => $customer->lastname,
        '{firstname}' => $customer->firstname,
        '{url}' => ''.$url.'/#forgotpassword:'.$customer->secure_key.':'.$customer->id.''
    );
    $id_lang = Context::getContext()->language->id;
    $aa = $customer->email;
    $ab = $customer->firstname;
    $ac = $customer->lastname;
    $ad = Mail::l('Password query confirmation');
    if (Mail::Send($id_lang, 'password_query', $ad, $mail_params, $aa, $ab . ' ' . $ac)) {
        Context::getContext()->smarty->assign(array('confirmation' => 2, 'customer_email' => $customer->email));
    }
    $presmobileapp = new PresMobileApp();
    $result = array(
        'status' => 200,
        'messenger'=> $presmobileapp->l('A confirmation email has been sent to your address: '.$email.''),
    );
} else {
    $result = array(
        'status' => 401,
        'messenger'=>$presmobileapp->l('There is no account registered for this email address.'),
    );
}
echo json_encode($result);
die;
