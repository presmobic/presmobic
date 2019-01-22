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
$checktoken = $core->cookiekeymodule();
$mobi_token = (string)Tools::getValue('token_pres');
if ($mobi_token != $checktoken) {
    echo $core->transbv();
    die;
}
$presmobileapp = new PresMobileApp();
$id_product = (string)Tools::getValue('id_product');
if (empty($id_product)) {
    $result = array(
        'status' => 401,
        'messenger' => $presmobileapp->l('Add to cart error'),
    );
    echo json_encode($result);
    die;
}
$quantity = (string)Tools::getValue('quantity');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context=Context::getContext();
$attribute = null;
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$date_add = date('Y-m-d H:i:s');
$id_product = rtrim($id_product, ',');
$data_id_product = explode(',', $id_product);
$quantity = rtrim($quantity, ',');
$data_quantity = explode(',', $quantity);
$data_add =array();
foreach ($data_id_product as $key => $value) {
    foreach ($data_quantity as $key_qty => $value_qty) {
        if ($key == $key_qty) {
            $data_add[$key]['id_product'] = $value;
            $data_add[$key]['quantity'] = $value_qty;
        }
    }
}
$cart = $core->presMobicartresult();
if (!$context->cart->id) {
    if ($context->cookie->id_guest) {
        $guest = new Guest($context->cookie->id_guest);
        $context->cart->mobile_theme = $guest->mobile_theme;
    }
    $context->cart->add();
    if ($context->cart->id) {
        $context->cookie->id_cart = (int) $context->cart->id;
    }
}
foreach ($data_add as $key => $value) {
    $id_default_attribute = (int)Product::getDefaultAttribute($value['id_product']);
    $sql = "SELECT *FROM ". _DB_PREFIX_ ."cart_product WHERE id_product=".(int)$value['id_product']."";
    $sql .= " AND id_product_attribute=".(int)$id_default_attribute."";
    $sql .= " AND id_shop=".(int)$id_shop."";
    $sql .= " AND id_cart=".(int)$context->cart->id."";
    $result = $db->Executes($sql);
    if (!empty($result)) {
        if ($result[0]['quantity'] != $value['quantity']) {
            if ($result[0]['quantity'] < $value['quantity']) {
                $qty = $value['quantity'] - $result[0]['quantity'];
                $aa = (int)($value['id_product']);
                $ab = (int)($id_default_attribute);
                $updateQuantity = $context->cart->updateQty((int)($qty), $aa, $ab, null, 'up');
            } else {
                $qty = $result[0]['quantity'] - $value['quantity'];
                $aa = (int)($value['id_product']);
                $ab = (int)($id_default_attribute);
                $updateQuantity = $context->cart->updateQty((int)($qty), $aa, $ab, null, 'down');
            }
        }
    } else {
        $ac = (int)($value['quantity']);
        $aa = (int)($value['id_product']);
        $ab = (int)($id_default_attribute);
        $updateQuantity = $context->cart->updateQty($ac, $aa, $ab, null, 'up');
    }
}
$context->cart->update();
$cart = new Cart($context->cart->id);
$productcart = $cart->getProducts(true);
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
    'price'=>(string)Tools::displayPrice($price),
    'messenger' => $presmobileapp->l('Product successfully added to cart'),
);
echo json_encode($result);
die;
