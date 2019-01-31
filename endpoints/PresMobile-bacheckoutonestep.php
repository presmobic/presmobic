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

class BacheckoutOneStep extends PresMobileApp
{
    public function __construct()
    {
    }
    public function start($arg)
    {
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $controller = 'checkoutonestep';
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $id_shop = $context->shop->id;
        $id_country = $context->country->id;
        $coutry = Country::getCountries($id_lang, true);
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $cart_r = $core->presMobicartresult();
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $delivery = array();
        $id_address = 0;
        $cart = $this->presMobiCart();
        $addresses = $this->presMobiGetAddresses();
        $shipping = $this->presMobiGetShipping();
        $payment = $this->presMobiGetPayment();
        if ($context->cart->id_carrier == '0') {
            if (!empty($shipping)) {
                foreach ($shipping as $key => $value) {
                    $context->cart->id_carrier = str_replace(',', '', $key);
                    break;
                }
            }
        }
        $context->cart->update();
        if (!empty($arg[0])) {
            $id_address = $arg[0];
            $query_dely = "SELECT *FROM " . _DB_PREFIX_ . "address WHERE id_address='" . (int)$arg[0]. "' ";
            $address_delivery = $db->ExecuteS($query_dely);
            foreach ($address_delivery as $key => $value) {
                $delivery[$key]['id_address_delivery'] = $value['id_address'];
                $delivery[$key]['alias'] = $value['alias'];
                $delivery[$key]['company'] = $value['company'];
                $delivery[$key]['lastname'] = $value['lastname'];
                $delivery[$key]['firstname'] = $value['firstname'];
                $delivery[$key]['address1'] = $value['address1'];
                $delivery[$key]['address2'] = $value['address2'];
                $delivery[$key]['postcode'] = $value['postcode'];
                $delivery[$key]['city'] = $value['city'];
                $delivery[$key]['phone'] = $value['phone'];
                $delivery[$key]['phone_mobile'] = $value['phone_mobile'];
                $delivery[$key]['id_country'] = $value['id_country'];
                $delivery[$key]['id_state'] = $value['id_state'];
            }
        } else {
            $delivery[0]['id_address_delivery'] = '';
            $delivery[0]['alias'] = '';
            $delivery[0]['company'] = '';
            $delivery[0]['lastname'] = '';
            $delivery[0]['firstname'] = '';
            $delivery[0]['address1'] = '';
            $delivery[0]['address2'] = '';
            $delivery[0]['postcode'] = '';
            $delivery[0]['city'] = '';
            $delivery[0]['phone'] = '';
            $delivery[0]['phone_mobile'] = '';
            $delivery[0]['id_country'] = 0;
            $delivery[0]['id_state'] = 0;
        }
        $arrayName = array();
        foreach ($coutry as $key => $value) {
            $arrayName[$value["id_country"]] = array('value' => $value["iso_code"], 'name' => $value["name"]);
            $query = "SELECT *FROM " . _DB_PREFIX_ . "state WHERE id_country='" . (int)$value["id_country"] . "' ";
            $params = $db->ExecuteS($query);
            $array = array();
            if (empty($params)) {
                foreach ($params as $key1 => $value1) {
                    $key1;
                    $abf = array('value' => $value1["iso_code"], 'name' => $value1["name"]);
                    $array[$value["id_country"]][$value1["id_state"]] = $abf;
                }
            }
        }
        $localtion = array('countries' => $arrayName, 'states' => $array);
        $id_customer = $cart_r['id_customer'];
        $cart_r_t = new Cart($context->cart->id);
        $customer_r = new Customer($cart_r_t->id_customer);
        $customer_bs = $customer_r->getAddresses($context->language->id);
        $check_address = 0;
        if (!empty($customer_bs)) {
            $check_address = 1;
        }
        $lists_currency = Currency::getCurrencies();
        $lists_currency;
        $code_currency_default = $context->currency->iso_code;
        $code_currency_default;
        $id_currency_default = $context->currency->id;
        $infor_currency = Currency::getCurrency($id_currency_default);
        $minium_price1 = Configuration::get('PS_PURCHASE_MINIMUM');
        $conversion_rate = $infor_currency['conversion_rate'];
        $minium_price = $conversion_rate * $minium_price1;
        $price_check = Tools::displayPrice($minium_price);
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
        $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=24";
        $db_meta = $db->Executes($sql_meta);
        $checkterm  = Configuration::get('PS_CONDITIONS');
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $hook_displayBeforeCarrier = $core->mobiexec172('displayBeforeCarrier', array());
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $hook_displayBeforeCarrier = $core->mobiexec17('displayBeforeCarrier', array());
        } else {
            $hook_displayBeforeCarrier = $core->mobiexec('displayBeforeCarrier', array());
        }
        $context->smarty->assign("hook_displayBeforeCarrier", $hook_displayBeforeCarrier);
        $context->smarty->assign("checkterm", $checkterm);
        $context->smarty->assign("check_address", $check_address);
        $context->smarty->assign("minium_price", $minium_price);
        $context->smarty->assign("price_check", $price_check);
        $context->smarty->assign("id_carrier", $context->cart->id_carrier.',');
        $context->smarty->assign("cart_r", $cart_r);
        $context->smarty->assign("delivery", $delivery);
        $context->smarty->assign("localtion", $localtion);
        $context->smarty->assign("id_address", $id_address);
        $context->smarty->assign("id_country_default", $id_country);
        $context->smarty->assign("id_customer", $id_customer);
        $context->smarty->assign('cart', $cart);
        $context->smarty->assign('list_payment', $payment);
        $context->smarty->assign('addresses', $addresses);
        $context->smarty->assign('shipping', $shipping);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/checkoutonestep/checkoutonestep.tpl';
        $content =  $context->smarty->fetch($a);
        $presmobileapp = new PresMobileApp();
        $result = array(
        'controller' => $controller,
        'content' => $content,
        'chir' =>$presmobileapp->l('Checkout'),
        'batitle' =>$db_meta[0]['title'].'-'.$shop_name,
        'description' => strip_tags($db_meta[0]['description'])
        );
        echo json_encode($result);
        die;
    }
    public function presMobiCart()
    {
        $context = Context::getContext();
        $url_fodel = _PS_MODULE_DIR_;
        $url_fodel;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $url;
        $id_lang = $context->language->id;
        $id_shop = $context->shop->id;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $cart = $core->presMobicartresult();
        $cart;
        $product = $context->cart->getProducts();
        $cartrule = $context->cart->getCartRules();
        $cart_r = new Cart($context->cart->id);
        $customer = new Customer($cart_r->id_customer);
        $customer_br = $customer->getAddresses($context->language->id);
        $check_address = 0;
        $check_address;
        if (!empty($customer_br)) {
            $check_address = 1;
        }
        $count_product = 0;
        $count_product;
        $ba_cart = array();
        if (!empty($product)) {
            $ba_cart[0]['count_product'] = count($product);
            $id_product = '';
            $price_shipping = 0;
            $price =(float)0;
            foreach ($product as $key => $value) {
                $key;
                $id_product .= $value['id_product'].',';
                $price += (float)$value['total'];
            }
            $ba_cart[0]['price_product_check'] = $price;
            $ba_cart[0]['price_product'] = Tools::displayPrice($price);
            $price_shipping = (float)$context->cart->getOrderTotal(false, Cart::ONLY_SHIPPING);
            if ($price_shipping == 0) {
                $price_shipping = 'Free';
            } else {
                $price_shipping = Tools::displayPrice($price_shipping);
            }
            $ba_cart[0]['price_shipping'] = $price_shipping;
            $ba_cart[0]['totalprice'] = Tools::displayPrice($context->cart->getOrderTotal());
            $id_product = rtrim($id_product, ',');
            $sql_where_product = " AND p.`id_product` IN (".pSQL($id_product).")";
            $sql_sort_category = '';
            $abc = $sql_where_product;
            $abd = $sql_sort_category;
            $product_r = $core->presMobigetProduct($id_shop, $id_lang, $abc, $abd, 'LIMIT 0,1000', 2);
            foreach ($product_r as $key1 => $value1) {
                $product[$key1]['price_discount'] = Tools::displayPrice($value1['price_without_reduction']);
                $product[$key1]['price_total'] = Tools::displayPrice($value1['price_tax_exc']);
                $bc = $value1['link_rewrite'];
                $bb = $value1['id_product'];
                $product[$key1]['link_img'] = $this->getlinkimageproduct($bc, $bb);
                $product[$key1]['specific_prices'] = $value1['specific_prices'];
            }
            $ba_cart[0]['product'] = $product;
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
            $base_total_tax_inc = $cart_r->getOrderTotal(true);
            $base_total_tax_exc = $cart_r->getOrderTotal(false);
            $total_tax = $base_total_tax_inc - $base_total_tax_exc;
            if ($total_tax < 0) {
                $total_tax = 0;
            }
            $ba_cart[0]['price_tax'] = Tools::displayPrice($total_tax);
            $ba_cart[0]['coupon'] = $discount_new;
        }
        return $ba_cart;
    }
    public function getlinkimageproduct($link_rew, $id_product)
    {
        $linkimages = new Link();
        $image = Product::getCover((int)$id_product);
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $type_img = ImageType::getFormattedName('presmobic');
        } else {
            $type_img = ImageType::getFormatedName('presmobic');
        }
        $link_img = Tools::getShopProtocol() . $linkimages->getImageLink($link_rew, $image['id_image'], $type_img);
        return $link_img;
    }
    public function presMobiGetAddresses()
    {
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $core;
        $context = Context::getContext();
        $cart_r = new Cart($context->cart->id);
        $customer = new Customer($cart_r->id_customer);
        $customer_br = $customer->getAddresses($context->language->id);
        $alias = array();
        $result = array();
        $address_delivery = array();
        $address_invoice = array();
        foreach ($customer_br as $key1 => $value1) {
            $key1;
            $alias[$value1['id_address']] = $value1['alias'];
            if ($cart_r->id_address_delivery == $value1['id_address']) {
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
            if ($cart_r->id_address_invoice == $value1['id_address']) {
                $address_invoice[0] = array(
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
        $result[0]['alias'] = $alias;
        $result[0]['address_delivery'] = $address_delivery;
        $result[0]['address_invoice'] = $address_invoice;
        return $result;
    }
    public function presMobiGetShipping()
    {
        $context = Context::getContext();
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $id_shop = $context->shop->id;
        $id_lang = $context->language->id;
        $delivery_option_list = $context->cart->getDeliveryOptionList();
        $result = array();
        $count_shipping = 0;
        $count_shipping;
        $price_shipping = 0;
        $price_shipping;
        if (!empty($delivery_option_list)) {
            foreach ($delivery_option_list as $key_f => $value_f) {
                $key_f;
                foreach ($value_f as $key_dol => $value_dol) {
                    $count_shipping++;
                    $ar_carrier_name = array();
                    $sql_carrier_name = 'SELECT delay FROM ' . _DB_PREFIX_ . 'carrier_lang';
                    $sql_carrier_name .= ' WHERE id_shop=\''.(int)$id_shop.'\'';
                    $sql_carrier_name .= ' AND id_lang=\''.(int)$id_lang.'\'';
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
            }
        }
        if ($context->cart->id_carrier == 0) {
            if (!empty($result)) {
                foreach ($result as $key_s => $value_s) {
                    $key_s;
                    $context->cart->id_carrier =  rtrim($key_s, ',');
                    break;
                }
            }
            $context->cart->update();
        }
        return $result;
    }
    public function presMobiGetPayment()
    {
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $url;
        $payment_method = Module::getPaymentModules();
        $list_payment = '';
        foreach ($payment_method as $key => $value) {
            $key;
            $af = Hook::exec('displayPayment', array(), $value['id_module']);
            $list_payment .= '<div class="presmobi-payment">'.$af.'</div>';
        }
        return $list_payment;
    }
}
