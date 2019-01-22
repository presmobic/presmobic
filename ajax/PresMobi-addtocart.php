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
$id_product = (int)Tools::getValue('id_product');
$data_attribute = (string)Tools::getValue('data_attribute');
$quantity = Tools::getValue('quantity');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context=Context::getContext();
$attribute = null;
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$date_add = date('Y-m-d H:i:s');
$data_attribute = rtrim($data_attribute, ',');
$combination = explode(',', $data_attribute);
if ($quantity == false) {
    $quantity = 1;
}
$cart = $core->presMobicartresult();
if ($data_attribute == '') {
    $id_product_attribute = 0;
} else {
    $sql = "SELECT  pa.`id_product_attribute` AS id_pro,a.`id_attribute` ";
    $sql .= " AS id_attribute,agl.`name` AS group_name, al.`name` AS attribute_name";
    $sql .= " FROM `" . _DB_PREFIX_ . "product_attribute` pa";
    $sql .= " INNER JOIN " . _DB_PREFIX_ . "product_attribute_shop product_attribute_shop";
    $sql .= " ON (product_attribute_shop.id_product_attribute ";
    $sql .= "= pa.id_product_attribute AND product_attribute_shop.id_shop = ".(int)$id_shop.")";
    $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "product_attribute_combination` pac ";
    $sql .= " ON pac.`id_product_attribute` = pa.`id_product_attribute`";
    $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "attribute` a ON a.`id_attribute` = pac.`id_attribute`";
    $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "attribute_group` ag ";
    $sql .= " ON ag.`id_attribute_group` = a.`id_attribute_group` ";
    $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "attribute_lang` al ";
    $sql .= "ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = ".(int)$id_lang.")";
    $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "attribute_group_lang` agl ";
    $sql .= "ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = ".(int)$id_lang.")";
    $sql .= " WHERE pa.`id_product` = ".(int)$id_product."";
    $sql .= " GROUP BY pa.`id_product_attribute`, ag.`id_attribute_group`";
    $sql .= " ORDER BY pa.`id_product_attribute`";
    $result = $db->Executes($sql);
    $attribute = array();
    foreach ($result as $key => $value) {
        $key;
        $attribute[$value['id_pro']][] =  $value['id_attribute'];
    }
    $aeb = array();
    $id_product_attribute = 0;
    foreach ($attribute as $key => $value) {
        $aeb = array_diff($combination, $attribute[$key]);
        if (empty($aeb)) {
            $id_product_attribute = $key;
            break;
        }
    }
}
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
$customer = new Customer($context->cart->id_customer);
$customer_br = $customer->getAddresses($context->language->id);
if (!empty($customer_br)) {
    foreach ($customer_br as $key1 => $value1) {
        if ($context->cart->id_address_delivery != $value1['id_address']) {
            $context->cart->id_address_delivery = $customer_br[0]['id_address'];
        }
        if ($context->cart->id_address_invoice != $value1['id_address']) {
            $context->cart->id_address_invoice = $customer_br[0]['id_address'];
        }
    }
} else {
    $context->cart->id_address_delivery = 0;
    $context->cart->id_address_invoice = 0;
}
$aa = (int)($quantity);
$ab = (int)($id_product);
$ac = (int)($id_product_attribute);
$updateQuantity = $context->cart->updateQty($aa, $ab, $ac, null, 'up');
$context->cart->update();
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
    $hookpresmobic_before_add_to_cart = $core->mobiexec172('presmobic_before_add_to_cart', array());
} elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
    $hookpresmobic_before_add_to_cart = $core->mobiexec17('presmobic_before_add_to_cart', array());
} else {
    $hookpresmobic_before_add_to_cart = $core->mobiexec('presmobic_before_add_to_cart', array());
}
$cart = new Cart($context->cart->id);
$productcart = $cart->getProducts(true);
$presmobileapp = new PresMobileApp();
if (empty($productcart)) {
    $result = array(
        'status' => 401,
        'messenger' =>$presmobileapp->l('This product is no longer in stock'),
    );
    echo json_encode($result);
    die;
}
$quantity_cart = 0;
foreach ($productcart as $key => $value) {
    $quantity_cart += $value['cart_quantity'];
}
$price = 0;
foreach ($productcart as $key => $value) {
    $price += $value['total_wt'];
}

$result = array(
    'total_product'=>$quantity_cart,
    'price'=>Tools::displayPrice($price),
    'messenger' =>'Product successfully added to cart'
);
echo json_encode($result);
die;
