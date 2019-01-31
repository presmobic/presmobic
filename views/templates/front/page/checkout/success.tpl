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
<div class="prestashop-checkout-succes">
	<div class="prestashop-block-order-sussces">
		<span class="ion-ios-icon-order-list"></span>
		<label>
			{l s='You can review your order' mod='presmobileapp'}!
		</label>
		<a class="prestashop-myorder-button" onclick="PresMobibamobileroutes(this)" ba-link="#order">
			{l s='My order' mod='presmobileapp'}
		</a>
	</div>
	{$hook_displayPaymentReturn nofilter} {* no escape necessary *}
</div>