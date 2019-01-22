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
<div data-role="header " class="ui-grid-b header-account">
  <div class="ui-block-a" style="width: 13%;"> 
    <span class="" style="color:#fff;font-size: 13px;float: left;margin:15px 11px;" onclick="goBack()">
      <i class="icon-iconarrowleft"></i>
    </span>
  </div>
  {if $cart['logged'] !='1'}
  <div class="ui-block-b" style="width: 74%;text-align: center;padding-top: 10px;" onclick="PreMobisetCookie('control','#account'),PresMobibamobileroutes(this)" ba-link="#login"> 
    <span class="ion-md-icon-account avata-account"></span>
    <h3 style="color: #ffffff;text-shadow: none;font-size: 14px;">{l s='LOGIN' mod='presmobileapp'}</h3>
  </div>
  <div class="ui-block-c" style="font-size: 20px;width: 13%;margin: 8px 0px;"> 
  </div>
  {/if}
  {if $cart['logged']}
  <div class="ui-block-b" style="width: 74%;text-align: center;padding-top: 10px;">
    <span class="ion-md-icon-account avata-account" onclick="PresMobibamobileroutes(this)" ba-link="#profile"></span>
    <div class="td_name_customer" onclick="PresMobibamobileroutes(this)" ba-link="#profile">
      <h3 style="color: #fff;margin: -19px 6px;text-shadow: none;font-size: 14px;float: left;">
        {$cart['customerName']|escape:'htmlall':'UTF-8'}
      </h3>
      <span style="border-bottom: 1px solid #fff; cursor: pointer; float: left;color: #fff;top: 0;font-size: 12px;text-shadow: none;">
        <i class="fa fa-pencil"></i>   
      </span>
    </div>
    <h6 style="color: #968787;margin: 4px 0;text-shadow: none;font-size: 14px;float: left;width: 100%;">
      {$cart['email']|escape:'htmlall':'UTF-8'}
    </h6>
  </div>
  <div class="ui-block-c" style="text-align: right;padding-right: 1em;font-size: 13px;width: 13%;margin: 8px 0px;" onclick="PreMobiLogout()"> 
    <span class="ion-ios-icon-logout" style="font-size: 30px;color: #fff;text-shadow: none;line-height: 1.3;"></span>
  </div>
  {/if}
