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
<script>
	var bazoom = {$productzoom nofilter} {* no escape necessary *};
	function bazoomimg(key){
		$('.home-header').hide();
		$('#footer-detail').hide();
		$('#draggable').hide();
		var pswpElement = document.querySelectorAll('.pswp')[0];
		var options = {
			index: key 
		};
		var productgallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, bazoom, options);
		productgallery.init();
		productgallery.listen('close', function() {
			$('.home-header').show();
			$('#footer-detail').show();
			$('#draggable').show();
		});
	}
	$( "#draggable" ).draggable({
		containment: "window",
		start: function() {
		},
		drag: function() {
		},
		stop: function() {
			element1 = document.getElementById('draggable'),
			style1 = window.getComputedStyle(element1),
			topba = style1.getPropertyValue('top');
			PreMobisetCookie('bamoveproduct_top', topba);
			leftba = style1.getPropertyValue('left');
			PreMobisetCookie('bamoveproduct_left', leftba);
		}
	});
	var homeleft = PreMobigetCookie('bamoveproduct_left');
	var hometop = PreMobigetCookie('bamoveproduct_top');
	if (typeof homeleft !== "undefined" && typeof hometop !== "undefined" ) {
		$('#draggable').css('left', homeleft);
		$('#draggable').css('top', hometop);
	}
</script>
<input type="hidden" name="controller" value="product">
<input type="hidden" name="id_product" value="{$product[0]['id_product']|escape:'htmlall':'UTF-8'}">
<div class="Presmobile-select-popup popup-product-images">
	<div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-product-images')" style="opacity: 0.8;"></div>
	<div class="Presmobile-select-popup-block" style="border-radius: 0;">
	</div>
</div>
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="pswp__bg"></div>
	<div class="pswp__scroll-wrap">
		<div class="pswp__container">
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
		</div>
		<div class="pswp__ui pswp__ui--hidden">
			<div class="pswp__top-bar">
				<div class="pswp__counter"></div>
				<button class="pswp__button pswp__button--close" title="Close (Esc)" ></button>
				<button class="pswp__button pswp__button--share" title="Share"></button>
				<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
				<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
				<div class="pswp__preloader">
					<div class="pswp__preloader__icn">
						<div class="pswp__preloader__cut">
							<div class="pswp__preloader__donut"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
				<div class="pswp__share-tooltip"></div> 
			</div>
			<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
			</button>
			<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
			</button>
			<div class="pswp__caption">
				<div class="pswp__caption__center"></div>
			</div>
		</div>
	</div>
