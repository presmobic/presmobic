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
<div class="premobile-checkout-cart" style="padding: 1em;">
	<div class="premobile-checkout-box-steps clearfix">
		<div class="ui-grid-b">
			<div class="ui-block-a">
				<div class="block-step first-step step-active">
					<div class="step-item">
						<div class="around">
							<span class="step-value">1</span>
						</div>
					</div>
					<div class="step-title">
						{l s='ADDRESS' mod='presmobileapp'}
					</div>
				</div>
			</div>
			<div class="ui-block-b">
				<div class="block-step second-step">
					<div class="step-item">
						<div class="around">
							<span class="step-value">2</span>
						</div>
					</div>
					<div class="step-title">
						{l s='SHIPPING' mod='presmobileapp'}
					</div>
				</div>
			</div>
			<div class="ui-block-c">
				<div class="block-step three-step">
					<div class="step-item">
						<div class="around">
							<span class="step-value">3</span>
						</div>
					</div>
					<div class="step-title">
						{l s='PAYMENT' mod='presmobileapp'}
					</div> 
				</div>
			</div>
		</div>
	</div>
</div>
<div class="Presmobile-myaddress">
	<div class="ui-grid-a">
		<h3>{l s='ADDRESS' mod='presmobileapp'}</h3>
		<div class="Presmobile-addnew-address" onclick="PresMobibamobileroutes(this)" ba-link="#checkoutaddress"><i class="fa fa-plus-circle"></i> {l s='Add a new address' mod='presmobileapp'}</div>
		<p class="presmobile-choose-addr presmobile-choose-delivery-addess" onclick="PresMoblieShowAddressSelectPopup('popup-choose-delivery-address')">
			<i class="icon-vector-smart-object"></i>
			{l s='Choose a delivery address' mod='presmobileapp'}
		</p>
		<p class="presmobile-choose-addr presmobile-choose-billing-addess" style="display: none;" onclick="PresMoblieShowAddressSelectPopup('popup-choose-billing-address')">
			<i class="icon-vector-smart-object"></i>
			{l s='Choose a billing address' mod='presmobileapp'}
		</p>
		<div class="Presmobile-myaddress-block-check">
			<input type="checkbox" name="" class="use-billing-choice" onclick="PresMobiCheckdelivery(this)" checked>
			<span class="Presmobile-myaddress-checked">
				<div class="checked"></div> 
			</span>
			<span style="padding-left: 21px;line-height: 20px;display: block;min-height: 20px;">{l s='Use the delivery address as the billing address.' mod='presmobileapp'}</span>
		</div>
	</div>
	<div class="Presmobile-select-popup popup-choose-delivery-address">
		<div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-choose-delivery-address')"></div>
		<div class="Presmobile-select-popup-block">
			<div class="Presmobile-select-popup-header">
				<h4>{l s='Choose a delivery address' mod='presmobileapp'}</h4>
			</div>
			<ul class="Presmobile-select-popup-content">
				{foreach from=$alias key=key item=item}
				<li class="list-delivery-address list-delivery-address-{$key|escape:'htmlall':'UTF-8'} {if $address_delivery[0]['id_address']==$key}addressselected {/if} clearfix" onclick="PresMoblieChangeMyDeliveryAddress(this)" value="{$key|escape:'htmlall':'UTF-8'}">
					<span class="choose-address"></span>{$item|escape:'htmlall':'UTF-8'}
				</li>
				{/foreach}
			</ul>
			<div class="ui-grid-a Presmobile-select-popup-footer">
				<div class="ui-block-a">
					<h4 onclick="PresMoblieHideAddressSelectPopup('popup-choose-delivery-address')">{l s='Close' mod='presmobileapp'}</h4>
				</div>
				<div class="ui-block-b">
					<h4 class="apply-change-delivery-address" onclick="PresMoblieHideAddressSelectPopup('popup-choose-delivery-address')">{l s='Apply' mod='presmobileapp'}</h4>
				</div>
			</div>
		</div>
	</div>
	{if !empty(address_delivery)}
	<div class="ui-grid-a">
		<div class="premobile-detail-head delivery-head clearfix">
			<h4>{l s='Delivery addrress' mod='presmobileapp'}<i class="icon-ello-icon-pent" onclick="PresMobibamobileroutes(this)" ba-link="#checkoutaddress:{$address_delivery[0]['id_address']|escape:'htmlall':'UTF-8'}"></i></h4>
		</div>
		<div class="premobile-detail-content address-content-1 address-content-3">
			<h5 class="fullname-detail">{$address_delivery[0]['lastname']|escape:'htmlall':'UTF-8'} {$address_delivery[0]['firstname']|escape:'htmlall':'UTF-8'}</h5>
			<p class="company-detail">{$address_delivery[0]['company']|escape:'htmlall':'UTF-8'}</p>
			<p class="address-detail">{$address_delivery[0]['address1']|escape:'htmlall':'UTF-8'} {$address_delivery[0]['address2']|escape:'htmlall':'UTF-8'}</p>
			<p class="city-detail">{$address_delivery[0]['city']|escape:'htmlall':'UTF-8'}, {$address_delivery[0]['state']|escape:'htmlall':'UTF-8'} {$address_delivery[0]['postcode']|escape:'htmlall':'UTF-8'}</p>
			<p class="country-detail">{$address_delivery[0]['country']|escape:'htmlall':'UTF-8'}</p>
			<p class="homephone-detail">{$address_delivery[0]['phone']|escape:'htmlall':'UTF-8'}</p>
			<p class="mobile-detail">{$address_delivery[0]['phone_mobile']|escape:'htmlall':'UTF-8'}</p>			
		</div>
	</div>
	{/if}
	<div class="Presmobile-select-popup popup-choose-billing-address">
		<div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-choose-billing-address')"></div>
		<div class="Presmobile-select-popup-block">
			<div class="Presmobile-select-popup-header">
				<h4>{l s='Choose a billing address' mod='presmobileapp'}</h4>
			</div>
			<ul class="Presmobile-select-popup-content">
				{foreach from=$alias key=key item=item}
				<li class="list-billing-address list-billing-address-{$key|escape:'htmlall':'UTF-8'} {if $address_invoice[0]['id_address']==$key}addressselected{/if} clearfix" value="{$key|escape:'htmlall':'UTF-8'}" onclick="PresMoblieChangeMyBillingAddress(this)">
					<span class="choose-address"></span>{$item|escape:'htmlall':'UTF-8'}
				</li>
				{/foreach}
			</ul>
			<div class="ui-grid-a Presmobile-select-popup-footer">
				<div class="ui-block-a">
					<h4 onclick="PresMoblieHideAddressSelectPopup('popup-choose-billing-address')">{l s='Close' mod='presmobileapp'}</h4>
				</div>
				<div class="ui-block-b">
					<h4 class="apply-change-billing-address" onclick="PresMoblieHideAddressSelectPopup('popup-choose-billing-address')">{l s='Apply' mod='presmobileapp'}</h4>
				</div>
			</div>
		</div>
	</div>
	{if !empty(address_invoice)}
	<div class="ui-grid-a" style="border: none;">
		<div class="premobile-detail-head delivery-head clearfix">
			<h4>{l s='Billing addrress' mod='presmobileapp'}<i class="icon-ello-icon-pent" onclick="PresMobibamobileroutes(this)" ba-link="#checkoutaddress:{$address_invoice[0]['id_address']|escape:'htmlall':'UTF-8'}"></i></h4>
		</div>
		<div class="premobile-detail-content address-content-2 address-content-3">
			<h5 class="fullname-detail">{$address_invoice[0]['lastname']|escape:'htmlall':'UTF-8'} {$address_invoice[0]['firstname']|escape:'htmlall':'UTF-8'}</h5>
			<p class="company-detail">{$address_invoice[0]['company']|escape:'htmlall':'UTF-8'}</p>
			<p class="address-detail">{$address_invoice[0]['address1']|escape:'htmlall':'UTF-8'} {$address_invoice[0]['address2']|escape:'htmlall':'UTF-8'}</p>
			<p class="city-detail">{$address_invoice[0]['city']|escape:'htmlall':'UTF-8'}, {$address_invoice[0]['state']} {$address_invoice[0]['postcode']|escape:'htmlall':'UTF-8'}</p>
			<p class="country-detail">{$address_invoice[0]['country']|escape:'htmlall':'UTF-8'}</p>
			<p class="homephone-detail">{$address_invoice[0]['phone']|escape:'htmlall':'UTF-8'}</p>
			<p class="mobile-detail">{$address_invoice[0]['phone_mobile']|escape:'htmlall':'UTF-8'}</p>			
		</div>
	</div>
	{/if}
</div>
<div class="Presmobile-myaddress Presmobile-myaddress-last-block">
	<div class="PresMobilesubmit-myaddress" style="text-align: center;" onclick="PresMobibamobileroutes(this)" ba-link="#checkoutcart">{l s='PROCEED TO CHECKOUT' mod='presmobileapp'}</div>
</div>
