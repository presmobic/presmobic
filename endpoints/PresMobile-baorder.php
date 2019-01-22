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

class BaOrder extends PresMobileApp
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
        $presmobileapp = new PresMobileApp();
        $controller = 'order';
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $id_lang = $context->language->id;
        $cart = $core->presMobicartresult();
        $check_cache = $core->presMobicheckcache($controller);
        $check_cache;
        $order = new Order();
        $orderbycustomer = $order->getCustomerOrders($cart['id_customer']);
        if (!empty($orderbycustomer)) {
            foreach ($orderbycustomer as $key => $value) {
                $quantity = 0;
                $cart_r = new Cart($value['id_cart']);
                foreach ($cart_r->getProducts() as $key1 => $value1) {
                    $key1;
                    $quantity += $value1['cart_quantity'];
                }
                $orderbycustomer[$key]['quantity'] = $quantity;
                $orderbycustomer[$key]['price_total'] = Tools::displayPrice($value['total_paid']);
            }
        }
        $orderbycustomer_aw = array();
        if (count($orderbycustomer) > 8) {
            for ($i=0; $i < 8; $i++) {
                $orderbycustomer_aw[$i] = $orderbycustomer[$i];
            }
            $context->smarty->assign("order", $orderbycustomer_aw);
        } else {
            $context->smarty->assign("order", $orderbycustomer);
        }
        $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=16";
            $db_meta = $db->Executes($sql_meta);
            $batitle = $db_meta[0]['title'];
        } else {
            $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=16";
            $db_meta = $db->Executes($sql_meta);
            $batitle = $db_meta[0]['title'].' - '.$shop_name;
        }
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobic_afterOrder = $core->mobiexec172('presmobic_afterOrder', array());
            $presmobic_beforeOrder = $core->mobiexec172('presmobic_beforeOrder', array());
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobic_afterOrder = $core->mobiexec17('presmobic_afterOrder', array());
            $presmobic_beforeOrder = $core->mobiexec17('presmobic_beforeOrder', array());
        } else {
            $presmobic_afterOrder = $core->mobiexec('presmobic_afterOrder', array());
            $presmobic_beforeOrder = $core->mobiexec('presmobic_beforeOrder', array());
        }
        $url = $core->getMobiBaseLink();
        $seourl = Configuration::get('PS_REWRITING_SETTINGS', null, '', $id_shop);
        $context->smarty->assign("seourl", $seourl);
        $context->smarty->assign("presmobic_afterOrder", $presmobic_afterOrder);
        $context->smarty->assign("presmobic_beforeOrder", $presmobic_beforeOrder);
        $context->smarty->assign("url", $url);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/order/order.tpl';
        $content =  $context->smarty->fetch($a);
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $check_setcache = $core->presMobisetcache($controller, $content);
        $check_setcache;
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'chir' => $presmobileapp->l('My Order'),
            'batitle' => $batitle,
            'description' => $presmobileapp->l('Order history - ').$shop_name
        );
        echo json_encode($result);
        die;
    }
}