</div>
<div class="ui-grid-a PresMobileproduct-images"  style="position: relative;overflow: initial;" >
	{if !empty($product[0]['img'])}
	<div class="owl-carousel owl-theme">
		{foreach from=$product[0]['img'] key=key item=item}
		<div class="item baimgdetail" img-value="{$key|escape:'htmlall':'UTF-8'+1}" attr-img="{if isset($attri_img[$item['id_image']])}{$attri_img[$item['id_image']]|escape:'htmlall':'UTF-8'}{/if}" >
			<img src="{$item['image']|escape:'htmlall':'UTF-8'}" style="float:left;" onclick="return bazoomimg({$key})" alt="">
		</div>
		{/foreach}
	</div>
	{/if}
	{if !empty($product[0]['available_now'])}
	<div class="td_product_detail_instock" style="z-index:999">
		<span style="text-shadow: none;">
			{$product[0]['available_now']|escape:'htmlall':'UTF-8'}
		</span>
	</div>
	{/if}
	{if !empty($product[0]['specific_prices'])}
	{if $product[0]['specific_prices']['reduction_type'] == 'percentage'}
	<div class = "td_sale_off_product_detail" style="z-index:999;">
		<span class="price-percent-reduction" style="text-shadow: none;">-{$product[0]['specific_prices']['reduction']|escape:'htmlall':'UTF-8' * 100}%
		</span>
	</div>
	{/if}
	{/if}
	<div class = "td_tab_img_product_detail" style="z-index:999;">
		<span class="price-percent-reduction count-next-slider" style="text-shadow: none;">
			{l s='1 of' mod='presmobileapp'}
			{count($product[0]['img'])|escape:'htmlall':'UTF-8'}
		</span>
	</div>
	{if $active_wishlist== 1}
	{if empty($wishlist)}
	<div class = "td_wis_product_detail td_wislist_product_detail" {if $cart['logged']}onclick="PreMobiaddWislist({$cart['id_customer']|escape:'htmlall':'UTF-8'}, {$product[0]['id_product']|escape:'htmlall':'UTF-8'},2)"{else}onclick="PreMobisetCookie('control','#product:{$product[0]['id_product']|escape:'htmlall':'UTF-8'}'),PresMobibamobileroutes(this)" ba-link="#login"{/if}>
		<i class="fa fa-star"></i>
	</div>
	{else}
	<div class = "td_wis_product_detail td_wislist_product_detail" style="right: 15%;" {if $cart['logged']}onclick="PresMoblieShowAddressSelectPopup('popup-choose-wishlist')"{else}onclick="PreMobisetCookie('control','#product:{$product[0]['id_product']|escape:'htmlall':'UTF-8'}'),PresMobibamobileroutes(this)" ba-link="#login"{/if}>
		<i class="fa fa-star"></i>
	</div>
	<div class="Presmobile-select-popup popup-choose-wishlist">
		<div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-choose-wishlist')"></div>
		<div class="Presmobile-select-popup-block">
			<div class="Presmobile-select-popup-header">
				<h4> {l s='Choose Wishlist' mod='presmobileapp'}</h4>
			</div>
			<ul class="Presmobile-select-popup-content">
				{foreach from=$wishlist key=key_a item=item_a}
				<li class="list-wishlist list-wishlist-{$item_a['id_wishlist']|escape:'htmlall':'UTF-8'} {if $item_a['default'] == 1}wishlistselected{/if}" value-wishlist="{$item_a['id_wishlist']|escape:'htmlall':'UTF-8'} " onclick="PresMoblieAddToWishlist(this)">{$item_a['name']}
					<span class="choose-address"></span>
				</li>
				{/foreach}
			</ul>
			<div class="ui-grid-a Presmobile-select-popup-footer">
				<div class="ui-block-a" style="width:50%;margin:0;">
					<h4 onclick="PresMoblieHideAddressSelectPopup('popup-choose-wishlist')">{l s='Close' mod='presmobileapp'}</h4>
				</div>
				<div class="ui-block-b" style="width:50%;margin:0;">
					<h4 class="apply-choose-wishlist" data-wishlist="" onclick="PreMobiaddWislist({$cart['id_customer']|escape:'htmlall':'UTF-8'}, {$product[0]['id_product']|escape:'htmlall':'UTF-8'},1)" >{l s='Done' mod='presmobileapp'}</h4>
				</div>
			</div>
		</div>
	</div>
	{/if}
	{/if}
	{if $active_favorite == 1}
	<div class = "td_love_product_detail td_favorite_product_detail" {if $cart['logged']}{if $product[0]['favorite']=='1'} style="color:red;" add="1" {/if}{/if}{if $cart['logged']}onclick="PreMobiaddFavorite({$cart['id_customer']|escape:'htmlall':'UTF-8'},{$product[0]['id_product']|escape:'htmlall':'UTF-8'},'detail')"{else}onclick="PreMobisetCookie('control','#product:{$product[0]['id_product']|escape:'htmlall':'UTF-8'}'),PresMobibamobileroutes(this)" ba-link="#login"{/if}>
		<i class="fa fa-heart"></i>
	</div>
	{/if}
