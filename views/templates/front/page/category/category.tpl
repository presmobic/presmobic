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
{$presmobic_displayBeforeCategory nofilter} {* no escape necessary *}
<div onclick="PreMobileCategoryHideSearch(this)" class="td_backgroud_dark"></div>

<div class="ui-grid-c presmobile-category-filter-fixed">
	<input type="hidden" name="" class="presmobi-check-category" data-check="1">
	<input type="hidden" name="" class="presmobi-id-category" data-check="{$id_category_default|escape:'htmlall':'UTF-8'}">
	{if !empty($sub_leve)}
	{$presmobic_displayBeforeSubCategoryBar nofilter} {* no escape necessary *}
	<div class="ui-block-a premobile-category-filter premobile-category-filter-category" style="padding: 12px 0px 4px 1em!important;" onclick="PresMobicategorysearch(this,'category')">
		<label class="label-category" style="float:left;">{l s='Sub Category' mod='presmobileapp'}</label>
		<i class="fa fa-caret-right menu-category">
		</i>
	</div>
	{/if}
	{$presmobic_displayBeforeFilterBar nofilter} {* no escape necessary *}
	<div class="ui-block-b premobile-category-filter premobile-category-filter-filter" style="padding: 12px 0px 4px 1em!important;" onclick="PresMobicategorysearch(this,'filter')">
		<label class="label-category" style="float:left;">{l s='Filter' mod='presmobileapp'}</label>
		<i class="fa fa-caret-right menu-category">
		</i>
	</div>
	{$presmobic_displayBeforeSortBar nofilter} {* no escape necessary *}
	<div class="ui-block-c premobile-category-filter premobile-category-filter-sort" style="padding: 12px 0px 4px 1em;" onclick="PresMobicategorysearch(this,'sort')">
		<label class="label-category" style="float:left;">{l s='Sort' mod='presmobileapp'}</label>
		<i class="fa fa-caret-right menu-category">
		</i>
	</div>
	{$presmobic_displayBeforeLayoutBar nofilter} {* no escape necessary *}
	<div class="ui-block-d premobile-category-filter" style="padding-top: 12px;float:right;padding-right: 13px; text-align: right; padding-left: 0;">
		<span class="icon-iconsort1 content-grid" style="color: #666666;font-size: 16px;" onclick="PresMobiproductList(this,2)"></span>
		<span class="icon-iconsortlist content-grid" style="color: #989898;font-size: 16px;" onclick="PresMobiproductList(this,1)"></span>
	</div>
</div>
<div class="ui-grid-a premobile-category-search r-category td_sub_category_tab_category" style="display: none;float: left;width: 100%;color: #000;">
	{foreach from=$sub_leve key=key item=item}
	<div class="ui-block-a" onclick="PresMobibamobileroutes(this)" ba-link="#category:{$item['id_category']|escape:'htmlall':'UTF-8'}">{$item['name']}</div>
	{/foreach}
