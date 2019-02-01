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

var load_page = 0;
var PresMobi_scroll = 0;
var start_limit =0;
var choice_category_lastest = 2;
var start_ajax = 1;
var category_list = 2;
var run_loading = 1;
var view_category = 1;
var view_product = 1;
var array_port = ['http','https'];
var array_back = [];
var page_array = ['ordermessenger','mywishlistbyid','myvouchers','checkoutonestep','contact','merchandisereturns','privacypolicy','about','termsofuse','creditslips','myaddressbycustomer','myaddress','home','category','latest','product','login','forgotpassword','order','orderbyid','comment','checkoutaddress','checkoutsuccess','signup','favorite','profile','cart','checkoutcart','checkoutpayment','search','account','wishlist'];
 $(document).ready(function () {
    $( ".controller-autoload" ).click(function() {
      var add_controller =  $(this).attr('ba-link');
      if (add_controller != '') {
        PresMobibamobileroutes(this);
      }
    });
    if (cache_add == 1) {
        var time_cache = cacheapp * 60;
        function PresMobiClearCache(){
            setInterval(function(){ 
                $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-clearcache.php?token_pres="+token_pres,
                {
                },
                function (data, status) {
                });
            }, time_cache);
        }
    }
    PreMobisetCookie('choiceCategory',2);
    var checkcomment = PreMobigetCookie('checkcomment');
    if (checkcomment == '') {
        PreMobisetCookie('checkcomment', 0);
    }
    var link = window.location.href;
    var controllers = link.split("#").pop();
    $('.payment_module a').attr('data-prefetch','');
    controller = controllers.split(":").shift();
    if (jQuery.inArray( controller, array_port ) < 0) {
        array_back.push(link);
        $('#home').css('display','none');
        $('.footer-app .menu-select').removeClass('ba-active');
        var check_arg = controllers.search(":");
        var argument = '';
        if (check_arg != '-1') {
            argument = controllers.replace(""+controller+":", "");
        }
        var check = 0;
        if (controller == 'category') {
            $(":mobile-pagecontainer").pagecontainer("change", "#category", {
                transition: 'none'
            });
            $('.footer-app .redcategory').addClass('ba-active');
            check = 1;
        }
        if (controller == 'home') {
            $(":mobile-pagecontainer").pagecontainer("change", "#home", {
                transition: 'none'
            });
            $('.footer-app .redhome').addClass('ba-active');
            check = 0;
        }
        if (controller == 'search') {
            $(":mobile-pagecontainer").pagecontainer("change", "#search", {
                transition: 'none'
            });
            $('.footer-app .redsearch').addClass('ba-active');
            check = 1;
        }
        if (controller == 'account') {
            $(":mobile-pagecontainer").pagecontainer("change", "#account", {
                transition: 'none'
            });
            $('.footer-app .redaccount').addClass('ba-active');
            check = 1;
        }
        if (argument != '') {
            window.location.hash = '#'+controller+':'+argument+''; 
        } else {
            window.location.hash = '#'+controller+'';
        }
        if (check == '0') {
            $.post("" + url_presmobileapp + "?fc=module&module=presmobileapp&controller=baloadpage&ajax=1&token_pres="+token_pres,
            {
                controllers: "#"+controller+"",
                argument: argument,
            },
            function (data, status) {
                load_page = 1;
                var obj = jQuery.parseJSON(data);
                $('title').html(obj.batitle);
                $('meta[name="description"]').attr('content',obj.description);
                $('#'+obj.controller+'').css('display','block');
                $(".content-"+obj.controller+"").html(obj.content);
                $('.premobile-title-'+obj.controller+'').html(obj.chir);
                $(".content-"+obj.controller+"").css('display','block');
                if (obj.controller == 'checkoutpayment') {
                    $('a').attr('data-ajax','false');
                }
                $( "div#range-slider" ).rangeslider();
                renderslide();
                PreMobicheckaddress();
                presMobiTouch();
                $('.owl-dot').removeClass('ui-btn ui-shadow ui-corner-all');
                PresMobileChangePayment();
                if (obj.controller == 'orderbyid') {
                    if (obj.invoice_number == '0') {
                        $('.pdf_order .icon-icondowload-pdf').hide();
                    } else {
                        $('.icon-icondowload-pdf').attr('href',url_presmobileapp+'?controller=pdf-invoice&id_order='+obj.id_order);
                        $('.pdf_order .icon-icondowload-pdf').show();
                    }
                    $('.all-messenger').html(obj.count_mess);
                    $('.ordermessenger_d h5').attr('ba-link','#ordermessenger:'+obj.id_order);
                }
                if (obj.controller == 'checkoutonestep') {
                    $(".presmobi-payment a").each(function () {
                        var demo = $(this).attr('href');
                        position = demo.indexOf(url_presmobileapp);
                        if (position == '0') {
                            $(this).attr('data-ajax','false');
                            $(this).attr('onclick','PresMobichoisepaymentoncheckout(this)');
                            if (check_ssl == '0') {
                                $(this).attr('link',demo+'&ignore_redirect=1');
                            } else {
                                $(this).attr('link',demo+'?ignore_redirect=1');
                            }
                            $(this).attr('href','');
                        }
                    });
                }
            });
        }
        if (argument != '' && check == '1') {
            $.post("" + url_presmobileapp + "?fc=module&module=presmobileapp&controller=baloadpage&ajax=1&token_pres="+token_pres,
            {
                controllers: "#"+controller+"",
                argument: argument
            },
            function (data, status) {
                load_page = 1;
                var obj = jQuery.parseJSON(data);
                $('title').html(obj.batitle);
                $('meta[name="description"]').attr('content',obj.description);
                $('#'+obj.controller+'').css('display','block');
                $('.footer-app .red'+obj.controller+'').addClass('ba-active');
                $(".content-"+obj.controller+"").html(obj.content);
                $('.premobile-title-'+obj.controller+'').html(obj.chir);
                $(".content-"+obj.controller+"").css('display','block');
                if (obj.controller == 'checkoutpayment') {
                    $('a').attr('data-ajax','false');
                }
                if (obj.controller == 'orderbyid') {
                    if (obj.invoice_number == '0') {
                        $('.pdf_order .icon-icondowload-pdf').hide();
                    } else {
                        $('.icon-icondowload-pdf').attr('href',url_presmobileapp+'?controller=pdf-invoice&id_order='+obj.id_order);
                        $('.pdf_order .icon-icondowload-pdf').show();
                    }
                    $('.all-messenger').html(obj.count_mess);
                    $('.ordermessenger_d h5').attr('ba-link','#ordermessenger:'+obj.id_order);
                }
                if (obj.controller == 'checkoutonestep') {
                    $(".presmobi-payment a").each(function () {
                        var demo = $(this).attr('href');
                        position = demo.indexOf(url_presmobileapp);
                        if (position == '0') {
                            $(this).attr('data-ajax','false');
                            $(this).attr('onclick','PresMobichoisepaymentoncheckout(this)');
                            if (check_ssl == '0') {
                                $(this).attr('link',demo+'&ignore_redirect=1');
                            } else {
                                $(this).attr('link',demo+'?ignore_redirect=1');
                            }
                            $(this).attr('href','');
                        }
                    });
                }
                PresMobileChangePayment();
                $( "div#range-slider" ).rangeslider();
                renderslide();
                PreMobicheckaddress();
                presMobiTouch();
                $('.owl-dot').removeClass('ui-btn ui-shadow ui-corner-all');
                PresMobileCheckOutAddressCheckFields();
            });
        }
    }
    $('.owl-carousel .owl-dot').removeClass('ui-btn ui-shadow ui-corner-all');
    $('.owl-carousel').owlCarousel({
        autoplay:true,
        autoplayTimeout:3000,
        loop:true,
        margin:10,
        nav:true,
        nav:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    });
    $('body').on('focus',".democlick", function(){
        var clipboard = new ClipboardJS('.btn');
        clipboard.on('success', function(e) {
            PreMobimessenger('success','Copy link success.');
        });
        clipboard.on('error', function(e) {
        });
    });
    $('.ui-btn-null').css('left','0');
 });