</div>
<!--  end -->
<div class="ui-grid-a">
	<div class="ui-block-a robb_product_price" style="width: 100%;">
		{if $product[0]['total_price'] != $product[0]['price_new']}
		<span style="float: left;margin-right: 15px;"><h4 class="robb_price_new">{$product[0]['price_new']|escape:'htmlall':'UTF-8'}</h4></span>
		{/if}
		<span style="float: left;">
			<h4 style="color: black;" class="robb_price_total">{$product[0]['total_price']|escape:'htmlall':'UTF-8'}</h4></span>
			<h4 style="color: #FF7430;display: none;font-size: 16px;" class="warning"> {l s='This product is no longer in stock with those attributes but is available with others.' mod='presmobileapp'}</h4></span>
		</div>
	</div>
	<div class="ui-grid-a">
		{$presmobic_displayBeforeProductName nofilter} {* no escape necessary *}
		<div class="ui-block-a product-name" style="width: 100%;">
			<p style="margin: 2px 0;">{$product[0]['name']|escape:'htmlall':'UTF-8'}</p>
		</div>
		{$presmobic_displayAfterProductName nofilter} {* no escape necessary *}
	</div>
	<div class="ui-grid-a">
		{$hook_actionProductOutOfStock nofilter} {* no escape necessary *}
	</div>
	<div class="ui-grid-a">
		{$hook_displayRightColumnProduct nofilter} {* no escape necessary *}
	</div>
	<div class="ui-grid-a">
		{$hook_displayLeftColumnProduct nofilter} {* no escape necessary *}
	</div>
	<div class="ui-grid-a">
		{$hook_productbuton  nofilter} {* no escape necessary *}
	</div>
	<div class="ui-grid-a PresMobileproduct-rating" onclick="PresMobibamobileroutes(this)" ba-link="#comment:{$product[0]['id_product']|escape:'htmlall':'UTF-8'}">
		{if !empty($product[0]['comment'])}
		<div class="ui-block-a" style="width: 100%;">
			<div style="float: left;">
				{for $foo=1 to 5}
				<span style="text-align: center;margin: 0; font-size:13px;{if $foo <= $product[0]['grade_comment']}color:#ffcc00; {/if}{if $foo > $product[0]['grade_comment']}color: whitesmoke;{/if}" class="ion-md-icon-star"></span>
				{/for}
			</div>
			<div class="PresMobileproduct-detail-ranting">
				{if $product[0]['count_comment'] != 1}
				{$product[0]['count_comment']|escape:'htmlall':'UTF-8'} reviews >
				{else}
				{$product[0]['count_comment']|escape:'htmlall':'UTF-8'} review >
				{/if}
			</div>
		</div>
		{/if}
	</div>
	{if !empty($product[0]['attribute'])}
	<input type="hidden" name="" class="id_product_detail" value="{$product[0]['id_product']|escape:'htmlall':'UTF-8'}">
	{foreach from=$product[0]['attribute'] key=key_a item=item_a}
	<div class="ui-grid-a product-attribute">
		{if $key_a =='color'}
		{foreach from=$item_a key=key_a1 item=item_a1}
		<div class="ui-block-a" style="width: 100%;">
			<h4>{$key_a1|escape:'htmlall':'UTF-8'}</h4>
			<div class="robb-color-val">
				{foreach from=$item_a1 key=key_c1 item=item_c}
				<div class="color-value color-value-{$key_c1|escape:'htmlall':'UTF-8'}">
					<input type="radio" name="{$key_a1|escape:'htmlall':'UTF-8'}" value="{$key_c1|escape:'htmlall':'UTF-8'}" {foreach from=$product[0]['attribute_default'] key=key_check item=item_check}{if $item_check==$key_c1}checked{/if} {/foreach} onclick="PresMobichoiseattribute()" class="select_attribute selected_attribute">
					<label for="color-{$key_c1|escape:'htmlall':'UTF-8'}">
						<span style="background-color: {$item_c|escape:'htmlall':'UTF-8'};{if $item_c =='White'}    box-shadow: 0 0px 1px 0px rgba(0, 0, 0, 0.69);{/if}">
							<i class="icon-iconcheck" style="{if $item_c =='White'}color:#000000;{/if}" ></i>
						</span>
					</label>
				</div>
				{/foreach}
			</div>
		</div>
		{/foreach}
		{/if}
		{if $key_a =='select'}
		{foreach from=$item_a key=key_a1 item=item_a1}
		<div class="ui-block-a" style="width: 100%;">
			<h4>{$key_a1|escape:'htmlall':'UTF-8'}</h4>
			<div class="attribute-type-select">
				<select name="key_a1" class="selected_attribute choice_selected_attribute" onchange="PresMobichoiseattribute()">
					{foreach from=$item_a1 key=key_c1 item=item_c}
					<option value="{$key_c1|escape:'htmlall':'UTF-8'}" {foreach from=$product[0]['attribute_default'] key=key_check item=item_check}{if $item_check == $key_c1} selected {/if} {/foreach}>{$item_c|escape:'htmlall':'UTF-8'}</option>
					{/foreach}
				</select>
			</div>
		</div>
		{/foreach}
		{/if}
		{if $key_a =='radio'}
		{foreach from=$item_a key=key_a1 item=item_a1}
		<div class="ui-block-a" style="width: 100%;">
			<h4>{$key_a1|escape:'htmlall':'UTF-8'}</h4>
			<div class="robb-size-val">
				{foreach from=$item_a1 key=key_c1 item=item_c}
				<div class="robb-size-value">
					<input type="radio" name="size" value="{$key_c1|escape:'htmlall':'UTF-8'}" {foreach from=$product[0]['attribute_default'] key=key_check item=item_check}{if $item_check == $key_c1} checked {/if} {/foreach} onclick="PresMobichoiseattribute()" class="selected_attribute">
					<label>
						<span>{$item_c|escape:'htmlall':'UTF-8'}</span>
						<div class="robb-size-checked">
							<i class="icon-iconcheck"></i>
						</div>
					</label>
				</div>
				{/foreach}
			</div>
		</div>
		{/foreach}
		{/if}
	</div>
	{/foreach}
	{/if}
	<div class="ui-grid-a PresMobileproduct-quatity combiqty">
		{$presmobic_displayBeforeQuantityBox nofilter} {* no escape necessary *}
		<div class="ui-block-a" style="width: 100%;">
			<h4> {l s='Quantity' mod='presmobileapp'}</h4>
			<div class="box-quantity clearfix">
				<i class="fa fa-minus-circle" onclick="quantitydefaultminus()"></i>
				<div> 
					<input type="number" name="quantity" onkeypress="return event.charCode >= 48 && event.charCode <= 57 && event.charCode != 46" class="premobile_quantity" value="1" max="{$product[0]['quantity']|escape:'htmlall':'UTF-8'}" id="quantity_wanted" onblur="PresMobistartqtydetail(this,{$product[0]['quantity']|escape:'htmlall':'UTF-8'})">
				</div>
				<i class="fa fa-plus-circle" onclick="quantitydefaultplus({$product[0]['quantity']|escape:'htmlall':'UTF-8'})"></i>
				<label  style="float: left;margin-top:5px;">
					{if $hide_qty == 1}
					<span class="ba_items">{$product[0]['quantity']|escape:'htmlall':'UTF-8'} </span> {l s='Items' mod='presmobileapp'}
					{/if}
					<span class="checkqties" style="color: #FF7430;display:{if $checkqties >= $product[0]['quantity']}block{else}none{/if};"> {l s='Warning: Last items in stock!' mod='presmobileapp'}</span></label> 
				</div>
			</div>
			{$presmobic_displayAfterQuantityBox nofilter} {* no escape necessary *}
		</div>
		{$presmobic_displayBeforeSheetData nofilter} {* no escape necessary *}
		<div class="ui-grid-a PresMobileabout-product">
			{if !empty($product[0]['feature'])}
			<h4> {l s='About This Item' mod='presmobileapp'}</h4>
			{/if}
			<div class="PresMobilefeature content-feature">
				{if !empty($product[0]['feature'])}
				{foreach from=$product[0]['feature'] key=key_fea item=item_fea}
				<div class="ui-block-a" style="width: 100%;">
					<div style="width: 50%;float: left; font-size:13px;">{$item_fea['name']|escape:'htmlall':'UTF-8'}</div>
					<div style="width: 50%;float: left; font-size:13px;">{$item_fea['value']|escape:'htmlall':'UTF-8'}</div>
				</div>
				{/foreach}
				{/if}
			</div>
			{if $product[0]['feature']|@count >3}
			<div class="ui-block-a" style="width: 100%;">
				<p class="PresMobileviewmore viewmore_about PresMobileviewmore_1" onclick="PresMobimoreaubot(2)">
					{l s='View more ' mod='presmobileapp'}
					<i class="fa fa-chevron-down"></i>
				</p>
				<p class="PresMobileviewmore viewmore_about PresMobileviewmore_2" onclick="PresMobimoreaubot(1)" style="display: none">
					{l s='View less' mod='presmobileapp'}
					<i class="fa fa-chevron-down" style="transform: rotate(180deg);"></i>
				</p>
			</div>
			{/if}
		</div>
		{$presmobic_displayAfterSheetData nofilter} {* no escape necessary *}
		{$presmobic_displayBeforeDescription nofilter} {* no escape necessary *}
		<div class="ui-grid-a PresMobileproduct-description">
			<div class="ui-block-a" style="width: 100%;">
				{if !empty($product[0]['description_short'])}
				<h4> {l s='Description' mod='presmobileapp'}</h4>
				{/if}
			</div>
			{if !empty($product[0]['description_short']) }
			<div style="font-size:13px;" class="ui-block-a PresMobiledescription-1 PresMobiledescription">
				{$product[0]['description_short'] nofilter} {* no escape necessary *}
			</div>
			<div class="ui-block-a PresMobiledescription-2 PresMobiledescription" style="font-size:13px;display: none;">
				{$product[0]['description'] nofilter} {* no escape necessary *}
			</div>
			<div class="ui-block-a" style="width: 100%;">
				<p class="PresMobileviewmore viewmore_des_1 PresMobileviewmore_des_1" onclick="PresMobimoredes(2)">
					{l s='View more' mod='presmobileapp'}
					<i class="fa fa-chevron-down"></i>
				</p>
				<p class="PresMobileviewmore viewmore_des_1 PresMobileviewmore_des_2" onclick="PresMobimoredes(1)" style="display: none">
					{l s='View less' mod='presmobileapp'}
					<i class="fa fa-chevron-down" style="transform: rotate(180deg);"></i>
				</p>
			</div>
			{/if}
		</div>
		{$presmobic_displayAfterDescription nofilter} {* no escape necessary *}
		{$presmobic_displayAfterBuyerProtection nofilter} {* no escape necessary *}
		<div class="ui-grid-a PresMobileproduct-protection">
			<div class="ui-block-a" style="width: 100%;">
				<div class="icon-iconshieldchecked"></div>
				<h4>{l s='Buyer Protection ' mod='presmobileapp'}</h4>
				<div>
					<p>{l s='Return Accepted if product not as describeb, seller pays return shiping; or kepp the product and agree refund with seller. ' mod='presmobileapp'}</p>
				</div>
			</div>
		</div>
		<div class="ui-grid-a PresMobileproduct-hook-detail">
			{if isset($HOOK_PRODUCT_ACTIONS) && $HOOK_PRODUCT_ACTIONS}{$HOOK_PRODUCT_ACTIONS}{/if}
		</div>
		{$presmobic_displayAfterBuyerProtection nofilter} {* no escape necessary *}
		{if !empty($product_pack)}
		<div class="ui-grid-a">
			<h4>{l s='Buy Together' mod='presmobileapp'}</h4>
			{foreach from=$product_pack key=key_acce item=item_acce}
			<div class="ui-block-a td_detail_product_togetther">
				<div class="td_product_detail_togetther_left">
					<label class="container" style="float: left;padding: 0;width: 20%;">
						<input type="checkbox" name="category-color" id="checkbox-v-{$item_acce['id_product']|escape:'htmlall':'UTF-8'}" value="{$item_acce['id_product']|escape:'htmlall':'UTF-8'}" class="category-color price_pack" onclick="checkmaxpack({$item_acce['id_product']|escape:'htmlall':'UTF-8'})" data-price="{$item_acce['price_tax_exc']|escape:'htmlall':'UTF-8'}" data-pricespecal="{$item_acce['reduction']|escape:'htmlall':'UTF-8'}" >
						<span class="checkmark" style="border: 1px solid #E7E7E7;top: 40px;float: left;height: 21px;width: 21px;"></span>
					</label>
					<div class="td_detail_product_togetther_image" onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item_acce['id_product']|escape:'htmlall':'UTF-8'}">
						<img src="{$item_acce['link_img']|escape:'htmlall':'UTF-8'}" style="width: 100%;" alt="">
						{if !empty($item_acce['specific_prices'])}
						{if $item_acce['specific_prices']['reduction_type'] == 'percentage'}
						<div class = "td_product_detail_sale_off_mobile">
							<span class="price-percent-reduction" style="text-shadow: none;" >-{$item_acce['specific_prices']['reduction'] * 100}%
							</span>
						</div>
						{/if}
						{/if}
					</div>
				</div>
				<div class="td_product_detail_togetther_right">
					<div style="float: left;width: 100%;">
						<span class="price_sale">{$item_acce['total_price']|escape:'htmlall':'UTF-8'}</span>
						{if $item_acce['total_price'] != $item_acce['price_new']}
						<span class="price_total">{$item_acce['price_new']|escape:'htmlall':'UTF-8'}</span>
						{/if}
					</div>
					<div style="float:  left;width: 100%;padding: 3px 0;">
						<div>
							{if isset($item_acce['grade_comment'])}
							{for $foo=1 to 5}
							<span style="text-align: center;margin: 0;{if $foo <= $item_acce['grade_comment']}color:#ffcc00; {/if}{if $foo > $item_acce['grade_comment']}color: whitesmoke;{/if}" class="ion-md-icon-star"></span>
							{/for}
							{/if}
						</div>
					</div>
					<p class="d_product" style="padding: 0;height: auto;">
						{$item_acce['name']|escape:'htmlall':'UTF-8'}
					</p>
					<div class="td_product_detail_togetther_right_quantity">
						<span class="td_product_detail_togetther_right_quantity_minus td_product_detail_togetther_right_quantity_minus_{$item_acce['id_product']|escape:'htmlall':'UTF-8'}" onclick="quantitydefaultpluspack({$item_acce['id_product']|escape:'htmlall':'UTF-8'})" >
							<span style="position:  absolute;left: 50%;top: 50%;font-size: 11px;transform: translate( -50%,-40%) !important;">
								<i class="fa fa-minus"  style="color: #fff;text-shadow:  none;"></i>
							</span>
						</span>
						<span style="float:left;width: 18%;padding: 0 11px;">
							<input class="td_product_detail_togetther_right_quantity_num td_product_detail_togetther_right_quantity_num_{$item_acce['id_product']|escape:'htmlall':'UTF-8'}" type="number" value="1" onblur="PresMobistartqtypack(this, {$item_acce['id_product']|escape:'htmlall':'UTF-8'}, {$item_acce['quantity']|escape:'htmlall':'UTF-8'})" onkeypress="return event.charCode >= 48 && event.charCode <= 57" max="{$item_acce['quantity']|escape:'htmlall':'UTF-8'}">
						</span>
						<span class="td_product_detail_togetther_right_quantity_plus_{$item_acce['id_product']|escape:'htmlall':'UTF-8'} td_product_detail_togetther_right_quantity_plus" onclick="quantitypluspack({$item_acce['id_product']|escape:'htmlall':'UTF-8'}, {$item_acce['quantity']|escape:'htmlall':'UTF-8'})" >
							<span style="position:  absolute;left: 50%;top: 50%;font-size: 11px;transform: translate( -50%,-40%) !important;">
								<i class="fa fa-plus" style="color: #fff;text-shadow: none;"></i>
							</span>
						</span>
					</div>
				</div>
			</div>

		</div>
		{/foreach}
		<div class="ui-block-a td_total_pri_product_togetther" style="width: 100%;">
			<div style="float:left;width: 50%;">
				<div style="float:left;width:100%;">
					<span style="float:left;font-weight: 700;">{l s='Total Price:' mod='presmobileapp'}</span>
					<span style="float:left;color: #FF0033;margin-left: 4px;font-weight: 700;">{$sign_currency|escape:'htmlall':'UTF-8'}<span class="pack_total">0</span> </span>
				</div>
				<div style="float:left;width:100%;">
					<span style="float:left;font-weight: 700;">{l s='Save:' mod='presmobileapp'}</span>
					<span style="float:left;color: #FF0033;margin-left: 4px;" class="pack_save">
						-{$sign_currency|escape:'htmlall':'UTF-8'}<span class="price_pack_specal">0 </span>
						{* <span class="specific_pack">(-20%)</span> *}
					</span>
				</div>
			</div>
			{if $checkaddcart == 0}
			<div class="ui-block-c" style="width: 50%;float: left;background: #FF0033;padding: 9px;" onclick="PresMobiaddtocartpack()">
				<div class="td_product_detail_addtocart" style="float:left;width:100%;padding: 0;">
					<div style="text-align: center;color: #fff;text-shadow: none; font-size: 13px;margin-top: 2px;margin-left: 8px;">
						<span class="td_img_cart icon-iconcart"></span>
						<span style="margin-left: 3px;">{l s='Add to Cart ' mod='presmobileapp'}</span>
					</div>
				</div>
			</div>
			{/if}
		</div>
		{/if}
		<input type="hidden" name="" class="product_detail_id" data-check='{$product[0]['id_product']|escape:'htmlall':'UTF-8'}'>
		{if !empty($product_acce)}
		<input type="hidden" name="" class="product_acce_check" data-check='1'>
		{else}
		<input type="hidden" name="" class="product_acce_check" data-check='0'>
		{/if}
		{$presmobic_displayBeforeLookAtProduct nofilter} {* no escape necessary *}
		{if !empty($product_acce)}
		<div class="ui-grid-a others-product grid-product">
			<h4> {l s='Others have also bought' mod='presmobileapp'}</h4>
			{foreach from=$product_acce key=key_show item=item_show}
			<div class="ui-block-{if $key_show%2==0}a{/if}{if $key_show%2!=0}b{/if}" style="position: relative;margin-top: 10px; margin-bottom: 15px;">
				<div class="td_img_product_mobile" onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item_show['id_product']|escape:'htmlall':'UTF-8'}">
					<img src="{$item_show['link_img']|escape:'htmlall':'UTF-8'}" style="width: 100%;" alt="">
					{if isset($item_show['specific_prices']) && $item_show['specific_prices'] && isset($item_show['specific_prices']['reduction']) && $item_show['specific_prices']['reduction']}
					{if $item_show['specific_prices']['reduction_type'] == 'percentage'}
					<div class = "td_sale_off_mobile">
						<span class="price-percent-reduction">-{$item_show['specific_prices']['reduction']|escape:'htmlall':'UTF-8' * 100}%
						</span>
					</div>
					{/if}
					{/if}
					{if $item_show['on_sale'] == '1'}
					<div class="td_sale_mobile">
						<span style="text-shadow: none;">
							{l s='Sale!' mod='presmobileapp'}
						</span>
					</div>
					{/if}
				</div>
				<div class="description_product" >
					<div style="float: left;width: 100%;">
						<span class="price_sale">{$item_show['total_price']|escape:'htmlall':'UTF-8'}</span>
						{if $item_show['total_price'] != $item_show['price_new']}
						<span class="price_total">{$item_show['price_new']|escape:'htmlall':'UTF-8'}</span>
						{/if}
					</div>
					<p class="d_product">
						{$item_show['name']|escape:'htmlall':'UTF-8'}
					</p>
					{if $item_show['count_attr'] == 0}
					<div class="btn_cart_t">
						<div class="btn_cart">
							<span class="cart-title" onclick="PresMobiaddToCart({$item_show['id_product']|escape:'htmlall':'UTF-8'},'{$item_show['price']|escape:'htmlall':'UTF-8'}')">
								<div style="float:left;position:relative;left3px;">
									<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/cart.png" class="td_img_cart" alt="">
									<div class="td_cart_plus">
										<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/plus.png" class="td_img_plus" alt="">
									</div>
								</div>
								<span style="float:left;">{l s='Add To Cart' mod='presmobileapp'}</span>
							</span>
						</div>
						<div class="icon-cart_pl">
							<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/cart.png" class="td_img_cart" style="margin-top: 3px;" alt="">
							<div class="td_checked_circle">
								<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/check.png" class="td_img_check" alt="">
							</div>
						</div>
					</div>
					{/if}
					{if $item_show['count_attr'] != 0}
					<div class="btn_cart_t">
						<div class="btn_cart_attr" onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item_show['id_product']|escape:'htmlall':'UTF-8'}">
							<span class="cart-title_attr">{l s='Choose Option' mod='presmobileapp'}</span>
						</div>
					</div>
					{/if}
				</div>
			</div>
			{/foreach}
		</div>
		{/if}
		{$presmobic_displayAfterLookAtProduct nofilter} {* no escape necessary *}
		<div class="ui-grid-a">
			{$hook_displayProductTab nofilter} {* no escape necessary *}
			{$hook_displayProductTabContent nofilter} {* no escape necessary *}
		</div>
		<div class="ui-grid-a">
			<div class="ba_load_lastest presmobi_loadting_product">
				<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/ajax-loader.gif" alt="">
			</div>
		</div>
		<div data-role="footer" id="footer-detail" role="contentinfo" class=" ui-footer ui-bar-inherit td_footer_product_detail">
			<div class="ui-grid-b">
				<div class="ui-block-a footer-detail-boxshare">
					<a onclick="PresMobishare();">
						<span class="icon-pres-mobic-share-"></span>
					</a>
				</div>
				<div class="ui-block-b footer-detail-boxcomment" onclick="PresMobibamobileroutes(this)" ba-link="#comment:{$product[0]['id_product']|escape:'htmlall':'UTF-8'}">
					<span class="fa icon-pres-mobic-comment">
						<span class="" style="border-radius: 7px;text-shadow: none;width: auto;height: 15px;font-size: 10px;padding:  2px 5px;font-weight: bold;position: absolute;top: 5px;background: red;color: #fff;line-height: 1.5;">
							<span style="width: 100%;margin-top: 2px;">
								{$product[0]['count_comment']|escape:'htmlall':'UTF-8'}
							</span>
						</span>
					</span>
				</div>
				{if $checkaddcart == 0}
				<div class="ui-block-c footer-detail-boxaddtocart" onclick="PresMobiaddToCart({$product[0]['id_product']|escape:'htmlall':'UTF-8'},'{$product[0]['price']|escape:'htmlall':'UTF-8'}',1)">
					<div style="width:100%;">
						<div class="td-addtocart-icon">
							<span class="td_img_cart icon-iconcart"></span>
						{l s='Add To Cart' mod='presmobileapp'}</div>
					</div>
				</div>
				{/if}
			</div>
		</div>
		<div class="td_backgroud_dark" onclick="PresMobicencalshare();"></div>
		<div class="td_product_detail_share">
			<div class="td_product_detail_share_button">
				<div style="float: left;width: 100%;text-align: center;padding: 18px 0;">
					<a target="_blank" href="https://www.facebook.com/sharer.php?u={$url|escape:'htmlall':'UTF-8'}#product:{$product[0]['id_product']|escape:'htmlall':'UTF-8'}">
						<span class="td_product_detail_icon_footer" style="float:left;">
							<i class="fa fa-facebook-f" style="float:left;width:100%;"></i>
							<span style="font-size:  13px;float:  left;width: 100%;"> {l s='Facebook' mod='presmobileapp'}</span>
						</span>
					</a>
					<a target="_blank" href="https://twitter.com/intent/tweet?text={$product[0]['name']|escape:'htmlall':'UTF-8'} {$url|escape:'htmlall':'UTF-8'}#product:{$product[0]['id_product']|escape:'htmlall':'UTF-8'}">
						<span class="td_product_detail_icon_footer" style="float:left;">
							<i class="fa fa-twitter" style="float:left;width:100%;"></i>
							<span style="font-size:  13px;float:  left;width: 100%;"> {l s='Twitter' mod='presmobileapp'}</span>
						</span>
					</a>
					<a target="_blank" href="https://plus.google.com/share?url={$url|escape:'htmlall':'UTF-8'}#product:{$product[0]['id_product']|escape:'htmlall':'UTF-8'}">
						<span class="td_product_detail_icon_footer" style="color: #D6492F;float:left;">
							<i class="fa fa-google" style="float:left;width:100%;margin-left:3px;"></i>
							<span style="font-size:  13px;float:  left;width: 100%;"> {l s='Google' mod='presmobileapp'}</span>
						</span>
					</a>
					<a target="_blank" href="http://www.pinterest.com/pin/create/button/?url={$url|escape:'htmlall':'UTF-8'}#product:{$product[0]['id_product']|escape:'htmlall':'UTF-8'}">
						<span class="td_product_detail_icon_footer" style="color: #D6492F;float:left;">
							<i class="fa fa-pinterest" style="float:left;width:100%;"></i>
							<span style="font-size:  13px;float:  left;width: 100%;"> {l s='Pinterest' mod='presmobileapp'}</span>
						</span>
					</a>
				</div>
			</div>
			<div class="td_product_detail_share_cancel">
				<a onclick="PresMobicencalshare();">
					{l s='Cancel' mod='presmobileapp'}
				</a>
			</div>
		</div>
		<div class="ion-ios-icon-home-outline ui-widget-content" onclick="PresMobibamobileroutes(this)" ba-link="#home" id="draggable"></div>
