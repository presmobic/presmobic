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

class BaMyWishListById extends PresMobileApp
{
    public function __construct()
    {
        parent::__construct();
    }
    public function start($arg)
    {
        $presmobileapp = new PresMobileApp();
        $controller = 'mywishlistbyid';
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $context = Context::getContext();
        $id_wishlist = $arg[0];
        $id_shop = $context->shop->id;
        $id_lang = $context->language->id;
        $id_shop_group = Context::getContext()->shop->id_shop_group;
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $cart_r = $core->presMobicartresult();
        $sql = "SELECT *FROM " . _DB_PREFIX_ . "wishlist ";
        $sql .= "WHERE id_shop=".(int)$id_shop." AND id_shop_group=".(int)$id_shop_group." ";
        $sql .= "AND id_wishlist=".(int)$id_wishlist."";
        $wishlist = $db->Executes($sql);
        $sql_pro = "SELECT *FROM " . _DB_PREFIX_ . "wishlist_product ";
        $sql_pro .= "WHERE id_wishlist=".(int)$id_wishlist."";
        $product_wishlist = $db->Executes($sql_pro);
        $product = array();
        if (!empty($product_wishlist)) {
            foreach ($product_wishlist as $key => $value) {
                $product[$key]['id_product_wishlist'] = $value['id_wishlist_product'];
                $product[$key]['id_product'] = $value['id_product'];
                $product_a = new Product($value['id_product']);
                $combination = $product_a->getAttributeCombinationsById($value['id_product_attribute'], $id_lang);
                $attribute = '';
                if (!empty($combination)) {
                    foreach ($combination as $key1 => $value1) {
                        $key1;
                        $attribute .= $value1['attribute_name'].',';
                    }
                    $attribute = rtrim($attribute, ',');
                }
                $product[$key]['combi'] = $attribute;
                $product[$key]['name'] = $product_a->name[$id_lang];
                $product[$key]['quantity'] = $value['quantity'];
                $ca = $value['id_product'];
                $cb = $value['id_product_attribute'];
                $cc = $product_a->link_rewrite[$id_lang];
                $product[$key]['img'] = $this->getImagesproductattribute($id_lang, $ca, $cb, $cc);
                if (empty($product[$key]['img'])) {
                    $ra = $product_a->link_rewrite[$id_lang];
                    $product[$key]['img'] = $this->getlinkimageproduct($ra, $value['id_product']);
                }
                $product[$key]['priority'] = $value['priority'];
            }
        }
        $priority = array(
        1 =>$presmobileapp->l('Medium'),
        2=>$presmobileapp->l('Low'),
        0=>$presmobileapp->l('High')
        );
        $sql = "SELECT wpc.`quantity`,wpc.`date_add`,wp.`id_product`,wp.`id_product_attribute`";
        $sql .= " FROM " . _DB_PREFIX_ . "cart c";
        $sql .= " JOIN " . _DB_PREFIX_ . "wishlist_product_cart wpc";
        $sql .= " ON c.id_cart=wpc.id_cart";
        $sql .= " JOIN " . _DB_PREFIX_ . "wishlist_product wp";
        $sql .= " ON wpc.id_wishlist_product=wp.id_wishlist_product";
        $sql .= " WHERE c.id_customer=".(int)$cart_r['id_customer']."";
        $sql .= " AND c.id_shop=".(int)$id_shop."";
        $sql .= " AND c.id_lang=".(int)$id_lang."";
        $product_cart = $db->Executes($sql);
        $product_c = array();
        if (!empty($product_cart)) {
            foreach ($product_cart as $key => $value) {
                $product_c[$key]['id_product'] = $value['id_product'];
                $product_a = new Product($value['id_product']);
                $combination = $product_a->getAttributeCombinationsById($value['id_product_attribute'], $id_lang);
                $attribute = '';
                if (!empty($combination)) {
                    foreach ($combination as $key1 => $value1) {
                        $attribute .= $value1['attribute_name'].',';
                    }
                    $attribute = rtrim($attribute, ',');
                }
                $product_c[$key]['combi'] = $attribute;
                $product_c[$key]['name'] = $product_a->name[$id_lang];
                $product_c[$key]['quantity'] = $value['quantity'];
                $product_c[$key]['customerName'] = $cart_r['customerName'];
                $product_c[$key]['date'] = Tools::displayDate($value['date_add'], null);
                $aa = $value['id_product'];
                $ab = $value['id_product_attribute'];
                $ac = $product_a->link_rewrite[$id_lang];
                $product_c[$key]['img'] = $this->getImagesproductattribute($id_lang, $aa, $ab, $ac);
            }
        }
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobicBeforeWishlistById = $core->mobiexec172('presmobicBeforeWishlistById', array());
            $bap = array('baproductwish'=>$product);
            $presmobicGetDataProductWishlistById = $core->mobiexec172('presmobicGetDataProductWishlistById', $bap);
            $presmobicAfterWishlistById = $core->mobiexec172('presmobicAfterWishlistById', array());
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobicBeforeWishlistById = $core->mobiexec17('presmobicBeforeWishlistById', array());
            $bap = array('baproductwish'=>$product);
            $presmobicGetDataProductWishlistById = $core->mobiexec17('presmobicGetDataProductWishlistById', $bap);
            $presmobicAfterWishlistById = $core->mobiexec17('presmobicAfterWishlistById', array());
        } else {
            $presmobicBeforeWishlistById = $core->mobiexec('presmobicBeforeWishlistById', array());
            $bap = array('baproductwish'=>$product);
            $presmobicGetDataProductWishlistById = $core->mobiexec('presmobicGetDataProductWishlistById', $bap);
            $presmobicAfterWishlistById = $core->mobiexec('presmobicAfterWishlistById', array());
        }
        if (is_array($presmobicGetDataProductWishlistById)) {
            $product = $presmobicGetDataProductWishlistById['baproductwish'];
        }
        $context->smarty->assign("presmobicBeforeWishlistById", $presmobicBeforeWishlistById);
        $context->smarty->assign("presmobicAfterWishlistById", $presmobicAfterWishlistById);

        $context->smarty->assign("product", $product);
        $context->smarty->assign("product_c", $product_c);
        $context->smarty->assign("prioritya", $priority);
        $context->smarty->assign("wishlist", $wishlist);
        $context->smarty->assign("url", $url);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/wishlist/wishlistbyid.tpl';
        $content =  $context->smarty->fetch($a);
        $check_setcache = $core->presMobisetcache($controller.':'.$arg[0], $content);
        $check_setcache;
        $result = array(
        'controller' => $controller,
        'content' => $content,
        'chir' => $presmobileapp->l('Wishlist').' - '.$wishlist[0]['name']
        );
        echo json_encode($result);
        die;
    }
    public function getImagesproductattribute($id_language, $id_product, $id_product_attribute, $link_rew)
    {
        $images = new Image();
        $getimages = $images->getImages($id_language, $id_product, $id_product_attribute);
        $img = '';
        if (!empty($getimages)) {
            foreach ($getimages as $key => $value) {
                $key;
                $img = $this->getlinkimageproduct($link_rew, $value['id_image']);
            }
        }
        return $img;
    }
    public function getlinkimageproduct($link_rew, $id_img)
    {
        $linkimages = new Link();
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $type_img = ImageType::getFormattedName('presmobic');
        } else {
            $type_img = ImageType::getFormatedName('presmobic');
        }
        $link_img = Tools::getShopProtocol() . $linkimages->getImageLink($link_rew, $id_img, $type_img);
        return $link_img;
    }
}
