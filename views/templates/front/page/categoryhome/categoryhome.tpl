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
{$presmobic_displayBeforeMainCategory nofilter} {* no escape necessary *}
<div role="main" class="ui-content td_tab_category content-category">
  <div class="ui-grid-a">
    {foreach from=$category key=key item=item}
    <div class="td_tab_category_product ui-block-{if $key%2==0}a{/if}{if $key%2!=0}b{/if} category-{if $key%2==0}a{/if}{if $key%2!=0}b{/if}" onclick="PresMobibamobileroutes(this)" ba-link="#category:{$item['id_category']|escape:'htmlall':'UTF-8'}">
      <div class="category-box" style="-webkit-filter: brightness(0.60);">
        <img src="{$url|escape:'htmlall':'UTF-8'}{$item['link_img']|escape:'htmlall':'UTF-8'}" style="float: left;width: 100%;" alt="">
      </div>
      <div class="td_tab_category_product_title" >
        {$item['name']|escape:'htmlall':'UTF-8'}
      </div>
    </div>
    {/foreach}
  </div>
</div>
{$presmobic_displayAfterMainCategory nofilter} {* no escape necessary *}