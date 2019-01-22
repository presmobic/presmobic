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
$context = Context::getContext();
$presmobileapp = new PresMobileApp();
$cart = $core->presMobicartresult();
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$email = Tools::getValue('email');
$billing = Tools::getValue('billing');
$id_address_update = Tools::getValue('id_address');
$delivery_first_name = Tools::getValue('first_name');
$delivery_last_name = Tools::getValue('last_name');
$delivery_company = Tools::getValue('company');
$delivery_address_1 = Tools::getValue('address_1');
$delivery_address_2 = Tools::getValue('address_2');
$delivery_city = Tools::getValue('city');
$delivery_idsates = Tools::getValue('idsates');
$delivery_zip_postal = Tools::getValue('postal');
$delivery_idcountry = Tools::getValue('idcountry');
$homephone = Tools::getValue('homephone');
$mobilephone = Tools::getValue('mobilephone');
$alias = Tools::getValue('alias');
$additional_info = Tools::getValue('additional-info');
$bill_country = new Country($delivery_idcountry);
if (!$bill_country->checkZipCode($delivery_zip_postal)) {
    $result = array(
        'error' => 'zipcode',
        'status' => 401,
        'messenger'=>$presmobileapp->l('The Zip/Postal code you\'ve entered is invalid.'),
    );
    echo json_encode($result);
    die;
}
if ($email != false) {
    $sql = "SELECT *FROM " . _DB_PREFIX_ . "customer WHERE email='" . pSQL($email) . "'";
    $sql .= " AND is_guest=0";
    $param = $db->ExecuteS($sql);
    if (!empty($param)) {
        $result = array(
            'error' => 'email',
            'status' => 401,
            'messenger'=>$presmobileapp->l('An account using this email address has already been registered.'),
        );
        echo json_encode($result);
        die;
    }
}

