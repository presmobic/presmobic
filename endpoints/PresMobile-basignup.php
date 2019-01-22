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

class BaSignUp extends PresMobileApp
{
    public function __construct()
    {
    }
    public function start($arg)
    {
        $arg;
        $url_fodel = _PS_MODULE_DIR_;
        $presmobileapp = new PresMobileApp();
        $controller = 'signup';
        $context = Context::getContext();
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobicBeforeSignUp = $core->mobiexec172('presmobicBeforeSignUp', array());
            $presmobicAfterSignUp = $core->mobiexec172('presmobicAfterSignUp');
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobicBeforeSignUp = $core->mobiexec17('presmobicBeforeSignUp', array());
            $presmobicAfterSignUp = $core->mobiexec17('presmobicAfterSignUp');
        } else {
            $presmobicBeforeSignUp = $core->mobiexec('presmobicBeforeSignUp', array());
            $presmobicAfterSignUp = $core->mobiexec('presmobicAfterSignUp');
        }
        $year = date('Y');
        $context->smarty->assign("presmobicBeforeSignUp", $presmobicBeforeSignUp);
        $context->smarty->assign("presmobicAfterSignUp", $presmobicAfterSignUp);
        $b2b_enable = Configuration::get('PS_B2B_ENABLE');
        $context->smarty->assign("url", $url);
        $context->smarty->assign("b2b_enable", $b2b_enable);
        $context->smarty->assign("year", $year);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/signup/signup.tpl';
        $content =  $context->smarty->fetch($a);
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'chir' => $presmobileapp->l('Sign Up')
        );
        echo json_encode($result);
        die;
    }
}
