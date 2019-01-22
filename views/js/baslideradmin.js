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
 
function hideOtherLanguage1(id)
{
    $('.translatable-field1').hide();
    $('.lang1-' + id).show();
    var id_old_language = id_language;
    id_language = id;
    if (id_old_language != id)
        changeEmployeeLanguage();
    updateCurrentText();
}
function textfile(id_lang) {
    var error = 0;
    var id_data_default = $('#lang_default').val();
    $('#fileToUpload'+id_lang).trigger('click');
    $('#fileToUpload'+id_lang).change(function (e) {
        var target = event.target || event.srcElement;
        if (target.value.length != 0) {
            var path_img = $(this).val();
            var files = $(this)[0].files[0];
            var filestype = files.name.split('.').pop();
            var str = "jpg,JPG,png,PNG,jpeg,JPEG";
            var searchstring = str.search(filestype);
            var filessize = files.size;
            if (filessize > 200000) {
                error = 1;
            }
            if (searchstring == '-1') {
                error = 2;
            }
            if (error == '1') {
                alert('Sorry, File too large (limit of 2MB).');
                $('#text_file'+id_lang).attr('value', '');
                $('#fileToUpload'+id_lang).attr('value', '');
                $('#virtual_product_file_uploader-name'+id_lang).attr('value', '');
                if (id_data_default == id_lang) {
                    $('.id_lang_default').val('');
                }
            }
            if (error == '2') {
                path_img = path_img.replace(/\\/g, "/");
                $('#text_file'+id_lang).attr('value', path_img);
                var files = $(this)[0].files;
                    var name = '';
                    $.each(files, function (index, value) {
                        name += value.name + ', ';
                    });
                alert(name.slice(0, -2) +' Image format not recognized, allowed formats are: *.jpeg, *.jpg, *.png');
                $('#virtual_product_file_uploader-name'+id_lang).attr('value', '');
                $('#text_file'+id_lang).attr('value', '');
                $('#fileToUpload'+id_lang).attr('value', '');
                if (id_data_default == id_lang) {
                    $('.id_lang_default').val('');
                }
            }
            if (error == '0') {
                path_img = path_img.replace(/\\/g, "/");
                $('#text_file'+id_lang).attr('value', path_img);
                if ($(this)[0].files !== undefined) {
                    var files = $(this)[0].files;
                    var name = '';
                    $.each(files, function (index, value) {
                        name += value.name + ', ';
                    });
                    $('#virtual_product_file_uploader-name'+id_lang).attr('value', name.slice(0, -2));
                } else {
                    var name = $(this).val().split(/[\\/]/);
                    $('#virtual_product_file_uploader-name'+id_lang).attr('value', name.slice(0, -2));
                }
            }
            $('#fileToUpload'+id_lang).off();
        }
    });
}
function activeimg(id_lang){
    $('#active_on_'+id_lang).bind('click', function(){
        toggleDraftWarning(false);
    });
    $('#active_off_'+id_lang).bind('click', function(){
        toggleDraftWarning(true);
    });
}
function basaveslider() {
    var data_default = $('.id_lang_default ').val();
    if (data_default == '') {
        alert('You must upload at least a file for default language');
        return false;
    }
    var formData = new FormData($("#form")[0]);
    $.ajax({
        url: "" + url_presmobileapp + "/modules/presmobileapp/ajax/PreMobi-saveslider.php",
        type: "POST",
        data: formData,
        async: false,
        success: function (data) {
            if (data == 1) {
                window.location.href = url2;
            } else {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
                $("#demomode").css('display', 'block');
                return false;
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
function baeditslider(id_lang) {
    var data_default = $('#virtual_product_file_uploader-name'+id_lang).val();
    if (data_default == '') {
        alert('Please select a images');
        return false;
    }
    var formData = new FormData($("#form")[0]);
    $.ajax({
        url: "" + url_presmobileapp + "/modules/presmobileapp/ajax/PreMobi-editslider.php",
        type: "POST",
        data: formData,
        async: false,
        success: function (data) {
            if (data == 1) {
                window.location.href = url3;
            } else {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
                $("#demomodep").css('display', 'block');
                return false;
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
    