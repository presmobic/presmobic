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

<script src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/js/jsadmin.js"></script>
<script src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/js/baslideradmin.js"></script>
<script src="{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/views/js/iquery-ui-1.12.1.js"></script>
<script >
	var letme = 10;
	var start_bamobicgenimg = {$start_bamobicgenimg|escape:'htmlall':'UTF-8'}; 
	var b = 0;
	var limit = 10;
	var url_presmobileapp = "{$baseDir|escape:'htmlall':'UTF-8'}";
	var mobic_genimg = "{$mobic_genimg|escape:'htmlall':'UTF-8'}";
	var url2 = "{$url2|escape:'htmlall':'UTF-8'}";
	var url3 = "{$url3|escape:'htmlall':'UTF-8'}";
	$(function () {
		if (start_bamobicgenimg == 0) {
			ajax_genimg(letme);
		} else {
			$('.PresMobile-admin-popup-progress-block').remove();
		}
		$(".presmobileappba_premobic_slider tbody").sortable({
			opacity: 0.6,
			cursor: "move",
			update: function () {
				var position = new Array();
				$("tbody tr input").each(function (i) {
					position[i] = $(this).val();
				});
				var order = $(this).sortable("serialize") + "&action=updatePosition&position=" + position;
				$.post("{$baseDir|escape:'htmlall':'UTF-8'}modules/presmobileapp/ajax/PreMobi-updateslider.php", order);
			}
		});
		$(".presmobileappba_premobic_slider tbody").disableSelection();
	});
	function PresMobile_admin_popup_hide() {
		$('.PresMobile-admin-popup-progress-block').hide();
	}
	function PresMobichoicemode(id){
		$('.abcdg').removeAttr('checked');
		$('.abcdg_'+id).attr('checked','');
	}
	function ajax_genimg(letme){
		console.log(letme);
		$.post(""+url_presmobileapp+"modules/presmobileapp/ajax/PresMobi-genimage.php",
		{
			limit:letme
		},
		function (data, status) {
			var obj = jQuery.parseJSON(data);
			letme = obj.limit;
			if (obj.stop == 0) {
				ajax_genimg(letme);
				var b = ((letme-10)*100/{$product_gen|escape:'htmlall':'UTF-8'});
				$('.progress-bar-striped').css('width',b+'%');
				$('.abcd').html(letme-10);
			} else {
				var b = (letme*100/{$product_gen|escape:'htmlall':'UTF-8'});
				$('.progress-bar-striped').css('width',b+'%');
				$('.abcd').html(letme);
				setTimeout(function(){
					$('.PresMobile-admin-popup-progress-block').hide();
					return false;
				}, 5000);
			}
		});
	}
