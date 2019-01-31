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

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 " lang="{$lang_iso|escape:'htmlall':'UTF-8'}"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7" lang="{$lang_iso|escape:'htmlall':'UTF-8'}"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8" lang="{$lang_iso|escape:'htmlall':'UTF-8'}"><![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9" lang="{$lang_iso|escape:'htmlall':'UTF-8'}"><![endif]-->
<html lang="{$lang_iso|escape:'htmlall':'UTF-8'}">
<head>
  <title>{$shop_name|escape:'htmlall':'UTF-8'}</title>
  <meta name="description" content="{$description[0]['description']|escape:'htmlall':'UTF-8'}" />
  <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
  <meta name="generator" content="PrestaShop" />
  <meta name="robots" content="index,follow" />
  <script type="text/javascript">
    var check_ssl_re = "{$ssl_check|escape:'htmlall':'UTF-8'}";
    var check_ssl_onpage = "{$ssl_onpage|escape:'htmlall':'UTF-8'}";
    var check_http = location.protocol;
    var link_p = window.location.href;
    var link_new = '';
    if (check_ssl_re =='0') {
      if (check_http != 'http:' ) {
        link_new = link_p.replace(check_http,'http:');
        window.location = ""+link_new+"";
      }
    }
    if (check_ssl_re =='1') {
      if (check_http != 'https:' ) {
        if (check_ssl_onpage == '1') {
          link_new = link_p.replace(check_http,'https:');
          window.location = ""+link_new+"";
        }
      }
    }
    // alert(link_new);
  </script>
  
  {if $version_mobi >= '1.7'}
  <script
  src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/js/jquery-2.2.4.min.js"></script>
  {foreach $javascript.bottom.external as $js}
  <script type="text/javascript" src="{$js.uri|escape:'htmlall':'UTF-8'}" {$js.attribute|escape:'htmlall':'UTF-8'}></script>
  {/foreach}
  {foreach $javascript.bottom.inline as $js}
  <script type="text/javascript">
    {$js.content nofilter}{* no escape necessary *}
  </script>
  {/foreach}
  {foreach $stylesheets.external as $stylesheet}
  <link rel="stylesheet" href="{$stylesheet.uri|escape:'htmlall':'UTF-8'}" type="text/css" media="{$stylesheet.media|escape:'htmlall':'UTF-8'}">
  {/foreach}
  {/if} 
  {if $version_mobi < '1.7'}
   <script
  src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/js/jquery-1.11.3.min.js"></script>
  {if $install_stripe_official === true}
  <script type="text/javascript" src="{$baseDir|escape:'htmlall':'UTF-8'}modules/stripe_official/views/js/jquery.the-modal.js"></script>
  <script type="text/javascript" src="{$baseDir|escape:'htmlall':'UTF-8'}modules/stripe_official/views/js/payment_validation.js"></script>
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
  {/if}
  <script type="text/javascript">
    {if isset($js_def) && is_array($js_def) && $js_def|@count}
    {foreach from=$js_def key=k item=def}
    {if !empty($k) && is_string($k)}
    {if is_bool($def)}
    var {$k|escape:'htmlall':'UTF-8'} = {$def|var_export:true|escape:'htmlall':'UTF-8'};
    {elseif is_int($def)}
    var {$k|escape:'htmlall':'UTF-8'} = {$def|intval|escape:'htmlall':'UTF-8'};
    {elseif is_float($def)}
    var {$k|escape:'htmlall':'UTF-8'} = {$def|floatval|replace:',':'.'|escape:'htmlall':'UTF-8'};
    {elseif is_string($def)}
    var {$k|escape:'htmlall':'UTF-8'} = '{$def|strval}';
    {elseif is_array($def) || is_object($def)}
    var {$k|escape:'htmlall':'UTF-8'} = {$def|json_encode|escape:'htmlall':'UTF-8'};
    {elseif is_null($def)}
    var {$k|escape:'htmlall':'UTF-8'} = null;
    {else}
    var {$k|escape:'htmlall':'UTF-8'} = '{$def|@addcslashes:'\''|escape:'htmlall':'UTF-8'}';
    {/if}
    {/if}
    {/foreach}
    {/if}
  </script>
  {if isset($display_js) && $display_js|@count}
  {foreach from=$display_js key=k item=js_uri}
  <script type="text/javascript" src="{$js_uri|escape:'htmlall':'UTF-8'}"></script>
  {/foreach}
  {/if}
  {if isset($display_css)}
  {foreach from=$display_css key=css_uri item=media}
  <link rel="stylesheet" href="{$css_uri|escape:'htmlall':'UTF-8'}" type="text/css" media="{$media|escape:'htmlall':'UTF-8'}" />
  {/foreach}
  {/if}
  {/if}
  <!-- Include meta tag to ensure proper rendering and touch zooming -->
  {* <link mimeType="application/font-woff" href="{$baseDir}modules/presmobileapp/views/fonts/fontello.ttf"> *}
    {if $version_mobi < '1.7' && $version_mobi >= '1.6.1'}
    <script src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/js/jquery-ui-1.11.4.min.js" type="text/javascript"></script>
    {else}
      <script src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/js/iquery-ui-1.12.1.js"></script>
    {/if}
  
  <script src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/js/touchmove.js"></script>
  <script src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/js/jquery.mobile-1.4.5.min.js"></script>
  <script src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/js/owl.carousel.js"></script>
  <!-- Include jQuery Mobile stylesheets -->
  <link rel="stylesheet" href="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/css/jquery.mobile-1.4.5.min.css">
  <!-- Include the jQuery library -->
  <link rel="stylesheet" href="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/css/font-awesome.min.css">
  <!-- Include the jQuery Mobile library -->
  <link rel="stylesheet" href="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/css/animation.css">
  <link rel="stylesheet" href="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/css/fontello.css">
  <link rel="stylesheet" href="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/css/fontello-ie7.css">
  <link rel="stylesheet" href="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/css/stylemobileapp.css">
  {if $rtl == 1}
  <link rel="stylesheet"  href="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/css/stylertl.css">
  {/if}
  <link rel="stylesheet" href="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/css/owl.carousel.min.css">
  <link rel="stylesheet" href="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/css/animate.css">
  <script type="text/javascript" src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/js/presmobileapp.js"></script>
  <!-- Start WOWSlider.com HEAD section -->
  <link rel="stylesheet" type="text/css" href="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/css/jquery-ui.css" />
  <script src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/js/clipboard/dist/clipboard.min.js"></script>
  {* zoom img *}
  <link rel="stylesheet" type="text/css" href="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/css/default-skin.css" />
  <link rel="stylesheet" type="text/css" href="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/css/photoswipe.css" />
  <script src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/js/photoswipe.js"></script>
  <script src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/js/photoswipe-ui-default.min.js"></script>
  <link rel="icon" type="image/vnd.microsoft.icon" href="{$baseDir|escape:'htmlall':'UTF-8'}img/favicon.ico?1324977642" />
  <link rel="shortcut icon" type="image/x-icon" href="{$baseDir|escape:'htmlall':'UTF-8'}img/favicon.ico?1324977642" />
  <style type="text/css">
