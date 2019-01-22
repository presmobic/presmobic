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
{if !empty($customer_br)}
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
		<p>{$item['city']|escape:'htmlall':'UTF-8'} {$item['state']|escape:'htmlall':'UTF-8'} {$item['postcode']|escape:'htmlall':'UTF-8'}</p>
		<p>{$item['country']|escape:'htmlall':'UTF-8'}</p>
		<p>{$item['phone']|escape:'htmlall':'UTF-8'}</p>
		<p>{$item['phone_mobile']|escape:'htmlall':'UTF-8'}</p>
	</div>
</div>
{/foreach}
</div>
{/if}