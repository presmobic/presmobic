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

class PresMobileAppBaLoadPageModuleFrontController extends ModuleFrontController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function run()
    {
        parent::init();
        parent::initHeader();
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $mobi_token = Tools::getValue('token_pres');
        $checktoken = $core->cookiekeymodule();
        if ($mobi_token != $checktoken) {
            echo $core->transbv();
            die;
        }
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '<')) {
            $this->resertController('product');
        }
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '<')) {
            $_GET['controller'] = 'product';
            $_GET['id_product'] = Tools::getValue('argument');
            $d = Dispatcher::getInstance();
            $d->controller = 'product';
        }
        $value = Tools::getValue('value');
        $action = Tools::getValue('action');
        if (isset($value) && $action=='category') {
            $arg = array(0=>$value);
            $this->loadcontentlatest($arg);
            die;
        }
        if (isset($value) && $action=='searchProduct') {
            $arg = array(0=>$value);
            $this->loadcontentPresMobisearchProduct($arg);
            die;
        }
        $controller = Tools::getValue('controllers');
        $controllers = ltrim($controller, '#');
        $argument = Tools::getValue('argument');
        $argument = explode(':', $argument);
        $this->baStart($controllers, $argument);
    }
    public function baStart($controllers, $arg = array())
    {
        $url_fodel = _PS_MODULE_DIR_;
        require_once($url_fodel.'presmobileapp/endpoints/PresMobile-ba'.$controllers.'.php');
        $check_file = file_exists($url_fodel.'presmobileapp/endpoints/PresMobile-ba'.$controllers.'.php');
        if ($check_file == true) {
            $link_file = 'Ba'.$controllers;
            $endpoints = new $link_file();
            $html = $endpoints->start($arg);
            echo $html;
            die;
        }
    }
    public function loadcontentlatest($arg)
    {
        $url_fodel = _PS_MODULE_DIR_;
        require_once($url_fodel.'presmobileapp/blocks/block-balatest.php');
        $block = new Balatest();
        $html = $block->render($arg);
        echo $html;
    }
    public function loadcontentPresMobisearchProduct($arg)
    {
        $url_fodel = _PS_MODULE_DIR_;
        require_once($url_fodel.'presmobileapp/blocks/block-basearchproduct.php');
        $block = new BasearchProduct();
        $html = $block->render($arg);
        echo $html;
    }
    public function resertController($controller)
    {
        $url_fodel = _PS_MODULE_DIR_;
        require_once($url_fodel.'presmobileapp/includes/Presmobic-badispatcher.php');
        $badispatcher = new BaDispatcher();
        $badispatcher->controller = $controller;
        DispatcherCore::$instance = $badispatcher;
    }
}
