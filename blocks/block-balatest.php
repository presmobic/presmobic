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
        $this->name = "lastest";
        $this->version = "1.0.0";
        $this->hook = array('content');
        $this->displayName = $this->l('Latest Products');
        $this->description = $this->l('display products which sort by latest created date on Home page');
    }
    public function render($arg = array())
    {
        $context = Context::getContext();
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $sql_category = "";
        $sql_where = "";
        $key_category = 0;
        if (!empty($arg)) {
            foreach ($arg as $key => $value) {
                $context->cookie->{'id_category_lastest'} = $value;
                $key_category =  $value;
                $sql_category .= " LEFT JOIN "._DB_PREFIX_."category_product";
                $sql_category .= " ON "._DB_PREFIX_."order_detail.product_id ";
                $sql_category .= " = "._DB_PREFIX_."category_product.id_product ";
                $sql_where .= "AND "._DB_PREFIX_."category_product.id_category=".(int)$value."";
            }
        }
        $product = array();
        $id_shop = $context->shop->id;
        $id_lang = $context->language->id;
        $cart_r = new Cart($context->cart->id);
        $product_cart = $cart_r->getProducts();
        if (!empty($arg)) {
            foreach ($arg as $key => $value) {
                $ab = 'ORDER BY product_shop.date_upd DESC';
                $ac = 'limit 0,4 ';
                $product = $core->presMobigetProduct($id_shop, $id_lang, '', $ab, $ac, (int)$value);
            }
        } else {
            $aa = 'ORDER BY product_shop.date_upd DESC';
            $product = $core->presMobigetProduct($id_shop, $id_lang, '', $aa, 'limit 0,4 ', 2);
        }
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
        
        $checkaddcarthome = Configuration::get('PS_ATTRIBUTE_CATEGORY_DISPLAY');
        $checkaddcart = Configuration::get('PS_CATALOG_MODE');
        $context->smarty->assign("checkaddcart", $checkaddcart);
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        include_once($url_fodel.'presmobileapp/includes/Presmobic-bahook.php');
        $pres_hook = new Bahook();
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobicDisplayBeforeLatestTitle = $core->mobiexec172('presmobicDisplayBeforeLatestTitle', array());
            $presmobicDisplayAfterLatestTitle = $core->mobiexec172('presmobicDisplayAfterLatestTitle', array());
            $presmobicGetLatestCategoriesData = $core->mobiexec172('presmobicGetLatestCategoriesData', array());
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobicDisplayBeforeLatestTitle = $core->mobiexec17('presmobicDisplayBeforeLatestTitle', array());
            $presmobicDisplayAfterLatestTitle = $core->mobiexec17('presmobicDisplayAfterLatestTitle', array());
            $presmobicGetLatestCategoriesData = $core->mobiexec17('presmobicGetLatestCategoriesData', array());
        } else {
            $presmobicDisplayBeforeLatestTitle = $core->mobiexec('presmobicDisplayBeforeLatestTitle', array());
            $presmobicDisplayAfterLatestTitle = $core->mobiexec('presmobicDisplayAfterLatestTitle', array());
            $presmobicGetLatestCategoriesData = $core->mobiexec('presmobicGetLatestCategoriesData', array());
        }
        $presmobicGetLatestCategoriesData = $pres_hook->presmobicGetLatestCategoriesData();
        $context->smarty->assign('presmobicDisplayBeforeLatestTitle', $presmobicDisplayBeforeLatestTitle);
        $context->smarty->assign('presmobicDisplayAfterLatestTitle', $presmobicDisplayAfterLatestTitle);
        $context->smarty->assign("checkaddcarthome", $checkaddcarthome);
        $context->smarty->assign("url", $url);
        $context->smarty->assign("product", $product);
        $context->smarty->assign("key_category", $key_category);
        $context->smarty->assign("category", $presmobicGetLatestCategoriesData);
        $context->smarty->assign("count_product", count($product));
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/block/latest.tpl';
        return $context->smarty->fetch($a);
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
        $context = Context::getContext();
        $linkimages = new Link();
        $image = Product::getCover((int)$id_product);
        if (empty($image)) {
            $base = Tools::getShopProtocol() . Tools::getServerName();
            $iso_lang = $context->language->iso_code;
            $size = 'small_'.'default';
            $no_img = $iso_lang.'-default-';
            $link_img = $base._THEME_PROD_DIR_.$no_img.$size.".jpg";
        } else {
            if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
                $type_img = ImageType::getFormattedName('presmobic');
            } else {
                $type_img = ImageType::getFormatedName('presmobic');
            }
            $link_img = Tools::getShopProtocol() . $linkimages->getImageLink($link_rew, $image['id_image'], $type_img);
        }
        return $link_img;
    }
}
