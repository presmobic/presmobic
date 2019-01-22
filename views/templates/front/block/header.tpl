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
{$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
 <div data-role="header " class="ui-grid-a home-header">
  {$presmobicDisplayBeforeLogo nofilter} {* no escape necessary *}
  <div class="ui-block-a logo_modem" onclick="PresMobibamobileroutes(this)" ba-link="#home"> 
    <img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/logo.png" class="img_logo" alt="presmobic">
  </div>
  {$presmobicDisplayAfterLogo nofilter} {* no escape necessary *}
  {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
  <div class="ui-block-b content_checkout" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
    <div class="total_checkout">
      <p class="total_c">{l s='Total:' mod='presmobileapp'}</p>
      <p class="total_price">{if $bacart['price']}{$bacart['price']|escape:'htmlall':'UTF-8'}{else}0{/if}</p>
    </div>
    <div class="cart_checkout">
      <span class="total_product">{if $bacart['product_total']}{$bacart['product_total']|escape:'htmlall':'UTF-8'}{else}0{/if}</span>
      <div class="icon_checkout icon-iconbag"></div>
    </div>
  </div>
  {$presmobicDisplayAfterMiniCart nofilter} {* no escape necessary *}
</div>
{$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}