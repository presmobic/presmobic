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

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;

class BaCore extends PresMobileApp
{
    public $start_time = 0;
    public $max_execution_time = 7200;
    public $errors = array();
    public static $native_module;
    protected static $deprecated_hooks = array(
        // Back office
        'backOfficeFooter' => array('from' => '1.7.0.0'),
        'displayBackOfficeFooter' => array('from' => '1.7.0.0'),
        // Shipping step
        'displayCarrierList' => array('from' => '1.7.0.0'),
        'extraCarrier' => array('from' => '1.7.0.0'),
        // Payment stepf
        'hookBackBeforePayment' => array('from' => '1.7.0.0'),
        'hookDisplayBeforePayment' => array('from' => '1.7.0.0'),
        'hookOverrideTOSDisplay' => array('from' => '1.7.0.0'),
        // Product page
        'displayProductTabContent' => array('from' => '1.7.0.0'),
        'displayProductTab' => array('from' => '1.7.0.0'),
    );
    public function __construct()
    {
    }
    public function presMobiinstall($displayname, $file, $position, $hook, $arg = null)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $hook = json_encode($hook);
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE file='".pSQL($file)."'";
        $param = $db->Executes($sql);
        $list_id_shop = Shop::getCompleteListOfShopsID();
        foreach ($list_id_shop as $key_shop => $value_shop) {
            $key_shop;
            $value_shop;
            if (empty($param)) {
                $sql = "INSERT INTO " . _DB_PREFIX_ . "ba_mobileapp_block";
                $sql .= " VALUES ('','".pSQL($displayname)."','".pSQL($file)."','1','".pSQL($arg)."',";
                $sql .= "'".(int)$position."','".pSQL($hook)."','".(int)$value_shop."')";
                $db->query($sql);
            }
        }
    }
    public function presMobiuninstall($file)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE file='".pSQL($file)."'";
        $param = $db->Executes($sql);
        $list_id_shop = Shop::getCompleteListOfShopsID();
        foreach ($list_id_shop as $key_shop => $value_shop) {
            $key_shop;
            $value_shop;
            if (!empty($param)) {
                $sql = "DELETE FROM " . _DB_PREFIX_ . "ba_mobileapp_block";
                $sql .= " WHERE file='".pSQL($file)."'";
                $db->query($sql);
            }
        }
    }
    public function presMobidisnable($file)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE file='".pSQL($file)."'";
        $param = $db->Executes($sql);
        $list_id_shop = Shop::getCompleteListOfShopsID();
        foreach ($list_id_shop as $key_shop => $value_shop) {
            $key_shop;
            $value_shop;
            if (!empty($param)) {
                $sql = "UPDATE " . _DB_PREFIX_ . "ba_mobileapp_block SET active=0";
                $sql .= " WHERE file='".pSQL($file)."'";
                $db->query($sql);
            }
        }
    }
    public function presMobienable($file)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE file='".pSQL($file)."'";
        $param = $db->Executes($sql);
        $list_id_shop = Shop::getCompleteListOfShopsID();
        foreach ($list_id_shop as $key_shop => $value_shop) {
            $key_shop;
            $value_shop;
            if (!empty($param)) {
                $sql = "UPDATE " . _DB_PREFIX_ . "ba_mobileapp_block SET active=1";
                $sql .= " WHERE file='".pSQL($file)."'";
                $db->query($sql);
            }
        }
    }
    //xác thực secure của use(đối số $length)
    public function secureToken($length = 9)
    {
        $characters       = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = Tools::strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function presMobigetProduct(
        $id_shop,
        $id_lang,
        $sql_where_product = '',
        $sql_sort_category = '',
        $ba_limit = 'LIMIT 0,1000',
        $id_category = 2
    ) {
        $sql_category = '';
        if ($id_category != 2) {
            $sql_category .= ' AND cp.`id_category`='.(int)$id_category.'';
        }
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $sql_product_l1 = 'SELECT p.*,product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) 
        as quantity, 
        MAX(product_attribute_shop.id_product_attribute) id_product_attribute, product_attribute_shop.minimal_quantity 
        AS product_attribute_minimal_quantity, pl.`description`, pl.`description_short`, pl.`available_now`,
                    pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, 
                    pl.`meta_keywords`, pl.`meta_title`, pl.`name`, 
                    MAX(image_shop.`id_image`) id_image,
                    il.`legend`, m.`name` AS manufacturer_name, cl.`name` AS category_default,
                    DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),
                    INTERVAL 20
                        DAY)) > 0 AS new, product_shop.price AS orderprice
                FROM `' . _DB_PREFIX_ . 'category_product` cp
                LEFT JOIN `' . _DB_PREFIX_ . 'product` p
                    ON p.`id_product` = cp.`id_product`
                 INNER JOIN ' . _DB_PREFIX_ . 'product_shop product_shop
        ON (product_shop.id_product = p.id_product AND product_shop.id_shop = '.(int)$id_shop.')
                LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute` pa
                ON (p.`id_product` = pa.`id_product`)
                 LEFT JOIN ' . _DB_PREFIX_ . 'product_attribute_shop product_attribute_shop
        ON (product_attribute_shop.id_product_attribute = pa.id_product_attribute 
        AND product_attribute_shop.id_shop = '.(int)$id_shop.' 
        AND product_attribute_shop.`default_on` = 1)
                 LEFT 
            JOIN ' . _DB_PREFIX_ . 'stock_available stock
            ON (stock.id_product = p.id_product 
            AND stock.id_product_attribute = IFNULL(`product_attribute_shop`.id_product_attribute, 0) 
            AND stock.id_shop = '.(int)$id_shop.'  )
                LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl
                    ON (product_shop.`id_category_default` = cl.`id_category`
                    AND cl.`id_lang` = '.(int)$id_lang.' AND cl.id_shop = '.(int)$id_shop.' )
                LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl
                    ON (p.`id_product` = pl.`id_product`
                    AND pl.`id_lang` = '.(int)$id_lang.' AND pl.id_shop = '.(int)$id_shop.' )
                LEFT JOIN `' . _DB_PREFIX_ . 'image` i
                    ON (i.`id_product` = p.`id_product`) LEFT JOIN ' . _DB_PREFIX_ . 'image_shop image_shop
        ON (image_shop.id_image = i.id_image AND image_shop.id_shop = 1 AND image_shop.cover=1)
                LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il
                    ON (image_shop.`id_image` = il.`id_image`
                    AND il.`id_lang` = '.(int)$id_lang.')
                LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m
                    ON m.`id_manufacturer` = p.`id_manufacturer`
                WHERE product_shop.`id_shop` = '.(int)$id_shop.' '.$sql_category.'
                 '.$sql_where_product.' AND product_shop.`active` = 1 
                 AND product_shop.`visibility` IN ("both", "catalog") 
                 GROUP BY product_shop.id_product '.pSQL($sql_sort_category).'
                 '.$ba_limit.'';
        $result = $db->executeS($sql_product_l1);
        $ca_product = new Product();
        $product = $ca_product->getProductsProperties($id_lang, $result);
        return $product;
    }
    public function presMobigetProductCart(
        $id_shop,
        $id_lang,
        $sql_where_product = '',
        $sql_sort_category = '',
        $ba_limit = 'LIMIT 0,1000',
        $id_category = 2
    ) {
        $sql_category = '';
        if ($id_category != 2) {
            $sql_category .= ' AND cp.`id_category`='.(int)$id_category.'';
        }
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $sql_product_l1 = 'SELECT p.*,product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) 
        as quantity, pa.`id_product_attribute`, product_attribute_shop.minimal_quantity 
        AS product_attribute_minimal_quantity, pl.`description`, pl.`description_short`, pl.`available_now`,
                    pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`,
                    pl.`meta_keywords`, pl.`meta_title`, pl.`name`, pai.`id_image`,
                    il.`legend`, m.`name` AS manufacturer_name, cl.`name` AS category_default,
                    DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),
                    INTERVAL 20
                        DAY)) > 0 AS new, product_shop.price AS orderprice
                FROM `' . _DB_PREFIX_ . 'category_product` cp
                LEFT JOIN `' . _DB_PREFIX_ . 'product` p
                    ON p.`id_product` = cp.`id_product`
                 INNER JOIN ' . _DB_PREFIX_ . 'product_shop product_shop
        ON (product_shop.id_product = p.id_product AND product_shop.id_shop = '.(int)$id_shop.')
                LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute` pa
                ON (p.`id_product` = pa.`id_product`)
                LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_image` pai
                ON (pa.`id_product_attribute` = pai.`id_product_attribute`)
                 LEFT JOIN ' . _DB_PREFIX_ . 'product_attribute_shop product_attribute_shop
        ON (product_attribute_shop.id_product_attribute = pa.id_product_attribute 
        AND product_attribute_shop.id_shop = '.(int)$id_shop.' 
        AND product_attribute_shop.`default_on` = 1)
                 LEFT 
            JOIN ' . _DB_PREFIX_ . 'stock_available stock
            ON (stock.id_product = p.id_product 
            AND stock.id_product_attribute = IFNULL(`product_attribute_shop`.id_product_attribute, 0) 
            AND stock.id_shop = '.(int)$id_shop.'  )
                LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl
                    ON (product_shop.`id_category_default` = cl.`id_category`
                    AND cl.`id_lang` = '.(int)$id_lang.' AND cl.id_shop = '.(int)$id_shop.' )
                LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl
                    ON (p.`id_product` = pl.`id_product`
                    AND pl.`id_lang` = '.(int)$id_lang.' AND pl.id_shop = '.(int)$id_shop.' )
                LEFT JOIN `' . _DB_PREFIX_ . 'image` i
                    ON (i.`id_product` = p.`id_product`) LEFT JOIN ' . _DB_PREFIX_ . 'image_shop image_shop
        ON (image_shop.id_image = i.id_image AND image_shop.id_shop = 1 AND image_shop.cover=1)
                LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il
                    ON (image_shop.`id_image` = il.`id_image`
                    AND il.`id_lang` = '.(int)$id_lang.')
                LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m
                    ON m.`id_manufacturer` = p.`id_manufacturer`
                WHERE product_shop.`id_shop` = '.(int)$id_shop.' '.pSQL($sql_category).'
                 '.pSQL($sql_where_product).'
                 AND product_shop.`active` = 1 
                 AND product_shop.`visibility` IN ("both", "catalog") 
                 GROUP BY pa.id_product_attribute '.pSQL($sql_sort_category).'
                 '.$ba_limit.'';
        $result = $db->executeS($sql_product_l1);
        $ca_product = new Product();
        $product = $ca_product->getProductsProperties($id_lang, $result);
        return $product;
    }
    public function presMobicartresult()
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $context = Context::getContext();
        $cart_id = $context->cart->id;
        $id_shop = $context->shop->id;
        $cart = new Cart($cart_id);
        $productcart = $cart->getProducts(true);
        $cart_array = array();
        $acb = $context->customer->logged;
        $cart_array = array(
            'cart' => $context->cart,
            'cart_qties' => $context->cart->nbProducts(),
            'logged' => $context->customer->isLogged(),
            'id_address_delivery' => $context->cart->id_address_delivery,
            'id_address_invoice' => $context->cart->id_address_invoice,
            'customerName' => ($acb ? $context->customer->firstname.' '.$context->customer->lastname : false),
            'firstName' => ($context->customer->logged ? $context->customer->firstname : false),
            'email' => ($context->customer->logged ? $context->customer->email : false),
            'lastName' => ($context->customer->logged ? $context->customer->lastname : false),
            'id_customer' => ($context->customer->logged ? $context->customer->id : false),
            'birthday' => ($context->customer->logged ? $context->customer->birthday : false),
            'company' => ($context->customer->logged ? $context->customer->company : false),
            'siret' => ($context->customer->logged ? $context->customer->siret : false),
            'ape' => ($context->customer->logged ? $context->customer->ape : false),
            'newsletter' => ($context->customer->logged ? $context->customer->newsletter : false),
            'website' => ($context->customer->logged ? $context->customer->website : false),
            'ip_registration_newsletter' => ($acb ? $context->customer->ip_registration_newsletter : false),
            'id_gender' => ($context->customer->logged ? $context->customer->id_gender : false)
        );
        $price = 0;
        $product_total = 0;
        if (!empty($productcart)) {
            foreach ($productcart as $key => $value) {
                $key;
                $price += $value['total_wt'];
                $product_total += $value['cart_quantity'];
            }
        }
        $cart_array['price'] = Tools::displayPrice($price);
        $cart_array['product_total'] = $product_total;
        $order = new Order();
        $orderbycustomer = $order->getCustomerOrders($context->customer->id);
        $order = 0;
        if (!empty($orderbycustomer)) {
            $order = count($orderbycustomer);
        }
        $cart_array['order'] = $order;
        $cart_array['count_favorite'] = 0;
        $cart_array['favorite'] = array();
        if (Module::isInstalled("favoriteproducts")) {
            $sql2 = "SELECT * FROM `" . _DB_PREFIX_ . "favorite_product`";
            $sql2.= " WHERE `id_customer`=".(int)$context->customer->id." AND id_shop=".(int)$id_shop."";
            $param_customer = $db->Executes($sql2);
            if (!empty($param_customer)) {
                $cart_array['count_favorite'] = count($param_customer);
                $cart_array['favorite'] = $param_customer;
            }
        }
        $cart_array['count_wis'] = 0;
        if (Module::isInstalled("blockwishlist")) {
            $sql_wis = "SELECT * FROM ". _DB_PREFIX_ . "wishlist" ;
            $sql_wis .= " WHERE `id_customer`=".(int)$context->customer->id." AND id_shop=".(int)$id_shop."" ;
            $param_wis = $db->Executes($sql_wis);
            if (!empty($param_wis)) {
                $cart_array['count_wis'] = count($param_wis);
            }
        }
        $orderreturn = new OrderReturn();
        $return = $orderreturn->getOrdersReturn($context->customer->id);
        $cart_array['count_merchandise'] = count($return);
        $select = "SELECT *FROM " . _DB_PREFIX_ . "order_slip WHERE id_customer=".(int)$context->customer->id."";
        $creditslips = $db->Executes($select);
        $cart_array['count_creadit'] = count($creditslips);
        $a = $context->language->id;
        $discountbycustomer = CartRule::getCustomerCartRules($a, $context->customer->id, true, false);
        $cart_array['count_voucher'] = count($discountbycustomer);
        $customer = new Customer($context->customer->id);
        $customer_br = $customer->getAddresses($context->language->id);
        $cart_array['count_address'] = count($customer_br);
        return $cart_array;
    }
    public function presMobicheckcache($controler)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $context = Context::getContext();
        $id_language = $context->cookie->id_lang;
        $id_shop = $context->cookie->id_shop;
        $id_customer = $context->cart->id_customer;
        if ($id_customer == '') {
            $id_customer = 0;
        }
        $language = Language::getLanguages();
        $iso_code = '';
        if (count($language) > 1) {
            foreach ($language as $key => $value) {
                $key;
                if ($value['id_lang'] == $id_language) {
                    $iso_code = $value['iso_code'].'/';
                }
            }
        }
        $url = Tools::getShopProtocol() . Tools::getServerName() . __PS_BASE_URI__.$iso_code.'#'.$controler;
        $md_cache = md5($url.$id_language.$id_shop);
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobic_cache WHERE key_mobic ";
        $sql .= "LIKE '".pSQL($md_cache)."' AND id_customer=".(int)$id_customer."";
        $param = $db->Executes($sql);
        if (!empty($param)) {
            return $param[0]['body'];
        } else {
            return '';
        }
        die;
    }
    public function presMobisetcache($controler, $body)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $context = Context::getContext();
        $id_language = $context->cookie->id_lang;
        $id_shop = $context->cookie->id_shop;
        $id_customer = $context->cart->id_customer;
        if ($id_customer == '') {
            $id_customer = 0;
        }
        $language = Language::getLanguages();
        $iso_code = '';
        if (count($language) > 1) {
            foreach ($language as $key => $value) {
                $key;
                if ($value['id_lang'] == $id_language) {
                    $iso_code = $value['iso_code'].'/';
                }
            }
        }
        $url = Tools::getShopProtocol() . Tools::getServerName() . __PS_BASE_URI__.$iso_code.'#'.$controler;
        $md_cache = md5($url.$id_language.$id_shop);
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobic_cache ";
        $sql .= "WHERE key_mobic LIKE '".pSQL($md_cache)."' AND id_customer=".(int)$id_customer."";
        $param = $db->Executes($sql);
        if (empty($param)) {
            $sql = "REPLACE INTO " . _DB_PREFIX_ . "ba_mobic_cache ";
            $sql .= "VALUES('','".(int)$id_customer."','','".pSQL($md_cache)."','".pSQL($body, true)."')";
            $db->query($sql);
        }
    }
    public function mobiexec(
        $hook_name,
        $hook_args = array(),
        $module_unset = array(),
        $id_module = null,
        $array_return = false,
        $check_exceptions = true,
        $use_push = false,
        $id_shop = null
    ) {
        $abc = 0;
        if (!empty($hook_args)) {
            if (!isset($hook_args['product'])) {
                $abc = 1;
            }
        }
        static $disable_non_native_modules = null;
        if ($disable_non_native_modules === null) {
            $disable_non_native_modules = (bool)Configuration::get('PS_DISABLE_NON_NATIVE_MODULE');
        }
        // Check arguments validity
        if (($id_module && !is_numeric($id_module)) || !Validate::isHookName($hook_name)) {
            throw new PrestaShopException('Invalid id_module or hook_name');
        }
        // If no modules associated to hook_name or recompatible hook name, we stop the function
        if (!$module_list = Hook::getHookModuleExecList($hook_name)) {
            return '';
        }
        if (!is_array($module_unset)) {
            return '';
        }
        foreach ($module_list as $key => $value) {
            foreach ($module_unset as $key1 => $value1) {
                $key1;
                if ($value1 == $value['module']) {
                    unset($module_list[$key]);
                }
            }
        }
        $module_list = array_values($module_list);
        // Check if hook exists
        if (!$id_hook = Hook::getIdByName($hook_name)) {
            return false;
        }
        // Store list of executed hooks on this page
        Hook::$executed_hooks[$id_hook] = $hook_name;
        $live_edit = false;
        $context = Context::getContext();
        if (!isset($hook_args['cookie']) || !$hook_args['cookie']) {
            $hook_args['cookie'] = $context->cookie;
        }
        if (!isset($hook_args['cart']) || !$hook_args['cart']) {
            $hook_args['cart'] = $context->cart;
        }
        $retro_hook_name = Hook::getRetroHookName($hook_name);

        
        // Look on modules list
        $altern = 0;
        $output = '';
        if ($disable_non_native_modules && !isset(Hook::$native_module)) {
            Hook::$native_module = Module::getNativeModuleList();
        }
        $different_shop = false;
        if ($id_shop !== null && Validate::isUnsignedId($id_shop) && $id_shop != $context->shop->getContextShopID()) {
            $old_context_shop_id = $context->shop->getContextShopID();
            $old_context_shop_id;
            $old_context = $context->shop->getContext();
            $old_shop = clone $context->shop;
            $shop = new Shop((int)$id_shop);
            if (Validate::isLoadedObject($shop)) {
                $context->shop = $shop;
                $context->shop->setContext(Shop::CONTEXT_SHOP, $shop->id);
                $different_shop = true;
            }
        }
        foreach ($module_list as $array) {
            // Check errors
            if ($id_module && $id_module != $array['id_module']) {
                continue;
            }
            $a = $disable_non_native_modules;
            $b = Hook::$native_module;
            if ((bool)$a && $b && count($b) && !in_array($array['module'], self::$native_module)) {
                continue;
            }
            if (!($moduleInstance = Module::getInstanceByName($array['module']))) {
                continue;
            }
            // Check permissions
            if ($check_exceptions) {
                $exceptions = $moduleInstance->getExceptions($array['id_hook']);
                $controller = Dispatcher::getInstance()->getController();
                if (in_array($controller, $exceptions)) {
                    continue;
                }
                //retro compat of controller names
                $matching_name = array(
                    'authentication' => 'auth',
                    'productscomparison' => 'compare'
                );
                if (isset($matching_name[$controller]) && in_array($matching_name[$controller], $exceptions)) {
                    continue;
                }
                $a = Validate::isLoadedObject($context->employee);
                if ($a && !$moduleInstance->getPermission('view', $context->employee)) {
                    continue;
                }
            }
            if ($use_push && !$moduleInstance->allow_push) {
                continue;
            }
            // Check which / if method is callable
            $hook_callable = is_callable(array($moduleInstance, 'hook'.$hook_name));
            $hook_retro_callable = is_callable(array($moduleInstance, 'hook'.$retro_hook_name));
            if (($hook_callable || $hook_retro_callable) && Module::preCall($moduleInstance->name)) {
                $hook_args['altern'] = ++$altern;
                if ($use_push && isset($moduleInstance->push_filename) && file_exists($moduleInstance->push_filename)) {
                    Tools::waitUntilFileIsModified($moduleInstance->push_filename, $moduleInstance->push_time_limit);
                }
                // Call hook method
                if ($hook_callable) {
                    $display = $moduleInstance->{'hook'.$hook_name}($hook_args);
                } elseif ($hook_retro_callable) {
                    $display = $moduleInstance->{'hook'.$retro_hook_name}($hook_args);
                }
                // Live edit
                $a = Tools::isSubmit('live_edit');
                $b = Tools::getValue('ad');
                $c = Tools::getValue('liveToken');
                $d = Tab::getIdFromClassName('AdminModulesPositions');
                $e = Tools::getValue('id_employee');
                $g = $array_return;
                $h = $array['live_edit'];
                if (!$g && $h && $a && $b && $c == Tools::getAdminToken('AdminModulesPositions'.(int)$d.(int)$e)) {
                    $live_edit = true;
                    $output .= $this->wrapLiveEdit($display, $moduleInstance, $array['id_hook']);
                } elseif ($array_return) {
                    $output[$moduleInstance->name] = $display;
                } else {
                    $output .= $display;
                }
            }
        }
        if ($different_shop) {
            $context->shop = $old_shop;
            $context->shop->setContext($old_context, $shop->id);
        }
        if ($abc == 1) {
            return $hook_args;
        }
        if ($array_return) {
            return $output;
        } else {
            $a = $output;
            $b = $live_edit;
            return ($live_edit ? '<script type="text/javascript">hooks_list.push(\''.$hook_name.'\');</script>
                <div id="'.$hook_name.'" class="dndHook" style="min-height:50px">' : '').$a.($b ? '</div>' : '');
        }// Return html string
    }
    public function wrapLiveEdit($display, $moduleInstance, $id_hook)
    {
        $a = $moduleInstance->id;
        $b = str_replace('_', '-', Tools::safeOutput($moduleInstance->name));
        $c = Tools::safeOutput($moduleInstance->name);
        $d = Tools::safeOutput($moduleInstance->name);
        return '<script type="text/javascript"> modules_list.push(\''.$c.'\');</script>
                <div id="hook_'.(int)$id_hook.'_module_'.(int)$a.'_moduleName_'.$b.'"
                class="dndModule" style="border: 1px dotted red;'.(!Tools::strlen($display) ? 'height:50px;' : '').'">
                    <span style="font-family: Georgia;font-size:13px;font-style:italic;">
                        <img style="padding-right:5px;" src="'._MODULE_DIR_.$d.'/logo.gif">'
                .Tools::safeOutput($moduleInstance->displayName).'<span style="float:right">
                <a href="#" id="'.(int)$id_hook.'_'.(int)$moduleInstance->id.'" class="moveModule">
                    <img src="'._PS_ADMIN_IMG_.'arrow_out.png"></a>
                <a href="#" id="'.(int)$id_hook.'_'.(int)$moduleInstance->id.'" class="unregisterHook">
                    <img src="'._PS_ADMIN_IMG_.'delete.gif"></a></span>
                </span>'.$display.'</div>';
    }
    private static function getHookRegistry()
    {
        //SymfonyContainer::getInstance() Only use this function in Prestashop 1.7.x+
        $sfContainer = SymfonyContainer::getInstance();
        if (!is_null($sfContainer) && "dev" === $sfContainer->getParameter('kernel.environment')) {
            return $sfContainer->get('prestashop.hooks_registry');
        }
        return null;
    }
    public static function mobiexec172(
        $hook_name,
        $hook_args = array(),
        $module_unset = array(),
        $id_module = null,
        $array_return = false,
        $check_exceptions = true,
        $use_push = false,
        $id_shop = null,
        $chain = false
    ) {
        $abc = 0;
        if (!empty($hook_args)) {
            if (!isset($hook_args['product'])) {
                $abc = 1;
            }
        }
        if (defined('PS_INSTALLATION_IN_PROGRESS')) {
            return;
        }
        // $chain & $array_return are incompatible so if chained is set to true, we disable the array_return option
        if (true === $chain) {
            $array_return = false;
        }
        static $disable_non_native_modules = null;
        if ($disable_non_native_modules === null) {
            $disable_non_native_modules = (bool)Configuration::get('PS_DISABLE_NON_NATIVE_MODULE');
        }
        // Check arguments validity
        if (($id_module && !is_numeric($id_module)) || !Validate::isHookName($hook_name)) {
            throw new PrestaShopException('Invalid id_module or hook_name');
        }
        // If no modules associated to hook_name or recompatible hook name, we stop the function
        if (!$module_list = Hook::getHookModuleExecList($hook_name)) {
            if ($array_return) {
                return array();
            } else {
                return '';
            }
        }
        foreach ($module_list as $key => $value) {
            foreach ($module_unset as $key1 => $value1) {
                $key1;
                if ($value1 == $value['module']) {
                    unset($module_list[$key]);
                }
            }
        }
        $module_list = array_values($module_list);
        // Check if hook exists
        if (!$id_hook = Hook::getIdByName($hook_name)) {
            if ($array_return) {
                return array();
            } else {
                return false;
            }
        }
        if (array_key_exists($hook_name, self::$deprecated_hooks)) {
            $deprecVersion = isset(self::$deprecated_hooks[$hook_name]['from'])?
                    self::$deprecated_hooks[$hook_name]['from']:
                    _PS_VERSION_;
            Tools::displayAsDeprecated('The hook '. $hook_name .' is deprecated in PrestaShop v.'. $deprecVersion);
        }
        // Store list of executed hooks on this page
        Hook::$executed_hooks[$id_hook] = $hook_name;
        $context = Context::getContext();
        if (!isset($hook_args['cookie']) || !$hook_args['cookie']) {
            $hook_args['cookie'] = $context->cookie;
        }
        if (!isset($hook_args['cart']) || !$hook_args['cart']) {
            $hook_args['cart'] = $context->cart;
        }
        // Look on modules list
        $altern = 0;
        if ($array_return) {
            $output = array();
        } else {
            $output = '';
        }
        if ($disable_non_native_modules && !isset(Hook::$native_module)) {
            Hook::$native_module = Module::getNativeModuleList();
        }
        $different_shop = false;
        if ($id_shop !== null && Validate::isUnsignedId($id_shop) && $id_shop != $context->shop->getContextShopID()) {
            $old_context = $context->shop->getContext();
            $old_shop = clone $context->shop;
            $shop = new Shop((int)$id_shop);
            if (Validate::isLoadedObject($shop)) {
                $context->shop = $shop;
                $context->shop->setContext(Shop::CONTEXT_SHOP, $shop->id);
                $different_shop = true;
            }
        }
        foreach ($module_list as $key => $array) {
            // Check errors
            if ($id_module && $id_module != $array['id_module']) {
                continue;
            }
            $a = $disable_non_native_modules;
            $b = Hook::$native_module;
            if ((bool)$a && $b && count($b) && !in_array($array['module'], $b)) {
                continue;
            }
            // Check permissions
            if ($check_exceptions) {
                $exceptions = Module::getExceptionsStatic($array['id_module'], $array['id_hook']);
                $controller = Dispatcher::getInstance()->getController();
                $controller_obj = Context::getContext()->controller;
                //check if current controller is a module controller
                if (isset($controller_obj->module) && Validate::isLoadedObject($controller_obj->module)) {
                    $controller = 'module-'.$controller_obj->module->name.'-'.$controller;
                }
                if (in_array($controller, $exceptions)) {
                    continue;
                }
                //Backward compatibility of controller names
                $matching_name = array(
                    'authentication' => 'auth'
                );
                if (isset($matching_name[$controller]) && in_array($matching_name[$controller], $exceptions)) {
                    continue;
                }
                $ab = Validate::isLoadedObject($context->employee);
                if ($ab && !Module::getPermissionStatic($array['id_module'], 'view', $context->employee)) {
                    continue;
                }
            }
            if (!($moduleInstance = Module::getInstanceByName($array['module']))) {
                continue;
            }
            if ($use_push && !$moduleInstance->allow_push) {
                continue;
            }
            if (self::isHookCallableOn($moduleInstance, $hook_name)) {
                $hook_args['altern'] = ++$altern;
                if ($use_push && isset($moduleInstance->push_filename) && file_exists($moduleInstance->push_filename)) {
                    Tools::waitUntilFileIsModified($moduleInstance->push_filename, $moduleInstance->push_time_limit);
                }
                if (0 !== $key && true === $chain) {
                    $hook_args = $output;
                }
                $display = self::callHookOn($moduleInstance, $hook_name, $hook_args);
                if ($array_return) {
                    $output[$moduleInstance->name] = $display;
                } else {
                    if (true === $chain) {
                        $output = $display;
                    } else {
                        $output .= $display;
                    }
                }
            } elseif (Hook::isDisplayHookName($hook_name)) {
                if ($moduleInstance instanceof WidgetInterface) {
                    if (0 !== $key && true === $chain) {
                        $hook_args = $output;
                    }
                    $display = Hook::coreRenderWidget($moduleInstance, $hook_name, $hook_args);
                    if ($array_return) {
                        $output[$moduleInstance->name] = $display;
                    } else {
                        if (true === $chain) {
                            $output = $display;
                        } else {
                            $output .= $display;
                        }
                    }
                }
            }
        }
        if ($different_shop) {
            $context->shop = $old_shop;
            $context->shop->setContext($old_context, $shop->id);
        }
        if (true === $chain) {
            if (isset($output['cookie'])) {
                unset($output['cookie']);
            }
            if (isset($output['cart'])) {
                unset($output['cart']);
            }
        }
        if ($abc == 1) {
            return $hook_args;
        }
        return $output;
    }
    public static function mobiexec17(
        $hook_name,
        $hook_args = array(),
        $module_unset = array(),
        $id_module = null,
        $array_return = false,
        $check_exceptions = true,
        $use_push = false,
        $id_shop = null,
        $chain = false
    ) {
        $abc = 0;
        if (!empty($hook_args)) {
            if (!isset($hook_args['product'])) {
                $abc = 1;
            }
        }
        if (defined('PS_INSTALLATION_IN_PROGRESS')) {
            return;
        }
        $hookRegistry = self::getHookRegistry();
        $isRegistryEnabled = !is_null($hookRegistry);
        if ($isRegistryEnabled) {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
            $hookRegistry->selectHook($hook_name, $hook_args, $backtrace[0]['file'], $backtrace[0]['line']);
        }
        // $chain & $array_return are incompatible so if chained is set to true, we disable the array_return option
        if (true === $chain) {
            $array_return = false;
        }
        static $disable_non_native_modules = null;
        if ($disable_non_native_modules === null) {
            $disable_non_native_modules = (bool)Configuration::get('PS_DISABLE_NON_NATIVE_MODULE');
        }
        // Check arguments validity
        if (($id_module && !is_numeric($id_module)) || !Validate::isHookName($hook_name)) {
            throw new PrestaShopException('Invalid id_module or hook_name');
        }
        // If no modules associated to hook_name or recompatible hook name, we stop the function
        if (!$module_list = Hook::getHookModuleExecList($hook_name)) {
            if ($isRegistryEnabled) {
                $hookRegistry->collect();
            }
            if ($array_return) {
                return array();
            } else {
                return '';
            }
        }
        foreach ($module_list as $key => $value) {
            foreach ($module_unset as $key1 => $value1) {
                $key1;
                if ($value1 == $value['module']) {
                    unset($module_list[$key]);
                }
            }
        }
        $module_list = array_values($module_list);
        // Check if hook exists
        if (!$id_hook = Hook::getIdByName($hook_name)) {
            if ($isRegistryEnabled) {
                $hookRegistry->collect();
            }
            if ($array_return) {
                return array();
            } else {
                return false;
            }
        }
        if (array_key_exists($hook_name, self::$deprecated_hooks)) {
            $deprecVersion = isset(self::$deprecated_hooks[$hook_name]['from'])?
                    self::$deprecated_hooks[$hook_name]['from']:
                    _PS_VERSION_;
            Tools::displayAsDeprecated('The hook '. $hook_name .' is deprecated in PrestaShop v.'. $deprecVersion);
        }
        // Store list of executed hooks on this page
        Hook::$executed_hooks[$id_hook] = $hook_name;
        $context = Context::getContext();
        if (!isset($hook_args['cookie']) || !$hook_args['cookie']) {
            $hook_args['cookie'] = $context->cookie;
        }
        if (!isset($hook_args['cart']) || !$hook_args['cart']) {
            $hook_args['cart'] = $context->cart;
        }
        // Look on modules list
        $altern = 0;
        if ($array_return) {
            $output = array();
        } else {
            $output = '';
        }
        if ($disable_non_native_modules && !isset(Hook::$native_module)) {
            Hook::$native_module = Module::getNativeModuleList();
        }
        $different_shop = false;
        if ($id_shop !== null && Validate::isUnsignedId($id_shop) && $id_shop != $context->shop->getContextShopID()) {
            $old_context = $context->shop->getContext();
            $old_shop = clone $context->shop;
            $shop = new Shop((int)$id_shop);
            if (Validate::isLoadedObject($shop)) {
                $context->shop = $shop;
                $context->shop->setContext(Shop::CONTEXT_SHOP, $shop->id);
                $different_shop = true;
            }
        }
        foreach ($module_list as $key => $array) {
            // Check errors
            if ($id_module && $id_module != $array['id_module']) {
                continue;
            }
            $a = $disable_non_native_modules;
            $b = Hook::$native_module;
            if ((bool)$a && $b && count($b) && !in_array($array['module'], $b)) {
                continue;
            }
            // Check permissions
            if ($check_exceptions) {
                $exceptions = Module::getExceptionsStatic($array['id_module'], $array['id_hook']);
                $controller = Dispatcher::getInstance()->getController();
                $controller_obj = Context::getContext()->controller;
                //check if current controller is a module controller
                if (isset($controller_obj->module) && Validate::isLoadedObject($controller_obj->module)) {
                    $controller = 'module-'.$controller_obj->module->name.'-'.$controller;
                }
                if (in_array($controller, $exceptions)) {
                    continue;
                }
                //Backward compatibility of controller names
                $matching_name = array(
                    'authentication' => 'auth'
                );
                if (isset($matching_name[$controller]) && in_array($matching_name[$controller], $exceptions)) {
                    continue;
                }
                $ab = Validate::isLoadedObject($context->employee);
                if ($ab && !Module::getPermissionStatic($array['id_module'], 'view', $context->employee)) {
                    continue;
                }
            }
            if (!($moduleInstance = Module::getInstanceByName($array['module']))) {
                continue;
            }
            if ($use_push && !$moduleInstance->allow_push) {
                continue;
            }
            if ($isRegistryEnabled) {
                $hookRegistry->hookedByModule($moduleInstance);
            }
            if (self::isHookCallableOn($moduleInstance, $hook_name)) {
                $hook_args['altern'] = ++$altern;
                if ($use_push && isset($moduleInstance->push_filename) && file_exists($moduleInstance->push_filename)) {
                    Tools::waitUntilFileIsModified($moduleInstance->push_filename, $moduleInstance->push_time_limit);
                }
                if (0 !== $key && true === $chain) {
                    $hook_args = $output;
                }
                $display = self::callHookOn($moduleInstance, $hook_name, $hook_args);
                if ($array_return) {
                    $output[$moduleInstance->name] = $display;
                } else {
                    if (true === $chain) {
                        $output = $display;
                    } else {
                        $output .= $display;
                    }
                }
                if ($isRegistryEnabled) {
                    $hookRegistry->hookedByCallback($moduleInstance, $hook_args);
                }
            } elseif (Hook::isDisplayHookName($hook_name)) {
                if ($moduleInstance instanceof WidgetInterface) {
                    if (0 !== $key && true === $chain) {
                        $hook_args = $output;
                    }
                    $display = Hook::coreRenderWidget($moduleInstance, $hook_name, $hook_args);
                    if ($array_return) {
                        $output[$moduleInstance->name] = $display;
                    } else {
                        if (true === $chain) {
                            $output = $display;
                        } else {
                            $output .= $display;
                        }
                    }
                }
                if ($isRegistryEnabled) {
                    $hookRegistry->hookedByWidget($moduleInstance, $hook_args);
                }
            }
        }
        if ($different_shop) {
            $context->shop = $old_shop;
            $context->shop->setContext($old_context, $shop->id);
        }
        if (true === $chain) {
            if (isset($output['cookie'])) {
                unset($output['cookie']);
            }
            if (isset($output['cart'])) {
                unset($output['cart']);
            }
        }
        if ($isRegistryEnabled) {
            $hookRegistry->hookWasCalled();
            $hookRegistry->collect();
        }
        if ($abc == 1) {
            return $hook_args;
        }
        return $output;
    }
    public static function callHookOn($module, $hookName, $hookArgs)
    {
        if (is_callable(array($module, 'hook' . $hookName))) {
            return Hook::coreCallHook($module, 'hook' . $hookName, $hookArgs);
        }
        foreach (self::getHookAliasesFor($hookName) as $hook) {
            if (is_callable(array($module, 'hook' . $hook))) {
                return Hook::coreCallHook($module, 'hook' . $hook, $hookArgs);
            }
        }
        return '';
    }
    public static function isHookCallableOn($module, $hookName)
    {
        $aliases = self::getHookAliasesFor($hookName);
        $aliases[] = $hookName;
        return array_reduce($aliases, function ($prev, $curr) use ($module) {
            return $prev || is_callable(array($module, 'hook' . $curr));
        }, false);
    }
    public static function getHookAliasesList()
    {
        $cacheId = 'hook_aliases';
        if (!Cache::isStored($cacheId)) {
            $hookAliasList = Db::getInstance()->executeS('SELECT * FROM `'._DB_PREFIX_.'hook_alias`');
            $hookAliases = array();
            if ($hookAliasList) {
                foreach ($hookAliasList as $ha) {
                    if (!isset($hookAliases[$ha['name']])) {
                        $hookAliases[$ha['name']] = array();
                    }
                    $hookAliases[$ha['name']][] = $ha['alias'];
                }
            }
            Cache::store($cacheId, $hookAliases);
            return $hookAliases;
        }
        return Cache::retrieve($cacheId);
    }
    public static function getHookAliasesFor($hookName)
    {
        $cacheId = 'hook_aliases_' . $hookName;
        if (!Cache::isStored($cacheId)) {
            $aliasesList = self::getHookAliasesList();
            if (isset($aliasesList[$hookName])) {
                Cache::store($cacheId, $aliasesList[$hookName]);
                return $aliasesList[$hookName];
            }
            $retroName = array_keys(array_filter($aliasesList, function ($elem) use ($hookName) {
                return in_array($hookName, $elem);
            }));
            if (empty($retroName)) {
                Cache::store($cacheId, array());
                return array();
            }
            Cache::store($cacheId, $retroName);
            return $retroName;
        }
        return Cache::retrieve($cacheId);
    }
    public function regenerateThumbnails($type = 'all', $deleteOldImages = false)
    {
        $this->start_time = time();
        ini_set('max_execution_time', $this->max_execution_time); // ini_set may be disabled, we need the real value
        $this->max_execution_time = (int)ini_get('max_execution_time');
        $languages = Language::getLanguages(false);
        $process =
            array(
                array('type' => 'categories', 'dir' => _PS_CAT_IMG_DIR_),
                array('type' => 'manufacturers', 'dir' => _PS_MANU_IMG_DIR_),
                array('type' => 'suppliers', 'dir' => _PS_SUPP_IMG_DIR_),
                array('type' => 'scenes', 'dir' => _PS_SCENE_IMG_DIR_),
                array('type' => 'products', 'dir' => _PS_PROD_IMG_DIR_),
                array('type' => 'stores', 'dir' => _PS_STORE_IMG_DIR_)
            );
        // Launching generation process
        foreach ($process as $proc) {
            if ($type != 'all' && $type != $proc['type']) {
                continue;
            }
            // Getting format generation
            $formats = ImageType::getImagesTypes($proc['type']);
            if ($type != 'all') {
                $format = (string)Tools::getValue('format_'.$type);
                if ($format != 'all') {
                    foreach ($formats as $k => $form) {
                        if ($form['id_image_type'] != $format) {
                            unset($formats[$k]);
                        }
                    }
                }
            }
            if ($deleteOldImages) {
                $this->deleteOldImages($proc['dir'], $formats, ($proc['type'] == 'products' ? true : false));
            }
            $a = $proc['dir'];
            $b = $formats;
            $c = $proc['type'];
            if (($return = $this->regenerateNewImages($a, $b, ($c == 'products' ? true : false))) === true) {
                if (!count($this->errors)) {
                    $this->errors[] = sprintf(Tools::displayError('Cannot '), $proc['type'], $proc['dir']);
                }
            } elseif ($return == 'timeout') {
                $this->errors[] = Tools::displayError('Only part of');
            } else {
                if ($proc['type'] == 'products') {
                    if ($this->regenerateWatermark($proc['dir']) == 'timeout') {
                        $this->errors[] = 'Server timed out. The watermark may not have been applied to all images.';
                    }
                }
                if (!count($this->errors)) {
                    if ($this->regenerateNoPictureImages($proc['dir'], $formats, $languages)) {
                        $this->errors[] = sprintf(
                            Tools::displayError('Cannot write'),
                            $proc['type']
                        );
                    }
                }
            }
        }
        return (count($this->errors) > 0 ? false : true);
    }
    public function deleteOldImages($dir, $type, $product = false)
    {
        if (!is_dir($dir)) {
            return false;
        }
        $toDel = scandir($dir);
        foreach ($toDel as $d) {
            foreach ($type as $imageType) {
                if (preg_match('/^[0-9]+\-'.($product ? '[0-9]+\-' : '').$imageType['name'].'\.jpg$/', $d)
                    || (count($type) > 1 && preg_match('/^[0-9]+\-[_a-zA-Z0-9-]*\.jpg$/', $d))
                    || preg_match('/^([[:lower:]]{2})\-default\-'.$imageType['name'].'\.jpg$/', $d)) {
                    if (file_exists($dir.$d)) {
                        unlink($dir.$d);
                    }
                }
            }
        }
        // delete product images using new filesystem.
        if ($product) {
            $productsImages = Image::getAllImages();
            foreach ($productsImages as $image) {
                $imageObj = new Image($image['id_image']);
                $imageObj->id_product = $image['id_product'];
                if (file_exists($dir.$imageObj->getImgFolder())) {
                    $toDel = scandir($dir.$imageObj->getImgFolder());
                    foreach ($toDel as $d) {
                        foreach ($type as $imageType) {
                            $ab = preg_match('/^[0-9]+\-'.$imageType['name'].'\.jpg$/', $d);
                            $ac = preg_match('/^[0-9]+\-[_a-zA-Z0-9-]*\.jpg$/', $d);
                            if ($ab || (count($type) > 1 && $ac)) {
                                if (file_exists($dir.$imageObj->getImgFolder().$d)) {
                                    unlink($dir.$imageObj->getImgFolder().$d);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function regenerateNewImages($dir, $type, $productsImages = false)
    {
        if (!is_dir($dir)) {
            return false;
        }
        $errors = false;
        if (!$productsImages) {
            foreach (scandir($dir) as $image) {
                if (preg_match('/^[0-9]*\.jpg$/', $image)) {
                    foreach ($type as $k => $imageType) {
                        $k;
                        // Customizable writing dir
                        $newDir = $dir;
                        if ($imageType['name'] == 'thumb_scene') {
                            $newDir .= 'thumbs/';
                        }
                        if (!file_exists($newDir)) {
                            continue;
                        }
                        $abf = Tools::stripslashes($imageType['name']);
                        if (!file_exists($newDir.Tools::substr($image, 0, -4).'-'.$abf.'.jpg')) {
                            $a = $newDir.Tools::substr($image, 0, -4);
                            $b = Tools::stripslashes($imageType['name']);
                            $c = $imageType['width'];
                            $d = $imageType['height'];
                            if (!file_exists($dir.$image) || !filesize($dir.$image)) {
                                $errors = true;
                                $this->errors[] = 'Source file does not exist or is empty';
                            } elseif (!ImageManager::resize($dir.$image, $a.'-'.$b.'.jpg', (int)$c, (int)$d)) {
                                $errors = true;
                                $this->errors[] = 'Failed to resize image file';
                            }
                        }
                        if (time() - $this->start_time > $this->max_execution_time - 4) {
                            return 'timeout';
                        }
                    }
                }
            }
        } else {
            foreach (Image::getAllImages() as $image) {
                $imageObj = new Image($image['id_image']);
                $existing_img = $dir.$imageObj->getExistingImgPath().'.jpg';
                if (file_exists($existing_img) && filesize($existing_img)) {
                    foreach ($type as $imageType) {
                        $b = $imageObj->getExistingImgPath();
                        if (!file_exists($dir.$b.'-'.Tools::stripslashes($imageType['name']).'.jpg')) {
                            $a = $existing_img;
                            $c = Tools::stripslashes($imageType['name']);
                            $d = $imageType['width'];
                            $e = $imageType['height'];
                            if (!ImageManager::resize($a, $dir.$b.'-'.$c.'.jpg', (int)($d), (int)($e))) {
                                $errors = true;
                                $this->errors[] = 'Original image is corrupt';
                            }
                        }
                    }
                } else {
                    $errors = true;
                    $this->errors[] = 'Original image is missing or empty';
                }
                if (time() - $this->start_time > $this->max_execution_time - 4) {
                    return 'timeout';
                }
            }
        }
        return $errors;
    }
    /* Hook watermark optimization */
    public function regenerateWatermark($dir)
    {
        $result = Db::getInstance()->executeS('
        SELECT m.`name` FROM `'._DB_PREFIX_.'module` m
        LEFT JOIN `'._DB_PREFIX_.'hook_module` hm ON hm.`id_module` = m.`id_module`
        LEFT JOIN `'._DB_PREFIX_.'hook` h ON hm.`id_hook` = h.`id_hook`
        WHERE h.`name` = \'actionWatermark\' AND m.`active` = 1');
        if ($result && count($result)) {
            $productsImages = Image::getAllImages();
            foreach ($productsImages as $image) {
                $imageObj = new Image($image['id_image']);
                if (file_exists($dir.$imageObj->getExistingImgPath().'.jpg')) {
                    foreach ($result as $module) {
                        $moduleInstance = Module::getInstanceByName($module['name']);
                        if ($moduleInstance && is_callable(array($moduleInstance, 'hookActionWatermark'))) {
                            $a = array('id_image' => $imageObj->id, 'id_product' => $imageObj->id_product);
                            call_user_func(array($moduleInstance, 'hookActionWatermark'), $a);
                        }
                        if (time() - $this->start_time > $this->max_execution_time - 4) {
                            return 'timeout';
                        }
                    }
                }
            }
        }
    }
    public function regenerateNoPictureImages($dir, $type, $languages)
    {
        $errors = false;
        foreach ($type as $image_type) {
            foreach ($languages as $language) {
                $file = $dir.$language['iso_code'].'.jpg';
                if (!file_exists($file)) {
                    $file = _PS_PROD_IMG_DIR_.Language::getIsoById((int)Configuration::get('PS_LANG_DEFAULT')).'.jpg';
                }
                $abcd = Tools::stripslashes($image_type['name']);
                if (!file_exists($dir.$language['iso_code'].'-default-'.$abcd.'.jpg')) {
                    $a = $dir.$language['iso_code'].'-default-'.Tools::stripslashes($image_type['name']).'.jpg';
                    $b = $image_type['width'];
                    if (!ImageManager::resize($file, $dir.$a, (int)$b, (int)$image_type['height'])) {
                        $errors = true;
                    }
                }
            }
        }
        return $errors;
    }
    public function getBaseLink($id_shop = null, $ssl = null)
    {
        static $force_ssl = null;
        if ($ssl === null) {
            if ($force_ssl === null) {
                $force_ssl = (Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE'));
            }
            $ssl = $force_ssl;
        }
        if (Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE') && $id_shop !== null) {
            $shop = new Shop($id_shop);
        } else {
            $shop = Context::getContext()->shop;
        }
        $a = Configuration::get('PS_SSL_ENABLED');
        $base = (($ssl && $a) ? 'https://'.$shop->domain_ssl : 'http://'.$shop->domain);
        return $base.$shop->getBaseURI();
    }
    public function getMobiBaseLink($id_shop = null, $ssl = null)
    {
        static $force_ssl = null;
        if ($ssl === null) {
            if ($force_ssl === null) {
                $force_ssl = (Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE'));
            }
            $ssl = $force_ssl;
        }
        if (Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE') && $id_shop !== null) {
            $shop = new Shop($id_shop);
        } else {
            $shop = Context::getContext()->shop;
        }
        $a = Configuration::get('PS_SSL_ENABLED');
        $base = (($ssl && $a) ? 'https://'.$shop->domain_ssl : 'http://'.$shop->domain);
        return $base.$shop->getBaseURI();
    }
    public function cookiekeymodule()
    {
        $keygooglecookie = sha1(_COOKIE_KEY_ . 'presmobileapp');
        $md5file = md5($keygooglecookie);
        return $md5file;
    }
    public function transbv()
    {
        $transbv = new PresMobileApp();
        $v = $transbv->l('You do not have permission to access it.');
        return $v;
    }
}
