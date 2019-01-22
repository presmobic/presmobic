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
$presmobileapp = new PresMobileApp();
$context = Context::getContext();
$idOrder = (int)(Tools::getValue('id_order'));
$msgText = (string)Tools::getValue('text');
if (!$idOrder || !Validate::isUnsignedId($idOrder)) {
    $result = array(
        'messenger'=>$presmobileapp->l('The order is no longer valid.'),
        'status'=>401
    );
    echo json_encode($result);
    die;
} elseif (empty($msgText)) {
    $result = array(
        'messenger'=>$presmobileapp->l('The message cannot be blank.'),
        'status'=>401
    );
    echo json_encode($result);
    die;
} elseif (!Validate::isMessage($msgText)) {
    $result = array(
        'messenger'=>$presmobileapp->l('This message is invalid (HTML is not allowed).'),
        'status'=>401
    );
    echo json_encode($result);
    die;
}
$order = new Order($idOrder);
if (Validate::isLoadedObject($order) && $order->id_customer == $context->customer->id) {
    $id_customer_thread = CustomerThread::getIdCustomerThreadByEmailAndIdOrder($context->customer->email, $order->id);
    $cm = new CustomerMessage();
    if (!$id_customer_thread) {
        $ct = new CustomerThread();
        $ct->id_contact = 0;
        $ct->id_customer = (int)$order->id_customer;
        $ct->id_shop = (int)$context->shop->id;
        if (($id_product = (int)Tools::getValue('id_product')) && $order->orderContainProduct((int)$id_product)) {
            $ct->id_product = $id_product;
        }
        $ct->id_order = (int)$order->id;
        $ct->id_lang = (int)$context->language->id;
        $ct->email = $context->customer->email;
        $ct->status = 'open';
        $ct->token = Tools::passwdGen(12);
        $ct->add();
    } else {
        $ct = new CustomerThread((int)$id_customer_thread);
    }
    $cm->id_customer_thread = $ct->id;
    $cm->message = $msgText;
    $cm->ip_address = ip2long($_SERVER['REMOTE_ADDR']);
    $cm->add();
    if (!Configuration::get('PS_MAIL_EMAIL_MESSAGE')) {
        $to = (string)Configuration::get('PS_SHOP_EMAIL');
    } else {
        $to = new Contact((int)(Configuration::get('PS_MAIL_EMAIL_MESSAGE')));
        $to = (string)$to->email;
    }
    $toName = (string)Configuration::get('PS_SHOP_NAME');
    $customer = $context->customer;
    if (Validate::isLoadedObject($customer)) {
        Mail::Send(
            $context->language->id,
            'order_customer_comment',
            Mail::l('Message from a customer'),
            array(
                '{lastname}' => $customer->lastname,
                '{firstname}' => $customer->firstname,
                '{email}' => $customer->email,
                '{id_order}' => (int)($order->id),
                '{order_name}' => $order->getUniqReference(),
                '{message}' => Tools::nl2br($msgText)
            ),
            $to,
            $toName,
            $customer->email,
            $customer->firstname.' '.$customer->lastname
        );
    }
} else {
    $result = array(
        'messenger'=>$presmobileapp->l('Order not found'),
        'status'=>401
    );
    echo json_encode($result);
    die;
}
