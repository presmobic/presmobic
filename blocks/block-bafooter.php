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

class BaFooter extends PresMobileApp
{
    public function __construct()
    {
        $this->name = "Footer";
        $this->version = "1.0.0";
        $this->hook = array('footer');
        $this->displayName = $this->l('Footer Block');
        $this->description = $this->l('Footer block on Homepage');
    }
    public function render($arg = array())
    {
        $arg;
        $context = Context::getContext();
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        include_once($url_fodel.'presmobileapp/configs/defines.inc.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $hook_array = (array)Tools::jsonDecode(_PS_MOBIC_HOOK_);
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $displayFooter = $core->mobiexec172('displayFooter', array(), $hook_array['displayFooter']);
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $displayFooter = $core->mobiexec17('displayFooter', array(), $hook_array['displayFooter']);
        } else {
            $displayFooter = '';
        }
        $context->smarty->assign("displayFooter", $displayFooter);
        $context->smarty->assign("url", $url);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/block/footer.tpl';
        return $context->smarty->fetch($a);
    }
}
