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

class BaTermsOfUse extends PresMobileApp
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
        $controller = 'termsofuse';
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
                    'batitle' =>$presmobileapp->l('Terms and conditions of use - ').$shop_name,
                    'description' => $presmobileapp->l('Terms and conditions of use - ').$shop_name
                );
                echo json_encode($result);
                die;
            }
        }
        $term = "SELECT * FROM " . _DB_PREFIX_ . "cms_lang WHERE id_cms =3";
        $term .= " AND id_lang=".(int)$id_lang."";
        $content = $db->Executes($term);
        $context->smarty->assign("content", $content);
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $context->smarty->assign("url", $url);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/termsofuse/termsofuse.tpl';
        $content =  $context->smarty->fetch($a);
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'batitle' =>$presmobileapp->l('Terms and conditions of use - ').$shop_name,
            'description' => $presmobileapp->l('Terms and conditions of use - ').$shop_name
        );
        echo json_encode($result);
        die;
    }
}
