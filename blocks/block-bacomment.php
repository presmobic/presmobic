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
        $this->name = "comment";
        $this->version = "1.0.0";
        $this->displayName = $this->l('What\'s client say?');
        $this->hook = array('content');
        $this->description = $this->l('display latest comment in "What\'s client say" block on Home page');
    }
    public function render($arg = array())
    {
        $arg;
        $context = Context::getContext();
        $url_fodel = _PS_MODULE_DIR_;
        include_once($url_fodel.'presmobileapp/includes/Presmobic-core.php');
        include_once($url_fodel.'presmobileapp/includes/Presmobic-bahook.php');
        $core = new BaCore();
        $url = $core->getMobiBaseLink();
        $context = Context::getContext();
        $param = array();
        if (Module::isInstalled("productcomments")) {
            $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
            $query = "SELECT *FROM " . _DB_PREFIX_ . "product_comment WHERE validate='1'";
            $query .= " ORDER BY id_product_comment DESC LIMIT 0,3";
            $param = $db->ExecuteS($query);
        } else {
            return '';
        }
        if (empty($param)) {
            return '';
        }
        if (!empty($param)) {
            foreach ($param as $key => $value) {
                $time_minus = date('Y-m-d H:i:s');
                $total = 0;
                $date_minus = $this->dateDifference($time_minus, $value['date_add']);
                if ($date_minus > 1) {
                    $total = $date_minus .' minutes';
                } else {
                    $total = $date_minus .' minute';
                }
                $hour = 0;
                if ($date_minus >=60) {
                    $hour = $date_minus/60;
                    if ($hour >= 2) {
                        $total = $hour .' hours';
                    } else {
                        $total = $hour .' hour';
                    }
                }
                if ($hour >=24) {
                    $days = $hour/24;
                    if ($days >=2) {
                        $total = $days .'days';
                    } else {
                        $total = $days .'day';
                    }
                }
                $param[$key]['cal_m'] = $total;
            }
        }

        if (Tools::version_compare(_PS_VERSION_, '1.7.0', '>=') && Tools::version_compare(_PS_VERSION_, '1.7.4', '<')) {
            $presmobicDisplayBeforeOurClients = $core->mobiexec172('presmobicDisplayBeforeOurClients', array());
            $presmobicDisplayAfterOurClients = $core->mobiexec172('presmobicDisplayAfterOurClients', array());
            $presmobicGetClientsData = $core->mobiexec172('presmobicGetClientsData', array('bacomment'=>$param));
        } elseif (Tools::version_compare(_PS_VERSION_, '1.7.4', '>=')) {
            $presmobicDisplayBeforeOurClients = $core->mobiexec17('presmobicDisplayBeforeOurClients', array());
            $presmobicDisplayAfterOurClients = $core->mobiexec17('presmobicDisplayAfterOurClients', array());
            $presmobicGetClientsData = $core->mobiexec17('presmobicGetClientsData', array('bacomment'=>$param));
        } else {
            $presmobicDisplayBeforeOurClients = $core->mobiexec('presmobicDisplayBeforeOurClients', array());
            $presmobicDisplayAfterOurClients = $core->mobiexec('presmobicDisplayAfterOurClients', array());
            $presmobicGetClientsData = $core->mobiexec('presmobicGetClientsData', array('bacomment'=>$param));
        }
        if (is_array($presmobicGetClientsData)) {
            $param = $presmobicGetClientsData['bacomment'];
        }
        $context->smarty->assign('presmobicDisplayBeforeOurClients', $presmobicDisplayBeforeOurClients);
        $context->smarty->assign('presmobicDisplayAfterOurClients', $presmobicDisplayAfterOurClients);
        $context->smarty->assign("url", $url);
        $context->smarty->assign("data", $param);
        $a = _PS_MODULE_DIR_ . '/presmobileapp/views/templates/front/block/comment.tpl';
        return $context->smarty->fetch($a);
    }
    public function dateDifference($date_1, $date_2, $differenceFormat = '%i')
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format($differenceFormat);
    }
}
