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

class BaComment extends PresMobileApp
{
    public function __construct()
    {
    }
    public function start($arg)
    {
        $arg;
        $id_product = (int)Tools::getValue('argument');
        $comment_check = Configuration::get('PRODUCT_COMMENTS_ALLOW_GUESTS');
        $comment_time = Configuration::get('PRODUCT_COMMENTS_MINIMAL_TIME');
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $url_fodel = _PS_MODULE_DIR_;
        $controller = 'comment';
        $context = Context::getContext();
        $check_comment = $context->cookie->checkcomment1;
        $show_comment = 0;
        if ($check_comment !== false) {
            $date_b = date('H:i:s');
            $time_diff = strtotime($date_b) - strtotime($check_comment);
            if ($time_diff >= $comment_time) {
                $show_comment = 1;
            } else {
                $show_comment = 0;
            }
        }
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $cart = $core->presMobicartresult();
        $comment = array();
        $rating = array();
        if (Module::isInstalled("productcomments")) {
            $select = "SELECT *FROM " . _DB_PREFIX_ . "product_comment WHERE id_product=".(int)$id_product."";
            $select .= " AND validate=1 limit 0,6";
            $param = $db->Executes($select);
        }
        if (!empty($param)) {
            $star_5 = 0;
            $star_4 = 0;
            $star_3 = 0;
            $star_2 = 0;
            $star_1 = 0;
            $count_total = 0;
            foreach ($param as $key => $value) {
                $key;
                $count_total += $value['grade'];
                if ($value['grade'] == '5') {
                    $star_5 += $value['grade'];
                }
                if ($value['grade'] == '4') {
                    $star_4 += $value['grade'];
                }
                if ($value['grade'] == '3') {
                    $star_3 += $value['grade'];
                }
                if ($value['grade'] == '2') {
                    $star_2 += $value['grade'];
                }
                if ($value['grade'] == '1') {
                    $star_1 += $value['grade'];
                }
            }
            $rating[5] = ($star_5/$count_total)*100;
            $rating[4] = ($star_4/$count_total)*100;
            $rating[3] = ($star_3/$count_total)*100;
            $rating[2] = ($star_2/$count_total)*100;
            $rating[1] = ($star_1/$count_total)*100;
            $comment['rating_star'] = $rating;
            $comment['total'] = number_format(($count_total/count($param)), 1);
            $comment['countcomment'] = count($param);
            $comment['grade'] = round($comment['total']);
            $comment['comment'] = $param;
        } else {
            $rating[5] = 0;
            $rating[4] = 0;
            $rating[3] = 0;
            $rating[2] = 0;
            $rating[1] = 0;
            $comment['rating_star'] = $rating;
            $comment['total'] = 0;
            $comment['countcomment'] = 0;
            $comment['grade'] = 0;
            $comment['comment'] = array();
        }
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        $core = new BaCore();
        $cart = $core->presMobicartresult();
        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobicBeforeComment = $core->mobiexec172('presmobicBeforeComment', array());
            $bacomment = array('bacommentp'=>$comment);
            $presmobicGetDataComment = $core->mobiexec172('presmobicGetDataComment', $bacomment);
            $presmobicAfterComment = $core->mobiexec172('presmobicAfterComment');
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobicBeforeComment = $core->mobiexec17('presmobicBeforeComment', array());
            $bacomment = array('bacommentp'=>$comment);
            $presmobicGetDataComment = $core->mobiexec17('presmobicGetDataComment', $bacomment);
            $presmobicAfterComment = $core->mobiexec17('presmobicAfterComment');
        } else {
            $presmobicBeforeComment = $core->mobiexec('presmobicBeforeComment', array());
            $bacomment = array('bacommentp'=>$comment);
            $presmobicGetDataComment = $core->mobiexec('presmobicGetDataComment', $bacomment);
            $presmobicAfterComment = $core->mobiexec('presmobicAfterComment');
        }
        if (is_array($presmobicGetDataComment)) {
            $comment = $presmobicGetDataComment['bacommentp'];
        }
        $url = $core->getMobiBaseLink();
        $context->smarty->assign("presmobicBeforeComment", $presmobicBeforeComment);
        $context->smarty->assign("presmobicAfterComment", $presmobicAfterComment);
        $context->smarty->assign("show_comment", $show_comment);
        $context->smarty->assign("cart", $cart);
        $context->smarty->assign("url", $url);
        $context->smarty->assign("comment_check", $comment_check);
        $context->smarty->assign("comment", $comment);
        $context->smarty->assign("id_product", $id_product);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/page/comment/comment.tpl';
        $content =  $context->smarty->fetch($a);
        $presmobileapp = new PresMobileApp();
        $result = array(
            'controller' => $controller,
            'content' => $content,
            'chir' => $presmobileapp->l('All Comments')
        );
        echo json_encode($result);
        die;
    }
}