</div>
<div class="premobile-category-search r-filter" style="padding: 0 1em;display: none;margin-top: 36px;">
	<div class="ui-grid-a " style=" border-bottom: 1px #e4e4e4 solid;">
		<div onclick="premobileappOpen(this,'color')" style="float: left;width: 100%;padding-top: 3px;">
			<p class="premobile-attibute-title"  >{l s='Color' mod='presmobileapp'}</p>
			<i class="fa fa-angle-up" style="width: fit-content;float: right;margin-top: -30px;display: none;"></i>
			<i class="fa fa-angle-down" style="width: fit-content;float: right;margin-top: -30px;"></i>
		</div>
		<div class="ui-grid-a acitve-attribute" style="display: none;float: left;width: 100%;margin: 0 0 10px 0;">
			{foreach from=$attribute key=key_a item=item_a}
			{if $key_a == '3'}
			{foreach from=$item_a key=key_b item=item_b}
			<div class="ui-block-{if $key_b%2==0}a{/if}{if $key_b%2!=0}b{/if} td_checkbox_tab_category">
				<label class="container">
					<label for="checkbox-v-{$item_b['id_attribute']|escape:'htmlall':'UTF-8'}">{$item_b['name']|escape:'htmlall':'UTF-8'}</label>
					<input type="checkbox" name="category-color" id="checkbox-v-{$item_b['id_attribute']|escape:'htmlall':'UTF-8'}"  value="{$item_b['id_attribute']|escape:'htmlall':'UTF-8'}" class="category-color presmobi-category-check"
					{if !empty(checkbox_color_array)}
					{foreach from=$checkbox_color_array item=foo}
					{if ($foo == $item_b['id_attribute'])}
					checked=""
					{/if}
					{/foreach}
					{/if}
					>
					<span class="checkmark"></span>
				</label>
			</div>
			{/foreach}
			{/if}
			{/foreach}
		</div>
	</div>
	<div class="ui-grid-a" style=" border-bottom: 1px #e4e4e4 solid;" >
		<div  onclick="premobileappOpen(this,'size')" style="float: left;width: 100%;">
			<p  class="premobile-attibute-title">{l s='Size' mod='presmobileapp'}</p>
			<i class="fa fa-angle-up" style="width: fit-content;float: right;margin-top: -30px;display: none;"></i>
			<i class="fa fa-angle-down" style="width: fit-content;float: right;margin-top: -30px;"></i>
		</div>
		<div class="ui-grid-a acitve-attribute" style="display: none;float:left;width:100%;margin: 0 0 10px 0;">
			{foreach from=$attribute key=key_a item=item_a}
			{if $key_a == '1'}
			{foreach from=$item_a key=key_b item=item_b}
			<div class="ui-block-{if $key_b%2==0}a{/if}{if $key_b%2!=0}b{/if} td_checkbox_tab_category">
				<label class="container">
					<input type="checkbox" name="category-size" id="checkbox-v-{$item_b['id_attribute']|escape:'htmlall':'UTF-8'}"  value="{$item_b['id_attribute']|escape:'htmlall':'UTF-8'}" class="category-size presmobi-category-check" 
					{if !empty(checkbox_size_array)}
					{foreach from=$checkbox_size_array item=foo}
					{if ($foo == $item_b['id_attribute']|escape:'htmlall':'UTF-8')}
					checked=""
					{/if}
					{/foreach}
					{/if} >
					<label for="checkbox-v-{$item_b['id_attribute']|escape:'htmlall':'UTF-8'}">{$item_b['name']|escape:'htmlall':'UTF-8'}</label>
					<span class="checkmark"></span>
				</label>
			</div>
			{/foreach}
			{/if}
			{/foreach}
		</div>
	</div>
	<div class="ui-grid-a" style="border-bottom: 1px #e4e4e4 solid; ">
		<div class="block-rangeprice" onclick="premobileappOpen(this,'rangeprice')" style="float: left;width: 100%;padding-top: 3px;">
			<p style="float: left;font-size:13px;line-height:1;">{l s='Price Range: ' mod='presmobileapp'} </p>
			<div style="float:left;margin: 13px 0.2em;line-height:1;font-size: 13px;">
				<span style="width: fit-content;" class="rangemin">{if ($rangemin != 0)} {$rangemin|escape:'htmlall':'UTF-8'} {else} 0 {/if}-</span>
				<span style="width: fit-content;" class="rangemax">{if ($rangemax != 0)} {$rangemax|escape:'htmlall':'UTF-8'} {else} {$pricemax|escape:'htmlall':'UTF-8'} {/if} </span>
				<span>{$sign|escape:'htmlall':'UTF-8'}</span>
			</div>
			<div style="float:right;margin: 11px 0;">
				<i class="fa fa-angle-up" style="width: fit-content;float: right;display: none;"></i>
				<i class="fa fa-angle-down" style="width: fit-content;float: right;"></i>
			</div>
		</div>
		<div class="ui-grid-a acitve-attribute" style="display: block;float:left;width:100%;">
			<div class="ui-field-contain">
				<div data-role="rangeslider" id="range-slider" data-mini="true">
					<input name="range-4a" style="display:none;" class="td_slider_tab_category" id="range-4a" min="0" max="{if !empty($pricemax)} {$pricemax|escape:'htmlall':'UTF-8'}{/if}" value="{if ($rangemin != 0)}{$rangemin|escape:'htmlall':'UTF-8'}{else}0{/if}" type="range" onchange="rangemin(this)"/>
					<input name="range-4b" style="display:none;" class="td_slider_tab_category" id="range-4b" min="0" max="{if !empty($pricemax)} {$pricemax|escape:'htmlall':'UTF-8'}{/if}" value="{if ($rangemax != 0)}{$rangemax|escape:'htmlall':'UTF-8'}{else}{$pricemax|escape:'htmlall':'UTF-8'}{/if}" type="range" onchange="rangemax(this)" />
				</div>
			</div>
		</div>
	</div>
	<div data-role="footer" role="contentinfo" class=" ui-footer footer-category ui-bar-inherit" style="text-shadow: none;font-size: 13px;background: white;position: fixed;text-transform: uppercase;left:0;z-index: 999999;bottom:  0px;width: 100%;display: none;">
		<div class="ui-grid-a">
			<div class="ui-block-a" style="text-align: center; line-height: 43px;" onclick="PresMobiresertfilter()">
				{l s='RESET' mod='presmobileapp'}
			</div>
			<div class="ui-block-b" style="text-align:  center;line-height: 43px;background: red;color: white;" onclick="PresMobibamobileroutes(this,'search-catehory')" ba-link="#category:{$id_category_default|escape:'htmlall':'UTF-8'}">
				{l s='Done' mod='presmobileapp'}
			</div>
		</div>
	</div>
