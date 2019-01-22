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
$context=Context::getContext();
$idlang = $context->language->id;
$id_shop = $context->shop->id;
$languages = Language::getLanguages();
$id_lang_default = Configuration::get('PS_LANG_DEFAULT');
$active_add = Tools::getValue('active_add');
$urlimages = Tools::getValue('urlimages');
$target_dir = 'views/img/slideshow/';
$date_create = date('Y-m-d H:i:s');
$date_upd = date('Y-m-d H:i:s');
$banameimg1 = $_FILES["fileToUpload"]["name"];
$banameimg = basename($_FILES["fileToUpload"]["name"][$id_lang_default]);
$url_video_tmp = _PS_MODULE_DIR_.'presmobileapp/views/img/'.$banameimg;
move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$id_lang_default], $url_video_tmp);
foreach ($languages as $key => $value) {
    $img_url = basename($_FILES["fileToUpload"]["name"][$value['id_lang']]);
    if ($value['id_lang'] == $id_lang_default) {
        $sql = "SELECT * FROM  " . _DB_PREFIX_ . "ba_premobic_slider";
        $id = $db->Executes($sql);
        $position = count($id) + 1;
        $target_file = $target_dir . $img_url;
        $sql1 = "INSERT INTO "._DB_PREFIX_."ba_premobic_slider ";
        $sql1 .= "(id,id_lang,images,name,url_images,date_create,date_upd,language,position,active)";
        $sql1 .= " VALUES ('','".(int)$value['id_lang'] ."','".pSQL($target_file)."','".pSQL($img_url)."','";
        $sql1 .= "".pSQL($urlimages[$value['id_lang']])."','".pSQL($date_create)."','".pSQL($date_upd)."','";
        $sql1 .= "".pSQL($value['name'])."','".(int)$position."','".pSQL($active_add[$value['id_lang']])."')";
        $db->query($sql1);
        $url_save_img = _PS_MODULE_DIR_.'presmobileapp/views/img/slideshow/'.$img_url;
        copy($url_video_tmp, $url_save_img);
    } else {
        if ($img_url == '') {
            $linkimages = $urlimages[$value['id_lang']];
            if ($linkimages == '') {
                $linkimages = $urlimages[$id_lang_default];
            }
            $sql = "SELECT * FROM  " . _DB_PREFIX_ . "ba_premobic_slider";
            $id = $db->Executes($sql);
            $position = count($id) + 1;
            $target_file = $target_dir . $banameimg;
            $sql1 = "INSERT INTO "._DB_PREFIX_."ba_premobic_slider ";
            $sql1 .= "(id,id_lang,images,name,url_images,date_create,date_upd,language,position,active)";
            $sql1 .= " VALUES ('','".(int)$value['id_lang'] ."','".pSQL($target_file)."','".pSQL($banameimg)."','";
            $sql1 .= "".pSQL($linkimages)."','".pSQL($date_create)."','".pSQL($date_upd)."','";
            $sql1 .= "".pSQL($value['name'])."','".(int)$position."','".pSQL($active_add[$value['id_lang']])."')";
            $db->query($sql1);
            $url_save_img = _PS_MODULE_DIR_.'presmobileapp/views/img/slideshow/'.$banameimg;
            copy($url_video_tmp, $url_save_img);
        }
        if ($img_url != '') {
            $linkimages = $urlimages[$value['id_lang']];
            if ($linkimages == '') {
                $linkimages = $urlimages[$id_lang_default];
            }
            $img_url_ex = basename($_FILES["fileToUpload"]["name"][$value['id_lang']]);
            $target_file = $target_dir . $img_url_ex;
            $sql = "SELECT * FROM  " . _DB_PREFIX_ . "ba_premobic_slider";
            $id = $db->Executes($sql);
            $position = count($id) + 1;
            $sql1 = "INSERT INTO "._DB_PREFIX_."ba_premobic_slider";
            $sql1 .= "(id,id_lang,images,name,url_images,date_create,date_upd,language,position,active)";
            $sql1 .= " VALUES ('','".(int)$value['id_lang'] ."','".pSQL($target_file)."','".pSQL($img_url_ex)."','";
            $sql1 .= "".pSQL($linkimages)."','".pSQL($date_create)."','".pSQL($date_upd)."','";
            $sql1 .= "".pSQL($value['name'])."','".(int)$position."','".pSQL($active_add[$value['id_lang']])."')";
            $db->query($sql1);
            $url_save_img = _PS_MODULE_DIR_.'presmobileapp/views/img/slideshow/'.$img_url_ex;
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$value['id_lang']], $url_save_img);
        }
    }
}
$url_dele = _PS_MODULE_DIR_.'presmobileapp/views/img/';
$file = $url_dele.$banameimg;
@unlink($file);
echo "1";
