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

class BaProduct extends PresMobileApp
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
        $id_product = (int)Tools::getValue('argument');
        $qtity = Product::getQuantity($id_product);
        $qtity;
        $presmobileapp = new PresMobileApp();
        $context = Context::getContext();
        $id_currency = $context->currency->id;
        $sign_currency_content = new Currency($id_currency);
        $sign_currency = $sign_currency_content->sign;
        $id_lang = $context->language->id;
        $id_shop = $context->shop->id;
        $controller = 'product';
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $product_a = new Product($id_product);
        $check_cache = $core->presMobicheckcache($controller.':'.$id_product);
        $check_cache;
        $active_wishlist = 0;
        $active_favorite = 0;
        $sql_where_product = " AND p.`id_product` IN (".pSQL($id_product).")";
        $sql_sort_category = '';
        $cy = $sql_where_product;
        $cu = $sql_sort_category;
        $product = $core->presMobigetProduct($id_shop, $id_lang, $cy, $cu, 'LIMIT 0,1000', 2);
        $cq = $product[0]['link_rewrite'];
        $cw = $product[0]['id_product'];
        $product[0]['link_img'] = $this->getlinkimageproduct($cq, $cw);
        $product[0]['img'] = $this->getlinkimageproductattr($id_lang, $cq, $cw);
        $product[0]['zoomimg'] = $this->getlinkimageproductattr($id_lang, $cq, $cw);
        $productzoom = array();
        foreach ($product[0]['zoomimg'] as $key => $value) {
            $productzoom[$key]['src'] = $value['image'];
            $size = getimagesize($value['image']);
            $productzoom[$key]['id'] = $value['id_image'];
            $productzoom[$key]['w'] = $size[0];
            $productzoom[$key]['h'] = $size[1];
            $productzoom[$key]['title'] = $value['legend'];
        }
        $product[0]['total_price'] = Tools::displayPrice($product[0]['price']);
        $product[0]['price_new'] = Tools::displayPrice($product[0]['price_without_reduction']);
        $param = array();
        $product[0]['count_comment'] = 0;
        $product[0]['grade_comment'] = 0;
        $attr = $this->getAttributesParams($id_product, $id_shop, $id_lang);
        $array_attr = array();
        foreach ($attr as $key => $value) {
            $key;
            $array_attr[$value['group_name']][$value['id_attribute']] = $value['attribute_name'];
        }
        $product[0]['attribute'] = $array_attr;
        if (Module::isInstalled("productcomments")) {
            $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
            $query = "SELECT *FROM " . _DB_PREFIX_ . "product_comment WHERE validate='1'";
            $query .= " AND id_product='".(int)$id_product."'";
            $param = $db->ExecuteS($query);
            if (!empty($param)) {
                $rate = 0;
                $product[0]['count_comment'] = count($param);
                foreach ($param as $key => $value) {
                    $rate += $value['grade'];
                }
                $product[0]['grade_comment'] = round($rate/$product[0]['count_comment']);
            }
        }
        $product[0]['comment'] = $param;
        $feature = $this->getproductfeature($id_lang, $id_product);
        $product[0]['feature'] = $feature;
        $sql_acces = "SELECT *FROM " . _DB_PREFIX_ . "accessory WHERE id_product_1=".(int)$id_product."";
        $param_acc = $db->Executes($sql_acces);
        $product_acce =  array();
        if (!empty($param_acc)) {
            $id_product_acc = '';
            foreach ($param_acc as $key_ac => $value_ac) {
                $key_ac;
                $id_product_acc .= $value_ac['id_product_2'].',';
            }
            $id_product_acc = rtrim($id_product_acc, ',');
            $sql_where_product_acc = " AND p.`id_product` IN (".pSQL($id_product_acc).")";
            $cd = $sql_where_product_acc;
            $cf = 'LIMIT 0,6';
            $cg = 'LIMIT 0,1000';
            $product_acce = $core->presMobigetProduct($id_shop, $id_lang, $cd, '', $cf, $cg, 2);
            foreach ($product_acce as $key_ac => $value_ac) {
                $product_acce[$key_ac]['grade_comment'] = 0;
                if (Module::isInstalled("productcomments")) {
                    $query = "SELECT *FROM " . _DB_PREFIX_ . "product_comment WHERE validate='1' ";
                    $query .= " AND id_product='".(int)$value_ac['id_product']."'";
                    $param = $db->ExecuteS($query);
                    $rate = 0;
                    $product_acce[$key_ac]['count_comment'] = count($param);
                    if (!empty($param)) {
                        foreach ($param as $key => $value) {
                            $rate += $value['grade'];
                        }
                        $product_acce[$key_ac]['grade_comment'] = round($rate/$product_acce[$key_ac]['count_comment']);
                    } else {
                        $product_acce[$key_ac]['grade_comment'] = 0;
                    }
                }
                $cm = $value_ac['link_rewrite'];
                $cs = $value_ac['id_product'];
                $product_acce[$key_ac]['link_img'] = $this->getlinkimageproduct($cm, $cs);
                $product_acce[$key_ac]['total_price'] = Tools::displayPrice($value_ac['price']);
                $product_acce[$key_ac]['price_new'] = Tools::displayPrice($value_ac['price_without_reduction']);
            }
        }
        //pack
        $sql_pack = "SELECT *FROM " . _DB_PREFIX_ . "pack WHERE id_product_pack=".(int)$id_product."";
        $param_pack = $db->Executes($sql_pack);
        $product_pack =  array();
        if (!empty($param_pack)) {
            $id_product_acc = '';
            foreach ($param_pack as $key_ac => $value_ac) {
                $key_ac;
                $id_product_acc .= $value_ac['id_product_item'].',';
            }
            $id_product_acc = rtrim($id_product_acc, ',');
            $sql_where_product_acc = " AND p.`id_product` IN (".pSQL($id_product_acc).")";
            $product_pack = $core->presMobigetProduct($id_shop, $id_lang, $sql_where_product_acc, '', 'LIMIT 0,6', 2);
            if (Module::isInstalled("productcomments")) {
                $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
                foreach ($product_pack as $key_ac => $value_ac) {
                    $product_pack[$key_ac]['grade_comment'] = 0;
                    if (Module::isInstalled("productcomments")) {
                        $query = "SELECT *FROM " . _DB_PREFIX_ . "product_comment ";
                        $query .= "WHERE validate='1' ";
                        $query .= "AND id_product='".(int)$value_ac['id_product']."'";
                        $param = $db->ExecuteS($query);
                        $rate_pack = 0;
                        $product_pack[$key_ac]['count_comment'] = count($param);
                        if (!empty($param)) {
                            foreach ($param as $key => $value) {
                                $rate_pack += $value['grade'];
                            }
                            $ck = round($rate_pack/$product_pack[$key_ac]['count_comment']);
                            $product_pack[$key_ac]['grade_comment'] = $ck;
                        } else {
                            $product_pack[$key_ac]['grade_comment'] = 0;
                        }
                    }
                }
            }
        }
        foreach ($product_pack as $key_new => $value_new) {
            $key_new;
            $attibute = $this->getAttributesParams($value_new['id_product'], $id_shop, $id_lang);
            if (!empty($attibute)) {
                $product_pack[$key_new]['count_attr'] = 1;
            } else {
                $product_pack[$key_new]['count_attr'] = 0;
            }
            $cb = $value_new['link_rewrite'];
            $cn = $value_new['id_product'];
            $product_pack[$key_new]['link_img'] = $this->getlinkimageproduct($cb, $cn);
            $product_pack[$key_new]['total_price'] = Tools::displayPrice($value_new['price']);
            $product_pack[$key_new]['price_new'] = Tools::displayPrice($value_new['price_without_reduction']);
        }
        $id_default_attribute = (int)Product::getDefaultAttribute($id_product);
        $product_sql_attr = "SELECT *FROM " . _DB_PREFIX_ . "product_attribute_combination ";
        $product_sql_attr .= "WHERE id_product_attribute='".(int)$id_default_attribute."'";
        $param_attribute = $db->Executes($product_sql_attr);
        $demo = array();
        $demo2 = array();
        $check_attribute = array();
        if (!empty($param_attribute)) {
            foreach ($param_attribute as $key_ca => $value_ca) {
                $check_attribute[$key_ca] = $value_ca['id_attribute'];
            }
            $product[0]['attribute_default'] = $check_attribute;
            if (Tools::version_compare(_PS_VERSION_, '1.6.1', '<=')) {
                $sql1 = "SELECT * FROM `" . _DB_PREFIX_ . "product_attribute`";
                $sql1 .= " JOIN " . _DB_PREFIX_ . "product_attribute_shop ON ";
                $sql1 .= "" . _DB_PREFIX_ . "product_attribute.id_product_attribute=";
                $sql1 .= "" . _DB_PREFIX_ . "product_attribute_shop.id_product_attribute ";
                $sql1 .= " WHERE " . _DB_PREFIX_ . "product_attribute_shop.id_shop=";
                $sql1 .= "'" . (int)$id_shop . "'";
                $sql1 .= " AND " . _DB_PREFIX_ . "product_attribute.id_product=";
                $sql1 .= "'" . (int)$id_product . "'";
                $param1 = $db->Executes($sql1);
            } else {
                $sql1 = "SELECT * FROM `" . _DB_PREFIX_ . "product_attribute`";
                $sql1 .= " JOIN " . _DB_PREFIX_ . "product_attribute_shop ON ";
                $sql1 .= "" . _DB_PREFIX_ . "product_attribute.id_product_attribute=";
                $sql1 .= "" . _DB_PREFIX_ . "product_attribute_shop.id_product_attribute";
                $sql1 .= " WHERE " . _DB_PREFIX_ . "product_attribute_shop.id_shop=";
                $sql1 .= "'" . (int)$id_shop . "'";
                $sql1 .= " AND " . _DB_PREFIX_ . "product_attribute_shop.id_product=";
                $sql1 .= "'" . (int)$id_product . "'";
                $param1 = $db->Executes($sql1);
            }
            $imageproductattribute = array();
            if (!empty($param1)) {
                foreach ($param1 as $key_attr => $value_attr) {
                    $key_attr;
                    $ca = $id_product;
                    $cx = $value_attr['id_product_attribute'];
                    $imageproductattribute[] = $this->getImagesproductattribute($id_lang, $ca, $cx);
                }
                foreach ($imageproductattribute as $key => $value) {
                    foreach ($value as $key_1 => $value_1) {
                        $key_1;
                        foreach ($attr as $key_2 => $value_2) {
                            $key_2;
                            if ($value_1['id_product_attribute'] == $value_2['id_pro']) {
                                $demo[$value_1['id_image']][$value_2['id_pro']][] = $value_2['id_attribute'];
                            }
                        }
                    }
                }
            }
            foreach ($demo as $key_3 => $value_3) {
                $acb = array();
                foreach ($value_3 as $key_4 => $value_4) {
                    $value_4;
                    $acb[] = implode('-', $value_3[$key_4]);
                }
                $demo2[$key_3] = implode(' ', $acb);
            }
        }
        foreach ($product_acce as $key_new => $value_new) {
            $key_new;
            $attibute = $this->getAttributesParams($value_new['id_product'], $id_shop, $id_lang);
            if (!empty($attibute)) {
                $product_acce[$key_new]['count_attr'] = 1;
            } else {
                $product_acce[$key_new]['count_attr'] = 0;
            }
        }
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        include_once($url_fodel.'presmobileapp/configs/defines.inc.php');
        $core = new BaCore();
        $cart = $core->presMobicartresult();
        $wishlist = array();
        if (Module::isInstalled("favoriteproducts")) {
            $active_favorite = 1;
        }
        if (Module::isInstalled("blockwishlist")) {
            $active_wishlist = 1;
        }
        if ($cart['logged'] == '1') {
            $favorite = array();
            if (Module::isInstalled("favoriteproducts")) {
                $select = "SELECT *FROM  " . _DB_PREFIX_ . "favorite_product WHERE id_product=".(int)$id_product."";
                $select .= " AND id_customer=".(int)$cart['id_customer']."";
                $select .= " AND id_shop=".(int)$id_shop."";
                $favorite = $db->Executes($select);
            }
            if (!empty($favorite)) {
                $product[0]['favorite'] = 1;
            } else {
                $product[0]['favorite'] = 0;
            }
            if (Module::isInstalled("blockwishlist")) {
                $select1 = "SELECT *FROM  " . _DB_PREFIX_ . "wishlist WHERE id_customer=".(int)$cart['id_customer']."";
                $wishlist = $db->Executes($select1);
                $active_wishlist = 1;
            }
        }
        $checkattribute = $this->checkAttribute($id_lang);
        $productattribute = array();
        if (!empty($product[0]['attribute'])) {
            foreach ($product[0]['attribute'] as $key => $value) {
                foreach ($checkattribute as $key_att => $value_attr) {
                    $key_att;
                    if ($key == $value_attr['name']) {
                        $productattribute[$value_attr['group_type']][$key] = $product[0]['attribute'][$key];
                    }
                }
            }
            $product[0]['attribute'] = $productattribute;
        }
        $checkaddcart = Configuration::get('PS_CATALOG_MODE');
        $checkstock = Configuration::get('PS_ORDER_OUT_OF_STOCK');
        $checkqties = Configuration::get('PS_LAST_QTIES');
        $hide_qty = Configuration::get('PS_DISPLAY_QTIES');
        $hook_productbuton = '';
        $hook_array = (array)Tools::jsonDecode(_PS_MOBIC_HOOK_);
        $product_ar = array('product' => $product_a);
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $bw = $hook_array['displayLeftColumnProduct'];
            $hook_displayLeftColumnProduct = $core->mobiexec172('displayLeftColumnProduct', array(), $bw);
            $bk = $hook_array['displayRightColumnProduct'];
            $hook_displayRightColumnProduct = $core->mobiexec172('displayRightColumnProduct', array(), $bk);
            $hook_actionProductOutOfStock = $core->mobiexec172('actionProductOutOfStock', $product_ar);
            $bj = $hook_array['displayProductTab'];
            $hook_displayProductTab = $core->mobiexec172('displayProductTab', $product_ar, $bj);
            $bd = $hook_array['displayProductTabContent'];
            $hook_displayProductTabContent = $core->mobiexec172('displayProductTabContent', $product_ar, $bd);
            $hook_displayProductContent = $core->mobiexec172('displayProductContent', array('product' => $product_a));
            $bs = $hook_array['displayProductButtons'];
            $hook_productbuton = $core->mobiexec172('displayProductButtons', $product_ar, $bs);
            $bm = array('product_img' => $product[0]['img']);
            $presmobic_productImages = $core->mobiexec172('presmobic_productImages', $bm);
            $bn = array('product_quantity' => $product[0]['quantity']);
            $presmobic_instock = $core->mobiexec172('presmobic_instock', $bn);
            $bv = array('product_total_price' => $product[0]['total_price']);
            $presmobic_productprice = $core->mobiexec172('presmobic_productprice', $bv);
            $presmobic_displayBeforeProductDetail = $core->mobiexec172('presmobic_displayBeforeProductDetail');
            $presmobic_displayBeforeImages = $core->mobiexec172('presmobic_displayBeforeImages');
            $presmobic_displayAfterImages = $core->mobiexec172('presmobic_displayAfterImages');
            $presmobic_displayBeforeProductName = $core->mobiexec172('presmobic_displayBeforeProductName');
            $presmobic_displayAfterProductName = $core->mobiexec172('presmobic_displayAfterProductName');
            $presmobic_displayBeforeQuantityBox = $core->mobiexec172('presmobic_displayBeforeQuantityBox');
            $presmobic_displayAfterQuantityBox = $core->mobiexec172('presmobic_displayAfterQuantityBox');
            $presmobic_displayBeforeSheetData = $core->mobiexec172('presmobic_displayBeforeSheetData');
            $presmobic_displayAfterSheetData = $core->mobiexec172('presmobic_displayAfterSheetData');
            $presmobic_displayBeforeDescription = $core->mobiexec172('presmobic_displayBeforeDescription');
            $presmobic_displayAfterDescription = $core->mobiexec172('presmobic_displayAfterDescription');
            $presmobic_displayAfterBuyerProtection = $core->mobiexec172('presmobic_displayAfterBuyerProtection');
            $presmobic_displayBeforeLookAtProduct = $core->mobiexec172('presmobic_displayBeforeLookAtProduct');
            $presmobic_displayAfterLookAtProduct = $core->mobiexec172('presmobic_displayAfterLookAtProduct');
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $bb = $hook_array['displayLeftColumnProduct'];
            $hook_displayLeftColumnProduct = $core->mobiexec17('displayLeftColumnProduct', array(), $bb);
            $bh = $hook_array['displayRightColumnProduct'];
            $hook_displayRightColumnProduct = $core->mobiexec17('displayRightColumnProduct', array(), $bh);
            $hook_actionProductOutOfStock = $core->mobiexec17('actionProductOutOfStock', $product_ar);
            $bc = $hook_array['displayProductTab'];
            $hook_displayProductTab = $core->mobiexec17('displayProductTab', $product_ar, $bc);
            $ae = $hook_array['displayProductTabContent'];
            $hook_displayProductTabContent = $core->mobiexec17('displayProductTabContent', $product_ar, $ae);
            $hook_displayProductContent = $core->mobiexec17('displayProductContent', array('product' => $product_a));
            $ad = $hook_array['displayProductButtons'];
            $hook_productbuton = $core->mobiexec17('displayProductButtons', $product_ar, $ad);
            $cr = array('product_quantity' => $product[0]['quantity']);
            $presmobic_instock = $core->mobiexec17('presmobic_instock', $cr);
            $ch = array('product_img' => $product[0]['img']);
            $presmobic_productImages = $core->mobiexec17('presmobic_productImages', $ch);
            $bq = array('product_total_price' => $product[0]['total_price']);
            $presmobic_productprice = $core->mobiexec17('presmobic_productprice', $bq);
            $presmobic_displayBeforeProductDetail = $core->mobiexec17('presmobic_displayBeforeProductDetail');
            $presmobic_displayBeforeImages = $core->mobiexec17('presmobic_displayBeforeImages');
            $presmobic_displayAfterImages = $core->mobiexec17('presmobic_displayAfterImages');
            $presmobic_displayBeforeProductName = $core->mobiexec17('presmobic_displayBeforeProductName');
            $presmobic_displayAfterProductName = $core->mobiexec17('presmobic_displayAfterProductName');
            $presmobic_displayBeforeQuantityBox = $core->mobiexec17('presmobic_displayBeforeQuantityBox');
            $presmobic_displayAfterQuantityBox = $core->mobiexec17('presmobic_displayAfterQuantityBox');
            $presmobic_displayBeforeSheetData = $core->mobiexec17('presmobic_displayBeforeSheetData');
            $presmobic_displayAfterSheetData = $core->mobiexec17('presmobic_displayAfterSheetData');
            $presmobic_displayBeforeDescription = $core->mobiexec17('presmobic_displayBeforeDescription');
            $presmobic_displayAfterDescription = $core->mobiexec17('presmobic_displayAfterDescription');
            $presmobic_displayAfterBuyerProtection = $core->mobiexec17('presmobic_displayAfterBuyerProtection');
            $presmobic_displayBeforeLookAtProduct = $core->mobiexec17('presmobic_displayBeforeLookAtProduct');
            $presmobic_displayAfterLookAtProduct = $core->mobiexec17('presmobic_displayAfterLookAtProduct');
        } else {
            $ab = $hook_array['displayLeftColumnProduct'];
            $hook_displayLeftColumnProduct = $core->mobiexec('displayLeftColumnProduct', array(), $ab);
            $bl = $hook_array['displayRightColumnProduct'];
            $hook_displayRightColumnProduct = $core->mobiexec('displayRightColumnProduct', array(), $bl);
            $hook_actionProductOutOfStock = $core->mobiexec('actionProductOutOfStock', array('product' => $product_a));
            $aa = $hook_array['displayProductTab'];
            $hook_displayProductTab = $core->mobiexec('displayProductTab', $product_ar, $aa);
            $ba = $hook_array['displayProductTabContent'];
            $hook_displayProductTabContent = $core->mobiexec('displayProductTabContent', $product_ar, $ba);
            $hook_displayProductContent = $core->mobiexec('displayProductContent', array('product' => $product_a));
            $bf = $hook_array['displayProductButtons'];
            $hook_productbuton = $core->mobiexec('displayProductButtons', $product_ar, $bf);
            $ct = array('product_quantity' => $product[0]['quantity']);
            $presmobic_instock = $core->mobiexec('presmobic_instock', $ct);
            $ce = array('product_img' => $product[0]['img']);
            $presmobic_productImages = $core->mobiexec('presmobic_productImages', $ce);
            $be = array('product_total_price' => $product[0]['total_price']);
            $presmobic_productprice = $core->mobiexec('presmobic_productprice', $be);
            $presmobic_displayBeforeProductDetail = $core->mobiexec('presmobic_displayBeforeProductDetail');
            $presmobic_displayBeforeImages = $core->mobiexec('presmobic_displayBeforeImages');
            $presmobic_displayAfterImages = $core->mobiexec('presmobic_displayAfterImages');
            $presmobic_displayBeforeProductName = $core->mobiexec('presmobic_displayBeforeProductName');
            $presmobic_displayAfterProductName = $core->mobiexec('presmobic_displayAfterProductName');
            $presmobic_displayBeforeQuantityBox = $core->mobiexec('presmobic_displayBeforeQuantityBox');
            $presmobic_displayAfterQuantityBox = $core->mobiexec('presmobic_displayAfterQuantityBox');
            $presmobic_displayBeforeSheetData = $core->mobiexec('presmobic_displayBeforeSheetData');
            $presmobic_displayAfterSheetData = $core->mobiexec('presmobic_displayAfterSheetData');
            $presmobic_displayBeforeDescription = $core->mobiexec('presmobic_displayBeforeDescription');
            $presmobic_displayAfterDescription = $core->mobiexec('presmobic_displayAfterDescription');
            $presmobic_displayAfterBuyerProtection = $core->mobiexec('presmobic_displayAfterBuyerProtection');
            $presmobic_displayBeforeLookAtProduct = $core->mobiexec('presmobic_displayBeforeLookAtProduct');
            $presmobic_displayAfterLookAtProduct = $core->mobiexec('presmobic_displayAfterLookAtProduct');
        }
        if (is_array($presmobic_instock)) {
            $product[0]['quantity'] = $presmobic_instock['product_quantity'];
        }
        if (is_array($presmobic_productImages)) {
            $product[0]['img'] = $presmobic_productImages['product_img'];
        }
        if (is_array($presmobic_productprice)) {
            $product[0]['total_price'] = $presmobic_productprice['product_total_price'];
        }
        $url = $core->getMobiBaseLink();
        $context->smarty->assign("hide_qty", $hide_qty);
        $context->smarty->assign("hook_top", '');
        $context->smarty->assign("hook_productbuton", $hook_productbuton);

        $context->smarty->assign("presmobic_displayBeforeProductDetail", $presmobic_displayBeforeProductDetail);
        $context->smarty->assign("presmobic_displayBeforeImages", $presmobic_displayBeforeImages);
        $context->smarty->assign("presmobic_displayAfterImages", $presmobic_displayAfterImages);
        $context->smarty->assign("presmobic_displayBeforeProductName", $presmobic_displayBeforeProductName);
        $context->smarty->assign("presmobic_displayAfterProductName", $presmobic_displayAfterProductName);
        $context->smarty->assign("presmobic_displayBeforeQuantityBox", $presmobic_displayBeforeQuantityBox);
        $context->smarty->assign("presmobic_displayAfterQuantityBox", $presmobic_displayAfterQuantityBox);

        $context->smarty->assign("presmobic_displayBeforeSheetData", $presmobic_displayBeforeSheetData);
        $context->smarty->assign("presmobic_displayAfterSheetData", $presmobic_displayAfterSheetData);
        $context->smarty->assign("presmobic_displayBeforeDescription", $presmobic_displayBeforeDescription);
        $context->smarty->assign("presmobic_displayAfterDescription", $presmobic_displayAfterDescription);
        $context->smarty->assign("presmobic_displayAfterBuyerProtection", $presmobic_displayAfterBuyerProtection);
        $context->smarty->assign("presmobic_displayBeforeLookAtProduct", $presmobic_displayBeforeLookAtProduct);
        $context->smarty->assign("presmobic_displayAfterLookAtProduct", $presmobic_displayAfterLookAtProduct);

        $context->smarty->assign("hook_displayLeftColumnProduct", $hook_displayLeftColumnProduct);
        $context->smarty->assign("hook_displayRightColumnProduct", $hook_displayRightColumnProduct);
        $context->smarty->assign("hook_actionProductOutOfStock", $hook_actionProductOutOfStock);
        $context->smarty->assign("hook_displayProductTab", $hook_displayProductTab);
        $context->smarty->assign("hook_displayProductTabContent", $hook_displayProductTabContent);
        $context->smarty->assign("hook_displayProductContent", $hook_displayProductContent);
        $context->smarty->assign("checkqties", $checkqties);
        $context->smarty->assign("checkaddcart", $checkaddcart);
        $context->smarty->assign("checkstock", $checkstock);
        $context->smarty->assign("url", $url);
        $context->smarty->assign("sign_currency", $sign_currency);
        $context->smarty->assign("cart", $cart);
        $context->smarty->assign("active_favorite", $active_favorite);
        $context->smarty->assign("active_wishlist", $active_wishlist);
        $context->smarty->assign("attri_img", $demo2);
        $context->smarty->assign("wishlist", $wishlist);
        $context->smarty->assign("product_pack", $product_pack);
        $context->smarty->assign("product_acce", $product_acce);
        $context->smarty->assign("product", $product);
        $context->smarty->assign("productzoom", json_encode($productzoom));
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/product/detail.tpl';
        $content =  $context->smarty->fetch($a);
        $check_setcache = $core->presMobisetcache($controller.':'.$id_product, $content);
        $check_setcache;
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'chir' => $presmobileapp->l('Detail'),
            'batitle' => $product[0]['name'].' - '.$shop_name,
            'description' => strip_tags($product[0]['description'])
        );
        echo json_encode($result);
        die;
    }
    public function getImagesproductattribute($id_language, $id_product, $id_product_attribute)
    {
        $images = new Image();
        $getimages = $images->getImages($id_language, $id_product, $id_product_attribute);
        return $getimages;
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
    public function getlinkimageproductattr($id_lang, $link_rew, $id_product)
    {
        $linkimages = new Link();
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $type_img = ImageType::getFormattedName('presmobic');
        } else {
            $type_img = ImageType::getFormatedName('presmobic');
        }
        $image = Image::getImages($id_lang, $id_product);
        foreach ($image as $key => $value) {
            $linkurla = Tools::getShopProtocol();
            $cv = $value['id_image'];
            $image[$key]['image'] = $linkurla . $linkimages->getImageLink($link_rew, $cv, $type_img);
        }
        return $image;
    }
    public function getlinkimageproductzoom($id_lang, $link_rew, $id_product)
    {
        $linkimages = new Link();
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $type_img = ImageType::getFormattedName('thickbox');
        } else {
            $type_img = ImageType::getFormatedName('thickbox');
        }
        $image = Image::getImages($id_lang, $id_product);
        foreach ($image as $key => $value) {
            $linkurla = Tools::getShopProtocol();
            $cv = $value['id_image'];
            $image[$key]['image'] = $linkurla . $linkimages->getImageLink($link_rew, $cv, $type_img);
        }
        return $image;
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
        $sql = "SELECT  pa.`id_product_attribute` AS id_pro,a.`id_attribute` ";
        $sql .= "AS id_attribute,agl.`name` AS group_name, al.`name` AS attribute_name";
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
    public function getproductfeature($id_lang, $id_product)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $query = "SELECT  *FROM `" . _DB_PREFIX_ . "feature_product` fp";
        $query .= " LEFT JOIN `" . _DB_PREFIX_ . "feature_lang` fl";
        $query .= " ON fp.id_feature=fl.id_feature";
        $query .= " LEFT JOIN `" . _DB_PREFIX_ . "feature_value_lang` fvl";
        $query .= " ON fvl.id_feature_value=fp.id_feature_value";
        $query .= " WHERE fp.id_product=".(int)$id_product."";
        $query .= " AND fvl.id_lang=".(int)$id_lang." AND fl.id_lang=".(int)$id_lang."";
        $query .= " ORDER BY fl.id_feature ASC";
        $result = $db->Executes($query);
        return $result;
    }
    public function checkAttribute($id_lang)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $query = "SELECT  *FROM `" . _DB_PREFIX_ . "attribute_group_lang` fp";
        $query .= " LEFT JOIN `" . _DB_PREFIX_ . "attribute_group` fl";
        $query .= " ON fp.id_attribute_group=fl.id_attribute_group";
        $query .= " WHERE fp.id_lang=".(int)$id_lang."";
        $result = $db->Executes($query);
        return $result;
    }
}
