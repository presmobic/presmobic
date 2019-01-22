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
<form id="formsocial" method="POST" accept-charset="utf-8" enctype="multipart/form-data" class="form-horizontal col-lg-12">
    <h3>{l s='Social ' mod='presmobileapp'}</h3>
 	<div class="form-group col-lg-12">
        <label class="control-label col-lg-3 text-right">{l s='Facebook URL' mod='presmobileapp'}</label>
        <div class="col-lg-6">
            <input type="text" id="facebook" name="facebook" value="{$facebook|escape:'htmlall':'UTF-8'}">
        </div>
    </div>
    <div class="form-group col-lg-12">
        <label class="control-label col-lg-3 text-right">{l s='Twitter URL' mod='presmobileapp'}</label>
        <div class="col-lg-6">
            <input type="text" id="twitter" name="twitter" value="{$twitter|escape:'htmlall':'UTF-8'}">
        </div>
    </div>
    <div class="form-group col-lg-12">
        <label class="control-label col-lg-3 text-right">{l s='Google+ URL' mod='presmobileapp'}</label>
        <div class="col-lg-6">
            <input type="text" id="google" name="google" value="{$google|escape:'htmlall':'UTF-8'}">
        </div>
    </div>
	<div class="panel-footer" style="clear: both;">
    	<button type="submit" name="submitfooter" class="btn btn-default pull-right" ><i class="process-icon-save" id="submitfooter"></i>{l s='Save' mod='presmobileapp'}</button>
	</div>
</form>

</div>