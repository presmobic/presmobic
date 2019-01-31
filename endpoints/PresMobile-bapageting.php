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

class BaPageTing extends PresMobileApp
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
        $start = Tools::getValue('start');
        $page = Tools::getValue('page');
        if ($page == 'order') {
            $start = $start+2;
        }
        $id_category = Tools::getValue('id_category');
        $id_product = Tools::getValue('id_product');
        $search_product = Tools::getValue('search_product');
        $choice_id_category = Tools::getValue('choice_id_category');
        $category_check_attribute = Tools::getValue('category_check');
        $category_check_sort = Tools::getValue('category_check_sort');
        $category_list = Tools::getValue('category_list');
        $category_price_rangemin = Tools::getValue('category_price_rangemin');
        $category_price_rangemax = Tools::getValue('category_price_rangemax');
        $limit = $start+6;
        $cart_r = new Cart($context->cart->id);
        $product_cart = $cart_r->getProducts();
        $order = new Order();
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        if ($page == 'comment') {
            $comment_r = $this->getComment($limit, $id_product);
            $comment = array();
            $rating = array();
            if (!empty($comment_r)) {
                $star_5 = 0;
                $star_4 = 0;
                $star_3 = 0;
                $star_2 = 0;
                $star_1 = 0;
                $count_total = 0;
                foreach ($comment_r as $key => $value) {
                    $count_total += $value['grade'];
                    if ($value['grade'] == '5') {
                        $star_5 += $value['grade'];
                    }
                    if ($value['grade'] == '4') {
                        $star_4 += $value['grade'];
                    }
                    if ($value['grade'] == '3') {
                        $star_3 += $value['grade'];
                    }
                    if ($value['grade'] == '2') {
                        $star_2 += $value['grade'];
                    }
                    if ($value['grade'] == '1') {
                        $star_1 += $value['grade'];
                    }
                }
                $rating[5] = ($star_5/$count_total)*100;
                $rating[4] = ($star_4/$count_total)*100;
                $rating[3] = ($star_3/$count_total)*100;
                $rating[2] = ($star_2/$count_total)*100;
                $rating[1] = ($star_1/$count_total)*100;
                $comment['rating_star'] = $rating;
                $comment['total'] = number_format(($count_total/count($comment_r)), 1);
                $comment['countcomment'] = count($comment_r);
                $comment['grade'] = round($comment['total']);
                $comment['comment'] = $comment_r;
            } else {
                $rating[5] = 0;
                $rating[4] = 0;
                $rating[3] = 0;
                $rating[2] = 0;
                $rating[1] = 0;
                $comment['rating_star'] = $rating;
                $comment['total'] = 0;
                $comment['countcomment'] = 0;
                $comment['grade'] = 0;
                $comment['comment'] = array();
            }
            if (!empty($comment)) {
                $context->smarty->assign("comment", $comment);
                $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/loadpageting/comment.tpl';
                $content =  $context->smarty->fetch($a);
                $result = array(
                    'content' => $content,
                    'stop' =>0,
                    'limit' =>$limit,
                    'start_ajax' =>1
                );
                echo json_encode($result);
                die;
            } else {
                $result = array(
                    'content' => '',
                    'stop' =>1,
                    'limit' =>$limit,
                    'start_ajax' =>1
                );
                echo json_encode($result);
                die;
            }
        }
        if ($page == 'order') {
            $order = $this->getMyOrder($limit);
            if (!empty($order)) {
                $context->smarty->assign("order", $order);
                $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/loadpageting/order.tpl';
                $content =  $context->smarty->fetch($a);
                $result = array(
                    'content' => $content,
                    'stop' =>0,
                    'limit' =>$limit,
                    'start_ajax' =>1
                );
                echo json_encode($result);
                die;
            } else {
                $result = array(
                    'content' => '',
                    'stop' =>1,
                    'limit' =>$limit,
                    'start_ajax' =>1
                );
                echo json_encode($result);
                die;
            }
        }
        if ($page == 'creditslips') {
            $select = "SELECT *FROM " . _DB_PREFIX_ . "order_slip ";
            $select .= "WHERE id_customer=".(int)$context->cart->id_customer." LIMIT ".(int)$start.",6";
            $creditslips = $db->Executes($select);
            if (!empty($creditslips)) {
                $context->smarty->assign("creditslips", $creditslips);
                $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/loadpageting/sceditslips.tpl';
                $content =  $context->smarty->fetch($a);
                $result = array(
                    'content' => $content,
                    'stop' =>0,
                    'limit' =>$limit,
                    'start_ajax' =>1
                );
                echo json_encode($result);
                die;
            } else {
                $result = array(
                    'content' => '',
                    'stop' =>1,
                    'limit' =>$limit,
                    'start_ajax' =>1
                );
                echo json_encode($result);
                die;
            }
        }
        if ($page == 'myaddressbycustomer') {
            $address = $this->getMyaddress($limit);
            if (!empty($address)) {
                $context->smarty->assign("customer_br", $address);
                $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/loadpageting/address.tpl';
                $content =  $context->smarty->fetch($a);
                $result = array(
                    'content' => $content,
                    'stop' =>0,
                    'limit' =>$limit,
                    'start_ajax' =>1
                );
                echo json_encode($result);
                die;
            } else {
                $result = array(
                    'content' => '',
                    'stop' =>1,
                    'limit' =>$limit,
                    'start_ajax' =>1
                );
                echo json_encode($result);
                die;
            }
        }
        if ($page == 'latest') {
            $bn = 'ORDER BY product_shop.date_upd DESC';
            $bm = 'limit '.(int)$limit.',6';
            $product = $core->presMobigetProduct($id_shop, $id_lang, '', $bn, $bm, (int)$id_category);
        }
        if ($page == 'search') {
            $sql = "SELECT *FROM "._DB_PREFIX_."product_lang pl";
            $sql .= " LEFT JOIN "._DB_PREFIX_."product p ON pl.id_product=p.id_product";
            $sql .= " WHERE pl.id_shop=".(int)$id_shop."";
            $sql .= " AND pl.id_lang=".(int)$id_lang."";
            $sql .= " AND pl.name LIKE '%".pSQL($search_product)."%'";
            $data = $db->Executes($sql);
            $sql_where_product = '';
            $id_product = '';
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $id_product .= $value['id_product'].',';
                }
                $id_product = rtrim($id_product, ',');
                $sql_where_product .= " AND p.`id_product` IN (".pSQL($id_product).")";
            }
            $bn = 'ORDER BY product_shop.date_upd DESC';
            $bm = $sql_where_product;
            $product = $core->presMobigetProduct($id_shop, $id_lang, $bm, $bn, 'limit '.(int)$limit.',6', (int)2);
        }
        if ($page == 'product') {
            $sql_acces = "SELECT *FROM " . _DB_PREFIX_ . "accessory WHERE id_product_1=".(int)$id_product."";
            $data = $db->Executes($sql_acces);
            $sql_where_product = '';
            $id_product = '';
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $id_product .= $value['id_product_2'].',';
                }
                $id_product = rtrim($id_product, ',');
                $sql_where_product .= " AND p.`id_product` IN (".pSQL($id_product).")";
            }
            $bn = 'ORDER BY product_shop.date_upd DESC';
            $bm = $sql_where_product;
            $product = $core->presMobigetProduct($id_shop, $id_lang, $bm, $bn, 'limit '.(int)$limit.',6', (int)2);
        }
        if ($page == 'category') {
            $sql_attribute = '';
            if ($category_check_attribute != '') {
                $category_check_attribute = rtrim($category_check_attribute, ',');
                $sql_attribute .= "pac.id_attribute IN(".pSQL($category_check_attribute).") AND";
            }
            $sql_sort_category = "";
            if ($category_check_sort !=false) {
                if ($category_check_sort == '1') {
                    $sql_sort_category .= "ORDER BY p.`id_product` DESC";
                }
                if ($category_check_sort == '4') {
                    $sql_sort_category .= "ORDER BY pl.`name` ASC";
                }
                if ($category_check_sort == '5') {
                    $sql_sort_category .= "ORDER BY pl.`name` DESC";
                }
            }
            $sql_ranger_price = "";
            if ($category_price_rangemax != false) {
                if ($category_price_rangemin != false) {
                    $bc = $category_price_rangemin;
                    $bv = $category_price_rangemax;
                    $sql_ranger_price .= " (p.price >=".(int)$bc." AND p.price <= ".(int)$bv." ) AND";
                } else {
                    $sql_ranger_price .= " p.price <= ".(int)$category_price_rangemax." AND";
                }
            }
            $sql_catgory = "SELECT c.*, cl.* FROM " . _DB_PREFIX_ . "category c";
            $sql_catgory .= " INNER JOIN " . _DB_PREFIX_ . "category_shop category_shop";
            $sql_catgory .= " ON (category_shop.id_category = c.id_category ";
            $sql_catgory .= "AND category_shop.id_shop = ".(int)$id_shop.")";
            $sql_catgory .= " LEFT JOIN `" . _DB_PREFIX_ . "category_lang` cl ";
            $sql_catgory .= "ON c.`id_category` = cl.`id_category` AND cl.id_shop = ".(int)$id_shop."";
            $sql_catgory .= " RIGHT JOIN `" . _DB_PREFIX_ . "category` c2";
            $sql_catgory .= " ON c2.`id_category` = ".(int)$choice_id_category."";
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
            $sql_product .= " LEFT JOIN " . _DB_PREFIX_ . "product_attribute_combination pac ";
            $sql_product .= "ON pac.`id_product_attribute` = pa.id_product_attribute";
            $sql_product .= " INNER JOIN " . _DB_PREFIX_ . "category_product cp ON cp.`id_product` = p.id_product";
            $sql_product .= " WHERE ".pSQL($sql_attribute)."";
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
            if ($category_check_sort == '2') {
                $aa = $sql_where_product;
                $ab = $sql_sort_category;
                $ac = (int)$choice_id_category;
                $product = $core->presMobigetProduct($id_shop, $id_lang, $aa, $ab, 'limit 0,1000', $ac);
                uasort($product, 'lowestfirst');
            } elseif ($category_check_sort == '3') {
                $aa = $sql_where_product;
                $ab = $sql_sort_category;
                $ac = (int)$choice_id_category;
                $product = $core->presMobigetProduct($id_shop, $id_lang, $aa, $ab, 'limit 0,1000', $ac);
                uasort($product, 'highestfirst');
            } else {
                $aa = $sql_where_product;
                $ab = $sql_sort_category;
                $ac = (int)$choice_id_category;
                $product = $core->presMobigetProduct($id_shop, $id_lang, $aa, $ab, 'limit '.$limit.',6', $ac);
            }
        }
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
                        $select = "SELECT *FROM  " . _DB_PREFIX_ . "favorite_product";
                        $select .= " WHERE id_product=".(int)$value['id_product']."";
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
                $product[$key]['total_price'] = Tools::displayPrice($value['price']);
                $product[$key]['price_new'] = Tools::displayPrice($value['price_without_reduction']);
            }
            $sql = "SELECT * FROM " . _DB_PREFIX_ . "category p JOIN " . _DB_PREFIX_ . "category_lang pl";
            $sql .= " ON p.id_category=pl.id_category";
            $sql .= " WHERE p.level_depth=2 AND pl.id_shop=".(int)$id_shop." AND pl.id_lang=".(int)$id_lang."";
            $data = $db->Executes($sql);
            $product = array_values($product);
            $product_sort = array();
            if ($category_check_sort == '2' || $category_check_sort == '3') {
                for ($i= $limit; $i <= $limit + 5; $i++) {
                    if (array_key_exists($i, $product)) {
                        $product_sort[$i] = $product[$i];
                    }
                }
                $product = array();
                $product = $product_sort;
            }
            $checkaddcart = Configuration::get('PS_CATALOG_MODE');
            $context->smarty->assign("checkaddcart", $checkaddcart);
            $url_fodel = _PS_MODULE_DIR_;
            include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
            $core = new BaCore();
            $url = $core->getMobiBaseLink();
            $context->smarty->assign("cart_check", $cart_check);
            $context->smarty->assign("url", $url);
            $context->smarty->assign("product", $product);
            $context->smarty->assign("count_product", count($product));
            if ($page == 'category') {
                if ($category_list == '1') {
                    $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/loadpageting/product_list.tpl';
                    $content =  $context->smarty->fetch($a);
                    $result = array(
                        'content' => $content,
                        'stop' =>0,
                        'limit' =>$limit,
                        'start_ajax' =>1
                    );
                    echo json_encode($result);
                    die;
                }
            }
            $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/loadpageting/product.tpl';
            $content =  $context->smarty->fetch($a);
            $result = array(
                'content' => $content,
                'stop' =>0,
                'limit' =>$limit,
                'start_ajax' =>1
            );
            echo json_encode($result);
            die;
        } else {
            $result = array(
                'content' => '',
                'stop' =>1,
                'limit' =>$limit,
                'start_ajax' =>1
            );
            echo json_encode($result);
            die;
        }
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
    public function getMyOrder($limit)
    {
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $context = Context::getContext();
        $context;
        $cart = $core->presMobicartresult();
        $order = new Order();
        $orderbycustomer = $order->getCustomerOrders($cart['id_customer']);
        if (!empty($orderbycustomer)) {
            foreach ($orderbycustomer as $key => $value) {
                $quantity = 0;
                $cart_r = new Cart($value['id_cart']);
                foreach ($cart_r->getProducts() as $key1 => $value1) {
                    $key1;
                    $quantity += $value1['cart_quantity'];
                }
                $orderbycustomer[$key]['quantity'] = $quantity;
                $orderbycustomer[$key]['price_total'] = Tools::displayPrice($value['total_paid']);
            }
        }
        $orderbycustomer_aw = array();
        for ($i= $limit; $i <= $limit + 8; $i++) {
            if (array_key_exists($i, $orderbycustomer)) {
                $orderbycustomer_aw[$i] = $orderbycustomer[$i];
            }
        }
        return $orderbycustomer_aw;
    }
    public function getMyaddress($limit)
    {
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $cart = $core->presMobicartresult();
        $customer = new Customer($cart['id_customer']);
        $customer_br = $customer->getAddresses($id_lang);
        $orderbycustomer_aw = array();
        for ($i= $limit; $i <= $limit+6; $i++) {
            if (array_key_exists($i, $customer_br)) {
                $orderbycustomer_aw[$i] = $customer_br[$i];
            }
        }
        return $orderbycustomer_aw;
    }
    public function getComment($limit, $id_product)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=')) {
            $select = "SELECT *FROM " . _DB_PREFIX_ . "ba_mobic_comment WHERE id_product=".(int)$id_product."";
            $select .= " AND validate=1 limit ".(int)$limit.",6";
            $param = $db->Executes($select);
        } else {
            $select = "SELECT *FROM " . _DB_PREFIX_ . "product_comment WHERE id_product=".(int)$id_product."";
            $select .= " AND validate=1 limit ".(int)$limit.",6";
            $param = $db->Executes($select);
        }
        return $param;
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
