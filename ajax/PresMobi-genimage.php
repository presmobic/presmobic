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
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
$core = new BaCore();
$id_shop = Context::getContext()->shop->id;
$id_shop_group = Context::getContext()->shop->id_shop_group;
if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
    $image_type = ImageType::getFormattedName("presmobic");
} else {
    $image_type = ImageType::getFormatedName("presmobic");
}
$image_width = 480;
$image_height = 480;
$limit = Tools::getValue('limit');
$start = $limit+10;
if ($limit == 10) {
    $sql = "SELECT * FROM " . _DB_PREFIX_ . "product LIMIT 0,10";
} else {
    $sql = "SELECT * FROM " . _DB_PREFIX_ . "product LIMIT ".(int)($limit-10).",".(int)($limit)."";
}
$product = $db->Executes($sql);
$id_product = '';
if (!empty($product)) {
    foreach ($product as $key1 => $value1) {
        $id_product .= $value1['id_product'].',';
    }
} else {
    $sql1 = "SELECT * FROM " . _DB_PREFIX_ . "product";
    $product = $db->Executes($sql1);
    Configuration::updateValue('start_bamobicgenimg', '1', false, '', $id_shop_group, $id_shop);
    $result = array(
        'status' => 200,
        'stop'=> 1,
        'limit' =>count($product)
    );
    echo json_encode($result);
    die;
}
$id_product = rtrim($id_product, ',');
$sql1 = "SELECT * FROM " . _DB_PREFIX_ . "image WHERE id_product IN(".pSQL($id_product).")";
$image_array = $db->Executes($sql1);
$dir = _PS_PROD_IMG_DIR_;
if (!empty($image_array)) {
    foreach ($image_array as $key2 => $value2) {
        $image = new Image($value2['id_image']);
        $new_path = $image->getPathForCreation();
        $existing_img = $dir.$image->getExistingImgPath().'.jpg';
        $aa = $new_path.'-'.Tools::stripslashes($image_type).'.'.$image->image_format;
        $ab = $image_width;
        if (file_exists($existing_img) && filesize($existing_img)) {
            ImageManager::resize($existing_img, $aa, $ab, $image_height, $image->image_format);
        }
    }
}


$result = array(
    'status' => 200,
    'stop'=> 0,
    'limit' =>$start
);
echo json_encode($result);
die;
