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
$id_product = (int)Tools::getValue('id_product');
$use_email = (string)Tools::getValue('use_name');
$use_pass = (string)Tools::getValue('use_pass');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context=Context::getContext();
$attribute = null;
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$sql = "SELECT *FROM " . _DB_PREFIX_ . "customer";
$sql .= " WHERE email='".pSQL($use_email)."'";
$paarm = $db->Executes($sql);
if (empty($paarm)) {
    $result = array(
        'status' => 401,
        'messenger'=> $presmobileapp->l('Authentication failed.')
    );
    echo json_encode($result);
    die;
} else {
    if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=')) {
        $check = 0;
        $abcd = $Crypto->checkHash($use_pass, $paarm[0]['passwd']);
        if ($abcd === true) {
            $check = 1;
        }
        $passwd =md5(_COOKIE_KEY_.$use_pass);
        if ($passwd  == $paarm[0]['passwd']) {
            $check = 1;
        }
    } else {
        $passwd = Tools::encrypt($use_pass);
        $sql = "SELECT *FROM " . _DB_PREFIX_ . "customer";
        $sql .= " WHERE email='".pSQL($use_email)."'";
        $sql .= " AND passwd='".pSQL($passwd)."'";
        $paarm = $db->Executes($sql);
        if (empty($paarm)) {
            $check = 0;
        } else {
            $check = 1;
        }
    }
}
$login = array(
    'login' => array(
        'use_email' => $use_email,
        'use_pass' =>$use_pass
    )
);
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
    $presmobicBeforeSubmitLogin = $core->mobiexec172('presmobicBeforeSubmitLogin', array(), $login);
} elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
    $presmobicBeforeSubmitLogin = $core->mobiexec17('presmobicBeforeSubmitLogin', array(), $login);
} else {
    $presmobicBeforeSubmitLogin = $core->mobiexec('presmobicBeforeSubmitLogin', array(), $login);
}
if (is_array($presmobicBeforeSubmitLogin)) {
    $use_email = $presmobicBeforeSubmitLogin['login']['use_email'];
    $use_pass = $presmobicBeforeSubmitLogin['login']['use_pass'];
}
if ($check == 1) {
    $id_customer = $paarm[0]['id_customer'];
    $customer = new Customer($id_customer);
    Context::getContext()->cookie->id_compare = 0;
    Context::getContext()->cookie->id_customer = (int) ($customer->id);
    Context::getContext()->cookie->customer_lastname  = $customer->lastname;
    Context::getContext()->cookie->customer_firstname = $customer->firstname;
    Context::getContext()->cookie->logged = 1;
    $customer->logged = 1;
    Context::getContext()->cookie->is_guest = $customer->isGuest();
    Context::getContext()->cookie->passwd = $customer->passwd;
    Context::getContext()->cookie->email = $customer->email;
    $customer = new Customer($id_customer);
    $customer_br = $customer->getAddresses($context->language->id);
    $check_address = 0;
    if (!empty($customer_br)) {
        Context::getContext()->cart->id_address_delivery = $customer_br[0]['id_address'];
        Context::getContext()->cart->id_address_invoice = $customer_br[0]['id_address'];
        Context::getContext()->cart->update();
        $check_address = 1;
    } else {
        Context::getContext()->cart->id_address_delivery = 0;
        Context::getContext()->cart->id_address_invoice = 0;
        Context::getContext()->cart->update();
    }
    $result = array(
        'status' => 200,
        'messenger'=>$presmobileapp->l('Login Succsses.'),
        'address' =>$check_address,
    );
    echo json_encode($result);
    die;
} else {
    $result = array(
        'status' => 401,
        'messenger'=> $presmobileapp->l('Authentication failed.')
    );
    echo json_encode($result);
    die;
}
