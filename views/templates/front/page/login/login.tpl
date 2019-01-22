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

{$presmobicBeforeLogin nofilter} {* no escape necessary *}
<div class="PresMobilebox-content">
	<form method="post" action="">
		<div class="form-group">
			<label class="PresMobiletitle" onclick="PreMobileSingUpLabelClick(this)">Email *</label>
			<input  type="email" autocomplete="false" name="user_name" class="form-control login_user_name"  onfocus="this.removeAttribute('readonly'),PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required="" onkeyup="PreMobichecklogin(event)">
		</div>
		<div class="form-group">
			<label class="PresMobiletitle" onclick="PreMobileSingUpLabelClick(this)">Password *</label>
			<input type="password" name="password" autocomplete="false" class="login_user_pass"  onfocus="this.removeAttribute('readonly'),PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" required=""  onkeyup="PreMobichecklogin(event)">
		</div>
		<div class="form-group PresMobileforgot-pw">
			<label onclick="PresMobileLoginPu()">{l s='Forgot password? ' mod='presmobileapp'}</label>
		</div>
		<div class="form-group PresMobilelogin-buttom disabledbutton">
			<div class="submit-form" onclick="PreMobilogin()"> {l s='LOGIN' mod='presmobileapp'}</div>
		</div>
	</form>
	<div class="PresMobilesingup">
		<div class="PresMobilesignup-link" >
			<label> {l s='Not a member yes?' mod='presmobileapp'}<a onclick="PresMobibamobileroutes(this)" ba-link="#signup" href="javascript:void(0)"> {l s='Sign up' mod='presmobileapp'}</a></label>
		</div>
	</div>
	<div class="PresMobilelogin-success" style="display: none;">
		<span>{l s='Link sent successfully ' mod='presmobileapp'}</span>
	</div>
</div>
<div class="PresMobileforgot-pu">
	<div class='bg-gorgot-pw' onclick="PresMobileClosePu()"></div>
	<div class="PresMobilepopup-content" onblur="PresMobileClosePu()">
		<div class="close" onclick="PresMobileClosePu()">
			<i class="fa fa-times"></i>
		</div>
		<h5>{l s='Forgot password? ' mod='presmobileapp'}</h5>
		<label>
			{l s='In order to receive your access code by email, please enter the address you provided during the registration process.' mod='presmobileapp'}
		</label>
		<form>
			<div class="form-group">
				<input type="email"  name="user_name" class="form-control user_email_resert" placeholder="Email" required="">
			</div>
			<div class="form-group" onclick="PrerMobiresertPassword()">
				<div class="forot-pw">
				{l s='Send reset link' mod='presmobileapp'}</div>
			</div>
		</form>
	</div>
</div>
{$presmobicAfterLogin nofilter} {* no escape necessary *}