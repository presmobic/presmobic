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
{foreach from=$creditslips key=key item=item}
<div class="ui-content">
	<div class="ui-grid-a">
		<div class="ui-block-a"> {l s='Credit slips' mod='presmobileapp'}</div>
		<div class="ui-block-b">{l s='#%s' sprintf=$item['id_order_slip']|string_format:"%06d"  mod='presmobileapp'}</div>
	</div>
	<div class="ui-grid-a">
		<div class="ui-block-a"> {l s='Order' mod='presmobileapp'}</div>
		<div class="ui-block-b" onclick="PresMobibamobileroutes(this)" ba-link="#orderbyid:{$item['id_order']|escape:'htmlall':'UTF-8'}">{l s='#%s' sprintf=$item['id_order']|string_format:"%06d"  mod='presmobileapp'}</div>
	</div>
	<div class="ui-grid-a">
		<div class="ui-block-a">{l s='Date issuad ' mod='presmobileapp'}</div>
		<div class="ui-block-b">{$item['date']|escape:'htmlall':'UTF-8'}</div>
	</div>
	<div class="ui-grid-a">
		<div class="ui-block-a">{l s='Views credit slips ' mod='presmobileapp'}</div>
		<div class="ui-block-b"><a data-ajax="false" href="{$url|escape:'htmlall':'UTF-8'}index.php?controller=pdf-order-slip&id_order_slip={$item['id_order_slip']|escape:'htmlall':'UTF-8'}">{l s='PDF' mod='presmobileapp'}</a></div>
	</div>
</div>
{/foreach}