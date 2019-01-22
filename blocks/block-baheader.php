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

class BaHeader extends PresMobileApp
{
    public function __construct()
    {
        $this->name = "Header";
        $this->version = "1.0.0";
        $this->hook = array('header');
        $this->displayName = $this->l('Header Bar');
        $this->description = $this->l('display a logo, minicart on top header of mobile website application');
    }
    public function render($arg = array())
    {
        $arg;
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        include_once($url_fodel.'presmobileapp/includes/Presmobic-bahook.php');
        $core = new BaCore();
        $bacart = $core->presMobicartresult();
        $context = Context::getContext();
        $url = $core->getMobiBaseLink();
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobicDisplayBeforeHeader = $core->mobiexec172('presmobicDisplayBeforeHeader', array());
            $presmobicDisplayBeforeLogo = $core->mobiexec172('presmobicDisplayBeforeLogo', array());
            $presmobicDisplayAfterLogo = $core->mobiexec172('presmobicDisplayAfterLogo', array());
            $presmobicDisplayBeforeMiniCart = $core->mobiexec172('presmobicDisplayBeforeMiniCart', array());
            $presmobicDisplayAfterMiniCart = $core->mobiexec172('presmobicDisplayAfterMiniCart', array());
            $presmobicDisplayAfterHeader = $core->mobiexec172('presmobicDisplayAfterHeader', array());
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobicDisplayBeforeHeader = $core->mobiexec17('presmobicDisplayBeforeHeader', array());
            $presmobicDisplayBeforeLogo = $core->mobiexec17('presmobicDisplayBeforeLogo', array());
            $presmobicDisplayAfterLogo = $core->mobiexec17('presmobicDisplayAfterLogo', array());
            $presmobicDisplayBeforeMiniCart = $core->mobiexec17('presmobicDisplayBeforeMiniCart', array());
            $presmobicDisplayAfterMiniCart = $core->mobiexec17('presmobicDisplayAfterMiniCart', array());
            $presmobicDisplayAfterMiniCart = $core->mobiexec17('presmobicDisplayAfterHeader', array());
            $presmobicDisplayAfterHeader = $core->mobiexec17('presmobicDisplayAfterHeader', array());
        } else {
            $presmobicDisplayBeforeHeader = $core->mobiexec('presmobicDisplayBeforeHeader', array());
            $presmobicDisplayBeforeLogo = $core->mobiexec('presmobicDisplayBeforeLogo', array());
            $presmobicDisplayAfterLogo = $core->mobiexec('presmobicDisplayAfterLogo', array());
            $presmobicDisplayBeforeMiniCart = $core->mobiexec('presmobicDisplayBeforeMiniCart', array());
            $presmobicDisplayAfterMiniCart = $core->mobiexec('presmobicDisplayAfterMiniCart', array());
            $presmobicDisplayAfterHeader = $core->mobiexec('presmobicDisplayAfterHeader', array());
        }
        // var_dump($presmobicDisplayBeforeLogo);die;
        $context->smarty->assign("url", $url);
        $context->smarty->assign("bacart", $bacart);

        $context->smarty->assign("presmobicDisplayBeforeHeader", $presmobicDisplayBeforeHeader);
        $context->smarty->assign("presmobicDisplayBeforeLogo", $presmobicDisplayBeforeLogo);
        $context->smarty->assign("presmobicDisplayAfterLogo", $presmobicDisplayAfterLogo);
        $context->smarty->assign("presmobicDisplayBeforeMiniCart", $presmobicDisplayBeforeMiniCart);
        $context->smarty->assign("presmobicDisplayAfterMiniCart", $presmobicDisplayAfterMiniCart);
        $context->smarty->assign("presmobicDisplayAfterHeader", $presmobicDisplayAfterHeader);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/block/header.tpl';
        return $context->smarty->fetch($a);
    }
}
