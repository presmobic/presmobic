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
{if !empty($product)}
{foreach from=$product key=key_show item=item_show}
<div class="ui-block-{if $key_show%2==0}a{/if}{if $key_show%2!=0}b{/if}" style="position: relative;z-index: 1;{if $key_show%2!=0}padding: 0 0px 0 7px;{else}padding: 0 7px 0 0;{/if}margin-top: 10px; margin-bottom: 15px;">
  <div class="td_img_product_mobile" onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item_show['id_product']|escape:'htmlall':'UTF-8'}">
    <img src="{$item_show['link_img']|escape:'htmlall':'UTF-8'}" style="width: 100%;" alt="">
    {if isset($item_show['specific_prices']) && $item_show['specific_prices'] && isset($item_show['specific_prices']['reduction']) && $item_show['specific_prices']['reduction']}
    {if $item_show['specific_prices']['reduction_type'] == 'percentage'}
    <div class = "td_sale_off_mobile">
      <span class="price-percent-reduction">-{$item_show['specific_prices']['reduction']|escape:'htmlall':'UTF-8' * 100}%
      </span>
    </div>
    {/if}
    {/if}
    {if $item_show['on_sale'] == '1'}
    <div class="td_sale_mobile">
      <span style="text-shadow: none;">
        {l s='Sale!' mod='presmobileapp'}
      </span>
    </div>
    {/if}
  </div>
  <div class="description_product" >
    <div style="float: left;width: 100%;">
      <span class="price_sale">{$item_show['total_price']|escape:'htmlall':'UTF-8'}</span>
      {if $item_show['total_price'] != $item_show['price_new']}
      <span class="price_total">{$item_show['price_new']|escape:'htmlall':'UTF-8'}</span>
      {/if}
    </div>
    <p class="d_product">
      {$item_show['name']|escape:'htmlall':'UTF-8'}
    </p>
    {if $item_show['count_attr'] == 0}
    {if $checkaddcart == 0}
    <div class="btn_cart_t">
      <div class="btn_cart">
        <span class="cart-title" onclick="PresMobiaddToCart({$item_show['id_product']|escape:'htmlall':'UTF-8'},'{$item_show['price']|escape:'htmlall':'UTF-8'}')">
          <div class="icon-iconcart">
            <i class="td_cart_plus fa fa-plus-circle"></i>
          </div>
          <span style="display: block;">{l s='Add To Cart' mod='presmobileapp'}</span>
        </span>
      </div>
      <div class="icon-cart_pl {$item_show['id_product']|escape:'htmlall':'UTF-8'}" style="display: {if $item_show['checkcart'] == '1'} block {else} none {/if};">
        <img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/cart.png" class="td_img_cart" style="margin-top: 3px;" alt="">
        <div class="td_checked_circle">
          <i class="fa fa-check td_img_check"></i>
        </div>
      </div>
    </div>
    {/if}
    {/if}
    {if $item_show['count_attr'] != 0}
    <div class="btn_cart_t">
      <div class="btn_cart_attr" onclick="PresMobibamobileroutes(this)" ba-link="#product:{$item_show['id_product']|escape:'htmlall':'UTF-8'}">
        <span class="cart-title_attr">{l s='Choose Option' mod='presmobileapp'}</span>
      </div>
    </div>
    {/if}
  </div>
</div>
{/foreach}
{/if}
