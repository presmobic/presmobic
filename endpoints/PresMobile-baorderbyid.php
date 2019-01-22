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

class BaOrderById extends PresMobileApp
{
    public function __construct()
    {
        parent::__construct();
    }
    public function start($arg)
    {
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $presmobileapp = new PresMobileApp();
        $controller ='orderbyid';
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $url_fodel = _PS_MODULE_DIR_;
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $id_shop = $context->shop->id;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        include_once($url_fodel.'presmobileapp/configs/defines.inc.php');
        $core = new BaCore();
        $check_cache = $core->presMobicheckcache($controller.':'.$arg[0]);
        $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
        $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=16";
        $db_meta = $db->Executes($sql_meta);
        $cache_add = Configuration::get('cache_add');
        if ($cache_add == 1) {
            if ($check_cache != '') {
                $result = array(
                    'controller' => $controller,
                    'content' => $check_cache,
                    'chir' => $presmobileapp->l('Order ID: #').$arg[0],
                    'batitle' =>$db_meta[0]['title'].'-'.$shop_name,
                    'description' => strip_tags($db_meta[0]['description']),
                    'id_order' =>$arg[0]
                );
                echo json_encode($result);
                die;
            }
        }
        $order = new Order($arg[0]);
        $cart_r = new Cart($order->id_cart);
        $orderbycustomer = $order->getCustomerOrders($order->id_customer);
        $discount = $cart_r->getCartRules();
        $discount_new = array();
        if (!empty($discount)) {
            foreach ($discount as $key_d => $value_d) {
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
        $orderbyidcustomer = array();
        foreach ($orderbycustomer as $key_o => $value_o) {
            if ($value_o['id_order'] == $arg[0]) {
                $orderbyidcustomer[0] = $orderbycustomer[$key_o];
            }
        }
        $shipping = $order->getShipping();
        foreach ($shipping as $key_s => $value_s) {
            $shipping[$key_s]['shipping_cost_tax_incl'] = Tools::displayPrice($value_s['shipping_cost_tax_incl']);
        }
        $customer = new Customer($order->id_customer);
        $customer_br = $customer->getAddresses($context->language->id);
        $address_delivery = array();
        $address_invoice = array();
        foreach ($customer_br as $key1 => $value1) {
            if ($orderbyidcustomer[0]['id_address_delivery'] == $value1['id_address']) {
                $address_delivery[0] = array(
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
            if ($orderbyidcustomer[0]['id_address_invoice'] == $value1['id_address']) {
                $address_invoice[0] = array(
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
        $quantity = 0;
        $product = $cart_r->getProducts();
        foreach ($product as $key => $value) {
            foreach ($order->getProducts() as $key1 => $value1) {
                $ab = $value1['product_attribute_id'];
                $ac = $value['id_product_attribute'];
                if ($value1['product_id'] == $value['id_product'] && $ab == $ac) {
                    $product[$key]['id_order_detail'] = $value1['id_order_detail'];
                }
            }
        }
        $db_checkrma = "SELECT * FROM " . _DB_PREFIX_ . "order_return ";
        $db_checkrma = $db->Executes($db_checkrma);
        foreach ($orderbyidcustomer as $key => $value) {
            if (empty($db_checkrma)) {
                $orderbyidcustomer[$key]['check_rma'] = 0;
            } else {
                foreach ($db_checkrma as $key_checkrma => $value_checkrma) {
                    $key_checkrma;
                    if ($value['id_order'] == $value_checkrma['id_order']) {
                        $orderbyidcustomer[$key]['check_rma'] = 1;
                    } else {
                        $orderbyidcustomer[$key]['check_rma'] = 0;
                    }
                }
            }
        }
        $products = $order->getProducts();
        /* DEPRECATED: customizedDatas @since 1.5 */
        OrderReturn::addReturnedQuantity($products, $order->id);
        foreach ($product as $key => $value) {
            foreach ($products as $key_rma => $value_rma) {
                $key_rma;
                if ($value['id_order_detail'] == $value_rma['id_order_detail']) {
                    $product[$key]['qty_rma'] = $value_rma['qty_returned'];
                }
            }
        }
        foreach ($product as $key1 => $value1) {
            $quantity += $value1['cart_quantity'];
            $product[$key1]['link_img'] = $this->getlinkimageproduct($value1['link_rewrite'], $value1['id_image']);
            $product[$key1]['price_discount'] = Tools::displayPrice($value1['total_wt']);
            $product[$key1]['price_total'] = Tools::displayPrice($value1['total']);
        }
        $orderbyidcustomer[0]['total_shipping_check'] = $orderbyidcustomer[0]['total_shipping'];
        $orderbyidcustomer[0]['total_products'] = Tools::displayPrice($orderbyidcustomer[0]['total_products']);
        $orderbyidcustomer[0]['total_shipping'] = Tools::displayPrice($orderbyidcustomer[0]['total_shipping']);
        $orderbyidcustomer[0]['total_paid'] = Tools::displayPrice($orderbyidcustomer[0]['total_paid']);
        $orderbyidcustomer[0]['quantity'] = $quantity;
        $orderbyidcustomer[0]['shipping'] = $shipping;
        $orderbyidcustomer[0]['product'] = $product;
        $orderbyidcustomer[0]['count_product'] = count($product);
        $orderbyidcustomer[0]['address_delivery'] = $address_delivery;
        $orderbyidcustomer[0]['address_invoice'] = $address_invoice;
        $orderbyidcustomer[0]['discount_new'] = $discount_new;
        $orderbyidcustomer[0]['carrier_tax_rate'] = Tools::displayPrice($orderbyidcustomer[0]['carrier_tax_rate']);
        $aa = $orderbyidcustomer[0]['total_paid_tax_incl'];
        $ab = $orderbyidcustomer[0]['total_paid_tax_excl'];
        $orderbyidcustomer[0]['tax'] = Tools::displayPrice($aa-$ab);
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $hook_displayOrderDetail = $core->mobiexec172('displayOrderDetail', array('order' => $order));
            $presmobic_beforeOrderShipping = $core->mobiexec172('presmobic_beforeOrderShipping');
            $presmobic_afterOrderShipping = $core->mobiexec172('presmobic_afterOrderShipping');
            $presmobic_afterOrderProduct = $core->mobiexec172('presmobic_afterOrderProduct');
            $presmobic_beforeOrderProduct = $core->mobiexec172('presmobic_beforeOrderProduct');
            $presmobic_afterOrderPayment = $core->mobiexec172('presmobic_afterOrderPayment');
            $presmobic_beforeOrderPayment = $core->mobiexec172('presmobic_beforeOrderPayment');
            $presmobic_afterOrderRma = $core->mobiexec172('presmobic_afterOrderRma');
            $presmobic_beforeOrderRma = $core->mobiexec172('presmobic_beforeOrderRma');
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $hook_displayOrderDetail = $core->mobiexec17('displayOrderDetail', array('order' => $order));
            $presmobic_beforeOrderShipping = $core->mobiexec17('presmobic_beforeOrderShipping');
            $presmobic_afterOrderShipping = $core->mobiexec17('presmobic_afterOrderShipping');
            $presmobic_afterOrderProduct = $core->mobiexec17('presmobic_afterOrderProduct');
            $presmobic_beforeOrderProduct = $core->mobiexec17('presmobic_beforeOrderProduct');
            $presmobic_afterOrderPayment = $core->mobiexec17('presmobic_afterOrderPayment');
            $presmobic_beforeOrderPayment = $core->mobiexec17('presmobic_beforeOrderPayment');
            $presmobic_afterOrderRma = $core->mobiexec17('presmobic_afterOrderRma');
            $presmobic_beforeOrderRma = $core->mobiexec17('presmobic_beforeOrderRma');
        } else {
            $hook_displayOrderDetail = $core->mobiexec('displayOrderDetail', array('order' => $order));
            $presmobic_beforeOrderShipping = $core->mobiexec('presmobic_beforeOrderShipping');
            $presmobic_afterOrderShipping = $core->mobiexec('presmobic_afterOrderShipping');
            $presmobic_afterOrderProduct = $core->mobiexec('presmobic_afterOrderProduct');
            $presmobic_beforeOrderProduct = $core->mobiexec('presmobic_beforeOrderProduct');
            $presmobic_afterOrderPayment = $core->mobiexec('presmobic_afterOrderPayment');
            $presmobic_beforeOrderPayment = $core->mobiexec('presmobic_beforeOrderPayment');
            $presmobic_afterOrderRma = $core->mobiexec('presmobic_afterOrderRma');
            $presmobic_beforeOrderRma = $core->mobiexec('presmobic_beforeOrderRma');
        }
        $check_status = $orderbyidcustomer[0]['id_order_state'];
        $order_return = Configuration::get('PS_ORDER_RETURN', null, '', $id_shop);
        $context->smarty->assign("presmobic_beforeOrderShipping", $presmobic_beforeOrderShipping);
        $context->smarty->assign("presmobic_afterOrderShipping", $presmobic_afterOrderShipping);
        $context->smarty->assign("presmobic_afterOrderProduct", $presmobic_afterOrderProduct);
        $context->smarty->assign("presmobic_beforeOrderProduct", $presmobic_beforeOrderProduct);
        $context->smarty->assign("presmobic_afterOrderPayment", $presmobic_afterOrderPayment);
        $context->smarty->assign("presmobic_beforeOrderPayment", $presmobic_beforeOrderPayment);
        $context->smarty->assign("presmobic_afterOrderRma", $presmobic_afterOrderRma);
        $context->smarty->assign("check_status", $check_status);
        $context->smarty->assign("order_return", $order_return);
        $context->smarty->assign("presmobic_beforeOrderRma", $presmobic_beforeOrderRma);
        $message = CustomerMessage::getMessagesByOrderId($arg[0], false);
        $seourl = Configuration::get('PS_REWRITING_SETTINGS', null, '', $id_shop);
        $context->smarty->assign("seourl", $seourl);
        $context->smarty->assign("order", $orderbyidcustomer);
        $context->smarty->assign("hook_displayOrderDetail", $hook_displayOrderDetail);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/order/orderbyid.tpl';
        $content =  $context->smarty->fetch($a);
        $check_setcache = $core->presMobisetcache($controller.':'.$arg[0], $content);
        $check_setcache;
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'chir' => $presmobileapp->l('Order ID: #').$arg[0],
            'batitle' =>$db_meta[0]['title'].'-'.$shop_name,
            'description' => strip_tags($db_meta[0]['description']),
            'id_order' =>$arg[0],
            'count_mess' => count($message),
            'invoice_number' => $order->invoice_number
        );
        echo json_encode($result);
        die;
    }
    public function getlinkimageproduct($link_rew, $id_image)
    {
        $linkimages = new Link();
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $type_img = ImageType::getFormattedName('presmobic');
        } else {
            $type_img = ImageType::getFormatedName('presmobic');
        }
        $link_img = Tools::getShopProtocol() . $linkimages->getImageLink($link_rew, $id_image, $type_img);
        return $link_img;
    }
}
