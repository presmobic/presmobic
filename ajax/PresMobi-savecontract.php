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
include_once($url_fodel.'presmobileapp/libs/PHPMailer/PHPMailerAutoload.php');
$name = Tools::getValue('name');
$email = Tools::getValue('email');
$id_subject = Tools::getValue('id_contact');
$orderreference = Tools::getValue('orderreference');
$message = Tools::getValue('message');
$presmobileapp = new PresMobileApp();
$context = Context::getContext();
$id_lang = $context->language->id;
$contact = new ContactCore();
$contact = $contact::getContacts($id_lang);
if (!empty($id_subject)) {
    foreach ($contact as $key => $value) {
        if ($id_subject == $value['id_contact']) {
            $subject = $value['name'];
        }
    }
}
$id_shop = $context->shop->id;
if (!Validate::isEmail($email) || $email == false) {
    $result = array(
        'messenger'=>$presmobileapp->l('Invalid email address.'),
        'status'=>401
    );
    echo json_encode($result);
    die;
}
if ($id_subject == '0') {
    $result = array(
        'messenger'=>$presmobileapp->l('Please select a subject from the list provided.'),
        'status'=>401
    );
    echo json_encode($result);
    die;
}
if ($message ==false) {
    $result = array(
        'messenger'=>$presmobileapp->l('The message cannot be blank.'),
        'status'=>401
    );
    echo json_encode($result);
    die;
}
$contact = array(
    'contact' => array(
        'name' => $name,
        'email' =>$email,
        'orderreference' => $orderreference,
        'message' =>$message
    )
);
if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
    $presmobicBeforeSubmitContacUs = $core->mobiexec172('presmobicBeforeSubmitContacUs', array(), $contact);
} elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
    $presmobicBeforeSubmitContacUs = $core->mobiexec17('presmobicBeforeSubmitContacUs', array(), $contact);
} else {
    $presmobicBeforeSubmitContacUs = $core->mobiexec('presmobicBeforeSubmitContacUs', array(), $contact);
}
if (is_array($presmobicBeforeSubmitContacUs)) {
    $name = $presmobicBeforeSubmitContacUs['contact']['name'];
    $email = $presmobicBeforeSubmitContacUs['contact']['email'];
    $orderreference = $presmobicBeforeSubmitContacUs['contact']['orderreference'];
    $message = $presmobicBeforeSubmitContacUs['contact']['message'];
}
$date_add = date('Y-m-d H:i:s');
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$sql = "INSERT INTO " . _DB_PREFIX_ . "customer_thread VALUES";
$sql .= "('','".(int)$id_shop."','".(int)$id_lang."','0','0','0','0','open',";
$sql .= "'".pSQL($email)."','','".pSQL($date_add)."','".pSQL($date_add)."')";
$db->query($sql);
$id_customer_thread = $db->Insert_ID();
$sql1 = "INSERT INTO " . _DB_PREFIX_ . "customer_message VALUES";
$sql1 .= "('','".(int)$id_customer_thread."','0','".pSQL($message)."','',";
$sql1 .= "'0','','".pSQL($date_add)."','".pSQL($date_add)."','','')";
$db->query($sql1);
$context->smarty->assign("subject", $subject);
$context->smarty->assign("message", $message);
$context->smarty->assign("orderreference", $orderreference);
$a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/hook/front/template.tpl';
$html = $context->smarty->fetch($a);
$mail = new PHPMailer();
$email_sent = Configuration::get('PS_SHOP_EMAIL');
$mail->setFrom($email_sent, '');
$mail->addAddress($email, '');
$mail->IsHTML(true);
$mail->Subject = $subject;
$mail->msgHTML($html);
$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';
//Replace the plain text body with one created manually
$mail->AltBody = strip_tags($html);
$sent = $mail->send();
if ($sent == false) {
    $result = array(
        'messenger'=>$presmobileapp->l('Send Mail Fail.'),
        'status'=>401
    );
    echo json_encode($result);
    die;
}
$result = array(
    'messenger'=>$presmobileapp->l('Your message has been successfully sent to our team.'),
    'status'=>200
);
echo json_encode($result);
die;
