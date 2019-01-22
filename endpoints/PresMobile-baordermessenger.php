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

class BaOrderMessenger extends PresMobileApp
{
    public function __construct()
    {
    }
    public function start($arg)
    {
        $arg;
        $id_order = $arg[0];
        $presmobileapp = new PresMobileApp();
        $presmobileapp;
        $url_fodel = _PS_MODULE_DIR_;
        $controller = 'ordermessenger';
        $context = Context::getContext();
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $order = new Order($id_order);
        $products = $order->getProducts();
        $message = CustomerMessage::getMessagesByOrderId((int)($id_order), false);
        $products_new = array();
        foreach ($products as $key => $value) {
            $products_new[$key]['id_product'] = $value['product_id'];
            $products_new[$key]['name'] = $value['product_name'];
        }
        $url = $core->getMobiBaseLink();
        usort($message, "sortFunction");
        $context->smarty->assign("id_order", $id_order);
        $context->smarty->assign("url", $url);
        $context->smarty->assign("message", $message);
        $context->smarty->assign("products_new", $products_new);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/order/ordermessenger.tpl';
        $content =  $context->smarty->fetch($a);
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'chir' =>'Message'
        );
        echo json_encode($result);
        die;
    }
}
function sortFunction($a, $b)
{
    return strtotime($a["date_add"]) - strtotime($b["date_add"]);
}
