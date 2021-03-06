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

{$presmobic_beforeAddress nofilter} {* no escape necessary *}
<div class="ui-gird-a presmobile-addnewcustomer-address" onclick="PreMobisetCookie('control','#myaddressbycustomer'),PresMobibamobileroutes(this)" ba-link="#checkoutaddress">
	<span class="icon-addnew-address">+</span>{l s='Add a new address' mod='presmobileapp'}
</div>
<div class="ui-content grid-myaddressbycustomer">
	{if empty($customer_br)}
	<div class="prestashop-myaddressbycustomer-empty"> 
		<i class="icon-ello-my-address"></i>
		<label>
			{l s='No addresses are available.' mod='presmobileapp'}
		</label>
	</div>
	{else}
	{foreach from=$customer_br key=key item=item}
	<div class="ui-gird-a lists-custom-address address-{$item['id_address']|escape:'htmlall':'UTF-8'}">
		<div class="address-item">
			<div class="presmobile-myaddcustom-lastname clearfix">
				<h4>{$item['alias']|escape:'htmlall':'UTF-8'}</h4>
				<div class="edit-delete-customname">
					<span class="icon-ello-icon-pent" onclick="PreMobisetCookie('control','#myaddressbycustomer'),PresMobibamobileroutes(this)" ba-link="#checkoutaddress:{$item['id_address']|escape:'htmlall':'UTF-8'}"></span>
 					<span class="icon-icontrash" delete-data="{$item['id_address']|escape:'htmlall':'UTF-8'}" onclick="PresMoblieApplyDeleteMyAddress(this)"></span>
				</div>
			</div>
			<p>{$item['lastname']|escape:'htmlall':'UTF-8'} {$item['firstname']|escape:'htmlall':'UTF-8'}</p>
			<p>{$item['company']|escape:'htmlall':'UTF-8'}</p>
			<p>{$item['address1']|escape:'htmlall':'UTF-8'} {$item['address2']|escape:'htmlall':'UTF-8'}</p>
			<p>{$item['country']|escape:'htmlall':'UTF-8'}</p>
			<p>{$item['phone']|escape:'htmlall':'UTF-8'}</p>
			<p>{$item['phone_mobile']|escape:'htmlall':'UTF-8'}</p>
		</div>
	</div>
	{/foreach}
	<div class="Presmobile-select-popup popup-delete-myaddress">
		<div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-delete-myaddress')"></div>
		<div class="Presmobile-select-popup-block">
			<div class="Presmobile-select-popup-header">
				<h4>{l s='Are you sure you want to delete this  address.' mod='presmobileapp'}</h4>
			</div>
			<div class="Presmobile-select-popup-content">
			</div>
			<div class="ui-grid-a Presmobile-select-popup-footer">
				<div class="ui-block-a">
					<h4 onclick="PresMoblieHideAddressSelectPopup('popup-delete-myaddress')">{l s='Cancel' mod='presmobileapp'}</h4>
				</div>
				<div class="ui-block-b">
					<h4 class="apply-delete-address" onclick="PresMoblieHideAddressSelectPopup('popup-delete-myaddress')">{l s='Delete' mod='presmobileapp'}</h4>
				</div>
			</div>
		</div>
	</div>
</div>
{/if}
{$presmobic_afterAddress nofilter} {* no escape necessary *}
<div class="ui-grid-a">
	<div class="ba_load_lastest presmobi_loadting_myaddressbycustomer">
		<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/ajax-loader.gif" alt="">
	</div>
</div>
