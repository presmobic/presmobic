{*
* 2007-2019 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author Buy Addons Team <hatt@buy-addons.com>
*  @copyright  2017-2019 Buy Addons Team
*  @version  Release: $Revision$
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{$displayFooter nofilter} {* no escape necessary *}
<div data-role="main" class="ui-content banner_1" style="clear: left;background: #e9e9e9;position: fixed;z-index: 999999;text-align:  center;bottom: 72px;width: fit-content;padding-top: 0;/* padding-left: 30%; */margin-left: 30%;/* line-height: 110px; */height: 15px;display: none;">
  <div style="margin-top: 6px; margin-left: 10px;" class="message_info">{l s='Update Success' mod='presmobileapp'}</div>
</div>
<div data-role="footer" role="contentinfo" class="footer-app ui-footer ui-bar-inherit" style="background: white;position:  fixed;z-index:  9999;bottom:  0px;width: 100%;border-top: 1px solid rgba(0, 0, 0, 0.1);">
  <div class="ui-grid-c">
   <div class="ui-block-a" style="text-align: center;">
    <a href="#home" class="menu-select redhome footer-home ba-active" onclick="PresMobiactivetab(this),PresMobibamobileroutes(this)" ba-link="#home" style="color: #7a7a7a;text-decoration:  none;font-weight: normal;">
     <span class="ion-ios-icon-home " style="font-size: 23px;"></span>
     <div style="text-shadow: none;font-size: 10px;">{l s='Home' mod='presmobileapp'}</div>
   </a>
 </div>
 <div class="ui-block-b" style="text-align: center;">
  <a href="#category" class="menu-select redcategory" onclick="PresMobiactivetab(this),PresMobibamobileroutes(this)" ba-link="#category" style="color: #7a7a7a;text-decoration:  none;font-weight: normal;">
   <span class="ion-ios-icon-grid-out" class="menu-select" style="font-size: 23px;"></span>
   <div style="text-shadow: none;font-size: 10px;">{l s='Category' mod='presmobileapp'}</div>
 </a>
</div>
<div class="ui-block-c"  style="text-align: center;">
  <a href="#search" class="menu-select redsearch" onclick="PresMobiactivetab(this),PresMobibamobileroutes(this)" ba-link="#search" style="color: #7a7a7a;text-decoration:  none;font-weight: normal;">
   <div class="ion-ios-icon-search" style="font-size: 23px;"></div>
   <div style="text-shadow: none;font-size: 10px;">{l s='Search' mod='presmobileapp'}</div>
 </a>
</div>
<div class="ui-block-d" style="text-align: center;">
  <a href="#account" class="menu-select redaccount" onclick="PresMobiactivetab(this),PresMobibamobileroutes(this)" ba-link="#account" style="color: #7a7a7a;text-decoration:  none;font-weight: normal;">
   <div class="ion-ios-icon-account-outline" style="font-size: 23px;"></div>
   <div style="text-shadow: none;font-size: 10px;">{l s='Me' mod='presmobileapp'}</div>
 </a>
</div>
</div>
</div>