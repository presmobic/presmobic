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
$id_product = (int)Tools::getValue('id_product');
$use_email = (string)Tools::getValue('use_name');
$use_pass = (string)Tools::getValue('use_pass');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context=Context::getContext();
$customer = new Customer();
$id_guest = $context->cart->id_guest;
$id_shop = $context->shop->id;
$id_shop_group = $context->shop->id_shop_group;
$id_page = $context->theme->product_per_page;
$id_address = $context->customer->ip_registration_newsletter;
$date = date("Y-m-d H:i:s");
$sql = "INSERT INTO "._DB_PREFIX_."connections (id_connections,id_shop_group,id_shop,id_guest,id_page,ip_address ";
$sql .= " ,date_add,http_referer) VALUES ('',".(int)$id_shop_group.",".(int)$id_shop.",'".(int)$id_guest."'";
$sql .= " ,'".(int)$id_page."','".(int)$id_address."','".pSQL($date)."','')";
$db->query($sql);
$customer->logout();
die;
