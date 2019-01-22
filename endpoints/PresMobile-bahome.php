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

class BaHome extends PresMobileApp
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
        $presmobileapp;
        $controller = 'home';
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $linkimages = new Link();
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $is_shop = $context->shop->id;
        $cache_add = Configuration::get('cache_add');
        if ($cache_add == 1) {
            $check_cache = $core->presMobicheckcache($controller);
            if ($check_cache != '') {
                $result = array(
                    'controller' => $controller,
                    'content' => $check_cache
                );
                echo json_encode($result);
                die;
            }
        }
        include_once($url_fodel.'presmobileapp/includes/Presmobic-mobiledetect.php');
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE active=1 ";
        $sql .= "AND hook LIKE '%header%' ORDER BY position ASC";
        $param_header = $db->Executes($sql);
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE active=1 AND ";
        $sql .= "hook LIKE '%content%' ORDER BY position ASC";
        $param_content = $db->Executes($sql);
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE active=1 ";
        $sql .= "AND hook LIKE '%footer%' ORDER BY position ASC";
        $param_footer = $db->Executes($sql);
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE active=1 ";
        $sql .= "AND hook LIKE '%PresMobisearchProduct%' ORDER BY position ASC";
        $param_PresMobisearchProduct = $db->Executes($sql);
        $header_block = '';
        $content_block = '';
        $footer_block = '';
        $PresMobisearchProduct_block = '';
        foreach ($param_header as $key => $value) {
            $file_cut = str_replace(array('block-', '.php'), '', $value['file']);
            include_once($url_fodel.'presmobileapp/blocks/'.$value['file']);
            $html_block = new $file_cut();
            $header_block .= $html_block->render();
        }
        foreach ($param_content as $key => $value) {
            $file_cut = str_replace(array('block-', '.php'), '', $value['file']);
            include_once($url_fodel.'presmobileapp/blocks/'.$value['file']);
            $html_block = new $file_cut();
            $content_block .= $html_block->render();
        }
        foreach ($param_footer as $key => $value) {
            $file_cut = str_replace(array('block-', '.php'), '', $value['file']);
            include_once($url_fodel.'presmobileapp/blocks/'.$value['file']);
            $html_block = new $file_cut();
            $footer_block .= $html_block->render();
        }
        foreach ($param_PresMobisearchProduct as $key => $value) {
            $file_cut = str_replace(array('block-', '.php'), '', $value['file']);
            include_once($url_fodel.'presmobileapp/blocks/'.$value['file']);
            $html_block = new $file_cut();
            $PresMobisearchProduct_block .= $html_block->render();
        }
        $core = new BaMobileDetect();
        $url = Tools::getShopProtocol() . Tools::getServerName() . __PS_BASE_URI__;
        $sql2 = "SELECT * FROM " . _DB_PREFIX_ . "category p JOIN " . _DB_PREFIX_ . "category_lang pl";
        $sql2 .= " ON p.id_category=pl.id_category";
        $sql2 .= " WHERE p.level_depth=2 AND pl.id_shop=".(int)$is_shop." AND pl.id_lang=".(int)$id_lang."";
        $data = $db->Executes($sql2);
        foreach ($data as $key => $value) {
            $img = $linkimages->getCatImageLink('category', $value['id_category']);
            if (file_exists(_PS_CAT_IMG_DIR_.(int)$value['id_category'].'.jpg')) {
                $data[$key]['link_img'] = strstr($img, 'img/c');
            } else {
                $data[$key]['link_img'] = 'modules/presmobileapp/views/img/backgroundnoimg.png';
            }
        }
        $context = Context::getContext();
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $cart = $core->presMobicartresult();
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $rtl = new Language($id_lang);
        $rtl = $rtl->is_rtl;
        $token = $this->cookiekeymodule();
        $context->smarty->assign("cart", $cart);
        $this->context->smarty->assign('rtl', $rtl);
        $this->context->smarty->assign('header', $header_block);
        $this->context->smarty->assign('content', $content_block);
        $this->context->smarty->assign('footer', $footer_block);
        $this->context->smarty->assign('PresMobisearchProduct', $PresMobisearchProduct_block);
        $this->context->smarty->assign('baseDir', $url);
        $this->context->smarty->assign('token', $token);
        $context->smarty->assign("category", $data);
        $context->smarty->assign("url", $url);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/home/home.tpl';
        $content =  $context->smarty->fetch($a);
        $check_setcache = $core->presMobisetcache($controller, $content);
        $check_setcache;
        $result = array(
            'controller' => $controller,
            'batitle' => $shop_name,
            'content' => $content
        );
        echo json_encode($result);
        die;
    }
}
