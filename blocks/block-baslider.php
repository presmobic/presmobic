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

class BaSlider extends PresMobileApp
{
    public function __construct()
    {
        $this->name = "slider";
        $this->version = "1.0.0";
        $this->hook = array('content');
        $this->displayName = $this->l('SlideshowSlideshow');
        $this->description = $this->l('display slideshow in Homepage, you can change images in Slider tab');
    }
    public function render($arg = array())
    {
        $arg;
        $context = Context::getContext();
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        include_once($url_fodel.'presmobileapp/includes/Presmobic-bahook.php');
        $core = new BaCore();
        $pres_hook = new Bahook();
        $url = $core->getMobiBaseLink();
        $presmobicGetSlideData = $pres_hook->presmobicGetSlideData();
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobicDisplayBeforeSlider = $core->mobiexec172('presmobicDisplayBeforeSlider', array());
            $presmobicDisplayAfterSlider = $core->mobiexec172('presmobicDisplayAfterSlider', array());
            $presmobicDisplayBeforeLatestContent = $core->mobiexec172('presmobicDisplayBeforeLatestContent', array());
            $presmobicDisplayAfterLatestContent = $core->mobiexec172('presmobicDisplayAfterLatestContent', array());
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobicDisplayBeforeSlider = $core->mobiexec17('presmobicDisplayBeforeSlider', array());
            $presmobicDisplayAfterSlider = $core->mobiexec17('presmobicDisplayAfterSlider', array());
            $presmobicDisplayBeforeLatestContent = $core->mobiexec17('presmobicDisplayBeforeLatestContent', array());
            $presmobicDisplayAfterLatestContent = $core->mobiexec17('presmobicDisplayAfterLatestContent', array());
        } else {
            $presmobicDisplayBeforeSlider = $core->mobiexec('presmobicDisplayBeforeSlider', array());
            $presmobicDisplayAfterSlider = $core->mobiexec('presmobicDisplayAfterSlider', array());
            $presmobicDisplayBeforeLatestContent = $core->mobiexec('presmobicDisplayBeforeLatestContent', array());
            $presmobicDisplayAfterLatestContent = $core->mobiexec('presmobicDisplayAfterLatestContent', array());
        }
        // var_dump($presmobicGetSlideData);die;
        $context->smarty->assign('presmobicDisplayBeforeLatestContent', $presmobicDisplayBeforeLatestContent);
        $context->smarty->assign('presmobicDisplayAfterLatestContent', $presmobicDisplayAfterLatestContent);
        $context->smarty->assign('presmobicDisplayBeforeSlider', $presmobicDisplayBeforeSlider);
        $context->smarty->assign('presmobicDisplayAfterSlider', $presmobicDisplayAfterSlider);
        $context->smarty->assign('presmobicGetSlideData', $presmobicGetSlideData);
        $context->smarty->assign('baseDir', $url);
        $context->smarty->assign('infor', $presmobicGetSlideData);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/block/slider.tpl';
        return $context->smarty->fetch($a);
    }
}
