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
<section id="checkout-payment-step" class="checkout-step -reachable -current js-current-step">
  {if $version_mobi >= '1.7'}
  <link rel="stylesheet" href="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/css/style-for-ver1.7.css">
  <div class="payment-options">
    {foreach from=$payment_options item="module_options"}
    {foreach from=$module_options item="option"}
    <div class="payment-items">
      <div id="{$option.id|escape:'htmlall':'UTF-8'}-container" class="payment-option clearfix">
        {* This is the way an option should be selected when Javascript is enabled *}
        <span class="custom-radio float-xs-left">
          <input
          onclick="selectpayment17('{$option.id|escape:'htmlall':'UTF-8'}')"
          class="ps-shown-by-js {if $option.binary} binary {/if}"
          id="{$option.id|escape:'htmlall':'UTF-8'}"
          data-module-name="{$option.module_name|escape:'htmlall':'UTF-8'}"
          name="payment-option"
          type="radio"
          required
          >
          <span></span>
        </span>
        {* This is the way an option should be selected when Javascript is disabled *}
        <form method="GET" class="ps-hidden-by-js">
          {if $option.id === $selected_payment_option}
          {l s='Selected' mod='presmobileapp'}
          {else}
          <button class="ps-hidden-by-js" type="submit" name="select_payment_option" value="{$option.id|escape:'htmlall':'UTF-8'}">
            {l s='Choose' mod='presmobileapp'}
          </button>
          {/if}
        </form>

        <label for="{$option.id|escape:'htmlall':'UTF-8'}">
          <span>{$option.call_to_action_text|escape:'htmlall':'UTF-8'}</span>
          {if $option.logo}
          <img src="{$option.logo|escape:'htmlall':'UTF-8'}" alt="">
          {/if}
        </label>

      </div>
    </div>

    {if $option.additionalInformation}
    <div
    id="{$option.id|escape:'htmlall':'UTF-8'}-additional-information"
    class="js-additional-information definition-list additional-information{if $option.id != $selected_payment_option} ps-hidden {/if}"
    >
    {$option.additionalInformation nofilter} {* no escape necessary *}
  </div>
  {/if}

  <div style="display: none;" 
  id="pay-with-{$option.id|escape:'htmlall':'UTF-8'}-form"
  class="js-payment-option-form {if $option.id != $selected_payment_option} ps-hidden {/if}"
  >
  {if $option.form}
  {$option.form nofilter} {* no escape necessary *}
  {else}
  <form id="payment-form" class="mobile-{$option.id|escape:'htmlall':'UTF-8'}" method="POST" action="{$option.action nofilter}">
    {foreach from=$option.inputs item=input}
    <input type="{$input.type|escape:'htmlall':'UTF-8'}" name="{$input.name|escape:'htmlall':'UTF-8'}" value="{$input.value|escape:'htmlall':'UTF-8'}">
    {/foreach}
    <button style="display:none" id="pay-with-{$option.id|escape:'htmlall':'UTF-8'}" type="submit"></button>
  </form>
  {/if}
</div>
{/foreach}
{foreachelse}
<p class="alert alert-danger">{l s='Unfortunately, there are no payment method available.' mod='presmobileapp'}</p>
{/foreach}


<div class="selected-payment-mobi" style="text-align: center;color: red;height: 30px;"> {l s='Process' mod='presmobileapp'}</div>
</div> 
{/if}

{if $version_mobi < '1.7'}

<div class="premobile-checkout-cart" style="padding: 1em;">
  <style>
  @import url("{$URL|escape:'htmlall':'UTF-8'}themes/default-bootstrap/css/global.css");
</style>
<div class="premobile-checkout-box-steps clearfix">
  <div class="ui-grid-b">
    <div class="ui-block-a">
      {*
        if(step == done){add class step-done}
        if(step == active){add class step-active}
        *}
        <div class="block-step first-step step-active step-done">
          <div class="step-item">
            <div class="around">
              <span class="step-value">1</span>
            </div>
          </div>
          <div class="step-title">
            {l s='ADDRESS' mod='presmobileapp'}
          </div>
        </div>
      </div>
      <div class="ui-block-b">
        <div class="block-step second-step step-active step-done">
          <div class="step-item">
            <div class="around">
              <span class="step-value">2</span>
            </div>
          </div>
          <div class="step-title">
            {l s='SHIPPING' mod='presmobileapp'}
          </div>
        </div>
      </div>
      <div class="ui-block-c">
        <div class="block-step three-step step-active">
          <div class="step-item">
            <div class="around">
              <span class="step-value">3</span>
            </div>
          </div>
          <div class="step-title">
            {l s='PAYMENT' mod='presmobileapp'}
          </div> 
        </div>
      </div>
    </div>
  </div>
