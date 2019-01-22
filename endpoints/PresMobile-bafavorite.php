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

class Bafavorite extends PresMobileApp
{
    public function __construct()
    {
    }
    public function start($arg)
    {
        $arg;
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $id_lang = $context->language->id;
        $cart = $core->presMobicartresult();
        $controller = 'favorite';
        $sql_where_product = "";
        $product = array();
        if (!empty($cart['favorite'])) {
            $id_product = "";
            foreach ($cart['favorite'] as $key => $value) {
                $key;
                $id_product .= $value['id_product'].',';
            }
            $id_product = rtrim($id_product, ',');
            $sql_where_product .= " AND p.`id_product` IN (".pSQL($id_product).")";
            $product = $core->presMobigetProduct($id_shop, $id_lang, $sql_where_product, '', 'LIMIT 0,1000', 2);
            foreach ($product as $key1 => $value1) {
                $aa = $value1['id_product'];
                $product[$key1]['link_img'] = $this->getlinkimageproduct($value1['link_rewrite'], $aa);
                $product[$key1]['total_price'] = Tools::displayPrice($value1['price']);
                $product[$key1]['cur_price'] = Tools::displayPrice($value1['price_without_reduction']);
            }
        }
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobic_beforeFavorite = $core->mobiexec172('presmobic_beforeFavorite', array());
            $presmobic_afterFavorite = $core->mobiexec172('presmobic_afterFavorite', array());
            $bap = array('baproductfo' => $product);
            $presmobicGetDataFavorite = $core->mobiexec172('presmobicGetDataFavorite', $bap);
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $bap = array('baproductfo' => $product);
            $presmobicGetDataFavorite = $core->mobiexec17('presmobicGetDataFavorite', $bap);
        } else {
            $presmobic_beforeFavorite = $core->mobiexec('presmobic_beforeFavorite', array());
            $presmobic_afterFavorite = $core->mobiexec('presmobic_afterFavorite', array());
            $bap = array('baproductfo' => $product);
            $presmobicGetDataFavorite = $core->mobiexec('presmobicGetDataFavorite', $bap);
        }
        if (is_array($presmobicGetDataFavorite)) {
            $product = $presmobicGetDataFavorite['baproductfo'];
        }
        $context->smarty->assign("presmobic_beforeFavorite", $presmobic_beforeFavorite);
        $context->smarty->assign("presmobic_afterFavorite", $presmobic_afterFavorite);
        $context->smarty->assign("product", $product);
        $context->smarty->assign("cart", $cart);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/favorite/favorite.tpl';
        $content = $context->smarty->fetch($a);
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $check_setcache = $core->presMobisetcache($controller, $content);
        $check_setcache;
        $result = array(
            'controller' => 'favorite',
            'batitle' =>$shop_name,
            'content' => $content,
            'chir' => 'Favorite'
        );
        echo json_encode($result);
        die;
    }
    public function getlinkimageproduct($link_rew, $id_product)
    {
        $linkimages = new Link();
        $image = Product::getCover((int)$id_product);
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $type_img = ImageType::getFormattedName('presmobic');
        } else {
            $type_img = ImageType::getFormatedName('presmobic');
        }
        $link_img = Tools::getShopProtocol() . $linkimages->getImageLink($link_rew, $image['id_image'], $type_img);
        return $link_img;
    }
}
