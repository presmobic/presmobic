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
$presmobileapp = new PresMobileApp();
$newslettersigin = Tools::getValue('newslettersigin');
if (empty($newslettersigin)) {
    $newslettersigin = 0;
}
$ip_registration = Tools::getValue('ip_registration');
if ($ip_registration == '1') {
    $ip_registration = Tools::getRemoteAddr();
} else {
    $ip_registration = '';
}
$id_gender = Tools::getValue('id_gender');
$companyname = Tools::getValue('companyname');
$siret = Tools::getValue('siret');
if (!empty($siret)) {
    $sireta = Validate::isSiret($siret);
    if ($sireta  == true) {
        $siret = Tools::getValue('siret');
    } else {
        $result = array(
            'status'=>401,
            'messeger' =>$presmobileapp->l('Siret is invalid.')
        );
        echo json_encode($result);
        return false;
    }
}
$ape = Tools::getValue('ape');
if (!empty($ape)) {
    $ape1 = Validate::isApe($ape);
    if ($ape1  == true) {
        $ape = Tools::getValue('ape');
    } else {
        $result = array(
            'status'=>401,
            'messeger' =>$presmobileapp->l('Ape is invalid.')
        );
        echo json_encode($result);
        return false;
    }
}
$website = Tools::getValue('website');
$years = Tools::getValue('years');
$months = Tools::getValue('months');
$days = Tools::getValue('days');
$firstname = Tools::getValue('first-name');
$email = Tools::getValue('email');
$lastname = Tools::getValue('last-name');
$passwd = Tools::getValue('password');
$passwdzxc = Tools::strlen($passwd);
if ($passwdzxc < 5 || $passwdzxc >250) {
    $result = array(
            'status'=>401,
            'messeger' =>$presmobileapp->l('Passwd is invalid.')
        );
    echo json_encode($result);
    return false;
}
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=')) {
    $passwd =md5(_COOKIE_KEY_.$passwd);
} else {
    $passwd = Tools::encrypt($passwd);
}
$confirm_password = Tools::getValue('confirm-password');
$context = Context::getContext();
$id_lang = $context->language->id;
$id_shop = $context->shop->id;
$active              = 1;
$id_risk             = 0;
$id_shop_group       = Context::getContext()->shop->id_shop_group;
$newsletter_date_add = date('Y-m-d H:i:s');
$last_passwd_gen     = date('Y-m-d H:i:s', strtotime('-' . Configuration::get('PS_PASSWD_TIME_FRONT') . 'minutes'));
$id_default_group    = (int) Configuration::get('PS_CUSTOMER_GROUP');
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
$date_add            = date('Y-m-d H:i:s');
$secure_key          = md5(uniqid(rand(), true));
$db                  = Db::getInstance(_PS_USE_SQL_SLAVE_);
$sql                 = "SELECT *FROM " . _DB_PREFIX_ . "customer WHERE email='" . pSQL($email) . "'";
$param               = $db->ExecuteS($sql);
if (!empty($param)) {
    $result = array(
        'messeger'=>$presmobileapp->l('An account using this email address has already been registered.'),
        'status'=>401
    );
} else {
    $signup = array(
        'signup' => array(
            'newslettersigin' => $newslettersigin,
            'ip_registration' =>$ip_registration,
            'id_gender' => $id_gender,
            'companyname' => $companyname,
            'website' => $website,
            'years' => $years,
            'months' => $months,
            'days' =>$days,
            'firstname' => $firstname,
            'email' =>$email,
            'lastname' => $lastname
        )
    );
    if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
        $presmobicBeforeSubmitSignUp = $core->mobiexec172('presmobicBeforeSubmitSignUp', array(), $signup);
    } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
        $presmobicBeforeSubmitSignUp = $core->mobiexec17('presmobicBeforeSubmitSignUp', array(), $signup);
    } else {
        $presmobicBeforeSubmitSignUp = $core->mobiexec('presmobicBeforeSubmitSignUp', array(), $signup);
    }
    if (is_array($presmobicBeforeSubmitSignUp)) {
        $newslettersigin = $presmobicBeforeSubmitSignUp['signup']['newslettersigin'];
        $ip_registration = $presmobicBeforeSubmitSignUp['signup']['ip_registration'];
        $id_gender = $presmobicBeforeSubmitSignUp['signup']['id_gender'];
        $companyname = $presmobicBeforeSubmitSignUp['signup']['companyname'];
        $website = $presmobicBeforeSubmitSignUp['signup']['website'];
        $years = $presmobicBeforeSubmitSignUp['signup']['years'];
        $months = $presmobicBeforeSubmitSignUp['signup']['months'];
        $days = $presmobicBeforeSubmitSignUp['signup']['days'];
        $firstname = $presmobicBeforeSubmitSignUp['signup']['firstname'];
        $email = $presmobicBeforeSubmitSignUp['signup']['email'];
        $lastname = $presmobicBeforeSubmitSignUp['signup']['lastname'];
    }
    $sql_get = "INSERT INTO " . _DB_PREFIX_ . "customer";
    $sql_get .= "(id_shop_group,id_shop,id_gender,id_default_group,id_lang,id_risk,";
    $sql_get .= "company,siret,ape,website,firstname,lastname,email,passwd,";
    $sql_get .= "last_passwd_gen,birthday,newsletter,ip_registration_newsletter,";
    $sql_get .= "newsletter_date_add,secure_key,active,date_add,date_upd)";
    $sql_get .= " VALUES ('" . (int) $id_shop_group . "','" . (int) $id_shop . "',";
    $sql_get .= " '" . (int) $id_gender . "','" . (int) $id_default_group . "',";
    $sql_get .= "'" . (int) $id_lang . "','" . (int) $id_risk . "','" . pSQL($companyname) . "',";
    $sql_get .= "'" . pSQL($siret) . "','" . pSQL($ape) . "','" . pSQL($website) . "',";
    $sql_get .= "'" . pSQL($firstname) . "', '" . pSQL($lastname) . "', '" . pSQL($email) . "',";
    $sql_get .= "'" . pSQL($passwd) . "','" . pSQL($last_passwd_gen) . "',";
    $sql_get .= "'" . pSQL($birthday) . "','" . (int)$newslettersigin . "',";
    $sql_get .= "'" . pSQL($ip_registration) . "','" . pSQL($newsletter_date_add) . "',";
    $sql_get .= "'" . pSQL($secure_key) . "','" . (int) $active . "',";
    $sql_get .= "'" . pSQL($date_add) . "','" . pSQL($date_add) . "') ";
    $info_cus = $db->query($sql_get);
    $id_customer = $db->Insert_ID();
    $query1 = "INSERT INTO " . _DB_PREFIX_ . "customer_group(id_customer,id_group)";
    $query1 .= " VALUES('" . (int) $id_customer . "','" . (int) $id_default_group . "')";
    $db->query($query1);
    $customer = new Customer($id_customer);
    Context::getContext()->cookie->id_customer = (int) ($customer->id);
    Context::getContext()->cookie->customer_lastname  = $customer->lastname;
    Context::getContext()->cookie->customer_firstname = $customer->firstname;
    Context::getContext()->cookie->logged = 1;
    $customer->logged = 1;
    Context::getContext()->cookie->is_guest = $customer->isGuest();
    Context::getContext()->cookie->passwd = $customer->passwd;
    Context::getContext()->cookie->email = $customer->email;
    $shop_name = Configuration::get('PS_SHOP_NAME');
    $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
    $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta =18";
    $db_meta = $db->Executes($sql_meta);
    $result = array(
        'messeger'=>$presmobileapp->l('Registration complete'),
        'batitle' => $db_meta[0]['title'].' - '.$shop_name,
        'status'=>200
    );
}
echo json_encode($result);
die;
