{*
* 2007-2019 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author Buy Addons Team <hatt@buy-addons.com>
*  @copyright  2017-2019 Buy Addons Team
*  @version  Release: $Revision$
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{$presmobicDisplayBeforeOurClients nofilter} {* no escape necessary *}
<div data-role="main" class="PresMobilehome-comment" id="ba_touchmove" >
	<div class="content-coment" style="">
		<h4 class="td_title_comment" style="text-shadow:none;font-weight: normal;"> {l s='WHAT\'S CLIENT SAY?' mod='presmobileapp'}</h4>
		<div class="owl-carousel owl-theme">
			{foreach from=$data key=key item=item}
			<div class="item">
				<p class="">"{$item['content']|escape:'htmlall':'UTF-8'}".</p>
				<p class="PresMobilecomment-authod">{$item['customer_name']|escape:'htmlall':'UTF-8'} | {$item['cal_m']|escape:'htmlall':'UTF-8'} {l s='ago.' mod='presmobileapp'}</p>
				<div class="PresMobilecomment-ratting">
					{for $foo=1 to 5}
					<span style="text-shadow:none;text-align: center;margin: 0;{if $foo <= $item['grade']}color:#ffcc00;{else}color:#fff;{/if}" class="ion-md-icon-star"></span>
					{/for}
				</div>
			</div>
			{/foreach}
		</div>
	</div>
</div>
{$presmobicDisplayAfterOurClients nofilter} {* no escape necessary *}