</div>
<!--end header-->
<div role="main" class="ui-content account-pages" style="background: white;padding: 0;">
  {if $cart['logged']}
  {$presmobic_beforeaccountSetting nofilter} {* no escape necessary *}
  <div class="my-account-group-title">
    {l s='My account' mod='presmobileapp'}
  </div>
  <div class="ui-grid-a account-items-noboder" onclick="PresMobibamobileroutes(this)" ba-link="#order">
    <div class="ui-block-a">
      <span class="ion-ios-icon-order-list"></span>
      <span>{l s='My Order' mod='presmobileapp'}</span>
    </div>
    <div class="ui-block-b">
      <p>{$cart['order']|escape:'htmlall':'UTF-8'}</p>
    </div>
  </div>
  <div class="ui-grid-a">
    <div class="ui-block-a" onclick="PresMobibamobileroutes(this)" ba-link="#favorite">
      <span class="icon-ello-favorite"></span>
      <span>{l s='My favorite product' mod='presmobileapp'}</span>
    </div>
    <div class="ui-block-b">
      <p>{$cart['count_favorite']|escape:'htmlall':'UTF-8'}</p>
    </div>
  </div>
  <div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#wishlist">
    <div class="ui-block-a">
      <span class="icon-my-wishlist"></span>
      <span>{l s='My Wishlist' mod='presmobileapp'}</span>
    </div>
    <div class="ui-block-b">
      <p>{$cart['count_wis']|escape:'htmlall':'UTF-8'}</p>
    </div>
  </div>
  <div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#merchandisereturns">
    <div class="ui-block-a">
      <span class="icon-ello-merchandise-returns"></span>
      <span>{l s='My merchandise returns' mod='presmobileapp'}</span>
    </div>
    <div class="ui-block-b">
      <p>
        {$cart['count_merchandise']|escape:'htmlall':'UTF-8'}
      </p>
    </div>
  </div>
  <div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#creditslips">
    <div class="ui-block-a">
      <span class="icon-mycredit-slip"></span>
      <span>{l s='My Credit Slips' mod='presmobileapp'}</span>
    </div>
    <div class="ui-block-b">
      <p>
        {$cart['count_creadit']|escape:'htmlall':'UTF-8'}
      </p>
    </div>
  </div>
  <div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#myaddressbycustomer">
    <div class="ui-block-a">
      <span class="icon-ello-my-address"></span>
      <span>{l s='My Address' mod='presmobileapp'}</span>
    </div>
    <div class="ui-block-b">
      <p>
        {$cart['count_address']|escape:'htmlall':'UTF-8'}
      </p>
    </div>
  </div>
  <div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#myvouchers">
    <div class="ui-block-a">
      <span class="icon-ello-vouchers"></span>
      <span>{l s='My Vouchers' mod='presmobileapp'}</span>
    </div>
    <div class="ui-block-b">
      <p>
        {$cart['count_voucher']|escape:'htmlall':'UTF-8'}
      </p>
    </div>
  </div>
  {$presmobic_afteraccountSetting nofilter} {* no escape necessary *}
  <div class="ui-grid-a">
    {$hook_displayCustomerAccount nofilter} {* no escape necessary *}
  </div>
  {/if}
  <div class="my-account-group-title">
    {l s='Setting app' mod='presmobileapp'}
  </div>
  <div class="ui-grid-a">
    <div class="ui-block-a" style="width:50%;" onclick="PresMoblieShowAddressSelectPopup('popup-choose-currency')">
      <span class="icon-ello-currency"></span>
      <span>{l s='Currency' mod='presmobileapp'}</span>
    </div>
    <div class="ui-block-b" style="width:50%;" onclick="PresMoblieShowAddressSelectPopup('popup-choose-currency')">
      <p>{$code_currencydefault|escape:'htmlall':'UTF-8'}</p>
    </div>
    <div class="Presmobile-select-popup popup-choose-currency">
      <div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-choose-currency')"></div>
      <div class="Presmobile-select-popup-block">
        <div class="Presmobile-select-popup-header">
          <h4> {l s='Choose Currency' mod='presmobileapp'}</h4>
        </div>
        <ul class="Presmobile-select-popup-content">
          {foreach from=$currency key=key item=item}
          <li class="list-currency list-currency-{$item['id_currency']|escape:'htmlall':'UTF-8'}
          {if $item['id_currency'] == $currencydefault} currencyselected {/if} clearfix" onclick="PresMoblieChangeCurrency(this)" value="{$item['id_currency']|escape:'htmlall':'UTF-8'}">{$item['name']|escape:'htmlall':'UTF-8'} ({$item['iso_code']|escape:'htmlall':'UTF-8'})
          <span class="choose-address"></span>
        </li>
        {/foreach}
      </ul>
      <div class="ui-grid-a Presmobile-select-popup-footer">
        <div class="ui-block-a" style="width:50%;margin:0;">
          <h4 onclick="PresMoblieHideAddressSelectPopup('popup-choose-currency')">{l s='Close' mod='presmobileapp'}</h4>
        </div>
        <div class="ui-block-b" style="width:50%;margin:0;">
          <h4 class="apply-choose-currency" data-currency="" onclick="PresMoblieCurrency()">{l s='Done' mod='presmobileapp'}</h4>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="ui-grid-a">
  <div class="ui-block-a" style="width:50%;" onclick="PresMoblieShowAddressSelectPopup('popup-choose-language')">
    <span class="icon-ello-language"></span>
    <span>{l s='Language' mod='presmobileapp'}</span>
  </div>
  <div class="ui-block-b" style="width:50%;" onclick="PresMoblieShowAddressSelectPopup('popup-choose-language')">
    <p>{$name_language_default|escape:'htmlall':'UTF-8'}</p>
  </div>
  <div class="Presmobile-select-popup popup-choose-language">
    <div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-choose-language')"></div>
    <div class="Presmobile-select-popup-block">
      <div class="Presmobile-select-popup-header">
        <h4>{l s='Choose Language' mod='presmobileapp'}</h4>
      </div>
      <ul class="Presmobile-select-popup-content">
        {foreach from=$language key=key item=item}
        <li class="list-language list-language-{$item['id_lang']|escape:'htmlall':'UTF-8'} {if $item['id_lang']==$languagedefault} languageselected {/if} clearfix" onclick="PresMoblieChangeLanguage(this)" value="{$item['id_lang']|escape:'htmlall':'UTF-8'}">{$item['name']|escape:'htmlall':'UTF-8'}
          <span class="choose-address"></span>
        </li>
        {/foreach}
      </ul>
      <div class="ui-grid-a Presmobile-select-popup-footer">
        <div class="ui-block-a" style="width:50%;margin:0;">
          <h4 onclick="PresMoblieHideAddressSelectPopup('popup-choose-language')"> {l s='Close' mod='presmobileapp'}</h4>
        </div>
        <div class="ui-block-b" style="width:50%;margin:0;">
          <h4 class="apply-choose-language" data-language="" onclick="PresMoblieHideAddressSelectPopup('popup-choose-language'),PresMobileUpdateLanguage()"> {l s='Done' mod='presmobileapp'}</h4>
        </div>
      </div>
    </div>
  </div>
</div>
{$presmobic_beforeaccountInfomartion nofilter} {* no escape necessary *}
<div class="my-account-group-title">
  {l s='Information' mod='presmobileapp'}
</div>
<div class="ui-grid-a account-items-noboder" onclick="PresMobibamobileroutes(this)" ba-link="#contact">
  <div class="ui-block-a">
    <span class="icon-ello-contact"></span>
    <span>{l s='Contact us' mod='presmobileapp'}</span>
  </div>
</div>
<div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#about">
  <div class="ui-block-a">
    <span class="icon-ello-about"></span>
    <span>{l s='About Us' mod='presmobileapp'}</span>
  </div>
</div>
<div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#privacypolicy">
  <div class="ui-block-a">
    <span class="ion-ios-icon-list-lock"></span>
    <span>{l s='Privacy policy' mod='presmobileapp'}</span>
  </div>
</div>
<div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#termsofuse">
  <div class="ui-block-a">
    <span class="ion-md-icon-list" ></span>
    <span>{l s='Terms of Use' mod='presmobileapp'}</span>
  </div>
</div>
{$presmobic_afteraccountInfomartion nofilter} {* no escape necessary *}
</div>
  <!--clear div-->