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
{$presmobic_afterOrder nofilter} {* no escape necessary *}
<div class="PresMobileorder-content">
	{if !empty($order)}
	<div class="PresMobileblock-order" >
		<ul class="lists-order grid-order">
			{foreach from=$order key=key item=item}
			<li class="block-order" onclick="PresMobibamobileroutes(this)" ba-link="#orderbyid:{$item['id_order']|escape:'htmlall':'UTF-8'}">
				<div class="order-id clearfix">
					<div class="order-title">{l s='Order ID -' mod='presmobileapp'} #{$item['id_order']|escape:'htmlall':'UTF-8'}</div>
					<div class="order-status" style="background-color:{$item['order_state_color']|escape:'htmlall':'UTF-8'}">
						<i class="fa fa-heart" style="color: {$item['order_state_color']|escape:'htmlall':'UTF-8'}"></i>
						{$item['order_state']|escape:'htmlall':'UTF-8'}
					</div>      
				</div>
				<label class="order-date">{l s='Date:' mod='presmobileapp'} {$item['date_add']|escape:'htmlall':'UTF-8'}</label>
				<label class="order-quantity">{l s='Quantity:' mod='presmobileapp'} {$item['quantity']|escape:'htmlall':'UTF-8'}{l s='items' mod='presmobileapp'}</label>
				<label class="order-total-amount">Total Amount: {$item['price_total']|escape:'htmlall':'UTF-8'}</label>
				<div class="order-moreinfore clearfix">
					<p class="order-detail" onclick="PresMobibaReOrder(this)" id-order="{$item['id_order']|escape:'htmlall':'UTF-8'}"><span class="icon-ello-refresh"> </span>{l s='Reorder' mod='presmobileapp'}</p>
					{if $item['invoice'] != 0}
					<a class="link-button" href="{$url|escape:'htmlall':'UTF-8'}{if $seourl == '0'}index.php{/if}?controller=pdf-invoice&id_order={$item['id_order']|escape:'htmlall':'UTF-8'}" target="_blank" style="margin-right: 50px;">
						<span class="icon-icondowload-pdf"></span>
					</a>
					{/if}
				</div>
			</li>
			{/foreach}
		</ul>
	</div>
	{/if}
	{if empty($order)}
	<div class="PresMobileblock-order-empity">
		<span class="ion-ios-icon-order-list"></span>
		<label>
			{l s='You do not have any order?' mod='presmobileapp'}
		</label>
		<a class="PresMobileshopnow-button" href="#" onclick="PresMobibamobileroutes(this)" ba-link="#home"><span style="vertical-align: text-bottom;font-size: inherit;">{l s='Shop Now !' mod='presmobileapp'}</span></a>
	</div>
	{/if}
</div>
{$presmobic_beforeOrder nofilter} {* no escape necessary *}
<div class="ui-grid-a">
	<div class="ba_load_lastest presmobi_loadting_order">
		<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/ajax-loader.gif" alt="">
	</div>
</div>