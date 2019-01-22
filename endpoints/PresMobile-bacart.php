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

class BaCart extends PresMobileApp
{
    public function __construct()
    {
        parent::__construct();
    }
    public function start($arg)
    {
        $arg;
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $context = Context::getContext();
        $controller = 'cart';
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $url_fodel = _PS_MODULE_DIR_;
        $id_lang = $context->language->id;
        $id_shop = $context->shop->id;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $cart = $core->presMobicartresult();
        $product = $context->cart->getProducts();
        $cartrule = $context->cart->getCartRules();
        $cart_r = new Cart($context->cart->id);
        $customer = new Customer($cart_r->id_customer);
        $customer_br = $customer->getAddresses($context->language->id);
        $check_address = 0;
        if (!empty($customer_br)) {
            $check_address = 1;
        }
        $ba_cart = array();
        if (!empty($product)) {
            $id_product = '';
            $id_product_attribute = '';
            $price_shipping = 0;
            $price =(float)0;
            foreach ($product as $key => $value) {
                $id_product .= $value['id_product'].',';
                $id_product_attribute .= $value['id_product_attribute'].',';
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
            $id_product_attribute = rtrim($id_product_attribute, ',');
            $sql_where_product = " AND p.`id_product` IN (".pSQL($id_product).")";
            $sql_where_product .= " AND pa.`id_product_attribute` IN (".pSQL($id_product_attribute).")";
            $sql_sort_category = '';
            $ac = $sql_where_product;
            $ad = $sql_sort_category;
            $product_r = $core->presMobigetProductCart($id_shop, $id_lang, $ac, $ad, 'LIMIT 0,1000', 2);
            foreach ($product_r as $key1 => $value1) {
                $key1;
                foreach ($product as $key => $value) {
                    $ra = $value1['id_product_attribute'];
                    $rb = $value['id_product_attribute'];
                    if ($value1['id_product'] == $value['id_product'] && $ra == $rb) {
                        if (!empty($product[$key]['attributes'])) {
                            $product[$key]['attributes'] = str_replace(" :", ":", $product[$key]['attributes']);
                        }
                        $product[$key]['price_discount'] = Tools::displayPrice($value1['price_without_reduction']);
                        $product[$key]['price_total'] = Tools::displayPrice($value1['price_tax_exc']);
                        $aa = $value1['link_rewrite'];
                        $ab = $value['id_image'];
                        $product[$key]['link_img'] = $this->getlinkimageproduct($aa, $ab);
                        $product[$key]['specific_prices'] = $value1['specific_prices'];
                    }
                }
            }
            foreach ($product as $key => $value) {
                if ($value['id_product_attribute'] == '0') {
                    $product[$key]['attributes'] = '';
                    $product[$key]['price_discount'] = Tools::displayPrice($value['price_without_reduction']);
                    $product[$key]['price_total'] = Tools::displayPrice($value['total']);
                    $product[$key]['link_img'] = $this->getlinkimageproduct($value['link_rewrite'], $value['id_image']);
                    $product[$key]['specific_prices'] = SpecificPrice::getByProductId($value['id_product']);
                }
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
            $ba_cart[0]['coupon'] = $discount_new;
        }
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $cart = $core->presMobicartresult();
        $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=14";
            $db_meta = $db->Executes($sql_meta);
            $batitle = $db_meta[0]['title'];
        } else {
            $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=21";
            $db_meta = $db->Executes($sql_meta);
            $batitle = $db_meta[0]['title'].' - '.$shop_name;
        }
        $cart_abc = new Cart($context->cart->id);
        $productcart = $cart_abc->getProducts(true);
        $quantity_cart = 0;
        foreach ($productcart as $key => $value) {
            $quantity_cart += $value['cart_quantity'];
        }
        $price_total_a = 0;
        foreach ($productcart as $key => $value) {
            $price_total_a += $value['total_wt'];
        }
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobic_beforeCartProduct = $core->mobiexec172('presmobic_beforeCartProduct', array());
            $presmobic_afterCartProduct = $core->mobiexec172('presmobic_afterCartProduct', array());
            $presmobic_beforeCartCoupon = $core->mobiexec172('presmobic_beforeCartCoupon', array());
            $presmobic_afterCartCoupon = $core->mobiexec172('presmobic_afterCartCoupon', array());
            $ar_product = array('baproduct'=>$product);
            $presmobicGetDataProductCart = $core->mobiexec172('presmobicGetDataProductCart', $ar_product);
            $presmobicBeforeCartBoxQuantity = $core->mobiexec172('presmobicBeforeCartBoxQuantity', array());
            $presmobicBeforeCartBoxQuantity = $core->mobiexec172('presmobicBeforeCartBoxQuantity', array());
            $presmobicBeforeCartSubmitCheckout = $core->mobiexec172('presmobicBeforeCartSubmitCheckout', array());
            $presmobicAfterCartSubmitCheckout = $core->mobiexec172('presmobicAfterCartSubmitCheckout', array());
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobic_beforeCartProduct = $core->mobiexec17('presmobic_beforeCartProduct', array());
            $presmobic_afterCartProduct = $core->mobiexec17('presmobic_afterCartProduct', array());
            $presmobic_beforeCartCoupon = $core->mobiexec17('presmobic_beforeCartCoupon', array());
            $presmobic_afterCartCoupon = $core->mobiexec17('presmobic_afterCartCoupon', array());

            $ar_product = array('baproduct'=>$product);
            $presmobicGetDataProductCart = $core->mobiexec17('presmobicGetDataProductCart', array(), $ar_product);
            $presmobicBeforeCartBoxQuantity = $core->mobiexec17('presmobicBeforeCartBoxQuantity', array());
            $presmobicAfterCartBoxQuantity = $core->mobiexec17('presmobicAfterCartBoxQuantity', array());
            $presmobicBeforeCartSubmitCheckout = $core->mobiexec17('presmobicBeforeCartSubmitCheckout', array());
            $presmobicAfterCartSubmitCheckout = $core->mobiexec17('presmobicAfterCartSubmitCheckout', array());
        } else {
            $presmobic_beforeCartProduct = $core->mobiexec('presmobic_beforeCartProduct', array());
            $presmobic_afterCartProduct = $core->mobiexec('presmobic_afterCartProduct', array());
            $presmobic_afterCartCoupon = $core->mobiexec('presmobic_afterCartCoupon', array());
            $presmobic_beforeCartCoupon = $core->mobiexec('presmobic_beforeCartCoupon', array());
            $ar_product = array('baproduct'=>$product);
            $presmobicGetDataProductCart = $core->mobiexec('presmobicGetDataProductCart', array(), $ar_product);
            $presmobicBeforeCartBoxQuantity = $core->mobiexec('presmobicBeforeCartBoxQuantity', array());
            $presmobicAfterCartBoxQuantity = $core->mobiexec('presmobicAfterCartBoxQuantity', array());
            $presmobicBeforeCartSubmitCheckout = $core->mobiexec('presmobicBeforeCartSubmitCheckout', array());
            $presmobicAfterCartSubmitCheckout = $core->mobiexec('presmobicAfterCartSubmitCheckout', array());
        }
        if (is_array($presmobicGetDataProductCart)) {
            $ba_cart[0]['product'] = $presmobicGetDataProductCart['baproduct'];
        }
        $id_currency_default = $context->currency->id;
        $infor_currency = Currency::getCurrency($id_currency_default);
        $minium_price1 = Configuration::get('PS_PURCHASE_MINIMUM');
        $conversion_rate = $infor_currency['conversion_rate'];
        $minium_price = $conversion_rate * $minium_price1;
        $price_check = Tools::displayPrice($minium_price);
        $checkterm  = Configuration::get('PS_CONDITIONS');
        $context->smarty->assign("checkterm", $checkterm);
        $context->smarty->assign("minium_price", $minium_price);
        $context->smarty->assign("price_check", $price_check);
        $check_order = Configuration::get('PS_ORDER_PROCESS_TYPE');
        $check_guest = Configuration::get('PS_GUEST_CHECKOUT_ENABLED');
        // var_dump($ba_cart);die;
        $context->smarty->assign("presmobicBeforeCartBoxQuantity", $presmobicBeforeCartBoxQuantity);
        $context->smarty->assign("presmobicAfterCartBoxQuantity", $presmobicAfterCartBoxQuantity);
        $context->smarty->assign("presmobicBeforeCartSubmitCheckout", $presmobicBeforeCartSubmitCheckout);
        $context->smarty->assign("presmobicAfterCartSubmitCheckout", $presmobicAfterCartSubmitCheckout);

        $context->smarty->assign("presmobic_beforeCartProduct", $presmobic_beforeCartProduct);
        $context->smarty->assign("presmobic_afterCartProduct", $presmobic_afterCartProduct);
        $context->smarty->assign("presmobic_beforeCartCoupon", $presmobic_beforeCartCoupon);
        $context->smarty->assign("presmobic_afterCartCoupon", $presmobic_afterCartCoupon);
        
        $context->smarty->assign("check_guest", $check_guest);
        $context->smarty->assign("check_order", $check_order);
        $context->smarty->assign("cart", $ba_cart);
        $context->smarty->assign("check_address", $check_address);
        $context->smarty->assign("cart_customer", $cart);
        $context->smarty->assign("url", $url);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/cart/cart.tpl';
        $content =  $context->smarty->fetch($a);
        $result = array(
            'total_product'=>$quantity_cart,
            'price'=>Tools::displayPrice($price_total_a),
            'controller' => $controller,
            'content' => $content,
            'chir' => 'Shopping cart',
            'batitle' => $batitle,
            'description' => strip_tags($db_meta[0]['description'])
        );
        echo json_encode($result);
        die;
    }
    public function getlinkimageproduct($link_rew, $id_image)
    {
        $linkimages = new Link();
        $context = Context::getContext();
        $iso_lang = $context->language->iso_code;
        $no_img = $iso_lang.'-default';
        if ($id_image == $no_img) {
            $base = Tools::getShopProtocol() . Tools::getServerName();
            $no_img1 = $iso_lang.'-default-';
            $size = 'small_'.'default';
            $link_img = $base._THEME_PROD_DIR_.$no_img1.$size.".jpg";
        } else {
            if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
                $type_img = ImageType::getFormattedName('presmobic');
            } else {
                $type_img = ImageType::getFormatedName('presmobic');
            }
            $link_img = Tools::getShopProtocol() . $linkimages->getImageLink($link_rew, $id_image, $type_img);
        }
        
        return $link_img;
    }
}
