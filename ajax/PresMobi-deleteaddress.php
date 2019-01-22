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
$id_address = (int)Tools::getValue('id_address');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context = Context::getContext();
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$address = new Address($id_address);
$address->delete();
$cart = $core->presMobicartresult();
$customer = new Customer($cart['id_customer']);
$customer_br = $customer->getAddresses($id_lang);
if (empty($customer_br)) {
    Context::getContext()->cart->id_address_invoice = 0;
    Context::getContext()->cart->id_address_delivery = 0;
    Context::getContext()->cart->update();
} else {
    if (Context::getContext()->cart->id_address_invoice == $id_address) {
        Context::getContext()->cart->id_address_invoice = $customer_br[0]['id_address'];
    }
    if (Context::getContext()->cart->id_address_delivery == $id_address) {
        Context::getContext()->cart->id_address_delivery = $customer_br[0]['id_address'];
    }
    Context::getContext()->cart->update();
}
$presmobileapp = new PresMobileApp();
$result = array(
    'status' =>200,
    'messenger' =>$presmobileapp->l('Delete Success.'),
);
echo json_encode($result);
die;
