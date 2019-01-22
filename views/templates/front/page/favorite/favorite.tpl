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
{$presmobic_beforeFavorite nofilter} {* no escape necessary *}
<div class="PresMobilefavorite-content">
	{if !empty($product)}
	<div class="PresMobileblock-favorite">
		<div class="ui-grid-a">
			{foreach from=$product key=key item=item}
			<div class="ui-block-{if $key%2==0}a{else}b{/if} PresMobilebox-product" >
				<div class="images-favorite-box">
					<div class="box-icontrash">
						<i class="icon-icontrash" onclick="PresMobideleteFavorite({$item['id_product']|escape:'htmlall':'UTF-8'})"></i>
					</div>
					<img onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item['id_product']|escape:'htmlall':'UTF-8'}" src="{$item['link_img']|escape:'htmlall':'UTF-8'}" alt="favorite">
					{if $item['specific_prices']['reduction_type'] == 'percentage'}
					<div class = "td_sale_off_mobile">
						<span class="price-percent-reduction">-{$item['specific_prices']['reduction']|escape:'htmlall':'UTF-8' * 100}%
						</span>
					</div>
					{/if}
				</div>
				<div onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item['id_product']|escape:'htmlall':'UTF-8'}" class="price-favorite-box">
					<span class="PresMobilefavorite-price">{$item['total_price']|escape:'htmlall':'UTF-8'}</span>
					{if $item['price_tax_exc'] != $item['price_without_reduction']}
					<span class="price_total">{$item['cur_price']|escape:'htmlall':'UTF-8'}</span>
					{/if}
				</div>
				<label onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item['id_product']|escape:'htmlall':'UTF-8'}" class="PresMobilefavorite-title">{$item['name']|escape:'htmlall':'UTF-8'}</label>
			</div>
			{/foreach}
		</div>
	</div>
	<div class="favorite-popup">
		<div class="favo-bg" onclick="PreMobiClearFavoriteProductHide()"></div>
		<div class="favorite-block">
			<div class="favorite-header">
				<h4> {l s='All Delete "Favorite"?' mod='presmobileapp'}</h4>
			</div>
			<div class="favorite-content">
				{l s='Are you sure you want to all detete this Favorite? This action cannot be undone' mod='presmobileapp'}
			</div>
			<div class="ui-grid-a favorite-footer">
				<div class="ui-block-a">
					<h4 onclick="PreMobiClearFavoriteProductHide()"> {l s='Canel' mod='presmobileapp'}</h4>
				</div>
				<div class="ui-block-b">
					<h4 onclick="PresMobideleteFavorite(0,1)">{l s='Delete' mod='presmobileapp'}</h4>
				</div>
			</div>
		</div>
	</div>
	{/if}
	{if empty($product)}
	<div class="PresMobileblock-favorite-empity" >
		<span class="icon-favorite-new"></span>
		<label>
			{l s='You do not have any favorite ' mod='presmobileapp'}<br/>{l s='products.' mod='presmobileapp'}
		</label>
	</div>
	{/if}
</div>
{$presmobic_afterFavorite nofilter} {* no escape necessary *}