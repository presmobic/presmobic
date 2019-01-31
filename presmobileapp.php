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

class PresMobileApp extends Module
{
    public $demoMode = false;
    public function __construct()
    {
        $this->name = "presmobileapp";
        $this->tab = "mobile";
        $this->version = "1.0.0";
        $this->author = "buy-addons";
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
        $this->module_key = 'd9f1479a1f65dcf8c763f284dc5cf5ab';
        $this->displayName = $this->l('PresMobic - Prestashop Mobile Web Application');
        $this->description = $this->l('Create a Mobile Web App for Prestashop, make Prestashop Store better on mobile');
        parent::__construct();
    }
    public function disable($forceAll = false)
    {
        $forceAll;
        $ac = _PS_THEME_DIR_;
        if (Tools::version_compare(_PS_VERSION_, '1.7', '<')) {
            // rmdir(''.$ac.'mobile');
            $dir = _PS_THEME_DIR_.'mobile';
            if (file_exists($dir)) {
                $this->deleteDir(''.$ac.'mobile');
            }
            // unlink(''.$ac.'mobile');
            unlink(''.$ac.'mobile\layout.tpl');
        }
        $tab = new Tab((int) Tab::getIdFromClassName('AdminPressMobileApp'));
        $tab->delete();
        if (parent::disable() == false) {
            return false;
        }
        return true;
    }
    public function enable($forceAll = false)
    {
        $forceAll;
        if (Tools::version_compare(_PS_VERSION_, '1.7', '<')) {
            $dir = _PS_THEME_DIR_.'mobile';
            if (!file_exists($dir)) {
                mkdir($dir);
            }
            $ab = _PS_MODULE_DIR_;
            $ac = _PS_THEME_DIR_;
            copy(''.$ab.'presmobileapp\views\templates\admin\layout.tpl', ''.$ac.'mobile\layout.tpl');
            copy(''.$ab.'presmobileapp\views\templates\admin\layout_total.tpl', ''.$ac.'layout.tpl');
        }
        $tab_id = Tab::getIdFromClassName('AdminPressMobileApp');
        if ($tab_id === false) {
            $this->installTab('AdminPressMobileApp', 'PresMobic');
        }
        if (parent::enable() == false) {
            return false;
        }
        return true;
    }
    public function install()
    {
        if (Tools::version_compare(_PS_VERSION_, '1.7', '<')) {
            $ab = _PS_MODULE_DIR_;
            $ac = _PS_THEME_DIR_;
            copy(''.$ab.'presmobileapp\views\templates\admin\layout.tpl', ''.$ac.'mobile\layout.tpl');
            copy(''.$ab.'presmobileapp\views\templates\admin\layout_total.tpl', ''.$ac.'layout.tpl');
        }
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $create_table = 'CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'ba_mobileapp_block (
            `id` int(11) unsigned NOT NULL auto_increment,
            `name_block` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
            `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
            `params` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
            `position` int(11),
            `hook` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
            `id_shop` int(11),
            PRIMARY KEY (`id`) 
        )';
        $db->query($create_table);
        $create_table = 'CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'ba_mobic_cache (
            `id` int(11) unsigned NOT NULL auto_increment,
            `id_customer` int(11) DEFAULT NULL,
            `id_product` int(11) DEFAULT NULL,
            `key_mobic` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
            `body` longtext DEFAULT NULL,
            PRIMARY KEY (`id`) 
        )';
        $db->query($create_table);
        $sql = 'CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'ba_mobic_oder (
            `id` int(11) unsigned NOT NULL auto_increment,
            `id_order` int(11),
            PRIMARY KEY (`id`) 
        )';
        $db->query($sql);
        $create_table = 'CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'ba_mobic_comment (
            `id_product_comment` int(11) unsigned NOT NULL auto_increment,
            `id_product` int(11),
            `id_customer` int(11),
            `id_guest` int(11),
            `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
            `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
            `customer_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
            `grade` int(11),
            `validate` int(11),
            `deleted` int(11),
            `date_add` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`id_product_comment`) 
        )';
        $db->query($create_table);
        $list_id_shop = Shop::getCompleteListOfShopsID();
        foreach ($list_id_shop as $key => $value) {
            $key;
            $sql = "INSERT INTO " . _DB_PREFIX_ . "ba_mobileapp_block";
            $sql .= " VALUES ('','Header Bar','block-baheader.php','1','','1','[\"header\"]','".$value."')";
            $sql1 = "INSERT INTO " . _DB_PREFIX_ . "ba_mobileapp_block";
            $sql1 .= " VALUES ('','Slideshow','block-baslider.php','1','','1','[\"content\"]','".$value."')";
            $sql2 = "INSERT INTO " . _DB_PREFIX_ . "ba_mobileapp_block";
            $sql2 .= " VALUES ('','Latest Products','block-balatest.php','1','','2','[\"content\"]','".$value."')";
            $sql3 = "INSERT INTO " . _DB_PREFIX_ . "ba_mobileapp_block";
            $sql3 .= " VALUES ('','Whats client say','block-bacomment.php','1','','3','[\"content\"]','".$value."')";
            $sql4 = "INSERT INTO " . _DB_PREFIX_ . "ba_mobileapp_block";
            $sql4 .= " VALUES ('','Our Categories','block-bacategory.php','1','','4','[\"content\"]','".$value."')";
            $sql5 = "INSERT INTO " . _DB_PREFIX_ . "ba_mobileapp_block";
            $sql5 .= " VALUES ('','Featured Brands','block-bafeature.php','1','','5','[\"content\"]','".$value."')";
            $sql6 = "INSERT INTO " . _DB_PREFIX_ . "ba_mobileapp_block";
            $sql6 .= " VALUES ('','Footer Block','block-bafooter.php','1','','1','[\"footer\"]','".$value."')";
            $sql7 = "INSERT INTO " . _DB_PREFIX_ . "ba_mobileapp_block";
            $sql7 .= " VALUES ('','Search in Header Bar','block-basearchproduct.php',";
            $sql7 .= "'1','','1','[\"searchProduct\"]','".$value."')";
            $db->query($sql);
            $db->query($sql1);
            $db->query($sql2);
            $db->query($sql3);
            $db->query($sql4);
            $db->query($sql5);
            $db->query($sql6);
            $db->query($sql7);
        }
        $restapi_slider = 'CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'ba_premobic_slider (
            `id` int(11) unsigned NOT NULL auto_increment,
            `id_lang` int(11),
            `images` text,
            `name` text,
            `url_images` text,
            `date_create` text,
            `date_upd` text,
            `language` text,
            `position` int(11) ,
            `active` int(11) ,
            PRIMARY KEY (`id`) 
        )';
        $languages = Language::getLanguages();
        $images2 = 'views/img/slideshow/banner3.png';
        $images1 = 'views/img/slideshow/banner_1.png';
        $name2 = 'banner3.png';
        $name1 = 'banner_1.png';
        $date_create = date('Y-m-d H:i:s');
        $date_upd = date('Y-m-d H:i:s');
        $db->query($restapi_slider);
        $id_lang_default = Configuration::get('PS_LANG_DEFAULT');
        $id_language = Context::getContext()->language->id;
        $id_language;
        foreach ($languages as $key => $value) {
            if ($id_lang_default == $value['id_lang']) {
                $insert_premobic_slider = "INSERT INTO " . _DB_PREFIX_ . "ba_premobic_slider";
                $insert_premobic_slider .= "(`id_lang`,`images`,`name`, `date_create`, `date_upd`,";
                $insert_premobic_slider .= "`language`, `position`, `active`) ";
                $insert_premobic_slider .= "VALUES ('" . (int)$value['id_lang'] . "','" . pSQL($images1) . "',";
                $insert_premobic_slider .= "'" . pSQL($name1) . "', '" . pSQL($date_create) . "',";
                $insert_premobic_slider .= "'" . pSQL($date_upd) . "','" . pSQL($value['name']) . "', 1,1)";
                $db->query($insert_premobic_slider);
            } else {
                $insert_premobic_slider = "INSERT INTO " . _DB_PREFIX_ . "ba_premobic_slider";
                $insert_premobic_slider .= "(`id_lang`,`images`,`name`, `date_create`, `date_upd`,";
                $insert_premobic_slider .= "`language`, `position`, `active`) ";
                $insert_premobic_slider .= "VALUES ('" . (int)$value['id_lang'] . "','" . pSQL($images2) . "',";
                $insert_premobic_slider .= "'" . pSQL($name2) . "', '" . pSQL($date_create) . "',";
                $insert_premobic_slider .= "'" . pSQL($date_upd) . "','" . pSQL($value['name']) . "', 2,1)";
                $db->query($insert_premobic_slider);
            }
        }
        $this->installTab('AdminPressMobileApp', 'PresMobic');
        if (parent::install() == false) {
            return false;
        }
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/configs/defines.inc.php');
        $re_hook = Tools::jsonDecode(_PS_MOBIC_HOOK_RE_, true);
        ;
        foreach ($re_hook as $key => $value) {
            $sql = "SELECT *FROM " . _DB_PREFIX_ . "hook WHERE name='".pSQL($value)."'";
            $param = $db->Executes($sql);
            if (empty($param)) {
                $this->preInstallHook($value);
            }
        }
        Configuration::updateValue('cacheapp', '5', false, '', null);
        Configuration::updateValue('cache_add', '1', false, '', null);
        $this->registerHook('OrderConfirmation');
        $this->registerHook('presmobicDisplayAfterLogo');
        $this->registerHook("displayFooter");
        $this->registerHook("actionDispatcher");
        $this->registerHook("displayTop");
        $this->registerHook("displayBackOfficeHeader");
        $id_hook = Hook::getIdByName('displayTop');
        $this->updatePosition($id_hook, 1, 1);
        return true;
    }
    public function uninstall()
    {
        if (parent::uninstall() == false) {
            return false;
        }
        $tab = new Tab((int) Tab::getIdFromClassName('AdminPressMobileApp'));
        $tab->delete();
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $sql = "DROP TABLE IF EXISTS " . _DB_PREFIX_ . "ba_mobileapp_block";
        $sql1 = "DROP TABLE IF EXISTS " . _DB_PREFIX_ . "ba_mobic_cache";
        $sql2 = "DROP TABLE IF EXISTS " . _DB_PREFIX_ . "ba_premobic_slider";
        $sql3 = "DROP TABLE IF EXISTS " . _DB_PREFIX_ . "ba_mobic_comment";
        $db->query($sql3);
        $db->query($sql2);
        $db->query($sql);
        $db->query($sql1);
        $ac = _PS_THEME_DIR_;
        if (Tools::version_compare(_PS_VERSION_, '1.7', '<')) {
            unlink(''.$ac.'mobile\layout.tpl');
        }
        // Tools::clearSmartyCache();
        // Tools::clearXMLCache();
        // Media::clearCache();
        $this->unregisterHook('OrderConfirmation');
        $this->unregisterHook("displayFooter");
        $this->unregisterHook("displayTop");
        $this->unregisterHook("actionDispatcher");
        $this->unregisterHook("presmobic_before_add_to_cart");
        $this->unregisterHook("displayBackOfficeHeader");
        return true;
    }
    
    // hook icon order mobile
    public function hookDisplayBackOfficeHeader()
    {
        $this->context->controller->addCss($this->_path . 'views/css/tabr.css');
    }
    public function hookDisplayTop()
    {
        $id_shop = $this->context->shop->id;
        $mobi_secure = Configuration::get('mobi_secure', null, '', $id_shop);
        $debug_add = Configuration::get('debug_add', null, '', $id_shop);
        if ($debug_add == 1) {
            $secure_mobi = (string)Tools::getValue('secure');
            if ($mobi_secure == $secure_mobi) {
                $this->getHtml17();
            }
        } else {
            $this->getHtml17();
        }
    }
    public function hookactionDispatcher()
    {
    }
    // hook khi thanh toán xong
    public function hookOrderConfirmation()
    {
        $url_fodel = _PS_MODULE_DIR_;
        $id_order = Tools::getValue("id_order");
        include_once($url_fodel.'presmobileapp/includes/Presmobic-mobiledetect.php');
        $core = new BaMobileDetect();
        $check_mobile = $core->isMobile();
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $corea = new BaCore();
        $url = $corea->getMobiBaseLink();
        $url;
        if ($check_mobile == '1') {
            $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
            $sql = "INSERT INTO " . _DB_PREFIX_ . "ba_mobic_oder VALUES('',".(int)$id_order.")";
            $db->query($sql);
            echo $id_order;
            die;
            // header('Location: '.$url.'#checkoutsuccess:'.$id_order.'');
        }
    }
    public function hookdisplayFooter()
    {
        $id_shop = $this->context->shop->id;
        $mobi_secure = Configuration::get('mobi_secure', null, '', $id_shop);
        $debug_add = Configuration::get('debug_add', null, '', $id_shop);
        if ($debug_add == 1) {
            $secure_mobi = Tools::getValue('secure');
            if ($mobi_secure == $secure_mobi) {
                $this->getHtml16();
            }
        } else {
            $this->getHtml16();
        }
    }
    public function getHtml17()
    {
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=')) {
            $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
            $linkimages = new Link();
            $context = Context::getContext();
            $language = Language::getLanguages();
            $controler = (string)Tools::getValue('controller');
            $id_product = (int)Tools::getValue('id_product');
            $id_category = (int)Tools::getValue('id_category');
            $url_fodel = _PS_MODULE_DIR_;
            $id_lang = $context->language->id;
            $is_shop = $context->shop->id;
            include_once($url_fodel.'presmobileapp/includes/Presmobic-mobiledetect.php');
            include_once($url_fodel.'presmobileapp/configs/defines.inc.php');
            include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
            include_once($url_fodel.'presmobileapp/includes/Presmobic-bahook.php');
            $core = new BaCore();
            $url = $core->getMobiBaseLink();
            $html = '';
            $mobile_core = new BaMobileDetect();
            $check_mobile = $mobile_core->isMobile();
            $comment_time = Configuration::get('PRODUCT_COMMENTS_MINIMAL_TIME');
            $shop_name = Configuration::get('PS_SHOP_NAME');
            $url_redirect = '';
            if (count($language) >= 2) {
                $url_redirect .= $url.$context->language->iso_code.'/';
            } else {
                $url_redirect .= $url;
            }
            $token = $this->cookiekeymodule();
            $ignore_redirect = Tools::isSubmit('ignore_redirect');
            if ($check_mobile == '1' && $ignore_redirect !='1') {
                $mobic_link = Tools::jsonDecode(_PS_MOBIC_REDRIEC_, true);
                foreach ($mobic_link as $key => $value) {
                    if ($controler == $value['controller']) {
                        if ($controler == 'product') {
                            Tools::redirect('Location: '.$url_redirect.'#product:'.$id_product.'');
                        } elseif ($controler == 'category') {
                            Tools::redirect('Location: '.$url_redirect.'#category:'.$id_category.'');
                        } else {
                            Tools::redirect('Location: '.$url_redirect.'#'.$key.'');
                        }
                    }
                }
                $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE active=1 ";
                $sql .= " AND id_shop=".(int)$is_shop." AND hook LIKE '%header%' ORDER BY position ASC";
                $param_header = $db->Executes($sql);
                $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE active=1 AND ";
                $sql .= "hook LIKE '%content%'  AND id_shop=".(int)$is_shop." ORDER BY position ASC";
                $param_content = $db->Executes($sql);
                $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE active=1 ";
                $sql .= " AND id_shop=".(int)$is_shop." AND hook LIKE '%footer%' ORDER BY position ASC";
                $param_footer = $db->Executes($sql);
                $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE active=1 ";
                $sql .= " AND id_shop=".(int)$is_shop." AND hook LIKE '%PresMobisearchProduct%' ORDER BY position ASC";
                $param_PresMobisearchProduct = $db->Executes($sql);
                $header_block = '';
                $content_block = '';
                $footer_block = '';
                $PresMobisearchProduct_block = '';
                foreach ($param_header as $key => $value) {
                    $file_cut = str_replace(array('block-', '.php'), '', $value['file']);
                    include_once($url_fodel.'presmobileapp/blocks/'.$value['file']);
                    $html_block = new $file_cut();
                    $header_block .= $html_block->render();
                }
                foreach ($param_content as $key => $value) {
                    $file_cut = str_replace(array('block-', '.php'), '', $value['file']);
                    include_once($url_fodel.'presmobileapp/blocks/'.$value['file']);
                    $html_block = new $file_cut();
                    $content_block .= $html_block->render();
                }
                foreach ($param_footer as $key => $value) {
                    $file_cut = str_replace(array('block-', '.php'), '', $value['file']);
                    include_once($url_fodel.'presmobileapp/blocks/'.$value['file']);
                    $html_block = new $file_cut();
                    $footer_block .= $html_block->render();
                }
                foreach ($param_PresMobisearchProduct as $key => $value) {
                    $file_cut = str_replace(array('block-', '.php'), '', $value['file']);
                    include_once($url_fodel.'presmobileapp/blocks/'.$value['file']);
                    $html_block = new $file_cut();
                    $PresMobisearchProduct_block .= $html_block->render();
                }
                $sql2 = "SELECT * FROM " . _DB_PREFIX_ . "category p JOIN " . _DB_PREFIX_ . "category_lang pl";
                $sql2 .= " ON p.id_category=pl.id_category";
                $sql2 .= " WHERE p.level_depth=2 AND pl.id_shop=".(int)$is_shop." AND pl.id_lang=".(int)$id_lang."";
                $data = $db->Executes($sql2);
                foreach ($data as $key => $value) {
                    $img = $linkimages->getCatImageLink('category', $value['id_category']);
                    if (file_exists(_PS_CAT_IMG_DIR_.(int)$value['id_category'].'.jpg')) {
                        $data[$key]['link_img'] = strstr($img, 'img/c');
                    } else {
                        $data[$key]['link_img'] = 'modules/presmobileapp/views/img/backgroundnoimg.png';
                    }
                }
                $context = Context::getContext();
                $url_fodel = _PS_MODULE_DIR_;
                $cart = $core->presMobicartresult();
                $hook_array = (array)Tools::jsonDecode(_PS_MOBIC_HOOK_);
                $hook_displayFooter = '';
                $hook_header = '';
                $hook_top = '';
                $this->resertController('index');
                $this->resertController('product');
                $_GET['controller'] = 'order';
                $d = Dispatcher::getInstance();
                $d->controller = 'order';
                $context->controller->php_self = 'order';
                $bc = _PS_VERSION_;
                if (Tools::version_compare($bc, '1.7.0', '>=') && Tools::version_compare($bc, '1.7.4', '<')) {
                    $hook_header = $core->mobiexec172('displayHeader', array(), $hook_array['displayHeader']);
                    $hook_header_av = $core->mobiexec172('Header', array(), $hook_array['displayHeader']);
                    $hook_displayNav = $core->mobiexec172('displayNav', array(), $hook_array['displayNav']);
                    $hook_displayHome = $core->mobiexec172('displayHome', array(), $hook_array['displayHome']);
                    $hook_displayHomeTab = $core->mobiexec172('displayHomeTab', array(), $hook_array['displayHomeTab']);
                    $am = $hook_array['displayHomeTabContent'];
                    $hook_displayHomeTabContent = $core->mobiexec172('displayHomeTabContent', array(), $am);
                    $presmobicDisplayBeforeHeader = $core->mobiexec172('presmobicDisplayBeforeHeader', array());
                    $presmobicDisplayBeforeLogo = $core->mobiexec172('presmobicDisplayBeforeLogo', array());
                    $presmobicDisplayAfterLogo = $core->mobiexec172('presmobicDisplayAfterLogo', array());
                    $presmobicDisplayBeforeMiniCart = $core->mobiexec172('presmobicDisplayBeforeMiniCart', array());
                    $presmobicDisplayAfterMiniCart = $core->mobiexec172('presmobicDisplayAfterMiniCart', array());
                    $presmobicDisplayAfterHeader =  $core->mobiexec172('presmobicDisplayAfterHeader', array());
                    $presmobicDisplayBeforeTextStatic = $core->mobiexec172('presmobicDisplayBeforeTextStatic', array());
                    $presmobicDisplayFooter = $core->mobiexec172('presmobicDisplayFooter', array());
                    $presmobicDisplayBeforeNewsletter = $core->mobiexec172('presmobicDisplayBeforeNewsletter', array());
                    $presmobicDisplayAfterNewsletter = $core->mobiexec172('presmobicDisplayAfterNewsletter', array());
                    $presmobicDisplayBeforeFooterText = $core->mobiexec172('presmobicDisplayBeforeFooterText', array());
                    $presmobicDisplayAfterFooterText = $core->mobiexec172('presmobicDisplayAfterFooterText', array());
                    $presmobicDisplayBeforeSocialFooter = $core->mobiexec172('presmobicDisplayBeforeSocialFooter');
                    $presmobicDisplayAfterSocialFooter = $core->mobiexec172('presmobicDisplayAfterSocialFooter');
                    $presmobicDisplayAfterFooter = $core->mobiexec172('presmobicDisplayAfterFooter', array());
                    $presmobic_afteraccountSetting = $core->mobiexec172('presmobic_afteraccountSetting', array());
                    $presmobic_beforeaccountSetting = $core->mobiexec172('presmobic_beforeaccountSetting', array());
                    $presmobic_beforeaccountInfomartion = $core->mobiexec172('presmobic_beforeaccountInfomartion');
                    $presmobic_afteraccountInfomartion = $core->mobiexec172('presmobic_afteraccountInfomartion');
                } else {
                    $hook_header = $core->mobiexec17('displayHeader', array(), $hook_array['displayHeader']);
                    $hook_header_av = $core->mobiexec17('Header', array(), $hook_array['displayHeader']);
                    $hook_displayNav = $core->mobiexec17('displayNav', array(), $hook_array['displayNav']);
                    $hook_displayHome = $core->mobiexec17('displayHome', array(), $hook_array['displayHome']);
                    $hook_displayHomeTab = $core->mobiexec17('displayHomeTab', array(), $hook_array['displayHomeTab']);
                    $aj = $hook_array['displayHomeTabContent'];
                    $hook_displayHomeTabContent = $core->mobiexec17('displayHomeTabContent', array(), $aj);
                    $presmobicDisplayBeforeHeader = $core->mobiexec17('presmobicDisplayBeforeHeader', array());
                    $presmobicDisplayBeforeLogo = $core->mobiexec17('presmobicDisplayBeforeLogo', array());
                    $presmobicDisplayAfterLogo = $core->mobiexec17('presmobicDisplayAfterLogo', array());
                    $presmobicDisplayBeforeMiniCart = $core->mobiexec17('presmobicDisplayBeforeMiniCart', array());
                    $presmobicDisplayAfterMiniCart = $core->mobiexec17('presmobicDisplayAfterMiniCart', array());
                    $presmobicDisplayAfterHeader =  $core->mobiexec17('presmobicDisplayAfterHeader', array());
                    $presmobicDisplayBeforeTextStatic = $core->mobiexec17('presmobicDisplayBeforeTextStatic', array());
                    $presmobicDisplayFooter = $core->mobiexec17('presmobicDisplayFooter', array());
                    $presmobicDisplayBeforeNewsletter = $core->mobiexec17('presmobicDisplayBeforeNewsletter', array());
                    $presmobicDisplayAfterNewsletter = $core->mobiexec17('presmobicDisplayAfterNewsletter', array());
                    $presmobicDisplayBeforeFooterText = $core->mobiexec17('presmobicDisplayBeforeFooterText', array());
                    $presmobicDisplayAfterFooterText = $core->mobiexec17('presmobicDisplayAfterFooterText', array());
                    $presmobicDisplayBeforeSocialFooter = $core->mobiexec17('presmobicDisplayBeforeSocialFooter');
                    $presmobicDisplayAfterSocialFooter = $core->mobiexec17('presmobicDisplayAfterSocialFooter');
                    $presmobicDisplayAfterFooter = $core->mobiexec17('presmobicDisplayAfterFooter', array());
                    $presmobic_afteraccountSetting = $core->mobiexec17('presmobic_afteraccountSetting', array());
                    $presmobic_beforeaccountSetting = $core->mobiexec17('presmobic_beforeaccountSetting', array());
                    $presmobic_beforeaccountInfomartion = $core->mobiexec17('presmobic_beforeaccountInfomartion');
                    $presmobic_afteraccountInfomartion = $core->mobiexec17('presmobic_afteraccountInfomartion');
                }
                $preslanguage = Language::getLanguages(true);
                $id_lang_default = $context->cookie->id_lang;
                $name_language_default = $context->language->name;
                $iso_language_default = $context->language->iso_code;
                $sql_description = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang ";
                $sql_description .= "WHERE id_lang=".(int)$id_lang_default."";
                $sql_description .= " AND id_shop=".(int)$is_shop." AND id_meta=4";
                $description = $db->Executes($sql_description);
                $lists_currency = Currency::getCurrencies();
                $id_currency_default = $context->currency->id;
                $code_currency_default = $context->currency->iso_code;
                $infor_currency = Currency::getCurrency($id_currency_default);
                $infor_currency;
                $minium_price = Configuration::get('PS_PURCHASE_MINIMUM');
                $minium_price;
                $rtl = new Language($id_lang);
                $rtl = $rtl->is_rtl;
                $cache_add = Configuration::get('cache_add');
                $cacheapp = Configuration::get('cacheapp');
                $this->smarty->assign('cacheapp', $cacheapp);
                $this->smarty->assign('cache_add', $cache_add);
                $this->context->smarty->assign('rtl', $rtl);
                $css_js = $context->controller;
                $display_js = $css_js->getJavascript();
                $display_jsdef = Media::getJsDef();
                $display_css = $css_js->getStylesheets();
                $ag = Configuration::get('PS_SSL_ENABLED');
                $useSSL = ((isset($this->ssl) && $this->ssl && $ag) || Tools::usingSecureMode()) ? true : false;
                $protocol_content = ($useSSL) ? 'https://' : 'http://';
                $af = Configuration::get('PS_REWRITING_SETTINGS');
                $context->smarty->assign(array(
                    'base_dir' => _PS_BASE_URL_.__PS_BASE_URI__,
                    'base_uri' => $protocol_content.Tools::getHttpHost().__PS_BASE_URI__.(!$af ? 'index.php' : ''),
                    'static_token' => Tools::getToken(false),
                    'token' => Tools::getToken(),
                    'priceDisplayPrecision' => _PS_PRICE_DISPLAY_PRECISION_,
                    'currency' => Tools::setCurrency($this->context->cookie),
                    'priceDisplay' => Product::getTaxCalculationMethod((int)$this->context->cookie->id_customer),
                    'roundMode' => (int)Configuration::get('PS_PRICE_ROUND_MODE'),
                    'is_logged' => (bool)$this->context->customer->isLogged(),
                    'is_guest' => (bool)$this->context->customer->isGuest(),
                    'content_only' => (int)Tools::getValue('content_only'),
                    'quick_view' => (bool)Configuration::get('PS_QUICK_VIEW'),
                    'page_name' => Configuration::get('PS_SHOP_NAME'),
                    'usingSecureMode' => (bool)Tools::usingSecureMode(),
                    'ajaxsearch' => (bool)Configuration::get('PS_SEARCH_AJAX'),
                    'instantsearch' => (bool)Configuration::get('PS_INSTANT_SEARCH'),
                    'id_lang' => $id_lang
                ));
                $checkbox = 0;
                if (Tools::version_compare(_PS_VERSION_, '1.6.1.0', '>=')) {
                    $checkbox = 1;
                }
                $install_stripe_official = Module::isInstalled("stripe_official");
                $pres_hook = new Bahook();
                $pres_hook;
                $context->smarty->assign("presmobic_afteraccountSetting", $presmobic_afteraccountSetting);
                $context->smarty->assign("presmobic_beforeaccountSetting", $presmobic_beforeaccountSetting);
                $context->smarty->assign("presmobic_beforeaccountInfomartion", $presmobic_beforeaccountInfomartion);
                $context->smarty->assign("presmobic_afteraccountInfomartion", $presmobic_afteraccountInfomartion);
                $context->smarty->assign("install_stripe_official", $install_stripe_official);
                $context->smarty->assign("presmobicDisplayBeforeFooterText", $presmobicDisplayBeforeFooterText);
                $context->smarty->assign("presmobicDisplayAfterFooterText", $presmobicDisplayAfterFooterText);
                $context->smarty->assign("presmobicDisplayBeforeSocialFooter", $presmobicDisplayBeforeSocialFooter);
                $context->smarty->assign("presmobicDisplayAfterSocialFooter", $presmobicDisplayAfterSocialFooter);
                $context->smarty->assign("presmobicDisplayAfterFooter", $presmobicDisplayAfterFooter);
                $context->smarty->assign("presmobicDisplayBeforeNewsletter", $presmobicDisplayBeforeNewsletter);
                $context->smarty->assign("presmobicDisplayAfterNewsletter", $presmobicDisplayAfterNewsletter);
                $context->smarty->assign("presmobicDisplayFooter", $presmobicDisplayFooter);
                $context->smarty->assign("presmobicDisplayBeforeHeader", $presmobicDisplayBeforeHeader);
                $context->smarty->assign("presmobicDisplayBeforeTextStatic", $presmobicDisplayBeforeTextStatic);
                $context->smarty->assign("presmobicDisplayBeforeLogo", $presmobicDisplayBeforeLogo);
                $context->smarty->assign("presmobicDisplayAfterLogo", $presmobicDisplayAfterLogo);
                $context->smarty->assign("presmobicDisplayBeforeMiniCart", $presmobicDisplayBeforeMiniCart);
                $context->smarty->assign("presmobicDisplayAfterMiniCart", $presmobicDisplayAfterMiniCart);
                $context->smarty->assign("presmobicDisplayAfterHeader", $presmobicDisplayAfterHeader);
                $context->smarty->assign("checkbox", $checkbox);
                $context->smarty->assign("token_pres", $this->presscookiekeymodule());
                $context->smarty->assign("check_ssl", Configuration::get('PS_REWRITING_SETTINGS'));
                $context->smarty->assign("version_mobi", _PS_VERSION_);
                $context->smarty->assign("js_def", $display_jsdef);
                $context->smarty->assign("javascript", $display_js);
                $context->smarty->assign("ssl_check", Configuration::get('PS_SSL_ENABLED'));
                $context->smarty->assign("ssl_onpage", Configuration::get('PS_SSL_ENABLED_EVERYWHERE'));
                $context->smarty->assign("stylesheets", $display_css);
                $context->smarty->assign("hook_displayFooter", $hook_displayFooter);
                $context->smarty->assign("hook_displayHome", $hook_displayHome);
                $context->smarty->assign("hook_displayHomeTabContent", $hook_displayHomeTabContent);
                $context->smarty->assign("hook_displayHomeTab", $hook_displayHomeTab);
                $context->smarty->assign("hook_header", $hook_header);
                $context->smarty->assign("hook_header_av", $hook_header_av);
                $context->smarty->assign("hook_displayNav", $hook_displayNav);
                $context->smarty->assign("hook_top", $hook_top);
                $context->smarty->assign("cart", $cart);
                $context->smarty->assign("description", $description);
                $context->smarty->assign("shop_name", $shop_name);
                $context->smarty->assign("comment_time", $comment_time);
                $context->smarty->assign("language", $preslanguage);
                $context->smarty->assign("languagedefault", $id_lang_default);
                $context->smarty->assign("currency", $lists_currency);
                $context->smarty->assign("currencydefault", $id_currency_default);
                $context->smarty->assign("code_currencydefault", $code_currency_default);
                $context->smarty->assign("name_language_default", $name_language_default);
                $context->smarty->assign("lang_iso", $iso_language_default);
                $this->context->smarty->assign('header', $header_block);
                $this->context->smarty->assign('content', $content_block);
                $this->context->smarty->assign('footer', $footer_block);
                $this->context->smarty->assign('PresMobisearchProduct', $PresMobisearchProduct_block);
                $this->context->smarty->assign('baseDir', $url);
                $this->context->smarty->assign('token', $token);
                $context->smarty->assign("category", $data);
                $facebook =  Configuration::get('facebook');
                $twitter =  Configuration::get('twitter');
                $google =  Configuration::get('google');
                $this->context->smarty->assign('facebook', $facebook);
                $this->context->smarty->assign('twitter', $twitter);
                $this->context->smarty->assign('google', $google);
                $html .= $this->display(__FILE__, 'views/templates/hook/front/home.tpl');
                die($html);
            } else {
                $this->context->controller->addJS($this->_path.'views/js/redirectpage.js');
            }
            $demomodepremobic = Configuration::get('demoModepremobic', null, '', $is_shop);
            if ($demomodepremobic == 1) {
                $this->context->controller->addJS($this->_path.'views/js/demomode.js');
            }
        }
    }
    public function getHtml16()
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $url_fodel = _PS_MODULE_DIR_;
        $linkimages = new Link();
        $context = Context::getContext();
        $language = Language::getLanguages();
        $controler = Tools::getValue('controller');
        $id_product = Tools::getValue('id_product');
        $id_category = Tools::getValue('id_category');
        $id_lang = $context->language->id;
        $is_shop = $context->shop->id;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-mobiledetect.php');
        include_once($url_fodel.'presmobileapp/configs/defines.inc.php');
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        include_once($url_fodel.'presmobileapp/includes/Presmobic-bahook.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $html = '';
        $core = new BaMobileDetect();
        $check_mobile = $core->isMobile();
        $comment_time = Configuration::get('PRODUCT_COMMENTS_MINIMAL_TIME');
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $url_redirect = '';
        if (count($language) >= 2) {
            $url_redirect .= $url.$context->language->iso_code.'/';
        } else {
            $url_redirect .= $url;
        }
        $token = $this->cookiekeymodule();
        $ignore_redirect = Tools::isSubmit('ignore_redirect');
        if ($check_mobile == '1' && $ignore_redirect !='1') {
            $mobic_link = Tools::jsonDecode(_PS_MOBIC_REDRIEC_, true);
            foreach ($mobic_link as $key => $value) {
                if ($controler == $value['controller']) {
                    if ($controler == 'product') {
                        Tools::redirect('Location: '.$url_redirect.'#product:'.$id_product.'');
                    } elseif ($controler == 'category') {
                        Tools::redirect('Location: '.$url_redirect.'#category:'.$id_category.'');
                    } else {
                        Tools::redirect('Location: '.$url_redirect.'#'.$key.'');
                    }
                }
            }
            $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE active=1 ";
            $sql .= " AND id_shop=".(int)$is_shop." AND hook LIKE '%header%' ORDER BY position ASC";
            $param_header = $db->Executes($sql);
            $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE active=1 AND ";
            $sql .= "hook LIKE '%content%'  AND id_shop=".(int)$is_shop." ORDER BY position ASC";
            $param_content = $db->Executes($sql);
            $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE active=1 ";
            $sql .= " AND id_shop=".(int)$is_shop." AND hook LIKE '%footer%' ORDER BY position ASC";
            $param_footer = $db->Executes($sql);
            $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE active=1 ";
            $sql .= " AND id_shop=".(int)$is_shop." AND hook LIKE '%PresMobisearchProduct%' ORDER BY position ASC";
            $param_PresMobisearchProduct = $db->Executes($sql);
            $header_block = '';
            $content_block = '';
            $footer_block = '';
            $PresMobisearchProduct_block = '';
            foreach ($param_header as $key => $value) {
                $file_cut = str_replace(array('block-', '.php'), '', $value['file']);
                include_once($url_fodel.'presmobileapp/blocks/'.$value['file']);
                $html_block = new $file_cut();
                $header_block .= $html_block->render();
            }
            foreach ($param_content as $key => $value) {
                $file_cut = str_replace(array('block-', '.php'), '', $value['file']);
                include_once($url_fodel.'presmobileapp/blocks/'.$value['file']);
                $html_block = new $file_cut();
                $content_block .= $html_block->render();
            }
            foreach ($param_footer as $key => $value) {
                $file_cut = str_replace(array('block-', '.php'), '', $value['file']);
                include_once($url_fodel.'presmobileapp/blocks/'.$value['file']);
                $html_block = new $file_cut();
                $footer_block .= $html_block->render();
            }
            foreach ($param_PresMobisearchProduct as $key => $value) {
                $file_cut = str_replace(array('block-', '.php'), '', $value['file']);
                include_once($url_fodel.'presmobileapp/blocks/'.$value['file']);
                $html_block = new $file_cut();
                $PresMobisearchProduct_block .= $html_block->render();
            }
            $sql2 = "SELECT * FROM " . _DB_PREFIX_ . "category p JOIN " . _DB_PREFIX_ . "category_lang pl";
            $sql2 .= " ON p.id_category=pl.id_category";
            $sql2 .= " WHERE p.level_depth=2 AND pl.id_shop=".(int)$is_shop." AND pl.id_lang=".(int)$id_lang."";
            $data = $db->Executes($sql2);
            foreach ($data as $key => $value) {
                $img = $linkimages->getCatImageLink('category', $value['id_category']);
                if (file_exists(_PS_CAT_IMG_DIR_.(int)$value['id_category'].'.jpg')) {
                    $data[$key]['link_img'] = strstr($img, 'img/c');
                } else {
                    $data[$key]['link_img'] = 'modules/presmobileapp/views/img/backgroundnoimg.png';
                }
            }
            $context = Context::getContext();
            $url_fodel = _PS_MODULE_DIR_;
            include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
            $core = new BaCore();
            $cart = $core->presMobicartresult();
            $hook_array = (array)Tools::jsonDecode(_PS_MOBIC_HOOK_);
            $hook_displayFooter = '';
            $hook_header = '';
            $hook_top = '';
            $hook_header = $core->mobiexec('displayHeader', array(), $hook_array['displayHeader']);
            $hook_header_av = $core->mobiexec('Header', array(), $hook_array['displayHeader']);
            $hook_top = $core->mobiexec('displayTop', array(), $hook_array['displayTop']);
            $hook_displayNav = $core->mobiexec('displayNav', array(), $hook_array['displayNav']);
            $hook_displayHome = $core->mobiexec('displayHome', array(), $hook_array['displayHome']);
            $hook_displayHomeTab = $core->mobiexec('displayHomeTab', array(), $hook_array['displayHomeTab']);
            $ad = $hook_array['displayHomeTabContent'];
            $hook_displayHomeTabContent = $core->mobiexec('displayHomeTabContent', array(), $ad);
            $preslanguage = Language::getLanguages(true);
            $id_lang_default = $context->cookie->id_lang;
            $name_language_default = $context->language->name;
            $iso_language_default = $context->language->iso_code;
            $sql_description = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang_default." ";
            $sql_description .= "AND id_shop=".(int)$is_shop." AND id_meta=4";
            $description = $db->Executes($sql_description);
            $lists_currency = Currency::getCurrencies();
            $id_currency_default = $context->currency->id;
            $code_currency_default = $context->currency->iso_code;
            $infor_currency = Currency::getCurrency($id_currency_default);
            $infor_currency;
            $minium_price = Configuration::get('PS_PURCHASE_MINIMUM');
            $minium_price;
            $rtl = new Language($id_lang);
            $rtl = $rtl->is_rtl;
            $cache_add = Configuration::get('cache_add');
            $cacheapp = Configuration::get('cacheapp');
            $this->smarty->assign('cacheapp', $cacheapp);
            $this->smarty->assign('cache_add', $cache_add);
            $this->context->smarty->assign('rtl', $rtl);
            $css_js = $context->controller;
            $display_js = $css_js->js_files;
            $display_jsdef = Media::getJsDef();
            $display_css = $css_js->css_files;
            unset($display_js[0]);
            unset($display_js[1]);
            unset($display_js[2]);
            $display_js = array_values($display_js);
            $an = Configuration::get('PS_SSL_ENABLED');
            $useSSL = ((isset($this->ssl) && $this->ssl && $an) || Tools::usingSecureMode()) ? true : false;
            $protocol_content = ($useSSL) ? 'https://' : 'http://';
            $ac = Configuration::get('PS_REWRITING_SETTINGS');
            $context->smarty->assign(array(
                'base_dir' => _PS_BASE_URL_.__PS_BASE_URI__,
                'base_uri' => $protocol_content.Tools::getHttpHost().__PS_BASE_URI__.(!$ac ? 'index.php' : ''),
                'static_token' => Tools::getToken(false),
                'token' => Tools::getToken(),
                'priceDisplayPrecision' => _PS_PRICE_DISPLAY_PRECISION_,
                'currency' => Tools::setCurrency($this->context->cookie),
                'priceDisplay' => Product::getTaxCalculationMethod((int)$this->context->cookie->id_customer),
                'roundMode' => (int)Configuration::get('PS_PRICE_ROUND_MODE'),
                'is_logged' => (bool)$this->context->customer->isLogged(),
                'is_guest' => (bool)$this->context->customer->isGuest(),
                'content_only' => (int)Tools::getValue('content_only'),
                'quick_view' => (bool)Configuration::get('PS_QUICK_VIEW'),
                'usingSecureMode' => (bool)Tools::usingSecureMode(),
                'ajaxsearch' => (bool)Configuration::get('PS_SEARCH_AJAX'),
                'instantsearch' => (bool)Configuration::get('PS_INSTANT_SEARCH'),
                'id_lang' => $id_lang
            ));
            $checkbox = 0;
            if (Tools::version_compare(_PS_VERSION_, '1.6.1.0', '>=')) {
                $checkbox = 1;
            }
            $install_stripe_official = Module::isInstalled("stripe_official");
            $pres_hook = new Bahook();
            $pres_hook;
            $presmobicDisplayBeforeHeader = $core->mobiexec('presmobicDisplayBeforeHeader', array());
            $presmobicDisplayBeforeLogo = $core->mobiexec('presmobicDisplayBeforeLogo', array());
            $presmobicDisplayAfterLogo = $core->mobiexec('presmobicDisplayAfterLogo', array());
            $presmobicDisplayBeforeMiniCart = $core->mobiexec('presmobicDisplayBeforeMiniCart', array());
            $presmobicDisplayAfterMiniCart = $core->mobiexec('presmobicDisplayAfterMiniCart', array());
            $presmobicDisplayAfterHeader =  $core->mobiexec('presmobicDisplayAfterHeader', array());
            $presmobicDisplayBeforeTextStatic = $core->mobiexec('presmobicDisplayBeforeTextStatic', array());
            $presmobicDisplayFooter = $core->mobiexec('presmobicDisplayFooter', array());
            $presmobicDisplayBeforeNewsletter = $core->mobiexec('presmobicDisplayBeforeNewsletter', array());
            $presmobicDisplayAfterNewsletter = $core->mobiexec('presmobicDisplayAfterNewsletter', array());
            $presmobicDisplayBeforeFooterText = $core->mobiexec('presmobicDisplayBeforeFooterText', array());
            $presmobicDisplayAfterFooterText = $core->mobiexec('presmobicDisplayAfterFooterText', array());
            $presmobicDisplayBeforeSocialFooter = $core->mobiexec('presmobicDisplayBeforeSocialFooter', array());
            $presmobicDisplayAfterSocialFooter = $core->mobiexec('presmobicDisplayAfterSocialFooter', array());
            $presmobicDisplayAfterFooter = $core->mobiexec('presmobicDisplayAfterFooter', array());

            $presmobic_afteraccountSetting = $core->mobiexec('presmobic_afteraccountSetting', array());
            $presmobic_beforeaccountSetting = $core->mobiexec('presmobic_beforeaccountSetting', array());
            $presmobic_beforeaccountInfomartion = $core->mobiexec('presmobic_beforeaccountInfomartion', array());
            $presmobic_afteraccountInfomartion = $core->mobiexec('presmobic_afteraccountInfomartion', array());
            $context->smarty->assign("presmobic_afteraccountSetting", $presmobic_afteraccountSetting);
            $context->smarty->assign("presmobic_beforeaccountSetting", $presmobic_beforeaccountSetting);
            $context->smarty->assign("presmobic_beforeaccountInfomartion", $presmobic_beforeaccountInfomartion);
            $context->smarty->assign("presmobic_afteraccountInfomartion", $presmobic_afteraccountInfomartion);
            $context->smarty->assign("install_stripe_official", $install_stripe_official);
            $context->smarty->assign("presmobicDisplayBeforeFooterText", $presmobicDisplayBeforeFooterText);
            $context->smarty->assign("presmobicDisplayAfterFooterText", $presmobicDisplayAfterFooterText);
            $context->smarty->assign("presmobicDisplayBeforeSocialFooter", $presmobicDisplayBeforeSocialFooter);
            $context->smarty->assign("presmobicDisplayAfterSocialFooter", $presmobicDisplayAfterSocialFooter);
            $context->smarty->assign("presmobicDisplayAfterFooter", $presmobicDisplayAfterFooter);
            $context->smarty->assign("presmobicDisplayBeforeNewsletter", $presmobicDisplayBeforeNewsletter);
            $context->smarty->assign("presmobicDisplayAfterNewsletter", $presmobicDisplayAfterNewsletter);
            $context->smarty->assign("presmobicDisplayFooter", $presmobicDisplayFooter);
            $context->smarty->assign("presmobicDisplayBeforeHeader", $presmobicDisplayBeforeHeader);
            $context->smarty->assign("presmobicDisplayBeforeTextStatic", $presmobicDisplayBeforeTextStatic);
            $context->smarty->assign("presmobicDisplayBeforeLogo", $presmobicDisplayBeforeLogo);
            $context->smarty->assign("presmobicDisplayAfterLogo", $presmobicDisplayAfterLogo);
            $context->smarty->assign("presmobicDisplayBeforeMiniCart", $presmobicDisplayBeforeMiniCart);
            $context->smarty->assign("presmobicDisplayAfterMiniCart", $presmobicDisplayAfterMiniCart);
            $context->smarty->assign("presmobicDisplayAfterHeader", $presmobicDisplayAfterHeader);
            $context->smarty->assign("version_mobi", _PS_VERSION_);
            $context->smarty->assign("check_ssl", Configuration::get('PS_REWRITING_SETTINGS'));
            $context->smarty->assign("checkbox", $checkbox);
            $context->smarty->assign("token_pres", $this->presscookiekeymodule());
            $context->smarty->assign("js_def", $display_jsdef);
            $context->smarty->assign("display_js", $display_js);
            $context->smarty->assign("display_css", $display_css);
            $context->smarty->assign("hook_displayFooter", $hook_displayFooter);
            $context->smarty->assign("hook_displayHome", $hook_displayHome);
            $context->smarty->assign("hook_displayHomeTabContent", $hook_displayHomeTabContent);
            $context->smarty->assign("hook_displayHomeTab", $hook_displayHomeTab);
            $context->smarty->assign("hook_header_av", $hook_header_av);
            $context->smarty->assign("hook_header", $hook_header);
            $context->smarty->assign("ssl_check", Configuration::get('PS_SSL_ENABLED'));
            $context->smarty->assign("ssl_onpage", Configuration::get('PS_SSL_ENABLED_EVERYWHERE'));
            $context->smarty->assign("hook_displayNav", $hook_displayNav);
            $context->smarty->assign("hook_top", $hook_top);
            $context->smarty->assign("cart", $cart);
            $context->smarty->assign("description", $description);
            $context->smarty->assign("shop_name", $shop_name);
            $context->smarty->assign("comment_time", $comment_time);
            $context->smarty->assign("language", $preslanguage);
            $context->smarty->assign("languagedefault", $id_lang_default);
            $context->smarty->assign("currency", $lists_currency);
            $context->smarty->assign("currencydefault", $id_currency_default);
            $context->smarty->assign("code_currencydefault", $code_currency_default);
            $context->smarty->assign("name_language_default", $name_language_default);
            $context->smarty->assign("lang_iso", $iso_language_default);
            $this->context->smarty->assign('header', $header_block);
            $this->context->smarty->assign('content', $content_block);
            $this->context->smarty->assign('footer', $footer_block);
            $this->context->smarty->assign('PresMobisearchProduct', $PresMobisearchProduct_block);
            $this->context->smarty->assign('baseDir', $url);
            $this->context->smarty->assign('token', $token);
            $context->smarty->assign("category", $data);
            $facebook =  Configuration::get('facebook');
            $twitter =  Configuration::get('twitter');
            $google =  Configuration::get('google');
            $this->context->smarty->assign('facebook', $facebook);
            $this->context->smarty->assign('twitter', $twitter);
            $this->context->smarty->assign('google', $google);
            $html .= $this->display(__FILE__, 'views/templates/hook/front/home.tpl');
            die($html);
        } else {
            $this->context->controller->addJS($this->_path.'views/js/redirectpage.js');
        }
        $demomodepremobic = Configuration::get('demoModepremobic', null, '', $is_shop);
        if ($demomodepremobic == 1) {
            $this->context->controller->addJS($this->_path.'views/js/demomode.js');
        }
    }
    public function cookiekeymodule()
    {
        $keygooglecookie = sha1(_COOKIE_KEY_ . 'presmobileapp');
        $md5file = md5($keygooglecookie);
        return $md5file;
    }
    public function getContent()
    {
        $buttonDemoArr = array(
            'submitcache',
            'submitfooter',
            'submitdebug'
        );
        if ($this->demoMode == true) {
            Configuration::updateValue('demoModepremobic', '1', false, '', null);
            $bamodule = AdminController::$currentIndex;
            $token = Tools::getAdminTokenLite('AdminModules');
            foreach ($buttonDemoArr as $buttonDemo) {
                if (Tools::isSubmit($buttonDemo)) {
                    Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&demoMode=1');
                }
            }
        } else {
            Configuration::updateValue('demoModepremobic', '0', false, '', null);
        }
        $demoMode = 0;
        if (Tools::getValue('demoMode') == "1") {
            $demoMode = (int)Tools::getValue('demoMode');
        }
        $this->smarty->assign('demoMode', $demoMode);
        $id_shop = $this->context->shop->id;
        $id_shop_group = $this->context->shop->id_shop_group;
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $type_img = ImageType::getFormattedName('presmobic');
        } else {
            $type_img = ImageType::getFormatedName('presmobic');
        }
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $sql_thumbai = "SELECT *FROM " . _DB_PREFIX_ . "image_type WHERE name='".pSQL($type_img)."'";
        $check_thumbai = $db->Executes($sql_thumbai);
        if (empty($check_thumbai)) {
            $sql = "INSERT INTO " . _DB_PREFIX_ . "image_type";
            if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
                $sql .= " VALUES ('','".$type_img."','480','480','1','0','0','0','0')";
            } else {
                $sql .= " VALUES ('','".$type_img."','480','480','1','0','0','0','0','0')";
            }
            $db->query($sql);
            Configuration::updateValue('start_bamobicgenimg', '0', false, '', $id_shop_group, $id_shop);
        }
        $html = '';
        $url_fodel = _PS_MODULE_DIR_;
        $url = Tools::getShopProtocol() . Tools::getServerName() . __PS_BASE_URI__;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $dir = _PS_MODULE_DIR_ . '/presmobileapp/blocks/';
        $scanned_directory = array_diff(scandir($dir), array('..', '.'));
        $data = array();
        $core = new BaCore();
        if (Tools::getValue('bainstall')=='1') {
            $install_block = (string)Tools::getValue('key');
            include_once($url_fodel.'presmobileapp/blocks/block-'.$install_block.'.php');
            $block_file = new $install_block();
            $sql = "SELECT *FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE hook='".json_encode($block_file->hook)."'";
            $param = $db->Executes($sql);
            $position = count($param)+1;
            $aa = $block_file->displayName;
            $ab = $block_file->hook;
            $core->presMobiinstall($aa, 'block-'.$install_block.'.php', $position, $ab, null);
        }
        if (Tools::getValue('baunstall')=='1') {
            $install_block = (string)Tools::getValue('key');
            $core->presMobiuninstall('block-'.$install_block.'.php');
        }
        if (Tools::getValue('badisablel')=='1') {
            $install_block = (string)Tools::getValue('key');
            $core->presMobidisnable('block-'.$install_block.'.php');
            $adminControllers = AdminController::$currentIndex;
            $token='&token='.Tools::getAdminTokenLite('AdminModules');
            $configAndTask='&configure='.$this->name;
            $task = '&task=plugins&disablel=1';
            Tools::redirectAdmin($adminControllers.$token.$configAndTask.$task);
        }
        if (Tools::getValue('baenable')=='1') {
            $install_block = (string)Tools::getValue('key');
            $core->presMobienable('block-'.$install_block.'.php');
            $adminControllers = AdminController::$currentIndex;
            $token='&token='.Tools::getAdminTokenLite('AdminModules');
            $configAndTask='&configure='.$this->name;
            $task = '&task=plugins&enablemopic=1';
            Tools::redirectAdmin($adminControllers.$token.$configAndTask.$task);
        }
        unset($scanned_directory[10]);
        foreach ($scanned_directory as $key => $value) {
            $key;
            include_once($url_fodel.'presmobileapp/blocks/'.$value);
            $file_trim = str_replace(array('block-', '.php'), '', $value);
            $file = new $file_trim();
            $data[$file_trim]['name'] = $file->name;
            $data[$file_trim]['version'] = $file->version;
            $data[$file_trim]['displayName'] = $file->displayName;
            $data[$file_trim]['description'] = $file->description;
            $sql = "SELECT * FROM " . _DB_PREFIX_ . "ba_mobileapp_block WHERE file='".pSQL($value)."'";
            $param = $db->Executes($sql);
            $data[$file_trim]['active'] = '';
            if (empty($param)) {
                $data[$file_trim]['install'] = 0;
            } else {
                $data[$file_trim]['active'] = $param[0]['active'];
                $data[$file_trim]['install'] = 1;
            }
        }
        $this->caseImgSlider();
        $link = new Link();
        $url1 = $_SERVER['PHP_SELF'];
        $url1 = rtrim($url1, 'index.php');
        $url2 = $url1.$link->getAdminLink('AdminModules', true)
        ."&configure=presmobileapp&task=slider&addimg=1";
        $url3 = $url1.$link->getAdminLink('AdminModules', true)
        ."&configure=presmobileapp&task=slider&editslider=1";
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $url2 = $link->getAdminLink('AdminModules', true)
            ."&configure=presmobileapp&task=slider&addimg=1";
        }
        $this->context->smarty->assign('url2', $url2);
        $this->context->smarty->assign('url3', $url3);
        if (Tools::isSubmit('submitdebug')) {
            $secure_mobi = $core->secureToken();
            $debug_add = (int)Tools::getValue('debug_add');
            Configuration::updateValue('mobi_secure', $secure_mobi, false, '', $id_shop_group, $id_shop);
            Configuration::updateValue('debug_add', $debug_add, false, '', $id_shop_group, $id_shop);
            $html .= $this->displayConfirmation($this->l('Update successful.'));
        }
        if (Tools::isSubmit('submitcache')) {
            $timecache = (int)Tools::getValue('timecache');
            if ($timecache == 0 || empty($timecache)) {
                $html .= $this->displayError(" Cache time is invalid");
            } else {
                $cache_add = (int)Tools::getValue('cache_add');
                Configuration::updateValue('cacheapp', ''.$timecache.'', false, '', null);
                Configuration::updateValue('cache_add', ''.$cache_add.'', false, '', null);
                $html .= $this->displayConfirmation($this->l('Update successful.'));
            }
        }
        if (Tools::isSubmit('statuspresmobileappba_premobic_slider')) {
            $adminControllers = AdminController::$currentIndex;
            $token='&token='.Tools::getAdminTokenLite('AdminModules');
            $configAndTask='&configure='.$this->name;
            $task = '&task=slider&status=1';
            $id = (int)Tools::getValue('id');
            $sql = "SELECT * FROM  " . _DB_PREFIX_ . "ba_premobic_slider";
            $sql .= " WHERE id =".(int)$id."";
            $data = $db->Executes($sql);
            $active = $data[0]['active'];
            if ($active == 1) {
                $active = 0;
            } else {
                $active = 1;
            }
            $sql1 = " UPDATE " . _DB_PREFIX_ . "ba_premobic_slider SET active='" .(int)$active. "'";
            $sql1 .= " WHERE id = '".(int)$id."'";
            $db->query($sql1);
            Tools::redirectAdmin($adminControllers.$token.$configAndTask.$task);
        }
        if (Tools::isSubmit('clearcacheapp')) {
            $sql = "DELETE FROM " . _DB_PREFIX_ . "ba_mobic_cache";
            $db->query($sql);
            $html .= $this->displayConfirmation($this->l('Update successful.'));
        }
        if (Tools::isSubmit('submitfooter')) {
            $facebook = (string)Tools::getValue('facebook');
            $twitter = (string)Tools::getValue('twitter');
            $google = (string)Tools::getValue('google');
            Configuration::updateValue('facebook', ''.$facebook.'', false, '', null);
            Configuration::updateValue('twitter', ''.$twitter.'', false, '', null);
            Configuration::updateValue('google', ''.$google.'', false, '', null);
            $html .= $this->displayConfirmation($this->l('Update successful.'));
        }
        $disablel = (int)Tools::getValue('disablel');
        if ($disablel == 1) {
            $html .= $this->displayConfirmation($this->l('Successful disabled.'));
        }
        $enable = (int)Tools::getValue('enablemopic');
        if ($enable == 1) {
            $html .= $this->displayConfirmation($this->l('Successful enabled.'));
        }
        $status = (int)Tools::getValue('status');
        if ($status == 1) {
            $html .= $this->displayConfirmation($this->l('The status has been successfully updated.'));
        }
        $editslider = (int)Tools::getValue('editslider');
        if ($editslider == 1) {
            $html .= $this->displayConfirmation($this->l('Update successful.'));
        }
        $deleteslider = (int)Tools::getValue('delete_slider');
        if ($deleteslider == 1) {
            $html .= $this->displayConfirmation($this->l('Deletion successful.'));
        }
        $taskbar = (string)Tools::getValue('task');
        if (empty($taskbar)) {
            $this->context->smarty->assign('html_setting', $this->cacheApp());
        }
        $addimg = (int)Tools::getValue('addimg');
        if ($addimg == '1') {
            $html .= $this->displayConfirmation($this->l('Add successful.'));
        }
        switch ($taskbar) {
            case 'Settings':
                $this->context->smarty->assign('html_setting', $this->cacheApp());
                break;
            case 'slider':
                include_once($url_fodel.'presmobileapp/includes/Presmobic-baslider.php');
                $slider = new BAmobiSlider();
                $this->resetImg();
                $html_slider = $slider->createSliderList();
                $this->context->smarty->assign('html_slider', $html_slider);
                $add_new = (int)Tools::getValue('add');
                $this->context->smarty->assign('add_new', $add_new);
                if ($add_new == 1) {
                    $this->context->smarty->assign('html_add', $this->addSlider());
                }
                $updateslider = (int)Tools::getValue('updateslider');
                $this->context->smarty->assign('updateslider', $updateslider);
                if ($updateslider == 1) {
                    $this->context->smarty->assign('html_add', $this->editSlider());
                }
                break;
            case 'footeradmin':
                $this->context->smarty->assign('footeradmin', $this->footerAdmin());
                break;
        }
        $sql_product = "SELECT *FROM " . _DB_PREFIX_ . "product";
        $product_gen = $db->Executes($sql_product);
        $start_bamobicgenimg =  (int)Configuration::get('start_bamobicgenimg');
        $mobic_genimg =  (int)Configuration::get('PS_PRICE_ROUND_MODE');
        $bamodule = AdminController::$currentIndex;
        $token = Tools::getAdminTokenLite('AdminModules');
        $debug_add = Configuration::get('debug_add', null, '', $id_shop);
        if ($debug_add == 1) {
            $ac = _PS_THEME_DIR_;
            if (Tools::version_compare(_PS_VERSION_, '1.7', '<')) {
                // rmdir(''.$ac.'mobile');
                $dir = _PS_THEME_DIR_.'mobile';
                if (file_exists($dir)) {
                    $this->deleteDir(''.$ac.'mobile');
                }
            }
        } else {
            if (Tools::version_compare(_PS_VERSION_, '1.7', '<')) {
                $dir = _PS_THEME_DIR_.'mobile';
                if (!file_exists($dir)) {
                    @mkdir($dir);
                }
                $ab = _PS_MODULE_DIR_;
                $ac = _PS_THEME_DIR_;
                @copy(''.$ab.'presmobileapp\views\templates\admin\layout.tpl', ''.$ac.'mobile\layout.tpl');
                @copy(''.$ab.'presmobileapp\views\templates\admin\layout_total.tpl', ''.$ac.'layout.tpl');
            }
        }
        $this->smarty->assign('configure', $this->name);
        $this->context->smarty->assign('mobic_token', Tools::getAdminTokenLite('AdminModules'));
        $this->context->smarty->assign('start_bamobicgenimg', $start_bamobicgenimg);
        $this->context->smarty->assign('product_gen', count($product_gen));
        $this->context->smarty->assign('bamodule', $bamodule);
        $this->context->smarty->assign('mobic_genimg', $mobic_genimg);
        $this->context->smarty->assign('taskbar', $taskbar);
        $this->context->smarty->assign('block', $data);
        $this->context->smarty->assign('baseDir', $url);
        $this->context->controller->addCSS($this->_path . 'views/css/styleaddmin.css');
        $this->context->controller->addJS($this->_path . 'views/js/jquery-ui.js');
        $html .= $this->display(__FILE__, 'views/templates/admin/setting.tpl');
        return $html;
    }
    public function footerAdmin()
    {
        $facebook =  Configuration::get('facebook');
        $twitter =  Configuration::get('twitter');
        $google =  Configuration::get('google');
        $this->context->smarty->assign('facebook', $facebook);
        $this->context->smarty->assign('twitter', $twitter);
        $this->context->smarty->assign('google', $google);
        return $this->display(__FILE__, 'views/templates/admin/footeradmin.tpl');
    }
    public function cacheApp()
    {
        $token = Tools::getAdminTokenLite('AdminModules');
        $bacontroller = 'index.php?controller=AdminModules';
        $cf = 'configure=presmobileapp&task=Settings';
        $redirect = '' . $bacontroller . '&token=' . $token . '&' . $cf . '';
        $languages = Language::getLanguages();
        $id_shop = Context::getContext()->shop->id;
        $id_language = Context::getContext()->language->id;
        $id_language;
        $id_lang_default = Configuration::get('PS_LANG_DEFAULT');
        $cacheapp = Configuration::get('cacheapp');
        $cache_add = Configuration::get('cache_add');
        $mobi_secure = Configuration::get('mobi_secure', null, '', $id_shop);
        $debug_add = Configuration::get('debug_add', null, '', $id_shop);
        $seourl = Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL', null, '', $id_shop);
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $this->smarty->assign('redirect', $redirect);
        $this->smarty->assign('debug_add', $debug_add);
        $this->smarty->assign('mobi_secure', $mobi_secure);
        $this->smarty->assign('cacheapp', $cacheapp);
        $this->smarty->assign('url', $url);
        $this->smarty->assign('seourl', $seourl);
        $this->smarty->assign('cache_add', $cache_add);
        $this->smarty->assign('languages', $languages);
        $this->smarty->assign('id_lang_default', $id_lang_default);
        return $this->display(__FILE__, 'views/templates/admin/cacheapp.tpl');
    }
    public function getImageToHelpperList($imageTags)
    {
        if (!empty($imageTags)) {
            return '<a class="riverroad" href="#" title="" img="' . Tools::htmlentitiesDecodeUTF8($imageTags) . '">'
            . "<img style='width: 60px;
            /* border: 1px black solid; */
            background-color: white;
            border-color: #cccccc !important;
            padding: 4px;
            line-height: 1.42857;
            background-color: white;
            border: 1px solid #dddddd;
            border-radius: 3px;
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
            display: inline-block;
            max-width: 100%;
            height: 34px;' src='" . __PS_BASE_URI__ . "modules/presmobileapp/"
            . Tools::htmlentitiesDecodeUTF8($imageTags) . "'></a>";
        }
        return '<p style="text-align:center;">--</p>';
    }
    public function printstatus($imageTags)
    {
        return ($imageTags == 1 ? $this->l('Yes') : $this->l('No'));
    }
    public function addSlider()
    {
        $token = Tools::getAdminTokenLite('AdminModules');
        $bacontroller = 'index.php?controller=AdminModules';
        $cf = 'configure=presmobileapp&task=slider';
        $redirect = '' . $bacontroller . '&token=' . $token . '&' . $cf . '';
        $languages = Language::getLanguages();
        $id_language = Context::getContext()->language->id;
        $id_lang_default = Configuration::get('PS_LANG_DEFAULT');
        foreach ($languages as $key => $value) {
            $languages[$key]['checked'] = 0;
            if ($id_language == $value['id_lang']) {
                $languages[$key]['checked'] = 1;
            }
        }
        $this->smarty->assign('redirect', $redirect);
        $this->smarty->assign('languages', $languages);
        $this->smarty->assign('id_lang_default', $id_lang_default);
        return $this->display(__FILE__, 'views/templates/admin/addslider.tpl');
    }
    public function editSlider()
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $token = Tools::getAdminTokenLite('AdminModules');
        $bacontroller = 'index.php?controller=AdminModules';
        $cf = 'configure=presmobileapp&task=slider';
        $redirect = '' . $bacontroller . '&token=' . $token . '&' . $cf . '';
        $id_img = (int)Tools::getValue('id_img');
        $sql ="SELECT * FROM "._DB_PREFIX_."ba_premobic_slider WHERE id='".$id_img."'";
        $old_params = $db->ExecuteS($sql, true, false);
        $this->smarty->assign('list_img_edit', $old_params);
        $this->smarty->assign('redirect', $redirect);
        return $this->display(__FILE__, 'views/templates/admin/editslider.tpl');
    }
    //case imgslider
    public function caseImgSlider()
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $adminControllers = AdminController::$currentIndex;
        $token = '&token='.Tools::getAdminTokenLite('AdminModules');
        $configAndTask ='&configure='.$this->name;
        $dir_img = _PS_MODULE_DIR_ . "presmobileapp/";
        $dir_img;
        if (Tools::isSubmit('updatepresmobileappba_premobic_slider')) {
            $id_img = Tools::getValue('id');
            $sql = "SELECT * FROM "._DB_PREFIX_."ba_premobic_slider WHERE id='".$id_img."'";
            $data = $db->ExecuteS($sql);
            $task = '&task=slider&updateslider=1&id_lang_im='.$data[0]['id_lang'].'&id_img='.$id_img .'';
            Tools::redirectAdmin($adminControllers.$token.$configAndTask.$task);
        }
        if (Tools::isSubmit('deletepresmobileappba_premobic_slider')) {
            $id_img = Tools::getValue('id');
            $sql = 'SELECT images FROM ' . _DB_PREFIX_ . 'ba_premobic_slider WHERE id=' . (int) $id_img . '';
            $old_params = $db->ExecuteS($sql, true, false);
            $sql1 = 'DELETE  FROM ' . _DB_PREFIX_ . 'ba_premobic_slider WHERE id=' . (int) $id_img . '';
            $db->query($sql1);
            $task = '&task=slider&delete_slider=1';
            Tools::redirectAdmin($adminControllers.$token.$configAndTask.$task);
        }
        if (Tools::isSubmit('submitBulkdeletepresmobileappba_premobic_slider')) {
            $target_dir = __PS_BASE_URI__ . 'modules/presmobileapp/';
            $target_dir;
            $dir_img = _PS_MODULE_DIR_ . "presmobileapp/";
            $delete_box = Tools::getValue('presmobileappba_premobic_sliderBox');
            foreach ($delete_box as $key => $value) {
                $key;
                $sql = 'SELECT images FROM ' . _DB_PREFIX_ . 'ba_premobic_slider WHERE id=' . (int) $value . '';
                $old_params = $db->ExecuteS($sql, true, false);
                $list_img = $old_params[0]['images'];
                $list_img;
                $sql1 = 'DELETE  FROM ' . _DB_PREFIX_ . 'ba_premobic_slider WHERE id=' . (int) $value . '';
                $db->query($sql1);
            }
            $task = '&task=slider&delete_slider=1';
            Tools::redirectAdmin($adminControllers.$token.$configAndTask.$task);
        }
        if (Tools::isSubmit('submitResetpresmobileappba_premobic_slider')) {
            $this->resetImg();
            Tools::redirectAdmin($adminControllers.$token.$configAndTask.'&task=slider');
        }
    }
    public function resetImg()
    {
        $search_field = array(
            'id',
            'id_lang',
            'iamges',
            'name',
            'url_images',
            'position',
            'active',
            'language',
        );
        foreach ($search_field as $v) {
            $this->context->cookie->{'presmobileappba_premobic_sliderFilter_'.$v} = null;
        }
        return true;
    }
    public function currentUrl($server)
    {
        //Figure out whether we are using http or https.
        $http = 'http';
        //If HTTPS is present in our $_SERVER array, the URL should
        //start with https:// instead of http://
        if (isset($server['HTTPS'])) {
            $http = 'https';
        }
        //Get the HTTP_HOST.
        $host = $server['HTTP_HOST'];
        //Get the REQUEST_URI. i.e. The Uniform Resource Identifier.
        $requestUri = $server['REQUEST_URI'];
        //Finally, construct the full URL.
        //Use the function htmlentities to prevent XSS attacks.
        return $http . '://' . htmlentities($host) . '/' . htmlentities($requestUri);
    }
    public function resertController($controller)
    {
        $url_fodel = _PS_MODULE_DIR_;
        require_once($url_fodel.'presmobileapp/includes/Presmobic-badispatcher.php');
        $badispatcher = new BaDispatcher();
        $badispatcher->controller = $controller;
        DispatcherCore::$instance = $badispatcher;
    }
    public function presscookiekeymodule()
    {
        $keygooglecookie = sha1(_COOKIE_KEY_ . 'presmobileapp');
        $md5file = md5($keygooglecookie);
        return $md5file;
    }
    public function preInstallHook($name = '', $titel = '', $description = '', $position = 1, $live_edit = 1)
    {
        $hook = new Hook();
        $hook->name = $name;
        $hook->title = $titel;
        $hook->description = $description;
        $hook->position = $position;
        $hook->live_edit = $live_edit;
        $hook->add();
    }
    //cài đặt tab menu
    public function installTab($className, $tabName, $tabParentName = false)
    {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = $className;
        $tab->name = array();
        $tabParentName = 'SELL';
        $tab->position = 6;
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $tabName;
        }
        if ($tabParentName) {
            $tab->id_parent = (int) Tab::getIdFromClassName($tabParentName);
        } else {
            $tab->id_parent = 0;
        }
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $tab->icon = 'stay_current_portrait';
        }
        $tab->module = $this->name;
        $tab->add();
        return $tab->save();
    }
    public static function deleteDir($dirPath)
    {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (Tools::substr($dirPath, Tools::strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}
