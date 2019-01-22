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

<div class="panel col-lg-12">
<form id="form" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
    <h3>{l s='Cache App' mod='presmobileapp'}</h3>
    <div class="form-group col-lg-12">
            <label class="control-label col-lg-3 text-right">{l s='Time cache' mod='presmobileapp'}</label>
            <div class="col-lg-2">
                <div class="input-group ">
                    <input type="text" id="number" name="timecache" value="{$cacheapp|escape:'htmlall':'UTF-8'}"  onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" style="width: 50px;float: left;"><span class="input-group-addon" style="width: 0px;">{l s='Minutes' mod='presmobileapp'}</span>
                </div>
            </div>
    </div>
    <div class="form-group col-lg-12">
        <label class="control-label col-lg-3 text-right">
            <span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="Should be enabled except for debugging." style="margin-top: 5px;
    float: right;">
                {l s='Cache' mod='presmobileapp'}
            </span>
        </label>
            <div class="col-lg-6">
                <div class="translatable-field1 ">
                    <span class="switch prestashop-switch fixed-width-lg">
                        <input type="radio" name="cache_add" id="active_on" value="1" {if $cache_add == 1 } checked="checked"{/if}>
                        <label for="active_on">
                            Yes
                        </label>
                        <input type="radio" name="cache_add" id="active_off" value="0" {if $cache_add == 0 } checked="checked"{/if}>
                        <label for="active_off">
                            No
                        </label>
                        <a class="slide-button btn"></a>
                    </span>
                </div>
            </div>
    </div>
    <div class="form-group col-lg-9 col-md-offset-3" >
        <div class="clearfix row-padding-top" style="padding-top: 0px;">
            <button type="submit" name="clearcacheapp"class="btn btn-default">
                <i class="icon-eraser"></i>
                {l s='Clear cache' mod='presmobileapp'}
            </button>
        </div>
    </div>
    <div class="panel-footer" style="clear: both;"> 
            <button type="submit" name="submitcache" class="btn btn-default pull-right" ><i class="process-icon-save" id="submitcache"></i>{l s='Save' mod='presmobileapp'}</button>
    </div>
</form>
</div>
<div class="panel col-lg-12">
<form id="forma" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
    <h3>{l s='Debug Mode' mod='presmobileapp'}</h3>
    <div class="form-group col-lg-12">
        <label class="control-label col-lg-3 text-right">
            <span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="Should be enabled except for debugging." style="margin-top: 5px; float: right;"> {l s='Debug Mode' mod='presmobileapp'}</span>
        </label>
        <div class="col-lg-6">
            <div class="translatable-field1 ">
                <span class="switch prestashop-switch fixed-width-lg">
                    <input type="radio" name="debug_add" class="abcdg abcdg_1" id="active_on_mobi" value="1"  {if $debug_add == 1 } checked="checked"{/if}>
                    <label for="active_on_1" onclick="PresMobichoicemode(1)">
                        {l s='Yes' mod='presmobileapp'}
                    </label>
                    <input type="radio" name="debug_add" class="abcdg abcdg_0" id="active_off_mobi" value="0" {if $debug_add == 0 } checked="checked"{/if}>
                    <label for="active_off_0" onclick="PresMobichoicemode(0)">
                        {l s='No' mod='presmobileapp'}
                    </label>
                    <a class="slide-button btn"></a>
                </span>
            </div>
        </div>
    </div>
    {if $debug_add == 1 }
    <div class="form-group col-lg-12">
        <div class="col-lg-9 col-lg-offset-3">
            <div class="alert alert-warning">
                    {l s='The Presmobic is deactived in your store, you will need to use this URL to access your presmobic application: ' mod='presmobileapp'}
                <strong>
                    <a href="{$url|escape:'htmlall':'UTF-8'}{if $seourl== 0}index.php{/if}?secure={$mobi_secure|escape:'htmlall':'UTF-8'}" target="_blank">{$url|escape:'htmlall':'UTF-8'}{if $seourl== 0}index.php{/if}?secure={$mobi_secure|escape:'htmlall':'UTF-8'}</a>
                </strong>
                <span>
            </div>
        </div>
    </div>
    {/if}
    <div class="panel-footer" style="clear: both;"> 
            <button type="submit" name="submitdebug" class="btn btn-default pull-right"><i class="process-icon-save" id="submitdebug"></i>{l s='Save' mod='presmobileapp'}</button>
    </div>
</form>
</div>
