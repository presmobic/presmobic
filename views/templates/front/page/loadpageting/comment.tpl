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
{foreach from=$comment['comment'] key=key_c item=item_c}
<div class="PresMobilecomment-bottom-block clearfix" >
	<div class="comment-images">
		<span class="ion-md-icon-account avata-account" style="font-size: 46px;text-align: center;color:  #000;"></span>
	</div>
	<div class="comment-box">
		<h5>{$item_c['customer_name']|escape:'htmlall':'UTF-8'}</h5>
		<div class="rating">
			{for $foo=1 to 5}
			<span class="ion-md-icon-star" {if $foo > $item_c['grade']}style="color: #f1f1f1;"{/if}></span>
			{/for}
			<span class="comment-date">
				{$item_c['date_add']|escape:'htmlall':'UTF-8'}
			</span>
		</div>
		<div class="coment-text">
			{$item_c['content']|escape:'htmlall':'UTF-8'}
		</div>
	</div>
</div>
{/foreach}