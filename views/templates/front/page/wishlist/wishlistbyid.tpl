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
{$presmobicBeforeWishlistById nofilter} {* no escape necessary *}
{if !empty($product)}
<input type="hidden" name="" class="id_wishlist" value="{$wishlist[0]['id_wishlist']|escape:'htmlall':'UTF-8'}">
<div class="PresMobile-wishlist-content PresMobile-wishlist-content-top">
	<div class="permalink-block">
		<h3> {l s='Permalink:' mod='presmobileapp'}</h3>
		<div class="wishlist-permalink">
			{$url|escape:'htmlall':'UTF-8'}module/blockwishlist/view?token={$wishlist[0]['token']|escape:'htmlall':'UTF-8'}
		</div>
	</div>
	<div class="permalink-sendandcopy clearfix">
		<div class="permalink-send" onclick="PresMoblieShowAddressSelectPopup('popup-permalink-send')">
			<i class="fa fa-envelope"></i> {l s='Send this wishlist' mod='presmobileapp'}
		</div>
		<button class="permalink-copy btn democlick" data-clipboard-action="copy" data-clipboard-target=".wishlist-permalink">
			<i class="fa fa-copy"></i>{l s=' Copy invite link' mod='presmobileapp'}
		</button>
	</div>
	<div class="Presmobile-select-popup popup-permalink-send">
		<div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-permalink-send')"></div>
		<div class="Presmobile-select-popup-block">
			<div class="Presmobile-select-popup-header">
				<h4> {l s='Send Wishlist "abd"' mod='presmobileapp'}</h4>
			</div>
			<ul class="Presmobile-select-popup-content">
				<li>
					<span>{l s='To:' mod='presmobileapp'}</span>
				</li>
				<li class="lists-mail">
				</li>
				<li class="box_input_wishlist">
					<input type="email" onkeyup="PresMobiRenderWishListSendPermalink(this,event)" multiple name="send_wishlist" class="filed_input_wishlist" placeholder="@gmail.com">
				</li>
			</ul>
			<div class="ui-grid-a Presmobile-select-popup-footer">
				<div class="ui-block-a">
					<h4 onclick="PresMoblieHideAddressSelectPopup('popup-permalink-send')">{l s='Close' mod='presmobileapp'}</h4>
				</div>
				<div class="ui-block-b">
					<h4 class="apply-change-billing-address" onclick="PresMoblieHideAddressSelectPopup('popup-permalink-send'),PresMobiSendWishList({$wishlist[0]['id_wishlist']|escape:'htmlall':'UTF-8'})">{l s='Send' mod='presmobileapp'}</h4>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="PresMobile-block-wishlist">
	<div class="ui-grid-a">
		<div class="ui-block-a wishlist-tab wishlist-tab-1 wishlist-tab-active" onclick="PresMobiRenderWishListTab(1)">{l s='List Products ' mod='presmobileapp'}</div>
		<div class="ui-block-b wishlist-tab wishlist-tab-2" onclick="PresMobiRenderWishListTab(2)">{l s='Bought products\' info' mod='presmobileapp'}</div>
	</div>
