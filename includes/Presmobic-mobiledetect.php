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

class BaMobileDetect
{
    public function isMobile()
    {
        $isMobileUA = array(
            '/iphone/i' => 'iPhone',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
        );
        $is_mobile = 0;
        foreach ($isMobileUA as $sMobileKey => $sMobileOS) {
            $sMobileOS;
            if (preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])) {
                $is_mobile = 1;
            }
        }
        return $is_mobile;
    }
}
