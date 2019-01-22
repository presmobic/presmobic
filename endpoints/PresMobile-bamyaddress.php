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

class BaMyAddress extends PresMobileApp
{
    public function __construct()
    {
        parent::__construct();
    }
    public function start($arg)
    {
        $arg;
        $presmobileapp = new PresMobileApp();
        $controller = 'myaddress';
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $context = Context::getContext();
        $id_shop = $context->shop->id;
        $id_lang = $context->language->id;
        $cart_r = new Cart($context->cart->id);
        $customer = new Customer($cart_r->id_customer);
        $customer_br = $customer->getAddresses($context->language->id);
        $alias = array();
        $check = 0;
        foreach ($customer_br as $key => $value) {
            $key;
            if ($cart_r->id_address_delivery == $value['id_address']) {
                $check = 1;
            }
        }
        if ($check == '0') {
            $cart_r->id_address_delivery = $customer_br[0]['id_address'];
            $cart_r->id_address_invoice = $customer_br[0]['id_address'];
        }
        $cart_r->update();
        $address_delivery = array();
        $address_invoice = array();
        if (!empty($customer_br)) {
            foreach ($customer_br as $key1 => $value1) {
                $key1;
                $alias[$value1['id_address']] = $value1['alias'];
                if ($cart_r->id_address_delivery == $value1['id_address']) {
                    $address_delivery[0] = array(
                    'id_address' => $value1['id_address'],
                    'alias' => $value1['alias'],
                    'company' => $value1['company'],
                    'lastname' => $value1['lastname'],
                    'firstname' => $value1['firstname'],
                    'address1' => $value1['address1'],
                    'address2' => $value1['address2'],
                    'postcode' => $value1['postcode'],
                    'city' => $value1['city'],
                    'other' => $value1['other'],
                    'phone' => $value1['phone'],
                    'phone_mobile' => $value1['phone_mobile'],
                    'vat_number' => $value1['vat_number'],
                    'country' => $value1['country'],
                    'state' => $value1['state']
                    );
                }
                if ($cart_r->id_address_invoice == $value1['id_address']) {
                    $address_invoice[0] = array(
                    'id_address' => $value1['id_address'],
                    'alias' => $value1['alias'],
                    'company' => $value1['company'],
                    'lastname' => $value1['lastname'],
                    'firstname' => $value1['firstname'],
                    'address1' => $value1['address1'],
                    'address2' => $value1['address2'],
                    'postcode' => $value1['postcode'],
                    'city' => $value1['city'],
                    'other' => $value1['other'],
                    'phone' => $value1['phone'],
                    'phone_mobile' => $value1['phone_mobile'],
                    'vat_number' => $value1['vat_number'],
                    'country' => $value1['country'],
                    'state' => $value1['state']
                    );
                }
            }
        }
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $batitle = $shop_name;
        } else {
            $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
            $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=21";
            $db_meta = $db->Executes($sql_meta);
            $batitle = $db_meta[0]['title'].' - '.$shop_name;
        }
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $context->smarty->assign("url", $url);
        $context->smarty->assign("alias", $alias);
        $context->smarty->assign("address_invoice", $address_invoice);
        $context->smarty->assign("address_delivery", $address_delivery);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/address/myaddress.tpl';
        $content =  $context->smarty->fetch($a);
        $result = array(
        'controller' => $controller,
        'content' => $content,
        'batitle' => $batitle,
        'chir' => $presmobileapp->l('Checkout')
        );
        echo json_encode($result);
        die;
    }
}
