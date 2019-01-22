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

class BasearchProduct extends PresMobileApp
{
    public function __construct()
    {
        $this->name = "searchProduct";
        $this->version = "1.0.0";
        $this->hook = array('searchProduct');
        $this->displayName = $this->l('Search in Header Bar');
        $this->description = $this->l('display Search field in header on Search page');
    }
    public function render($arg = array())
    {
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $context = Context::getContext();
        $cart_r = new Cart($context->cart->id);
        $product_cart = $cart_r->getProducts();
        $id_shop = $context->shop->id;
        $id_lang = $context->language->id;
        $id_shop_group = $context->shop->id_shop_group;
        $data = array();
        $id_product = '';
        if (!empty($arg)) {
            foreach ($arg as $key => $value) {
                $sql = "SELECT *FROM "._DB_PREFIX_."product_lang pl";
                $sql .= " LEFT JOIN "._DB_PREFIX_."product p ON pl.id_product=p.id_product";
                $sql .= " WHERE pl.id_shop=".(int)$id_shop."";
                $sql .= " AND pl.id_lang=".(int)$id_lang."";
                $sql .= " AND pl.name LIKE '%".pSQL($value)."%'";
                $data = $db->Executes($sql);
            }
        }
        $countsearch = count($data);
        $date = date("Y-m-d H:i:s");
        if ($countsearch == 0) {
            $sql = "INSERT INTO "._DB_PREFIX_."statssearch (id_statssearch,id_shop,id_shop_group,keywords,results ";
            $sql .= " ,date_add) VALUES ('',".(int)$id_shop.",".(int)$id_shop_group.",'".pSQL($arg[0])."'";
            $sql .= " ,".(int)$countsearch.",'".pSQL($date)."')";
            $db->query($sql);
        } else {
            for ($i=0; $i < 2; $i++) {
                $sql = "INSERT INTO "._DB_PREFIX_."statssearch (id_statssearch,id_shop,id_shop_group,keywords,results ";
                $sql .= " ,date_add) VALUES ('',".(int)$id_shop.",".(int)$id_shop_group.",'".pSQL($arg[0])."'";
                $sql .= " ,".(int)$countsearch.",'".pSQL($date)."')";
                $db->query($sql);
            }
        }
        $product = array();
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $id_product .= $value['id_product'].',';
            }
            $id_product = rtrim($id_product, ',');
            $sql_where_product = '';
            $sql_where_product .= " AND p.`id_product` IN (".pSQL($id_product).")";
            $product = $core->presMobigetProduct($id_shop, $id_lang, $sql_where_product, '', 'LIMIT 0,6', 2);
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
                    $aa =  $value['id_product'];
                    $product[$key]['link_img'] = $this->getlinkimageproduct($value['link_rewrite'], $aa);
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
        }
        $checkaddcart = Configuration::get('PS_CATALOG_MODE');
        $context->smarty->assign("checkaddcart", $checkaddcart);
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $context->smarty->assign('url', $url);
        $context->smarty->assign("product", $product);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/block/searchproduct.tpl';
        return $context->smarty->fetch($a);
    }
    public function getlinkimageproduct($link_rew, $id_product)
    {
        $linkimages = new Link();
        $image = Product::getCover((int)$id_product);
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $type_img = ImageType::getFormattedName('home');
        } else {
            $type_img = ImageType::getFormatedName('home');
        }
        $link_img = Tools::getShopProtocol() . $linkimages->getImageLink($link_rew, $image['id_image'], $type_img);
        return $link_img;
    }
}
