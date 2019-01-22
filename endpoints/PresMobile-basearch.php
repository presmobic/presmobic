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

class BaSearch extends PresMobileApp
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
        $id_lang = $context->language->id;
        $id_shop = $context->shop->id;
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        include_once($url_fodel.'presmobileapp/configs/defines.inc.php');
        $core = new BaCore();
        $bacart = $core->presMobicartresult();
        $presmobileapp = new PresMobileApp();
        $controller = 'search';
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $sql_search = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
        $sql_search .= "AND id_shop=".(int)$id_shop." AND id_meta=4";
        $search = $db->Executes($sql_search);
        $context->smarty->assign("url", $url);
        $context->smarty->assign("cart", $bacart);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/search/search.tpl';
        $content =  $context->smarty->fetch($a);
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'batitle' =>$presmobileapp->l('Search - ').$shop_name,
            'description' => strip_tags($search[0]['description'])
        );
        echo json_encode($result);
        die;
    }
}
