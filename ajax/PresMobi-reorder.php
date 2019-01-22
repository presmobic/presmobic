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
$id_order = (int)Tools::getValue('id_order');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$url_fodel = _PS_MODULE_DIR_;
$context = Context::getContext();
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$oldCart = new Cart(Order::getCartIdStatic($id_order, $context->customer->id));
$duplication = $oldCart->duplicate();
$context->cookie->id_cart = $duplication['cart']->id;
$context->cookie->write();
$cart = new Cart($context->cart->id);
$productcart = $cart->getProducts(true);
$presmobileapp = new PresMobileApp();
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
