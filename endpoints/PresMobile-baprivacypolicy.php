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

class Baprivacypolicy extends PresMobileApp
{
    public function __construct()
    {
    }
    public function start($arg)
    {
        $arg;
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $url_fodel = _PS_MODULE_DIR_;
        $controller = 'privacypolicy';
        $context = Context::getContext();
        $id_lang = $context->language->id;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $presmobileapp = new PresMobileApp();
        $cache_add = Configuration::get('cache_add');
        if ($cache_add == 1) {
            $check_cache = $core->presMobicheckcache($controller);
            if ($check_cache != '') {
                $result = array(
                    'controller' => $controller,
                    'content' => $check_cache,
                    'batitle' =>$presmobileapp->l('Privacy policy - ').$shop_name,
                    'description' =>  $presmobileapp->l('Privacy policy - ').$shop_name
                );
                echo json_encode($result);
                die;
            }
        }
        $footer_block = '';
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE active=1 ";
        $sql .= "AND hook LIKE '%footer%' ORDER BY position ASC";
        $param_footer = $db->Executes($sql);
        foreach ($param_footer as $key => $value) {
            $key;
            $file_cut = str_replace(array('block-', '.php'), '', $value['file']);
            include_once($url_fodel.'presmobileapp/blocks/'.$value['file']);
            $html_block = new $file_cut();
            $footer_block .= $html_block->render();
        }
        $term = "SELECT * FROM " . _DB_PREFIX_ . "cms_lang WHERE id_cms =2";
        $term .= " AND id_lang=".(int)$id_lang."";
        $content = $db->Executes($term);
        $context->smarty->assign("content", $content);
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $context->smarty->assign("url", $url);
        $context->smarty->assign('footer', $footer_block);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/privacypolicy/privacypolicy.tpl';
        $content =  $context->smarty->fetch($a);
        $check_setcache = $core->presMobisetcache($controller, $content);
        $check_setcache;
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'batitle' =>$presmobileapp->l('Privacy policy - ').$shop_name,
            'description' => $presmobileapp->l('Privacy policy - ').$shop_name
        );
        echo json_encode($result);
        die;
    }
}