</style>
<script type="text/javascript">
  var token_pres = "{$token_pres|escape:'htmlall':'UTF-8'}";
  var url_presmobileapp = "{$baseDir|escape:'htmlall':'UTF-8'}";
  var presmobileapp_token = "{$token|escape:'htmlall':'UTF-8'}";
  var comment_time = "{$comment_time|escape:'htmlall':'UTF-8'}";
  var cache_add = "{$cache_add|escape:'htmlall':'UTF-8'}";
  var cacheapp = "{$cacheapp|escape:'htmlall':'UTF-8'}";
  var baseDir = "{$base_dir|escape:'htmlall':'UTF-8'}";
  var baseUri = "{$base_uri|escape:'htmlall':'UTF-8'}";
  var static_token = "{$static_token|escape:'htmlall':'UTF-8'}";
  var token = "{$token|escape:'htmlall':'UTF-8'}";
  var priceDisplayPrecision = 320;
  var priceDisplayMethod = "{$priceDisplay|escape:'htmlall':'UTF-8'}";
  var roundMode = "{$roundMode|escape:'htmlall':'UTF-8'}";
  var isLogged = "{$is_logged|escape:'htmlall':'UTF-8'}";
  var isGuest = "{$is_guest|escape:'htmlall':'UTF-8'}";
  var page_name = "{$page_name|escape:'htmlall':'UTF-8'}";
  var contentOnly = "{$content_only|escape:'htmlall':'UTF-8'}";
  var checkbox = {$checkbox|escape:'htmlall':'UTF-8'};
  if (checkbox == 1) {
    var FancyboxI18nClose = "Close";
  } else {
    var FancyboxboxI18nClose = "Close";
  }
  var FancyboxI18nNext = "Next";
  var FancyboxI18nPrev = "Previous";
  var usingSecureMode = "{$usingSecureMode|escape:'htmlall':'UTF-8'}";
  var ajaxsearch = "{$ajaxsearch|escape:'htmlall':'UTF-8'}";
  var instantsearch = "{$instantsearch|escape:'htmlall':'UTF-8'}";
  var quickView = "{$quick_view|escape:'htmlall':'UTF-8'}";
  var id_lang = "{$id_lang|escape:'htmlall':'UTF-8'}";
  var check_ssl ="{$check_ssl|escape:'htmlall':'UTF-8'}";
</script>
<!-- aaaaaaaaaaaaaaaaaaa -->
{$hook_header nofilter} {* no escape necessary *}
<!-- vvvvvvvvvvvvvvv -->
<script type="text/javascript">
  {if isset($js_def) && is_array($js_def) && $js_def|@count}
  {foreach from=$js_def key=k item=def}
  {if !empty($k) && is_string($k)}
  {if is_bool($def)}
  var {$k|escape:'htmlall':'UTF-8'} = {$def|var_export:true|escape:'htmlall':'UTF-8'};
  {elseif is_int($def)}
  var {$k|escape:'htmlall':'UTF-8'} = {$def|intval|escape:'htmlall':'UTF-8'};
  {elseif is_float($def)}
  var {$k|escape:'htmlall':'UTF-8'} = {$def|floatval|replace:',':'.'|escape:'htmlall':'UTF-8'};
  {elseif is_string($def)}
  var {$k|escape:'htmlall':'UTF-8'} = '{$def|strval|escape:'htmlall':'UTF-8'}';
  {elseif is_array($def) || is_object($def)}
  {elseif is_null($def)}
  var {$k|escape:'htmlall':'UTF-8'} = null;
  {else}
  var {$k|escape:'htmlall':'UTF-8'} = '{$def|@addcslashes:'\''|escape:'htmlall':'UTF-8'}';
  {/if}
  {/if}
  {/foreach}
  {/if}
