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
$id_cart_rule = (int)Tools::getValue('id_cart_rule');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$url_fodel = _PS_MODULE_DIR_;
$context = Context::getContext();
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
if (!$context->cart->id) {
    if ($context->cookie->id_guest) {
        $guest                       = new Guest($context->cookie->id_guest);
        $context->cart->mobile_theme = $guest->mobile_theme;
    }
    $context->cart->add();
    if ($context->cart->id) {
        $context->cookie->id_cart = (int) $context->cart->id;
    }
}
$context->cart->removeCartRule($id_cart_rule);
$context->cart->update();
$cart = $core->presMobicartresult();
$product = $context->cart->getProducts();
$cartrule = $context->cart->getCartRules();
$ba_cart = array();
if (!empty($product)) {
    $id_product = '';
    $price_shipping = 0;
    $price =(float)0;
    foreach ($product as $key => $value) {
        $id_product .= $value['id_product'].',';
        $price += (float)$value['total'];
    }
    $ba_cart[0]['price_product'] = Tools::displayPrice($price);
    $price_shipping = (float)$context->cart->getOrderTotal(false, Cart::ONLY_SHIPPING);
    if ($price_shipping == 0) {
        $price_shipping == 'Free';
    } else {
        $price_shipping = Tools::displayPrice($price_shipping);
    }
    $ba_cart[0]['price_shipping'] = $price_shipping;
    $ba_cart[0]['totalprice'] = Tools::displayPrice($context->cart->getOrderTotal());
    $discount_new = array();
    if (!empty($cartrule)) {
        foreach ($cartrule as $key_d => $value_d) {
            $discount_new[$key_d]['id'] = $value_d['id_cart_rule'];
            $discount_new[$key_d]['code'] = $value_d['code'];
            if ($value_d['reduction_percent'] != '0.00') {
                $discount_new[$key_d]['price'] = (float)$value_d['reduction_percent'].'%';
            }
            if ($value_d['reduction_amount'] != '0.00') {
                $discount_new[$key_d]['price'] = Tools::displayPrice($value_d['reduction_amount']);
            }
            $discount_new[$key_d]['total_price'] = Tools::displayPrice($value_d['value_tax_exc']);
        }
    }
    $ba_cart[0]['coupon'] = $discount_new;
}
echo json_encode($ba_cart);
die;
