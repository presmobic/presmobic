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
{$presmobicDisplayBeforeFeaturedBrands nofilter} {* no escape necessary *}
<div data-role="main" class="ui-content" style="padding: 0 1em;">
  <div class="ui-grid-a td_title_frature_brands">
    <h4 style="margin: 10px 0;">{l s='FEATURED BRANDS' mod='presmobileapp'}</h4>
  </div>
  <div class="feature td_feature" style="">
    <div class="td_feature_children" style="">
      {foreach from=$feature key=key_fea item=fea}
      <div class="list_feature {if $key_fea>0}list_feature_next{/if}">
        {if $fea['check'] == 1}
          {$fea['image'] nofilter} {* no escape necessary *}
        {/if}
        {if $fea['check'] == 0}
          <p style="padding: 0 10px 0 10px;line-height: 25px;">
            {$fea['name']|escape:'htmlall':'UTF-8'}
          </p>
        {/if}
      </div>
      {/foreach}
    </div>
  </div>
</div>
{$presmobicDisplayAfterFeaturedBrands nofilter} {* no escape necessary *}