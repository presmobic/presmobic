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
$presmobileapp = new PresMobileApp();
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=')) {
    $Crypto = new PrestaShop\PrestaShop\Core\Crypto\Hashing;
}
$company = (string)Tools::getValue('profilecompany');
$siret = (string)Tools::getValue('profilesiret');
if (!empty($siret)) {
    $sireta = Validate::isSiret($siret);
    if ($sireta  == true) {
        $siret = Tools::getValue('profilesiret');
    } else {
        $result = array(
            'status'=>401,
            'messeger' =>$presmobileapp->l('Siret is invalid.')
        );
        echo json_encode($result);
        return false;
    }
}
$ape = (string)Tools::getValue('profileape');
if (!empty($ape)) {
    $ape1 = Validate::isApe($ape);
    if ($ape1  == true) {
        $ape = Tools::getValue('profileape');
    } else {
        $result = array(
            'status'=>401,
            'messeger' =>$presmobileapp->l('Ape is invalid.')
        );
        echo json_encode($result);
        return false;
    }
}
$profileweb = (string)Tools::getValue('profileweb');
$newslettersigin = (string)Tools::getValue('newslettersigin');
if (empty($newslettersigin)) {
    $newslettersigin = 0;
}
$ip_registration = (string)Tools::getValue('ip_registration');
if ($ip_registration == '1') {
    $ip_registration = Tools::getRemoteAddr();
} else {
    $ip_registration = '';
}
$id_gender = (int)Tools::getValue('id_gender');
$years = Tools::getValue('years');
$months = Tools::getValue('months');
$days = Tools::getValue('days');
$passwd_current = Tools::getValue('profile-current-password');
$fisrtname = Tools::getValue('profile-first-name');
$lastname = Tools::getValue('profile-last-name');
$email = Tools::getValue('profile-email');
$passwd = Tools::getValue('profile-new-password');
$passwdzxc = Tools::strlen($passwd);
if (!empty($passwdzxc)) {
    if ($passwdzxc < 5 || $passwdzxc >250) {
        $result = array(
            'status'=>401,
            'messeger' =>$presmobileapp->l('Passwd is invalid.')
        );
        echo json_encode($result);
        return false;
    }
}
$cart = $core->presMobicartresult();
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context=Context::getContext();
$attribute = null;
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$date_upd = date('Y-m-d H:i:s');
$date_arr = array("0"=>$years,"1"=>$months,"2"=>$days);
$checkdate = 0;
foreach ($date_arr as $key => $value) {
    if ($checkdate == 0) {
        if (empty($value)) {
            $checkdate = 1;
        } else {
            $checkdate = 0;
        }
    }
}
if ($years == false && $months == false && $days == false) {
    $checkdate = 0;
}
if ($checkdate == 1) {
    $result = array(
                'status'=>401,
                'messeger' =>$presmobileapp->l('Invalid date of birth.')
            );
    echo json_encode($result);
    return false;
} else {
    $birthday = "".$years."-".$months."-".$days."";
}
$sql = "SELECT *FROM " . _DB_PREFIX_ . "customer ";
$sql .= " WHERE id_customer NOT IN (".(int)$cart['id_customer'].")";
$sql .= " AND id_shop=".(int)$id_shop." AND id_shop=".(int)$id_lang."";
$param = $db->Executes($sql);
$sql1 = "SELECT *FROM " . _DB_PREFIX_ . "customer ";
$sql1 .= " WHERE email ='".pSQL($email)."'";
$sql1 .= " AND id_shop=".(int)$id_shop."";
$param_passwd = $db->Executes($sql1);
$pass_customer = $param_passwd[0]['passwd'];
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=')) {
    $abcd = $Crypto->checkHash($passwd_current, $pass_customer);
    if ($abcd === false) {
        $result = array(
            'status'=>401,
            'messeger' =>$presmobileapp->l('The password you entered is incorrect.')
        );
        echo json_encode($result);
        return false;
    }
    $passwd =md5(_COOKIE_KEY_.$passwd);
} else {
    $passwd = Tools::encrypt($passwd);
    $passwd_current = Tools::encrypt($passwd_current);
    if ($pass_customer != $passwd_current) {
        $result = array(
                    'status'=>401,
                    'messeger' =>$presmobileapp->l('The password you entered is incorrect.')
                );
        echo json_encode($result);
        return false;
    }
}
if (!empty($param)) {
    foreach ($param as $key => $value) {
        if ($email == $value['email']) {
            $result = array(
                'status'=>401,
                'messeger' =>$presmobileapp->l('An account using this email address has already been registered.')
            );
            echo json_encode($result);
            die();
        }
    }
}
$check = 0;
if ($passwd == '') {
    $check = 1;
    $sql = "UPDATE " . _DB_PREFIX_ . "customer ";
    $sql .= " SET firstname='".pSQL($fisrtname)."',";
    $sql .= "id_gender='".pSQL($id_gender)."',";
    $sql .= "birthday='".pSQL($birthday)."',";
    $sql .= "lastname='".pSQL($lastname)."',";
    $sql .= "email='".pSQL($email)."',";
    $sql .= "company='".pSQL($company)."',";
    $sql .= "siret='".pSQL($siret)."',";
    $sql .= "ape='".pSQL($ape)."',";
    $sql .= "website='".pSQL($profileweb)."',";
    $sql .= "newsletter='".pSQL($newslettersigin)."',";
    $sql .= "ip_registration_newsletter='".pSQL($ip_registration)."',";
    $sql .= "date_upd='".pSQL($date_upd)."'";
    $sql .= " WHERE id_customer=".(int)$cart['id_customer']."";
    $sql .= " AND id_shop=".(int)$id_shop." AND id_shop=".(int)$id_lang."";
    $db->query($sql);
} else {
    $check = 1;
    $sql = "UPDATE " . _DB_PREFIX_ . "customer ";
    $sql .= " SET firstname='".pSQL($fisrtname)."',";
    $sql .= "id_gender='".pSQL($id_gender)."',";
    $sql .= "birthday='".pSQL($birthday)."',";
    $sql .= "lastname='".pSQL($lastname)."',";
    $sql .= "email='".pSQL($email)."',";
    $sql .= "company='".pSQL($company)."',";
    $sql .= "siret='".pSQL($siret)."',";
    $sql .= "ape='".pSQL($ape)."',";
    $sql .= "website='".pSQL($profileweb)."',";
    $sql .= "newsletter='".pSQL($newslettersigin)."',";
    $sql .= "ip_registration_newsletter='".pSQL($ip_registration)."',";
    $sql .= "passwd='".pSQL($passwd)."',";
    $sql .= "date_upd='".pSQL($date_upd)."'";
    $sql .= " WHERE id_customer=".(int)$cart['id_customer']."";
    $sql .= " AND id_shop=".(int)$id_shop." AND id_shop=".(int)$id_lang."";
    $db->query($sql);
}
if ($check = 1) {
    $result = array(
        'status'=>200,
        'messeger' =>$presmobileapp->l('Your personal information has been successfully updated.')
    );
    $customer = new Customer($cart['id_customer']);
    Context::getContext()->cookie->id_customer = (int) ($customer->id);
    Context::getContext()->cookie->customer_lastname  = $customer->lastname;
    Context::getContext()->cookie->customer_firstname = $customer->firstname;
    Context::getContext()->cookie->logged = 1;
    $customer->logged = 1;
    Context::getContext()->cookie->is_guest = $customer->isGuest();
    Context::getContext()->cookie->passwd = $customer->passwd;
    Context::getContext()->cookie->email = $customer->email;
}
echo json_encode($result);
die;
