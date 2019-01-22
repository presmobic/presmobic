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

class BaMyVouChers extends PresMobileApp
{
    public function __construct()
    {
        parent::__construct();
    }
    public function start($arg)
    {
        $arg;
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $presmobileapp = new PresMobileApp();
        $controller = 'myvouchers';
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $cart = $core->presMobicartresult();
        $discountbycustomer = CartRule::getCustomerCartRules($id_lang, $context->customer->id, true, false);
        $discount_new = array();
        if (!empty($discountbycustomer)) {
            foreach ($discountbycustomer as $key => $value) {
                if ($value['id_customer'] == $cart['id_customer']) {
                    $discount_new[$key] = $discountbycustomer[$key];
                }
            }
        }
        $discountcustomer = array();
        if (!empty($discount_new)) {
            foreach ($discount_new as $key => $value) {
                $discountcustomer[$key]['code'] = $value['code'];
                $discountcustomer[$key]['name'] = $value['name'];
                $discountcustomer[$key]['quantity'] = $value['quantity'];
                if ($value['value'] == '0') {
                    $discountcustomer[$key]['value'] = $presmobileapp->l('Free shipping');
                } else {
                    $discountcustomer[$key]['value'] = Tools::displayPrice($value['value']).'(Tax included)';
                }
                $discountcustomer[$key]['value'] = $presmobileapp->l('Free shipping');
                if ($value['minimal'] == '0') {
                    $discountcustomer[$key]['minimal'] =  $presmobileapp->l('None');
                } else {
                    $discountcustomer[$key]['minimal'] = Tools::displayPrice($value['minimal']);
                }
                $discountcustomer[$key]['active'] = $value['active'];
                $discountcustomer[$key]['date'] = Tools::displayDate($value['date_to'], null);
            }
        }
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobic_beforeDiscount = $core->mobiexec172('presmobic_beforeDiscount', array());
            $presmobic_afterDiscount = $core->mobiexec172('presmobic_afterDiscount', array());
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobic_beforeDiscount = $core->mobiexec17('presmobic_beforeDiscount', array());
            $presmobic_afterDiscount = $core->mobiexec17('presmobic_afterDiscount', array());
        } else {
            $presmobic_beforeDiscount = $core->mobiexec('presmobic_beforeDiscount', array());
            $presmobic_afterDiscount = $core->mobiexec('presmobic_afterDiscount', array());
        }
        $url = $core->getMobiBaseLink();
        $context->smarty->assign("presmobic_beforeDiscount", $presmobic_beforeDiscount);
        $context->smarty->assign("presmobic_afterDiscount", $presmobic_afterDiscount);
        $context->smarty->assign("url", $url);
        $context->smarty->assign("discount", $discountcustomer);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/myvouchers/myvouchers.tpl';
        $content =  $context->smarty->fetch($a);
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'chir' => $presmobileapp->l('My Vouchers'),
            'batitle' =>'My Vouchers - '.$shop_name,
            'description' => 'My Vouchers - '.$shop_name
        );
        echo json_encode($result);
        die;
    }
}
