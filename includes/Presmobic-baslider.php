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

class BAmobiSlider extends PresMobileApp
{
    private $status = array('No','Yes');
    public function __construct()
    {
        parent::__construct();
    }
    public function createSliderList()
    {
        $helper = new HelperList();
        $helper->bootstrap = true;
        $helper->no_link = true;
        $helper->explicitSelect = true;
        $helper->allow_export = true;
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->actions = array('edit','delete');
        $helper->toolbar_btn['new'] =  array(
            'href' => AdminController::$currentIndex.'&configure='.$this->name
            .'&add=1&task=slider&token='.Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Add new')
        );
        $helper->identifier = 'id';// Ten khoa chinh
        $helper->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'icon' => 'icon-trash',
                'confirm' => $this->l('Delete selected items?')
            )
        );
        $helper->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete'),
                'href' => AdminController::$currentIndex.'&configure='.$this->name
            .'&delete=1&task=slider&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Add new')
            )
        );
        $helper->show_toolbar = true;
        $helper->title = $this->l('Slider List');
        $helper->table = $this->name.'ba_premobic_slider';
        $helper->list_id = $this->name.'ba_premobic_slider';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->_orderBy = 'position';
        $helper->_orderWay = 'ASC';
        $helper->_use_found_rows = true;
        $helper->currentIndex=AdminController::$currentIndex.'&configure='.$this->name.'&task=slider';
        $page = Tools::getValue('submitFilter'.$helper->list_id);
        if (!empty($page)) {
            $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name
            .'&task=slider&submitFilter'.$helper->list_id.'='.(int)$page;
        }
        $langhelp = array();
        $languages = Language::getLanguages();
        foreach ($languages as $key_help => $value_help) {
            $key_help;
            $langhelp[$value_help['id_lang']] = $value_help['name'];
        }
        $fields_list = array(
            'id' => array(
                'title' => $this->l('ID'),
                'width' => 30,
                'type' => 'int',
                'align' => 'center',
            ),
            'images' => array(
                'title' => $this->l('Images'),
                'width' => 100,
                'type' => 'text',
                'align' => 'images',
                'callback' =>'getImageToHelpperList',
                'callback_object' =>$this,
                'filter' => false,
                'search' => false,
                'orderby' => false,
                'class' => 'image_helpperlist'
            ),
            'date_create' => array(
                'title' => $this->l('Created Date'),
                'width' => 100,
                'type' => 'datetime',
                'align' => 'date_create',
                'orderby' => false,
                'search' => false
            ),
            'date_upd' => array(
                'title' => $this->l('Updated Date'),
                'width' => 100,
                'type' => 'date_upd',
                'orderby' => false,
                'search' => false,
                'align' => 'left',
            ),
            'position' => array(
                'title' => $this->l('Position'),
                'width' => 100,
                'type' => 'int',
                'align' => 'center',
            ),
            'active' => array(
                'title' => $this->l('Status'),
                'width' => 50,
                'align' => 'center',
                'type' => 'select',
                'list' => array(
                    0 => $this->l('No'),
                    1 => $this->l('Yes'),
                ),
                'filter_key' => 'active',
                'active' => 'status',
                'callback' => 'changeactive',
                'callback_object' => $this
            ),
            'language' => array(
                'title' => $this->l('Languages'),
                'type' => 'select',
                'list' => $langhelp,
                'filter_key' => 'language',
                'align' => 'left'
            )
        );
        if ($this->context->cookie->{'presmobileappba_premobic_sliderOrderby'} == ""
        && $this->context->cookie->{'presmobileappba_premobic_sliderOrderway'} == "") {
            $this->context->cookie->{'presmobileappba_premobic_sliderOrderby'} = "position";
            $this->context->cookie->{'presmobileappba_premobic_sliderOrderway'} = "ASC";
        } else {
            $valueorderby = Tools::getValue($helper->list_id . "Orderby");
            $valueorderway = Tools::getValue($helper->list_id . "Orderway");
            if ($valueorderby != false && $valueorderway != false) {
                $this->context->cookie->{'presmobileappba_premobic_sliderOrderby'} = $valueorderby;
                $this->context->cookie->{'presmobileappba_premobic_sliderOrderway'} = Tools::strtoupper($valueorderway);
            }
        }
        $helper->orderBy = $this->context->cookie->{'presmobileappba_premobic_sliderOrderby'};
        $helper->orderWay = $this->context->cookie->{'presmobileappba_premobic_sliderOrderway'};
        $helper->listTotal=$this->getTotalList($helper);
        $html =$helper->generateList($this->getListContentImgslider($helper), $fields_list);
        return $html;
    }
    public function getTotalList($helper)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $orderby = pSQL(Tools::getValue($helper->list_id."Orderby", "position"));
        $orderway = pSQL(Tools::getValue($helper->list_id."Orderway", "ASC"));
        $sql = 'SELECT count(*) FROM '._DB_PREFIX_.'ba_premobic_slider';
        $sql .= $this->setWhereClause($helper);
        $sql .=' ORDER BY '.pSQL($orderby).' '.pSQL($orderway);
        $total = $db->getValue($sql);
        return $total;
    }
    public function getListContentImgslider($helper)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $id_shop =($this->context->shop->id);
        $id_shop;
        $allShop = Context::getContext()->cookie->shopContext;
        if ($allShop == false) {
            $sql = 'SELECT count(*) FROM '._DB_PREFIX_.'ba_premobic_slider ';
        } else {
            $sql = 'SELECT count(*) FROM '._DB_PREFIX_.'ba_premobic_slider ';
        }
        if (Tools::isSubmit('submitFilter')) {
            $sql .= $this->setWhereClause($helper);
        }
        $orderby = pSQL(Tools::getValue($helper->list_id."Orderby", "position"));
        $orderway = pSQL(Tools::getValue($helper->list_id."Orderway", "ASC"));
        //pagination
        // get items per page
        $cookiePagination = $this->context->cookie->{$helper->list_id.'_pagination'};
        $selected_pagination=(int)Tools::getValue($helper->list_id.'_pagination', $cookiePagination);
        if ($selected_pagination<=0) {
            $selected_pagination = 20;
        }
        $this->context->cookie->{$helper->list_id.'_pagination'}=$selected_pagination;
        $page = (int)Tools::getValue('submitFilter'.$helper->list_id, 1);
        if (!$page) {
            $page =1;
        }
        $this->context->cookie->{'submitFilter'.$helper->list_id}=$page;
        $start = ($page -1)* $selected_pagination;
        $sql = 'SELECT * FROM '._DB_PREFIX_.'ba_premobic_slider';
        $sql .= $this->setWhereClause($helper);
        $sql .=' ORDER BY '.pSQL($orderby).' '.pSQL($orderway).' LIMIT '.(int)$start.', '.(int)$selected_pagination;
        $rows = $db->ExecuteS($sql);
        foreach ($rows as $key => $value) {
            $value;
            if ($rows[$key]['url_images'] == '') {
                $rows[$key]['url_images'] = '--';
            }
        }
        return $rows;
    }
    public function setWhereClause($helper)
    {
        $sql_id = '';
        $sql_position = '';
        $sql_language = '';
        $array_where = array();
        $allShop = Context::getContext()->cookie->shopContext;
        if ($allShop == false) {
            $where = ' WHERE ';
        } else {
            $where = ' WHERE ';
        }
        if (Tools::getValue($helper->list_id."Filter_id", null) !== null) {
            $sql_id = pSQL(Tools::getValue($helper->list_id."Filter_id"));
            $this->context->cookie->{$helper->list_id.'Filter_id'} = $sql_id;
        }
        if ($sql_id != false) {
            $array_where[] = "id=".pSQL($sql_id)."";
        }
        if (Tools::getValue($helper->list_id."Filter_position", null) !== null) {
            $sql_position = pSQL(Tools::getValue($helper->list_id."Filter_position"));
            $this->context->cookie->{$helper->list_id.'Filter_position'} = $sql_position;
        }
        if ($sql_position != false) {
            $array_where[] = "position=".pSQL($sql_position)."";
        }
        if (Tools::getValue($helper->list_id."Filter_language", null) !== null) {
            $sql_language = pSQL(Tools::getValue($helper->list_id."Filter_language"));
            $this->context->cookie->{$helper->list_id.'Filter_language'} = $sql_language;
        }
        if ($sql_language != false) {
            $array_where[] = "id_lang=".(int)$sql_language."";
        }
        if (Tools::getValue($helper->list_id."Filter_active", null) !== null) {
            $sql_active = pSQL(Tools::getValue($helper->list_id."Filter_active"));
            $this->context->cookie->{$helper->list_id.'Filter_active'} = $sql_active;
        }
        if (isset($sql_active)) {
            $array_where[] = "active LIKE '%".pSQL($sql_active)."%'";
        }
        if (empty($array_where)) {
            return false;
        } else {
            $where .= implode(' AND ', $array_where);
        }
        return $where;
    }
    public function changeactive($objname)
    {
        $name_type = '';
        if ($objname == 0) {
            $name_type = 'No';
        }
        if ($objname == 1) {
            $name_type = 'Yes';
        }
        return $name_type;
    }
}