</div>
<div class="premobile-category-search r-sort" style="display: none;position: fixed;width: 100%;z-index: 9999;background: #fff;top: 81px;">
	<div class="ui-grid-a" style="border-bottom: 1px #ffefef solid;padding: 1em;">
		{foreach from=$basort key=key_sort item=item_sort}
		<div style="margin: 7px 0;" class="ui-block-a robb-category-sort {if $id_sort == $key_sort} active-category-sort {/if}" onclick="PresMobiCategoryShort(this),PresMobibamobileroutes(this)" ba-link="#category:{$id_category_default|escape:'htmlall':'UTF-8'}" data-sort="{$key_sort|escape:'htmlall':'UTF-8'}">
			<span><i class="sort-checked"></i></span>
			<a class="td_category_tab_item_sort" style="font-size: 13px;margin-left:20px;">{$item_sort|escape:'htmlall':'UTF-8'}</a>
		</div>
		{/foreach}
	</div>
</div>
<div class="content content-producta content-product-2">
	<div class="ui-grid-a grid-category-2"  {if empty($product)}style="font-size:13px;text-align: center;padding-top: 40%;height: 50vh;color:#858585;"{/if}>
		{if empty($product)}{l s='Product not found' mod='presmobileapp'}{/if}
		{if !empty($product)}
		{foreach from=$product key=key_show item=item_show}
		<div class="ui-block-{if $key_show%2==0}a{/if}{if $key_show%2!=0}b{/if}"  style="position: relative;z-index: 1;">
			<div class="td_img_product_mobile" onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item_show['id_product']|escape:'htmlall':'UTF-8'}">
				<img src="{$item_show['link_img']|escape:'htmlall':'UTF-8'}" style="width: 100%;" alt="">
				{if isset($item_show['specific_prices']) && $item_show['specific_prices'] && isset($item_show['specific_prices']['reduction']) && $item_show['specific_prices']['reduction']}
				{if $item_show['specific_prices']['reduction_type'] == 'percentage'}
				<div class = "td_sale_off_mobile">
					<span class="price-percent-reduction" style="text-shadow: none;">-{$item_show['specific_prices']['reduction']|escape:'htmlall':'UTF-8' * 100}%
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
					<span class="price_sale" style="font-size:14px;">{$item_show['total_price']|escape:'htmlall':'UTF-8'}</span>
					{if $item_show['total_price'] != $item_show['price_new']}
					<span class="price_total" style="font-size: 11px;">{$item_show['price_new']|escape:'htmlall':'UTF-8'}</span>
					{/if}
				</div>
				<p class="d_product">
					{$item_show['name']|escape:'htmlall':'UTF-8'}
				</p>
				{if $item_show['count_attr'] == 0}
				<div class="btn_cart_t">
					<div class="btn_cart">
						<span class="cart-title" onclick="PresMobiaddToCart({$item_show['id_product']|escape:'htmlall':'UTF-8'},'{$item_show['price']|escape:'htmlall':'UTF-8'}')">
							<div class="icon-iconcart">
								<i class="td_cart_plus fa fa-plus-circle"></i>
							</div>
							<span style="display: block;">{l s='Add To Cart' mod='presmobileapp'}</span>
						</span>
					</div>
					<div class="icon-cart_pl {$item_show['id_product']|escape:'htmlall':'UTF-8'}" style="display: {if $item_show['checkcart'] == '1'} block {else} none {/if};">
						<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/cart.png" class="td_img_cart" style="margin-top: 3px;" alt="">
						<div class="td_checked_circle">
							<i class="fa fa-check td_img_check"></i>
						</div>
					</div>
				</div>
				{/if}
				{if $item_show['count_attr'] != 0}
				<div class="btn_cart_t">
					<div class="btn_cart_attr" onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item_show['id_product']|escape:'htmlall':'UTF-8'}">
						<span class="cart-title_attr">{l s='Choose Option' mod='presmobileapp'}</span>
					</div>
					<div class="icon-cart_pl {$item_show['id_product']|escape:'htmlall':'UTF-8'}" style="display: {if $item_show['checkcart'] == '1'} block {else} none {/if};">
						<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/cart.png" class="td_img_cart" style="margin-top: 3px;" alt="">
						<div class="td_checked_circle">
							<i class="fa fa-check td_img_check"></i>
						</div>
					</div>
				</div>
				<div class="btn_cart_t">
					{$hook_displayProductListFunctionalButtons nofilter} {* no escape necessary *}
				</div>
				{/if}
			</div>
		</div>
		{/foreach}
		{/if}
	</div>
	<div class="ui-grid-a">
		<div class="ba_load_lastest presmobi_loadting_2">
			<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/ajax-loader.gif" alt="">
		</div>
	</div>
