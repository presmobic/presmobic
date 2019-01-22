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

class BaContact extends PresMobileApp
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
        $controller = 'contact';
        $context = Context::getContext();
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $id_lang = $context->language->id;
        $id_shop = $context->shop->id;
        $contact = new ContactCore();
        $contact = $contact::getContacts($id_lang);
        $login_check = $core->presMobicartresult();
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
        $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=3";
        $db_meta = $db->Executes($sql_meta);
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobicBeforeContacUs = $core->mobiexec172('presmobicBeforeContacUs', array());
            $presmobicAfterContacUs = $core->mobiexec172('presmobicAfterContacUs');
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobicBeforeContacUs = $core->mobiexec17('presmobicBeforeContacUs', array());
            $presmobicAfterContacUs = $core->mobiexec17('presmobicAfterContacUs');
        } else {
            $presmobicBeforeContacUs = $core->mobiexec('presmobicBeforeContacUs', array());
            $presmobicAfterContacUs = $core->mobiexec('presmobicAfterContacUs');
        }
        $context->smarty->assign("presmobicBeforeContacUs", $presmobicBeforeContacUs);
        $context->smarty->assign("presmobicAfterContacUs", $presmobicAfterContacUs);
        $context->smarty->assign("contact", $contact);
        $context->smarty->assign("login_check", $login_check);
        $context->smarty->assign("url", $url);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/contact/contact.tpl';
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