function PresMobiaddToCart(id_product,price,type){
    var data_attribute = '';
    var quantity = 1;
    if (type == '1') {
        $(".select_attribute").each(function () {
            var ischecked = $(this).is(":checked");
            if (ischecked) {
                data_attribute += $(this).val() + ",";
            } 
        });
        var bc = $('.selected_attribute').val();
        if (typeof bc !== "undefined") {
            data_attribute += bc + ",";
        }
        quantity = $('.premobile_quantity').val();
    }
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-addtocart.php?token_pres="+token_pres,
    {
        id_product: id_product,
        data_attribute:data_attribute,
        quantity:quantity
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        if (obj.status == '401') {
            PreMobimessenger('error',obj.messenger);
            return false;
        }
        PreMobimessenger(status = 'success', obj.messenger);
        $('.'+id_product+'').css('display', 'block');
        $('.total_product').html(obj.total_product);
        $('.total_price').html(obj.price);
    });
}
function PresMobiactivetab(element){
    var link = $(element).attr('href');
    $('#main-page').css('display','block');
    $(link).css('display','block');
    var controller = link.slice(1);
    $('.menu-select').removeClass('ba-active');
    $('.red'+controller+'').addClass('ba-active');
}
var  count_quantity = (function () {
    var counter = 1;
    return function () {
        return counter += 1;
    }
})();
function quantityplus(id,id_attr){
    var quantity = $('.td_product_detail_togetther_right_quantity_num_'+id+'_'+id_attr+'').val();
    $('.td_product_detail_togetther_right_quantity_num_'+id+'_'+id_attr+'').val(++quantity);
    $('.td_product_detail_togetther_right_quantity_minus_'+id+'_'+id_attr+'').addClass('quantity-product-1');
    $.post("" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobiupdatecart.php?token_pres="+token_pres,
    {
        quantity: 1,
        id_attr:id_attr,
        id_product:id,
        type:1
    },
    function (data, status) {
        id_combi = '';
        var obj = jQuery.parseJSON(data);
        if (obj.status == '401') {
            PreMobimessenger('error',obj.messenger);
            return false;
        }
        $.each(obj, function(i, f) {
            $.each(obj[i]['coupon'], function(i, m) {
                id_combi += '<div style="float:left;width:100%;">';
                id_combi += '<div style="float: left;">';
                id_combi += '<p style="margin: 8px 0 ;">Coupon';
                id_combi += '<span style="color: #ff0033;">('+m.code+': -'+m.price+')';
                id_combi += '<i class="icon-icondetele" style="line-height: 1.4;float:right;color: #adb4bd;" onclick="PresMobideleteCoupon('+m.id+')"></i></span>';
                id_combi += '</p></div>';
                id_combi += '<div style="float: right;">';
                id_combi += '<p style="color: #ff0033 !important;margin: 8px 0 0 0;">-'+m.total_price+'</p>';
                id_combi += '</div></div>';
            });
            $('.appendcoupon').html(id_combi);
        });
        $('.total_product').html(obj[0]['cart_quantity']);
        $('.product_price').html(obj[0]['price_product']);
        $('.shipping_price').html(obj[0]['price_shipping']);
        $('.total_price').html(obj[0]['price_product']);
        $('.total_price_end').html(obj[0]['totalprice']);
    });
}
function quantitydefaultplus(qty){
    var quantity = $('.premobile_quantity').val();
    if(quantity == qty) 
    {
        return false;
    }
    $('.premobile_quantity').val(++quantity);
    $('.PresMobileproduct-quatity .fa-minus-circle').addClass('quantity-product');
}
function quantitydefaultminus(){
    var quantity = $('.premobile_quantity').val();
    if (quantity >1) {
        $('.premobile_quantity').val(--quantity);
    } else {
        $('.PresMobileproduct-quatity .fa-minus-circle').removeClass('quantity-product');
    }
}
function quantityminus(id,id_attr){
    var quantity = $('.td_product_detail_togetther_right_quantity_num_'+id+'_'+id_attr+'').val();
    if (quantity > 1) {
        $('.td_product_detail_togetther_right_quantity_num_'+id+'_'+id_attr+'').val(quantity-1);
    } else {
        $('.td_product_detail_togetther_right_quantity_minus_'+id+'_'+id_attr+'').removeClass('quantity-product-1');
    }
    $.post("" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobiupdatecart.php?token_pres="+token_pres,
    {
        quantity: 1,
        id_attr:id_attr,
        id_product:id,
        type:2
    },
    function (data, status) {
        id_combi = '';
        var obj = jQuery.parseJSON(data);
        if (obj.status == '401') {
            PreMobimessenger('error',obj.messenger);
            return false;
        }
        $.each(obj, function(i, f) {
            $.each(obj[i]['coupon'], function(i, m) {
                id_combi += '<div style="float:left;width:100%;">';
                id_combi += '<div style="float: left;">';
                id_combi += '<p style="margin: 8px 0 ;">Coupon';
                id_combi += '<span style="color: #ff0033;">('+m.code+': -'+m.price+')';
                id_combi += '<i class="icon-icondetele" style="float:  right;color: #adb4bd;" onclick="PresMobideleteCoupon('+m.id+')"></i></span>';
                id_combi += '</p></div>';
                id_combi += '<div style="float: right;">';
                id_combi += '<p style="color: #ff0033 !important;margin: 8px 0 0 0;">-'+m.total_price+'</p>';
                id_combi += '</div></div>';
            });
            $('.appendcoupon').html(id_combi);
        });
        $('.total_product').html(obj[0]['cart_quantity']);
        $('.product_price').html(obj[0]['price_product']);
        $('.shipping_price').html(obj[0]['price_shipping']);
        $('.total_price').html(obj[0]['price_product']);
        $('.total_price_end').html(obj[0]['totalprice']);
    });
}
function PresMobicategorysearch(element, filter){
    $('.content-product-2').css('display','block');
    $('.content-producta').css('display','block');
    $('.content-product-1').css('display','none');
    $('.footer-category').css('display','none');
    $('.premobile-category-search').css('display','none');
    $('.premobile-category-filter label').removeClass('ba-active');
    $('.premobile-category-filter i').removeClass('ba-active');
    if (filter == 'category') {
        if (count_category()%2!=0) {
            $('.td_backgroud_dark').css('display','block');
            $('.r-'+filter+'').css('display','block');
            $('.premobile-category-filter-category label').addClass('ba-active');
            $('.premobile-category-filter-category i').addClass('ba-active');
        } else {
            $('.td_backgroud_dark').css('display','none');
            $('.r-'+filter+'').css('display','none');
            $('.presmobile-category-filter-fixed').css('border-bottom','1px solid #e0e0e0');
        }
    }
    if (filter == 'sort') {
        if (count_sort()%2!=0) {
            $('.td_backgroud_dark').css('display','block');
            $('.r-'+filter+'').css('display','block');
            $('.premobile-category-filter-sort label').addClass('ba-active');
            $('.premobile-category-filter-sort i').addClass('ba-active');
        } else {
            $('.td_backgroud_dark').css('display','none');
            $('.r-'+filter+'').css('display','none');
            $('.presmobile-category-filter-fixed').css('border-bottom','1px solid #e0e0e0');
        }
    }
    if (filter == 'filter') {
        if (count_filter()%2!=0) {
            $('.td_backgroud_dark').css('display','none');
            $('.r-'+filter+'').css('display','block');
            $('.content-producta').css('display','none');
            $('.premobile-category-filter-filter label').addClass('ba-active');
            $('.premobile-category-filter-filter i').addClass('ba-active');
            $('.presmobile-category-filter-fixed').css('border-bottom','none');
        } else {
            $('.content-product-2').css('display','block');
            $('.td_backgroud_dark').css('display','none');
            $('.r-'+filter+'').css('display','none');
            $('.presmobile-category-filter-fixed').css('border-bottom','1px solid #e0e0e0');
        }
        $('.footer-category').css('display','block');
    }
    $(".ba-active > label").css("color", "red");
}
function PresMobibamobileroutes(emlement,type){
    PresMobi_scroll = 0;
    start_limit = 0;
    category_list = 2;
    start_ajax = 1;
    PreMobileloadingopen();
    var id_category_lastest = PreMobigetCookie('choiceCategory');
    var link = $(emlement).attr('ba-link');
    array_back.push(link);
    PreMobisetCookie('controller',link);
    var sort_category = $(emlement).attr('data-sort');
    var controllers = link.split(":").shift();
    var check_arg = link.search(":");
    var argument = '';
    if (check_arg != '-1') {
        argument = link.split(":").pop();
    }
    if (controllers == '#home') {
        PreMobisetCookie('choiceCategory',2);
    }
    $('.footer-app .menu-select').removeClass('ba-active');
    if (controllers == '#category') {
        $('.footer-app .redcategory').addClass('ba-active');
    }
    if (controllers == '#home') {
        $('.footer-app .redhome').addClass('ba-active');
    }
    if (controllers == '#search') {
        $('.footer-app .redsearch').addClass('ba-active');
        $(".search-product").val('');
        $(".clear-search-icon").css('display', 'none');
    }
    if (controllers == '#account') {
        $('.footer-app .redaccount').addClass('ba-active');
    }
    $(controllers).removeAttr('style');
    if (controllers == '#product' || controllers == '#mywishlistbyid' || controllers == '#comment' || controllers == '#checkoutsuccess' || (controllers == '#category' && argument != '') || controllers == '#orderbyid') {
        $('.main-page').hide();
        $(controllers).show();
    } else{
        for (var i = 0; i < page_array.length; i++){
            if ('#'+page_array[i] != link) {
                $('#'+page_array[i]).hide();
            }
        }
    }
        $(":mobile-pagecontainer").pagecontainer("change", ""+controllers+"", {
            transition: 'none'
        });
    $(emlement).parents('.r-filter').css('display','none');
    if (typeof (type) !== "undefined") {
        var checkbox_color = "";
        $(".category-color").each(function () {
            var ischecked = $(this).is(":checked");
            if (ischecked) {
                checkbox_color += $(this).val() + ",";
            }
        });
        var checkbox_size = "";
        $(".category-size").each(function () {
            var ischecked = $(this).is(":checked");
            if (ischecked) {
                checkbox_size += $(this).val() + ",";
            }
        });
        var rangemin = $('.ui-rangeslider-first').val();
        var rangemax = $('.ui-rangeslider-last').val();
    }
    window.location.hash = link;
    if (controllers == '#category' && argument != '') {
        // alert('aaaaaaaaaa');
        PreMobisetCookie('argument_category',argument);
        var view_cookie = PreMobigetCookie('total_view_'+argument+'');
        if (view_cookie != '') {
            var total_view = parseInt(view_category)+parseInt(view_cookie);
        } else {
            var total_view = view_category;
        }
        // alert(total_view);
        PreMobisetCookie('total_view_'+argument+'',total_view);

        var view_cookie = PreMobigetCookie('total_view_'+argument+'');
    }
    if (controllers == '#product' && argument != '') {
        // alert('aaaaaaaaaa');
        PreMobisetCookie('argument_product',argument);
        var view_cookie = PreMobigetCookie('total_view_product'+argument+'');
        if (view_cookie != '') {
            var total_view = parseInt(view_product)+parseInt(view_cookie);
        } else {
            var total_view = view_product;
        }
        // alert(total_view);
        PreMobisetCookie('total_view_product'+argument+'',total_view);

        var view_cookie = PreMobigetCookie('total_view_product'+argument+'');
    }
    // var argument_category = PreMobigetCookie('argument_category');
    // alert(view_cookie);
    // if (argument_category != argument) {
    //     // view_category = 0;
    // }
    $.post("" + url_presmobileapp + "?fc=module&module=presmobileapp&controller=baloadpage&ajax=1&token_pres="+token_pres,
    {
        controllers: controllers,
        argument: argument,
        checkbox_color: checkbox_color,
        checkbox_size: checkbox_size,
        rangemin: rangemin,
        rangemax:rangemax,
        sort_category:sort_category,
        id_category_lastest:id_category_lastest,
        view_cookie: view_cookie
    },
    function (data, status) {
        document.documentElement.scrollTop = 0;
        var obj = jQuery.parseJSON(data);
        $('title').html(obj.batitle);
        $('meta[name="description"]').attr('content',obj.description);
        $(".content-"+obj.controller+"").html(obj.content);
        $(".content-"+obj.controller+"").fadeOut();
        $(".content-"+obj.controller+"").fadeIn(1300);
        $('.premobile-title-'+obj.controller+'').html(obj.chir);
        $('.content-product-2').css('display','block');
        if (obj.controller == 'orderbyid') {
            if (obj.invoice_number == '0') {
                $('.pdf_order .icon-icondowload-pdf').hide();
            } else {
                $('.icon-icondowload-pdf').attr('href',baseUri +'?controller=pdf-invoice&id_order='+obj.id_order);
                $('.pdf_order .icon-icondowload-pdf').show();
            }
            $('.all-messenger').html(obj.count_mess);
            $('.ordermessenger_d h5').attr('ba-link','#ordermessenger:'+obj.id_order);
        }
        if (link == '#checkoutpayment') {
            $(".presmobi-payment a").each(function () {
                var demo = $(this).attr('href');
                position = demo.indexOf(url_presmobileapp);
                if (position == '0') {
                    $(this).attr('data-ajax','false');
                    $(this).attr('onclick','PresMobichoisepayment(this)');
                    if (check_ssl == '0') {
                        $(this).attr('link',demo+'&ignore_redirect=1');
                    } else {
                        $(this).attr('link',demo+'?ignore_redirect=1');
                    }
                    $(this).attr('href','');
                }
            });
        }
        PresMobileChangePayment();
        if (link == '#checkoutonestep') {
            $(".presmobi-payment a").each(function () {
                var demo = $(this).attr('href');
                position = demo.indexOf(url_presmobileapp);
                if (position == '0') {
                    $(this).attr('data-ajax','false');
                    $(this).attr('onclick','PresMobichoisepaymentoncheckout(this)');
                    if (check_ssl == '0') {
                        $(this).attr('link',demo+'&ignore_redirect=1');
                    } else {
                        $(this).attr('link',demo+'?ignore_redirect=1');
                    }
                    $(this).attr('href','');
                }
            });
        }
        if (controllers != '#checkoutsuccess') {
            $( "div#range-slider").rangeslider();
            renderslide();
        } else {
            $('#checkoutsuccess').show();
        }
        if (obj.controller == 'mywishlistbyid') {
            var ade = $('#foo').val();
            $('#foodb').val(ade);
            $('.abcd').html('<div>hello</div><button class="dbcda" data-clipboard-action="copy" data-clipboard-target="div">Copy</button><script>var clipboard = new ClipboardJS(".btn");clipboard.on("success", function(e) {console.log(e);});clipboard.on("error", function(e) {console.log(e);});</script>');
        }
        $('.search-product').focus();
        PreMobileloadingclose();
        PreMobicheckaddress();
        presMobiTouch();
        $('.owl-dot').removeClass('ui-btn ui-shadow ui-corner-all');
        $('#'+obj.controller+'').css('display','block');
        var checkcomment = PreMobigetCookie('checkcomment');
        var timecomment = comment_time *1000;
        if (checkcomment == 1) {
            $(".PresMobilecomment-button").css('display', 'none');
            setTimeout(function() {
                $(".PresMobilecomment-button").css('display', 'block');
                PreMobisetCookie('checkcomment',0);
            }, timecomment);
        }
    });
}
function clickcopy(){
    $('#fileToUpload_'+a+'').trigger('click');
}
function rangemax(emlement){
    $('.rangemax').html($(emlement).val());
}
function rangemin(emlement){
    $('.rangemin').html($(emlement).val()+' - ');
}
function PresMobichoiceCategory(emlement){
    $(".loading-category").css('display', 'block');
    $(".ba_viewall").css('display', 'none');
    $(".ba_showproduct").css('display', 'none');
    $(".latest-empty").css('display', 'none');
    var value = $(emlement).attr('ba-category');
    choice_category_lastest = value;
    $.post("" + url_presmobileapp + "?fc=module&module=presmobileapp&controller=baloadpage&ajax=1&token_pres="+token_pres,
    {
        value: value,
        action:"category"
    },
    function (data, status) {
        $(".content-latest-2").html(data);
    });
}
function PresMobisearchProduct(emlement, event){
    $(".clear-search-icon").css('display', 'block');
    var value = $(emlement).val();
    if( value == ''){
        $(".clear-search-icon").css('display', 'none');
    }
    if (event.keyCode !== 13){
        return false;
    }
    $(".search-product").removeAttr('autofocus');
    PresMobi_scroll = 0;
    $(".PresMobileicon-loadding").css('display', 'block');
    var value = $(emlement).val();
    if( value == ''){
        $(".clear-search-icon").css('display', 'none');
    }
    $(emlement).blur();
    $.post("" + url_presmobileapp + "?fc=module&module=presmobileapp&controller=baloadpage&ajax=1&token_pres="+token_pres,
    {
        value: value,
        action:"searchProduct"
    },
    function (data, status) {
        $(".PresMobileicon-loadding").css('display', 'none');
        $(".content-PresMobisearchProduct").html(data);
        $(".content-PresMobisearchProduct").css('display', 'none');
        $(".content-PresMobisearchProduct").fadeIn(1000);
    });
}
function savecontact(){
    var email = $('input[name=email]').val();
    if (!validateEmail(email)) {
        PreMobimessenger(status = 'error', 'Invalid email address.');
        return false;
    }
    var formData = new FormData($('#contact_form')[0]);
    $.ajax({
        url: "" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobi-savecontact.php?token_pres="+token_pres,
        type: "POST",
        data: formData,
        async: false,
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status == '401') {
                PreMobimessenger(status = 'error', obj.messenger);
            } else {
                var controller = '#account';
                PresMobibamobileroutesback(controller);
                PreMobimessenger(status = 'success', obj.messenger);  
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
function last(array) {
    return array[array.length - 1];
}
function goBack() {
    var count_back = array_back.length;
    if (count_back == 1) {
        var link = '#home';
    } else {
        var link = array_back.pop();
        link = last(array_back);
    }
    var controllers = link.split("#").pop();
    var controller = controllers.split(":").pop();
    var check_arg = controllers.search(":");
    $('#'+controller).css('display','none');
    var argument = '';
    if (check_arg != '-1') {
        window.history.back();
    } else {
       window.history.back(); 
    }
    $.post("" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobi-back.php?token_pres="+token_pres,
    {
    },
    function (data, status) {
        var route = ''
        var controllers = link.split("#").pop();
        var rt = controllers.split(":").shift();
        if (rt == 'http') {
            route = '#home';
        } else {
            route = '#'+controllers;
        }
        PresMobibamobileroutesback(route);
    });
}
var  count_color = (function () {
    var counter = 0;
    return function () {
        return counter += 1;
    }
})();
var  count_size = (function () {
    var counter_size = 0;
    return function () {
        return counter_size += 1;
    }
})();
var  count_price = (function () {
    var counter_price = 0;
    return function () {
        return counter_price += 1;
    }
})();
var  count_filter = (function () {
    var counter_filter = 0;
    return function () {
        return counter_filter += 1;
    }
})();
var  count_category = (function () {
    var counter_category = 0;
    return function () {
        return counter_category += 1;
    }
})();
var  count_sort = (function () {
    var counter_sort = 0;
    return function () {
        return counter_sort += 1;
    }
})();
function premobileappOpen(element, attr){
    if (attr == 'color') {
        if (count_color()%2=='0') {
            $(element).parent().find('.fa-angle-up').css('display','none');
            $(element).parent().find('.fa-angle-down').css('display','block');
            $(element).parent().find('.acitve-attribute').css('display','none');
        } else {
            $(element).parent().find('.fa-angle-up').css('display','block');
            $(element).parent().find('.fa-angle-down').css('display','none');
            $(element).parent().find('.acitve-attribute').css('display','block');
        }
    }
    if (attr == 'size') {
        if (count_color()%2=='0') {
            $(element).parent().find('.fa-angle-up').css('display','none');
            $(element).parent().find('.fa-angle-down').css('display','block');
            $(element).parent().find('.acitve-attribute').css('display','none');
        } else {
            $(element).parent().find('.fa-angle-up').css('display','block');
            $(element).parent().find('.fa-angle-down').css('display','none');
            $(element).parent().find('.acitve-attribute').css('display','block');
        }
    }
}
function PresMobiresertfilter(){
    $('.ui-btn-active').css('width', '0%');
    $('.rangemax').html('0');
    $('.rangemin').html('0-');
    $('.ui-slider-handle').css({"left":"0%","margin-left":"-2px"});
    $('input[type=checkbox]').removeAttr("checked");
}
function PresMobiproductList(element,id){
    category_list = id;
    PresMobi_scroll = 0;
    start_limit = 0;
    $('.premobile-category-search').css('display','none');
    $('.content-grid').css('color','#bcbcbc');
    $('.content-producta').css('display','none');
    $('.content-product-'+id+'').css('display','block');
    $(element).css('color','#666666');
    $('.presmobile-category-filter-fixed').css('border-bottom','1px solid #e0e0e0');
}
function PresMobileLoginPu(){
    $('.PresMobileforgot-pu').fadeIn('slow');
}
function PresMobileClosePu(){
    $('.PresMobileforgot-pu').fadeOut('slow');
}
function renderslide(){
    $('.owl-carousel').owlCarousel({
        autoplay:true,
        autoplayTimeout:3000,
        loop:true,
        margin:10,
        nav:true,
        nav:false,
        autoHeight:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        },
        onDragged: PreMobilecallback
    });
}
function PreMobilecallback(event) {
    // Provided by the core
    var element   = event.target;         // DOM element, in this example .owl-carousel
    var name      = event.type;           // Name of the event, in this example dragged
    var namespace = event.namespace;      // Namespace of the event, in this example owl.carousel
    var items     = event.item.count;     // Number of items
    var item      = event.item.index;     // Position of the current item
    // Provided by the navigation plugin
    var pages     = event.page.count;     // Number of pages
    var page      = event.page.index;     // Position of the current page
    var size      = event.page.size;
    var aw = page + 1;
    $('.count-next-slider').html(aw+' of '+pages);
}
function PreMobileloadingopen(){
    $('.PresMobileicon-loadding').show();
}
function PreMobileloadingclose(){
    setTimeout(function(){ 
        $('.PresMobileicon-loadding').hide();
     }, 1000);
}
function PresMobichoiseattribute(){
    var id_product_detail = $('.id_product_detail').val();
    var selected_attribute = '';
    $(".selected_attribute").each(function () {
        var checked = $(this).is(':checked');
        if (checked) {
            selected_attribute += $(this).val() +',';
        }
    });
    $(".choice_selected_attribute").each(function () {
        selected_attribute += $(this).val() +',';
    });
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-productcombi.php?token_pres="+token_pres,
    {
       selected_attribute:selected_attribute,
       id_product:id_product_detail
    },
    function (data, status) {
        if (data ==1) {
            $('.warning').css('display', 'block');
            $('.combiqty').css('display', 'none');
            $('.footer-detail-boxaddtocart').addClass('disabledbutton');
            $('.robb_price_total').html('');
        } else if(data == 2) {
            $('.combiqty').css('display', 'none');
        } else {
            $('.footer-detail-boxaddtocart').removeClass('disabledbutton');
            $('.combiqty').css('display', 'block');
            $('.warning').css('display', 'none');
            var obj = jQuery.parseJSON(data);
            $('.robb_price_total').html(obj.price);
            $('.ba_items').html(obj.qty);
            if (obj.checkqties == 1) {
                $('.checkqties').css('display', 'block');
            } else {
                $('.checkqties').css('display', 'none');
            }
        }
    });
    var data_color = $('input[name="Color"]:checked').val();
    var data_size = $('input[name="size"]:checked').val();
    var abc = '';
    var r = 0;
    $(".baimgdetail").each(function () {
        var attr = $(this).attr('attr-img');
        if (attr.search(data_size+'-'+data_color) != '-1') {
            var abc = $(this).attr('img-value');
        }
         if (typeof (abc) !== "undefined") {
            r = abc;
         }
    });
    if(r!= '0'){
        renderslide();
        $('.owl-carousel').trigger('to.owl.carousel', --r);
    }
}
function PresMobimoreaubot(id){
    $('.viewmore_about').hide();
    $('.PresMobileviewmore_'+id+'').show();
    if (id == '2') {
        $('.content-feature').removeClass('PresMobilefeature');
    } else {
        $('.content-feature').addClass('PresMobilefeature');
    }
}
function PresMobimoredes(id){
    $('.viewmore_des_1').hide();
    $('.PresMobileviewmore_des_'+id+'').show();
    $('.PresMobiledescription').hide();
    $('.PresMobiledescription-'+id+'').show();
}
function PreMobiaddFavorite(id_customer, id_product, page, obja){
    var check = $(".td_love_product_detail").attr('add');
    if (page == 'cate') {
        var check = $(".td_love_product_cate"+id_product).attr('add');
    }
    var type = 0;
    if (typeof (check) !== "undefined") {
        type = 1;
    }
    if (type == '1') {
        $(".td_love_product_detail").removeAttr('add');
        $(".td_love_product_detail i").css("cssText", "color: #bcbcbc !important;");
    } else {
        $(".td_love_product_detail").attr('add','1');
        $(".td_love_product_detail i").css("cssText", "color: #ff0033 !important;");
    }
    if (page == 'cate' && type == '1') {
        $(obja).removeAttr('add');
        $(obja).css('color', '#00000');
    }
    if (page == 'cate' && type != '1') {
        $(obja).attr('add','1');
        $(obja).css('color', 'red');
    }
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-addfavorite.php?token_pres="+token_pres,
    {
        id_product: id_product,
        id_customer:id_customer,
        type:type
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        if (obj.typer == '1') {
            PreMobimessenger(status = 'success', obj.messeger);
        } else {
            PreMobimessenger(status = 'success', obj.messeger);
        }
    });
}
function PreMobiaddWislist(id_customer, id_product, type){
    if (type == 1) {
        var id_wishlist = $('.wishlistselected').attr('value-wishlist');
    } else{
        var id_wishlist = '';
    }
    var selected_attribute = '';
    $(".selected_attribute").each(function () {
        var checked = $(this).is(':checked');
        if (checked) {
            selected_attribute += $(this).val() +',';
        }
    });
    $(".choice_selected_attribute").each(function () {
        selected_attribute += $(this).val() +',';
    });
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-wislistproduct.php?token_pres="+token_pres,
    {
        id_product: id_product,
        id_wishlist: id_wishlist,
        type: type,
        id_customer:id_customer,
        data_attribute:selected_attribute
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        PreMobimessenger(status = 'success', obj.messenger);
        PresMoblieHideAddressSelectPopup('popup-choose-wishlist');
    });
}
function PreMobimessenger(status= '',mess = ''){
    $('.PresMobilenotification').css('display','block');
    $('.PresMobilenotification p').css('display','none');
    $('.PresMobilenotification .'+status).css('display','block');
    $('.PresMobilenotification .'+status).html(mess);
    setTimeout(function ()
    {
        $(".PresMobilenotification").fadeOut('slow');
    }, 2000);
}
function PreMobicheckComment(){
    var comment_name = $('.comment-name').val();
    var comment_descriprtion = $('.comment-descriprtion').val();
    var rating_value = $('.rating-value').val();
    var comment_customname = $('.comment-customname').val();
    var check = 0;
    if (comment_name == '') {
        check = 1;
    }
    if (comment_descriprtion == '') {
        check = 1;
    }
    if (rating_value == '0') {
        check = 1;
    }
    if (comment_customname == '') {
        check = 1;
    }
    if (check == '1') {
        $('.submit-comment').addClass('disabledbutton');
    } else {
        $('.submit-comment').removeClass('disabledbutton');
    }
}
function PresMobiaddComment(id_product){
    $("#PresMobil-add-comment").hide("fast");
    PreMobisetCookie('checkcomment',1);
    var comment_name = $('.comment-name').val();
    var comment_customname = $('.comment-customname').val();
    var comment_descriprtion = $('.comment-descriprtion').val();
    var rating_value = $('.rating-value').val();
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-addcomment.php?token_pres="+token_pres,
    {
        id_product: id_product,
        comment_name:comment_name,
        comment_descriprtion:comment_descriprtion,
        rating_value:rating_value,
        comment_customname:comment_customname
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        PreMobimessenger(status = 'success', obj.messeger);
        PresMobibamobileroutesback('#comment:'+id_product);

    });
}
function PreMobichecklogin(){
    var use_name = $('.login_user_name').val();
    var use_pass = $('.login_user_pass').val();
    if (use_pass != '' && use_name != '') {
        $('.PresMobilelogin-buttom').removeClass('disabledbutton');
    } else {
        $('.PresMobilelogin-buttom').addClass('disabledbutton');
    }
    if (event.keyCode !== 13){
        return false;
    }
    $('.login_user_pass').blur();
}
function PreMobilogin() {
    var use_name = $('.login_user_name').val();
    if (use_name == '') {
        PreMobimessenger(status = 'error', 'An email address required.');
        return false;
    }
    if (!validateEmail(use_name)) {
        PreMobimessenger(status = 'error', 'Invalid email address.');
        return false;
    }
    var use_pass = $('.login_user_pass').val();
    if (use_pass == '') {
        PreMobimessenger(status = 'error', 'Password is required.');
        return false;
    }
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-login.php?token_pres="+token_pres,
    {
        use_name: use_name,
        use_pass:use_pass
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        if (obj.status == '401') {
            PreMobimessenger(status = 'error', obj.messenger);  
        } else {
            PreMobimessenger(status = 'success', obj.messenger);
            var controller = PreMobigetCookie('control');
            if (controller == '#myaddress') {
                if (obj.address != '1') {
                    controller = '#checkoutaddress';
                }
            }
            PresMobibamobileroutesback(controller);
        }
    });
}
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
function PreMobisetCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function PreMobigetCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function PresMobibamobileroutesback(controlers){
    PresMobi_scroll = 0;
    start_limit = 0;
    start_ajax = 1;
    category_list = 2;
    PreMobisetCookie('choiceCategory',2);
    if (controlers == '#search') {
    } else{
        PreMobileloadingopen();
    }
    $('.main-page').removeClass('ui-page-active');
    var link = controlers;
    var controllers = link.split(":").shift();
    var check_arg = link.search(":");
    var argument = '';
    if (check_arg != '-1') {
        argument = link.split(":").pop();
    }
    $(controllers).removeAttr('style');
    if (controllers == '#product' || controllers == '#comment' || controllers == '#mywishlistbyid' || controllers == '#checkoutsuccess' || (controllers == '#category' && argument != '') || controllers == '#orderbyid') {
        $('.main-page').hide();
        $(controllers).show();
        $(controllers).addClass('ui-page-active');
    } else{
        for (var i = 0; i < page_array.length; i++){
            if ('#'+page_array[i] != link) {
                $('#'+page_array[i]).hide();
            }
        }
    }
    $(":mobile-pagecontainer").pagecontainer("change", ""+controllers+"", {
        transition: 'none'
    });
    $(controllers).addClass('ui-page-active');
    window.location.hash = link;
    $.post("" + url_presmobileapp + "?fc=module&module=presmobileapp&controller=baloadpage&ajax=1&token_pres="+token_pres,
    {
        controllers: controllers,
        argument: argument,
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        $('title').html(obj.batitle);
        $(".content-"+obj.controller+"").html(obj.content);
        $(".content-"+obj.controller+"").css('display', 'none');
        $(".content-"+obj.controller+"").fadeIn(1000);
        $('.menu-select').removeClass('ba-active');
        $('.red'+obj.controller).addClass('ba-active');
        $('.premobile-title-'+obj.controller+'').html(obj.chir);
        $('.content-product-2').css('display','block');
        $('.PresMobileicon-loadding').hide();
        $('.search-product').focus();
        if (obj.controller == 'orderbyid') {
            if (obj.invoice_number == '0') {
                $('.pdf_order .icon-icondowload-pdf').hide();
            } else {
                $('.icon-icondowload-pdf').attr('href',baseUri+'?controller=pdf-invoice&id_order='+obj.id_order);
                $('.pdf_order .icon-icondowload-pdf').show();
            }
            $('.all-messenger').html(obj.count_mess);
            $('.ordermessenger_d h5').attr('ba-link','#ordermessenger:'+obj.id_order);
        }
        if (obj.controller != 'checkoutsuccess') {
            renderslide();
        }
        if (obj.controller == 'checkoutsuccess') {
            $('.total_price').html(obj.price_total);
            $('.total_product').html(0);
        }
        if (obj.controller == 'cart') {
            $('.total_price').html(obj.price);
            $('.total_product').html(obj.total_product);
        }
        PresMobileChangePayment();
        presMobiTouch();
        PreMobileloadingclose();
        PreMobicheckaddress();
        PresMobileCheckOutAddressCheckFields();
        $('.owl-dot').removeClass('ui-btn ui-shadow ui-corner-all');
    });
}
function PreMobiLogout(){
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-logout.php?token_pres="+token_pres,
    {
    },
    function (data, status) {
        var controller = '#account';
        PresMobibamobileroutesback(controller);
    });
}
function PrerMobiresertPassword() {
    var user_email_resert = $('.user_email_resert').val();
    if (!validateEmail(user_email_resert) || user_email_resert == '') {
        PreMobimessenger(status = 'error', 'Invalid email address.');
        return false;
    }
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-resertpasw.php?token_pres="+token_pres,
    {
        email:user_email_resert
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        if (obj.status == '401') {
            PreMobimessenger(status = 'error', obj.messenger);
        } else {
            PreMobimessenger(status = 'success', obj.messenger);
            var controller = '#account';
            PresMobibamobileroutesback(controller);
        }
    });
}
function PresMobisingUp(){
    var formData = new FormData($('#presmobi-sign-up')[0]);
    $.ajax({
        url: "" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-signup.php?token_pres="+token_pres,
        type: "POST",
        data: formData,
        async: false,
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status == '401') {
                PreMobimessenger(status = 'error', obj.messeger);
            } else {
                PreMobimessenger(status = 'success', obj.messeger);
                var controller = '#account';
                PresMobibamobileroutesback(controller);
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
function PresMobilecheckSignup(){
    var first_name = $('.first-name').val();
    var last_name = $('.last-name').val();
    var username = $('.username').val();
    var email = $('.email').val();
    var password = $('.password').val();
    var confirm_password = $('.confirm-password').val();
    var check = 0;
    if (first_name == '') {
        check = 1;
    }
    if (last_name == '') {
        check = 1;
    }
    if (username == '') {
        check = 1;
    }
    if (email == '' || !validateEmail(email)) {
        check = 1;
    }
    if (password == '') {
        check = 1;
    }
    if (confirm_password == '') {
        check = 1;
    }
    if (password != confirm_password) {
        check = 1;
    }
    if (check == '1') {
        $('.PresMobilesignup-buttom').addClass('disabledbutton');
    } else {
        $('.PresMobilesignup-buttom').removeClass('disabledbutton');
    }
}
function PresMobieditProfile(){
    var fisrtname = $('.profile-first-name').val();
    var lastname = $('.profile-last-name').val();
    var email = $('.profile-email').val();
    var paswd_current = $('.profile-current-password').val();
    var paswd = $('.profile-password').val();
    var paswd_config = $('.profile-confirmation-password').val();
    if (paswd_current == '') {
        PreMobimessenger(status = 'error', 'The password you entered is incorrect.');
        return false;
    }
    if (paswd != paswd_config) {
        PreMobimessenger(status = 'error', 'The password and confirmation do not match.');
        return false;
    }
    if (fisrtname == '') {
        PreMobimessenger(status = 'error', 'firstname is required.');
        return false;
    }
    if (lastname == '') {
        PreMobimessenger(status = 'error', 'lastname is required.');
        return false;
    }
    if (email == '' || !validateEmail(email)) {
        PreMobimessenger(status = 'error', 'This email address is not valid.');
        return false;
    }
    var formData = new FormData($('#presmobi-profile')[0]);
    $.ajax({
        url: "" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-editprofile.php?token_pres="+token_pres,
        type: "POST",
        data: formData,
        async: false,
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status == '401') {
                PreMobimessenger(status = 'error', obj.messeger);
            } else {
                PreMobimessenger(status = 'success', obj.messeger);
                var controller = '#account';
                PresMobibamobileroutesback(controller);
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
function PresMobideleteFavorite(id,type){
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-deletefavorite.php?token_pres="+token_pres,
    {
        id:id,
        type:type
    },
    function (data, status) {
        var controller = '#favorite';
        PresMobibamobileroutesback(controller);
    });
}
function PresMobicheckCounpon(element){
    var discount = $(element).val();
    if (discount != '') {
        $('.addcountpon').removeClass('disabledbutton');
    } else {
        $('.addcountpon').addClass('disabledbutton');
    }
}
function PresMobiaddCountpon(){
    var discount = $('.td_cart_input_coupon').val();
    $.post("" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobiupdatecart.php?token_pres="+token_pres,
    {
        quantity: 1,
        type:3,
        discount:discount
    },
    function (data, status) {
        id_combi = '';
        var obj = jQuery.parseJSON(data);
        if (obj.status == 401) {
            PreMobimessenger(status = 'error', obj.messenger);
            return false;
        }
        $.each(obj, function(i, f) {
            $.each(obj[i]['coupon'], function(i, m) {
                id_combi += '<div style="float:left;width:100%;">';
                id_combi += '<div style="float: left;">';
                id_combi += '<p style="margin: 8px 0 0 0;">Coupon';
                id_combi += ':<span style="color: #ff0033;"> ('+m.code+': -'+m.price+')';
                id_combi += '<i class="icon-icondetele" style="float:  right;color: #adb4bd;" onclick="PresMobideleteCoupon('+m.id+')"></i></span>';
                id_combi += '</p></div>';
                id_combi += '<div style="float: right;">';
                id_combi += '<p style="color: #ff0033 !important;margin: 8px 0 ;">-'+m.total_price+'</p>';
                id_combi += '</div></div>';
            });
            PreMobimessenger(status = 'success', mess = 'Add coupon success');
            $('.appendcoupon').html(id_combi);
        });
        $('.product_price').html(obj[0]['price_product']);
        $('.shipping_price').html(obj[0]['price_shipping']);
        $('.total_price_end').html(obj[0]['totalprice']);
    });
}
function PresMobideleteCoupon(id){
    $.post("" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobi-deletecoupon.php?token_pres="+token_pres,
    {
        id_cart_rule: id
    },
    function (data, status) {
        id_combi = '';
        var obj = jQuery.parseJSON(data);
        $.each(obj, function(i, f) {
            $.each(obj[i]['coupon'], function(i, m) {
                id_combi += '<div style="float:left;width:100%;">';
                id_combi += '<div style="float: left;">';
                id_combi += '<p style="margin: 8px 0 0 0;">Coupon';
                id_combi += '<span style="color: #ff0033;">('+m.code+': -'+m.price+')';
                id_combi += '<i class="icon-icondetele" style="float:  right;color: #adb4bd;" onclick="PresMobideleteCoupon('+m.id+')"></i></span>';
                id_combi += '</p></div>';
                id_combi += '<div style="float: right;">';
                id_combi += '<p style="color: #ff0033 !important;margin: 8px 0 0 0;">-'+m.total_price+'</p>';
                id_combi += '</div></div>';
            });
            PreMobimessenger(status = 'success', 'Remove coupon success');
            $('.appendcoupon').html(id_combi);
        });
        $('.product_price').html(obj[0]['price_product']);
        $('.shipping_price').html(obj[0]['price_shipping']);
        $('.total_price_end').html(obj[0]['totalprice']);
    });
}
function PresMobiremoveProductCart(id_product,id_attribute){
    PreMobileCartCloseButton();
    $('.td_cart_product_'+id_product+'-'+id_attribute+'').remove();
    $.post("" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobi-deleteproductcart.php?token_pres="+token_pres,
    {
        id_product: id_product,
        id_attribute: id_attribute
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        if (obj['checkempty'] == '1') {
            $('.total_product').html('0');
            $('.total_price').html(obj['price']);
            PresMobibamobileroutesback('#cart');
            return false;
        } 
        id_combi = '';
        $.each(obj, function(i, f) {
            $.each(obj[i]['coupon'], function(i, m) {
                id_combi += '<div style="float:left;width:100%;">';
                id_combi += '<div style="float: left;">';
                id_combi += '<p style="margin: 8px 0 0 0;">Coupon';
                id_combi += '<span style="color: #ff0033;">('+m.code+': -'+m.price+')';
                id_combi += '<i class="icon-icondetele" style="float:  right;color: #adb4bd;" onclick="PresMobideleteCoupon('+m.id+')"></i></span>';
                id_combi += '</p></div>';
                id_combi += '<div style="float: right;">';
                id_combi += '<p style="color: #ff0033 !important;margin: 8px 0 0 0;">-'+m.total_price+'</p>';
                id_combi += '</div></div>';
            });
            $('.appendcoupon').html(id_combi);
        });
        $('.product_price').html(obj[0]['price_product']);
        $('.shipping_price').html(obj[0]['price_shipping']);
        $('.total_price').html(obj[0]['price_product']);
        $('.total_price_end').html(obj[0]['totalprice']);
        $('.total_product').html(obj[0]['quantity_cart']);
    });
}
function PreMobicheckaddress(){
    $('.txt-checkout').each(function(){
        var input = $(this).val();
        if (input != '') {
            $(this).parent().find('label.PresMobiletitle').css('top','5px');
            $(this).parent().find('label.PresMobiletitle').css('font-size','12px');
        }
    });
}
function PresMobistepAddress(){
    var formData = new FormData($('#stepAddress')[0]);
    $.ajax({
        url: "" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-updateAddress.php?token_pres="+token_pres,
        type: "POST",
        data: formData,
        async: false,
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status == '401') {
                if (obj.error == 'zipcode') {
                    $('input[name="postal"]').focus();
                }
                if (obj.error == 'email') {
                    $('input[name="email"]').focus();
                }
                PreMobimessenger(status = 'error', obj.messenger);
            } else {
                PreMobimessenger(status = 'success', obj.messenger);
                var controller = PreMobigetCookie('control');
                if(controller == '#checkoutonestep'){
                    PresMobibamobileroutesback(controller);
                } else {
                    if (controller != '#myaddressbycustomer') {
                        var controller = '#myaddress';
                    }
                    PresMobibamobileroutesback(controller);
                }
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
function PreMobileCheckoutCartCheckedShippingMethod(id,element){
    $('.shipping').find('.premobile-shipping-method').removeClass('method-check');
    $('.shipping-'+id).find('.premobile-shipping-method').addClass('method-check');
    var id_carrier = $(element).attr('data-shipping-method');
    $('.id_carrier').attr('value',id_carrier);
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-calculatororder.php?token_pres="+token_pres,
    {
        id_carrier: id_carrier,
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        $('.total_product_r').html(obj.price_product);
        $('#price_shipping_r').html(obj.price_shipping);
        $('#total_tax_r').html(obj.total_tax);
        $('#order_total_r').html(obj.order_total);
        $('.total_price_r').html(obj.order_total);
    });
}
function PresMobichoisepayment(element){
    $('.PresMobileicon-loadding-incart').show();
    $('.presmobile-payment-block-second').hide();
    $('.payment_detial').show();
    var link_payment = $(element).attr('link');
    $.ajax({
        url: link_payment,
        type: "GET",
        async: false,
        success: function (data) {
            var payment_html = data.replace('</body>','');
            var payment_return = payment_html.replace('</html>','');
            var html_p = '';
            html_p += payment_return;
            html_p += '<div class="presmobichoisepayment"><p>I confirm my order</p></div>';
            $('.payment_detial').html(html_p);
            $('.payment_detial .cart_navigation').remove();
            var url_payment = $('.payment_detial form').attr('action');
            $('.payment_detial form').attr('action','');
            $('.payment_detial .presmobichoisepayment').attr('link-payment',url_payment);
            $('.payment_detial .presmobichoisepayment').attr('onclick','PresMobiCheckoutCf(this)');
            $('.payment_detial .presmobichoisepayment').attr('data-ajax','false');
            $('.payment_detial .page-heading').remove();
            $('.payment_detial .button-exclusive').remove();
            $('.payment_detial #order_step').remove();
            $('.other_payment').show();
            $('.PresMobileicon-loadding-incart').hide();
            return false;
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
function PresMobiCheckoutCf(element){
    // alert('aaaaaaaa');
    $('.PresMobileicon-loadding-incart').show();
    var link = $(element).attr('link-payment');
    var link_payment = link.indexOf(url_presmobileapp);
    if (link_payment == '0') {
        $.post("" + link + "",
        {
        },
        function (data, status) {
            PresMobibamobileroutesback('#checkoutsuccess:'+data);
            $('.PresMobileicon-loadding-incart').hide();
            return false;
        });
    }
}
function PresMobidisplayPayment(){
    $('.presmobile-payment-block-second').show();
    $('.other_payment').hide();
    $('.payment_detial').hide();
}
$(document).on("pagecreate",function(){
    $("#ba_touchmove").on("swipeleft",function(){
        $('.owl-carousel').trigger('prev.owl.carousel');
    });
    $("#ba_touchmove").on("swiperight",function(){
        $('.owl-carousel').trigger('next.owl.carousel');
    });                      
});
function presMobiTouch(){
    $("#ba_touchmove").on("swipeleft",function(){
        $('.owl-carousel').trigger('prev.owl.carousel');
    });
    $("#ba_touchmove").on("swiperight",function(){
        $('.owl-carousel').trigger('next.owl.carousel');
    });
}
$(document).on("scrollstop", function (e) {
    var activePage = $.mobile.pageContainer.pagecontainer("getActivePage"),
    screenHeight = $.mobile.getScreenHeight(),
    contentHeight = $(".content-"+activePage[0].id, activePage).outerHeight(),
    header = $(".ui-header", activePage).outerHeight() - 1,
    scrolled = $(window).scrollTop(),
    footer = $(".ui-footer", activePage).outerHeight() - 1,
    scrollEnd = contentHeight - screenHeight + header + footer;
    $(".ui-btn-left", activePage).text("Scrolled: " + scrolled);
    $(".ui-btn-right", activePage).text("ScrollEnd: " + scrollEnd);
    var scroll_step = scrolled+157;
    var check_category = $('.presmobi-check-category').attr('data-check');
    if (scrolled != '0') {
        if(start_ajax != '0') {
            if (activePage[0].id == "latest" && scroll_step >= scrollEnd) {
                if (PresMobi_scroll != '1') {
                    $(".presmobi_loadting_"+activePage[0].id).css('display', 'block');
                    PresMobiPageTing(activePage[0].id,start_limit);
                }
            }
            if (activePage[0].id == "search" && scroll_step >= scrollEnd) {
                if (PresMobi_scroll != '1') {
                    $(".presmobi_loadting_"+activePage[0].id).css('display', 'block');
                    PresMobiPageTing(activePage[0].id,start_limit);
                }
            }
            if (activePage[0].id == "order" && scroll_step >= scrollEnd) {
                if (PresMobi_scroll != '1') {
                    $(".presmobi_loadting_"+activePage[0].id).css('display', 'block');
                    PresMobiPageTing(activePage[0].id,start_limit);
                }
            }
            if (activePage[0].id == "comment" && scroll_step >= scrollEnd) {
                if (PresMobi_scroll != '1') {
                    $(".presmobi_loadting_"+activePage[0].id).css('display', 'block');
                    PresMobiPageTing(activePage[0].id,start_limit);
                }
            }
            if (activePage[0].id == "product" && scroll_step >= scrollEnd) {
                var check_product_acce = $('.product_acce_check').attr('data-check');
                if (check_product_acce == '1') {
                    if (PresMobi_scroll != '1') {
                        $(".presmobi_loadting_"+activePage[0].id).css('display', 'block');
                        PresMobiPageTing(activePage[0].id,start_limit);
                    }
                }
            }
            if (activePage[0].id == "myaddressbycustomer" && scroll_step >= scrollEnd) {
                if (PresMobi_scroll != '1') {
                }
            }
            if (activePage[0].id == "creditslips" && scroll_step >= scrollEnd) {
                if (PresMobi_scroll != '1') {
                    $(".presmobi_loadting_"+activePage[0].id).css('display', 'block');
                    PresMobiPageTing(activePage[0].id,start_limit);
                }
            }
            if (check_category == '1') {
                if (activePage[0].id == "category" && scroll_step >= scrollEnd) {
                    if (PresMobi_scroll != '1') {
                        $(".presmobi_loadting_"+category_list).css('display', 'block');
                        PresMobiPageTing(activePage[0].id,start_limit);
                    }
                }
            }
        }
    }
});
/* load more fucntion */
function PresMobiPageTing(page,start) {
    start_ajax = 0;
    var choice_id_category = $('.presmobi-id-category').attr('data-check');
    var product_detail_id = $('.product_detail_id').attr('data-check');
    var id_category  = $('.tree-category-select').attr('ba-category');
    var search_product = $('.search-product').val();
    var category_check_sort = $('.active-category-sort').attr('data-sort');
    var rangemin = $('.ui-rangeslider-first').val();
    var rangemax = $('.ui-rangeslider-last').val();
    var category_check = '';
    $('.presmobi-category-check').each(function () {
        var ischecked = $(this).is(":checked");
        if (ischecked) {
            category_check += $(this).val() + ",";
        }
    });
    $.post("" + url_presmobileapp + "?fc=module&module=presmobileapp&controller=baloadpage&ajax=1&token_pres="+token_pres,
    {
        controllers: '#pageting',
        page: page,
        start:start,
        id_category:id_category,
        search_product:search_product,
        id_product:product_detail_id,
        choice_id_category:choice_id_category,
        category_check:category_check,
        category_check_sort:category_check_sort,
        category_list:category_list,
        category_price_rangemin:rangemin,
        category_price_rangemax:rangemax,
    },
    function (data, status) {
        var bacs = PreMobigetCookie('scoll_abc');
        var obj = jQuery.parseJSON(data);
        $('#'+obj.controller+'').css('display','block');
        if (page == 'category') {
            $(".grid-category-"+category_list+"").append(obj.content);
            $(".presmobi_loadting_"+category_list).css('display', 'none');
        } else {
            $(".grid-"+page+"").append(obj.content);
            $(".presmobi_loadting_"+page).css('display', 'none');
        }
        start_limit = obj.limit;
        if (obj.stop == '1') {
            PresMobi_scroll = 1;
        }
        start_ajax = obj.start_ajax;
        run_loading = 2;
    });
}
// notification
   $(document).on('click', '.ba_notifications', function () {
        PreMobimessenger(status = 'success', 'Saved');
    });
// end
// startqty
   function PresMobistartqty(obj, id, id_attr, maxqity) {
        var valueqty = $(obj).val();
        if (valueqty == 0) {
            $(obj).val('1');
        }
        if (valueqty == '' || valueqty > maxqity) {
            $(obj).val(maxqity);
        } else {
            var valueqty = $(obj).val();
            $.post("" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobiupdatecart.php?token_pres="+token_pres,
            {
                quantity: valueqty,
                id_attr:id_attr,
                id_product:id,
                type: 4
            },
            function (data, status) {
                var id_combi = '';
                var obj = jQuery.parseJSON(data);
                if (obj.status == '401') {
                    PreMobimessenger('error',obj.messenger);
                    return false;
                }
                $.each(obj, function(i, f) {
                    $.each(obj[i]['coupon'], function(i, m) {
                        id_combi += '<div style="float:left;width:100%;">';
                        id_combi += '<div style="float: left;">';
                        id_combi += '<p style="margin: 8px 0 0 0;">Coupon';
                        id_combi += '<span style="color: #ff0033;">('+m.code+': -'+m.price+')';
                        id_combi += '<i class="icon-icondetele" style="float:  right;color: #adb4bd;" onclick="PresMobideleteCoupon('+m.id+')"></i></span>';
                        id_combi += '</p></div>';
                        id_combi += '<div style="float: right;">';
                        id_combi += '<p style="color: #ff0033 !important;margin: 8px 0 0 0;">-'+m.total_price+'</p>';
                        id_combi += '</div></div>';
                    });
                    $('.appendcoupon').html(id_combi);
                });
                $('.total_product').html(obj[0]['cart_quantity']);
                $('.product_price').html(obj[0]['price_product']);
                $('.shipping_price').html(obj[0]['price_shipping']);
                $('.total_price').html(obj[0]['price_product']);
                $('.total_price_end').html(obj[0]['totalprice']);
            });
        }
    } 
// end
// clearsearch
function PresMobiclearsearch() {
    $(".search-product").val('');
    $(".clear-search-icon").css('display', 'none');
    PresMobibamobileroutesback('#search');
}
// end
function PresMobiCancelOrder(id_order){
    $('.cancel-order-popup').hide();
    $.post("" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobiupdatestatusorder.php?token_pres="+token_pres,
    {
        id_order: id_order
    },
    function (data, status) {
        PreMobimessenger('success','Order status changed to Cancelled');
        PresMobibamobileroutesback('#order');
    });
}
function PresMobiupdateaddress(id_address,type){
    var checked = $('.use-billing-choice').is(':checked');
    var id_address = id_address;
    var use_address = 0;
    if (checked == true) {
        use_address = 1;
    } else {
        use_address = 0;
    }
    $.post("" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobiupdateaddresscart.php?token_pres="+token_pres,
    {
        id_address: id_address,
        type:type,
        use_address:use_address
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        var html = '';
        $.each(obj, function(i, f) {
            $.each(obj[i]['content'], function(i, m) {
                html += '<h5 class="fullname-detail">'+m.lastname+' '+m.firstname+'</h5>';
                html += '<p class="company-detail">'+m.company+'</p>';
                html += '<p class="address-detail">'+m.address1+' '+m.address2+'</p>';
                html += '<p class="city-detail">'+m.city+' '+m.state+' '+m.postcode+'</p>';
                html += '<p class="country-detail">'+m.country+'</p>';
                html += '<p class="homephone-detail">'+m.phone+'</p>';
                html += '<p class="mobile-detail">'+m.phone_mobile+'</p>';
            });
        });
        $('.address-content-'+obj[0]['type']).html(html);
        $('.icon-edit-address-'+obj[0]['type']).attr('onclick','PresMobiRenderAddressHtml('+id_address+')');
        $('.icon-ello-icon-pent').attr('ba-link','#checkoutaddress:'+id_address+'');
    });
}
function PresMobileNewsletter(element,event){
    if (event.keyCode !== 13){
        return false;
    }
    var email = $(element).val();
    if (!validateEmail(email) || email =='') {
        PreMobimessenger(status = 'error', 'Invalid email address.');
        return false;
    }
    $(element).blur();
    $.post("" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobi-newsletter.php?token_pres="+token_pres,
    {
        email: email
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        if (obj.status == '401') {
            PreMobimessenger('error',obj.messenger);
            return false;
        } else {
            PreMobimessenger('success',obj.messenger);
            var controller = '#home';
            PresMobibamobileroutesback(controller);
            $(".smewletter-email").val('');
        }
    });
}
function PresMobileaddNewsletter(){
    var email = $('.mewletter-email').val();
    if (!validateEmail(email) || email =='') {
        PreMobimessenger(status = 'error', 'Invalid email address.');
        return false;
    }
    $('.mewletter-email').blur();
    $.post("" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobi-newsletter.php?token_pres="+token_pres,
    {
        email: email
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        if (obj.status == '401') {
            PreMobimessenger('error',obj.messenger);
            return false;
        } else {
            PreMobimessenger('success',obj.messenger);
            var controller = '#home';
            PresMobibamobileroutesback(controller);
            $(".smewletter-email").val('');
        }
    });
}
function PresMobideleteAddress(id_address){
    $.post("" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobi-deleteaddress.php?token_pres="+token_pres,
    {
        id_address: id_address
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        $('.address-'+id_address).remove();
        PreMobimessenger('success',obj.messenger);
    });
}
// changcontat
    function changecontac(idcontac) {
        var id_contact = $(idcontac).val();
        $(".description").css('display', 'none');
        $(".description"+id_contact).css('display', 'block');
    }
// end
//pack
    function checkmaxpack(id) {
        var price = 0;
        var price_sepcal = 0;
        $('.price_pack').each(function(index, el) {
            var checked = $(this).is(':checked');
            if (checked) {
                var quantity = $(this).parents('.td_detail_product_togetther').find('.td_product_detail_togetther_right_quantity_num ').val();
                price += (quantity*$(this).attr('data-price'));
                price_sepcal += parseFloat($(this).attr('data-pricespecal'));
            }
        });
        price = price.toFixed(2);
        price_sepcal = price_sepcal.toFixed(2);
        $('.pack_total').html(price);
        $('.price_pack_specal').html(price_sepcal);
    }
    function quantitypluspack(id, qty) {
        var quantity = $('.td_product_detail_togetther_right_quantity_num_'+id+'').val();
        if(quantity == qty)
        {
            return false;
        }
        var price = 0;
        $('.td_product_detail_togetther_right_quantity_num_'+id+'').val(''+(++quantity)+'');
        $('.td_product_detail_togetther_right_quantity_minus_'+id+'').addClass('quantity-product-1');
        $('.price_pack').each(function(index, el) {
            var checked = $(this).is(':checked');
            if (checked) {
                var quantity = $(this).parents('.td_detail_product_togetther').find('.td_product_detail_togetther_right_quantity_num ').val();
                price += (quantity*$(this).attr('data-price'));
            }
        });
        price = price.toFixed(2);
        $('.pack_total').html(price);
    }
    function quantitydefaultpluspack(id){
        var price = 0;
        var quantity = $('.td_product_detail_togetther_right_quantity_num_'+id+'').val();
        if (quantity > 1) {
            $('.td_product_detail_togetther_right_quantity_num_'+id+'').val(''+(quantity-1)+'');
        } else {
            $('.td_product_detail_togetther_right_quantity_minus_'+id+'').removeClass('quantity-product-1');
        }
        $('.price_pack').each(function(index, el) {
            var checked = $(this).is(':checked');
            if (checked) {
                var quantity = $(this).parents('.td_detail_product_togetther').find('.td_product_detail_togetther_right_quantity_num ').val();
                price += (quantity*$(this).attr('data-price'));
            }
        });
        price = price.toFixed(2);
        $('.pack_total').html(price);
    }
    function PresMobistartqtydetail(obj, qty) {
        var valueqty = $(obj).val();
        if (valueqty == 0 || valueqty == '') {
            $(obj).val('1');
        }
        if (valueqty >= qty) {
            $(obj).val(qty);
        }
    }
    function PresMobistartqtypack(obj, id, qty) {
        var price = 0;
        var valueqty = $(obj).val();
        if (valueqty == 0 || valueqty == '') {
            $(obj).val('1');
            $('.td_product_detail_togetther_right_quantity_num_'+id+'').attr('value','1');
        }
        else if (valueqty >= qty) {
            $(obj).val('1');
            $('.td_product_detail_togetther_right_quantity_num_'+id+'').attr('value',''+qty+'');
        } else {
            $('.td_product_detail_togetther_right_quantity_num_'+id+'').attr('value',''+valueqty+'');
        }
        $('.price_pack').each(function(index, el) {
            var checked = $(this).is(':checked');
            if (checked) {
                var quantity = $(this).parents('.td_detail_product_togetther').find('.td_product_detail_togetther_right_quantity_num ').val();
                price += (quantity*$(this).attr('data-price'));
            }
        });
        price = price.toFixed(2);
        $('.pack_total').html(price);
    }
    function PresMobiaddtocartpack() {
        var quantity = '';
        var id_product = '';
        $('.price_pack').each(function(index, el) {
        var checked = $(this).is(':checked');
        if (checked) {
                quantity += $(this).parents('.td_detail_product_togetther').find('.td_product_detail_togetther_right_quantity_num ').val()+',';
                id_product += $(this).val() +',';
            }
        });
        $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PreMobi-addtocartpack.php?token_pres="+token_pres,
        {
            id_product:id_product,
            quantity:quantity
        },
        function (data, status) {
        var obj = jQuery.parseJSON(data);
        if (obj.status == '401') {
            PreMobimessenger('error',obj.messenger);
            return false;
        }
        PreMobimessenger(status = 'success', obj.messenger);
            $('.total_product').html(obj.total_product);
            $('.total_price').html(obj.price);
        });
    }
//end
function PresMobiRenderAddressHtml(id_address){
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PreMobi-render.php?token_pres="+token_pres,
    {
        id_address:id_address
    },
    function (data, status) {
        $('.popup-choose-edit-address').show();
        $('.edit-address-pres').html(data);
        PreMobicheckaddress();
    });
}
function PresMobichoisepaymentoncheckout(element){
    $('.PresMobileicon-loadding-incart').show();
    $('.presmobile-payment-block-second').hide();
    $('.payment_detial').show();
    var link_payment = $(element).attr('link');
    $.ajax({
        url: link_payment,
        type: "GET",
        async: false,
        success: function (data) {
            var payment_html = data.replace('</body>','');
            var payment_return = payment_html.replace('</html>','');
            var html_p = '';
            html_p += payment_return;
            html_p += '<div class="presmobichoisepayment"><p>I confirm my order</p></div>';
            $('.payment_detial').html(html_p);
            $('.payment_detial .cart_navigation').remove();
            var url_payment = $('.payment_detial form').attr('action');
            $('.payment_detial form').attr('action','');
            $('.payment_detial .presmobichoisepayment').attr('link-payment',url_payment);
            $('.payment_detial .presmobichoisepayment').attr('onclick','PresMobiCheckoutCf(this)');
            $('.payment_detial .presmobichoisepayment').attr('data-ajax','false');
            $('.payment_detial .page-heading').remove();
            $('.payment_detial .button-exclusive').remove();
            $('.payment_detial #order_step').remove();
            $('.other_payment').show();
            $('.PresMobileicon-loadding-incart').hide();
            return false;
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
function PresMobiaddWishlist(){
    var wishlist = $('.add_wishlist').val();
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PreMobi-addwishlist.php?token_pres="+token_pres,
    {
        wishlist:wishlist
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        PreMobimessenger('success',obj.messenger);
        PresMobibamobileroutesback('#wishlist');
    });
}
var copy = function(elementId) {
    var input = document.getElementById(elementId);
    var isiOSDevice = navigator.userAgent.match(/ipad|iphone/i);
    if (isiOSDevice) {
        var editable = input.contentEditable;
        var readOnly = input.readOnly;
        input.contentEditable = true;
        input.readOnly = false;
        var range = document.createRange();
        range.selectNodeContents(input);
        var selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
        input.setSelectionRange(0, 999999);
        input.contentEditable = editable;
        input.readOnly = readOnly;
    } else {
        input.select();
    }
    document.execCommand('copy');
    PreMobimessenger('success','Copy link success.');
    $('#foo').blur();
}
function PresMobiCopyLink(el){
    var $input = $('.wishlist-permalink');
    $input.val();
    if (navigator.userAgent.match(/ipad|ipod|iphone/i)) {
      var el = $input.get(0);
      var editable = el.contentEditable;
      var readOnly = el.readOnly;
      el.contentEditable = true;
      el.readOnly = false;
      var range = document.createRange();
      range.selectNodeContents(el);
      var sel = window.getSelection();
      sel.removeAllRanges();
      sel.addRange(range);
      el.setSelectionRange(0, 999999);
      el.contentEditable = editable;
      el.readOnly = readOnly;
    } else {
      $input.select();
    }
    document.execCommand('copy');
    $input.blur();
    PreMobimessenger('success','Copy link success.');
}
function iosCopyToClipboard(el) {
    var oldContentEditable = el.contentEditable,
        oldReadOnly = el.readOnly,
        range = document.createRange();
    el.contentEditable = true;
    el.readOnly = false;
    range.selectNodeContents(el);
    var s = window.getSelection();
    s.removeAllRanges();
    s.addRange(range);
    el.setSelectionRange(0, 999999); // A big number, to cover anything that could be inside the element.
    el.contentEditable = oldContentEditable;
    el.readOnly = oldReadOnly;
    document.execCommand('copy');
}
function PresMobiSaveWishlist(id_wishlist_product,type){
    var quantity = $('.w_quantity_'+id_wishlist_product).val();
    var privoty = $('.w_priority_'+id_wishlist_product).val();
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PreMobi-savewishlist.php?token_pres="+token_pres,
    {
        quantity:quantity,
        privoty:privoty,
        id_wishlist_product:id_wishlist_product,
        type:type
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        if (type == '1') {
            PreMobimessenger('success',obj.messenger);
        } else {
            PreMobimessenger('success',obj.messenger);
            PresMobibamobileroutesback('#mywishlistbyid:'+$('.id_wishlist').val());
        }
    });
}
function PresMobiChangeCountry(element){
    var id_country = $(element).val();
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-renderstate.php?token_pres="+token_pres,
    {
        key:id_country
    },
    function (data, status) {
        state = '';
        var obj = jQuery.parseJSON(data);
        if (obj.status == '200') {
            $('.address-states').show();
            $.each(obj, function(i, f) {
                $.each(obj['states'], function(i, m) {
                    state += '<option value='+m.id_state+'>';
                    state += ''+m.name+'</option>';
                });
                $('.step_state').html(state);
            });
        } else {
            $('.address-states').hide();
        }
    });
}
//currency
    function PresMoblieCurrency() {
        $('.popup-choose-currency').fadeOut();
        $('body').removeClass('hiedden-scroll');
        var id_currency = $('.apply-choose-currency').attr('data-currency');
         $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-settinglangcur.php?token_pres="+token_pres,
        {
            id_currency:id_currency
        },
        function (data, status) {
            var obj = jQuery.parseJSON(data);
            PreMobimessenger('success',obj.messenger);
            window.location = url_presmobileapp;
        });
    }
//end
// update language 
function PresMobileUpdateLanguage(){
    var id_language = $('.apply-choose-language').attr('data-language');
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-updatelanguage.php?token_pres="+token_pres,
    {
        id_language:id_language
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        PreMobimessenger('success',obj.messenger);
        window.location = url_presmobileapp;
    });
}
//button home
function PresMobileChangePayment(){
    $(".ps-hidden-by-js").hide();
    $('.js-additional-information').hide();
}
function selectpayment17(id){
    $('.js-payment-option-form').hide();
    $('.js-additional-information').hide();
    $('#'+id+'-additional-information').show();
    $('#pay-with-'+id+'-form').show();
    var action = $('.mobile-'+id+'').attr('action');
    $('.selected-payment-mobi').attr('onclick','PresMobileChoicePayment17("'+action+'","'+id+'")');
}
function PresMobileChoicePayment17(action,id){
    $('.selected-payment-mobi').addClass('disabledbutton');
    setTimeout(function(){
        if(action.indexOf(url_presmobileapp) == -1) {
            $('#pay-with-'+id).trigger('click');
        } else {
            $.ajax({
                url: action,
                type: "GET",
                async: false,
                success: function (data) {
                    PresMobibamobileroutesback('#checkoutsuccess:'+data);
                    $('.PresMobileicon-loadding-incart').hide();
                    return false;
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    }, 1000);
}
function PresMobibaReOrder(element){
    var id_order = $(element).attr('id-order');
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-reorder.php?token_pres="+token_pres,
    {
        id_order:id_order
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        $('.total_product').html(obj.total_product);
        $('.total_price').html(obj.price);
        var controller = '#cart';
        PresMobibamobileroutesback(controller);
    });
}
function PresMobileChoiceProductAddMess(element){
    var id_product = $(element).attr('data-prodtomess');
    PresMoblieHideAddressSelectPopup('popup-choose-messenger');
    var html = $('.producttoselected .title-producttomessenger').html();
    $('.text-product').html(html);
}
function PresMobiRma(){
    var formData = new FormData($('#ba-rma')[0]);
    $.ajax({
        url: "" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobi-orderrma.php?token_pres="+token_pres,
        type: "POST",
        data: formData,
        async: false,
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status == '401') {
                PreMobimessenger('error', obj.messenger);
            } else {
                var controller = '#merchandisereturns';
                PresMobibamobileroutesback(controller);
                PreMobimessenger('success', obj.messenger);  
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
function PresMobiQtyRma(id_order_detail) {
    var ischecked = $('#cb-'+id_order_detail).is(":checked");
    if (ischecked) {
        $('.ram-total-return-'+id_order_detail).show();
    } else {
        $('.ram-total-return-'+id_order_detail).hide();
    }
}
$( "#icon_catemenu" ).draggable({
        containment: "window",
        start: function() {
        },
        drag: function() {
        },
        stop: function() {
            // element1 = document.getElementById('icon_catemenu'),
            // style1 = window.getComputedStyle(element1),
            // topba = style1.getPropertyValue('top');
            // PresMobicCategoriesSetCookie('premocibicmenu_top', topba);
            // leftba = style1.getPropertyValue('left');
            // PresMobicCategoriesSetCookie('premocibicmenu_left', leftba);
        }
    });
    // var homeleft = PresMobicCategoriesGetCookie('premocibicmenu_left');
    // var hometop = PresMobicCategoriesGetCookie('premocibicmenu_top');
    // if (typeof homeleft !== "undefined" && typeof hometop !== "undefined" ) {
    //     $('#icon_catemenu').css('left', homeleft);
    //     $('#icon_catemenu').css('top', hometop);
    // }
function PreMobileCategoryHideSearch(){
    $('.premobile-category-search').hide();
    $('.td_backgroud_dark').hide();
}
function PreMobileProfileFocus(element){
    $(element).parent().css("color","red");
}
function PreMobileProfileUnfocus(element){
    $(element).parent().css("color","#565656");
    var input_value = $(element).val();
    if(input_value ===''){
        $(element).css('border-color','#c6c6c6');
    }else{
    }
}
function PreMobileInputFieldTransitionFocus(element){
    $(element).parent().find('label.PresMobiletitle').css({"top":"5px","font-size":"12px"});
    $(element).parent('.checkout-address-field').find('label.PresMobiletitle').css('color','#ff0033');
    $(element).parent().parent().parent('#PresMobil-add-comment').css('max-height','33vh');
}
function PreMobileSingUpLabelClick(element){
    $(element).parent().find(":input" ).focus();
    PreMobileInputFieldTransitionFocus(element);
}
function PreMobileInputFieldTransitionUnfocus(element){
    $(element).parent().parent().parent('#PresMobil-add-comment').css('max-height','auto');
    $(element).parent('.checkout-address-field').find('label.PresMobiletitle').css('color','#757575');
    var input_value = $(element).val();
    if (input_value == 0 || input_value == '') {
        $(element).val('');
    }
    if(input_value ===''){
        $(element).parent().find('label.PresMobiletitle').css({"top":"40%","font-size":"16px"});
        $(element).css('border-color','#e0e6ed');
        $(element).parent().find('label.PresMobiletitle-none').css('display','none');
    }else{
        $(element).css('border-color','#e0e6ed');
    }
}
function PreMobileRatingStar(element){
    var rating = $(element).attr('rating');
    $('.star').css('color','#e2e2e2');
    for (var i =0; i <=rating ; i++) {
        $('.'+i+'-star').css('color','#ffcc00');
    }
    $('.rating-value').attr('value',rating);
    PreMobicheckComment();
}
function PresMobileCommentPopup(id){
    $('.PresMobilecomment').css('display','none');
    $('.PresMobilecomment-'+id).css('display','block');
}
function PresMoblieCheckOutShow(element){
    $(element).parent().find('.list-state').toggle();
    $('body').toggleClass('hiedden-scroll');
}
function PresMobileCheckOutAddressCanel(){
    $('.list-state').fadeOut();
    $('body').removeClass('hiedden-scroll');
}
function PresMobileCheckOutAddressChecked(id,statesname,key){
    $('.state-content .state-checked').find('.checkeds-'+key).removeClass('stateschecked');
    $('.state-content .state-checked-'+id).find('.checkeds-'+key).addClass('stateschecked');
    $('.getid_'+key+'').attr('val',statesname);
    $('.getid_'+key+'').attr('onclick','PresMobileCheckOutAddressOke(this,'+id+','+key+')');
}
function PresMobileCheckOutAddressOke(element,key,id){
    PresMobileCheckOutAddressCanel();
    var livalue = $(element).attr('val');
    $('.presmobile-idstate_'+id+'').attr('value',key);
    $('.text-state-'+id).val(livalue);
    $(element).parent().parent().parent().parent().parent().find('.PresMobiletitle').css({'top':'5px','font-size':'12px'});
    if (id == '2' || id == '4'){
        var id_select = 0;
        if (id == '2') {
            id_select = 1;
        }
        if (id == '4') {
            id_select = 3;
        }
        $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PresMobi-renderstate.php?token_pres="+token_pres,
        {
            key:key
        },
        function (data, status) {
            state = '';
            var obj = jQuery.parseJSON(data);
            if (obj.status == '200') {
                $('.address-states').show();
                $.each(obj, function(i, f) {
                    $.each(obj['states'], function(i, m) {
                        state += '<li class="state-checked state-checked-'+m.id_state+'" onclick="PresMobileCheckOutAddressChecked('+m.id_state+',\''+m.name+'\','+id_select+')" val="'+m.name+'">';
                        state += ''+m.name+'<div class="checkeds-'+id_select+'"></div></li>';
                    });
                    $('.state-content-'+id_select+'').html(state);
                });
            } else {
                $('.presmobile-idstate_1').attr('value','0');
                $('.text-state-1').val('');
                $('.address-states').hide();
                $('.address-states .PresMobile-state-title').css({'top':'40%','font-size':'16px'});
            }
        });
    }
}
function PresMobileCheckOutAddressCheckFields(){
    var checkall = 1;
    $('.txt-delivery-address').each(function(){
        var getval = $(this).val();
        if(getval == ''){
            checkall = 0;
        }
    });
    var hasemail = $("input").hasClass("email-delivery");
    if (hasemail == true) {
        var check_mail = $(".email-delivery").val();
        if (check_mail == '') {
            checkall = 0;
        } else {
            checkall = 1;
        }
        if (!validateEmail(check_mail)) {
            checkall = 0;
        }  else {
            checkall = 1;
        }
    }

       console.log(checkall);
    if(checkall == 1){
        $('.PresMobilesubmit-address').removeClass('disabledbutton');
    } else {
        $('.PresMobilesubmit-address').addClass('disabledbutton');
    }
}
function PresMobiCheckCheckBox(element){
    var check_checked = $(element).is(":checked");
    if( check_checked == true ){
        $(element).parent('.select-billing').find('.icon-checkbox').find('.icon-iconcheck').css('display','block');
        $(element).parent().parent().find('.billing').hide();
        $(element).parent().parent().find('.billing').find('.billing-field-required').removeAttr('required')
    }else{
        $(element).parent('.select-billing').find('.icon-checkbox').find('.icon-iconcheck').css('display','none');
        $(element).parent().parent().find('.billing').show();
        $(element).parent().parent().find('.billing').find('.billing-field-required').attr('required','required')
    }
}
function PresMobileCheckoutCartShowContent(element){
    $(element).parent().find('.premobile-detail-content').toggle();
    $(element).find('.fa').toggle();
    $(element).find('.checkoutonestep-title').toggleClass('checkoutonestep-title-show');
}
function PreMobileCheckoutCartCheckedPaymentMethod(element,id){
    $('.payment').find('.payment-method').removeClass('payment-checked');
    $('.payment-'+id).find('.payment-method').addClass('payment-checked');
    var get_pmethod = $(element).attr('data-payment-method');
    console.log(get_pmethod);
    $('.get_payment_method').val(get_pmethod);
}
function PreMobileCheckoutCartTermsCondition() {
    var termdata = $('.accept-terms').parent().attr('accept-term-data');
    if (termdata == 'true') {
        $('.terms-conditions').attr('accept-term-data','false');
        $('.accept-terms').removeClass('accept');
        $('.checkout-buttom').css('opacity','0.4');
        $('.checkout-buttom').addClass('disabledbutton');
        $('#Presmobile-chekoutonestep-payment').hide();
    } else {
        $('.terms-conditions').attr('accept-term-data','true');
        $('.accept-terms').addClass('accept');
        $('.checkout-buttom').css('opacity','1');
        $('.checkout-buttom').removeClass('disabledbutton');
        $('#Presmobile-chekoutonestep-payment').show();
    }
}
function PreMobileCheckoutCartShowTermsBlock(){
    $('.terms-conditions-popup').fadeIn();
    $('body').css('overflow-y','hidden');
}
function PreMobileCheckoutCartCloseTermsBlock(){
    $('.terms-conditions-popup').fadeOut();
    $('body').css('overflow-y','auto');
}
function PreMobileCheckoutCartAcceptButton(){
    $('.terms-conditions').attr('accept-term-data','true');
    $('#Presmobile-chekoutonestep-payment').show();
    $('.accept-terms').addClass('accept');
    $('.checkout-buttom').css('opacity','1');
    $('.checkout-buttom').removeClass('disabledbutton');
    setTimeout(function(){
        PreMobileCheckoutCartCloseTermsBlock();
    }, 200);
}
function PreMobileCheckCardFields(){
    var nuber = $('.card-number').val();
    var month = $('.month-number').val();
    var year = $('.year-number').val();
    var security = $('.security-code').val();
    var fname = $('.fname-card').val();
    var lname = $('.lname-card').val();
    if(nuber == ''){
        $('.field-err-1').show();
    }else{
        $('.field-err-1').hide();
    }
    if(month == '' || year ==''){
        $('.field-err-2').show();
    }else{
        $('.field-err-2').hide();
    }
    if(security == ''){
        $('.field-err-3').show();
    }else{
        $('.field-err-3').hide();
    }
    if(fname == '' || lname ==''){
        $('.field-err-4').show();
    }else{
        $('.field-err-4').hide();
    }
}
function PreMobileContactUsCheckFields(element){
    var filed = $(element).val();
    if(filed !=''){
        $(element).css('border-bottom','1px solid lime');
    }
}
function PreMobileCartDeleteProductButton(element,id,id_attribute){
    $('.abcre').attr("onclick","PresMobiremoveProductCart("+id+","+id_attribute+")");
    $('.presmobile-delete-popup').fadeIn();
}
function PreMobileCartCloseButton(){
    $('.presmobile-rmpro-popup').fadeOut();
}
function PreMobileCartCheckOutButton(){
    $('.presmobile-checkout-popup').fadeIn();
}
function PreMobileOrderByIdCanel(){
    $('.cancel-order-popup').fadeIn();
}
function PreMobileOrderByIdPopupHide(){
    $('.cancel-order-popup').fadeOut();
}
function PreMobiClearFavoriteProduct(){
    $('.favorite-popup').fadeIn();
}
function PreMobiClearFavoriteProductHide(){
    $('.favorite-popup').fadeOut();
}
function PreMobiCheckFieldsContactUs(){
    var cont_us_name = $(".contactus_name").val();
    var cont_us_email = $(".contactus_email").val();
    var cont_us_subject = $(".contactus_subject").val();
    var cont_us_message = $(".contactus_message").val();
}
function PresMobiCategoryShort(element){
    $(element).find('span i').css('opacity','1');
}
$(document).on("pagecreate",function(){
   $(".header-title").on("swipeleft",function(){
     $("#category .header-title h3").css({'text-overflow': 'inherit','overflow':'auto'});
     $("#merchandisereturns .header-title h3").css({'text-overflow': 'inherit','overflow':'auto'});
    });
});
function PresMobileClickToAddressFieldTitle(element){
    $(element).parent().find('.txt-checkout').focus();
    console.log('aaa');
}
function PresMobiChoiceAddress(){
    $('.choice-address').show();
}
function PresMobiCheckdelivery(element){
    var checked = $(element).is(":checked");
    if (checked ==true) {
        $('.presmobile-choose-billing-addess').fadeOut();
    } else {
        $('.presmobile-choose-billing-addess').fadeIn();
    }
    $.post("" + url_presmobileapp + "modules/presmobileapp/ajax/PresMobiupdateaddresscart.php?token_pres="+token_pres,
    {
        check:1
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        var html = '';
        $.each(obj, function(i, f) {
            $.each(obj[i]['content'], function(i, m) {
                html += '<h5 class="fullname-detail">'+m.lastname+' '+m.firstname+'</h5>';
                html += '<p class="company-detail">'+m.company+'</p>';
                html += '<p class="address-detail">'+m.address1+' '+m.address2+'</p>';
                html += '<p class="city-detail">'+m.city+' '+m.state+' '+m.postcode+'</p>';
                html += '<p class="country-detail">'+m.country+'</p>';
                html += '<p class="homephone-detail">'+m.phone+'</p>';
                html += '<p class="mobile-detail">'+m.phone_mobile+'</p>';
            });
        });
        $('.address-content-'+obj[0]['type']).html(html);
    });
}
function PresMoblieShowAddressSelectPopup(choose_class){
    $('.'+choose_class).fadeIn();
    $('body').addClass('hiedden-scroll');
}
function PresMoblieHideAddressSelectPopup(choose_class){
    $('.'+choose_class).fadeOut();
    $('body').removeClass('hiedden-scroll');
}
function PresMoblieChangeMyDeliveryAddress(element){
    var deliveryaddresid = $(element).attr('value');
    $(element).parent().parent().find('.apply-change-delivery-address').attr('onclick','PresMobiupdateaddress('+deliveryaddresid+',1),PresMoblieHideAddressSelectPopup("popup-choose-delivery-address")');
    $('.list-delivery-address').removeClass('addressselected');
    $('.list-delivery-address-'+deliveryaddresid).addClass('addressselected');
}
function PresMoblieChangeMyBillingAddress(element){
    var billingaddresid = $(element).attr('value');
    $(element).parent().parent().find('.apply-change-billing-address').attr('onclick','PresMobiupdateaddress('+billingaddresid+',2),PresMoblieHideAddressSelectPopup("popup-choose-billing-address")');
    $('.list-billing-address').removeClass('addressselected');
    $('.list-billing-address-'+billingaddresid).addClass('addressselected');
}
function PresMoblieApplyDeleteMyAddress(element) {
    PresMoblieShowAddressSelectPopup('popup-delete-myaddress');
    var delete_data = $(element).attr('delete-data');
    $('.popup-delete-myaddress .apply-delete-address').attr("onclick","PresMobideleteAddress("+delete_data+"),PresMoblieHideAddressSelectPopup('popup-delete-myaddress')")
}
function PresMoblieChangeLanguage(element){
    var languagesid = $(element).attr('value');
    $('.list-language').removeClass('languageselected');
    $('.list-language-'+languagesid).addClass('languageselected');
    $('.apply-choose-language').attr('data-language',languagesid)
}
function PresMoblieChangeCurrency(element){
    var currencyid = $(element).attr('value');
    $('.list-currency').removeClass('currencyselected');
    $('.list-currency-'+currencyid).addClass('currencyselected');
    $('.apply-choose-currency').attr('data-currency',currencyid);
}
function PresMoblieChangeMerchandise(element){
    var merchandiseid = $(element).attr('id_value');
    $('.list-merchandise').removeClass('merchandiseselected');
    $('.list-merchandise-'+merchandiseid).addClass('merchandiseselected');
    $('.create-rmaslip-button').attr('data-merchandise',merchandiseid);
}
var pressmobile_orientation = window.screen.orientation.type;
if(pressmobile_orientation == 'landscape-primary'){
    $('.category-box').css("height","47vmax");
    $('.PresMobilebox-content').css("padding","5%");
}else{
    $('.PresMobilebox-content').css("padding","29% 5%");
    $('.td_tab_category>div>.td_tab_category_product .category-box').css("height","47vmin");
}
function PresMobiDeleteWishList(id_wishlist){
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PreMobi-deletewishlist.php?token_pres="+token_pres,
    {
        id_wishlist:id_wishlist
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        $('.wishlist_'+id_wishlist).remove();
        PreMobimessenger('success',obj.messenger);
    });
}
function PresMobiUpdateWishList(id_wishlist){
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PreMobi-updatewishlist.php?token_pres="+token_pres,
    {
        id_wishlist:id_wishlist
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        PreMobimessenger('success',obj.messenger);
    });
}
function PresMobiRenderWishList(id_wishlist){
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PreMobi-renderwishlist.php?token_pres="+token_pres,
    {
        id_wishlist:id_wishlist
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        PreMobimessenger('success',obj.messenger);
    });
}
function PresMobiRenderWishListTab(id){
    $(".wishlist-product-box").fadeOut();
    $(".wishlist-product-box-"+id).fadeIn();
    $('.wishlist-tab').removeClass('wishlist-tab-active');
    $('.wishlist-tab-'+id).addClass('wishlist-tab-active');
}
function PresMobiRenderWishListSendPermalink(element,e){
    var key = e.keyCode;
    var value = $(element).val();var class_id = 0;
    if (key == 13) {
        var lists_wishlist = '<span class="mail_wishlist mail_wishlist_'+class_id+'" data-mail="'+value+'">'+value+' <sup onclick="PresMobileRemoveMail(this)">X</sup></span>';
        if (!validateEmail(value) || value =='') {
            PreMobimessenger(status = 'error', 'Invalid email address.');
            return false;
        }else {
            $('.lists-mail').append(lists_wishlist);
            $('.lists-mail').addClass('lists-mail-data');
            $('.box_input_wishlist').css('margin-top','0');
            $(element).val('');
            class_id ++;
        }
    }
}
function PresMobiUpdateQuantityWishlistminus(id){
    var quantity = $('.w_quantity_'+id).val();
    if (quantity == 1) {
        return false;
    }
    $('.w_quantity_'+id).val(--quantity);
}
function PresMobiUpdateQuantityWishlistplus(id){
    var quantity = $('.w_quantity_'+id).val();
    $('.w_quantity_'+id).val(++quantity);
}
function PresMobileRemoveMail(element){
    $(element).parent().remove();
}
function PresMobiSendWishList(id_wishlist){
    var email = '';
    $('.mail_wishlist_0').each(function(){
        email += $(this).attr('data-mail') +',';
    });
    $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PreMobi-sendwishlist.php?token_pres="+token_pres,
    {
        id_wishlist:id_wishlist,
        email:email
    },
    function (data, status) {
        var obj = jQuery.parseJSON(data);
        PreMobimessenger('success',obj.messenger);
    });
}
function PresMoblieAddToWishlist(element){
    var wishlistid = $(element).attr('value-wishlist');
    $('.list-wishlist').removeClass('wishlistselected');
    $('.list-wishlist-'+wishlistid).addClass('wishlistselected');
    $('.apply-choose-wishlist').attr('data-wishlist',wishlistid);
}
//
function bazoomgimg(id_img){
    $('.zoomimgaa').css('display', 'none');
    $('.'+id_img).css('display', 'block');
}
function PresMoblieChangeProductToMessenger(element){
    var idproductlist = $(element).attr('value');
    $('.producttomessenger').removeClass('producttoselected');
    $('.producttomessenger-'+idproductlist).addClass('producttoselected');
    $('.apply-choose-product').attr('data-prodtomess',idproductlist);
}
function PresMoblieRepMessenger(id_order){
    var text = $('.rep-message').val();
    var id_pro = $('.producttoselected').attr('value');
    var currentdate = new Date(); 
    var datetime = "" + currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + "  "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();
    if (text != '') {
        $('.PresMobileorder-messenger-block-content').append('<div class="message-content clearfix"><div class="message-guests"><span class="message">'+text+'</span><span class="time">'+datetime+'</span></div></div>');
        $('.rep-message').val('');
        $.post("" + url_presmobileapp + "/modules/presmobileapp/ajax/PreMobi-sendorderdetail.php?token_pres="+token_pres,
        {
            text:text,
            id_order:id_order,
            id_product:id_pro
        },
        function (data, status) {
            var obj = jQuery.parseJSON(data);
            if (obj.status == '401') {
                PreMobimessenger('error',obj.messenger);
            }
        });
    }
}