</div>
<div class="content content-producta content-product-1 grid-category-1" {if empty($product)}style="font-size:13px;text-align: center;padding-top: 40%;color:#858585;"{/if}>
	{if empty($product)}Product not found{/if}
	{if !empty($product)}
	{foreach from=$product key=key_show item=item_show}
	<div class="ui-grid-a" style="border-bottom: 1px #aeaeae solid;">
		<div class="ui-block-a" style="position: relative;z-index: 1;">
			<div class="td_img_product_mobile" onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item_show['id_product']|escape:'htmlall':'UTF-8'}" >
				<img src="{$item_show['link_img']|escape:'htmlall':'UTF-8'}" style="width: 100%;" alt="">
				{if isset($item_show['specific_prices']) && $item_show['specific_prices'] && isset($item_show['specific_prices']['reduction']) && $item_show['specific_prices']['reduction']}
				{if $item_show['specific_prices']['reduction_type'] == 'percentage'}
				<div class = "td_sale_off_mobile">
					<span class="price-percent-reduction" style="text-shadow: none;">-{$item_show['specific_prices']['reduction']|escape:'htmlall':'UTF-8' * 100}%
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
		</div>
		<div class="ui-block-b">
			<div class="description_product" >
				<div style="float: left;width: 100%;">
					<span class="price_sale">{$item_show['total_price']|escape:'htmlall':'UTF-8'}</span>
					{if $item_show['total_price'] != $item_show['price_new']}
					<span class="price_total">{$item_show['price_new']|escape:'htmlall':'UTF-8'}</span>
					{/if}
					{if $item_show['product_favorite'] == 1}
					<span class="icon-iconlove icon-product-love td_love_product_cate{$item_show['id_product']|escape:'htmlall':'UTF-8'} 1" {if $cart_check['logged']}{if $item_show['favorite']=='1'} style="color:red;" add="1" {/if}{/if} {if $cart_check['logged']}onclick="PreMobiaddFavorite({$cart_check['id_customer']|escape:'htmlall':'UTF-8'},{$item_show['id_product']|escape:'htmlall':'UTF-8'},'cate',this)"{else}onclick="PreMobisetCookie('control','#category:{$id_category_default|escape:'htmlall':'UTF-8'}'),PresMobibamobileroutes(this)" ba-link="#login"{/if}>
						{/if}
					</span>
					{if $item_show['count_attr'] == 0}
					<div class="icon-cart_pl {$item_show['id_product']|escape:'htmlall':'UTF-8'}" style="display: {if $item_show['checkcart'] == '1'} block {else} none {/if};">
						<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/cart.png" class="td_img_cart" style="margin-top: 3px;" alt="">
						<div class="td_checked_circle">
							<i class="fa fa-check td_img_check"></i>
						</div>
					</div>
					{/if}
				</div>
				{if  $item_show['comment'] != '0'}
				<div class="PresMobileproduct-rating">
					<div class="clearfix" style="width: 100%;">
						<div style="float: left;">
							{for $foo=1 to 5}
							<span style="text-align: center;margin: 0; font-size:13px;{if $foo <= $item_show['comment']}color:#ffcc00; {/if}{if $foo > $item_show['comment']}color: whitesmoke;{/if}" class="ion-md-icon-star"></span>
							{/for}
						</div>
					</div>
				</div>
				{/if}
				<p class="d_product">
					{$item_show['name']|escape:'htmlall':'UTF-8'}
				</p>
				{if $item_show['count_attr'] == 0}
				<div class="btn_cart_t">
					<div class="btn_cart">
						<span class="cart-title" onclick="PresMobiaddToCart({$item_show['id_product']|escape:'htmlall':'UTF-8'},'{$item_show['price']|escape:'htmlall':'UTF-8'}')">
							<div class="icon-iconcart">
								<i class="td_cart_plus fa fa-plus-circle"></i>
							</div>
							<span style="display: block;">{l s='Add To Cart' mod='presmobileapp'}</span>
						</span>
					</div>
				</div>
				{/if}
				{if $item_show['count_attr'] != 0}
				<ul class="category-attribute">
					{if !empty($item_show['attribute2'])}
					{foreach from=$item_show['attribute2'] key=key_attr item=item_attr}
					<li class="attribute-box">
						<span>{$key_attr|escape:'htmlall':'UTF-8'}: </span>
						<span class="category-attrivalue">{$item_attr|escape:'htmlall':'UTF-8'} </span>
					</li>
					{/foreach}
					{/if}
				</ul>
				<div class="btn_cart_t" onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item_show['id_product']|escape:'htmlall':'UTF-8'}">
					<div class="btn_cart_attr">
						<span class="cart-title_attr">{l s='Choose Option' mod='presmobileapp'}</span>
					</div>
				</div>
				<div class="btn_cart_t">
					{$hook_displayProductListFunctionalButtons nofilter} {* no escape necessary *}
				</div>
				{/if}
			</div>
		</div>
	</div>
	{/foreach}
	{/if}
</div>
<div class="ui-grid-a">
	<div class="ba_load_lastest presmobi_loadting_1">
		<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/ajax-loader.gif" alt="">
	</div>
</div>
{$presmobic_displayAfterCategory nofilter} {* no escape necessary *}
