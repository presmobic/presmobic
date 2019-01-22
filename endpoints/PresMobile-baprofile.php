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

class Baprofile extends PresMobileApp
{
    public function __construct()
    {
        parent::__construct();
    }
    public function start($arg)
    {
        $arg;
        $context = Context::getContext();
        $presmobileapp = new PresMobileApp();
        $controller = 'profile';
        $url_fodel = _PS_MODULE_DIR_;
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $cart = $core->presMobicartresult();
        $year = date('Y');
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $id_shop = $context->shop->id;
        $id_lang = $context->language->id;
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=11";
            $db_meta = $db->Executes($sql_meta);
            $batitle = $db_meta[0]['title'];
        } else {
            $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=17";
            $db_meta = $db->Executes($sql_meta);
            $batitle = $db_meta[0]['title'].' - '.$shop_name;
        }
        $b2b_enable = Configuration::get('PS_B2B_ENABLE');
        $context->smarty->assign("b2b_enable", $b2b_enable);
        $context->smarty->assign("year", $year);
        $context->smarty->assign("url", $url);
        $birthday = $cart['birthday'];
        $birthday = explode("-", $birthday);
        $cart['birthday'] = $birthday ;
        $context->smarty->assign("cart", $cart);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/profile/profile.tpl';
        $content =  $context->smarty->fetch($a);
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'batitle' =>$batitle,
            'chir' => $presmobileapp->l('Edit profile')
        );
        echo json_encode($result);
        die;
    }
}
