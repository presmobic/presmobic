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

class BaHook extends PresMobileApp
{
    public function __construct()
    {
        parent::__construct();
    }
    // hook displayBeforeHeader
    public function presmobicDisplayBeforeHeader()
    {
    }
    // hook displayBeforeLogo
    public function presmobicDisplayBeforeLogo()
    {
    }
    // hook displayAfterLogo
    public function presmobicDisplayAfterLogo()
    {
    }
    // hook displayBeforeMiniCart
    public function presmobicDisplayBeforeMiniCart()
    {
    }
    // hook displayAfterMiniCart
    public function presmobicDisplayAfterMiniCart()
    {
    }
    // hook displayAfterHeader
    public function presmobicDisplayAfterHeader()
    {
    }


    // hook displayBeforeSlider
    public function presmobicDisplayBeforeSlider()
    {
    }
    // hook displayAfterSlider
    public function presmobicDisplayAfterSlider()
    {
    }
    // hook getSlideData
    public function presmobicGetSlideData()
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $sql = "SELECT * FROM "._DB_PREFIX_."ba_premobic_slider WHERE id_lang='".$id_lang."'";
        $sql .= " AND active =1";
        $infor = $db->ExecuteS($sql);
        return $infor;
    }
    // hook displayBeforeLatestTitle
    public function presmobicDisplayBeforeLatestTitle()
    {
    }
    // hook displayAfterLatestTitle
    public function presmobicDisplayAfterLatestTitle()
    {
    }
    // hook presmobicDisplayAfterOurClients
    public function presmobicDisplayAfterOurClients()
    {
    }
    // hook getLatestCategoriesData
    public function presmobicGetLatestCategoriesData()
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $context = Context::getContext();
        $id_shop= $context->shop->id;
        $id_lang = $context->language->id;
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "category p JOIN " . _DB_PREFIX_ . "category_lang pl";
        $sql .= " ON p.id_category=pl.id_category";
        $sql .= " WHERE p.level_depth=2 AND pl.id_shop=".(int)$id_shop." AND pl.id_lang=".(int)$id_lang."";
        $data = $db->Executes($sql);
        return $data;
    }
    // hook displayBeforeLatestContent
    public function presmobicDisplayBeforeLatestContent()
    {
    }
    // hook displayAfterLatestContent
    public function presmobicDisplayAfterLatestContent()
    {
    }
    // hook displayBeforeOurClients
    public function presmobicDisplayBeforeOurClients()
    {
    }
    // hook getClientsData
    public function presmobicGetClientsData()
    {
    }
    // hook displayBeforeOurCategories
    public function presmobicDisplayBeforeOurCategories()
    {
    }
    // hook displayAfterOurCategories
    public function presmobicDisplayAfterOurCategories()
    {
    }
    // hook getOurCategoriesData
    public function presmobicGetOurCategoriesData()
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $linkimages = new Link();
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $is_shop = $context->shop->id;
        $sql = "SELECT * FROM " . _DB_PREFIX_ . "category p JOIN " . _DB_PREFIX_ . "category_lang pl";
        $sql .= " ON p.id_category=pl.id_category";
        $sql .= " WHERE p.level_depth=2 AND pl.id_shop=".(int)$is_shop." AND pl.id_lang=".(int)$id_lang."";
        $data = $db->Executes($sql);
        foreach ($data as $key => $value) {
            $img = $linkimages->getCatImageLink('category', $value['id_category']);
            $data[$key]['link_img'] = strstr($img, 'img/c');
            if (file_exists(_PS_CAT_IMG_DIR_.(int)$value['id_category'].'.jpg')) {
                $data[$key]['link_img'] = strstr($img, 'img/c');
            } else {
                $data[$key]['link_img'] = 'modules/presmobileapp/views/img/backgroundnoimg.png';
            }
        }
        return $data;
    }
    // hook displayBeforeFeaturedBrands
    public function presmobicDisplayBeforeFeaturedBrands()
    {
    }
    // hook displayAfterFeaturedBrands
    public function presmobicDisplayAfterFeaturedBrands()
    {
    }
    // hook getBrandsData
    public function presmobicGetBrandsData()
    {
        $feature = new Manufacturer();
        $fea = $feature->getManufacturers();
        $feature = Manufacturer::getManufacturers();
        $id_lang = Context::getContext()->language->id;
        $images_types = 'jpg';
        foreach ($fea as $key => $value) {
            $image = _PS_MANU_IMG_DIR_.$value['id_manufacturer'].'.jpg';
            $image_url = ImageManager::thumbnail(
                $image,
                'manufacturer_mini_'.(int)$value['id_manufacturer'].'_'.$id_lang.'.'.$images_types,
                350,
                $images_types,
                true,
                true
            );
            $image_size = file_exists($image) ? filesize($image) / 1000 : false;
            $fea[$key]['image'] = $image_url;
            if ($image_size == false) {
                $fea[$key]['check'] = 0;
            } else {
                $fea[$key]['check'] = 1;
            }
        }
        return $fea;
    }
    // hook displayBeforeTextStatic
    public function presmobicDisplayBeforeTextStatic()
    {
    }
    // hook displayFooter
    public function presmobicDisplayFooter()
    {
    }
    // hook displayBeforeNewsletter
    public function presmobicDisplayBeforeNewsletter()
    {
    }
    // hook displayAfterNewsletter
    public function presmobicDisplayAfterNewsletter()
    {
    }
    // hook beforeUpdateEmailNewsletter
    public function presmobicBeforeUpdateEmailNewsletter()
    {
    }
    // hook displayBeforeFooterText
    public function presmobicDisplayBeforeFooterText()
    {
    }
    // hook displayAfterFooterText
    public function presmobicDisplayAfterFooterText()
    {
    }
    // hook displayBeforeSocialFooter
    public function presmobicDisplayBeforeSocialFooter()
    {
    }
    // hook displayAfterSocialFooter
    public function presmobicDisplayAfterSocialFooter()
    {
    }
    // hook displayAfterFooter
    public function presmobicDisplayAfterFooter()
    {
    }
    public function dateDifference($date_1, $date_2, $differenceFormat = '%i')
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format($differenceFormat);
    }
}
