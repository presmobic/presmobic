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
$context = Context::getContext();
$presmobileapp = new PresMobileApp();
$url_fodel = _PS_MODULE_DIR_;
include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
$core = new BaCore();
$mobi_token = (string)Tools::getValue('token_pres');
$checktoken = $core->cookiekeymodule();
if ($mobi_token != $checktoken) {
    echo $core->transbv();
    die;
}
$customizationQtyInput = Tools::getValue('customization_qty_input');
$order_qte_input = Tools::getValue('order_qte_input');
$customizationIds = Tools::getValue('customization_ids');
if (!$id_order = (int)(Tools::getValue('id_order'))) {
    $result = array(
        'status' => 401,
        'messenger'=> $presmobileapp->l('For each product you wish to add, please specify the desired quantity.')
    );
    echo json_encode($result);
    die;
}
if (!$order_qte_input && !$customizationQtyInput && !$customizationIds) {
    $result = array(
        'status' => 401,
        'messenger'=> $presmobileapp->l('For each product you wish to add, please specify the desired quantity.')
    );
    echo json_encode($result);
    die;
}
if (!$customizationIds && !$ids_order_detail = Tools::getValue('ids_order_detail')) {
    $result = array(
        'status' => 401,
        'messenger'=> $presmobileapp->l('For each product you wish to add, please specify the desired quantity.')
    );
    echo json_encode($result);
    die;
}
$order = new Order((int)($id_order));
if (!$order->isReturnable()) {
    Tools::redirect('index.php?controller=order-follow&errorNotReturnable');
}
if ($order->id_customer != $context->customer->id) {
    die(Tools::displayError());
}
$orderReturn = new OrderReturn();
$orderReturn->id_customer = (int)$context->customer->id;
$orderReturn->id_order = $id_order;
$orderReturn->question = (string)Tools::getValue('returnText');
if (empty($orderReturn->question)) {
    $result = array(
        'status' => 401,
        'messenger'=> $presmobileapp->l('Please provide an explanation for your RMA.')
    );
    echo json_encode($result);
    die;
}
if (!$orderReturn->checkEnoughProduct($ids_order_detail, $order_qte_input, $customizationIds, $customizationQtyInput)) {
    $result = array(
        'status' => 401,
        'messenger'=> $presmobileapp->l('You do not have enough products to request an additional merchandise return.')
    );
    echo json_encode($result);
    die;
}
$orderReturn->state = 1;
$orderReturn->add();
$orderReturn->addReturnDetail($ids_order_detail, $order_qte_input, $customizationIds, $customizationQtyInput);
Hook::exec('actionOrderReturn', array('orderReturn' => $orderReturn));
$result = array(
    'status' => 200,
    'messenger'=> $presmobileapp->l('Update Success.')
);
echo json_encode($result);
die;