</script>
</head>
<body class="ui-mobile-viewport ui-overlay-a">
  <div class="PresMobileicon-loadding">
    <!-- addclass 'presmobile-checkout-loading' in checkout page-->
    <img src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/ajax-loader.gif" alt="">
    <div class="imgesloadding">
    </div>
  </div> 
  <div class="PresMobileicon-loadding-incart">
    <div class="loading-bg"></div>
    <img src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/ajax-loader.gif" alt="">
  </div> 
  <div class="PresMobilenotification clearfix" style="display: none;">
    <p class='success'>
      {l s='Notification' mod='presmobileapp'}
    </p>
    <p class='error'>
      {l s='Notification' mod='presmobileapp'}
    </p>
  </div>
  <!-- Start of first page -->
  <!-- 1. Define some markup -->
  <!-- 2. Include library -->
  <!-- 3. Instantiate clipboard -->
  <script>
    var clipboard = new ClipboardJS('.btn');
    clipboard.on('success', function(e) {
      console.log(e);
    });
    clipboard.on('error', function(e) {
      console.log(e);
    });
  </script>
  <div>
    {$hook_displayNav nofilter} {* no escape necessary *}
  </div>
  <div data-role="page" id="home" class="main-page abcde">
    {$header nofilter} {* no escape necessary *}
    <!-- /header -->
    <div class="presmobile-home-refresh" style="display: none;">
      <div class="home-updating">
        <i class="fa fa-redo updating-tranform"></i>
        <span>{l s='Updating...' mod='presmobileapp'}</span>
      </div>
      <img style="display: none;" src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/refreshloading.gif" alt="">
    </div>
    <div class="ui-grid-a">
      {$hook_top nofilter} {* no escape necessary *}
    </div>
    <div class="ui-grid-a presmobile-home-page content-home ">
      {$content nofilter} {* no escape necessary *}
    </div>
    <div class="ui-grid-a presmobile-home-page">
      {$hook_displayHomeTab nofilter} {* no escape necessary *}
    </div>
    <div class="ui-grid-a presmobile-home-page">
      {$hook_displayHomeTabContent nofilter} {* no escape necessary *}
    </div>
    <div class="ui-grid-a presmobile-home-page">
      {$hook_displayHome nofilter} {* no escape necessary *}
    </div>
    <!--banner 2-->
    <!--banner 3-->
    <div data-role="main" class="ui-content td_near_footer">
      {$presmobicDisplayBeforeTextStatic nofilter} {* no escape necessary *}
      <div class="ui-grid-a ">
        <div class="ui-block-a td_near_footer_chil" style="">
          <div class="td_near_footer_chil2">
            <p class="ion-ios-icon-reply" style="text-align: center;color: red;font-size: 30px;margin: 0;"></p>
            <h2 style="margin: 5px 0;">{l s='7 Day Free Returns' mod='presmobileapp'}</h2>
            <p style="margin: 5px 0;text-align: center;font-size: 10px;color: #838383;">{l s='Lorem ipsum is simply dummy text of the printing' mod='presmobileapp'}</p>
          </div>
        </div>
        <div class="ui-block-b td_near_footer_chil" style="">
          <div class="td_near_footer_chil2">
            <p class="ion-ios-icon-safe" style="text-align: center;color: red;font-size: 30px;margin: 0;"></p>
            <h2 style="margin: 5px 0;">{l s='100% Certified' mod='presmobileapp'}</h2>
            <p style="margin: 5px 0;text-align: center;font-size: 10px;color: #838383;">{l s='Lorem ipsum is simply dummy text of the printing' mod='presmobileapp'}</p>
          </div>
        </div>
        <div class="ui-block-a td_near_footer_chil" style="">
          <div class="td_near_footer_chil2">
            <p class="ion-md-icon-reload" style="text-align: center;color: red;font-size: 30px;margin: 0;"></p>
            <h2 style="margin: 5px 0;">{l s='Life Time Exchange' mod='presmobileapp'}</h2>
            <p style="margin: 5px 0;text-align: center;font-size: 10px;color: #838383;">{l s='Lorem ipsum is simply dummy text of the printing' mod='presmobileapp'}</p>
          </div>
        </div>
        <div class="ui-block-b td_near_footer_chil" style="">
          <div class="td_near_footer_chil2">
            <p class="ion-ios-icon-phone" style="text-align: center;color: red;font-size: 30px;margin: 0;"></p>
            <h2 style="margin: 5px 0;">{l s='Support 24/24' mod='presmobileapp'}</h2>
            <p style="margin: 5px 0;text-align: center;font-size: 10px;color: #838383;">{l s='Lorem ipsum is simply dummy text of the printing' mod='presmobileapp'}</p>
          </div>
        </div>
      </div>
    </div>
    {$presmobicDisplayFooter nofilter} {* no escape necessary *}
    <div data-role="main" class="ui-content presmobile-mewletter-block">
      <div class="presmobile-mewletter-bg"></div>
      {$presmobicDisplayBeforeNewsletter nofilter} {* no escape necessary *}
      <div class="td_footer_title">
        <p>{l s='NEWSLETTER' mod='presmobileapp'}</p>
        <div class="box-mail-mewletter">
          <input type="text" class="mewletter-email" name="letter-mail" placeholder="Enter you e-mail" onkeyup="PresMobileNewsletter(this,event)">
          <span class="icon-ello-icon-send-email" onclick="PresMobileaddNewsletter()"></span>
        </div>
      </div>
      {$presmobicDisplayAfterNewsletter nofilter} {* no escape necessary *}
    </div>
    <div data-role="main" class="ui-content banner_1" style="background: #0A1622;clear: left;padding: 0;position: relative;">
      {$presmobicDisplayBeforeFooterText nofilter} {* no escape necessary *}
      <div class="td_footer_title">
        <p style="text-align: center;color: #ffffff;margin: 0;">{l s='WELCOME TO MODERNSHOP' mod='presmobileapp'}</p>
      </div>
      <div class="td_footer_infor">
        <p>{l s='Address Name St. 63, City Name, State, Country Name' mod='presmobileapp'}</p>
        <a href="tel:{l s='+30 123 456789 - +44 987 654321' mod='presmobileapp'}">{l s='+30 123 456789 - +44 987 654321' mod='presmobileapp'}</a>
        <p>{l s='info@domain.com - www.domain.com' mod='presmobileapp'}</p>
      </div>
      {$presmobicDisplayAfterFooterText nofilter} {* no escape necessary *}
      <div class="td_footer_icon">
        {$presmobicDisplayBeforeSocialFooter nofilter} {* no escape necessary *}
        <p style="text-align: center;color: #ffffff;margin: 0;">
          {if !empty($twitter)}
              <span class="td_icon_footer" onclick="window.open('{$twitter}{*Escape is unnecessary*}', '_blank')" ><i class="icon-icontwitter"></i></span>
            {/if}
            {if !empty($facebook)}
              <span class="td_icon_footer" onclick="window.open('{$facebook}{*Escape is unnecessary*}', '_blank')"><i class="icon-iconfacebook"></i></span>
            {/if}
            {if !empty($google)}
              <span class="td_icon_footer" onclick="window.open('{$google}{*Escape is unnecessary*}', '_blank')"><i class="icon-icongoogle"></i></span>
            {/if}
        </p>
        {$presmobicDisplayAfterSocialFooter nofilter} {* no escape necessary *}
      </div>
      <div class="td_footer_last">
        <p>&copy; {l s='2015 Copyright. All rights reserved.' mod='presmobileapp'}</p>
      </div>
      {$presmobicDisplayAfterFooter nofilter} {* no escape necessary *}
    </div>
    <div style="height: 44px;clear: both;"></div>
    {$footer nofilter} {* no escape necessary *}
    {$hook_displayFooter nofilter} {* no escape necessary *}
  </div>
  <!-- /page -->
  <!-- Start of second page -->
  <div data-role="page" id="category" style="background: #fff;font-size: 13px;" class="main-page abcde">
    {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
    <div data-role="header " class="ui-grid-b home-header">
      <div class="ui-block-a header-backicon"> 
        <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
          <i class="icon-iconarrowleft"></i>
        </span>
      </div>
      <div class="ui-block-b header-title"> 
        <h3 style="font-size:16px; text-align: center;width: 100%;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;" class="premobile-title-category">{l s='Categories' mod='presmobileapp'}</h3>
      </div>
      {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
      <div class="ui-block-c content_checkout" style="width: 30%;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
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
    <div class="preshop-pages-content content-category ui-grid-a">
      <div role="main" class="ui-content td_tab_category content-category">
        <div class="ui-grid-a" style="width:100%;">
          {foreach from=$category key=key item=item}
          <div class="td_tab_category_product ui-block-{if $key%2==0}a{/if}{if $key%2!=0}b{/if} category-{if $key%2==0}a{/if}{if $key%2!=0}b{/if}" onclick="PresMobibamobileroutes(this)" ba-link="#category:{$item['id_category']|escape:'htmlall':'UTF-8'}">
            <div class="category-box" style="float: left;width: 100%;-webkit-filter: brightness(0.60);">
              <img src="{$baseDir|escape:'htmlall':'UTF-8'}{$item['link_img']|escape:'htmlall':'UTF-8'}" style="float: left;width: 100%;" alt="">
            </div>
            <div class="td_tab_category_product_title">
              {$item['name']|escape:'htmlall':'UTF-8'}
            </div>
          </div>
          {/foreach}
        </div>
      </div>
    </div>
    <!-- /content -->
    <!--clear div-->
    <div style="height: 44px;clear: both;"></div>
    {$footer nofilter} {* no escape necessary *}
    {$hook_displayFooter nofilter} {* no escape necessary *}
    <!-- /footer -->
  </div><!-- /page -->
  <div data-role="page" id="latest" style="background: #fff;" class="main-page">
    {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
    <div data-role="header " class="ui-grid-b home-header">
      <div class="ui-block-a header-backicon"> 
        <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
          <i class="icon-iconarrowleft"></i>
        </span>
      </div>
      <div class="ui-block-b header-title"> 
        <h3 style="font-size:16px; text-align: center;width: 100%;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;" class="premobile-title-latest">{l s='Lastest' mod='presmobileapp'}</h3>
      </div>
      {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
      <div class="ui-block-c content_checkout" style="width: 30%;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
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
    {$hook_top nofilter} {* no escape necessary *}
    <div role="main" class="ui-content td_tab_category content-latest">
    </div>
    <!-- /content -->
    <!--clear div-->
    <div style="height: 44px;clear: both;"></div>
    {$footer nofilter} {* no escape necessary *}
    {$hook_displayFooter nofilter} {* no escape necessary *}
    <!-- /footer -->
  </div><!-- /page -->
  <div data-role="page" id="checkoutonestep" style="height: 100%;background: #fff;" class="main-page">
    {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
    <div data-role="header " class="ui-grid-b home-header">
      <div class="ui-block-a header-backicon"> 
        <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
          <i class="icon-iconarrowleft"></i>
        </span>
      </div>
      <div class="ui-block-b header-title"> 
        <h3 style="font-size:16px; text-align: center;width: 100%;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;" class="premobile-title-checkoutonestep">{l s='Checkout' mod='presmobileapp'}</h3>
      </div>
      {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
      <div class="ui-block-c content_checkout" style="width: 30%;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
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
    {$hook_top nofilter} {* no escape necessary *}
    <div role="main" class="ui-content td_tab_category content-checkoutonestep">
    </div>
    <!-- /content -->
    <!--clear div-->
    <div style="height: 44px;clear: both;"></div>
    {$footer nofilter} {* no escape necessary *}
    {$hook_displayFooter nofilter} {* no escape necessary *}
    <!-- /footer -->
  </div><!-- /page -->
  <div data-role="page" id="myvouchers" style="background: #fff;" class="main-page">
    {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
    <div data-role="header " class="ui-grid-b home-header">
      <div class="ui-block-a header-backicon"> 
        <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
          <i class="icon-iconarrowleft"></i>
        </span>
      </div>
      <div class="ui-block-b header-title"> 
        <h3 style="font-size:16px; text-align: center;width: 100%;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;" class="premobile-title-myvouchers">{l s='My Vouchers' mod='presmobileapp'}</h3>
      </div>
      {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
      <div class="ui-block-c content_checkout" style="width: 30%;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
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
    {$hook_top nofilter} {* no escape necessary *}
    <div role="main" class="ui-content td_tab_category content-myvouchers">
    </div>
    <!-- /content -->
    <!--clear div-->
    <div style="height: 44px;clear: both;"></div>
    {$footer nofilter} {* no escape necessary *}
    {$hook_displayFooter nofilter} {* no escape necessary *}
    <!-- /footer -->
  </div><!-- /page -->
  <div data-role="page" id="wishlist" style="background: #fff;" class="main-page">
    {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
    <div data-role="header " class="ui-grid-b home-header">
      <div class="ui-block-a header-backicon"> 
        <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
          <i class="icon-iconarrowleft"></i>
        </span>
      </div>
      <div class="ui-block-b header-title"> 
        <h3 style="font-size:16px; text-align: center;width: 100%;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;" class="premobile-title-wishlist">{l s='My Wishlist' mod='presmobileapp'}</h3>
      </div>
      {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
      <div class="ui-block-c content_checkout" style="width: 30%;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
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
    {$hook_top nofilter} {* no escape necessary *}
    <div role="main" class="ui-content td_tab_category content-wishlist" style="    margin-top: 45px;">
    </div>
    <!-- /content -->
    <!--clear div-->
    <div style="height: 44px;clear: both;"></div>
    {$footer nofilter} {* no escape necessary *}
    {$hook_displayFooter nofilter} {* no escape necessary *}
    <!-- /footer -->
  </div><!-- /page -->
  <div data-role="page" id="mywishlistbyid" style="background: #fff;" class="main-page">
    {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
    <div data-role="header " class="ui-grid-b home-header">
      <div class="ui-block-a header-backicon"> 
        <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
          <i class="icon-iconarrowleft"></i>
        </span>
      </div>
      <div class="ui-block-b header-title"> 
        <h3 style="font-size:16px; text-align: center;width: 100%;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;" class="premobile-title-mywishlistbyid">{l s='' mod='presmobileapp'}</h3>
      </div>
      {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
      <div class="ui-block-c content_checkout" style="width: 30%;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
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
    {$hook_top nofilter} {* no escape necessary *}
    <div role="main" class="ui-content td_tab_category content-mywishlistbyid" style="    margin-top: 45px;">
    </div>
    <!-- /content -->
    <!--clear div-->
    <div style="height: 44px;clear: both;"></div>
    {$footer nofilter} {* no escape necessary *}
    {$hook_displayFooter nofilter} {* no escape necessary *}
    <!-- /footer -->
  </div><!-- /page -->
  <div data-role="page" id="product" style="background: #fff;" class="main-page abcde">
    {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
    <div data-role="header " class="ui-grid-b home-header">
      <div class="ui-block-a header-backicon"> 
        <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
          <i class="icon-iconarrowleft"></i>
        </span>
      </div>
      <div class="ui-block-b header-title" > 
        <h3  class="premobile-title-product">{l s='Detail' mod='presmobileapp'}</h3>
      </div>
      {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
      <div class="ui-block-c content_checkout" style="width: 30%;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
        <div class="total_checkout">
          <p class="total_c">{l s='Total:' mod='presmobileapp'}</p>
          <p class="total_price">{if $bacart['price']}{$cart['price']|escape:'htmlall':'UTF-8'}{else}0{/if}</p>
        </div>
        <div class="cart_checkout">
          <span class="total_product">{if $cart['product_total']}{$cart['product_total']|escape:'htmlall':'UTF-8'}{else}0{/if}</span>
          <div class="icon_checkout icon-iconbag"></div>
        </div>
      </div>
      {$presmobicDisplayAfterMiniCart nofilter} {* no escape necessary *}
    </div>
    {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
    {$hook_top nofilter} {* no escape necessary *}
    <div role="main" class="ui-content td_tab_category content-product content-Detail" style="margin-top: 45px;position: relative;">
    </div>
    <!-- /content -->
    <!--clear div-->
    <div style="height: 44px;clear: both;"></div>
    <!-- /footer -->
    {$hook_displayFooter nofilter} {* no escape necessary *}
  </div><!-- /page -->
  <div data-role="page" id="login" style="background: #fff;" class="main-page abcde">
    {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
    <div data-role="header " class="ui-grid-b home-header">
      <div class="ui-block-a header-backicon"> 
        <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
          <i class="icon-iconarrowleft"></i>
        </span>
      </div>
      <div class="ui-block-b header-title header-title-nocarticon" > 
        <h3 class="premobile-title-login">{l s='login' mod='presmobileapp'}</h3>
      </div>
      <div class="ui-block-c content_checkout" style="width: 30%;">
      </div>
    </div>
    {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
    {$hook_top nofilter} {* no escape necessary *}
    <div role="main" class="ui-content td_tab_category content-login" style="overflow: auto;max-height: 100%;margin-top: 45px;">
    </div>
    <!-- /content -->
    <!--clear div-->
    <div style="height: 44px;clear: both;"></div>
    <!-- /footer -->
    {$hook_displayFooter nofilter} {* no escape necessary *}
  </div><!-- /page -->
  <div data-role="page" id="forgotpassword" style="background: #fff;" class="main-page abcde">
    {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
    <div data-role="header " class="ui-grid-b home-header">
      <div class="ui-block-a header-backicon"> 
        <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
          <i class="icon-iconarrowleft"></i>
        </span>
      </div>
      <div class="ui-block-b header-title" > 
        <h3   class="premobile-title-forgotpassword">{l s='forgotpassword' mod='presmobileapp'}</h3>
      </div>
      <div class="ui-block-c content_checkout" style="width: 30%;">
      </div>
    </div>
    {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
    {$hook_top nofilter} {* no escape necessary *}
    <div role="main" class="ui-content td_tab_category content-forgotpassword" style="margin-top: 45px;">
    </div>
    <!-- /content -->
    <!--clear div-->
    <div style="height: 44px;clear: both;"></div>
    <!-- /footer -->
    {$hook_displayFooter nofilter} {* no escape necessary *}
  </div><!-- /page -->
  <div data-role="page" id="order" style="background: #fff;" class="main-page abcde">
    {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
    <div data-role="header " class="ui-grid-b home-header">
      <div class="ui-block-a header-backicon"> 
        <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
          <i class="icon-iconarrowleft"></i>
        </span>
      </div>
      <div class="ui-block-b header-title header-title-nocarticon" > 
        <h3   class="premobile-title-order">{l s='My Order' mod='presmobileapp'}</h3>
      </div>
      <div class="ui-block-c content_checkout" style="width: 15%;">
      </div>
    </div>
    {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
    {$hook_top nofilter} {* no escape necessary *}
    <div role="main" class="ui-content td_tab_category content-order" style="margin-top: 45px;">
    </div>
    <!-- /content -->
    <!--clear div-->
    <div style="height: 44px;clear: both;"></div>
    {$footer nofilter} {* no escape necessary *}
    {$hook_displayFooter nofilter} {* no escape necessary *}
    <!-- /footer -->
  </div><!-- /page -->
  <div data-role="page" id="orderbyid" style="background: #fff;" class="main-page abcde">
    {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
    <div data-role="header " class="ui-grid-b home-header">
      <div class="ui-block-a header-backicon"> 
        <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
          <i class="icon-iconarrowleft"></i>
        </span>
      </div>
      <div class="ui-block-b header-title" > 
        <h3   class="premobile-title-orderbyid">{l s='' mod='presmobileapp'}</h3>
      </div>
      <div class="ui-block-c content_checkout ordermessenger_d" style="width: 30%;">
        <h5 onclick="PresMobibamobileroutes(this)" ba-link="#ordermessenger" class="count_messorder">
          <span class="fa icon-pres-mobic-comment">
            <span class="all-messenger">
              56
            </span>
          </span>
        </span>
      </h5>
      <h5 style="margin-right: 0;" class="pdf_order">
        <a class="icon-icondowload-pdf" target="_blank">
        </a>
      </h5>
    </div>
  </div>
  {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-orderbyid" style="margin-top: 45px;">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 60px;clear: both;background: #ffff;"></div>
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
  <!-- /footer -->
</div><!-- /page -->
<div data-role="page" id="ordermessenger" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a header-backicon"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </span>
    </div>
    <div class="ui-block-b header-title header-title-nocarticon" > 
      <h3   class="premobile-title-ordermessenger">{l s='' mod='presmobileapp'}</h3>
    </div>
    <div class="ui-block-c content_checkout" style="width: 10%;">
    </div>
  </div>
  {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-ordermessenger" style="margin-top: 45px;">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 60px;clear: both;background: #fff;"></div>
  <!-- /footer -->
</div><!-- /page -->
<div data-role="page" id="comment" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </span>
    </div>
    <div class="ui-block-b"> 
      <h3 style="text-align: center;margin: 13px 0px;font-size: 16px;margin:15px 0 " class="premobile-title-comment">{l s='All Comment' mod='presmobileapp'}</h3>
    </div>
    <div class="ui-block-c content_checkout" style="width: 15%;">
    </div>
  </div>
  {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-comment" style="margin-top: 45px;">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  <!-- /footer -->
  {$hook_displayFooter nofilter} {* no escape necessary *}
</div><!-- /page -->
<div data-role="page" id="checkoutaddress" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a header-backicon"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </span>
    </div>
    <div class="ui-block-b header-title header-title-nocarticon" > 
      <h3   class="premobile-title-checkoutaddress">{l s='Address' mod='presmobileapp'}</h3>
    </div>
    <div class="ui-block-c content_checkout" style="width: 30%;">
    </div>
  </div>
  {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-checkoutaddress" style="margin-top: 45px;">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
  <!-- /footer -->
</div><!-- /page -->
<div data-role="page" id="checkoutsuccess" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header header-checkoutsuccess">
    <div class="checkout-order-success">
      <h3>
        <span class="ion-ios-icon-check" style="font-size: 32px;"></span>
        {l s='Your order has been received' mod='presmobileapp'}
      </h3>
      <p>
        {l s='Thanks For Shipping With Us' mod='presmobileapp'}
      </p>
      <p> {l s='Your order ID is' mod='presmobileapp'} <span class="premobile-title-checkoutsuccess"></span></p>
    </div>
  </div>
  {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-checkoutsuccess" style="margin-top: 45px;">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
  <!-- /footer -->
</div><!-- /page -->
<div data-role="page" id="signup" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a header-backicon"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </span>
    </div>
    <div class="ui-block-b header-title header-title-nocarticon" > 
      <h3   class="premobile-title-signup">{l s='Sign Up' mod='presmobileapp'}</h3>
    </div>
    <div class="ui-block-c content_checkout" style="width: 30%;">
    </div>
  </div>
  {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-signup" style="padding:0;margin-top: 45px;">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  {$hook_displayFooter nofilter} {* no escape necessary *}
  <!-- /footer -->
</div><!-- /page -->
<div data-role="page" id="favorite" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a header-backicon"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 16px" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </span>
    </div>
    <div class="ui-block-b header-title header-title-nocarticon" > 
      <h3   class="premobile-title-favorite">{l s='Favorite' mod='presmobileapp'}</h3>
    </div>
    <div class="ui-block-c content_checkout" style="width: 15%;" onclick="PreMobiClearFavoriteProduct()">
      <h3 class="preshop-button-right"> {l s='Clear' mod='presmobileapp'}</h3>
    </div>
  </div>
  {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-favorite" style="margin-top: 45px;">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  <!-- /footer -->
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
</div><!-- /page -->
<div data-role="page" id="profile" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a header-backicon"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 16px" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </span>
    </div>
    <div class="ui-block-b header-title header-title-nocarticon" > 
      <h3   class="premobile-title-profile">{l s='Edit profile' mod='presmobileapp'}</h3>
    </div>
    <div class="ui-block-c content_checkout" style="width: 15%;" onclick="PresMobieditProfile()">
      <h3 class="preshop-button-right"> {l s='Done' mod='presmobileapp'}</h3>
    </div>
  </div>
  {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-profile" style="margin-top: 45px;">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  <!-- /footer -->
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
</div><!-- /page -->
<div data-role="page" id="cart" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a header-backicon"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </span>
    </div>
    <div class="ui-block-b header-title"> 
      <h3   class="premobile-title-cart">{l s='Shopping cart' mod='presmobileapp'}</h3>
    </div>
    {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
    <div class="ui-block-c content_checkout" style="width: 30%;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
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
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-cart" style="padding:0;">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  <!-- /footer -->
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
</div><!-- /page -->
<div data-role="page" id="checkoutcart" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a header-backicon"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </span>
    </div>
    <div class="ui-block-b header-title" > 
      <h3 class="premobile-title-checkoutcart">{l s='Checkout' mod='presmobileapp'}</h3>
    </div>
    {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
    <div class="ui-block-c content_checkout" style="width: 30%;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
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
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-checkoutcart" style="margin-top: 45px;">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  <!-- /footer -->
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
</div><!-- /page -->
<div data-role="page" id="creditslips" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a header-backicon"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </span>
    </div>
    <div class="ui-block-b header-title" > 
      <h3 class="premobile-title-creditslips">{l s='My Credit slips' mod='presmobileapp'}</h3>
    </div>
    {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
    <div class="ui-block-c content_checkout" style="width: 30%;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
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
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-creditslips">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  <!-- /footer -->
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
</div><!-- /page -->
<div data-role="page" id="merchandisereturns" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a header-backicon"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </span>
    </div>
    <div class="ui-block-b header-title" > 
      <h3 class="premobile-title-merchandisereturns premobile-title-category" style="text-align: center;width: 100%;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;">{l s='Return Merchandise Authorization (RMA)' mod='presmobileapp'}</h3>
    </div>
    {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
    <div class="ui-block-c content_checkout" style="width: 30%;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
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
  <div role="main" class="ui-content td_tab_category content-merchandisereturns">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  <!-- /footer -->
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
</div><!-- /page -->
<div data-role="page" id="checkoutpayment" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a header-backicon"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </span>
    </div>
    <div class="ui-block-b header-title" > 
      <h3   class="premobile-title-checkoutpayment">{l s='Checkout' mod='presmobileapp'}</h3>
    </div>
    {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
    <div class="ui-block-c content_checkout" style="width: 30%;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
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
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-checkoutpayment" style="margin-top: 45px;">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  <!-- /footer -->
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
</div><!-- /page -->
<!-- Start of second page -->
<div data-role="page" id="search" style="background: white;" class="main-page abcde">
  <div class="ui-grid-a">
    {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
    <div data-role="header " class="ui-grid-b home-header">
      <div class="ui-block-a" style="float:left;width: 10% !important;"> 
        <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
          <i class="icon-iconarrowleft"></i>
        </span>
      </div>
      <div class="ui-block-b" style="width: 60% !important;position:relative;"> 
        <input type="text" style="box-sizing: unset;width: 90%;" name="" class="search-product" placeholder="Search Product" onkeyup="PresMobisearchProduct(this, event)" id="search_product_app" autofocus>
        <select class="dis-keyboard" style="display: none;">
          <option ></option>
        </select>
        <div class="clear-search-icon" onclick="PresMobiclearsearch()">
          <i class="fa fa-times-circle"></i>
        </div>
      </div>
      {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
      <div class="ui-block-c content_checkout " style="width: 30% !important;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
        <div class="total_checkout">
          <p class="total_c">{l s='Total:' mod='presmobileapp'}</p>
          <p class="total_price">{if $cart['price']}{$cart['price']|escape:'htmlall':'UTF-8'}{else}0{/if}</p>
        </div>
        <div class="cart_checkout">
          <span class="total_product" style="text-shadow: none;">{if $cart['product_total']}{$cart['product_total']|escape:'htmlall':'UTF-8'}{else}0{/if}</span>
          <div class="icon_checkout icon-iconbag"></div>
        </div>
      </div>
      {$presmobicDisplayAfterMiniCart nofilter} {* no escape necessary *}
    </div>
    {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
    {$hook_top nofilter} {* no escape necessary *}
    <!-- /header -->
    <div role="main" class="ui-content content-PresMobisearchProduct content-search" style="margin-top: 46px;">
      {$PresMobisearchProduct nofilter} {* no escape necessary *}
    </div>
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
  <!-- /footer -->
</div><!-- /page -->
<!--secon page-->
<div data-role="page" id="myaddress" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a header-backicon"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </span>
    </div>
    <div class="ui-block-b header-title" > 
      <h3 class="premobile-title-myaddress">{l s='Checkout' mod='presmobileapp'}</h3>
    </div>
    {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
    <div class="ui-block-c content_checkout" style="width: 30%;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
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
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-myaddress" style="margin-top: 45px;">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  <!-- /footer -->
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
</div>
<!-- /page -->
<div data-role="page" id="myaddressbycustomer" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a header-backicon"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </span>
    </div>
    <div class="ui-block-b header-title" > 
      <h3 class="premobile-title-myaddressbycustomer">{l s='My Address' mod='presmobileapp'}</h3>
    </div>
    {$presmobicDisplayBeforeMiniCart nofilter} {* no escape necessary *}
    <div class="ui-block-c content_checkout" style="width: 30%;" onclick="PresMobibamobileroutes(this)" ba-link="#cart">
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
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-myaddressbycustomer" style="margin-top: 45px;">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  <!-- /footer -->
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
</div>
<!-- /page -->
<div data-role="page" id="termsofuse" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a header-backicon"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </span>
    </div>
    <div class="ui-block-b header-title header-title-nocarticon" > 
      <h3 class="premobile-title-termsofuse">{l s='Terms of use' mod='presmobileapp'}</h3>
    </div>
    <div class="ui-block-c content_checkout" style="width: 15%;">
    </div>
  </div>
  {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
  {$hook_top nofilter} {* no escape necessary *}
  <div role="main" class="ui-content td_tab_category content-termsofuse" style="margin-top: 45px;">
  </div>
  <!-- /content -->
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  <!-- /footer -->
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
</div>
<!-- /page -->
<div data-role="page" id="privacypolicy" style="background: #fff;" class="main-page abcde">
  {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
  <div data-role="header " class="ui-grid-b home-header">
    <div class="ui-block-a header-backicon"> 
      <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
        <i class="icon-iconarrowleft"></i>
      </div>
      <div class="ui-block-b header-title header-title-nocarticon" > 
        <h3>{l s='Privacy policy' mod='presmobileapp'}</h3>
      </div>
      <div class="ui-block-c content_checkout" style="width: 15% ;">
      </div>
    </div>
    {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
    {$hook_top nofilter} {* no escape necessary *}
    <div role="main" class="ui-content td_tab_category content-privacypolicy" style="margin-top: 45px;">
    </div>
    <!-- /content -->
    <!--clear div-->
    <div style="height: 44px;clear: both;"></div>
    <!-- /footer -->
    {$footer nofilter} {* no escape necessary *}
    {$hook_displayFooter nofilter} {* no escape necessary *}
  </div>
  <!-- /page -->
  <div data-role="page" id="contact" style="background: #fff;" class="main-page abcde">
    {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
    <div data-role="header " class="ui-grid-b home-header">
      <div class="ui-block-a header-backicon"> 
        <span class="" style="font-size: 13px;float: left;margin: 15px 16px;" onclick="goBack()">
          <i class="icon-iconarrowleft"></i>
        </span>
      </div>
      <div class="ui-block-b header-title"> 
        <h3 style="text-align: center;font-size: 16px;">{l s='Contact us' mod='presmobileapp'}</h3>
      </div>
      <div class="ui-block-c content_checkout" style="width: 30% !important;top: 7px;">
        <h5 onclick="PresMobibamobileroutes(this)" ba-link="#about" style="margin:15px 0;font-size:13px;font-weight: normal;color: #545454;text-align: right;padding-right: 1em;">{l s='About us' mod='presmobileapp'}</h5>
      </div>
    </div>
    {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
    {$hook_top nofilter} {* no escape necessary *}
    <div role="main" class="ui-content td_tab_category content-contact" style="margin-top: 45px;">
    </div>
    <!-- /content -->
    <!--clear div-->
    <div style="height: 44px;clear: both;"></div>
    <!-- /footer -->
    {$footer nofilter} {* no escape necessary *}
    {$hook_displayFooter nofilter} {* no escape necessary *}
  </div>
  <!-- /page -->
  <!-- /page -->
  <div data-role="page" id="about" style="background: #fff;" class="main-page abcde">
    {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
    <div data-role="header " class="ui-grid-b home-header">
      <div class="ui-block-a header-backicon" style="width: 30%;"> 
        <span class="" style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
          <i class="icon-iconarrowleft"></i>
        </span>
      </div>
      <div class="ui-block-b header-title" style="width: 40%;"> 
        <h3>{l s='About us' mod='presmobileapp'}</h3>
      </div>
      <div class="ui-block-c content_checkout" style="width: 30%;">
        <h5 style="color: #9e9595;font-size: 13px;font-weight: normal;margin: 15px 0px;text-align: right;padding-right: 1em;" onclick="PresMobibamobileroutes(this)" ba-link="#contact">{l s='Contact us' mod='presmobileapp'}</h5>
      </div>
    </div>
    {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
    {$hook_top nofilter} {* no escape necessary *}
    <div role="main" class="ui-content td_tab_category content-about" style="margin-top: 45px;">
    </div>
    <!-- /content -->
    <!--clear div-->
    <div style="height: 44px;clear: both;"></div>
    <!-- /footer -->
    {$footer nofilter} {* no escape necessary *}
    {$hook_displayFooter nofilter} {* no escape necessary *}
  </div>
  <!-- /page -->
  <div data-role="page" id="account" class="main-page abcde">
    <div class="content-account ui-grid-a">
      {$presmobicDisplayBeforeHeader nofilter} {* no escape necessary *}
      <div data-role="header " class="ui-grid-b header-account">
        <div class="ui-block-a" style="width: 13%;"> 
          <span style="font-size: 13px;float: left;margin: 15px 11px;" onclick="goBack()">
            <i class="icon-iconarrowleft"></i>
          </span>
        </div>
        {if $cart['logged'] !='1'}
        <div class="ui-block-b" style="width: 74%;text-align: center;padding-top: 10px;" onclick="PreMobisetCookie('control','#account'),PresMobibamobileroutes(this)" ba-link="#login"> 
          <span class="ion-md-icon-account avata-account"></span>
          <h3 style="margin-top: 0;color: #e6e6e6;text-shadow: none;font-size: 14px;">{l s='LOGIN' mod='presmobileapp'}</h3>
        </div>
        <div class="ui-block-c" style="font-size: 20px;width: 10%;margin: 8px 0px;"> 
        </div>
        {/if}
        {if $cart['logged']}
        <div class="ui-block-b" style="width: 74%;text-align: center;padding-top: 10px;">
          <span class="ion-md-icon-account avata-account"></span>
          <div class="td_name_customer" onclick="PresMobibamobileroutes(this)" ba-link="#profile">
            <h3 style="color: #fff;margin: -19px 6px !important;text-shadow: none;font-size: 14px;float: left;">
              {$cart['customerName']|escape:'htmlall':'UTF-8'}
            </h3>
            <span style="border-bottom: 1px solid #fff; cursor: pointer; float: left;color: #fff;top: 0;font-size: 12px;text-shadow: none;">
              <i class="fa fa-pencil"></i>   
            </span>
          </div>
          <h6 style="color: #968787;margin: 4px 0;text-shadow: none;font-size: 14px;float: left;width: 100%;">
            {$cart['email']|escape:'htmlall':'UTF-8'}
          </h6>
        </div>
        <div class="ui-block-c" style="text-align: right;padding-right: 1em;font-size: 13px;width: 13%;margin: 8px 0px;" onclick="PreMobiLogout()"> 
          <span class="ion-ios-icon-logout" style="margin-right: 0.4em;font-size: 30px;color: #fff;text-shadow: none;line-height: 1.3"></span>
        </div>
        {/if}
      </div>
      {$presmobicDisplayAfterHeader nofilter} {* no escape necessary *}
      <!--end header-->
      <!--end header-->
      <div role="main" class="ui-content account-pages" style="background: white;padding: 0;">
        {if $cart['logged']}
        {$presmobic_beforeaccountSetting nofilter} {* no escape necessary *}
        <div class="my-account-group-title">
          {l s='My account' mod='presmobileapp'}
        </div>
        <div class="ui-grid-a account-items-noboder" onclick="PresMobibamobileroutes(this)" ba-link="#order">
          <div class="ui-block-a">
            <span class="ion-ios-icon-order-list"></span>
            <span>{l s='My Order' mod='presmobileapp'}</span>
          </div>
          <div class="ui-block-b">
            <p>{$cart['order']|escape:'htmlall':'UTF-8'}</p>
          </div>
        </div>
        <div class="ui-grid-a">
          <div class="ui-block-a" onclick="PresMobibamobileroutes(this)" ba-link="#favorite">
            <span class="icon-ello-favorite"></span>
            <span>{l s='My favorite product' mod='presmobileapp'}</span>
          </div>
          <div class="ui-block-b">
            <p>{$cart['count_favorite']|escape:'htmlall':'UTF-8'}</p>
          </div>
        </div>
        <div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#wishlist">
          <div class="ui-block-a">
            <span class="icon-my-wishlist"></span>
            <span>{l s='My Wishlist' mod='presmobileapp'}</span>
          </div>
          <div class="ui-block-b">
            <p>{$cart['count_wis']|escape:'htmlall':'UTF-8'}</p>
          </div>
        </div>
        <div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#merchandisereturns">
          <div class="ui-block-a">
            <span class="icon-ello-merchandise-returns"></span>
            <span>{l s='My merchandise returns' mod='presmobileapp'}</span>
          </div>
          <div class="ui-block-b">
            <p>
              {$cart['count_merchandise']|escape:'htmlall':'UTF-8'}
            </p>
          </div>
        </div>
        <div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#creditslips">
          <div class="ui-block-a">
            <span class="icon-mycredit-slip"></span>
            <span>{l s='My Credit Slips' mod='presmobileapp'}</span>
          </div>
          <div class="ui-block-b">
            <p>
              {$cart['count_creadit']|escape:'htmlall':'UTF-8'}
            </p>
          </div>
        </div>
        <div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#myaddressbycustomer">
          <div class="ui-block-a">
            <span class="icon-ello-my-address"></span>
            <span>{l s='My Address' mod='presmobileapp'}</span>
          </div>
          <div class="ui-block-b">
            <p>
              {$cart['count_address']|escape:'htmlall':'UTF-8'}
            </p>
          </div>
        </div>
        <div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#myvouchers">
          <div class="ui-block-a">
            <span class="icon-ello-vouchers"></span>
            <span>{l s='My Vouchers' mod='presmobileapp'}</span>
          </div>
          <div class="ui-block-b">
            <p>
              {$cart['count_voucher']|escape:'htmlall':'UTF-8'}
            </p>
          </div>
        </div>
        <div class="ui-grid-a" >
        </div>
        {$presmobic_afteraccountSetting nofilter} {* no escape necessary *}
        {/if}
        <div class="my-account-group-title">
          {l s='Setting app' mod='presmobileapp'}
        </div>
        <div class="ui-grid-a">
          <div class="ui-block-a" style="width:50%;" onclick="PresMoblieShowAddressSelectPopup('popup-choose-currency')">
            <span class="icon-ello-currency"></span>
            <span>{l s='Currency' mod='presmobileapp'}</span>
          </div>
          <div class="ui-block-b" style="width:50%;" onclick="PresMoblieShowAddressSelectPopup('popup-choose-currency')">
            <p>{$code_currencydefault}</p>
          </div>
          <div class="Presmobile-select-popup popup-choose-currency">
            <div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-choose-currency')"></div>
            <div class="Presmobile-select-popup-block">
              <div class="Presmobile-select-popup-header">
                <h4>{l s='Choose Currency' mod='presmobileapp'}</h4>
              </div>
              <ul class="Presmobile-select-popup-content">
                {foreach from=$currency key=key item=item}
                <li class="list-currency list-currency-{$item['id_currency']|escape:'htmlall':'UTF-8'}
                {if $item['id_currency'] == $currencydefault} currencyselected {/if} clearfix" onclick="PresMoblieChangeCurrency(this)" value="{$item['id_currency']|escape:'htmlall':'UTF-8'}">{$item['name']|escape:'htmlall':'UTF-8'} ({$item['iso_code']|escape:'htmlall':'UTF-8'})
                <span class="choose-address"></span>
              </li>
              {/foreach}
            </ul>
            <div class="ui-grid-a Presmobile-select-popup-footer">
              <div class="ui-block-a" style="width:50%;margin:0;">
                <h4 onclick="PresMoblieHideAddressSelectPopup('popup-choose-currency')">{l s='Close' mod='presmobileapp'}</h4>
              </div>
              <div class="ui-block-b" style="width:50%;margin:0;">
                <h4 class="apply-choose-currency" data-currency="" onclick="PresMoblieCurrency()">{l s='Done' mod='presmobileapp'}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="ui-grid-a">
        <div class="ui-block-a" style="width:50%;">
          <span class="icon-ello-language" onclick="PresMoblieShowAddressSelectPopup('popup-choose-language')"></span>
          <span>{l s='Language' mod='presmobileapp'}</span>
        </div>
        <div class="ui-block-b" style="width:50%;"  onclick="PresMoblieShowAddressSelectPopup('popup-choose-language')">
          <p>{$name_language_default|escape:'htmlall':'UTF-8'}</p>
        </div>
        <div class="Presmobile-select-popup popup-choose-language">
          <div class="Presmobile-select-popup-bg" onclick="PresMoblieHideAddressSelectPopup('popup-choose-language')"></div>
          <div class="Presmobile-select-popup-block">
            <div class="Presmobile-select-popup-header">
              <h4>{l s='Choose Language' mod='presmobileapp'}</h4>
            </div>
            <ul class="Presmobile-select-popup-content">
              {foreach from=$language key=key item=item}
              <li class="list-language list-language-{$item['id_lang']|escape:'htmlall':'UTF-8'} {if $item['id_lang']==$languagedefault} languageselected {/if} clearfix" onclick="PresMoblieChangeLanguage(this)" value="{$item['id_lang']|escape:'htmlall':'UTF-8'}">{$item['name']|escape:'htmlall':'UTF-8'}
                <span class="choose-address"></span>
              </li>
              {/foreach}
            </ul>
            <div class="ui-grid-a Presmobile-select-popup-footer">
              <div class="ui-block-a" style="width:50%;margin:0;">
                <h4 onclick="PresMoblieHideAddressSelectPopup('popup-choose-language')">Close</h4>
              </div>
              <div class="ui-block-b" style="width:50%;margin:0;">
                <h4 class="apply-choose-language" data-language="" onclick="PresMoblieHideAddressSelectPopup('popup-choose-language'),PresMobileUpdateLanguage()"> {l s='Done' mod='presmobileapp'}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      {$presmobic_beforeaccountInfomartion nofilter} {* no escape necessary *}
      <div class="my-account-group-title">
        {l s='Information' mod='presmobileapp'}
      </div>
      <div class="ui-grid-a account-items-noboder" onclick="PresMobibamobileroutes(this)" ba-link="#contact">
        <div class="ui-block-a">
          <span class="icon-ello-contact"></span>
          <span>{l s='Contact us' mod='presmobileapp'}</span>
        </div>
      </div>
      <div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#about">
        <div class="ui-block-a">
          <span class="icon-ello-about"></span>
          <span>{l s='About Us' mod='presmobileapp'}</span>
        </div>
      </div>
      <div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#privacypolicy">
        <div class="ui-block-a">
          <span class="ion-ios-icon-list-lock"></span>
          <span>{l s='Privacy policy' mod='presmobileapp'}</span>
        </div>
      </div>
      <div class="ui-grid-a" onclick="PresMobibamobileroutes(this)" ba-link="#termsofuse">
        <div class="ui-block-a">
          <span class="ion-md-icon-list" ></span>
          <span>{l s='Terms of Use' mod='presmobileapp'}</span>
        </div>
      </div>
      {$presmobic_beforeaccountSetting nofilter} {* no escape necessary *}
    </div>
    <!--clear div-->
    <!--clear div-->
  </div>
  <!--clear div-->
  <div style="height: 44px;clear: both;"></div>
  {$footer nofilter} {* no escape necessary *}
  {$hook_displayFooter nofilter} {* no escape necessary *}
  <!-- /footer -->
</div>
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>{l s='loading' mod='presmobileapp'}</h1></div>
</body>
</html>