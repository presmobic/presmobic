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
<div class="prestashop-my-creditslips">
	{if empty($credit)}
	<div class="prestashop-creditslips-empty"> 
		<i class="icon-mycredit-slip"></i>
		<label>
			{l s='You have not received any credit slips.' mod='presmobileapp'}
		</label>
	</div>
	{else}
	<label class="text-creditslips"> 
		{l s='Credit slips you have received after canceled orders.' mod='presmobileapp'}
	</label>
	<ul class="prestashop-mylist-creditslips">
		{foreach from=$credit key=key item=item}
		<li class="creditslips-item">
			<div class="ui-grid-a">
				<div class="ui-block-a">{l s='Credit slips' mod='presmobileapp'}</div>
				<div class="ui-block-b">{l s='#%s' sprintf=$item['id_order_slip']|string_format:"%06d"  mod='presmobileapp'}</div>
			</div>
			<div class="ui-grid-a">
				<div class="ui-block-a">{l s='Order' mod='presmobileapp'}</div>
				<div class="ui-block-b" onclick="PresMobibamobileroutes(this)" ba-link="#orderbyid:{$item['id_order']|escape:'htmlall':'UTF-8'}">{l s='#%s' sprintf=$item['id_order']|string_format:"%06d"  mod='presmobileapp'}</div>
			</div>
			<div class="ui-grid-a">
				<div class="ui-block-a">{l s='Date issuad' mod='presmobileapp'}</div>
				<div class="ui-block-b">{$item['date']|escape:'htmlall':'UTF-8'}</div>
			</div>
			<div class="ui-grid-a credit-detail" >
				<div class="ui-block-a">{l s='Views credit slips' mod='presmobileapp'}</div>
				<div class="ui-block-b"><a data-ajax="false" href="{$url|escape:'htmlall':'UTF-8'}index.php?controller=pdf-order-slip&id_order_slip={$item['id_order_slip']|escape:'htmlall':'UTF-8'}"><i class="fa fa-download"></i>  {l s='PDF' mod='presmobileapp'}</a></div>
			</div>
		</li>
		{/foreach}
	</ul>
	{/if}
	<div class="ui-grid-a">
		<div class="ba_load_lastest presmobi_loadting_creditslips">
			<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/ajax-loader.gif" alt="">
		</div>
	</div>
</div>