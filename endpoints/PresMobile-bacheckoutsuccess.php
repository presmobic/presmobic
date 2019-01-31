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

class BaCheckOutSuccess extends PresMobileApp
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
        $controller = 'checkoutsuccess';
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $id_lang = $context->language->id;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        include_once($url_fodel.'presmobileapp/configs/defines.inc.php');
        $core = new BaCore();
        $id_order = $arg[0];
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=25";
            $db_meta = $db->Executes($sql_meta);
            $batitle = $db_meta[0]['title'];
        } else {
            $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=26";
            $db_meta = $db->Executes($sql_meta);
            $batitle = $db_meta[0]['title'].' - '.$shop_name;
        }
        $hook_displayOrderConfirmation = array(
            'mobic_id_order' =>$id_order
        );
        $hook_displayPaymentReturn = '';
        $price_total = Tools::displayPrice(0);
        $context->smarty->assign("url", $url);
        $context->smarty->assign("hook_displayOrderConfirmation", $hook_displayOrderConfirmation);
        $context->smarty->assign("hook_displayPaymentReturn", $hook_displayPaymentReturn);
        $context->smarty->assign("id_order", $id_order);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/checkout/success.tpl';
        $content =  $context->smarty->fetch($a);
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'chir' => $id_order,
            'batitle' => $batitle,
            'description' => strip_tags('Order Confirmation'),
            'price_total' => $price_total
        );
        echo json_encode($result);
        die;
    }
}
