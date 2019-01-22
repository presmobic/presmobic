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

include_once('../../../config/config.inc.php');
include_once('../../../init.php');
include_once('./../presmobileapp.php');
$url_fodel = _PS_MODULE_DIR_;
include_once($url_fodel.'presmobileapp/configs/defines.inc.php');
$mobic_link = Tools::jsonDecode(_PS_MOBIC_REDRIEC_, true);
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context = Context::getContext();
$controller = Tools::getValue('controllers');
$argument = Tools::getValue('argument');
$argument = explode(':', $argument);
$link = new Link();
$request = array();
$abc = array();
foreach ($mobic_link as $key => $value) {
    if ($controller == $key) {
        $request = array();
        $controller_page = $value['controller'];
        if (!empty($value['args'])) {
            $abc = $value['args'];
        }
    }
}
$request = array();
foreach ($argument as $key => $value) {
    $request[$abc[$key]] = $value;
}
$linkpage =$link->getPageLink($controller_page, null, null, $request);
echo $linkpage;
die;
