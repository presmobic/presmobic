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

class BaMerchandiseReturns extends PresMobileApp
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
        $id_shop = $context->shop->id;
        $id_lang = $context->language->id;
        $presmobileapp = new PresMobileApp();
        $controller = 'merchandisereturns';
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $check_cache = $core->presMobicheckcache($controller);
        $check_cache;
        $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
        $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=19";
        $db_meta = $db->Executes($sql_meta);
        $presmobileapp = new PresMobileApp();
        $cart = $core->presMobicartresult();
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $orderreturn = new OrderReturn();
        $return = $orderreturn->getOrdersReturn($cart['id_customer']);
        if (!empty($return)) {
            foreach ($return as $key => $value) {
                $return[$key]['date'] = Tools::displayDate($value['date_upd'], null);
            }
        }
        $context->smarty->assign("return", $return);
        $context->smarty->assign("url", $url);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/merchandisereturns/merchandisereturns.tpl';
        $content =  $context->smarty->fetch($a);
        $check_setcache = $core->presMobisetcache($controller, $content);
        $check_setcache;
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'chir' =>$presmobileapp->l('Return Merchandise Authorization (RMA)'),
            'batitle' =>$db_meta[0]['title'].' - '.$shop_name,
            'description' => strip_tags($db_meta[0]['description'])
        );
        echo json_encode($result);
        die;
    }
}
