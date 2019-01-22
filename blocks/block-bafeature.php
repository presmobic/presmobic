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

class BaFeature extends PresMobileApp
{
    public function __construct()
    {
        $this->name = "feature";
        $this->version = "1.0.0";
        $this->hook = array('content');
        $this->displayName = $this->l('Featured Brands');
        $this->description = $this->l('display manufacturers in "Featured Brands" block on Home page');
    }
    public function render($arg = array())
    {
        $arg;
        $context = Context::getContext();
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        include_once($url_fodel.'presmobileapp/includes/Presmobic-bahook.php');
        $pres_hook = new Bahook();
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobicDisplayBeforeFeaturedBrands = $core->mobiexec172('presmobicDisplayBeforeFeaturedBrands', array());
            $presmobicDisplayAfterFeaturedBrands = $core->mobiexec172('presmobicDisplayAfterFeaturedBrands', array());
            $presmobicGetBrandsData = $core->mobiexec172('presmobicGetBrandsData', array());
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobicDisplayBeforeFeaturedBrands = $core->mobiexec17('presmobicDisplayBeforeFeaturedBrands', array());
            $presmobicDisplayAfterFeaturedBrands = $core->mobiexec17('presmobicDisplayAfterFeaturedBrands', array());
            $presmobicGetBrandsData = $core->mobiexec172('presmobicGetBrandsData', array());
        } else {
            $presmobicDisplayBeforeFeaturedBrands = $core->mobiexec('presmobicDisplayBeforeFeaturedBrands', array());
            $presmobicDisplayAfterFeaturedBrands = $core->mobiexec('presmobicDisplayAfterFeaturedBrands', array());
            $presmobicGetBrandsData = $core->mobiexec172('presmobicGetBrandsData', array());
        }
        $presmobicGetBrandsData = $pres_hook->presmobicGetBrandsData();
        $context->smarty->assign("presmobicDisplayBeforeFeaturedBrands", $presmobicDisplayBeforeFeaturedBrands);
        $context->smarty->assign("presmobicDisplayAfterFeaturedBrands", $presmobicDisplayAfterFeaturedBrands);
        $context->smarty->assign("url", $url);
        $context->smarty->assign("feature", $presmobicGetBrandsData);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/block/featurebrand.tpl';
        return $context->smarty->fetch($a);
    }
}
