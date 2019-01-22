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

class Balatest extends PresMobileApp
{
    public function __construct()
    {
        parent::__construct();
    }
    public function start($arg)
    {
        $presmobileapp = new PresMobileApp();
        $controller = 'latest';
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $sql_category = "";
        $sql_where = "";
        $key_category = 0;
        if (!empty($arg)) {
            foreach ($arg as $key => $value) {
                $key_category =  $value;
                $sql_category .= " LEFT JOIN "._DB_PREFIX_."category_product";
                $sql_category .= " ON "._DB_PREFIX_."order_detail.product_id ";
                $sql_category .= "= "._DB_PREFIX_."category_product.id_product";
                $sql_where .= "AND "._DB_PREFIX_."category_product.id_category=".(int)$value."";
            }
        }
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $id_lang = $context->language->id;
        $cart_r = new Cart($context->cart->id);
        $product_cart = $cart_r->getProducts();
        $order = new Order();
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $order_detail = $order->getProducts();
        $order_detail;
        $id_category = $context->cookie->id_category_lastest;
        if ($id_category == '0') {
            $id_category = 2;
        }
        $cache_add = Configuration::get('cache_add');
        if ($cache_add == 1) {
            $check_cache = $core->presMobicheckcache($controller.':'.$id_category);
            if ($check_cache != '') {
                $result = array(
                    'controller' => $controller,
                    'content' => $check_cache,
                    'chir' => $presmobileapp->l('Lastest')
                );
                echo json_encode($result);
                die;
            }
        }
        $aa = 'ORDER BY product_shop.date_upd DESC';
        $product = $core->presMobigetProduct($id_shop, $id_lang, '', $aa, 'limit 0,6', (int)$id_category);
        $context->cookie->{'id_category_lastest'} = 0;
        ;
        if (!empty($product)) {
            foreach ($product as $key => $value) {
                $product[$key]['checkcart'] = 0;
                if (!empty($product_cart)) {
                    foreach ($product_cart as $key_cart => $value_cart) {
                        $key_cart;
                        if ($value_cart['id_product'] == $value['id_product']) {
                            $product[$key]['checkcart'] = 1;
                        }
                    }
                }
                $product[$key]['link_img'] = $this->getlinkimageproduct($value['link_rewrite'], $value['id_product']);
                $attr = Product::getProductAttributesIds($value['id_product']);
                if (empty($attr)) {
                    $product[$key]['count_attr'] = 0;
                } else {
                    $product[$key]['count_attr'] = 1;
                }
                $product[$key]['total_price'] = Tools::displayPrice($value['price']);
                $product[$key]['price_new'] = Tools::displayPrice($value['price_without_reduction']);
            }
        }
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "category p JOIN " . _DB_PREFIX_ . "category_lang pl";
        $sql .= " ON p.id_category=pl.id_category";
        $sql .= " WHERE p.level_depth=2 AND pl.id_shop=".(int)$id_shop." AND pl.id_lang=".(int)$id_lang."";
        $data = $db->Executes($sql);
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $context->smarty->assign("url", $url);
        $context->smarty->assign("product", $product);
        $context->smarty->assign("key_category", $key_category);
        $context->smarty->assign("category", $data);
        $context->smarty->assign("count_product", count($product));
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/latest/latest.tpl';
        $content =  $context->smarty->fetch($a);
        $check_setcache = $core->presMobisetcache($controller.':'.$id_category, $content);
        $check_setcache;
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'chir' => $presmobileapp->l('Lastest')
        );
        echo json_encode($result);
        die;
    }
    public function getimage($id_product)
    {
        $image = Product::getCover((int)$id_product);
        $image = new Image($image['id_image']);
        $product_photo = _PS_BASE_URL_._THEME_PROD_DIR_.$image->getExistingImgPath().".jpg";
        return $product_photo;
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
