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
<div class="prestashop-my-merchandisereturns">
	{if empty($return)}
	<div class="prestashop-merchandisereturns-empty"> 
		<i class="icon-ello-merchandise-returns"></i>
		<label>
			{l s='You have no ' mod='presmobileapp'}<br/>{l s='merchandise return authorizations.' mod='presmobileapp'}
		</label>
	</div>
	{else}
	<ul class="prestashop-mylist-merchandisereturns">
		{foreach from=$return key=key item=item}
		<li class="merchandisereturns-item">
			<div class="ui-grid-a">
				<div class="ui-block-a">{l s='Return' mod='presmobileapp'}</div>
				<div class="ui-block-b">{l s='#%s' sprintf=$item['id_order_return']|string_format:"%06d"  mod='presmobileapp'}</div>
			</div>
			<div class="ui-grid-a">
				<div class="ui-block-a">{l s='Order' mod='presmobileapp'}</div>
				<div class="ui-block-b" onclick="PresMobibamobileroutes(this)" ba-link="#orderbyid:{$item['id_order']|escape:'htmlall':'UTF-8'}">{$item['reference']|escape:'htmlall':'UTF-8'}</div>
			</div>
			<div class="ui-grid-a">
				<div class="ui-block-a">{l s='Package status' mod='presmobileapp'}</div>
				<div class="ui-block-b"> 
					<p class="order-status">{$item['state_name']|escape:'htmlall':'UTF-8'}</p>
				</div>
			</div>
			<div class="ui-grid-a">
				<div class="ui-block-a">{l s='Date issued' mod='presmobileapp'}</div>
				<div class="ui-block-b">{$item['date']|escape:'htmlall':'UTF-8'}</div>
			</div>
			<div class="ui-grid-a merchandisereturns-detail" >
				<div class="ui-block-a">{l s='Return slips' mod='presmobileapp'}</div>
				<div class="ui-block-b">{if $item['state'] == '2'}<a data-ajax="false" href="{$url|escape:'htmlall':'UTF-8'}?controller=pdf-order-return&id_order_return={$item['id_order_return']|escape:'htmlall':'UTF-8'}"><i class="fa fa-download"></i> {l s='PDF' mod='presmobileapp'}</a>{else}--{/if}</div>
			</div>
		</li>
		{/foreach}
	</ul>
	{/if}
</div>