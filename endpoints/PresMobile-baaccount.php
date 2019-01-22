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

class Baaccount extends PresMobileApp
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
        $context = Context::getContext();
        $controller = 'account';
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        include_once($url_fodel.'presmobileapp/configs/defines.inc.php');
        $core = new BaCore();
        $cart = $core->presMobicartresult();
        $preslanguage = Language::getLanguages(true);
        $id_lang_default = $context->cookie->id_lang;
        $name_language_default = $context->language->name;
        $id_shop = $context->shop->id;
        $lists_currency = Currency::getCurrencies();
        $id_currency_default = $context->currency->id;
        $code_currency_default = $context->currency->iso_code;
        $hook_array = (array)Tools::jsonDecode(_PS_MOBIC_HOOK_);
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $ac = $hook_array['displayCustomerAccount'];
            $hook_displayCustomerAccount = $core->mobiexec172('displayCustomerAccount', array(), $ac);
            $presmobic_afteraccountSetting = $core->mobiexec172('presmobic_afteraccountSetting', array());
            $presmobic_beforeaccountSetting = $core->mobiexec172('presmobic_beforeaccountSetting', array());
            $presmobic_beforeaccountInfomartion = $core->mobiexec172('presmobic_beforeaccountInfomartion', array());
            $presmobic_afteraccountInfomartion = $core->mobiexec172('presmobic_afteraccountInfomartion', array());
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $ab = $hook_array['displayCustomerAccount'];
            $hook_displayCustomerAccount = $core->mobiexec17('displayCustomerAccount', array(), $ab);

            $presmobic_afteraccountSetting = $core->mobiexec17('presmobic_afteraccountSetting', array());
            $presmobic_beforeaccountSetting = $core->mobiexec17('presmobic_beforeaccountSetting', array());
            $presmobic_beforeaccountInfomartion = $core->mobiexec17('presmobic_beforeaccountInfomartion', array());
            $presmobic_afteraccountInfomartion = $core->mobiexec17('presmobic_afteraccountInfomartion', array());
        } else {
            $aa = $hook_array['displayCustomerAccount'];
            $hook_displayCustomerAccount = $core->mobiexec('displayCustomerAccount', array(), $aa);

            $presmobic_afteraccountSetting = $core->mobiexec('presmobic_afteraccountSetting', array());
            $presmobic_beforeaccountSetting = $core->mobiexec('presmobic_beforeaccountSetting', array());
            $presmobic_beforeaccountInfomartion = $core->mobiexec('presmobic_beforeaccountInfomartion', array());
            $presmobic_afteraccountInfomartion = $core->mobiexec('presmobic_afteraccountInfomartion', array());
        }

        $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang_default." ";
        $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=18";
        $db_meta = $db->Executes($sql_meta);

        $context->smarty->assign("presmobic_afteraccountSetting", $presmobic_afteraccountSetting);
        $context->smarty->assign("presmobic_beforeaccountSetting", $presmobic_beforeaccountSetting);
        $context->smarty->assign("presmobic_beforeaccountInfomartion", $presmobic_beforeaccountInfomartion);
        $context->smarty->assign("presmobic_afteraccountInfomartion", $presmobic_afteraccountInfomartion);
        $context->smarty->assign("hook_displayCustomerAccount", $hook_displayCustomerAccount);
        $context->smarty->assign("language", $preslanguage);
        $context->smarty->assign("languagedefault", $id_lang_default);
        $context->smarty->assign("currency", $lists_currency);
        $context->smarty->assign("currencydefault", $id_currency_default);
        $context->smarty->assign("code_currencydefault", $code_currency_default);
        $context->smarty->assign("name_language_default", $name_language_default);
        $context->smarty->assign("cart", $cart);
        $context->smarty->assign("url", $url);
        $context->smarty->assign("cart_customer", $cart);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/account/account.tpl';
        $content =  $context->smarty->fetch($a);
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'batitle' =>$db_meta[0]['title'].' - '.$shop_name,
            'description' => strip_tags($db_meta[0]['description'])
        );
        echo json_encode($result);
        die;
    }
}
