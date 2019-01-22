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

class BaForgotPassword extends PresMobileApp
{
    public function __construct()
    {
    }
    public function start($arg)
    {
        $arg;
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $controller = 'forgotpassword';
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $id_shop = $context->shop->id;
        $af = 'SELECT `email` FROM '._DB_PREFIX_.'customer c ';
        $af .= 'WHERE c.`secure_key` = \''.pSQL($arg[0]).'\' AND c.id_customer = '.(int)$arg[1];
        $email = Db::getInstance()->getValue($af);
        if ($email) {
            $customer = new Customer();
            $customer->getByemail($email);
            $customer->passwd = Tools::encrypt($password = Tools::passwdGen(MIN_PASSWD_LENGTH));
            $customer->last_passwd_gen = date('Y-m-d H:i:s', time());
            if ($customer->update()) {
                $mail_params = array(
                    '{email}' => $customer->email,
                    '{lastname}' => $customer->lastname,
                    '{firstname}' => $customer->firstname,
                    '{passwd}' => $password
                );
                $aa = $context->language->id;
                $ab = Mail::l('Your new password');
                $ac = $customer->email;
                $ad = $customer->firstname.' '.$customer->lastname;
                if (!Mail::Send($aa, 'password', $ab, $mail_params, $ac, $ad)) {
                    $context->smarty->assign("status", 1);
                } else {
                    $context->smarty->assign("status", 0);
                }
            }
        }
        $sql_meta = "SELECT * FROM " . _DB_PREFIX_ . "meta_lang WHERE id_lang=".(int)$id_lang." ";
        $sql_meta .= "AND id_shop=".(int)$id_shop." AND id_meta=7";
        $db_meta = $db->Executes($sql_meta);
        $context->smarty->assign("email", $customer->email);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/login/forgot.tpl';
        $content =  $context->smarty->fetch($a);
        $presmobileapp = new PresMobileApp();
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'chir' =>$presmobileapp->l('Forgot Password'),
            'batitle' =>$db_meta[0]['title'].'-'.$shop_name,
            'description' => strip_tags($db_meta[0]['description'])
        );
        echo json_encode($result);
        die;
    }
}
