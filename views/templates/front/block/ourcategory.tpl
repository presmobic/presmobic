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
{$presmobicDisplayBeforeOurCategories nofilter} {* no escape necessary *}
<div data-role="main" class="ui-content ourcategory-content" style="clear: left;padding: 0 0 16px 0;">
  <div class="ui-grid-a" style="padding: 0 16px;">
    <div class="td_title_category">
      <h4 class="text" style="margin-bottom: 10px;">{l s='OUR CATEGORIES' mod='presmobileapp'}</h4>
    </div>
  </div>
  <div class="ourcategory td_our_category">
    <div class="td_our_category_chil">
      {foreach from=$data key=key item=item}
      <div class="ourcategory-item {if $key>0}list_feature_next{/if}">
        <div style="float:left;position:relative;text-align: center;width:142px;height:98px;" onclick="PresMobibamobileroutes(this)" ba-link="#category:{$item['id_category']|escape:'htmlall':'UTF-8'}">
          <div class="ourcategory-bg"></div>
          <img src="{$url|escape:'htmlall':'UTF-8'}{$item['link_img']|escape:'htmlall':'UTF-8'}" alt="our category">
          <p>{$item['name']|escape:'htmlall':'UTF-8'}</p>
        </div>
      </div>
      {/foreach}
    </div>
  </div>
</div>
{$presmobicDisplayAfterOurCategories nofilter} {* no escape necessary *}