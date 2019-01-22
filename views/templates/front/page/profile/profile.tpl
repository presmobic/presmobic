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
<div class="PresMobileprofile-content">
	<div class="PresMobileprofile-image">
		<div class="image-box"">
			<span class="ion-md-icon-account avata-account" style="font-weight: normal;font-size: 97px;text-align: center;color:  #000;"></span>
		</div>
	</div>
	<div class="PresMobileprofile-text">
		<form id="presmobi-profile">
			<div class="profile-box">
				<ul class="list_gender">
					<li>
						<label class="">{l s='Title:' mod='presmobileapp'}</label> 
					</li>
					<li>
						<span>
							<input type="radio" name="id_gender" id="id_gender1" value="1" {if $cart['id_gender'] == 1}checked{/if}>
							<div class="propertie-checked">
								<div></div>
							</div>
						</span>
						<span> {l s='Mr.' mod='presmobileapp'}</span>
					</li>
					<li>
						<span>
							<input type="radio" name="id_gender" id="id_gender2" value="2" {if $cart['id_gender'] == 2}checked {/if}> 
							<div class="propertie-checked">
								<div></div>
							</div>
						</span>
						<span>  {l s='Mrs.' mod='presmobileapp'}</span>
					</li>
				</ul>
			</div>
			<div class="profile-box">
				<label>{l s='First name * ' mod='presmobileapp'}</label>
				<input type="text" onfocus="PreMobileProfileFocus(this)" onblur="PreMobileProfileUnfocus(this)" name="profile-first-name" class="profile-first-name" value="{$cart['firstName']|escape:'htmlall':'UTF-8'}"  placeholder="First name" required>
			</div>
			<div class="profile-box">
				<label>{l s='Last name * ' mod='presmobileapp'}</label>
				<input type="text" onfocus="PreMobileProfileFocus(this)" onblur="PreMobileProfileUnfocus(this)" name="profile-last-name" class="profile-last-name" value="{$cart['lastName']|escape:'htmlall':'UTF-8'}" placeholder="Last name" required>
			</div>
			<div class="profile-box">
				<label> {l s='Email *' mod='presmobileapp'}</label>
				<input type="email" onfocus="PreMobileProfileFocus(this)" onblur="PreMobileProfileUnfocus(this)" name="profile-email" class="profile-email" value="{$cart['email']|escape:'htmlall':'UTF-8'}" placeholder="email" required>
			</div>
			<div class="profile-box">
				<label class="">{l s='Date of Birth:' mod='presmobileapp'}</label> 
				<ul class="birth-day">
					<li>
						<select name="days" id="days">
							<option value="" selected="selected"> {l s='Days' mod='presmobileapp'}</option>
							{for $days=1 to 31}
							<option value="{$days|escape:'htmlall':'UTF-8'}" {if $days == $cart['birthday'][2]}selected="selected" {/if}>{$days|escape:'htmlall':'UTF-8'}</option>
							{/for}
						</select>
					</li>
					<li>
						<select name="months" id="months">
							<option value="" selected="selected"> {l s='Months' mod='presmobileapp'}</option>
							<option value="1" {if 1 == $cart['birthday'][1]}selected="selected" {/if}> {l s='January' mod='presmobileapp'}</option>
							<option value="2" {if 2 == $cart['birthday'][1]}selected="selected" {/if}>  {l s='February' mod='presmobileapp'}</option>
							<option value="3" {if 3 == $cart['birthday'][1]}selected="selected" {/if}>  {l s='March' mod='presmobileapp'}</option>
							<option value="4" {if 4 == $cart['birthday'][1]}selected="selected" {/if}>  {l s='April' mod='presmobileapp'}</option>
							<option value="5" {if 5 == $cart['birthday'][1]}selected="selected" {/if}>  {l s='May' mod='presmobileapp'}</option>
							<option value="6" {if 6 == $cart['birthday'][1]}selected="selected" {/if}>  {l s='June' mod='presmobileapp'}</option>
							<option value="7" {if 7 == $cart['birthday'][1]}selected="selected" {/if}>  {l s='July' mod='presmobileapp'}</option>
							<option value="8" {if 8 == $cart['birthday'][1]}selected="selected" {/if}>  {l s='August' mod='presmobileapp'}</option>
							<option value="9" {if 9 == $cart['birthday'][1]}selected="selected" {/if}>  {l s='September' mod='presmobileapp'}</option>
							<option value="10" {if 10 == $cart['birthday'][1]}selected="selected" {/if}>  {l s='October' mod='presmobileapp'}</option>
							<option value="11" {if 11 == $cart['birthday'][1]}selected="selected" {/if}>  {l s='November' mod='presmobileapp'}</option>
							<option value="12" {if 12 == $cart['birthday'][1]}selected="selected" {/if}>  {l s='December' mod='presmobileapp'}</option>
						</select>
					</li>
					<li>
						<select name="years" id="years">
							<option value="" selected="selected"> {l s='Years' mod='presmobileapp'}</option>
							{for $years= 1990 to $year}
							<option value="{$years|escape:'htmlall':'UTF-8'}" {if $years == $cart['birthday'][0]} selected="selected" {/if}>{$years|escape:'htmlall':'UTF-8'}</option>
							{/for}
						</select> 
					</li> 
				</ul> 
			</div>
			<div class="profile-box">
				<label> {l s='Current password *' mod='presmobileapp'}</label>
				<input type="password" onfocus="PreMobileProfileFocus(this)" onblur="PreMobileProfileUnfocus(this)" name="profile-current-password" class="profile-current-password" value="" placeholder="Current password">
			</div>
			<div class="profile-box">
				<label> {l s='New password' mod='presmobileapp'}</label>
				<input type="password" onfocus="PreMobileProfileFocus(this)" onblur="PreMobileProfileUnfocus(this)" name="profile-new-password" class="profile-password" value="" placeholder="New password">
			</div>
			<div class="profile-box">
				<label> {l s='Confirmation' mod='presmobileapp'}</label>
				<input type="password" onfocus="PreMobileProfileFocus(this)" onblur="PreMobileProfileUnfocus(this)" name="profile-confirmation-password" class="profile-confirmation-password" value="" placeholder="Confirmation password">
			</div>
			{if $b2b_enable == '1'}
			<div class="form-group" style="margin-top: 30px;">
				<label class="PresMobiletitle" >{l s='YOUR COMPANY INFORMATION' mod='presmobileapp'}</label>
			</div>
			<div class="profile-box">
				<label>{l s='Company' mod='presmobileapp'} </label>
				<input type="text" onfocus="PreMobileProfileFocus(this)" onblur="PreMobileProfileUnfocus(this)" name="profilecompany" class="profile-confirmation-pcompany" value="{$cart['company']|escape:'htmlall':'UTF-8'}">
			</div>
			<div class="profile-box">
				<label>{l s='SIRET' mod='presmobileapp'} </label>
				<input type="text" onfocus="PreMobileProfileFocus(this)" onblur="PreMobileProfileUnfocus(this)" name="profilesiret" class="profile-confirmation-siret" value="{$cart['siret']|escape:'htmlall':'UTF-8'}">
			</div>	
			<div class="profile-box">
				<label>{l s='APE' mod='presmobileapp'} </label>
				<input type="text" onfocus="PreMobileProfileFocus(this)" onblur="PreMobileProfileUnfocus(this)" name="profileape" class="profile-confirmation-ape" value="{$cart['ape']|escape:'htmlall':'UTF-8'}">
			</div>	
			<div class="profile-box">
				<label>{l s='Website' mod='presmobileapp'} </label>
				<input type="text" onfocus="PreMobileProfileFocus(this)" onblur="PreMobileProfileUnfocus(this)" name="profileweb" class="profile-confirmation-web" value="{$cart['website']|escape:'htmlall':'UTF-8'}">
			</div>
			{/if}
			<div class="Presmobile-myaddress-block-check" style="margin-top:26px;">
				<input type="checkbox" name="newslettersigin" class="use-billing-choice" value ="1" {if $cart['newsletter'] == 1}checked {/if}>
				<span class="Presmobile-myaddress-checked">
					<div class="checked"></div>
				</span>
				<span style="padding-left: 21px;line-height: 20px;display: block;min-height: 20px;">{l s='Sign up for our newsletter!' mod='presmobileapp'}</span>
			</div>
			<div class="Presmobile-myaddress-block-check">
				<input type="checkbox" name="ip_registration" class="use-billing-choice" value ="1" {if !empty($cart['ip_registration_newsletter'])} checked {/if}>
				<span class="Presmobile-myaddress-checked">
					<div class="checked"></div>
				</span>
				<span style="padding-left: 21px;line-height: 20px;display: block;min-height: 20px;">{l s='Receive special offers from our partners!' mod='presmobileapp'}</span>
			</div>
		</form>
	</div>
</div>