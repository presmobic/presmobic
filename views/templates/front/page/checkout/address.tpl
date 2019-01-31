{*
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
*}
{$presmobicBeforeAddAddress nofilter} {* no escape necessary *}
<div class="PresMobilecheckout-address premobile-checkout-box-top">
	<form method="post" action="" id="stepAddress">
		<h4 class="checkout-address-title delivery-title">{l s='Your delivery address' mod='presmobileapp'}</h4>
		<input type="hidden" name="id_address" value="{$id_address|escape:'htmlall':'UTF-8'}">
		<div class="delivery-address">
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='First name' mod='presmobileapp'} *</label>
				<input  type="text" value="{$delivery[0]['firstname']|escape:'htmlall':'UTF-8'}" name="first_name" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" onkeyup="PresMobileCheckOutAddressCheckFields()">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Last name' mod='presmobileapp'} *</label>
				<input  type="text" value="{$delivery[0]['lastname']|escape:'htmlall':'UTF-8'}" name="last_name" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" onkeyup="PresMobileCheckOutAddressCheckFields()">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Company' mod='presmobileapp'}</label>
				<input  type="text" name="company" value="{$delivery[0]['company']|escape:'htmlall':'UTF-8'}" class="txt-checkout" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Address 1' mod='presmobileapp'} *</label>
				<input  type="text" name="address_1" value="{$delivery[0]['address1']|escape:'htmlall':'UTF-8'}" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" onkeyup="PresMobileCheckOutAddressCheckFields()">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Address 2' mod='presmobileapp'}</label>
				<input  type="text" name="address_2" value="{$delivery[0]['address2']|escape:'htmlall':'UTF-8'}" class="txt-checkout" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" onkeyup="PresMobileCheckOutAddressCheckFields()">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='City' mod='presmobileapp'} *</label>
				<input  type="text" name="city" value="{$delivery[0]['city']|escape:'htmlall':'UTF-8'}" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" onkeyup="PresMobileCheckOutAddressCheckFields()">
			</div>
			<div class="form-group checkout-address-field PresMobilefiled-select">
				<label class="PresMobiletitle PresMobiletitle-none" onclick="PresMoblieCheckOutShow(this)">{l s='Country' mod='presmobileapp'} *</label>
				<input type="text" name="country" class="txt-checkout text-state-2 txt-address txt-delivery-address" onclick="PresMoblieCheckOutShow(this)" readonly="readonly" value="{if isset($localtion['countries'][$delivery[0]['id_country']])}{if isset($localtion['countries'][$delivery[0]['id_country']]['name'])}{$localtion['countries'][$delivery[0]['id_country']]['name']|escape:'htmlall':'UTF-8'}{/if}{else}{if isset($localtion['countries'][$id_country_default]['name'])}{$localtion['countries'][$id_country_default]['name']|escape:'htmlall':'UTF-8'}{/if}{/if}" onkeyup="PresMobileCheckOutAddressCheckFields()">
				<input type="hidden" name="idcountry" class="presmobile-idstate_2" value="{if isset($localtion['countries'][$delivery[0]['id_country']])}
				{if isset($delivery[0]['id_country'])}
				{$delivery[0]['id_country']|escape:'htmlall':'UTF-8'}
				{/if}
				{else}
				{$id_country_default|escape:'htmlall':'UTF-8'}
				{/if}">
				<div class="list-state">
					<div class="state-bg" onclick="PresMobileCheckOutAddressCanel()"></div>
					<div class="state-conditions-block">
						<div class="state-header">
							<h4>{l s='Country' mod='presmobileapp'} *</h4>
						</div>
						<ul class="state-content">
							{if isset($localtion['countries'])}
							{foreach from=$localtion['countries'] key=key item=item}
							<li class="state-checked state-checked-{$key|escape:'htmlall':'UTF-8'}" onclick="PresMobileCheckOutAddressChecked({$key|escape:'htmlall':'UTF-8'},'{$item['name']|escape:'htmlall':'UTF-8'}',2)" val="{$item['name']|escape:'htmlall':'UTF-8'}">{$item['name']|escape:'htmlall':'UTF-8'}
								<div class="checkeds-2"></div>
							</li>
							{/foreach}
							{/if}
						</ul>
						<div class="ui-grid-a state-conditions-footer">
							<div class="ui-block-a">
								<h4 onclick="PresMobileCheckOutAddressCanel()">{l s='Canel' mod='presmobileapp'}</h4>
							</div>
							<div class="ui-block-b">
								<h4 class="getid_2" >{l s='OK' mod='presmobileapp'}</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Zip/ Postal Code' mod='presmobileapp'} *</label>
				<input type="text" name="postal" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" value="{$delivery[0]['postcode']|escape:'htmlall':'UTF-8'}" onkeyup="PresMobileCheckOutAddressCheckFields()">
			</div>
			<div class="form-group checkout-address-field PresMobilefiled-select address-states" style="{if isset($localtion['states'][$delivery[0]['id_country']])}display: none;{/if}">
				<label class="PresMobiletitle PresMobiletitle-none PresMobile-state-title" onclick="PresMoblieCheckOutShow(this)">{l s='State' mod='presmobileapp'} *</label>
				<input type="text" name="delivery_state" class="txt-checkout text-state-1 txt-address" onclick ="PresMoblieCheckOutShow(this)" required="" readonly="readonly" value="{if isset($localtion['states'][$delivery[0]['id_country']][$delivery[0]['id_state']])}
				{if isset($localtion['states'][$delivery[0]['id_country']][$delivery[0]['id_state']]['name'])}
				{$localtion['states'][$delivery[0]['id_country']][$delivery[0]['id_state']]['name']|escape:'htmlall':'UTF-8'}
				{/if}
				{/if}">
				<input type="hidden" name="idsates" class="presmobile-idstate_1 txt-delivery-address" value="{if isset($localtion['states'][$delivery[0]['id_country']][$delivery[0]['id_state']])}
				{if isset($delivery[0]['id_state'])}
				{$delivery[0]['id_state']|escape:'htmlall':'UTF-8'}
				{/if}
				{else}0
				{/if}">
				<div class="list-state">
					<div class="state-bg" onclick="PresMobileCheckOutAddressCanel()"></div>
					<div class="state-conditions-block">
						<div class="state-header">
							<h4>{l s='State' mod='presmobileapp'} *</h4>
						</div>
						<ul class="state-content state-content-1">
							{if isset($localtion['states'][$delivery[0]['id_country']])}
							{foreach from=$localtion['states'][$delivery[0]['id_country']] key=key item=item}
							<li class="state-checked state-checked-{$key|escape:'htmlall':'UTF-8'}" onclick="PresMobileCheckOutAddressChecked({$key|escape:'htmlall':'UTF-8'},'{$item['name']}',1)" val="{$item['name']|escape:'htmlall':'UTF-8'}">{$item['name']|escape:'htmlall':'UTF-8'}
								<div class="checkeds-1"></div>
							</li>
							{/foreach}
							{else}
							{if isset($localtion['states'][$id_country_default])}
							{foreach from=$localtion['states'][$id_country_default] key=key item=item}
							<li  class="state-checked state-checked-{$key|escape:'htmlall':'UTF-8'}" onclick="PresMobileCheckOutAddressChecked({$key|escape:'htmlall':'UTF-8'},'{$item['name']}',1)" val="{$item['name']|escape:'htmlall':'UTF-8'}">{$item['name']|escape:'htmlall':'UTF-8'}
								<div class="checkeds-1"></div>
							</li>
							{/foreach}
							{/if}
							{/if}
						</ul>
						<div class="ui-grid-a state-conditions-footer">
							<div class="ui-block-a">
								<h4 onclick="PresMobileCheckOutAddressCanel()">{l s='Canel' mod='presmobileapp'}</h4>
							</div>
							<div class="ui-block-b" onclick="PresMobileCheckOutAddressCheckFields()">
								<h4 class="getid_1">{l s='OK' mod='presmobileapp'}</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Home phone' mod='presmobileapp'} *</label>
				<input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="homephone" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" onkeyup="PresMobileCheckOutAddressCheckFields()" value="{$delivery[0]['phone']|escape:'htmlall':'UTF-8'}">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Mobile phone' mod='presmobileapp'} *</label>
				<input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="mobilephone" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" onkeyup="PresMobileCheckOutAddressCheckFields()" value="{$delivery[0]['phone_mobile']|escape:'htmlall':'UTF-8'}">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Additional information' mod='presmobileapp'}</label>
				<input type="text" name="additional-info" class="txt-checkout txt-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" value="">
			</div>
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Alias' mod='presmobileapp'} *</label>
				<input type="text" name="alias" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" value="{$delivery[0]['alias']|escape:'htmlall':'UTF-8'}" onkeyup="PresMobileCheckOutAddressCheckFields()" required="">
			</div>
			{if $id_customer == '0'}
			<div class="form-group checkout-address-field">
				<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Email' mod='presmobileapp'} *</label>
				<input type="text" name="email" class="txt-checkout txt-address txt-delivery-address email-delivery" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" value="" onkeyup="PresMobileCheckOutAddressCheckFields()" required="">
			</div>
			{/if}
		</div>
		<div class="PresMobilesubmit-address disabledbutton" onclick="PresMobistepAddress()">{l s='Save' mod='presmobileapp'}</div>
	</form>
</div>
{$presmobicAfterAddAddress nofilter} {* no escape necessary *}