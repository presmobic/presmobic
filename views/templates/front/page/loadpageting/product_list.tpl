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
				{if $item_show['favorite'] == 1}
				<span class="icon-iconlove icon-product-love td_love_product_cate " {if $cart_check['logged']}{if $item_show['favorite']=='1'} style="color:red;" add="1" {/if}{/if} {if $cart_check['logged']}onclick="PreMobiaddFavorite({$cart_check['id_customer']|escape:'htmlall':'UTF-8'},{$item_show['id_product']|escape:'htmlall':'UTF-8'},'cate',this)"{else}onclick="PreMobisetCookie('control','#category:{$id_category_default|escape:'htmlall':'UTF-8'}'),PresMobibamobileroutes(this)" ba-link="#login"{/if}>
				</span>
				{/if}
				{if $item_show['count_attr'] == 0}
				<span class="icon-iconlove icon-product-love"></span>
				<div class="icon-cart_pl {$item_show['id_product']|escape:'htmlall':'UTF-8'}" style="display: {if $item_show['checkcart'] == '1'} block {else} none {/if};">
					<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/cart.png" class="td_img_cart" style="margin-top: 3px;" alt="">
					<div class="td_checked_circle">
						<i class="fa fa-check td_img_check"></i>
					</div>
				</div>
				{/if}
			</div>
			<div class="PresMobileproduct-rating">
				<div class="clearfix" style="width: 100%;">
					<div style="float: left;">
						<span style="text-align: center;margin: 0; font-size:13px;color:#ffcc00;" class="ion-md-icon-star"></span>
						<span style="text-align: center;margin: 0; font-size:13px;color:#ffcc00;" class="ion-md-icon-star"></span>
						<span style="text-align: center;margin: 0; font-size:13px;color:#ffcc00;" class="ion-md-icon-star"></span>
						<span style="text-align: center;margin: 0; font-size:13px;color:#ffcc00;" class="ion-md-icon-star"></span>
						<span style="text-align: center;margin: 0; font-size:13px;color:whitesmoke;" class="ion-md-icon-star"></span>
					</div>
				</div>
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
			{/if}
		</div>
	</div>
</div>
{/foreach}
{/if}