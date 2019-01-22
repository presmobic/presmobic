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
{foreach from=$order key=key item=item}
<div class="order-id-detail">
	<div class="order-status" style="background-color: {$item['order_state_color']|escape:'htmlall':'UTF-8'}">
		{l s='Order status: ' mod='presmobileapp'}<span>{$item['order_state']|escape:'htmlall':'UTF-8'}</span>
	</div>
	<div class="premobile-checkout-cart" style="padding:1em 1em 0 1em;">
		<div class="premobile-checkout-box-top clearfix"  onclick="PresMobileCheckoutCartShowContent(this)" >
			<div class="ion-ios-icon-location box-title"> {l s='Address' mod='presmobileapp'}</div>
			<div class="chekout-angle">
				<i class="fa fa-angle-up"></i>
				<i class="fa fa-angle-down"></i>
			</div>
		</div>
		<div class="premobile-checkout-cart-detail prmobile-shipping-detail">
			<div class="premobile-detail-content">
				<h4> {l s='Delivery Address' mod='presmobileapp'}</h4>
				<div class="premobile-delivery-address">
					{foreach from=$item['address_delivery'] key=key1 item=item1}
					<h5 class="fullname-detail">{$item1['lastname']|escape:'htmlall':'UTF-8'} {$item1['firstname']|escape:'htmlall':'UTF-8'}</h5>
					<span class="company-detail">{$item1['company']|escape:'htmlall':'UTF-8'}</span>
					<span class="address-detail">{$item1['address1']|escape:'htmlall':'UTF-8'} {$item1['address2']|escape:'htmlall':'UTF-8'}</span>
					<span class="city-detail">{$item1['city']|escape:'htmlall':'UTF-8'} {$item1['state']|escape:'htmlall':'UTF-8'} {$item1['vat_number']|escape:'htmlall':'UTF-8'} {$item1['postcode']|escape:'htmlall':'UTF-8'}</span>
					<span class="country-detail">{$item1['country']|escape:'htmlall':'UTF-8'}</span>
					<span class="homephone-detail">{$item1['phone']|escape:'htmlall':'UTF-8'}</span>
					<span class="mobile-detail">{$item1['phone_mobile']|escape:'htmlall':'UTF-8'}</span>
					{/foreach}		
				</div>
				<h4> {l s='Billing Addrress' mod='presmobileapp'}</h4>
				<div class="premobile-billing-address">
					{foreach from=$item['address_invoice'] key=key1 item=item1}
					<h5 class="fullname-detail">{$item1['lastname']|escape:'htmlall':'UTF-8'} {$item1['firstname']|escape:'htmlall':'UTF-8'}</h5>
					<span class="company-detail">{$item1['company']|escape:'htmlall':'UTF-8'}</span>
					<span class="address-detail">{$item1['address1']|escape:'htmlall':'UTF-8'} {$item1['address2']|escape:'htmlall':'UTF-8'}</span>
					<span class="city-detail">{$item1['city']|escape:'htmlall':'UTF-8'} {$item1['state']|escape:'htmlall':'UTF-8'} {$item1['vat_number']|escape:'htmlall':'UTF-8'} {$item1['postcode']|escape:'htmlall':'UTF-8'}</span>
					<span class="country-detail">{$item1['country']|escape:'htmlall':'UTF-8'}</span>
					<span class="homephone-detail">{$item1['phone']|escape:'htmlall':'UTF-8'}</span>
					<span class="mobile-detail">{$item1['phone_mobile']|escape:'htmlall':'UTF-8'}</span>
					{/foreach}	
				</div>
			</div>	
		</div>
	</div>
	{$presmobic_beforeOrderShipping nofilter} {* no escape necessary *}
	<div class="premobile-checkout-cart">
		<div class="premobile-checkout-box-top clearfix"  onclick="PresMobileCheckoutCartShowContent(this)" >
			<div class="box-title box-shipping-title"> {l s='Shipping Method' mod='presmobileapp'}</div>
			<div class="chekout-angle">
				<i class="fa fa-angle-up"></i>
				<i class="fa fa-angle-down"></i>
			</div>
		</div>
		<div class="premobile-checkout-cart-detail prmobile-shipping-detail">
			<div class="premobile-detail-content">
				<ul class="">
					{foreach from=$item['shipping'] key=key2 item=item2}
					<li class="">
						<div class="">
							<p  class="prmobile-shipping-title">{$item2['carrier_name']|escape:'htmlall':'UTF-8'}</p>
							<p  class="prmobile-shipping-price"></p>
							<p>{if $item2['shipping_cost_tax_excl'] > 0}{$item2['shipping_cost_tax_incl']|escape:'htmlall':'UTF-8'} {else} {l s='Free Shipping!' mod='presmobileapp'}{/if}</p>
						</div>
					</li>
					{/foreach}
				</ul>		
			</div>
		</div>
	</div>
	{$presmobic_afterOrderShipping nofilter} {* no escape necessary *}
	{$presmobic_beforeOrderPayment nofilter} {* no escape necessary *}
	<div class="premobile-checkout-cart">
		<div class="premobile-checkout-box-top clearfix"  onclick="PresMobileCheckoutCartShowContent(this)" >
			<div class="box-title ion-ios-icon-wallet"> {l s='Payment Method' mod='presmobileapp'}</div>
			<div class="chekout-angle">
				<i class="fa fa-angle-up"></i>
				<i class="fa fa-angle-down"></i>
			</div>
		</div>
		<div class="premobile-checkout-cart-detail prmobile-shipping-detail">
			<div class="premobile-detail-content">
				<h5 class="order-payment-method">
					{$item['payment']|escape:'htmlall':'UTF-8'}
				</h5>
			</div>
		</div>
	</div>
	{$presmobic_afterOrderPayment nofilter} {* no escape necessary *}
	<div class="premobile-checkout-cart premobile-checkout-order">
		<div class="premobile-checkout-box-top clearfix"  onclick="PresMobileCheckoutCartShowContent(this)" >
			<div class="box-title ion-ios-icon-order-list"> {l s='Order(s) Detail' mod='presmobileapp'}</div>
			<div class="chekout-angle chekout-angle-order-detail" style="float: right;">
				<span>{$item['count_product']|escape:'htmlall':'UTF-8'} item{if $item['count_product'] >1}s{/if}</span>
				<i class="fa fa-angle-up"></i>
				<i class="fa fa-angle-down"></i>
			</div>
		</div>
		{$presmobic_afterOrderProduct nofilter} {* no escape necessary *}
		<form id="ba-rma">
			<input type="hidden" value="{$order[0]['id_order']|escape:'htmlall':'UTF-8'}" name="id_order">
		<div class="premobile-checkout-cart-detail prmobile-shipping-detail">
			<div class="premobile-detail-content">
				<ul>
					{foreach from=$item['product'] key=key3 item=item3}
					<li class="premobile-orders-detail clearfix">
						{if ($check_status == '4' || $check_status == '5') && $order_return == '1'}
						<div class="order-item-rma" onclick="PresMobiQtyRma({$item3['id_order_detail']|escape:'htmlall':'UTF-8'})">
							<input type="checkbox" id="cb-{$item3['id_order_detail']|escape:'htmlall':'UTF-8'}" class="rma-order rma-{$item3['id_order_detail']|escape:'htmlall':'UTF-8'}"  name="ids_order_detail[{$item3['id_order_detail']|escape:'htmlall':'UTF-8'}]" value="{$item3['id_order_detail']|escape:'htmlall':'UTF-8'}">
							<span class="Presmobile-myaddress-checked">
								<div class="checked"></div> 
							</span>
						</div>
						{/if}
						<div class="order-item-image" onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item3['id_product']|escape:'htmlall':'UTF-8'}">
							<img src="{$item3['link_img']|escape:'htmlall':'UTF-8'}" alt="">
						</div>
						<div class="order-item-meta" onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item3['id_product']|escape:'htmlall':'UTF-8'}">
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
							{if $item['check_rma'] == '1'}
								<div class="price returned">
									<span class="salea">{l s='Returned : ' mod='presmobileapp'}</span>
									<span class="total">{$item3['qty_rma']|escape:'htmlall':'UTF-8'}</span>
								</div>
							{/if}
						</div>
						<div class="ram-total-return-{$item3['id_order_detail']|escape:'htmlall':'UTF-8'}" style="display: none;">
							<span class="td_product_detail_togetther_right_quantity_minus td_product_detail_togetther_right_quantity_minus_{$item3['id_order_detail']|escape:'htmlall':'UTF-8'} quantity-product-{$item3['id_order_detail']|escape:'htmlall':'UTF-8'}1" onclick="quantitydefaultpluspack({$item3['id_order_detail']|escape:'htmlall':'UTF-8'})">
							<span style="position:  absolute;left: 50%;top: 50%;font-size:12px;transform: translate( -50%,-50%) !important;">
								<i class="fa fa-minus" style="color: #fff;text-shadow: none;    vertical-align: middle;"></i>
							</span>
						</span>
						<span style="float:left;width: 45px;margin: 0 11px;border: 1px solid #ededec;border-radius: 3px;max-width: 55px;">
							<input style="width: 93%;border:none;outline: none;font-size: 13px;" onkeypress="return event.charCode >= 48 && event.charCode <= 57 " name="order_qte_input[{$item3['id_order_detail']|escape:'htmlall':'UTF-8'}]" class="td_product_detail_togetther_right_quantity_num td_product_detail_togetther_right_quantity_num_{$item3['id_order_detail']|escape:'htmlall':'UTF-8'}" type="number" value='{$item3['cart_quantity']|escape:'htmlall':'UTF-8'}'>
						</span>
						<span class="td_product_detail_togetther_right_quantity_plus_{$item3['id_order_detail']|escape:'htmlall':'UTF-8'} td_product_detail_togetther_right_quantity_plus" onclick="quantitypluspack({$item3['id_order_detail']|escape:'htmlall':'UTF-8'},{$item3['cart_quantity']|escape:'htmlall':'UTF-8'})">
							<span style="position:  absolute;left: 50%;top: 50%;font-size: 11px;transform: translate( -50%,-50%) !important;">
								<i class="fa fa-plus" style="color: #fff;text-shadow: none;"></i>
							</span>
						</span>
						</div>
					</li>
					{/foreach}
					<li class="premobile-orders-detail premobile-orders-rma clearfix">
						<span>
							{l s='If you wish to return one or more products, please mark the corresponding boxes and provide an explanation for the return. When complete, click the button below.' mod='presmobileapp'}
						</span>
						<textarea class="rma-corresponding" cols="67" rows="3" name="returnText"></textarea>
					</li>
				</ul>
			</div>
		</div>
		</form>
		{$presmobic_beforeOrderProduct nofilter} {* no escape necessary *}
	</div>
	<div>
		{$hook_displayOrderDetail nofilter} {* no escape necessary *}
	</div>
	<div class="premobile-checkout-cart presmobile-checkout-total">
		<div class="premobile-detail-content">
			<div class="total-detail">
				<h4> {l s='Totals' mod='presmobileapp'}</h4>
				<ul>
					<li class="clearfix">
						<span class="title"> {l s='Total Price:' mod='presmobileapp'}</span>
						<span class="value">{$item['total_products']|escape:'htmlall':'UTF-8'}</span>
					</li>
					<li class="clearfix">
						<span class="title"> {l s='Shipping:' mod='presmobileapp'}</span>
						<span class="value" style="color: green;">{if $item['total_shipping_check'] > 0} {$item['total_shipping']|escape:'htmlall':'UTF-8'} {else}{l s='Free Shipping!' mod='presmobileapp'}{/if}</span>
					</li>
					<li class="clearfix">
						<span class="title">{l s='Tax: ' mod='presmobileapp'}</span>
						<span class="value">{$item['tax']|escape:'htmlall':'UTF-8'}</span>
					</li>
					{if !empty($item['discount_new'])}
					{foreach from=$item['discount_new'] key=key4 item=item4}
					<li class="clearfix">
						<span class="title">{l s='Coupon Code ' mod='presmobileapp'}({$item4['code']|escape:'htmlall':'UTF-8'}:-{$item4['price']|escape:'htmlall':'UTF-8'})</span>
						<span class="value">{$item4['total_price']|escape:'htmlall':'UTF-8'}</span>
					</li>						
					{/foreach}
					{/if}
					<li class="clearfix">
						<span class="title">{l s='Order Total ' mod='presmobileapp'}</span>
						<span class="value">{$item['total_paid']|escape:'htmlall':'UTF-8'}</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="premobile-checkout-cart premobile-checkout-shipping-block">
		<div class="premobile-checkout-box-top clearfix" onclick="PresMobileCheckoutCartShowContent(this)">
			<div class="box-title icon-ello-shipping">{l s='Shipping' mod='presmobileapp'}</div>
			<div class="chekout-angle">
				<i class="fa fa-angle-up"></i>
				<i class="fa fa-angle-down"></i>
			</div>
		</div>
		<div class="premobile-checkout-cart-detail prmobile-shipping-detail">
			<div class="premobile-detail-content">
				<ul>
					{foreach from=$item['shipping'] key=key2 item=item2}
					<li class="shipping-item">
						<div class="ui-grid-a">
							<div class="ui-block-a">{l s='Date' mod='presmobileapp'}</div>
							<div class="ui-block-b">{dateFormat date=$item2.date_add full=0}</div>
						</div>
						<div class="ui-grid-a">
							<div class="ui-block-a">{l s='Carrier' mod='presmobileapp'}</div>
							<div class="ui-block-b">{$item2['carrier_name']|escape:'htmlall':'UTF-8'}</div>	
						</div>
						<div class="ui-grid-a">
							<div class="ui-block-a">{l s='Weight' mod='presmobileapp'}</div>
							<div class="ui-block-b">{if $item2['weight'] > 0}{$item2['weight']|string_format:"%.3f"} {Configuration::get('PS_WEIGHT_UNIT')|escape:'htmlall':'UTF-8'}{else}{l s='-' mod='presmobileapp'}{/if}</div>
						</div>
						<div class="ui-grid-a">
							<div class="ui-block-a">{l s='Shipping cost' mod='presmobileapp'}</div>
							<div class="ui-block-b">{if $item2['shipping_cost_tax_excl'] > 0}{$item2['shipping_cost_tax_incl']|escape:'htmlall':'UTF-8'}{else} {l s='Free' mod='presmobileapp'} {/if}</div>
						</div>	
						<div class="ui-grid-a">
							<div class="ui-block-a">{l s='Tracking number' mod='presmobileapp'}</div>
							<div class="ui-block-b">{if $item2['tracking_number']}{if $line.url && $item2['tracking_number']}{else}{$item2['tracking_number']|escape:'htmlall':'UTF-8'}{/if}{else}{l s='-' mod='presmobileapp'}{/if}</div>
						</div>
					</li>
					{/foreach}
				</ul>
			</div>
		</div>
	</div>
	{$presmobic_beforeOrderRma nofilter} {* no escape necessary *}
	<div class="ui-grid-a rmaslip-block">
		<div class="reorder-button" onclick="PresMobibaReOrder(this)" id-order="{$item['id_order']|escape:'htmlall':'UTF-8'}">
			<span class="icon-ello-refresh"></span>
			{l s='Reorder' mod='presmobileapp'}
		</div>
		{if ($check_status == '4' || $check_status == '5') && $order_return == '1'}
			<div class="rmaslip-order-button" onclick="PresMobiRma()">
				{l s='Make an RMA slip' mod='presmobileapp'}
				<i class="fa fa-angle-right"></i>
			</div>
		{/if}
		<div class="Presmobile-select-popup popup-choose-merchandise">
			<div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-choose-merchandise')"></div>
			<div class="Presmobile-select-popup-block">
				<div class="Presmobile-select-popup-header">
					<h4> {l s='Merchandise return' mod='presmobileapp'}</h4>
					<span>{l s='Select a reason for the return' mod='presmobileapp'}</span>
					<i class="icon-ello-close" onclick="PresMoblieHideAddressSelectPopup('popup-choose-merchandise')"></i>
				</div>
				<ul class="Presmobile-select-popup-content">
					<li class="list-merchandise list-merchandise-1 clearfix" onclick="PresMoblieChangeMerchandise(this)" id_value="1">
						<span>Delivery of false products</span>
						<span class="choose-address"></span>
					</li>
					<li class="list-merchandise list-merchandise-2 merchandiseselected clearfix" onclick="PresMoblieChangeMerchandise(this)" id_value="2">
						<span>Other description</span>
						<span class="choose-address"></span>
					</li>
					<li class="list-merchandise list-merchandise-3 clearfix" onclick="PresMoblieChangeMerchandise(this)" id_value="3">
						<span>Product broken</span>
						<span class="choose-address"></span>
					</li>
					<li class="list-merchandise list-merchandise-4 clearfix" onclick="PresMoblieChangeMerchandise(this)" id_value="4">
						<span>Shortage of goods, accessories</span>
						<span class="choose-address"></span>
					</li>
					<li class="list-merchandise list-merchandise-5 clearfix" onclick="PresMoblieChangeMerchandise(this)" id_value="5">
						<span>Other</span>
						<span class="choose-address"></span>
					</li>
				</ul>
				<div class="ui-grid-a Presmobile-select-popup-footer">
					<div class="create-rmaslip-button" data-merchandise=''>
						{l s='Make an RMA slip  ' mod='presmobileapp'}
					</div>
				</div>
			</div>
		</div>
	</div>
	{$presmobic_afterOrderRma nofilter} {* no escape necessary *}
</div>
{/foreach}