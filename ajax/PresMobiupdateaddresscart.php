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
$mobi_token = Tools::getValue('token_pres');
$checktoken = $core->cookiekeymodule();
if ($mobi_token != $checktoken) {
    echo $core->transbv();
    die;
}
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context = Context::getContext();
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$id_address = Tools::getValue('id_address');
$type = Tools::getValue('type');
$use_address = Tools::getValue('use_address');
$check = Tools::getValue('check');
$cart_r = new Cart($context->cart->id);
$address_delivery = array();
$result = array();
if ($check == '1') {
    $id_address = Context::getContext()->cart->id_address_delivery;
    Context::getContext()->cart->id_address_invoice = $id_address;
    Context::getContext()->cart->update();
    $customer = new Customer($cart_r->id_customer);
    $customer_br = $customer->getAddresses($context->language->id);
    foreach ($customer_br as $key1 => $value1) {
        if ($id_address == $value1['id_address']) {
            $address_delivery[2] = array(
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
    $result[] = array(
        'status' =>200,
        'content' => $address_delivery,
        'type' => 3
    );
    echo json_encode($result);
    die;
} else {
    if ($use_address == '0') {
        Context::getContext()->cookie->{'useoneaddress'} = 0;
        if ($type == '2') {
            Context::getContext()->cart->id_address_invoice = $id_address;
            Context::getContext()->cart->update();
            $customer = new Customer($cart_r->id_customer);
            $customer_br = $customer->getAddresses($context->language->id);
            foreach ($customer_br as $key1 => $value1) {
                if ($id_address == $value1['id_address']) {
                    $address_delivery[2] = array(
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
            $result[] = array(
                'status' =>200,
                'content' => $address_delivery,
                'type' => 2
            );
            echo json_encode($result);
            die;
        }
        if ($type == '1') {
            Context::getContext()->cart->id_address_delivery = $id_address;
            Context::getContext()->cart->update();
            $customer = new Customer($cart_r->id_customer);
            $customer_br = $customer->getAddresses($context->language->id);
            foreach ($customer_br as $key1 => $value1) {
                if ($id_address == $value1['id_address']) {
                    $address_delivery[1] = array(
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
            $result[] = array(
                'status' =>200,
                'content' => $address_delivery,
                'type' => 1
            );
            echo json_encode($result);
            die;
        }
    }
    if ($use_address == '1') {
        Context::getContext()->cookie->{'useoneaddress'} = 1;
        Context::getContext()->cart->id_address_invoice = $id_address;
        Context::getContext()->cart->id_address_delivery = $id_address;
        Context::getContext()->cart->update();
        $customer = new Customer($cart_r->id_customer);
        $customer_br = $customer->getAddresses($context->language->id);
        foreach ($customer_br as $key1 => $value1) {
            if ($id_address == $value1['id_address']) {
                $address_delivery[1] = array(
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
        $result[] = array(
            'status' =>200,
            'content' => $address_delivery,
            'type' => 3
        );
        echo json_encode($result);
        die;
    }
}