</script>
<style type="text/css" media="screen">
.bootstrap .progress-bar{
	min-width: 0px !important;
}
.presmobileappba_premobic_slider tbody tr{
	cursor: move;
}
.PresMobile-admin-popup-progress-block{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 99999;
}
.PresMobile-admin-popup-bg{
	position: absolute;
	width: 100%;
	height: 100%;
	z-index: 8;
	background: #000;
	opacity: 0.2;
}
.PresMobile-admin-popup-content{
	margin: auto;
	background: #fff;
	margin-top: 30px;
	padding: 30px;
	z-index: 9;
	position: relative;
	min-width: 500px;
	max-width: 50%;
	min-height: 240px;
}
.PresMobile-admin-popup-content > h2.title{
	margin: auto;
	font-size: 18px;
	margin-bottom: 15px;
	font-family: Open Sans,Helvetica,Arial,sans-serif;
	font-weight: 700;
	line-height: 1.2;
	color: #363a41;
}
.PresMobile-admin-popup-content .close{
	position: absolute;
	right: 30px;
	top: 20px;
	font-size: 32px;
	outline: none;
}
.PresMobile-admin-popup-content .icon-close{
	border-radius: 0;
	padding: 10px 15px;
}
.PresMobile-admin-popup-content .icon-close::before,
.PresMobile-admin-popup-content .icon-close::after{
	display: none;
	opacity: 0;
}
.PresMobile-admin-popup-content .icon-close:hover{
	color:#25c8e9 !important;
	background-color:#fff !important;
	border-color: #25c8e9 !important;
}
.PresMobile-admin-popup-content .close .icon-remove{
	font-size: 20px;
}
.PresMobile-admin-popup-content > h3.progress-title{
	margin: auto !important;
	//margin-bottom: 20px !important;
	border: none !important;
	font-family: Open Sans,Helvetica,Arial,sans-serif;
	text-transform: none !important;
}
.PresMobile-admin-popup-content .progress-block{
	padding-top: 30px;
	position: relative;
}
.PresMobile-admin-popup-content .count-progress{
	position: absolute;
	border: none !important;
	text-transform: none !important;
	margin:auto !important ;
	top: 0;
	right: 0;
	font-family: Open Sans,Helvetica,Arial,sans-serif;
	font-size: 14px;
}
.bootstrap .progress-bar{
	background-color:#25B9D7 !important;
}
.PresMobile-admin-popup-progress-block .progress{
	margin-bottom:0;
}
.progress-block h3.progress-count{
	margin: 0 !important;
	border: none !important;
	line-height: 2 !important;
	padding: 0 !important;
}
.progress-block .progress-value{
	max-width: 100%;
	padding: 0 5px;
}
@media only screen and (max-width: 500px) {
	.PresMobile-admin-popup-content{
		min-width:95%;
		max-width:95%;
	}
	.PresMobile-admin-popup-content{
		padding: 15px;
	}
	.PresMobile-admin-popup-content .close{
		right: 15px;
		top: 7px;
	}
}
@media only screen and (max-width: 360px) {
	.PresMobile-admin-popup-content{
		min-width: 100%;
		max-width:100%;
	}
}
</style>
{if $demoMode ==" 1"}
	<div class="bootstrap ba_error" >
		<div class="module_error alert alert-danger" >
			{l s='You are use ' mod='presmobileapp'}
			<strong>{l s='Demo Mode ' mod='presmobileapp'}</strong>
			{l s=', so some buttons, functions will be disabled because of security. ' mod='presmobileapp'}
			{l s='You can use them in Live mode after you puchase our module. ' mod='presmobileapp'}
			{l s='Thanks !' mod='presmobileapp'}
		</div>
	</div>
{/if}
<div class="PresMobile-admin-popup-progress-block">
	<div class="PresMobile-admin-popup-bg"></div>
	<div class="PresMobile-admin-popup-content">
		<h2 class="title">{l s='Regenerate thumbnails' mod='presmobileapp'}</h2>
		<button type="button" class="close" onclick="PresMobile_admin_popup_hide()">×</button>
		<h3 class="progress-title">{l s='Regeneration in progress...' mod='presmobileapp'}</h3>
		<div class="progress-block">
			<h3 class="count-progress">{l s='Regenerating' mod='presmobileapp'} (<span>#{$product_gen|escape:'htmlall':'UTF-8'}</span>)</h3>
			<div class="progress">
				<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
					<div class="progress-value" style="color: white;">
						<span class="abcd">0</span>/<span>{$product_gen|escape:'htmlall':'UTF-8'}</span>
					</div>
				</div>
			</div>
			<h3 class="progress-count"></h3>
		</div>
		<div class="btn btn-default pull-right" onclick="PresMobile_admin_popup_hide()">
			Close
		</div>
	</div>
</div>
<input class="hidden" name="id_shop" value=""></input>
<div class="row">
	<div style="margin-right: 0px;" class="col-lg-2">
		<div class="list-group">
			<a href="{$bamodule|escape:'htmlall':'UTF-8'}&token={$token|escape:'htmlall':'UTF-8'}&configure={$configure|escape:'htmlall':'UTF-8'}&task=Settings" style="text-align: left;" id="generaltotal" class="newdrop list-group-item group_block {if $taskbar == 'Settings' || $taskbar==''}active{/if}">
				{l s='General' mod='presmobileapp'}
			</a>
			<a href="{$bamodule|escape:'htmlall':'UTF-8'}&token={$token|escape:'htmlall':'UTF-8'}&configure={$configure|escape:'htmlall':'UTF-8'}&task=slider" style="text-align: left;" id="slide" class="newdrop list-group-item group_block {if $taskbar == 'slider'}active{/if}">
				{l s='Slider' mod='presmobileapp'}
			</a>
			<a href="{$bamodule|escape:'htmlall':'UTF-8'}&token={$token|escape:'htmlall':'UTF-8'}&configure={$configure|escape:'htmlall':'UTF-8'}&task=plugins" style="text-align: left;" id="general" class="newdrop list-group-item group_block  {if $taskbar == 'plugins'}active{/if}">
				{l s='Blocks' mod='presmobileapp'}
			</a>
			<a href="{$bamodule|escape:'htmlall':'UTF-8'}&token={$token|escape:'htmlall':'UTF-8'}&configure={$configure|escape:'htmlall':'UTF-8'}&task=footeradmin" style="text-align: left;" id="general" class="newdrop list-group-item group_block  {if $taskbar == 'footeradmin'}active{/if}">
				{l s='Footer' mod='presmobileapp'}
			</a>
		</div>
	</div>
	<div class="col-lg-10 {if $taskbar == 'Settings' || $taskbar==''} {else}hidden{/if}" id="Settings">
		{if !empty($html_setting)} 
		{$html_setting nofilter} {* no escape necessary *}
		{/if}
	</div>
	<div class="col-lg-10 {if $taskbar == 'slider'} {else}hidden{/if} " id="slider">
		{if !empty($html_slider)} 
		{if $add_new == 1}
		{$html_add nofilter} {* no escape necessary *}
		{elseif $updateslider == 1}
		{$html_add nofilter} {* no escape necessary *}
		{else}
		{$html_slider nofilter} {* no escape necessary *} 
		{/if}
		{/if}
	</div>
	<div class="col-lg-10 {if $taskbar == 'footeradmin'} {else}hidden{/if} " id="slider">
		{if !empty($footeradmin)}
			{$footeradmin nofilter} {* no escape necessary *}
		{/if}
	</div>
	<div class="col-lg-10 {if $taskbar == 'plugins'} {else}hidden{/if}" id="general">
		<div class="panel general-panel">
			<div class="panel-heading">
				<i class="icon-cogs"></i>
				{l s='BLOCKS MANAGER' mod='presmobileapp'}
			</div>
			<div id="moduleContainer" class="row">
				<table id="module-list" class="table">
					<tbody>
						{foreach from=$block key=key_data item=item_data}
						<tr>
							<td>
								<input type="checkbox" name="modules" value="{$item_data['name']|escape:'htmlall':'UTF-8'}">
							</td>
							<td>
								<div id="anchor">
									<div class="module_name">
										{$item_data['displayName']|escape:'htmlall':'UTF-8'}
										{if $item_data['active'] == '1'}
										<span class="label label-info">{l s='Active' mod='presmobileapp'}
										</span>
										{/if}
										{if $item_data['active'] == '0'}
										<span class="label label-warning">{l s='Inactive' mod='presmobileapp'}</span>
										{/if}
										<p class="module_description">
											<small>
												v{$item_data['version']|escape:'htmlall':'UTF-8'}
											</small>
										</p>
									</div>
								</div>
							</td>
							<td>
								{$item_data['description'] nofilter} {* no escape necessary *}
							</td>
							<td>
								<div class="btn-group-action">
									<div class="btn-group">
										{if $item_data['install'] == 0}
										<a class="btn btn-success" href="?controller=AdminModules&token={$token|escape:'htmlall':'UTF-8'}&configure=presmobileapp&tab_module=shipping_logistics&module_name=presmobileapp&bainstall=1&key={$key_data|escape:'htmlall':'UTF-8'}" style="border-bottom-right-radius: 3px !important; border-top-right-radius: 3px !important;">
											<i class="icon-plus-sign-alt"></i>&nbsp;{l s='Install' mod='presmobileapp'}
										</a>
										{/if}
										{if $item_data['install'] == 1}
										{if $item_data['active'] == '0'}
										<a class="btn btn-default" href="?controller=AdminModules&token={$token|escape:'htmlall':'UTF-8'}&configure=presmobileapp&tab_module=shipping_logistics&module_name=presmobileapp&baenable=1&key={$key_data|escape:'htmlall':'UTF-8'}" onclick="" title="">
											<i class="icon-off"></i> {l s='Enable' mod='presmobileapp'}
										</a>
										{/if}
										{if $item_data['active'] != '0'}
										<a class="btn btn-default" href="?controller=AdminModules&token={$token|escape:'htmlall':'UTF-8'}&configure=presmobileapp&tab_module=shipping_logistics&module_name=presmobileapp&badisablel=1&key={$key_data|escape:'htmlall':'UTF-8'}" onclick="" title="Disable"><i class="icon-off"></i> {l s='Disable' mod='presmobileapp'}</a>
										{/if}
										{/if}
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<span class="caret">&nbsp;</span>
										</button>
										<ul class="dropdown-menu">
											{if $item_data['install'] == 1}
											{if $item_data['active'] != '0'}
											<li>
												<a class="" href="?controller=AdminModules&token={$token|escape:'htmlall':'UTF-8'}&configure=presmobileapp&tab_module=shipping_logistics&module_name=presmobileapp&baenable=1&key={$key_data|escape:'htmlall':'UTF-8'}" onclick="" title="">
													<i class="icon-off"></i> {l s='Enable' mod='presmobileapp'}
												</a>
											</li>
											{/if}
											{/if}
											{if $item_data['install'] == 1}
											{/if}
										</ul>
									</div>
								</div>
							</td>
						</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
