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
$id_carrier = (int)Tools::getValue('id_carrier');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$url_fodel = _PS_MODULE_DIR_;
$context = Context::getContext();
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$cart_r = new Cart($context->cart->id);
$delivery_option_list = $context->cart->getDeliveryOptionList();
$id_delivery = $context->cart->id_address_delivery;
$count_shipping = 0;
$price_shipping = 0;
$result = array();
if (!empty($delivery_option_list)) {
    foreach ($delivery_option_list as $key_dol1 => $value_dol1) {
        foreach ($value_dol1 as $key_dol => $value_dol) {
            $count_shipping++;
            $ar_carrier_name = array();
            $sql_carrier_name = 'SELECT delay FROM ' . _DB_PREFIX_ . 'carrier_lang';
            $sql_carrier_name .= ' WHERE id_shop=\''.(int)$id_shop.'\'';
            $sql_carrier_name .= ' AND id_lang=\''.(int)$id_lang.'\'';
            $sql_carrier_name .= ' AND id_carrier IN('.pSQL(rtrim($key_dol, ',')).')';
            $data_carrier_name = $db->ExecuteS($sql_carrier_name);
            if (!empty($data_carrier_name)) {
                foreach ($data_carrier_name as $key_dcn => $value_dcn) {
                    $ar_carrier_name[] = $value_dcn['delay'];
                }
            }
            $carrier_name = implode(', ', $ar_carrier_name);
            if ($value_dol['is_free'] == '1') {
                $carrier_name .= ' ' . $presmobileapp->l('(Free shipping!)');
            } else {
                $ae = $value_dol['total_price_without_tax'];
                $carrier_name .= ' (' . Tools::displayPrice($ae) . ') ';
            }
            $result[$key_dol]['carrier_name'] = $carrier_name;
            $ad = $value_dol['total_price_with_tax'];
            $result[$key_dol]['total_price_with_tax'] = $ad;
            $ac = $value_dol['total_price_without_tax'];
            $result[$key_dol]['total_price_without_tax'] = $ac;
            $aa = (float)$value_dol['total_price_with_tax'];
            $ab = (float)$value_dol['total_price_without_tax'];
            $result[$key_dol]['total_shipping_tax'] = $aa - $ab;
            $result[$key_dol]['is_free'] = $value_dol['is_free'];
        }
    }
}
$id_carrier_tr = $id_carrier.',';
$price_shipping = $result[$id_carrier_tr]['total_price_without_tax'];

$discount = $cart_r->getCartRules();
$discount_new = array();
$price_coupon = 0;
if (!empty($discount)) {
    foreach ($discount as $key_d => $value_d) {
        $discount_new[$key_d]['code'] = $value_d['code'];
        if ($value_d['reduction_percent'] != '0.00') {
            $discount_new[$key_d]['price'] = (float)$value_d['reduction_percent'].'%';
        }
        if ($value_d['reduction_amount'] != '0.00') {
            $discount_new[$key_d]['price'] = Tools::displayPrice($value_d['reduction_amount']);
        }
        $price_coupon += $value_d['value_tax_exc'];
        $discount_new[$key_d]['total_price'] = Tools::displayPrice($value_d['value_tax_exc']);
    }
}
$key = '' . $id_carrier . '';
foreach ($delivery_option_list as $id_address => $options) {
    if (isset($options[$key])) {
        $context->cart->setDeliveryOption(array(
            $id_address => $key
        ));
        if (isset($context->cookie->id_country)) {
            unset($context->cookie->id_country);
        }
        if (isset($context->cookie->id_state)) {
            unset($context->cookie->id_state);
        }
    }
}
$context->cart->update();
$base_total_tax_inc = $context->cart->getOrderTotal(true);
$base_total_tax_exc = $context->cart->getOrderTotal(false);
$total_tax = $base_total_tax_inc - $base_total_tax_exc;
if ($total_tax < 0) {
    $total_tax = 0;
}
$id_product = '';
$price_product = 0;
$product = $cart_r->getProducts();
foreach ($product as $key => $value) {
    $id_product .= $value['id_product'].',';
    $price_product += $value['total'];
}
$ba_cart = array();
$order_total = $price_product+$total_tax+$price_coupon+$price_shipping;
$ba_cart['price_product'] = Tools::displayPrice($price_product);
$ba_cart['price_shipping'] = Tools::displayPrice($price_shipping);
$ba_cart['total_tax'] = Tools::displayPrice($total_tax);
$ba_cart['order_total'] = Tools::displayPrice($order_total);
$context->cookie->{'price_order'} = Tools::displayPrice($order_total);
echo json_encode($ba_cart);
die;
