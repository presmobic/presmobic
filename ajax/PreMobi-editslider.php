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
$demoMode = Configuration::get('demoModepremobic', null, '', null);
if ($demoMode == 1) {
    $ok = 2;
    echo $ok;
    die;
}
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$context = Context::getContext();
$id_lang_img = (int)Tools::getValue('id_lang_img');
$id = (int)Tools::getValue('id_img');
$images_tmp = (string)Tools::getValue('images_tmp');
$active = Tools::getValue('active_add');
$url_images = Tools::getValue('urlimages');
$filename = Tools::getValue('filename');
$target_dir = 'views/img/slideshow/';
$banameimg1 = $_FILES["fileToUpload"]["name"];
$date_upd = date('Y-m-d H:i:s');
if ($images_tmp == $filename[$id_lang_img]) {
    $sql1 = "UPDATE " . _DB_PREFIX_ . "ba_premobic_slider SET url_images='" . pSQL($url_images[$id_lang_img]) . "'";
    $sql1 .= " ,date_upd='" . pSQL($date_upd) . "',active='" .(int)$active[$id_lang_img]. "' ";
    $sql1 .= " WHERE name='" . pSQL($images_tmp) . "' AND id_lang = '".(int)$id_lang_img."'";
    $db->query($sql1);
} else {
    $banameimg1 = $banameimg1[$id_lang_img];
    $img_url = basename($_FILES["fileToUpload"]["name"][$id_lang_img]);
    $target_file = $target_dir . $img_url;
    $sql1 = "UPDATE " . _DB_PREFIX_ . "ba_premobic_slider SET url_images='" . pSQL($url_images[$id_lang_img]) . "'";
    $sql1 .= " ,date_upd='" . pSQL($date_upd) . "',active='" .(int)$active[$id_lang_img]. "' ";
    $sql1 .= " ,images='" . pSQL($target_file) . "',name='" .pSQL($banameimg1). "' ";
    $sql1 .= " WHERE id='" . (int)$id . "' AND id_lang = '".(int)$id_lang_img."'";
    $db->query($sql1);
    $url_video_tmp = _PS_MODULE_DIR_.'presmobileapp/views/img/slideshow/'.$banameimg1;
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$id_lang_img], $url_video_tmp);
}
echo "1";
