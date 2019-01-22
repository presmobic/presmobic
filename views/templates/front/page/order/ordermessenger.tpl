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

<input type="hidden" name="" class="id_order_mess" value="{$id_order|escape:'htmlall':'UTF-8'}">
<div class="PresMobileorder-messenger-block-top">
  <div class="ui-grid-a">
    <h5>Product</h5>
    <div class="choose-messenger" onclick="PresMoblieShowAddressSelectPopup('popup-choose-messenger')">
     <p class="text-product">{l s='- Choice a product -' mod='presmobileapp'}</p>
   </div>
   <div class="Presmobile-select-popup popup-choose-messenger">
     <div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-choose-messenger')"></div>
     <div class="Presmobile-select-popup-block">
       <div class="Presmobile-select-popup-header">
         <h4> {l s='Choose a product to message' mod='presmobileapp'}</h4>
       </div>
       <ul class="Presmobile-select-popup-content">
        {foreach from=$products_new key=key item=itema}
        <li class="producttomessenger producttomessenger-{$key|escape:'htmlall':'UTF-8'}  clearfix" onclick="PresMoblieChangeProductToMessenger(this)" value="{$key|escape:'htmlall':'UTF-8'}">
          <span class="choose-address"></span>
          <span class="title-producttomessenger"> {$itema['name']|escape:'htmlall':'UTF-8'}</span>
        </li>
        {/foreach}
      </ul>
      <div class="ui-grid-a Presmobile-select-popup-footer">
       <div class="ui-block-a" style="width:50%;margin:0;">
         <h4 onclick="PresMoblieHideAddressSelectPopup('popup-choose-messenger')">{l s='Canel' mod='presmobileapp'}</h4>
       </div>
       <div class="ui-block-b" style="width:50%;margin:0;">
         <h4 class="apply-choose-product" onclick="PresMobileChoiceProductAddMess(this)" data-prodtomess="" >{l s='Done' mod='presmobileapp'}</h4>
       </div>
     </div>
   </div>
 </div>
</div>
</div>
<div class="PresMobileorder-messenger-block-content">
  {if !empty($message)}
  {foreach from=$message key=key1 item=item1}
  {if $item1['id_employee'] == 0}
  <div class="message-content clearfix">
    <div class="message-guests">
     <span class="message">{$item1['message']|escape:'htmlall':'UTF-8'}</span>
     <span class="time">{$item1['date_add']|escape:'htmlall':'UTF-8'}</span>
   </div>
 </div>
 {/if}
 {if $item1['id_employee'] == 1}
 <div class="message-content clearfix">
  <div class="icon-icon-shopmess"></div>
  <div class="message-admin">
   <span class="message">{$item1['message']|escape:'htmlall':'UTF-8'}</span>
   <span class="time">{$item1['date_add']|escape:'htmlall':'UTF-8'}</span>
 </div>
</div>
{/if}
{/foreach}
{/if}
</div>
<div class="PresMobileorder-messenger-block-footer">
 <input type="text" class="rep-message" placeholder="Enter a your message...">
 <div class="bottom-send-mess" onclick="PresMoblieRepMessenger({$id_order|escape:'htmlall':'UTF-8'})">{l s='Post' mod='presmobileapp'}</div>
</div>