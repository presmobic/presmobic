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
{$presmobicBeforeComment nofilter} {* no escape necessary *}
<div class="PresMobilecomment-content PresMobilecomment PresMobilecomment-1 grid-comment" style="display: block;">
	<h4> {l s='Ratings & Reviews' mod='presmobileapp'}</h4>
	<div class="PresMobilecomment-top-block">
		<div class="ui-grid-a">
			<div class="ui-block-a">
				<div class="PresMobilebox-ratings">
					<span>{$comment['total']|escape:'htmlall':'UTF-8'}</span>
					<i class="fa fa-star"></i>
					<div class="PresMobilebox-count-ratings">
						<p>{$comment['countcomment']|escape:'htmlall':'UTF-8'}  {l s='rating &' mod='presmobileapp'}</p>
						<p>{$comment['countcomment']|escape:'htmlall':'UTF-8'}  {l s='reviews' mod='presmobileapp'}</p>
					</div>
				</div>
			</div>
			<div class="ui-block-b">
				{foreach from=$comment['rating_star'] key=key item=item}
				<div class="content-rating clearfix">
					<div class="side">
						<span>{$key|escape:'htmlall':'UTF-8'} </span><i class="fa fa-star"></i>
					</div>
					<div class="middle">
						<div class="bar-container">
							<div class="bar-{$key|escape:'htmlall':'UTF-8'}" style="width: {$item|escape:'htmlall':'UTF-8'}%; "></div>
						</div>
					</div>
				</div>
				{/foreach}
			</div>
		</div>
	</div>	
	{if $comment_check == '1'}
		{if $show_comment == '1'}
			<div class="PresMobilecomment-button"  onclick="PresMobileCommentPopup(2)">
				<button>
					{l s='rate and write a review' mod='presmobileapp'}
				</button>
			</div>
		{/if}
	{/if}
	{if !empty($comment['rating_star'])}
	{foreach from=$comment['comment'] key=key_c item=item_c}
	<div class="PresMobilecomment-bottom-block clearfix" >
		<div class="comment-images">
			<span class="ion-md-icon-account avata-account" style="font-size: 46px;text-align: center;color:  #000;"></span>
		</div>
		<div class="comment-box">
			<h5>{$item_c['customer_name']|escape:'htmlall':'UTF-8'}</h5>
			<div class="rating">
				{for $foo=1 to 5}
				<span class="ion-md-icon-star" {if $foo > {$item_c['grade']|escape:'htmlall':'UTF-8'}}style="color: #f1f1f1;"{/if}></span>
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
	{/if}
</div>
{$presmobicAfterComment nofilter} {* no escape necessary *}
<div class="PresMobilecomment-popup PresMobilecomment PresMobilecomment-2" style="display: none;">
	<form method="post" action="">
		<div class="coment-popup-header">
			<h4> {l s='Write a review' mod='presmobileapp'}</h4>
			<div class="close" onclick="PresMobileCommentPopup(1)">
				<span class="icon-ello-close"></span>
			</div>			
		</div>
		<div id="PresMobil-add-comment" class="ui-content" style="overflow: auto;">
			<h4> {l s='Comments about this product' mod='presmobileapp'}</h4>
			<div class="comment-rating clearfix">
				<span> {l s='Your Rating:' mod='presmobileapp'}</span>
				<div class="stars-rating">
					<input type="hidden" class="rating-value" name="rating-value" value="0">
					<div class="star 1-star" onclick="PreMobileRatingStar(this)" rating="1"></div>
					<div class="star 2-star" onclick="PreMobileRatingStar(this)" rating="2"></div>
					<div class="star 3-star" onclick="PreMobileRatingStar(this)" rating="3"></div>
					<div class="star 4-star" onclick="PreMobileRatingStar(this)" rating="4"></div>
					<div class="star 5-star" onclick="PreMobileRatingStar(this)" rating="5"></div>
				</div>
			</div>
			<div class="comment-content">
				<div class="form-group">
					<label class="PresMobiletitle"> {l s='Title' mod='presmobileapp'}</label>
					<input class="comment-name" type="text" name="title" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" onkeyup ="PreMobicheckComment()">
				</div>
				{if $cart['logged'] != '1'}
				<div class="form-group">
					<label class="PresMobiletitle"> {l s='Custom name' mod='presmobileapp'}</label>
					<input class="comment-customname" type="text" name="comment-name"  onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" onkeyup ="PreMobicheckComment()">
				</div>
				{/if}
				<div class="form-group" >
					<label class="PresMobiletitle">{l s='Description Comments... ' mod='presmobileapp'}</label>
					<textarea name="descriprtion" class="comment-descriprtion" onfocus="PreMobileInputFieldTransitionFocus(this)" onblur="PreMobileInputFieldTransitionUnfocus(this)" onkeyup ="PreMobicheckComment()"></textarea>
				</div>
			</div>
		</div>
		<div class="submit-comment disabledbutton" onclick="PresMobiaddComment({$id_product|escape:'htmlall':'UTF-8'})">
			{l s='post comment ' mod='presmobileapp'}
		</div>
	</form>
</div>
<div class="ui-grid-a">
	<div class="ba_load_lastest presmobi_loadting_comment">
		<img src="{$url|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/img/ajax-loader.gif" alt="">
	</div>
</div>