</div>
<div class="presmobile-payment-page">
  <div class="presmobile-payment-block presmobile-payment-first">
    <h4>{l s='Your Payable Amount' mod='presmobileapp'}<i class="icon-ello-more-info-" onclick="PresMoblieShowAddressSelectPopup('popup-payment-detail')"></i></h4>
    <div class="presmobile-payment-value">{$price_order|escape:'htmlall':'UTF-8'}</div>
  </div>
  <div class="Presmobile-select-popup popup-payment-detail">
    <div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-payment-detail')"></div>
    <div class="Presmobile-select-popup-block">
      <div class="Presmobile-select-popup-header">
        <h4>{l s='Total Payable Amount' mod='presmobileapp'} <i class="icon-ello-close" onclick="PresMoblieHideAddressSelectPopup('popup-payment-detail')"></i></h4>
      </div>
      <ul class="Presmobile-select-popup-content">
        <li>{l s='Sub Total' mod='presmobileapp'}: {$cart_checkout[0]['quantity']|escape:'htmlall':'UTF-8'} item(s) <span>{$cart_checkout[0]['total_product']|escape:'htmlall':'UTF-8'}</span></li>
        <li>{l s='Shipping' mod='presmobileapp'}: <span style="color:green;">{$cart_checkout[0]['total_shipping']|escape:'htmlall':'UTF-8'}</span></li>
        <li>Tax<span>{$cart_checkout[0]['total_tax']|escape:'htmlall':'UTF-8'}</span></li>
        {if !empty($cart_checkout[0]['discount_new'])}
        {foreach from=$cart_checkout[0]['discount_new'] key=key4 item=item4}
        <li class="clearfix">
          {l s='Coupon Code' mod='presmobileapp'} <br/>({$item4['code']|escape:'htmlall':'UTF-8'}: -{$item4['price']|escape:'htmlall':'UTF-8'})<span>-{$item4['total_price']|escape:'htmlall':'UTF-8'}</span>
        </li>           
        {/foreach}
        {/if}
        <li>{l s='Total Payalbe Amount' mod='presmobileapp'}:<span>{$cart_checkout[0]['total_price']|escape:'htmlall':'UTF-8'}</span></li>
      </ul>
    </div>
  </div>
  <div class="payment_detial"  style="display: none;">
  </div>
  <div class="other_payment" onclick="PresMobidisplayPayment()" style="display: none;">
    <p>
      {l s='Other Payment Methods' mod='presmobileapp'}
    </p>
  </div>
  <div class="presmobile-payment-block presmobile-payment-block-second">
    {$list_payment nofilter} {* no escape necessary *}
  </div>
</div>

{/if}
<script type="text/javascript">
  {if !empty($display_jsdef)}
  {foreach from=$display_jsdef key=key item=item}
  var {$key nofilter} {* no escape necessary *} = "{$item nofilter} {* no escape necessary *}";
  {/foreach}
  {/if}
</script>
{if $version_mobi >= '1.7'}
{if $install_stripe_official === true}
  <script type="text/javascript" src="https://js.stripe.com/v2/" ></script>
  <script type="text/javascript" src="https://js.stripe.com/v3/" ></script>
  <script type="text/javascript" src="{$baseDir|escape:'htmlall':'UTF-8'}modules/stripe_official/views/js/payment_stripe.js" ></script>
  <script type="text/javascript" src="{$baseDir|escape:'htmlall':'UTF-8'}modules/stripe_official/views/js/jquery.the-modal.js" ></script>
{/if}
{/if}
{if $install_stripe_official === true}

  <link rel="stylesheet" href="{$baseDir|escape:'htmlall':'UTF-8'}/modules/stripe_official/views/css/front.css" type="text/css" media="all">
  <link rel="stylesheet" href="{$baseDir|escape:'htmlall':'UTF-8'}/modules/stripe_official/views/css/the-modal.css" type="text/css" media="all">
{/if}