$updateaddre = array(
    'updateaddress' => array(
        'email' => $email,
        'billing' =>$billing,
        'id_address_update' => $id_address_update,
        'delivery_first_name' =>$delivery_first_name,
        'delivery_last_name' => $delivery_last_name,
        'delivery_company' =>$delivery_company,
        'delivery_address_1' => $delivery_address_1,
        'delivery_address_2' =>$delivery_address_2,
        'delivery_city' => $delivery_city,
        'delivery_idsates' =>$delivery_idsates,
        'delivery_zip_postal' => $delivery_zip_postal,
        'delivery_idcountry' =>$delivery_idcountry,
        'homephone' =>$homephone,
        'mobilephone' =>$mobilephone,
        'alias' =>$alias,
        'additional_info' =>$additional_info
    )
);
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
    $presmobicBeforeSubmitAddAddress = $core->mobiexec172('presmobicBeforeSubmitAddAddress', array(), $updateaddre);
} elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
    $presmobicBeforeSubmitAddAddress = $core->mobiexec172('presmobicBeforeSubmitAddAddress', array(), $updateaddre);
} else {
    $presmobicBeforeSubmitAddAddress = $core->mobiexec172('presmobicBeforeSubmitAddAddress', array(), $updateaddre);
}
if (is_array($presmobicBeforeSubmitAddAddress)) {
    $email = $presmobicBeforeSubmitAddAddress['updateaddress']['email'];
    $billing = $presmobicBeforeSubmitAddAddress['updateaddress']['billing'];
    $id_address_update = $presmobicBeforeSubmitAddAddress['updateaddress']['id_address_update'];
    $delivery_first_name = $presmobicBeforeSubmitAddAddress['updateaddress']['delivery_first_name'];
    $delivery_last_name = $presmobicBeforeSubmitAddAddress['updateaddress']['delivery_last_name'];
    $delivery_company = $presmobicBeforeSubmitAddAddress['updateaddress']['delivery_company'];
    $delivery_address_1 = $presmobicBeforeSubmitAddAddress['updateaddress']['delivery_address_1'];
    $delivery_address_2 = $presmobicBeforeSubmitAddAddress['updateaddress']['delivery_address_2'];
    $delivery_city = $presmobicBeforeSubmitAddAddress['updateaddress']['delivery_city'];
    $delivery_idsates = $presmobicBeforeSubmitAddAddress['updateaddress']['delivery_idsates'];
    $delivery_zip_postal = $presmobicBeforeSubmitAddAddress['updateaddress']['delivery_zip_postal'];
    $delivery_idcountry = $presmobicBeforeSubmitAddAddress['updateaddress']['delivery_idcountry'];
    $homephone = $presmobicBeforeSubmitAddAddress['updateaddress']['homephone'];
    $mobilephone = $presmobicBeforeSubmitAddAddress['updateaddress']['mobilephone'];
    $alias = $presmobicBeforeSubmitAddAddress['updateaddress']['alias'];
    $additional_info = $presmobicBeforeSubmitAddAddress['updateaddress']['additional_info'];
}
$active              = 1;
$id_risk             = 0;
$id_shop_group       = Context::getContext()->shop->id_shop_group;
$newsletter_date_add = date('Y-m-d H:i:s');
$last_passwd_gen     = date('Y-m-d H:i:s', strtotime('-' . Configuration::get('PS_PASSWD_TIME_FRONT') . 'minutes'));
$id_default_group    = 2;
$date_add            = date('Y-m-d H:i:s');
$secure_key          = md5(uniqid(rand(), true));
$passwd = Tools::passwdGen();
$birthday = '';
if ($cart['logged'] == '1' || Context::getContext()->cart->id_customer != '0') {
    $id_customer = $cart['id_customer'];
} else {
    $sql_get  = "INSERT INTO " . _DB_PREFIX_ . "customer";
    $sql_get  .= "(id_shop_group,id_shop,id_default_group,id_lang,id_risk,firstname,lastname,";
    $sql_get  .= "email,passwd,last_passwd_gen,birthday,newsletter_date_add,secure_key,";
    $sql_get  .= "active,date_add,date_upd,max_payment_days,is_guest)";
    $sql_get  .= " VALUES ('" . (int) $id_shop_group . "','" . (int) $id_shop . "',";
    $sql_get  .= "'" . (int) $id_default_group . "','" . (int) $id_lang . "',";
    $sql_get  .= "'" . (int) $id_risk . "','" . pSQL($delivery_first_name) . "',";
    $sql_get  .= "'" . pSQL($delivery_last_name) . "', '" . pSQL($email) . "',";
    $sql_get  .= "'" . pSQL(Tools::encrypt($passwd)) . "','" . pSQL($last_passwd_gen) . "',";
    $sql_get  .= "'" . pSQL($birthday) . "','" . pSQL($newsletter_date_add) . "',";
    $sql_get  .= "'" . pSQL($secure_key) . "','" . (int) $active . "',";
    $sql_get  .= "'" . pSQL($date_add) . "','" . pSQL($date_add) . "','0','1')";
    $db->query($sql_get);
    $id_customer = $db->Insert_ID();
    $customer_group = "INSERT INTO " . _DB_PREFIX_ . "customer_group VALUES('".(int)$id_customer."','2')";
    $db->query($customer_group);
    Context::getContext()->cart->id_customer = $id_customer;
    $sql_get_max_idguest = 'select max(id_guest) from ' . _DB_PREFIX_ . 'guest';
    $id_guest_max = $db->Executes($sql_get_max_idguest);
    $id_guest_new = (int)($id_guest_max[0]['max(id_guest)']) + 1;
    $guest = new Guest();
    $guest->setNewGuest(Context::getContext()->cookie);
    Context::getContext()->cart->id_guest = $id_guest_new;
    $customer = new Customer($id_customer);
    Context::getContext()->cookie->id_customer = (int) ($customer->id);
    Context::getContext()->cookie->customer_lastname  = $customer->lastname;
    Context::getContext()->cookie->customer_firstname = $customer->firstname;
    Context::getContext()->cookie->logged = 1;
    $customer->logged = 1;
    Context::getContext()->cookie->is_guest = $customer->isGuest();
    Context::getContext()->cookie->passwd = $customer->passwd;
    Context::getContext()->cookie->email = $customer->email;
    Context::getContext()->customer = $customer;
    Context::getContext()->customer->update();
    $sql_deli = "INSERT INTO " . _DB_PREFIX_ . "address";
    $sql_deli .= "(id_country,id_state,id_customer,alias,company,lastname,firstname,";
    $sql_deli .= "address1,address2,postcode,city,phone,phone_mobile,date_add,";
    $sql_deli .= "date_upd,active,deleted,other)";
    $sql_deli .= " VALUES('".(int)$delivery_idcountry."','".(int)$delivery_idsates."',";
    $sql_deli .= "'".(int)$id_customer."','".pSQL($alias)."',";
    $sql_deli .= "'".pSQL($delivery_company)."','".pSQL($delivery_last_name)."',";
    $sql_deli .= "'".pSQL($delivery_first_name)."','".pSQL($delivery_address_1)."',";
    $sql_deli .= "'".pSQL($delivery_address_2)."','".pSQL($delivery_zip_postal)."',";
    $sql_deli .= "'".pSQL($delivery_city)."','".(int)$homephone."','".(int)$mobilephone."',";
    $sql_deli .= "'".pSQL($date_add)."','".pSQL($date_add)."',";
    $sql_deli .= "'1','0','".pSQL($additional_info)."')";
    $db->query($sql_deli);
    $id_address = $db->Insert_ID();
    Context::getContext()->cart->id_address_delivery = $id_address;
    Context::getContext()->cart->id_address_invoice = $id_address;
    $sql = "UPDATE " . _DB_PREFIX_ . "cart_product SET id_address_delivery=".(int) $id_address."";
    $sql .= " WHERE id_shop=".(int)$id_shop." AND id_cart=".(int)Context::getContext()->cart->id."";
    $db->query($sql);
}
if ($id_address_update == '0' && $email == false) {
    $sql_deli = "INSERT INTO " . _DB_PREFIX_ . "address";
    $sql_deli .= "(id_country,id_state,id_customer,alias,company,lastname,firstname,";
    $sql_deli .= "address1,address2,postcode,city,phone,phone_mobile,date_add,date_upd,";
    $sql_deli .= "active,deleted,other)";
    $sql_deli .= " VALUES('".(int)$delivery_idcountry."','".(int)$delivery_idsates."',";
    $sql_deli .= "'".(int)$id_customer."','".pSQL($alias)."','".pSQL($delivery_company)."',";
    $sql_deli .= "'".pSQL($delivery_last_name)."','".pSQL($delivery_first_name)."',";
    $sql_deli .= "'".pSQL($delivery_address_1)."','".pSQL($delivery_address_2)."',";
    $sql_deli .= "'".pSQL($delivery_zip_postal)."','".pSQL($delivery_city)."',";
    $sql_deli .= "'".(int)$homephone."','".(int)$mobilephone."','".pSQL($date_add)."',";
    $sql_deli .= "'".pSQL($date_add)."','1','0','".pSQL($additional_info)."')";
    $db->query($sql_deli);
}
if ($id_address_update > '0') {
    $sql = "UPDATE " . _DB_PREFIX_ . "address";
    $sql .= " SET id_country='".(int)$delivery_idcountry."',";
    $sql .= "id_state='".(int)$delivery_idsates."',";
    $sql .= "id_customer='".(int)$id_customer."',";
    $sql .= "alias='".pSQL($alias)."',";
    $sql .= "company='".pSQL($delivery_company)."',";
    $sql .= "lastname='".pSQL($delivery_last_name)."',";
    $sql .= "firstname='".pSQL($delivery_first_name)."',";
    $sql .= "address1='".pSQL($delivery_address_1)."',";
    $sql .= "address2='".pSQL($delivery_address_2)."',";
    $sql .= "postcode='".pSQL($delivery_zip_postal)."',";
    $sql .= "city='".pSQL($delivery_city)."',";
    $sql .= "phone='".(int)$homephone."',";
    $sql .= "other='".pSQL($additional_info)."',";
    $sql .= "phone_mobile='".(int)$mobilephone."',";
    $sql .= "date_upd='".pSQL($date_add)."'";
    $sql .= " WHERE id_address=".(int)$id_address_update."";
    $db->query($sql);
}
Context::getContext()->cart->update();
include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
$core = new BaCore();
$cart = $core->presMobicartresult();
$result = array(
    'status' => 200,
    'batitle' =>$presmobileapp->l('address'),
    'messenger'=>$presmobileapp->l('Add a new address success.')
);
echo json_encode($result);
die;