</div>
<div class="PresMobile-wishlist-content PresMobile-wishlist-content-second">
	<div class="wishlist-product-box wishlist-product-box-1">
		<div class="ui-grid-a">
			{foreach from=$product key=key item=item}
			<div class="ui-block-{if $key%2==0}a{else}b{/if} PresMobilebox-product">
				<div class="images-wishlist-box">
					<div class="box-icontrash">
						<i class="icon-icontrash" onclick="PresMobiSaveWishlist({$item['id_product_wishlist']|escape:'htmlall':'UTF-8'},2)"></i>
					</div>
					<img src="{$item['img']|escape:'htmlall':'UTF-8'}" alt="wishlist">
				</div>
				<label class="PresMobile-wishlist-title">{$item['name']|escape:'htmlall':'UTF-8'}</label>
				<label class="PresMobile-wishlist-title">{l s='Quantity: ' mod='presmobileapp'}</label>
				<ul class="PresMobile-wishlist-quantity">
					<li>
						<span class="quantity_wishlist_minus_{$item['id_product_wishlist']|escape:'htmlall':'UTF-8'}" onclick="PresMobiUpdateQuantityWishlistminus({$item['id_product_wishlist']|escape:'htmlall':'UTF-8'})">
							<i class="fa fa-minus"></i>	
						</span>
					</li>
					<li>
						<div>
							<input onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57 " value="{$item['quantity']|escape:'htmlall':'UTF-8'}" class="wishlist_quantity w_quantity_{$item['id_product_wishlist']|escape:'htmlall':'UTF-8'}">
						</div>
					</li>
					<li>
						<span class="quantity_wishlist_plus_{$item['id_product_wishlist']|escape:'htmlall':'UTF-8'}" onclick="PresMobiUpdateQuantityWishlistplus({$item['id_product_wishlist']|escape:'htmlall':'UTF-8'})">
							<i class="fa fa-plus"></i>	
						</span>
					</li>
				</ul>
				<div class="PresMobile-wishlist-priority">
					<label class="PresMobile-wishlist-title">{l s='Priority:' mod='presmobileapp'}</label>
					<select class="w_priority_{$item['id_product_wishlist']|escape:'htmlall':'UTF-8'}">
						{foreach from=$prioritya key=key_w item=item_w}
						<option value="{$key_w|escape:'htmlall':'UTF-8'}" {if $key_w == $item['priority']}selected{/if}>{$item_w|escape:'htmlall':'UTF-8'}</option>
						{/foreach}
					</select>
				</div>
				<div class="PresMobile-wishlist-delete-product" onclick="PresMobiSaveWishlist({$item['id_product_wishlist']|escape:'htmlall':'UTF-8'},1)">
					{l s='Save' mod='presmobileapp'}
				</div>
			</div>
			{/foreach}
		</div>
	</div>
	{if !empty($product_c)}
	<div class="wishlist-product-box wishlist-product-box-2">
		<ul>
			{foreach from=$product_c key=key item=item}
			<li onclick="PresMobibamobileroutes(this)" ba-link="#product">
				<div class="ui-grid-a">
					<div class="ui-block-a"> {l s='Product' mod='presmobileapp'}</div>
					<div class="ui-block-b">
						<img src="{$item['img']|escape:'htmlall':'UTF-8'}" alt="wishlist">
						<label class="PresMobile-wishlist-title">{$item['name']|escape:'htmlall':'UTF-8'}</label>
						<label class="PresMobile-wishlist-title">{$item['combi']|escape:'htmlall':'UTF-8'}</label>
					</div>
				</div>
				<div class="ui-grid-a">
					<div class="ui-block-a"> {l s='Quantity' mod='presmobileapp'}</div>
					<div class="ui-block-b">{$item['quantity']|escape:'htmlall':'UTF-8'}</div>
				</div>
				<div class="ui-grid-a">
					<div class="ui-block-a"> {l s='Offered by' mod='presmobileapp'}</div>
					<div class="ui-block-b">{$item['customerName']|escape:'htmlall':'UTF-8'}</div>
				</div>
				<div class="ui-grid-a">
					<div class="ui-block-a"> {l s='Date' mod='presmobileapp'}</div>
					<div class="ui-block-b">{$item['date']|escape:'htmlall':'UTF-8'}</div>
				</div>
			</li>
			{/foreach}
		</ul>
	</div>
	{/if}
</div>
{else}
<div class="PresMobile-wishlist-empity" >
	<span class="icon-favorite-heart-2"></span>
	<label>
		{l s='You do not have any wishlist' mod='presmobileapp'}
	</label>
</div>
{/if}
{$presmobicAfterWishlistById nofilter} {* no escape necessary *}