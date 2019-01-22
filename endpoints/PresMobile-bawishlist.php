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

class BaWishList extends PresMobileApp
{
    public function __construct()
    {
    }
    public function start($arg)
    {
        $arg;
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $cart_r = $core->presMobicartresult();
        $controller = 'wishlist';
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $id_shop_group = Context::getContext()->shop->id_shop_group;
        $wishlist = array();
        if (Module::isInstalled("blockwishlist")) {
            $sql = "SELECT *FROM " . _DB_PREFIX_ . "wishlist ";
            $sql .= "WHERE id_shop=".(int)$id_shop." AND id_shop_group=".(int)$id_shop_group." ";
            $sql .= "AND id_customer=".(int)$cart_r['id_customer']."";
            $wishlist = $db->Executes($sql);
            foreach ($wishlist as $key => $value) {
                $quantity = 0;
                $sql_product = "SELECT *FROM " . _DB_PREFIX_ . "wishlist_product ";
                $sql_product .= "WHERE id_wishlist=".(int)$value['id_wishlist']." ";
                $wishlist_product = $db->Executes($sql_product);
                if (!empty($wishlist_product)) {
                    foreach ($wishlist_product as $key1 => $value1) {
                        $key1;
                        if ($value['id_wishlist'] == $value1['id_wishlist']) {
                            $quantity += $value1['quantity'];
                        }
                    }
                }
                $wishlist[$key]['quantity'] = $quantity;
                $wishlist[$key]['date'] = Tools::displayDate($value['date_add'], null);
            }
        }
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobic_beforeWishlist = $core->mobiexec172('presmobic_beforeWishlist', array());
            $presmobic_afterWishlist = $core->mobiexec172('presmobic_afterWishlist', array());
            $bawishlist = array('bawishlist'=>$wishlist);
            $presmobicGetDataWishlist = $core->mobiexec172('presmobicGetDataWishlist', $bawishlist);
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobic_beforeWishlist = $core->mobiexec17('presmobic_beforeWishlist', array());
            $presmobic_afterWishlist = $core->mobiexec17('presmobic_afterWishlist', array());
            $bawishlist = array('bawishlist'=>$wishlist);
            $presmobicGetDataWishlist = $core->mobiexec17('presmobicGetDataWishlist', $bawishlist);
        } else {
            $presmobic_beforeWishlist = $core->mobiexec('presmobic_beforeWishlist', array());
            $presmobic_afterWishlist = $core->mobiexec('presmobic_afterWishlist', array());
            $bawishlist = array('bawishlist'=>$wishlist);
            $presmobicGetDataWishlist = $core->mobiexec('presmobicGetDataWishlist', $bawishlist);
        }
        if (is_array($presmobicGetDataWishlist)) {
            $wishlist = $presmobicGetDataWishlist['bawishlist'];
        }
        $url = $core->getMobiBaseLink();
        $context->smarty->assign("wishlist", $wishlist);
        $context->smarty->assign("url", $url);
        $context->smarty->assign("presmobic_beforeWishlist", $presmobic_beforeWishlist);
        $context->smarty->assign("presmobic_afterWishlist", $presmobic_afterWishlist);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/wishlist/wishlist.tpl';
        $content =  $context->smarty->fetch($a);
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $check_setcache = $core->presMobisetcache($controller, $content);
        $check_setcache;
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'batitle' =>$shop_name,
            'description' => $shop_name
        );
        echo json_encode($result);
        die;
    }
}
