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

<div class="bootstrap ba_error" id="demomodep" style="display:none;">
    <div class="module_error alert alert-danger">
        {l s='You are use ' mod='presmobileapp'}
        <strong>{l s='Demo Mode ' mod='presmobileapp'}</strong>
        {l s=', so some buttons, functions will be disabled because of security. ' mod='presmobileapp'}
        {l s='You can use them in Live mode after you puchase our module. ' mod='presmobileapp'}
        {l s='Thanks !' mod='presmobileapp'}
    </div>
</div>
<div class="panel col-lg-12">
<form id="form" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
    <h3>{l s='Edit img slider ' mod='presmobileapp'}</h3>
    {foreach from=$list_img_edit key=key_list_img item=value} 
    <div class="form-group col-lg-12">
            <label id="virtual_product_file_label" for="virtual_product_file" class="control-label col-lg-3 text-right required">{l s=' File' mod='presmobileapp'}</label>
            <div class="col-lg-6">
                <div class="form-group" style="margin-bottom: 10px;">
                    <div class="">
                        <div class="translatable-field1 "> 
                            <input id="fileToUpload{$value['id_lang']|escape:'htmlall':'UTF-8'}" type="file" name="fileToUpload[{$value['id_lang']|escape:'htmlall':'UTF-8'}]" class="hide ">
                            <input id="id_lang_img" name="id_lang_img" type="text" class="hide" value="{$value['id_lang']|escape:'htmlall':'UTF-8'}">
                            <input id="id_img" name="id_img" type="text" class="hide" value="{$value['id']|escape:'htmlall':'UTF-8'}">
                            <input id="images_tmp" name="images_tmp" type="text" class="hide" value="{$value['name']|escape:'htmlall':'UTF-8'}">
                            <input type="text" id="text_file{$value['id_lang']|escape:'htmlall':'UTF-8'}" class="form-control hide " name="name_file[{$value['id_lang']|escape:'htmlall':'UTF-8'}]" value="">
                            <div class="dummyfile input-group">
                                <span class="input-group-addon">
                                    <i class="icon-file"></i>
                                </span>
                                <input id="virtual_product_file_uploader-name{$value['id_lang']|escape:'htmlall':'UTF-8'}" type="text" name="filename[{$value['id_lang']|escape:'htmlall':'UTF-8'}]" readonly="" onclick="textfile({$value['id_lang']|escape:'htmlall':'UTF-8'})" value="{$value['name']|escape:'htmlall':'UTF-8'}">
                                <span class="input-group-btn">
                                    <button id="virtual_product_file_uploader-selectbutton" type="button" name="submitAddAttachments" class="btn btn-default" onclick="textfile({$value['id_lang']|escape:'htmlall':'UTF-8'})">
                                        <i class="icon-folder-open"></i>{l s='Add file' mod='presmobileapp'}</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="help-block">
                    {l s='Size image < 2MB.' mod='presmobileapp'}
                </p>
            </div>
        </div>
        <div class="form-group col-lg-12">
            <label class="control-label col-lg-3 text-right">{l s='Active' mod='presmobileapp'}</label>
            <div class="col-lg-6">
                <div class="translatable-field1 ">
                    <span class="switch prestashop-switch fixed-width-lg">
                        <input type="radio" name="active_add[{$value['id_lang']|escape:'htmlall':'UTF-8'}]" id="active_on_{$value['id_lang']|escape:'htmlall':'UTF-8'}" value="1" {if $value['active'] == 1} checked="checked"{/if} onclick="activeimg({$value['id_lang']|escape:'htmlall':'UTF-8'})">
                        <label for="active_on_{$value['id_lang']|escape:'htmlall':'UTF-8'}">
                            Yes
                        </label>
                        <input type="radio" name="active_add[{$value['id_lang']|escape:'htmlall':'UTF-8'}]" id="active_off_{$value['id_lang']|escape:'htmlall':'UTF-8'}" {if $value['active'] == 0} checked="checked"{/if} value="0" onclick="activeimg({$value['id_lang']|escape:'htmlall':'UTF-8'})">
                        <label for="active_off_{$value['id_lang']|escape:'htmlall':'UTF-8'}">
                            No
                        </label>
                        <a class="slide-button btn"></a>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group col-lg-12">
            <label class="control-label col-lg-3 text-right">{l s='Target URL' mod='presmobileapp'}</label>
            <div class="col-lg-6">
                <div class="translatable-field1">
                    <input type="text" id="urlimages{$value['id_lang']|escape:'htmlall':'UTF-8'}" name="urlimages[{$value['id_lang']|escape:'htmlall':'UTF-8'}]" value="{$value['url_images']|escape:'htmlall':'UTF-8'}">
                </div>
            </div>
        </div>
</form>
        <div class="panel-footer" style="clear: both;"> 
            <a href="{$redirect|escape:'htmlall':'UTF-8'}" class="btn btn-default"><i class="process-icon-cancel"></i>{l s='Cancel' mod='presmobileapp'}</a>
            <button type="button" name="submitEditSlider" class="btn btn-default pull-right" value="{$value['id']|escape:'htmlall':'UTF-8'}" onclick="baeditslider({$value['id_lang']})"><i class="process-icon-save" id="submitEditSlider"></i>{l s='Save' mod='presmobileapp'}</button>
        </div>
    {/foreach}
</div>
