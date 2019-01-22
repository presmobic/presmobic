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
{if $smarty.request.ignore_redirect == '1'}
	<script>
		var $ = jQuery.noConflict();
	</script>
	{if !empty($template)}{$template nofilter} {* no escape necessary *}{/if}
{else}
	{if !empty($display_header)}{include file="$tpl_dir./header.tpl" HOOK_HEADER=$HOOK_HEADER}{/if}
{/if}