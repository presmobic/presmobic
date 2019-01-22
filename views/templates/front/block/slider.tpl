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
{$presmobicDisplayBeforeSlider nofilter} {* no escape necessary *}
<div data-role="main" class="ui-content banner_1 home-slider">
	<div class="owl-carousel owl-theme">
		{foreach from=$infor key=key item=value}
		<div class="item" {if !empty($value['url_images'])} onclick="window.open('{$value['url_images']|escape:'htmlall':'UTF-8'}')" {/if}>
			<img src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/{$value['images']|escape:'htmlall':'UTF-8'}" style="width: 100%;" alt="">
		</div>
		{/foreach}
	</div>
</div>
{$presmobicDisplayAfterSlider nofilter} {* no escape necessary *}