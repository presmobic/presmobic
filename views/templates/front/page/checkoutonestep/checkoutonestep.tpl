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
<div class="payment_detial" style="display: none;">
</div>
<div class="other_payment" onclick="PresMobidisplayPayment()" style="display: none;">
	<p>{l s='Other Payment' mod='presmobileapp'}</p>
</div>
<div class="presmobile-payment-block-second">
	<div class="premobile-checkout-cart premobile-checkout-order">
		<div class="premobile-checkout-box-top clearfix"  onclick="PresMobileCheckoutCartShowContent(this)">
			<div class="ion-ios-icon-order-list box-title">{l s='Order(s) Detail' mod='presmobileapp'}</div>
			<div class="chekout-angle chekout-angle-order-detail">
				<span>{$cart[0]['count_product']|escape:'htmlall':'UTF-8'} item{if $cart[0]['count_product'] !='1'}(s){/if}</span>
				<i class="fa fa-angle-up"></i>
				<i class="fa fa-angle-down"></i>
			</div>
		</div>
		<div class="premobile-checkout-cart-detail prmobile-shipping-detail">
			<div class="premobile-detail-content">
				<ul>
					{foreach from=$cart[0]['product'] key=key3 item=item3}
					<li class="premobile-orders-detail clearfix" onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item3['id_product']|escape:'htmlall':'UTF-8'}">
						<div class="order-item-image">
							{if !empty($item3['specific_prices'])}
							{if $item3['specific_prices']['reduction_type'] == 'percentage'}
							<div class="order-item-sale">
								-{$item3['specific_prices']['reduction']|escape:'htmlall':'UTF-8'*100}%
							</div>
							{/if}
							{/if}
							<img src="{$item3['link_img']|escape:'htmlall':'UTF-8'}" alt="">
						</div>
						<div class="order-item-meta">
							<h5>
								{$item3['name']|escape:'htmlall':'UTF-8'}
							</h5>
							{if isset($item3['attributes'])}
							<div class="color-size">
								{$item3['attributes']|escape:'htmlall':'UTF-8'}
							</div>
							{/if}
							<div class="price">
								{if $item3['price_wt'] != $item3['total']}
								<span class="sale">{$item3['price_discount']|escape:'htmlall':'UTF-8'}</span>
								{/if}
								<span class="total">{$item3['price_total']|escape:'htmlall':'UTF-8'} x{$item3['cart_quantity']|escape:'htmlall':'UTF-8'}</span>
							</div>
						</div>
					</li>
					{/foreach}
				</ul>
			</div>
		</div>
	</div>
	<div class="premobile-checkout-cart">
		<div class="premobile-detail-content" style="padding-bottom: 0;">
			<div class="total-detail">
				<ul>
					<li class="clearfix">
						<span class="title">{l s='Sub Total: ' mod='presmobileapp'}</span>
						<span class="value total_product_r">{$cart[0]['price_product']|escape:'htmlall':'UTF-8'}</span>
					</li>
					<li class="clearfix">
						<span class="title"> {l s='Tax Products:' mod='presmobileapp'}</span>
						<span class="value" id="total_tax_r">{$cart[0]['price_tax']|escape:'htmlall':'UTF-8'}</span>
					</li>
					<li class="clearfix" style="border-top-style: solid;">
						<span class="title">{l s='Total Products: ' mod='presmobileapp'}</span>
						<span class="value total_price_r" id="order_total_r">{$cart[0]['totalprice']|escape:'htmlall':'UTF-8'}</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="premobile-checkout-cart">
		<div class="premobile-checkout-box-top clearfix"  onclick="PresMobileCheckoutCartShowContent(this)">
			<div class="box-title checkoutonestep-title">
				<div class="around"><span>1</span></div>
				{l s='Address' mod='presmobileapp'}
			</div>
			<div class="chekout-angle">
				<i class="fa fa-angle-up"></i>
				<i class="fa fa-angle-down"></i>
			</div>
		</div>
		<div class="premobile-detail-content">
			<div class="Presmobile-myaddress">
				<div class="ui-grid-a">
					<div class="Presmobile-addnew-address" onclick="PresMoblieShowAddressSelectPopup('popup-choose-add-address')"><i class="fa fa-plus-circle"></i> Add a new address</div>
					{if $cart_r['id_customer'] != '0'}
					{if $check_address == 1}
					<p class="presmobile-choose-addr presmobile-choose-delivery-addess" onclick="PresMoblieShowAddressSelectPopup('popup-choose-delivery-address')">
						<i class="icon-vector-smart-object"></i>
						{l s='Choose a delivery address' mod='presmobileapp'}
					</p>
					{/if}
					{if !empty($addresses)}
					<p class="presmobile-choose-addr presmobile-choose-billing-addess" style="display: none;" onclick="PresMoblieShowAddressSelectPopup('popup-choose-billing-address')">
						<i class="icon-vector-smart-object"></i>
						{l s='Choose a billing address' mod='presmobileapp'}
					</p>
					<div class="Presmobile-myaddress-block-check">
						{if $check_address == 1}
						<input type="checkbox" name="" class="use-billing-choice" onclick="PresMobiCheckdelivery(this)" checked>
						<span class="Presmobile-myaddress-checked">
							<div class="checked"></div> 
						</span>
						<span style="padding-left: 25px;line-height: 20px;display: block;min-height: 20px;"> {l s='Use the delivery address as the billing address.' mod='presmobileapp'}</span>
						{/if}
					</div>
					{/if}
					{/if}
				</div>
				<div class="Presmobile-select-popup popup-choose-edit-address">
					<div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-choose-edit-address')"></div>
					<div class="Presmobile-select-popup-block">
						<div class="Presmobile-select-popup-header">
							<h4> {l s='Edit Address' mod='presmobileapp'}</h4>
						</div>
						<ul class="Presmobile-select-popup-content edit-address-pres">
						</ul>
						<div class="ui-grid-a Presmobile-select-popup-footer">
							<div class="ui-block-a">
								<h4 onclick="PresMoblieHideAddressSelectPopup('popup-choose-edit-address')">{l s='Cancel' mod='presmobileapp'}</h4>
							</div>
							<div class="ui-block-b">
								<h4 class="apply-change-billing-address" onclick="PresMoblieHideAddressSelectPopup('popup-choose-edit-address'),PreMobisetCookie('control','#checkoutonestep'),PresMobistepAddress()"> {l s='Update' mod='presmobileapp'}</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="Presmobile-select-popup popup-choose-add-address">
					<div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-choose-add-address')"></div>
					<div class="Presmobile-select-popup-block" style="margin-top: -40px;">
						<div class="Presmobile-select-popup-header">
							<h4>{l s='New Address' mod='presmobileapp'}</h4>
						</div>
						<div class="Presmobile-select-popup-content">
							<div class="PresMobilecheckout-address premobile-checkout-box-top">
								<form method="post" action="" id="stepAddress">
									<input type="hidden" name="id_address" value="{$id_address|escape:'htmlall':'UTF-8'}">
									<div class="delivery-address">
										<h4>{l s='YOUR DELIVERY ADDRESS' mod='presmobileapp'}</h4>
										<div class="form-group checkout-address-field">
											<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='First name *' mod='presmobileapp'}
											</label>
											<input  type="text" value="{$delivery[0]['firstname']|escape:'htmlall':'UTF-8'}" name="first_name" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" onkeyup="PresMobileCheckOutAddressCheckFields()">
										</div>
										<div class="form-group checkout-address-field">
											<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">
											{l s='Last name *' mod='presmobileapp'}</label>
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
											<label class="PresMobiletitle PresMobiletitle-none PresMobiletitle-select" onclick="PresMoblieCheckOutShow(this)">{l s='Country *' mod='presmobileapp'}</label>
											<select onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)"  name="idcountry" onchange="PresMobiChangeCountry(this)">
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
											<select onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" name="idsates" class="step_state">
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
										<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Mobile phone *' mod='presmobileapp'}</label>
										<input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="mobilephone" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" onkeyup="PresMobileCheckOutAddressCheckFields()" value="{$delivery[0]['phone_mobile']|escape:'htmlall':'UTF-8'}">
									</div>
									<div class="form-group checkout-address-field">
										<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Additional information' mod='presmobileapp'}</label>
										<input type="text" name="additional-info" class="txt-checkout txt-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" value="">
									</div>
									<div class="form-group checkout-address-field">
										<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Alias *' mod='presmobileapp'}</label>
										<input type="text" name="alias" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" value="{$delivery[0]['alias']|escape:'htmlall':'UTF-8'}" onkeyup="PresMobileCheckOutAddressCheckFields()" required="">
									</div>
									{if $cart_r['id_customer'] == '0'}
									<div class="form-group checkout-address-field">
										<label class="PresMobiletitle" onclick="PresMobileClickToAddressFieldTitle(this)">{l s='Email *' mod='presmobileapp'}</label>
										<input type="text" name="email" class="txt-checkout txt-address txt-delivery-address" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" value="" onkeyup="PresMobileCheckOutAddressCheckFields()" required="">
									</div>
									{/if}
									<div class="checkout-address-field">
										<p>
											{l s='Please assign an address title for future reference.' mod='presmobileapp'}
										</p>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="ui-grid-a Presmobile-select-popup-footer">
						<div class="ui-block-a">
							<h4 onclick="PresMoblieHideAddressSelectPopup('popup-choose-add-address')">{l s='Cancel' mod='presmobileapp'}</h4>
						</div>
						<div class="ui-block-b">
							<h4 class="apply-change-billing-address" onclick="PresMoblieHideAddressSelectPopup('popup-choose-add-address'),PreMobisetCookie('control','#checkoutonestep'),PresMobistepAddress()"> {l s='Save' mod='presmobileapp'}</h4>
						</div>
					</div>
				</div>
			</div>
			{if !empty($addresses)}
			<div class="Presmobile-select-popup popup-choose-delivery-address">
				<div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-choose-delivery-address')"></div>
				<div class="Presmobile-select-popup-block">
					<div class="Presmobile-select-popup-header">
						<h4> {l s='Choose a delivery address' mod='presmobileapp'}</h4>
					</div>
					<ul class="Presmobile-select-popup-content">
						{foreach from=$addresses[0]['alias'] key=key item=item}
						<li class="list-delivery-address list-delivery-address-{$key|escape:'htmlall':'UTF-8'} {if $addresses[0]['address_delivery'][0]['id_address']==$key}addressselected {/if} clearfix" onclick="PresMoblieChangeMyDeliveryAddress(this)" value="{$key|escape:'htmlall':'UTF-8'}">
							<span class="choose-address"></span>{$item|escape:'htmlall':'UTF-8'}
						</li>
						{/foreach}
					</ul>
					<div class="ui-grid-a Presmobile-select-popup-footer">
						<div class="ui-block-a">
							<h4 onclick="PresMoblieHideAddressSelectPopup('popup-choose-delivery-address')"> {l s='Close' mod='presmobileapp'}</h4>
						</div>
						<div class="ui-block-b">
							<h4 class="apply-change-delivery-address" onclick="PresMoblieHideAddressSelectPopup('popup-choose-delivery-address')">{l s='Update' mod='presmobileapp'}</h4>
						</div>
					</div>
				</div>
			</div>
			{if $cart_r['id_customer'] != '0'}
			{if $check_address == 1}
			<div class="ui-grid-a">
				<div class="premobile-detail-head delivery-head clearfix">
					<h4> {l s='Delivery addrress' mod='presmobileapp'}<i class="icon-ello-icon-pent icon-edit-address-3 icon-edit-address-1" onclick="PresMobiRenderAddressHtml({$addresses[0]['address_delivery'][0]['id_address']|escape:'htmlall':'UTF-8'})"></i></h4>
				</div>
				<div class="address-content-1 address-content-3">
					<h5 class="fullname-detail">{$addresses[0]['address_delivery'][0]['lastname']|escape:'htmlall':'UTF-8'} {$addresses[0]['address_delivery'][0]['firstname']|escape:'htmlall':'UTF-8'}</h5>
					<p class="company-detail">{$addresses[0]['address_delivery'][0]['company']|escape:'htmlall':'UTF-8'}</p>
					<p class="address-detail">{$addresses[0]['address_delivery'][0]['address1']|escape:'htmlall':'UTF-8'} {$addresses[0]['address_delivery'][0]['address2']|escape:'htmlall':'UTF-8'}</p>
					<p class="city-detail">{$addresses[0]['address_delivery'][0]['city']|escape:'htmlall':'UTF-8'}, {$addresses[0]['address_delivery'][0]['state']|escape:'htmlall':'UTF-8'} {$addresses[0]['address_delivery'][0]['postcode']|escape:'htmlall':'UTF-8'}</p>
					<p class="country-detail">{$addresses[0]['address_delivery'][0]['country']|escape:'htmlall':'UTF-8'}</p>
					<p class="homephone-detail">{$addresses[0]['address_delivery'][0]['phone']|escape:'htmlall':'UTF-8'}</p>
					<p class="mobile-detail">{$addresses[0]['address_delivery'][0]['phone_mobile']|escape:'htmlall':'UTF-8'}</p>			
				</div>
			</div>
			{/if}
			<div class="Presmobile-select-popup popup-choose-billing-address">
				<div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-choose-billing-address')"></div>
				<div class="Presmobile-select-popup-block">
					<div class="Presmobile-select-popup-header">
						<h4> {l s='Choose a billing address' mod='presmobileapp'}</h4>
					</div>
					<ul class="Presmobile-select-popup-content">
						{foreach from=$addresses[0]['alias'] key=key item=item}
						<li class="list-billing-address list-billing-address-{$key|escape:'htmlall':'UTF-8'} {if $addresses[0]['address_invoice'][0]['id_address']==$key}addressselected{/if} clearfix" value="{$key|escape:'htmlall':'UTF-8'}" onclick="PresMoblieChangeMyBillingAddress(this)">
							<span class="choose-address"></span>{$item|escape:'htmlall':'UTF-8'}
						</li>
						{/foreach}
					</ul>
					<div class="ui-grid-a Presmobile-select-popup-footer">
						<div class="ui-block-a">
							<h4 onclick="PresMoblieHideAddressSelectPopup('popup-choose-billing-address')"> {l s='Close' mod='presmobileapp'}</h4>
						</div>
						<div class="ui-block-b">
							<h4 class="apply-change-billing-address" onclick="PresMoblieHideAddressSelectPopup('popup-choose-billing-address')"> {l s='Apply' mod='presmobileapp'}</h4>
						</div>
					</div>
				</div>
			</div>
			{if $check_address == 1}
			<div class="ui-grid-a" style="border: none;">
				<div class="premobile-detail-head delivery-head clearfix">
					<h4> {l s='Billing addrress' mod='presmobileapp'}<i class="icon-ello-icon-pent icon-edit-address-3 icon-edit-address-2"  onclick="PresMobiRenderAddressHtml({$addresses[0]['address_invoice'][0]['id_address']|escape:'htmlall':'UTF-8'})"></i></h4>
				</div>
				<div class="address-content-2 address-content-3">
					<h5 class="fullname-detail">{$addresses[0]['address_invoice'][0]['lastname']|escape:'htmlall':'UTF-8'} {$addresses[0]['address_invoice'][0]['firstname']|escape:'htmlall':'UTF-8'}</h5>
					<p class="company-detail">{$addresses[0]['address_invoice'][0]['company']|escape:'htmlall':'UTF-8'}</p>
					<p class="address-detail">{$addresses[0]['address_invoice'][0]['address1']|escape:'htmlall':'UTF-8'} {$addresses[0]['address_invoice'][0]['address2']|escape:'htmlall':'UTF-8'}</p>
					<p class="city-detail">{$addresses[0]['address_invoice'][0]['city']|escape:'htmlall':'UTF-8'}, {$addresses[0]['address_invoice'][0]['state']|escape:'htmlall':'UTF-8'} {$addresses[0]['address_invoice'][0]['postcode']|escape:'htmlall':'UTF-8'}</p>
					<p class="country-detail">{$addresses[0]['address_invoice'][0]['country']|escape:'htmlall':'UTF-8'}</p>
					<p class="homephone-detail">{$addresses[0]['address_invoice'][0]['phone']|escape:'htmlall':'UTF-8'}</p>
					<p class="mobile-detail">{$addresses[0]['address_invoice'][0]['phone_mobile']|escape:'htmlall':'UTF-8'}</p>			
				</div>
			</div>
			{/if}
			{/if}
		</div>
	</div>
