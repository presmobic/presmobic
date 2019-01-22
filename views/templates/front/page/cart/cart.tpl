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
{if !empty($cart)}
<div class="presmobile-cart-content clearfix">
	<div class="ui-block-a td_cart" style="float:left;width:100%;padding: 0 1em;margin-top:46px;">
		{$presmobic_beforeCartProduct nofilter} {* no escape necessary *}
		{foreach from=$cart[0]['product'] key=key item=item}
		<div class="ui-block-a td_cart_product td_cart_product_{$item['id_product']|escape:'htmlall':'UTF-8'}-{$item['id_product_attribute']|escape:'htmlall':'UTF-8'}" style="position: relative;" >
			<p class="id_product_attribute" id_attr="{$item['id_product_attribute']|escape:'htmlall':'UTF-8'}" style="display: none;">
				<div class="td_cart_product_left" onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item['id_product']|escape:'htmlall':'UTF-8'}">
					<div class="td_cart_product_img" >
						<img src="{$item['link_img']|escape:'htmlall':'UTF-8'}" style="max-width: 100%;" alt="">
						{if !empty($item['specific_prices'])}
						{if $item['specific_prices']['reduction_type'] == 'percentage'}
						<div class = "td_product_detail_sale_off_mobile">
							<span class="price-percent-reduction" style="text-shadow: none;">
								-{$item['specific_prices']['reduction']|escape:'htmlall':'UTF-8'*100}%
							</span>
						</div>
						{/if}
						{/if}
					</div>
				</div>
				<div class="td_cart_product_right" onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item['id_product']|escape:'htmlall':'UTF-8'}">
					<div class="td_cart_product_right_left">
						<p class="td_cart_product_name" style="padding: 0;height: auto;color:#5A5A5A;font-size: 13px;margin:0;margin-left: 1em;margin-bottom:10px;">
							{$item['name']|escape:'htmlall':'UTF-8'}
						</p>
						{if !empty($item['attributes'])}
						<div style="float: left;width: 100%;display:inline-block;margin:0;font-size: 13px;font-weight: 400;margin-left: 1em;margin-bottom:0.3em;">
							{$item['attributes']|escape:'htmlall':'UTF-8'}
						</div>
						{/if}
					</div>
					<div style="float: left;width: 40%;margin-left: 1em;">
						{if {$item['price_discount']} != {$item['price_total']}}
						<span class="price_total" style="float: left;width: 100%;font-size: 12px;margin-left:0;">{$item['price_discount']|escape:'htmlall':'UTF-8'}</span>
						{/if}
						<span class="price_sale" style="float: left;width: 100%;font-size: 14px;">{$item['price_total']|escape:'htmlall':'UTF-8'}</span>
					</div>
				</div>
				{$presmobicBeforeCartBoxQuantity nofilter} {* no escape necessary *}
				<div class="td_cart_product_quantity" style="position: absolute;bottom: 0; right: 0;">
					<span class="td_product_detail_togetther_right_quantity_minus_{$item['id_product']|escape:'htmlall':'UTF-8'}_{$item['id_product_attribute']|escape:'htmlall':'UTF-8'} td_product_detail_togetther_right_quantity_minus" onclick="quantityminus({$item['id_product']|escape:'htmlall':'UTF-8'},{$item['id_product_attribute']|escape:'htmlall':'UTF-8'})">
						<span style="position:  absolute;left: 50%;top: 50%;font-size:12px;transform: translate( -50%,-50%) !important;">
							<i class="fa fa-minus" style="color: #fff;text-shadow: none;    vertical-align: middle;"></i>
						</span>
					</span>
					<span style="float:left;width: 30%;margin: 0 11px;border: 1px solid #ededec;border-radius: 3px;max-width: 55px;">
						<input style="width: 93%;border:none;outline: none;font-size: 13px;" onkeypress="return event.charCode >= 48 && event.charCode <= 57 " class="td_product_detail_togetther_right_quantity_num_{$item['id_product']|escape:'htmlall':'UTF-8'}_{$item['id_product_attribute']|escape:'htmlall':'UTF-8'} td_product_detail_togetther_right_quantity_num" type="number" value="{$item['cart_quantity']|escape:'htmlall':'UTF-8'}" onblur="PresMobistartqty(this, {$item['id_product']|escape:'htmlall':'UTF-8'}, {$item['id_product_attribute']|escape:'htmlall':'UTF-8'},{$item['quantity_available']|escape:'htmlall':'UTF-8'})">
					</span>
					<span class="td_product_detail_togetther_right_quantity_plus_{$item['id_product']|escape:'htmlall':'UTF-8'} td_product_detail_togetther_right_quantity_plus" onclick="quantityplus({$item['id_product']|escape:'htmlall':'UTF-8'},{$item['id_product_attribute']|escape:'htmlall':'UTF-8'})">
						<span style="position:  absolute;left: 50%;top: 50%;font-size: 11px;transform: translate( -50%,-50%) !important;">
							<i class="fa fa-plus" style="color: #fff;text-shadow: none;"></i>
						</span>
					</span>
				</div>
				{$presmobicAfterCartBoxQuantity nofilter} {* no escape necessary *}
				<div class="td_cart_product_trash" onclick="PreMobileCartDeleteProductButton(this,{$item['id_product']|escape:'htmlall':'UTF-8'},{$item['id_product_attribute']|escape:'htmlall':'UTF-8'})" style="position: absolute;right: 0;">
					<i class="fa fa-trash"  style="float: right;color: #adb4bd;font-weight: 100;width: 30px;text-align: right;height: 16px;"></i>
				</div>
			</div>
			{/foreach}
			<div class="presmobile-rmpro-popup presmobile-delete-popup">
				<div class="cart-bg" onclick="PreMobileCartCloseButton()"></div>
				<div class="terms-conditions-block">
					<div class="tearms-conditions-header">
						<h4>{l s='Are you sure you want to remove this product from your basket?' mod='presmobileapp'}</h4>
					</div>
					<div class="ui-grid-a tearm-conditions-footer">
						<div class="ui-block-a">
							<h4 onclick="PreMobileCartCloseButton()" style="font-weight: normal;">{l s='Cancel' mod='presmobileapp'}</h4>
						</div>
						<div class="ui-block-b">
							<h4 class="abcre">{l s='Delete' mod='presmobileapp'}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		{$presmobic_afterCartProduct nofilter} {* no escape necessary *}
		{$presmobic_beforeCartCoupon nofilter} {* no escape necessary *}
		<div style="background: #f1f3f5;float: left;width: 100%;height: 10px;"></div>
		<div class="ui-block-a" style="float: left;width: 100%;padding: 0 1em;margin-bottom: 15px;">
			<p class="td_cart_product_name" style="padding: 0;height: auto;color:#111519;font-size: 13px;font-weight: 700;">
				{l s='Have a coupon?' mod='presmobileapp'}
			</p>
			<div style="float:left;text-shadow: none;box-shadow: none;width: 70%;">
				<input class="td_cart_input_coupon" type="text" name="" class="search-product"  placeholder="Coupon Code here..." onkeyup="PresMobicheckCounpon(this)">
			</div>
			<div style="float:right;text-shadow: none;box-shadow: none;" class="addcountpon disabledbutton" onclick="PresMobiaddCountpon()">
				<div style="float: left;background: #ff0235;padding: 6px 14px;color: #fff;">
					{l s='APPLY' mod='presmobileapp'}
				</div>
			</div>
		</div>
		{$presmobic_afterCartCoupon nofilter} {* no escape necessary *}
		<div style="background: #f1f3f5;float: left;width: 100%;height: 10px;"></div>
		<div class="ui-block-a td_cart_bottom" style="float: left;width: 100%;padding: 0 1em;font-size: 13px;">
			<p class="td_cart_product_name" style="padding: 0;height: auto;color:#111519;font-weight: 700;">
				{l s='TOTALS' mod='presmobileapp'}
			</p>
			<div style="float:left;width:100%;">
				<div style="float: left;">
					<p>{l s='Total Price' mod='presmobileapp'}:</p>
				</div>
				<div style="float: right;">
					<p class="product_price">{$cart[0]['price_product']|escape:'htmlall':'UTF-8'}</p>
				</div>
			</div>
			<div style="float:left;width:100%;">
				<div style="float: left;">
					<p>{l s='Shipping' mod='presmobileapp'}:</p>
				</div>
				<div style="float: right;">
					<p class="shipping_price">{$cart[0]['price_shipping']|escape:'htmlall':'UTF-8'}</p>
				</div>
			</div>
			<div style="float:left;width:100%;" class="appendcoupon">
				{if !empty($cart[0]['coupon'])}
				{foreach from=$cart[0]['coupon'] key=key_r item=item_r}
				<div style="float:left;width:100%;">
					<div style="float: left;position: relative;">
						<p style="margin:6px 0;">{l s='Coupon' mod='presmobileapp'} 
							<span style="color: #ff0033;font-size:13px;">({$item_r['code']|escape:'htmlall':'UTF-8'}: -{$item_r['price']|escape:'htmlall':'UTF-8'})<i class="icon-icondetele" style="position: absolute;color: #adb4bd;top: 6px;left: 100%;" onclick="PresMobideleteCoupon({$item_r['id']|escape:'htmlall':'UTF-8'})"></i></span>
						</p>
					</div>
					<div style="float: right;">
						<p style="color: #ff0033 !important;margin: 8px 0;"> -{$item_r['total_price']|escape:'htmlall':'UTF-8'}</p>
					</div>
				</div>
				{/foreach}
				{/if}
			</div>
			<div style="float:left;width:100%;">
				<div style="float: left;">
					<p style="font-weight:700;">{l s='Order Total' mod='presmobileapp'} </p>
				</div>
				<div style="float: right;">
					<p style="font-weight:700;" class="total_price_end">{$cart[0]['totalprice']|escape:'htmlall':'UTF-8'}</p>
				</div>
			</div>
		</div>
		{$presmobicBeforeCartSubmitCheckout nofilter} {* no escape necessary *}
		<div class="ui-block-a {if $minium_price > $cart[0]['price_product_check']} disabledbutton {/if}" style="float: left;padding: 0 1em;color: #fff;width:100%;background:#fff;">
			<div style="margin-bottom: 10px;float: left;background: #ff1d4b;padding: 10px 0px;color: #fff;width:100%;margin-top: 10px;text-align: center;text-shadow: none;" 
			{if $cart_customer['logged'] != '1'}
			{if $check_guest == '1'}
			onclick="PreMobileCartCheckOutButton()"
			{else}
			{if $check_order == '1'}
			onclick="PreMobisetCookie('control','#checkoutonestep'),PresMobibamobileroutes(this)" ba-link="#login"
			{else}
			onclick="PreMobisetCookie('control','#myaddress'),PresMobibamobileroutes(this)" ba-link="#login"
			{/if}
			{/if}
			{else}
			{if $check_order == '1'}
			onclick="PresMobibamobileroutes(this)" ba-link="#checkoutonestep"
			{else}
			{if $check_address == '1'}
			onclick="PresMobibamobileroutes(this)" ba-link="#myaddress"
			{else}
			onclick="PresMobibamobileroutes(this)" ba-link="#checkoutaddress"
			{/if}
			{/if}
			{/if}
			>
			{l s='CHECK OUT' mod='presmobileapp'}
			<i class="icon-iconarrow" style="color:#fff;"></i>
		</div>
	</div>
	{$presmobicAfterCartSubmitCheckout nofilter} {* no escape necessary *}
	{if $minium_price > $cart[0]['price_product_check']}
	<p for="" style="color: #F13340;font-weight: 700;float: left;padding: 0px 13px;">
		{l s='A minimum purchase total of ' mod='presmobileapp'}{$price_check|escape:'htmlall':'UTF-8'}
		{l s='(tax excl.) is required in order to validate your order, current purchase total is ' mod='presmobileapp'}
		{$cart[0]['price_product']|escape:'htmlall':'UTF-8'}
		{l s='(tax excl.).' mod='presmobileapp'}
	</p>
	{/if}
	<div class="presmobile-rmpro-popup presmobile-checkout-popup">
		<div class="cart-bg" onclick="PreMobileCartCloseButton()"></div>
		<div class="terms-conditions-block">
			<div class="tearms-conditions-header">
				<h4> {l s='You aren\'t login, if continue to checkout as guest. Do you want to login manage your order' mod='presmobileapp'}</h4>
			</div>
			<div class="ui-grid-a tearm-conditions-footer">
				<div class="ui-block-a">
					<h4 
					{if $check_order == '0'}
					onclick="PresMobibamobileroutes(this)" ba-link="#checkoutaddress"
					{else}
					onclick="PresMobibamobileroutes(this)" ba-link="#checkoutonestep"
					{/if}
					>{l s='No' mod='presmobileapp'}</h4>
				</div>
				<div class="ui-block-b">
					<h4 class="abcre"
					{if $check_order == '0'}
					onclick="PreMobisetCookie('control','#myaddress'),PresMobibamobileroutes(this)" ba-link="#login"
					{else}
					onclick="PreMobisetCookie('control','#checkoutonestep'),PresMobibamobileroutes(this)" ba-link="#login"
					{/if}
					>{l s='Yes' mod='presmobileapp'}</h4>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
{/if}
{if empty($cart)}
<div class="PresMobileblock-cart-empity" >
	<span class="icon-heart"></span>
	<label>
		{l s='You don\'t like empty' mod='presmobileapp'}
	</label>
	<a class="PresMobileshopnow-button" href="#" onclick="PresMobiactivetab(this),PresMobibamobileroutes(this)" ba-link="#home" >{l s='Shop Now' mod='presmobileapp'} !</a>
</div>
{/if}