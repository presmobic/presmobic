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

class BaCategory extends PresMobileApp
{
    public function __construct()
    {
        parent::__construct();
    }
    public function start($arg)
    {
        $arg;
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $argument = Tools::getValue('argument');
        if ($argument != false) {
            $this->getcategorybyid();
        }
        $controller = 'category';
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $cache_add = Configuration::get('cache_add');
        if ($cache_add == 1) {
            $check_cache = $core->presMobicheckcache($controller);
            if ($check_cache != '') {
                $result = array(
                    'controller' => $controller,
                    'content' => $check_cache,
                    'chir' => 'Categories',
                    'batitle' => 'Categories - '.$shop_name,
                    'description' => 'Categories - '.$shop_name
                );
                echo json_encode($result);
                die;
            }
        }
        $linkimages = new Link();
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $is_shop = $context->shop->id;
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $sql2 = "SELECT * FROM " . _DB_PREFIX_ . "category p JOIN " . _DB_PREFIX_ . "category_lang pl";
        $sql2 .= " ON p.id_category=pl.id_category";
        $sql2 .= " WHERE p.level_depth=2 AND pl.id_shop=".(int)$is_shop." AND pl.id_lang=".(int)$id_lang."";
        $data = $db->Executes($sql2);
        foreach ($data as $key => $value) {
            $img = $linkimages->getCatImageLink('category', $value['id_category']);
            $data[$key]['link_img'] = strstr($img, 'img/c');
        }
        $cart_id = $context->cookie->id_cart;
        $cart = new Cart($cart_id);
        $productcart = $cart->getProducts(true);
        if (empty($productcart)) {
            $result = array(
                'total_product'=>0,
                'price'=>Tools::displayPrice(0)
            );
        } else {
            $cart = $context->cookie->premobileappcart;
            $result = (array)json_decode($cart);
        }
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobic_displayBeforeMainCategory = $core->mobiexec172('presmobic_displayBeforeMainCategory', array());
            $presmobic_displayAfterMainCategory = $core->mobiexec172('presmobic_displayAfterMainCategory', array());
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobic_displayBeforeMainCategory = $core->mobiexec17('presmobic_displayBeforeMainCategory', array());
            $presmobic_displayAfterMainCategory = $core->mobiexec17('presmobic_displayAfterMainCategory', array());
        } else {
            $presmobic_displayBeforeMainCategory = $core->mobiexec('presmobic_displayBeforeMainCategory', array());
            $presmobic_displayAfterMainCategory = $core->mobiexec('presmobic_displayAfterMainCategory', array());
        }
        $context->smarty->assign("presmobic_displayBeforeMainCategory", $presmobic_displayBeforeMainCategory);
        $context->smarty->assign("presmobic_displayAfterMainCategory", $presmobic_displayAfterMainCategory);
        $context->smarty->assign("category", $data);
        $context->smarty->assign("cart", $result);
        $context->smarty->assign("url", $url);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/categoryhome/categoryhome.tpl';
        $content =  $context->smarty->fetch($a);
        $check_setcache = $core->presMobisetcache($controller, $content);
        $check_setcache;
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'chir' => 'Categories',
            'batitle' => 'Categories - '.$shop_name,
            'description' => 'Categories - '.$shop_name
        );
        echo json_encode($result);
        die;
    }
    public function getcategorybyid()
    {
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        include_once($url_fodel.'presmobileapp/configs/defines.inc.php');
        $core = new BaCore();
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $id_shop = $context->shop->id;
        $category = new Category();
        $cart_r = new Cart($context->cart->id);
        $product_cart = $cart_r->getProducts();
        $argument = (int)Tools::getValue('argument');
        $checkbox_color = (string) Tools::getValue('checkbox_color');
        $checkbox_color_array = explode(",", $checkbox_color);
        $checkbox_size = (string) Tools::getValue('checkbox_size');
        $checkbox_size_array = explode(",", $checkbox_size);
        $rangemin = (int) Tools::getValue('rangemin');
        $rangemax = (int) Tools::getValue('rangemax');
        $sort_category = Tools::getValue('sort_category');
        $hook_array = array(
            'category_filter' => array(
                'checkbox_color_array' =>$checkbox_color_array,
                'checkbox_size_array' => $checkbox_size_array,
                'rangemin' => $rangemin,
                'rangemax' => $rangemax
            )
        );
        $sort_category_array = array(
            'category_sort' => $sort_category
        );
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobic_filterArray = $core->mobiexec172('presmobic_filterArray', $hook_array);
            $presmobic_sortArray = $core->mobiexec172('presmobic_sortArray', $sort_category_array);
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobic_filterArray = $core->mobiexec17('presmobic_filterArray', $hook_array);
            $presmobic_sortArray = $core->mobiexec17('presmobic_sortArray', $sort_category_array);
        } else {
            $presmobic_filterArray = $core->mobiexec('presmobic_filterArray', $hook_array);
            $presmobic_sortArray = $core->mobiexec('presmobic_sortArray', $sort_category_array);
        }
        if (is_array($presmobic_filterArray)) {
            $checkbox_color_array = $presmobic_filterArray['category_filter']['checkbox_color_array'];
            $checkbox_size_array = $presmobic_filterArray['category_filter']['checkbox_size_array'];
            $rangemin = $presmobic_filterArray['category_filter']['rangemin'];
            $rangemax = $presmobic_filterArray['category_filter']['rangemax'];
        }
        if (is_array($presmobic_sortArray)) {
            $sort_category = $presmobic_sortArray['category_sort'];
        }
        $controller = 'category:'.$argument.$checkbox_color.$checkbox_size.$rangemin.$rangemax.$sort_category;
        $sql_color = "";
        $sql_sort_category = "";
        $id_sort = 1;
        if ($sort_category != false) {
            $id_sort = $sort_category;
            if ($sort_category == '1') {
                $sql_sort_category .= "ORDER BY p.`id_product` DESC";
            }
            if ($sort_category == '4') {
                $sql_sort_category .= "ORDER BY pl.`name` ASC";
            }
            if ($sort_category == '5') {
                $sql_sort_category .= "ORDER BY pl.`name` DESC";
            }
        }
        if ($checkbox_color !=false) {
            $checkbox_color = rtrim($checkbox_color, ',');
            $sql_color = "pac.id_attribute IN(".pSQL($checkbox_color).") AND ";
        }
        if ($checkbox_size != false) {
            $checkbox_size = rtrim($checkbox_size, ',');
            if ($checkbox_color !=false) {
                $checkbox_color = $checkbox_color.','.$checkbox_size;
                $sql_color = "pac.id_attribute IN(".pSQL($checkbox_color).") AND";
            } else {
                $sql_color = "pac.id_attribute IN(".pSQL($checkbox_size).") AND";
            }
        }
        $sql_ranger_price = "";
        if ($rangemax != false) {
            if ($rangemin != false) {
                $sql_ranger_price .= " (p.price >=".(int)$rangemin." AND p.price <= ".(int)$rangemax." ) AND";
            } else {
                $sql_ranger_price .= " p.price <= ".(int)$rangemax." AND";
            }
        }
        $sub_category = $category->getNestedCategories($argument);
        $sub_category;
        $category_new = new Category($argument, $id_lang);
        $sub_leve = $category_new->getSubCategories($id_lang);
        $cache_add = Configuration::get('cache_add');
        if ($cache_add == 1) {
            $check_cache = $core->presMobicheckcache($controller);
            if ($check_cache != '') {
                $result = array(
                    'controller' => 'category',
                    'content' => $check_cache,
                    'chir' => $category_new->name,
                    'batitle' => $category_new->name.' - '.$shop_name,
                    'description' => strip_tags($category_new->description)
                );
                echo json_encode($result);
                die;
            }
        }
        $sql_catgory = "SELECT c.*, cl.* FROM " . _DB_PREFIX_ . "category c";
        $sql_catgory .= " INNER JOIN " . _DB_PREFIX_ . "category_shop category_shop";
        $sql_catgory .= " ON (category_shop.id_category = c.id_category AND category_shop.id_shop = ".(int)$id_shop.")";
        $sql_catgory .= " LEFT JOIN `" . _DB_PREFIX_ . "category_lang` cl ";
        $sql_catgory .= "ON c.`id_category` = cl.`id_category` AND cl.id_shop = ".(int)$id_shop."";
        $sql_catgory .= " RIGHT JOIN `" . _DB_PREFIX_ . "category` c2 ON c2.`id_category` = ".(int)$argument."";
        $sql_catgory .= " AND c.`nleft` >= c2.`nleft` AND c.`nright` <= c2.`nright`";
        $sql_catgory .= " WHERE 1  AND c.`active` = 1";
        $sql_catgory .= " GROUP BY c.`id_category`";
        $sql_catgory .= " ORDER BY c.`level_depth` ASC , category_shop.`position` ASC";
        $category_select = $db->Executes($sql_catgory);
        $id_category = '';
        foreach ($category_select as $key_c => $value_c) {
            $key_c;
            $id_category .= $value_c['id_category'].',';
        }
        $id_category = rtrim($id_category, ',');
        $sql_product = "SELECT DISTINCT p.id_product FROM `" . _DB_PREFIX_ . "product` p";
        $sql_product .= " INNER JOIN " . _DB_PREFIX_ . "product_lang pl ON p.`id_product` = p.id_product";
        $sql_product .= " LEFT JOIN " . _DB_PREFIX_ . "product_attribute pa ON pa.`id_product` = p.id_product";
        $sql_product .= " LEFT JOIN " . _DB_PREFIX_ . "product_attribute_combination pac";
        $sql_product .= " ON pac.`id_product_attribute` = pa.id_product_attribute";
        $sql_product .= " INNER JOIN " . _DB_PREFIX_ . "category_product cp ON cp.`id_product` = p.id_product";
        $sql_product .= " WHERE ".pSQL($sql_color)."";
        $sql_product .= " ".pSQL($sql_ranger_price)."";
        $sql_product .= " cp.id_category IN(".pSQL($id_category).")";
        $product_select = $db->Executes($sql_product);
        $sql_where_product = "";
        if (!empty($product_select)) {
            $id_product = "";
            foreach ($product_select as $key => $value) {
                $id_product .= $value['id_product'].',';
            }
            $id_product = rtrim($id_product, ',');
            $sql_where_product .= " AND p.`id_product` IN (".pSQL($id_product).")";
        }
        if ($id_sort == '2') {
            $ra = $sql_where_product;
            $rb = $sql_sort_category;
            $product = $core->presMobigetProduct($id_shop, $id_lang, $ra, $rb, 'LIMIT 0, 1000', $argument);
            uasort($product, 'lowestfirst');
        } elseif ($id_sort == '3') {
            $ra = $sql_where_product;
            $rb = $sql_sort_category;
            $product = $core->presMobigetProduct($id_shop, $id_lang, $ra, $rb, 'LIMIT 0, 1000', $argument);
            uasort($product, 'highestfirst');
        } else {
            $ra = $sql_where_product;
            $rb = $sql_sort_category;
            $product = $core->presMobigetProduct($id_shop, $id_lang, $ra, $rb, 'LIMIT 0,6', $argument);
        }
        $pricemax = 0;
        $pricemin = 0;
        $cart_check = $core->presMobicartresult();
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
                if ($cart_check['logged'] == '1') {
                    if (Module::isInstalled("favoriteproducts")) {
                        $select = "SELECT *FROM  " . _DB_PREFIX_ . "favorite_product ";
                        $select .= "WHERE id_product=".(int)$value['id_product']."";
                        $select .= " AND id_customer=".(int)$cart_check['id_customer']."";
                        $select .= " AND id_shop=".(int)$id_shop."";
                        $favorite = $db->Executes($select);
                    }
                    if (!empty($favorite)) {
                        $product[$key]['favorite'] = 1;
                    } else {
                        $product[$key]['favorite'] = 0;
                    }
                }
                $product[$key]['link_img'] = $this->getlinkimageproduct($value['link_rewrite'], $value['id_product']);
                $attr = Product::getProductAttributesIds($value['id_product']);
                if (empty($attr)) {
                    $product[$key]['count_attr'] = 0;
                } else {
                    $product[$key]['count_attr'] = 1;
                }
                $product[$key]['count_comment'] = array();
                $product[$key]['total_price'] = Tools::displayPrice($value['price']);
                $product[$key]['price_new'] = Tools::displayPrice($value['price_without_reduction']);
                if (Module::isInstalled("productcomments")) {
                    $query = "SELECT *FROM " . _DB_PREFIX_ . "product_comment ";
                    $query .= "WHERE validate='1' AND id_product='".(int)$value['id_product']."'";
                    $param = $db->ExecuteS($query);
                    if (!empty($param)) {
                        $product[$key]['count_comment'] = $param;
                    } else {
                        $product[$key]['count_comment'] = array();
                    }
                }
            }
        }
        $attribute_byid = array();
        $attribute_1 = array();
        $rate = 0;
        $attr1 = array();
        foreach ($product as $key_cm => $value_cm) {
            if (!empty($value_cm['count_comment'])) {
                foreach ($value_cm['count_comment'] as $key => $value) {
                    $rate += $value['grade'];
                }
                $product[$key_cm]['comment'] = round($rate/count($value_cm['count_comment']));
            } else {
                $product[$key_cm]['comment'] = 0;
            }
            $attribute_byid = $this->getvariations($value_cm['id_product'], $id_shop, $id_lang);
            if (!empty($attribute_byid)) {
                foreach ($attribute_byid as $key_a1 => $value_a1) {
                    $key_a1;
                    foreach ($value_a1 as $key_a2 => $value_a2) {
                        $key_a2;
                        $attr1[$value_a2['group']][] = $value_a2['name'];
                        $attribute_1 = $attr1;
                    }
                }
            } else {
                $attribute_1 = array();
            }
            $product[$key_cm]['attribute1'] = $attribute_1;
        }
        $attribute_2 = array();
        foreach ($product as $key_cm => $value_cm) {
            if (!empty($value_cm['attribute1'])) {
                foreach ($value_cm['attribute1'] as $key => $value) {
                    $attribute_2[$key] = array_unique($value, 0);
                    $attribute_2[$key] = implode(', ', $attribute_2[$key]);
                }
                $product[$key_cm]['attribute2'] = $attribute_2;
            } else {
                $product[$key_cm]['attribute2'] = array();
            }
            $product_favorite = array();
            $product[$key_cm]['product_favorite'] = 0;
            if (Module::isInstalled("favoriteproducts")) {
                $product_favorite = $this->checkfavorite($value_cm['id_product'], $id_shop);
            }
            if (!empty($product_favorite)) {
                $product[$key_cm]['product_favorite'] = 1;
            }
        }
        $product_price = new Product();
        $product_pricemax = $product_price->getProducts($id_lang, 0, 1000, 'price', 'DESC', $argument);
        if (!empty($product_pricemax)) {
            $tammax =  $product_pricemax[0]['price'];
            $min =  $product_pricemax[0]['price'];
            foreach ($product_pricemax as $key => $value) {
                if ($product_pricemax[$key]['price'] >= $tammax) {
                    $tammax = $product_pricemax[$key]['price'];
                    $pricemax = number_format($tammax, 2);
                }
                if ($min >= $product_pricemax[$key]['price']) {
                    $min = $product_pricemax[$key]['price'];
                    $pricemin = number_format($min, 2);
                }
            }
        }
        $product = array_values($product);
        $product_sort = array();
        if ($id_sort == '2' || $id_sort == '3') {
            for ($i= 0; $i <= 5; $i++) {
                if (array_key_exists($i, $product)) {
                    $product_sort[$i] = $product[$i];
                }
            }
            $product = array();
            $product = $product_sort;
        }
        $attribute = new Attribute();
        $atr = $attribute->getAttributes($id_lang);
        $attr_new = array();
        $attr_chir = array();
        foreach ($atr as $key_attr => $value_attr) {
            $key_attr;
            if ($value_attr['id_attribute_group'] == '1') {
                $attr_chir['name'] = $value_attr['name'];
                $attr_chir['id_attribute'] = $value_attr['id_attribute'];
                $attr_new[$value_attr['id_attribute_group']][] = $attr_chir;
            }
            if ($value_attr['id_attribute_group'] == '3') {
                $attr_chir['name'] = $value_attr['name'];
                $attr_chir['id_attribute'] = $value_attr['id_attribute'];
                $attr_new[$value_attr['id_attribute_group']][] = $attr_chir;
            }
        }
        $list_sort = array(
        1=> 'Time: Latest',
        2=> 'Price: Lowest first',
        3=> 'Price: Highest first',
        4=> 'Product Name: A to Z',
        5=> 'Product Name: Z to A'
        );
        $curency = new Currency($id_lang);
        $sign = $curency->getSign();
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $hook_array = (array)Tools::jsonDecode(_PS_MOBIC_HOOK_);
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $aa = 'displayProductListFunctionalButtons';
            $ab = $hook_array['displayProductListFunctionalButtons'];
            $hook_displayProductListFunctionalButtons = $core->mobiexec172($aa, array(), $ab);
            $presmobic_displayBeforeCategory = $core->mobiexec172('presmobic_displayBeforeCategory', array());
            $presmobic_displayAfterCategory = $core->mobiexec172('presmobic_displayAfterCategory', array());
            $presmobic_displayBeforeSubCategoryBar = $core->mobiexec172('presmobic_displayBeforeSubCategoryBar');
            $presmobic_displayBeforeFilterBar = $core->mobiexec172('presmobic_displayBeforeFilterBar', array());
            $presmobic_displayBeforeSortBar = $core->mobiexec172('presmobic_displayBeforeSortBar', array());
            $presmobic_displayBeforeLayoutBar = $core->mobiexec172('presmobic_displayBeforeLayoutBar', array());
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $aa = 'displayProductListFunctionalButtons';
            $ab = $hook_array['displayProductListFunctionalButtons'];
            $hook_displayProductListFunctionalButtons = $core->mobiexec17($aa, array(), $ab);
            $presmobic_displayBeforeCategory = $core->mobiexec17('presmobic_displayBeforeCategory', array());
            $presmobic_displayAfterCategory = $core->mobiexec17('presmobic_displayAfterCategory', array());
            $presmobic_displayBeforeSubCategoryBar = $core->mobiexec17('presmobic_displayBeforeSubCategoryBar');
            $presmobic_displayBeforeFilterBar = $core->mobiexec17('presmobic_displayBeforeFilterBar', array());
            $presmobic_displayBeforeSortBar = $core->mobiexec17('presmobic_displayBeforeSortBar', array());
            $presmobic_displayBeforeLayoutBar = $core->mobiexec17('presmobic_displayBeforeLayoutBar', array());
        } else {
            $aa = 'displayProductListFunctionalButtons';
            $ab = $hook_array['displayProductListFunctionalButtons'];
            $hook_displayProductListFunctionalButtons = $core->mobiexec($aa, array(), $ab);
            $presmobic_displayBeforeCategory = $core->mobiexec('presmobic_displayBeforeCategory', array());
            $presmobic_displayAfterCategory = $core->mobiexec('presmobic_displayAfterCategory', array());
            $presmobic_displayBeforeSubCategoryBar = $core->mobiexec('presmobic_displayBeforeSubCategoryBar', array());
            $presmobic_displayBeforeFilterBar = $core->mobiexec('presmobic_displayBeforeFilterBar', array());
            $presmobic_displayBeforeSortBar = $core->mobiexec('presmobic_displayBeforeSortBar', array());
            $presmobic_displayBeforeLayoutBar = $core->mobiexec('presmobic_displayBeforeLayoutBar', array());
        }
        $context->smarty->assign("presmobic_displayBeforeCategory", $presmobic_displayBeforeCategory);
        $context->smarty->assign("presmobic_displayAfterCategory", $presmobic_displayAfterCategory);
        $context->smarty->assign("hook_displayProductListFunctionalButtons", $hook_displayProductListFunctionalButtons);
        $context->smarty->assign("presmobic_displayBeforeSubCategoryBar", $presmobic_displayBeforeSubCategoryBar);
        $context->smarty->assign("presmobic_displayBeforeFilterBar", $presmobic_displayBeforeFilterBar);
        $context->smarty->assign("presmobic_displayBeforeSortBar", $presmobic_displayBeforeSortBar);
        $context->smarty->assign("presmobic_displayBeforeLayoutBar", $presmobic_displayBeforeLayoutBar);
        $context->smarty->assign("cart_check", $cart_check);
        $context->smarty->assign("url", $url);
        $context->smarty->assign("basort", $list_sort);
        $context->smarty->assign("id_sort", $id_sort);
        $context->smarty->assign("id_category_default", $argument);
        $context->smarty->assign("sign", $sign);
        $context->smarty->assign("sub_leve", $sub_leve);
        $context->smarty->assign("product", $product);
        $context->smarty->assign("attribute", $attr_new);
        $context->smarty->assign("pricemax", $pricemax);
        $context->smarty->assign("pricemin", $pricemin);
        $context->smarty->assign("rangemax", $rangemax);
        $context->smarty->assign("rangemin", $rangemin);
        $context->smarty->assign("checkbox_size_array", $checkbox_size_array);
        $context->smarty->assign("checkbox_color_array", $checkbox_color_array);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/category/category.tpl';
        $content = $context->smarty->fetch($a);
        $check_setcache = $core->presMobisetcache($controller, $content);
        $check_setcache;
        $result = array(
        'controller' => 'category',
        'content' => $content,
        'chir' => $category_new->name,
        'batitle' => $category_new->name.' - '.$shop_name,
        'description' => strip_tags($category_new->description)
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
    public function getvariations($id_product, $id_shop, $id_lang)
    {
        $attibute = $this->getAttributesParams($id_product, $id_shop, $id_lang);
        $new_attribute = array();
        $a = array();
        foreach ($attibute as $key => $value) {
            $key;
            $a['name'] =  $value['attribute_name'];
            $a['group'] =  $value['group_name'];
            $new_attribute[$value['id_pro']][] = $a;
        }
        $b = array_filter($new_attribute);
        $array = array_values($b);
        return $array;
    }
    public static function getAttributesParams($id_product, $id_shop, $id_lang)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $sql = "SELECT  pa.`id_product_attribute` AS id_pro,a.`id_attribute`";
        $sql .= " AS id_attribute,agl.`name` AS group_name, al.`name` AS attribute_name";
        $sql .= " FROM `" . _DB_PREFIX_ . "product_attribute` pa";
        $sql .= " INNER JOIN " . _DB_PREFIX_ . "product_attribute_shop product_attribute_shop";
        $sql .= " ON (product_attribute_shop.id_product_attribute ";
        $sql .= "= pa.id_product_attribute AND product_attribute_shop.id_shop = ".(int)$id_shop.")";
        $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "product_attribute_combination` pac ";
        $sql .= " ON pac.`id_product_attribute` = pa.`id_product_attribute`";
        $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "attribute` a ON a.`id_attribute` = pac.`id_attribute`";
        $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "attribute_group` ag ";
        $sql .= " ON ag.`id_attribute_group` = a.`id_attribute_group` ";
        $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "attribute_lang` al ";
        $sql .= "ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = ".(int)$id_lang.")";
        $sql .= " LEFT JOIN `" . _DB_PREFIX_ . "attribute_group_lang` agl ";
        $sql .= "ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = ".(int)$id_lang.")";
        $sql .= " WHERE pa.`id_product` = ".(int)$id_product."";
        $sql .= " GROUP BY pa.`id_product_attribute`, ag.`id_attribute_group`";
        $sql .= " ORDER BY pa.`id_product_attribute`";
        $result = $db->Executes($sql);
        return $result;
    }
    public function checkfavorite($id_product, $id_shop)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $select = "SELECT *FROM  " . _DB_PREFIX_ . "favorite_product WHERE id_product=".(int)$id_product."";
        $select .= " AND id_shop=".(int)$id_shop."";
        $favorite = $db->Executes($select);
        return $favorite;
    }
}
function lowestfirst($a, $b)
{
    if ($a['price_tax_exc'] == $b['price_tax_exc']) {
        return 0;
    } elseif ($a['price_tax_exc'] > $b['price_tax_exc']) {
        return 1;
    } elseif ($a['price_tax_exc'] < $b['price_tax_exc']) {
        return -1;
    }
}
function highestfirst($a, $b)
{
    if ($a['price_tax_exc'] < $b['price_tax_exc']) {
        return 1;
    } elseif ($a['price_tax_exc'] == $b['price_tax_exc']) {
        return 0;
    }
}
