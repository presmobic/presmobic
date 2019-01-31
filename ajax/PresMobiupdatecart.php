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
$id_product = Tools::getValue('id_product');
$id_attr = Tools::getValue('id_attr');
$type = Tools::getValue('type');
$quantity = Tools::getValue('quantity');
$discount = Tools::getValue('discount');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context = Context::getContext();
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$presmobileapp = new PresMobileApp();
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
$badiscount = array(
    'coupon' => array(
        'discount' => $discount
    )
);
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
    $presmobicBeforeCartSubmitCoupon = $core->mobiexec172('presmobicBeforeCartSubmitCoupon', $badiscount);
} elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
    $presmobicBeforeCartSubmitCoupon = $core->mobiexec17('presmobicBeforeCartSubmitCoupon', $badiscount);
} else {
    $presmobicBeforeCartSubmitCoupon = $core->mobiexec('presmobicBeforeCartSubmitCoupon', $badiscount);
}
if (is_array($presmobicBeforeCartSubmitCoupon)) {
    $discount = $presmobicBeforeCartSubmitCoupon['favorites']['discount'];
}
if ($type == '3') {
    $cartRule = new CartRule(CartRule::getIdByCode($discount));
    $cartrule_va = Validate::isLoadedObject($cartRule);
    $error = $cartRule->checkValidity($context, false, true);
    if ($cartRule && $cartrule_va == '1') {
        if ($error) {
            $result = array(
                'status' =>401,
                'messenger' => $error
            );
            echo json_encode($result);
            die;
        } else {
            $context->cart->addCartRule($cartRule->id);
        }
    } else {
        $result = array(
            'status' =>401,
            'messenger' => $presmobileapp->l('Sorry, Coupon not exist.'),
        );
        echo json_encode($result);
        die;
    }
}
if ($type == '1') {
    $abc = StockAvailable::getQuantityAvailableByProduct($id_product, $id_attr);
    if ($abc < $quantity) {
        $result = array(
            'status'=>401,
            'messenger' =>$presmobileapp->l("There isn't enough product in stock"),
        );
        echo json_encode($result);
        die;
    }
    $updateQuantity = $context->cart->updateQty((int)($quantity), (int)($id_product), (int)($id_attr), null, 'up');
}
if ($type == '2') {
    $abc = StockAvailable::getQuantityAvailableByProduct($id_product, $id_attr);
    if ($abc < $quantity) {
        $result = array(
            'status'=>401,
            'messenger' =>$presmobileapp->l("There isn't enough product in stock"),
        );
        echo json_encode($result);
        die;
    }
    $updateQuantity = $context->cart->updateQty((int)($quantity), (int)($id_product), (int)($id_attr), null, 'down');
}
if ($type == '4') {
    $abc = StockAvailable::getQuantityAvailableByProduct($id_product, $id_attr);
    if ($abc < $quantity) {
        $result = array(
            'status'=>401,
            'messenger' =>$presmobileapp->l("There isn't enough product in stock"),
        );
        echo json_encode($result);
        die;
    }
    $sql = "SELECT *FROM ". _DB_PREFIX_ ."cart_product WHERE id_product=".(int)$id_product."";
    $sql .= " AND id_product_attribute=".(int)$id_attr."";
    $sql .= " AND id_shop=".(int)$id_shop."";
    $sql .= " AND id_cart=".(int)$context->cart->id."";
    $result = $db->Executes($sql);
    if ($result[0]['quantity'] != $quantity) {
        if ($result[0]['quantity'] < $quantity) {
            $qty = $quantity - $result[0]['quantity'];
            $updateQuantity = $context->cart->updateQty((int)($qty), (int)($id_product), (int)($id_attr), null, 'up');
        } else {
            $qty = $result[0]['quantity'] - $quantity;
            $updateQuantity = $context->cart->updateQty((int)($qty), (int)($id_product), (int)($id_attr), null, 'down');
        }
    }
}
$context->cart->update();
$cart = $core->presMobicartresult();
$product = $context->cart->getProducts();
$cartrule = $context->cart->getCartRules();
$ba_cart = array();
if (!empty($product)) {
    $id_product = '';
    $price_shipping = 0;
    $price =(float)0;
    $cart_quantity = 0;
    foreach ($product as $key => $value) {
        $id_product .= $value['id_product'].',';
        $price += (float)$value['total'];
        $cart_quantity += $value['cart_quantity'];
    }
    $ba_cart[0]['cart_quantity'] = $cart_quantity;
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
