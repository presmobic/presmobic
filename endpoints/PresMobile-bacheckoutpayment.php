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

//tích hợp thư viện
class Bacheckoutpayment extends PresMobileApp
{
    public function __construct()
    {
    }
    public function start($arg)
    {
        $arg;
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $url_fodel = _PS_MODULE_DIR_;
        $controller = 'checkoutpayment';
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $id_lang = $context->language->id;
        $price_order = $context->cookie->price_order;
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $payment_method = Module::getPaymentModules();
        $list_payment = '';
        foreach ($payment_method as $key => $value) {
            $key;
            $an = Hook::exec('displayPayment', array(), $value['id_module']);
            $list_payment .= '<div class="presmobi-payment">'.$an.'</div>';
        }
        $part = __PS_BASE_URI__;
        $cart_r = new Cart($context->cart->id);
        $cart_checkout = array();
        $delivery_option_list = $context->cart->getDeliveryOptionList();
        $result = array();
        $count_shipping = 0;
        $price_shipping = 0;
        $ad = '';
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=')) {
            $abc = new PaymentOptionsFinder();
            $ad = $abc->present();
        }
        if (!empty($delivery_option_list)) {
            foreach ($delivery_option_list as $key_dol1 => $value_dol1) {
                $key_dol1;
                foreach ($value_dol1 as $key_dol => $value_dol) {
                    $count_shipping++;
                    $ar_carrier_name = array();
                    $sql_carrier_name = 'SELECT delay FROM ' . _DB_PREFIX_ . 'carrier_lang ';
                    $sql_carrier_name .= 'WHERE id_shop=\''.(int)$id_shop.'\' AND id_lang=\''.(int)$id_lang.'\'';
                    $sql_carrier_name .= ' AND id_carrier IN('.pSQL(rtrim($key_dol, ',')).')';
                    $data_carrier_name = $db->ExecuteS($sql_carrier_name);
                    if (!empty($data_carrier_name)) {
                        foreach ($data_carrier_name as $key_dcn => $value_dcn) {
                            $key_dcn;
                            $ar_carrier_name[] = $value_dcn['delay'];
                        }
                    }
                    $carrier_name = implode(', ', $ar_carrier_name);
                    if ($value_dol['is_free'] == '1') {
                        $carrier_name .= ' ' . $this->l('(Free shipping!)');
                    }
                    $result[$key_dol]['carrier_name'] = $carrier_name;
                    $result[$key_dol]['total_price_with_tax'] = $value_dol['total_price_with_tax'];
                    $result[$key_dol]['total_price_without_tax'] = $value_dol['total_price_without_tax'];
                    if ($count_shipping == '1') {
                        $price_shipping = $result[$key_dol]['total_price_without_tax'];
                    }
                    $aa = (float)$value_dol['total_price_with_tax'];
                    $ab = (float)$value_dol['total_price_without_tax'];
                    $result[$key_dol]['total_shipping_tax'] = $aa - $ab;
                    $result[$key_dol]['is_free'] = $value_dol['is_free'];
                }
            }
        }
        if (!empty($result)) {
            foreach ($result as $key_s => $value_s) {
                $result[$key_s]['total_price_r'] =  Tools::displayPrice($value_s['total_price_without_tax']);
                $price_shipping = $result[$context->cart->id_carrier.',']['total_price_without_tax'];
            }
        }
        $cart_checkout[0]['shipping'] = $result;
        $quantity = 0;
        $product = $cart_r->getProducts();
        foreach ($product as $key1 => $value1) {
            $quantity += $value1['cart_quantity'];
        }
        $cart_checkout[0]['quantity'] = $quantity;
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
        $cart_checkout[0]['discount_new'] = $discount_new;
        $payment_method = Module::getPaymentModules();
        $base_total_tax_inc = $cart_r->getOrderTotal(true);
        $base_total_tax_exc = $cart_r->getOrderTotal(false);
        $total_tax = $base_total_tax_inc - $base_total_tax_exc;
        if ($total_tax < 0) {
            $total_tax = 0;
        }
        $cart_checkout[0]['price_tax'] = Tools::displayPrice($total_tax);
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $id_product = '';
        $price_product = 0;
        foreach ($product as $key => $value) {
            $id_product .= $value['id_product'].',';
            $price_product += $value['total'];
        }
        $id_product = rtrim($id_product, ',');
        $sql_where_product_acc = " AND p.`id_product` IN (".pSQL($id_product).")";
        $product_acce = $core->presMobigetProduct($id_shop, $id_lang, $sql_where_product_acc, '', 'LIMIT 0,1000', 2);
        foreach ($product_acce as $key1 => $value1) {
            $product[$key1]['price_discount'] = Tools::displayPrice($value1['price_without_reduction']);
            $product[$key1]['price_total'] = Tools::displayPrice($value1['price_tax_exc']);
            $product[$key1]['specific_prices'] = Tools::displayPrice($value1['specific_prices']);
        }
        $cart_checkout[0]['product'] = $product;
        $cart_checkout[0]['total_product'] = Tools::displayPrice($price_product);
        $total_price = $price_shipping+$price_product+$total_tax+$price_coupon;
        $cart_checkout[0]['total_shipping'] = Tools::displayPrice($price_shipping);
        $cart_checkout[0]['total_tax'] = Tools::displayPrice($total_tax);
        $cart_checkout[0]['total_price'] = Tools::displayPrice($total_price);
        $cart_checkout[0]['payment'] = $payment_method;
        $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=14";
            $db_meta = $db->Executes($sql_meta);
            $batitle = $shop_name;
        } else {
            $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=21";
            $db_meta = $db->Executes($sql_meta);
            $batitle = $db_meta[0]['title'].' - '.$shop_name;
        }
        $this->resertController('index');
        $_GET['controller'] = 'order';
        $d = Dispatcher::getInstance();
        $d->controller = 'order';
        $display_jsdef = Media::getJsDef();
        $install_stripe_official = Module::isInstalled("stripe_official");
        $context->smarty->assign('is_free', $context->cart->getOrderTotal(true, Cart::BOTH));
        $context->smarty->assign('payment_options', $ad);
        $context->smarty->assign('install_stripe_official', $install_stripe_official);
        $context->smarty->assign('version_mobi', _PS_VERSION_);
        $context->smarty->assign('list_payment', $list_payment);
        $context->smarty->assign('cart_checkout', $cart_checkout);
        $context->smarty->assign('baseDir', $url);
        $context->smarty->assign('display_jsdef', $display_jsdef);
        $context->smarty->assign('selected_payment_option', null);
        $context->smarty->assign("price_order", $price_order);
        $context->smarty->assign("URL", $part);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/checkout/payment.tpl';
        $content =  $context->smarty->fetch($a);
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'chir' =>'Checkout',
            'batitle' => $batitle,
            'description' => strip_tags($db_meta[0]['description'])
        );
        echo json_encode($result);
        die;
    }
    public function resertController($controller)
    {
        $url_fodel = _PS_MODULE_DIR_;

        require_once($url_fodel.'presmobileapp/includes/Presmobic-badispatcher.php');

        $badispatcher = new BaDispatcher();

        $badispatcher->controller = $controller;

        DispatcherCore::$instance = $badispatcher;
    }
}