</div>
{if $cart_r['id_customer'] != '0'}
<div class="premobile-checkout-cart">
	<div class="premobile-checkout-box-top clearfix"  onclick="PresMobileCheckoutCartShowContent(this)">
		<div class="box-shipping-title box-title checkoutonestep-title">
			<div class="around"><span>2</span></div>
			{l s='Shipping Method' mod='presmobileapp'}
		</div>
		<div class="chekout-angle">
			<i class="fa fa-angle-up"></i>
			<i class="fa fa-angle-down"></i>
		</div>
	</div>
	<div class="premobile-checkout-cart-detail prmobile-shipping-detail">
		<div class="premobile-detail-content">
			<ul class="premobile-list-shipping-method">
				{$i = 0}
				{$a = 0}
				{$value_shipping = 0}
				{$id_carrie = 0}
				{foreach from=$shipping key=key item=item}
				{if $i == '0'}{$value_shipping = $item['total_price_r']}{/if}
				<li class="shipping shipping-{$i++|escape:'htmlall':'UTF-8'}" data-shipping-method='{$key|escape:'htmlall':'UTF-8'}' onclick="PreMobileCheckoutCartCheckedShippingMethod({$a++|escape:'htmlall':'UTF-8'},this)">
					<div class="premobile-shipping-method {if $id_carrier == $key}method-check{/if}">
						<p  class="prmobile-shipping-title">{$item['carrier_name']|escape:'htmlall':'UTF-8'}</p>
						{if $item['is_free'] == 0}
							<p  class="prmobile-shipping-price">
								<span>{$item['total_price_r']|escape:'htmlall':'UTF-8'}</span>
								(tax excl.)
							</p>
						{/if}
						{$id_carrie = $key}
						<div class="primobile-shipping"></div>
					</div>
				</li>
				{/foreach}
			</ul>
			{if $checkterm ==1}
			<div class="terms-conditions" accept-term-data='false'>
				<div class="accept-terms" onclick="PreMobileCheckoutCartTermsCondition()">
					<div class="checkbox-inner"></div>
				</div>
				<div class="terms-conditions-link">
					<span onclick="PreMobileCheckoutCartTermsCondition()"> {l s='I agree to the terms of service and will adhere to them unconditionally.' mod='presmobileapp'}</span> 
					<span onclick="PreMobileCheckoutCartShowTermsBlock()">{l s='(Read the Terms of Service)' mod='presmobileapp'}</span>
				</div>
			</div>
			{/if}
			<div class="terms-conditions-popup">
				<div class="terms-bg" onclick="PreMobileCheckoutCartCloseTermsBlock()"></div>
				<div class="terms-conditions-block">
					<div class="tearms-conditions-header">
						<h4> {l s='Terms & Conditions' mod='presmobileapp'}</h4>
					</div>
					<div class="tearm-conditions-content">
						{l s="Permission is granted to temporarily download one copy of the materials (information or software) on our web site for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
						modify or copy the materials;
						the materials for any commercial purpose, or for any public display (commercial or non-commercial)
						empt to decompile or reverse engineer any software contained on Feedy’s web site;
						move any copyright or other proprietary notations from the materials; or<
						nsfer the materials to another person or “mirror” the materials on any other serve
						his license shall automatically terminate if you violate any of these restrictions and may be terminated by us at any time. Upon terminating your viewing of these materials or upon the termination of this license, you must destroy any downloaded materials in your possession whether in electronic or printed form
						sclai or implied, and hereby disclaims and negates all other warranties, including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights. Further, We does not warrant or make any representations concerning the accuracy, likely results, or reliability of the use of the materials on its Internet web site or otherwise relating to such materials or on any sites linked to this site
						itations" d='presmobileapp'}
					</div>
					<div class="ui-grid-a tearm-conditions-footer">
						<div class="ui-block-a">
							<h4 onclick="PreMobileCheckoutCartCloseTermsBlock()"> {l s='Close' mod='presmobileapp'}</h4>
						</div>
						<div class="ui-block-b">
							<h4 onclick="PreMobileCheckoutCartAcceptButton()"> {l s='Accept' mod='presmobileapp'}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="abcs" value="{$id_carrie|escape:'htmlall':'UTF-8'}" class="id_carrier">
</div>
<div class="premobile-checkout-cart" style="margin-bottom:10px;">
	<div class="premobile-checkout-box-top clearfix"  onclick="PresMobileCheckoutCartShowContent(this)" >
		<div class="box-shipping-title box-title checkoutonestep-title">
			<div class="around"><span>3</span></div>
			{l s='Payment Method' mod='presmobileapp'}
		</div>
		<div class="chekout-angle">
			<i class="fa fa-angle-up"></i>
			<i class="fa fa-angle-down"></i>
		</div>
	</div>
	<div class="premobile-detail-content">
		<div class="total-detail">
			<ul>
				<h4 style="text-transform: none;margin-bottom: 0;"> {l s='Summary' mod='presmobileapp'}</h4>
				<li class="clearfix">
					<span class="title">Sub Total: {$cart[0]['count_product']|escape:'htmlall':'UTF-8'} item{if $cart[0]['count_product'] !='1'}(s){/if}</span>
					<span class="value total_product_r">{$cart[0]['price_product']|escape:'htmlall':'UTF-8'}</span>
				</li>
				<li class="clearfix">
					<span class="title"> {l s='Shipping:' mod='presmobileapp'}</span>
					<span class="value" style="color: green;" id="price_shipping_r">{$cart[0]['price_shipping']|escape:'htmlall':'UTF-8'}</span>
				</li>
				<li class="clearfix">
					<span class="title">Tax:</span>
					<span class="value" id="total_tax_r">{$cart[0]['price_tax']|escape:'htmlall':'UTF-8'}</span>
				</li>
				{if !empty($cart[0]['coupon'])}
				{foreach from=$cart[0]['coupon'] key=key4 item=item4}
				<li class="clearfix">
					<span class="title"> {l s='Coupon Code' mod='presmobileapp'}<br/><span style="color: #bcbcbc;">({$item4['code']|escape:'htmlall':'UTF-8'}:-{$item4['price']|escape:'htmlall':'UTF-8'})</span></span>
					<span class="value">-{$item4['total_price']|escape:'htmlall':'UTF-8'}</span>
				</li>						
				{/foreach}
				{/if}
				<li class="clearfix">
					<span class="title"> {l s='Total Payalbe Amount:' mod='presmobileapp'}</span>
					<span class="value total_price_r" id="order_total_r">{$cart[0]['totalprice']|escape:'htmlall':'UTF-8'}</span>
				</li>
			</ul>
		</div>
		<div id="Presmobile-chekoutonestep-payment" class="premobile-checkout-cart presmobile-checkout-total payment-attr" style="display: {if $checkterm = 1} none {else} block{/if};">
			{if $minium_price > $cart[0]['price_product_check']}
			<p for="" style="color: #F13340;font-weight: 700;">
				{l s='A minimum purchase total of ' mod='presmobileapp'}{$price_check|escape:'htmlall':'UTF-8'}
				{l s='(tax excl.) is required in order to validate your order, current purchase total is ' mod='presmobileapp'}
				{$cart[0]['price_product']|escape:'htmlall':'UTF-8'}
				{l s='(tax excl.).' mod='presmobileapp'}
			</p>
			{else}
			{$list_payment nofilter} {* no escape necessary *}
			{/if}
		</div>
	</div>
</div>
{/if}
{/if}
</div>