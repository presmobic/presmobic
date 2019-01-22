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
				
				<div class="block-step first-step step-active step-done">
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
				<div class="block-step second-step step-active">
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

<div class="premobile-checkout-cart">
	<div class="premobile-checkout-box-top clearfix"  onclick="PresMobileCheckoutCartShowContent(this)" >
		<div class="box-shipping-title box-title">{l s='Shipping Method' mod='presmobileapp'}</div>
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
				{$id_carrier = 0}
				{foreach from=$cart[0]['shipping'] key=key item=item}
				<li class="shipping shipping-{$i++|escape:'htmlall':'UTF-8'}" data-shipping-method='{$key|escape:'htmlall':'UTF-8'}' onclick="PreMobileCheckoutCartCheckedShippingMethod({$a++},this)">
					<div class="premobile-shipping-method {if $i == '1'}method-check{/if}">
						<p  class="prmobile-shipping-title">{$item['carrier_name']|escape:'htmlall':'UTF-8'}</p>
						{if $item['is_free'] == 0}
						<p  class="prmobile-shipping-price">
							<span>{$item['total_price_r']|escape:'htmlall':'UTF-8'}</span>
							(tax excl.)
						</p>
						{/if}
						{$id_carrier = $key}
						<div class="primobile-shipping"></div>
					</div>
				</li>
				{/foreach}
			</ul>		
		</div>
	</div>
	<input type="hidden" name="abcs" value="{$id_carrier|escape:'htmlall':'UTF-8'}" class="id_carrier">
</div>
<div class="premobile-checkout-cart">
	{$hook_displayBeforeCarrier nofilter} {* no escape necessary *}
</div>
<div class="premobile-checkout-cart  premobile-checkout-order">
	<div class="premobile-checkout-box-top clearfix"  onclick="PresMobileCheckoutCartShowContent(this)">
		<div class="ion-ios-icon-order-list box-title">{l s='Order(s) Detail' mod='presmobileapp'}</div>
		<div class="chekout-angle chekout-angle-order-detail">
			<span>{$cart[0]['quantity']|escape:'htmlall':'UTF-8'} item{if $cart[0]['quantity'] !='1'}(s){/if}</span>
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
							{if $item3['price_discount'] != $item3['price_total']}
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
<div class="premobile-checkout-cart presmobile-checkout-total">
	<div class="premobile-detail-content">
		<div class="total-detail">
			<h4>{l s='Totals' mod='presmobileapp'}</h4>
			<ul>
				<li class="clearfix">
					<span class="title">{l s='Total Price' mod='presmobileapp'}:</span>
					<span class="value total_product_r">{$cart[0]['total_product']|escape:'htmlall':'UTF-8'}</span>
				</li>
				<li class="clearfix">
					<span class="title">{l s='Shipping' mod='presmobileapp'}:</span>
					<span class="value" style="color: green;" id="price_shipping_r">{if $cart[0]['total_shipping_check'] >0}{$cart[0]['total_shipping']|escape:'htmlall':'UTF-8'}{else}{l s='Free Shipping!' mod='presmobileapp'}{/if}</span>
				</li>
				<li class="clearfix">
					<span class="title">{l s='Tax' mod='presmobileapp'}:</span>
					<span class="value" id="total_tax_r">{$cart[0]['total_tax']|escape:'htmlall':'UTF-8'}</span>
				</li>
				{if !empty($cart[0]['discount_new'])}
				{foreach from=$cart[0]['discount_new'] key=key4 item=item4}
				<li class="clearfix">
					<span class="title">Coupon Code <br/><span style="color: #bcbcbc;">
					({$item4['code']|escape:'htmlall':'UTF-8'}: -{$item4['price']|escape:'htmlall':'UTF-8'})</span></span>
					<span class="value">-{$item4['total_price']|escape:'htmlall':'UTF-8'}</span>
				</li>						
				{/foreach}
				{/if}
				<li class="clearfix">
					<span class="title">{l s='Total Payable Amount' mod='presmobileapp'}</span>
					<span class="value total_price_r" id="order_total_r">{$cart[0]['total_price']|escape:'htmlall':'UTF-8'}</span>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="premobile-checkout-cart">
	<div class="terms-conditions" accept-term-data='false'>
		{if $checkterm == 1}
		<div class="accept-terms" onclick="PreMobileCheckoutCartTermsCondition()">
			<div class="checkbox-inner"></div>
		</div>
		<div class="terms-conditions-link"> 
			<span onclick="PreMobileCheckoutCartTermsCondition()">
				{l s='I agree to the terms of service and will adhere to them unconditionally.' mod='presmobileapp'}
			</span>
			<span onclick="PreMobileCheckoutCartShowTermsBlock()">({l s='Read the Terms of Service' mod='presmobileapp'})</span>
		</div>
		{/if}
		<button class="checkout-buttom {if $checkterm == 1} disabledbutton {/if}" onclick="PresMobibamobileroutes(this)" ba-link="#checkoutpayment" {if $checkterm == 0} style="opacity: 1;" {/if}>{l s='Proceed to checkout' mod='presmobileapp'}</button>
	</div>
	<div class="terms-conditions-popup">
		<div class="terms-bg" onclick="PreMobileCheckoutCartCloseTermsBlock()"></div>
		<div class="terms-conditions-block">
			<div class="tearms-conditions-header">
				<h4>{l s='Terms & Service' mod='presmobileapp'}</h4>
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
					<h4 onclick="PreMobileCheckoutCartCloseTermsBlock()">{l s='Close' mod='presmobileapp'}</h4>
				</div>
				<div class="ui-block-b">
					<h4 onclick="PreMobileCheckoutCartAcceptButton()">{l s='Accept' mod='presmobileapp'}</h4>
				</div>
			</div>
		</div>
	</div>
</div>	