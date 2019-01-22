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

class BaCheckOutAddress extends PresMobileApp
{
    public function __construct()
    {
    }
    public function start($arg)
    {
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $url_fodel = _PS_MODULE_DIR_;
        $controller = 'checkoutaddress';
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $id_shop = $context->shop->id;
        $id_country = $context->country->id;
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $cart = $core->presMobicartresult();
        $coutry = Country::getCountries($id_lang, true);
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $delivery = array();
        $id_address = 0;
        if (!empty($arg[0])) {
            $id_address = $arg[0];
            $query_dely = "SELECT *FROM " . _DB_PREFIX_ . "address WHERE id_address='" . (int)$arg[0]. "' ";
            $address_delivery = $db->ExecuteS($query_dely);
            foreach ($address_delivery as $key => $value) {
                $delivery[$key]['id_address_delivery'] = $value['id_address'];
                $delivery[$key]['alias'] = $value['alias'];
                $delivery[$key]['company'] = $value['company'];
                $delivery[$key]['lastname'] = $value['lastname'];
                $delivery[$key]['firstname'] = $value['firstname'];
                $delivery[$key]['address1'] = $value['address1'];
                $delivery[$key]['address2'] = $value['address2'];
                $delivery[$key]['postcode'] = $value['postcode'];
                $delivery[$key]['city'] = $value['city'];
                $delivery[$key]['phone'] = $value['phone'];
                $delivery[$key]['phone_mobile'] = $value['phone_mobile'];
                $delivery[$key]['id_country'] = $value['id_country'];
                $delivery[$key]['id_state'] = $value['id_state'];
            }
        } else {
            $delivery[0]['id_address_delivery'] = '';
            $delivery[0]['alias'] = '';
            $delivery[0]['company'] = '';
            $delivery[0]['lastname'] = '';
            $delivery[0]['firstname'] = '';
            $delivery[0]['address1'] = '';
            $delivery[0]['address2'] = '';
            $delivery[0]['postcode'] = '';
            $delivery[0]['city'] = '';
            $delivery[0]['phone'] = '';
            $delivery[0]['phone_mobile'] = '';
            $delivery[0]['id_country'] = 0;
            $delivery[0]['id_state'] = 0;
        }
        $arrayName = array();
        foreach ($coutry as $key => $value) {
            $arrayName[$value["id_country"]] = array('value' => $value["iso_code"], 'name' => $value["name"]);
            $query = "SELECT *FROM " . _DB_PREFIX_ . "state WHERE id_country='" . (int)$value["id_country"] . "' ";
            $params = $db->ExecuteS($query);
            $array = array();
            $aa = array();
            if (!empty($params)) {
                foreach ($params as $key1 => $value1) {
                    $key1;
                    $aa = array('value' => $value1["iso_code"], 'name' => $value1["name"]);
                    $array[$value["id_country"]][$value1["id_state"]] = $aa;
                }
            }
        }
        $localtion = array('countries' => $arrayName, 'states' => $array);
        $id_customer = $cart['id_customer'];
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
        $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=11";
        $db_meta = $db->Executes($sql_meta);
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $batitle = $db_meta[0]['title'];
        } else {
            $batitle = $db_meta[0]['title'].' - '.$shop_name;
        }
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobicBeforeAddAddress = $core->mobiexec172('presmobicBeforeAddAddress', array());
            $presmobicAfterAddAddress = $core->mobiexec172('presmobicAfterAddAddress');
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobicBeforeAddAddress = $core->mobiexec17('presmobicBeforeAddAddress', array());
            $presmobicAfterAddAddress = $core->mobiexec17('presmobicAfterAddAddress');
        } else {
            $presmobicBeforeAddAddress = $core->mobiexec('presmobicBeforeAddAddress', array());
            $presmobicAfterAddAddress = $core->mobiexec('presmobicAfterAddAddress');
        }
        $context->smarty->assign("presmobicBeforeAddAddress", $presmobicBeforeAddAddress);
        $context->smarty->assign("presmobicAfterAddAddress", $presmobicAfterAddAddress);
        
        $context->smarty->assign("url", $url);
        $context->smarty->assign("delivery", $delivery);
        $context->smarty->assign("localtion", $localtion);
        $context->smarty->assign("id_address", $id_address);
        $context->smarty->assign("id_country_default", $id_country);
        $context->smarty->assign("cartba", $cart);
        $context->smarty->assign("id_customer", $id_customer);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/checkout/address.tpl';
        $content =  $context->smarty->fetch($a);
        $presmobileapp = new PresMobileApp();
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'batitle' =>$batitle,
            'chir' => $presmobileapp->l('Address')
        );
        echo json_encode($result);
        die;
    }
}
