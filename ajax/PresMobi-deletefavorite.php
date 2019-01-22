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
$cart = $core->presMobicartresult();
$id = (int)Tools::getValue('id');
$type = (int)Tools::getValue('type');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context = Context::getContext();
$id_shop = $context->shop->id;
$id_lang = $context->language->id;
$deletefavorite = array(
    'deletefavorite' => array(
        'id' => $id,
        'type' =>$type
    )
);
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
    $presmobicBeforeDeleteFavorite = $core->mobiexec172('presmobicBeforeDeleteFavorite', array(), $deletefavorite);
} elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
    $presmobicBeforeDeleteFavorite = $core->mobiexec172('presmobicBeforeDeleteFavorite', array(), $deletefavorite);
} else {
    $presmobicBeforeDeleteFavorite = $core->mobiexec172('presmobicBeforeDeleteFavorite', array(), $deletefavorite);
}
if (is_array($presmobicBeforeDeleteFavorite)) {
    $id = $presmobicBeforeDeleteFavorite['deletefavorite']['id'];
    $type = $presmobicBeforeDeleteFavorite['deletefavorite']['type'];
}
if ($id != '0' && $type != '1') {
    $sql = "DELETE FROM " . _DB_PREFIX_ . "favorite_product";
    $sql .= " WHERE id_product=".(int)$id."";
    $sql .= " AND id_customer=".(int)$cart['id_customer']."";
    $sql .= " AND id_shop=".(int)$id_shop."";
    $db->query($sql);
} else {
    $sql = "DELETE FROM " . _DB_PREFIX_ . "favorite_product";
    $sql .= " WHERE id_customer=".(int)$cart['id_customer']."";
    $sql .= " AND id_shop=".(int)$id_shop."";
    $db->query($sql);
}
