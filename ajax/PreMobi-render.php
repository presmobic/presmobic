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
$id_address = (int)Tools::getValue('id_address');
$date_add = date('Y-m-d H:i:s');
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$cart_r = new Cart($context->cart->id);
$customer = new Customer($cart_r->id_customer);
$customer_br = $customer->getAddresses($context->language->id);
$id_country = $context->country->id;
$coutry = Country::getCountries($id_lang, true);
$address_delivery = array();
$alias = array();
foreach ($customer_br as $key1 => $value1) {
    $alias[$value1['id_address']] = $value1['alias'];
    if ($id_address == $value1['id_address']) {
        $address_delivery[0] = array(
            'id_address' => $value1['id_address'],
            'alias' => $value1['alias'],
            'company' => $value1['company'],
            'lastname' => $value1['lastname'],
            'firstname' => $value1['firstname'],
            'address1' => $value1['address1'],
            'address2' => $value1['address2'],
            'postcode' => $value1['postcode'],
            'city' => $value1['city'],
            'other' => $value1['other'],
            'phone' => $value1['phone'],
            'phone_mobile' => $value1['phone_mobile'],
            'vat_number' => $value1['vat_number'],
            'country' => $value1['country'],
            'state' => $value1['state']
        );
    }
}
$arrayName = array();
$array = array();
foreach ($coutry as $key => $value) {
    $arrayName[$value["id_country"]] = array('value' => $value["iso_code"], 'name' => $value["name"]);
    $query = "SELECT *FROM " . _DB_PREFIX_ . "state WHERE id_country='" . $value["id_country"] . "' ";
    $params = $db->ExecuteS($query);
    foreach ($params as $key1 => $value1) {
        $a = $value["id_country"];
        $b = $value1["id_state"];
        $array[$a][$b] = array('value' => $value1["iso_code"], 'name' => $value1["name"]);
    }
}
$localtion = array('countries' => $arrayName, 'states' => $array);
$id_customer = $cart_r->id_customer;
$url = $core->getMobiBaseLink();
$context->smarty->assign("delivery", $address_delivery);
$context->smarty->assign("localtion", $localtion);
$context->smarty->assign("id_address", $id_address);
$context->smarty->assign("id_country_default", $id_country);
$context->smarty->assign("id_customer", $id_customer);
$a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/block/address.tpl';
$content =  $context->smarty->fetch($a);
echo $content;
die;
