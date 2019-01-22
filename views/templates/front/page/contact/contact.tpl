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
{$presmobicBeforeContacUs nofilter} {* no escape necessary *}
<div data-role="main" class="main1 td_contact_us">
	<div class="ui-grid-a">
		<div>
			<h3 style="font-size: 13px;margin: 14px 0;">{l s='SEND A MESSAGE' mod='presmobileapp'}</h3>
		</div>
	</div>
	<div class="ui-grid-a">
		<form id="contact_form">
			<div class="form-group select-subject-heading">
				<label class="PresMobiletitle"> {l s='Subject Heading' mod='presmobileapp'}</label>
				<select name="id_contact" id="id_contact" onchange="changecontac(this)">
					<option value="0">{l s='-- Choose -- ' mod='presmobileapp'}</option>
					{foreach from=$contact key=key item=item}
					<option value="{$item['id_contact']|escape:'htmlall':'UTF-8'}">{$item['name']|escape:'htmlall':'UTF-8'}</option>
					{/foreach}
				</select>
			</div>
			{foreach from=$contact key=key item=item}
			<label class="description{$item['id_contact']|escape:'htmlall':'UTF-8'} description" style="display: none;">{$item['description']|escape:'htmlall':'UTF-8'}</label>
			{/foreach}
			<div class="form-group">
				<label class="PresMobiletitle"> {l s='Email Address' mod='presmobileapp'}</label>
				<input type="text" name="email" class="contactus_name" onchange="PreMobiCheckFieldsContactUs()" placeholder="Email Address" value="{if $login_check['logged'] == 1}{$login_check['email']|escape:'htmlall':'UTF-8'}{/if}">
			</div>
			<div class="form-group">
				<label class="PresMobiletitle">{l s='Order reference ' mod='presmobileapp'}</label>
				<input type="text" name="orderreference" class="contactus_name" onchange="PreMobiCheckFieldsContactUs()" placeholder="Name">
			</div>	
			<div class="form-group">
				<label class="PresMobiletitle"> {l s='Message' mod='presmobileapp'}</label>
				<textarea rows="2" name="message" class="contactus_message" onchange="PreMobiCheckFieldsContactUs()" placeholder="Message"></textarea>
			</div>
		</form>
	</div>
	<div class="ui-grid-a">
		<div class="button-submit-contact" style="width: 45%;float:  right;">
			<button class="ui-btn contact-us-submit" onclick="savecontact()">
				{l s='Send' mod='presmobileapp'}
			</button>
		</div>
	</div>
</div>
<div data-role="main" class="ui-content banner_1" style="background: #0A1622;clear: left;padding: 0;position: relative;">
	<div class="td_footer_title">
		<p style="text-align: center;color: #ffffff;margin: 0;">{l s='WELCOME TO MODERNSHOP' mod='presmobileapp'}</p>
	</div>
	<div class="td_footer_infor">
		<p>{l s='Address Name St. 63, City Name, State, Country Name' mod='presmobileapp'}</p>
		<a href="tel:{l s='+30 123 456789 - +44 987 654321' mod='presmobileapp'}">{l s='+30 123 456789 - +44 987 654321' mod='presmobileapp'}</a>
		<p>{l s='info@domain.com - www.domain.com' mod='presmobileapp'}</p>
	</div>
	<div class="td_footer_icon">
		<p style="text-align: center;color: #ffffff;margin: 0;">
			<span class="td_icon_footer"><i class="icon-icontwitter"></i></span>
			<span class="td_icon_footer"><i class="icon-iconfacebook"></i></span>
			<span class="td_icon_footer"><i class="icon-icongoogle"></i></span>
		</p>
	</div>
	<div class="td_footer_last">
		<p>&copy; {l s='2015 Copyright. All rights reserved.' mod='presmobileapp'}</p>
	</div>
</div>
{$presmobicAfterContacUs nofilter} {* no escape necessary *}
<!--clear div-->
  {*<div style="height: 60px;clear: both;"></div>*}