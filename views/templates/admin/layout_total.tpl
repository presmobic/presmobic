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
{assign var='left_column_size' value=0}{assign var='right_column_size' value=0}

{if isset($smarty.request.ignore_redirect)}
	<script>
		var $ = jQuery.noConflict();
	</script>
	{if !empty($template)}{$template nofilter} {* no escape necessary *}{/if}
{else}
	{if isset($HOOK_LEFT_COLUMN) && $HOOK_LEFT_COLUMN|trim && !$hide_left_column}{$left_column_size=3}{/if}
	{if isset($HOOK_RIGHT_COLUMN) && $HOOK_RIGHT_COLUMN|trim && !$hide_right_column}{$right_column_size=3}{/if}
	{if !empty($display_header)}{include file="$tpl_dir./header.tpl" HOOK_HEADER=$HOOK_HEADER}{/if}
	{if !empty($template)}{$template nofilter} {* no escape necessary *}{/if}
	{if !empty($display_footer)}{include file="$tpl_dir./footer.tpl"}{/if}
	{if !empty($live_edit)}{$live_edit nofilter} {* no escape necessary *}{/if}
{/if}