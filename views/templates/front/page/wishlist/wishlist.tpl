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
{$presmobic_beforeWishlist nofilter} {* no escape necessary *}
{if !empty($wishlist) }
<div class="ui-gird-a presmobile-addnewcustomer-address" onclick="PresMoblieShowAddressSelectPopup('popup-addnew-wistlist')">
	<span class="icon-addnew-address">+</span> {l s='Add new list ' mod='presmobileapp'}
</div>
<div class="Presmobile-select-popup popup-addnew-wistlist">
	<div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-addnew-wistlist')"></div>
	<div class="Presmobile-select-popup-block">
		<div class="Presmobile-select-popup-header">
			<h4>{l s='Create a new Wishlist ' mod='presmobileapp'}</h4>
		</div>
		<div class="Presmobile-select-popup-content">
			<input type="text" name="wishlist" class="add_wishlist" placeholder="Enter new wishlist name here...">
		</div>
		<div class="ui-grid-a Presmobile-select-popup-footer">
			<div class="ui-block-a">
				<h4 onclick="PresMoblieHideAddressSelectPopup('popup-addnew-wistlist')"> {l s='Close' mod='presmobileapp'}</h4>
			</div>
			<div class="ui-block-b">
				<h4 class="apply-change-billing-address" onclick="PresMoblieHideAddressSelectPopup('popup-addnew-wistlist'),PresMobiaddWishlist()"> {l s='Save' mod='presmobileapp'}</h4>
			</div>
		</div>
	</div>
</div>
<ul class="prestashop-mylist-wishlists">
	{foreach from=$wishlist key=key item=item}
	<li class=" a wishlists_item wishlist_{$item['id_wishlist']|escape:'htmlall':'UTF-8'}">
		<div class="ui-grid-a">
			<div class="ui-block-a"> {l s='Name' mod='presmobileapp'}</div>
			<div class="ui-block-b">{$item['name']|escape:'htmlall':'UTF-8'}</div>
		</div>
		<div class="ui-grid-a">
			<div class="ui-block-a"> {l s='Qty' mod='presmobileapp'}</div>
			<div class="ui-block-b">{$item['quantity']|escape:'htmlall':'UTF-8'}</div>
		</div>
		<div class="ui-grid-a">
			<div class="ui-block-a"> {l s='Viewed' mod='presmobileapp'}</div>
			<div class="ui-block-b">{if $item['counter']}{$item['counter']|escape:'htmlall':'UTF-8'}{else}0{/if}</div>
		</div>
		<div class="ui-grid-a">
			<div class="ui-block-a"> {l s='Created' mod='presmobileapp'}</div>
			<div class="ui-block-b">{$item['date']|escape:'htmlall':'UTF-8'}</div>
		</div>
		<div class="ui-grid-a">
			<div class="ui-block-a">{l s='Direct link ' mod='presmobileapp'}</div>
			<div class="ui-block-b" onclick="PresMobibamobileroutes(this)" ba-link="#mywishlistbyid:{$item['id_wishlist']|escape:'htmlall':'UTF-8'}">
				<span class="icon-ello-eye"></span>{l s='View product' mod='presmobileapp'}
			</div>
		</div>
		<div class="ui-grid-a">
			<div class="ui-block-a">
				<input type="radio" name="Default" class="check_default" value="{$item['id_wishlist']|escape:'htmlall':'UTF-8'}" {if $item['default']=='1'}checked{/if} onclick="PresMobiUpdateWishList({$item['id_wishlist']|escape:'htmlall':'UTF-8'})">
				<span class="wishlist_default">
					<div></div>
				</span>
				<label> {l s='Default' mod='presmobileapp'}</label>
			</div>
			<div class="ui-block-b">
				<div class="delete-wishlist-item">
					<i class="icon-icontrash" onclick="PresMobiDeleteWishList({$item['id_wishlist']|escape:'htmlall':'UTF-8'})"></i>
				</div>
			</div>
		</div>
	</li>
	{/foreach}
</ul>
{/if}
{$presmobic_afterWishlist nofilter} {* no escape necessary *}