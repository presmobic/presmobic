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

include_once('../../config/config.inc.php');
include_once('../../init.php');
include_once('presmobileapp.php');

$context = Context::getContext();
$positions = array();
if (Tools::getValue('action') == 'updatePosition' && Tools::getValue('position')) {
    $positions = explode(',', Tools::getValue('position'));
    foreach ($positions as $position => $id_megamenu) {
        $position = $position + 1;
        $sql = 'UPDATE `' . _DB_PREFIX_ . 'ba_premobic_slider` SET `position` = ' . (int) $position . '
        WHERE `id` = ' . (int) $id_megamenu;
        $res = Db::getInstance()->execute($sql);
    }
}
return true;
