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

class BaMyAddressByCustomer extends PresMobileApp
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
        $controller = 'myaddressbycustomer';
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $id_lang = $context->language->id;
        $cart = $core->presMobicartresult();
        $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
        $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=12";
        $db_meta = $db->Executes($sql_meta);
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $batitle = $db_meta[0]['title'];
        } else {
            $batitle = $db_meta[0]['title'].' - '.$shop_name;
        }
        $customer = new Customer($cart['id_customer']);
        $customer_br = $customer->getAddresses($id_lang);
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobic_beforeAddress = $core->mobiexec172('presmobic_beforeAddress', array());
            $presmobic_afterAddress = $core->mobiexec172('presmobic_afterAddress', array());
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobic_beforeAddress = $core->mobiexec17('presmobic_beforeAddress', array());
            $presmobic_afterAddress = $core->mobiexec17('presmobic_afterAddress', array());
        } else {
            $presmobic_beforeAddress = $core->mobiexec('presmobic_beforeAddress', array());
            $presmobic_afterAddress = $core->mobiexec('presmobic_afterAddress', array());
        }
        $url = $core->getMobiBaseLink();
        $context->smarty->assign("url", $url);
        $context->smarty->assign("customer_br", $customer_br);
        $context->smarty->assign("presmobic_beforeAddress", $presmobic_beforeAddress);
        $context->smarty->assign("presmobic_afterAddress", $presmobic_afterAddress);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/address/myaddressbycustomer.tpl';
        $content =  $context->smarty->fetch($a);
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'chir' =>$presmobileapp->l('My Address'),
            'batitle' =>$batitle,
            'description' => strip_tags($db_meta[0]['description'])
        );
        echo json_encode($result);
        die;
    }
}
