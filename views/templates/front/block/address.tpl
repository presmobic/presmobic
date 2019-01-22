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
<div class="PresMobilecheckout-address premobile-checkout-box-top">
	<form method="post" action="" id="stepAddress">
		<input type="hidden" name="id_address" value="{$id_address|escape:'htmlall':'UTF-8'}">
		<div class="delivery-address">
			<h4> {l s='YOUR DELIVERY ADDRESS' mod='presmobileapp'}</h4>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='First name *' mod='presmobileapp'}</label>
				<input  type="text" value="{$delivery[0]['firstname']|escape:'htmlall':'UTF-8'}" name="first_name" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" onkeyup="PresMobileCheckOutAddressCheckFields()">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Last name *' mod='presmobileapp'}</label>
				<input  type="text" value="{$delivery[0]['lastname']|escape:'htmlall':'UTF-8'}" name="last_name" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" onkeyup="PresMobileCheckOutAddressCheckFields()">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Company' mod='presmobileapp'}</label>
				<input  type="text" name="company" value="{$delivery[0]['company']|escape:'htmlall':'UTF-8'}" class="txt-checkout" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Address 1 *' mod='presmobileapp'}</label>
				<input  type="text" name="address_1" value="{$delivery[0]['address1']|escape:'htmlall':'UTF-8'}" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" onkeyup="PresMobileCheckOutAddressCheckFields()">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Address 2' mod='presmobileapp'}</label>
				<input  type="text" name="address_2" value="{$delivery[0]['address2']|escape:'htmlall':'UTF-8'}" class="txt-checkout" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" onkeyup="PresMobileCheckOutAddressCheckFields()">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='City *' mod='presmobileapp'}</label>
				<input  type="text" name="city" value="{$delivery[0]['city']|escape:'htmlall':'UTF-8'}" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" onkeyup="PresMobileCheckOutAddressCheckFields()">
			</div>
			<div class="form-group checkout-address-field PresMobilefiled-select">
				<label class="PresMobiletitle PresMobiletitle-none PresMobiletitle-select" onclick="PresMoblieCheckOutShow(this)"> {l s='Country *' mod='presmobileapp'}</label>
				<select onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" name="idcountry" onclick="PresMoblieCheckOutShow(this)" onchange="PresMobiChangeCountry(this)">
					{if !empty($localtion['countries'])}
					{foreach from=$localtion['countries'] key=key item=item}
					<option value="{$key|escape:'htmlall':'UTF-8'}" {if $id_country_default == $key}selected{/if}>{$item['name']|escape:'htmlall':'UTF-8'}</option>
					{/foreach}
					{/if}
				</select>
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Zip/ Postal Code *' mod='presmobileapp'}</label>
				<input type="text" name="postal" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" value="{$delivery[0]['postcode']|escape:'htmlall':'UTF-8'}" onkeyup="PresMobileCheckOutAddressCheckFields()">
			</div>
			<div class="form-group checkout-address-field PresMobilefiled-select address-states" style="{if empty($localtion['states'][$id_country_default])}display: none;{/if}">
				<label class="PresMobiletitle PresMobiletitle-none PresMobile-state-title PresMobiletitle-select" onclick="PresMoblieCheckOutShow(this)">{l s='State *' mod='presmobileapp'}</label>
				<select name="idsates" class="step_state">
					{if !empty($localtion['states'][$id_country_default])}
					{foreach from=$localtion['states'][$id_country_default] key=key item=item}
					<option value="{$key|escape:'htmlall':'UTF-8'}">{$item['name']|escape:'htmlall':'UTF-8'}</option>
					{/foreach}
					{/if}
				</select>
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Home phone *' mod='presmobileapp'}</label>
				<input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="homephone" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" onkeyup="PresMobileCheckOutAddressCheckFields()" value="{$delivery[0]['phone']|escape:'htmlall':'UTF-8'}">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)"> {l s='Mobile phone *' mod='presmobileapp'}</label>
				<input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="mobilephone" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" onkeyup="PresMobileCheckOutAddressCheckFields()" value="{$delivery[0]['phone_mobile']|escape:'htmlall':'UTF-8'}">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Additional information' mod='presmobileapp'}</label>
				<input type="text" name="additional-info" class="txt-checkout txt-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" value="">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)"> {l s='Alias *' mod='presmobileapp'}</label>
				<input type="text" name="alias" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" value="{$delivery[0]['alias']|escape:'htmlall':'UTF-8'}" onkeyup="PresMobileCheckOutAddressCheckFields()" required="">
			</div>
		</div>
	</form>
</div>