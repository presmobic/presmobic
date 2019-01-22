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
{$presmobic_beforeDiscount nofilter} {* no escape necessary *}
<div class="prestashop-my-vouchers"">
	{if empty($discount)}
	<div class="prestashop-vouchers-empty"> 
		<span class="icon-ello-vouchers"></span>
		<label>
			{l s='You do not have any vouchers.' mod='presmobileapp'}
		</label>
	</div>
	{else}
	<ul class="prestashop-mylist-vouchers">
		{foreach from=$discount key=key item=item}
		<li class="vouchers-item">
			<div class="ui-grid-a">
				<div class="ui-block-a">{l s='Code' mod='presmobileapp'}</div>
				<div class="ui-block-b">{$item['code']|escape:'htmlall':'UTF-8'}</div>
			</div>
			<div class="ui-grid-a voucher-description">
				<div class="ui-block-a">{l s='Description' mod='presmobileapp'}</div>
				<div class="ui-block-b description-content">{$item['name']|escape:'htmlall':'UTF-8'}</div>
			</div>
			<div class="ui-grid-a">
				<div class="ui-block-a">{l s='Quantity' mod='presmobileapp'}</div>
				<div class="ui-block-b">{$item['quantity']|escape:'htmlall':'UTF-8'}</div>
			</div>
			<div class="ui-grid-a">
				<div class="ui-block-a">{l s='Value' mod='presmobileapp'}</div>
				<div class="ui-block-b">{$item['value']|escape:'htmlall':'UTF-8'}</div>
			</div>
			<div class="ui-grid-a">
				<div class="ui-block-a">{l s='Minimun' mod='presmobileapp'}</div>
				<div class="ui-block-b">{$item['minimal']|escape:'htmlall':'UTF-8'}</div>
			</div>
			<div class="ui-grid-a">
				<div class="ui-block-a">{l s='Cumulative' mod='presmobileapp'}</div>
				<div class="ui-block-b">{if $item['active'] =='1'} <span class="check"></span> Yes {else}No{/if}</div>
			</div>
			<div class="ui-grid-a">
				<div class="ui-block-a">{l s='Expiration Date' mod='presmobileapp'}</div>
				<div class="ui-block-b">{$item['date']|escape:'htmlall':'UTF-8'}</div>
			</div>
		</li>
		{/foreach}
	</ul>
	{/if}
</div>
{$presmobic_afterDiscount nofilter} {* no escape necessary *}