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
<div class="PresMobilesignup-content">
	<form method="post" action="" id="presmobi-sign-up">
		<div class="form-group">
			<ul class="list_gender">
				<li>
					<span class="">{l s='Title :' mod='presmobileapp'}</span> 
				</li>
				<li>
					<span>
						<input type="radio" name="id_gender" id="id_gender1" value="1">
						<div class="propertie-checked">
							<div></div>
						</div>
					</span>
					<span> {l s='Mr. ' mod='presmobileapp'}</span>
				</li>
				<li>
					<span>
						<input type="radio" name="id_gender" id="id_gender2" value="2"> 
						<div class="propertie-checked">
							<div></div>
						</div>
					</span>
					<span>  {l s='Mrs.' mod='presmobileapp'}</span>
				</li>
			</ul>
		</div>	
		<div class="form-group">
			<label class="PresMobiletitle" onclick="PreMobileSingUpLabelClick(this)">{l s='First name * ' mod='presmobileapp'}</label>
			<input type="text" name="first-name" autocomplete="off" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" class="first-name" required="" onkeyup="PresMobilecheckSignup()">
		</div>
		<div class="form-group">
			<label class="PresMobiletitle"  onclick="PreMobileSingUpLabelClick(this)"> {l s='Last name *' mod='presmobileapp'}</label>
			<input type="text" name="last-name" autocomplete="off" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" class="last-name" onkeyup="PresMobilecheckSignup()">
		</div>
		<div class="form-group">
			<label class="PresMobiletitle" onclick="PreMobileSingUpLabelClick(this)"> {l s='Email *' mod='presmobileapp'}</label>
			<input type="email" name="email" autocomplete="off" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)"  required="" class="email" onkeyup="PresMobilecheckSignup()">
		</div>
		<div class="form-group">
			<label class="PresMobiletitle" onclick="PreMobileSingUpLabelClick(this)"> {l s='Password *' mod='presmobileapp'}</label>
			<input type="password" name="password" autocomplete="off" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" class="password" onkeyup="PresMobilecheckSignup()">
		</div>
		<div class="form-group">
			<label class="PresMobiletitle" onclick="PreMobileSingUpLabelClick(this)"> {l s='Confirm password *' mod='presmobileapp'}</label>
			<input type="password" name="confirm-password" autocomplete="off" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" class="confirm-password" onkeyup="PresMobilecheckSignup()">
		</div>
		<div class="form-group">
			<label class="PresMobiletitle" style="top:20%;"> {l s='Date of Birth' mod='presmobileapp'}</label>
			<ul class="birth-day">
				<li>
					<select name="days" id="days">
						<option value="" selected="selected">{l s='Days' mod='presmobileapp'}</option>
						{for $days=1 to 31}
						<option value="{$days|escape:'htmlall':'UTF-8'}">{$days|escape:'htmlall':'UTF-8'}</option>
						{/for}
					</select>
				</li>
				<li>
					<select name="months" id="months">
						<option value="" selected="selected"> {l s='Months' mod='presmobileapp'}</option>
						<option value="1"> {l s='January' mod='presmobileapp'}</option>
						<option value="2">  {l s='February' mod='presmobileapp'}</option>
						<option value="3">  {l s='March' mod='presmobileapp'}</option>
						<option value="4">  {l s='April' mod='presmobileapp'}</option>
						<option value="5">  {l s='May' mod='presmobileapp'}</option>
						<option value="6">  {l s='June' mod='presmobileapp'}</option>
						<option value="7">  {l s='July' mod='presmobileapp'}</option>
						<option value="8">  {l s='August' mod='presmobileapp'}</option>
						<option value="9">  {l s='September' mod='presmobileapp'}</option>
						<option value="10">  {l s='October' mod='presmobileapp'}</option>
						<option value="11">  {l s='November' mod='presmobileapp'}</option>
						<option value="12">  {l s='December' mod='presmobileapp'}</option>
					</select>
				</li>
				<li>
					<select name="years" id="years">
						<option value="" selected="selected"> {l s='Years' mod='presmobileapp'}</option>
						{for $years= 1990 to $year}
						<option value="{$years|escape:'htmlall':'UTF-8'}">{$years|escape:'htmlall':'UTF-8'}</option>
						{/for}
					</select> 
				</li> 
			</ul> 
		</div>
		{if $b2b_enable == '1'}
		<div class="form-group" style="margin-top: 30px;">
			<label class="PresMobiletitle" >{l s='YOUR COMPANY INFORMATION' mod='presmobileapp'}</label>
		</div>
		<div class="form-group">
			<label class="PresMobiletitle" onclick="PreMobileSingUpLabelClick(this)">{l s='Company' mod='presmobileapp'}</label>
			<input type="text" name="companyname" autocomplete="off" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" class="first-name" required="" onkeyup="PresMobilecheckSignup()">
		</div>
		<div class="form-group">
			<label class="PresMobiletitle" onclick="PreMobileSingUpLabelClick(this)">{l s='SIRET' mod='presmobileapp'}</label>
			<input type="text" name="siret" autocomplete="off" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" class="first-name" required="" onkeyup="PresMobilecheckSignup()">
		</div>
		<div class="form-group">
			<label class="PresMobiletitle" onclick="PreMobileSingUpLabelClick(this)">{l s='APE' mod='presmobileapp'}</label>
			<input type="text" name="ape" autocomplete="off" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" class="first-name" required="" onkeyup="PresMobilecheckSignup()">
		</div>
		<div class="form-group">
			<label class="PresMobiletitle" onclick="PreMobileSingUpLabelClick(this)">{l s='Website' mod='presmobileapp'}</label>
			<input type="text" name="website" autocomplete="off" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" class="first-name" required="" onkeyup="PresMobilecheckSignup()">
		</div>
		{/if}
		<div class="Presmobile-myaddress-block-check" style="margin-top: 1.5em;">
			<input type="checkbox" name="newslettersigin" class="use-billing-choice" value ="1">
			<span class="Presmobile-myaddress-checked">
				<div class="checked"></div>
			</span>
			<span style="padding-left: 26px;line-height: 20px;display: block;min-height: 20px;color: #fff;">{l s='Sign up for our newsletter!' mod='presmobileapp'}</span>
		</div>
		<div class="Presmobile-myaddress-block-check">
			<input type="checkbox" name="ip_registration" class="use-billing-choice" value ="1">
			<span class="Presmobile-myaddress-checked">
				<div class="checked"></div>
			</span>
			<span style="padding-left: 26px;line-height: 20px;display: block;min-height: 20px;color: #fff;">{l s='Receive special offers from our partners!' mod='presmobileapp'}</span>
		</div>
		<div class="form-group PresMobilesignup-buttom disabledbutton" onclick="PresMobisingUp()">
			<div class="sign-up"> {l s='SIGN UP' mod='presmobileapp'}</div>
		</div>
		<div class="form-group PresMobilelogin-buttom">
			<span> {l s='Already have an account?' mod='presmobileapp'}</span><a onclick="PresMobibamobileroutes(this)" ba-link="#login" href="javascript:void(0)">{l s='Login' mod='presmobileapp'}</a>
		</div>
		<div class="form-group">
		</div>
	</form>
</div>