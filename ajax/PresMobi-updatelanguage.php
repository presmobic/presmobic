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
include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
$core = new BaCore();
$mobi_token = (string)Tools::getValue('token_pres');
$checktoken = $core->cookiekeymodule();
if ($mobi_token != $checktoken) {
    echo $core->transbv();
    die;
}
$context = Context::getContext();
$id_language = (int)Tools::getValue('id_language');
$context->cookie->id_lang = $id_language;
$presmobileapp = new PresMobileApp();
$language = Language::getLanguages();
$iso_code = '';
if (count($language) > 1) {
    foreach ($language as $key => $value) {
        if ($value['id_lang'] == $id_language) {
            $iso_code = $value['iso_code'].'/';
        }
    }
}
$result = array(
    'messenger' => $presmobileapp->l('Update to language success.'),
    'iso_code' => $iso_code
);
echo json_encode($result);
die;
