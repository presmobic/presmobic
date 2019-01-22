<?php
/**
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
*/

$re_link = array(
    'product'=>array(
        'controller' => 'product',
        'args' => array(
            0=>'id_product'
        )
    ),
    'category'=>array(
        'controller' => 'category',
        'args' => array(
            0=>'id_category'
        )
    ),
    'cms' =>array(
        'controller' => 'cms',
        'args' => array(
            0=>'id_cms'
        )
    ),
    'order' =>array(
        'controller' => 'history',
        'args' => array()
    ),
    'merchandisereturns'=>array(
        'controller' => 'orderfollow',
        'args' => array()
    ),
    'creditslips' =>array(
        'controller' => 'orderslip',
        'args' => array()
    ),
    'myaddressbycustomer' =>array(
        'controller' => 'addresses',
        'args' => array()
    ),
    'myvouchers' =>array(
        'controller' => 'discount',
        'args' => array()
    ),
    'contact' =>array(
        'controller' => 'contact',
        'args' => array()
    ),
    'cart' =>array(
        'controller' => 'orderopc',
        'args' => array()
    ),
    'account' =>array(
        'controller' => 'myaccount',
        'args' => array()
    )
);
$hook_un = array(
    'displayTop'=> array(
        0=>'blocksearch',
        1=>'blockcart',
        2=>'blocktopmenu',
        3=>'blockuserinfo',
        4=>'sekeywords',
        5=>'blockwishlist',
        6=>'demopresmobileapp'
    ),
    'displayHeader'=> array(
        0=>'socialsharing',
        1=>'blockbanner',
        2=>'blockbestsellers',
        3=>'blockcart',
        4=>'blocksocial',
        5=>'blockcategories',
        6=>'blockcurrencies',
        7=>'blockfacebook',
        8=>'blocklanguages',
        9=>'blocklayered',
        10=>'blockcms',
        11=>'blockcontact',
        12=>'blockcontactinfos',
        13=>'blockmanufacturer',
        14=>'blockmyaccount',
        15=>'blockmyaccountfooter',
        16=>'blocknewproducts',
        17=>'blockpaymentlogo',
        18=>'blocksearch',
        19=>'blockspecials',
        20=>'blockstore',
        21=>'blocksupplier',
        22=>'blocktags',
        23=>'blockuserinfo',
        24=>'blockviewed',
        25=>'homeslider',
        26=>'homefeatured',
        27=>'productpaymentlogos',
        28=>'themeconfigurator',
        29=>'productcomments',
        30=>'blockwishlist',
        31=>'favoriteproducts',
        32=>'blocknewsletter',
        33 =>'demopresmobileapp'
    ),
    'displayNav'=> array(
        0=>'blockuserinfo',
        1=>'blockcurrencies',
        2=>'blocklanguages',
        3=>'blockcontact'
    ),
    'displayHome'=> array(
        0=>'themeconfigurator',
        1=>'blockfacebook',
        2=>'blockcmsinfo',
        3=> 'ps_imageslider',
        4=>'ps_featuredproducts',
        5=>'ps_banner',
        6=> 'ps_customtext'
    ),
    'displayHomeTab'=> array(
        0=>'blocknewproducts',
        1=>'homefeatured',
        2=>'blockbestsellers'
    ),
    'displayHomeTabContent'=> array(
        0=>'blocknewproducts',
        1=>'homefeatured',
        2=>'blockbestsellers'
    ),
    'displayFooter'=> array(
        0=>'blocksocial',
        1=>'blockcategories',
        2=>'blockcms',
        3=>'blockmyaccountfooter',
        4=>'blockcontactinfos',
        5=>'statsdata',
        6=>'themeconfigurator',
        7=>'blocknewsletter',
        8=>'presmobileapp',
        9=>'ps_contactinfo',
        10=>'ps_linklist',
        11=>'ps_customeraccountlinks',
        12=>'ps_contactinfo'
    ),
    'displayLeftColumnProduct'=> array(
        0=>'favoriteproducts',
        1=>'ps_sharebuttons'
    ),
    'displayRightColumnProduct'=> array(
        0=>'socialsharing',
        1=>'productcomments'
    ),
    'displayProductButtons'=> array(
        0=>'productpaymentlogos',
        1=>'blockwishlist',
        2=>'ps_sharebuttons'
    ),
    'displayProductTab'=> array(
        0=>'productcomments',
        1=>'ps_sharebuttons'
    ),
    'displayProductTabContent'=> array(
        0=>'productcomments',
        1=>'ps_sharebuttons'
    ),
    'displayCustomerAccount'=> array(
        0=>'blockwishlist',
        1=>'favoriteproducts'
    ),
    'displayProductComparison'=> array(
        0=>'productcomments'
    ),
    'displayProductListFunctionalButtons' => array(
        0=>'blockwishlist'
    )
);
$hook_re = array(
    0=>'presmobicDisplayBeforeHeader',
    1=>'presmobicDisplayBeforeLogo',
    2=>'presmobicDisplayAfterLogo',
    3=>'presmobicDisplayBeforeMiniCart',
    4=>'presmobicDisplayAfterMiniCart',
    5=>'presmobicDisplayAfterHeader',
    6=>'presmobic_displayBeforeFooter',
    7=>'presmobic_displayBeforeHomeFooter',
    8=>'presmobic_displayBeforeCategoryFooter',
    9=>'presmobic_displayBeforeSearchFooter',
    10=>'presmobic_displayBeforeMeFooter',
    11=>'presmobicDisplayAfterFooter',
    12=>'presmobic_get_product_data',
    13=>'presmobic_before_add_to_cart',
    14=>'presmobicDisplayBeforeSlider',
    15=>'presmobicDisplayAfterSlider',
    16=>'presmobicGetSlideData',
    17=>'presmobicDisplayBeforeLatestTitle',
    18=>'presmobicDisplayAfterLatestTitle',
    19=>'presmobicGetLatestCategoriesData',
    20=>'presmobicDisplayBeforeLatestContent',
    21=>'presmobicDisplayAfterLatestContent',
    22=>'presmobicDisplayBeforeOurClients',
    23=>'presmobicDisplayAfterOurClients',
    24=>'presmobicGetClientsData',
    25=>'presmobicDisplayBeforeOurCategories',
    26=>'presmobicDisplayAfterOurCategories',
    27=>'presmobicGetOurCategoriesData',
    28=>'presmobicDisplayBeforeFeaturedBrands',
    29=>'presmobicDisplayAfterFeaturedBrands',
    30=>'presmobicGetBrandsData',
    31=>'presmobicDisplayBeforeTextStatic',
    32=>'presmobicDisplayFooter',
    33=>'presmobicDisplayBeforeNewsletter',
    34=>'presmobicDisplayAfterNewsletter',
    35=>'presmobicBeforeUpdateEmailNewsletter',
    36=>'presmobicDisplayBeforeFooterText',
    37=>'presmobicDisplayAfterFooterText',
    38=>'presmobicDisplayBeforeSocialFooter',
    39=>'presmobicDisplayAfterSocialFooter',
    41=>'presmobic_displayBeforeMainCategory',
    42=>'presmobic_displayAfterMainCategory',
    43=>'presmobic_displayBeforeCategory',
    44=>'presmobic_displayAfterCategory',
    45=>'presmobic_displayBeforeSubCategoryBar',
    46=>'presmobic_displayBeforeFilterBar',
    47=>'presmobic_displayBeforeSortBar',
    48=>'presmobic_displayBeforeLayoutBar',
    49=>'presmobic_filterArray',
    50=>'presmobic_sortArray',
    51=>'presmobic_displayBeforeProductDetail',
    52=>'presmobic_instock',
    53=>'presmobic_displayBeforeImages',
    54=>'presmobic_displayAfterImages',
    55=>'presmobic_productImages',
    56=>'presmobic_bookmark',
    57=>'presmobic_favorites',
    58=>'presmobic_productprice',
    59=>'presmobic_displayBeforeProductName',
    60=>'presmobic_displayAfterProductName',
    61=>'presmobic_displayBeforeQuantityBox',
    62=>'presmobic_displayAfterQuantityBox',
    63=>'presmobic_displayBeforeSheetData',
    64=>'presmobic_displayAfterSheetData',
    65=>'presmobic_displayBeforeDescription',
    66=>'presmobic_displayAfterDescription',
    67=>'presmobic_displayAfterBuyerProtection',
    68=>'presmobic_displayBeforeLookAtProduct',
    69=>'presmobic_displayAfterLookAtProduct',
    70=>'presmobic_afteraccountSetting',
    71=>'presmobic_beforeaccountSetting',
    72=>'presmobic_beforeaccountInfomartion',
    73=>'presmobic_afteraccountInfomartion',
    74=>'presmobic_afterOrder',
    75=>'presmobic_beforeOrder',
    76=>'presmobic_beforeOrderShipping',
    77=>'presmobic_afterOrderShipping',
    78=>'presmobic_afterOrderProduct',
    79=>'presmobic_beforeOrderProduct',
    80=>'presmobic_afterOrderProduct',
    81=>'presmobic_beforeOrderProduct',
    82=>'presmobic_afterOrderPayment',
    83=>'presmobic_beforeOrderPayment',
    84=>'presmobic_afterOrderRma',
    85=>'presmobic_beforeOrderRma',
    86=>'presmobic_afterDiscount',
    87=>'presmobic_beforeDiscount',
    88=>'presmobic_afterFavorite',
    89=>'presmobic_beforeFavorite',
    90=>'presmobic_afterWishlist',
    91=>'presmobic_beforeWishlist',
    92=>'presmobic_afterAddress',
    93=>'presmobic_beforeAddress',
    94=>'presmobic_afterCartProduct',
    95=>'presmobic_beforeCartProduct',
    96=>'presmobic_beforeCartCoupon',
    97=>'presmobic_afterCartCoupon',
    98=>'presmobicGetDataProductCart',
    99=>'presmobicBeforeCartBoxQuantity',
    100=>'presmobicAfterCartBoxQuantity',
    101=>'presmobicBeforeCartSubmitCoupon',
    102=>'presmobicAfterCartSubmitCoupon',
    103=>'presmobicBeforeCartSubmitCheckout',
    104=>'presmobicAfterCartSubmitCheckout',
    105=>'presmobicBeforeCartSubmitDeleteProduct',
    106=>'presmobicAfterCartSubmitDeleteProduct',
    107=>'presmobicBeforeAddAddress',
    108=>'presmobicBeforeSubmitAddAddress',
    109=>'presmobicAfterSubmitAddAddress',
    110=>'presmobicAfterAddAddress',
    111=>'presmobicBeforeAddNewWishlist',
    112=>'presmobicAfterAddNewWishlist',
    113=>'presmobicGetDataWishlist',
    114=>'presmobicBeforeDeleteWishlist',
    115=>'presmobicAfterDeleteWishlist',
    116=>'presmobicBeforeWishlistById',
    117=>'presmobicBeforeSendWishlistById',
    118=>'presmobicAfterSendWishlistById',
    119=>'presmobicGetDataProductWishlistById',
    120=>'presmobicBeforeDeleteWishlistById',
    121=>'presmobicAfterDeleteWishlistById',
    122=>'presmobicBeforeSaveWishlistById',
    123=>'presmobicAfterSaveWishlistById',
    124=>'presmobicAfterWishlistById',
    125=>'presmobicGetDataFavorite',
    126=>'presmobicBeforeDeleteFavorite',
    127=>'presmobicAfterDeleteFavorite',
    128=>'presmobicBeforeContacUs',
    129=>'presmobicBeforeSubmitContacUs',
    130=>'presmobicAfterSubmitContacUs',
    131=>'presmobicAfterContacUs',
    132=>'presmobicBeforeComment',
    133=>'presmobicGetDataComment',
    134=>'presmobicAfterComment',
    135=>'presmobicBeforeLogin',
    136=>'presmobicBeforeSubmitLogin',
    137=>'presmobicBeforeSubmitLogin',
    138=>'presmobicAfterLogin',
    139=>'presmobicBeforeSignUp',
    140=>'presmobicBeforeSubmitSignUp',
    141=>'presmobicBeforeSubmitSignUp',
    142=>'presmobicAfterSignUp'
);
define('_PS_MOBIC_HOOK_RE_', json_encode($hook_re));
define('_PS_MOBIC_HOOK_', json_encode($hook_un));
define('_PS_MOBIC_REDRIEC_', json_encode($re_link));
