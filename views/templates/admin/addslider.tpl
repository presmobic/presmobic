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

<div class="bootstrap ba_error" id="demomode" style="display:none;">
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
    <h3>{l s='Add slider' mod='presmobileapp'}</h3>
    <div class="form-group col-lg-12">
            <label id="virtual_product_file_label" for="virtual_product_file" class="control-label col-lg-3 text-right required">{l s=' File' mod='presmobileapp'}</label>
            <div class="col-lg-6">
                <div class="form-group" style="margin-bottom: 10px;">
                    <div class="">
                        <input id="lang_default" type="text" class="hide" value="{$id_lang_default|escape:'htmlall':'UTF-8'}">
                    {foreach $languages key =key_lang item=value}
                        <div class="translatable-field1 lang1-{$value['id_lang']|escape:'htmlall':'UTF-8'}" style="{if $value['checked']==1}display: block;{/if}{if $value['checked']!=1}display: none;{/if}"> 
                            <input id="fileToUpload{$value['id_lang']|escape:'htmlall':'UTF-8'}" type="file" name="fileToUpload[{$value['id_lang']|escape:'htmlall':'UTF-8'}]" class="hide ">
                            <input type="text" id="text_file{$value['id_lang']|escape:'htmlall':'UTF-8'}" class="form-control hide {if $value['id_lang'] == $id_lang_default} id_lang_default {/if}" name="name_file[{$value['id_lang']|escape:'htmlall':'UTF-8'}]" value="">
                            <div class="dummyfile input-group">
                                <span class="input-group-addon">
                                    <i class="icon-file"></i>
                                </span>
                                <input id="virtual_product_file_uploader-name{$value['id_lang']|escape:'htmlall':'UTF-8'}" type="text" name="filename[{$value['id_lang']|escape:'htmlall':'UTF-8'}]" readonly="" onclick="textfile({$value['id_lang']|escape:'htmlall':'UTF-8'})">
                                <span class="input-group-btn">
                                    <button  type="button" name="submitAddAttachments" class="btn btn-default" onclick="textfile({$value['id_lang']|escape:'htmlall':'UTF-8'})">
                                        <i class="icon-folder-open"></i>{l s='Add file' mod='presmobileapp'}</button>
                                </span>
                            </div>
                        </div>
                    {/foreach}
                    </div>
                </div>
                <p class="help-block">
                    {l s='Size image < 2MB.' mod='presmobileapp'}
                </p>
            </div>
        {foreach $languages key =key_lang item=value}
            <div class="translatable-field1 lang1-{$value['id_lang']|escape:'htmlall':'UTF-8'}" style="{if $value['checked']==1}display: block;{/if}{if $value['checked']!=1}display: none;{/if}">
             <div class="col-lg-2">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
               {$value['iso_code']|escape:'htmlall':'UTF-8'}
               <span class="caret"></span>
              </button>
                  <ul class="dropdown-menu">
                      {foreach $languages key =key_lang item=value}
                      <li>
                      <a href="javascript:hideOtherLanguage1({$value['id_lang']|escape:'htmlall':'UTF-8'});">{$value['name']|escape:'htmlall':'UTF-8'}
                      </a></li>
                      {/foreach}
                  </ul>
             </div>
             </div>
        {/foreach}
        </div>
        <div class="form-group col-lg-12">
            <label class="control-label col-lg-3 text-right">{l s='Active' mod='presmobileapp'}</label>
            <div class="col-lg-6">
                {foreach $languages key =key_lang item=value}
                    <div class="translatable-field1 lang1-{$value['id_lang']|escape:'htmlall':'UTF-8'}" style="{if $value['checked']==1}display: block;{/if}{if $value['checked']!=1}display: none;{/if}">
                        <span class="switch prestashop-switch fixed-width-lg">
                            <input type="radio" name="active_add[{$value['id_lang']|escape:'htmlall':'UTF-8'}]" id="active_on_{$value['id_lang']|escape:'htmlall':'UTF-8'}" value="1" checked="checked" onclick="activeimg({$value['id_lang']|escape:'htmlall':'UTF-8'})">
                            <label for="active_on_{$value['id_lang']|escape:'htmlall':'UTF-8'}">
                                Yes
                            </label>
                            <input type="radio" name="active_add[{$value['id_lang']|escape:'htmlall':'UTF-8'}]" id="active_off_{$value['id_lang']|escape:'htmlall':'UTF-8'}" value="0" onclick="activeimg({$value['id_lang']|escape:'htmlall':'UTF-8'})">
                            <label for="active_off_{$value['id_lang']|escape:'htmlall':'UTF-8'}">
                                No
                            </label>
                            <a class="slide-button btn"></a>
                        </span>
                    </div>
                {/foreach}
            </div>
        </div>
        <div class="form-group col-lg-12">
            <label class="control-label col-lg-3 text-right">{l s='Target URL' mod='presmobileapp'}</label>
            <div class="col-lg-6">
                {foreach $languages key =key_lang item=value}
                <div class="translatable-field1 lang1-{$value['id_lang']|escape:'htmlall':'UTF-8'}" style="{if $value['checked']==1}display: block;{/if}{if $value['checked']!=1}display: none;{/if}">
                    <input type="text" id="urlimages{$value['id_lang']|escape:'htmlall':'UTF-8'}" name="urlimages[{$value['id_lang']|escape:'htmlall':'UTF-8'}]">
                </div>
                {/foreach}
            </div>
        </div>
</form>
    <div class="panel-footer" style="clear: both;">
        <a href="{$redirect|escape:'htmlall':'UTF-8'}" class="btn btn-default"><i class="process-icon-cancel"></i>{l s='Cancel' mod='presmobileapp'}</a>
        <button type="button" name="submitAddSlider" class="btn btn-default pull-right" onclick="basaveslider()"><i class="process-icon-save" id="submitAddSlider" ></i>{l s='Save' mod='presmobileapp'}</button>
       {*  <button type="submit" name="submitAddAndStaySlider" class="btn btn-default pull-right" style="margin-right: 6px;"><i class="process-icon-save" id="submitAddSlider"></i>{l s='Save And Stay' mod='presmobileapp'}</button> *}
    </div>
</div>
    