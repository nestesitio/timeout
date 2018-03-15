function inputChanged(element) {
    if(element === null){
        return;
    }
    var hf = element.hasAttribute("data-function");
    if (hf === true) {
        var f = element.getAttribute("data-function");
        //$("#jsmonitor").append(element.id + " ->"+  f + "<br />");
        
        if (f === "exportValue") {
            exportValue(element);
        }
        
        if (f === "importOptionsIfEmpty") {
            importOptionsIfEmpty(element);
        }
        
        if (f === "changePage") {
            var url = $(element).attr("data-action");
            var layer = $(element).attr("data-layer");
            if (layer !== null) {
                url = url.replace("/id/", "/" + $(element).val() + "/");
                $('#' + layer).load(url);
            }
            return;
        }
        
        if (f === "checkAvailability") {
            checkAvailability(element);
        }
        
    }
    
}

function sendForm(element, url, parent) {
    var f = checkFiles().length * 1000;
    setTimeout(function () {
        var form = $(element).closest("form");
        var form_data = serializeForm(form);
        $.post(url + "&js=1", form_data, function (data, status) {
            $(parent).html(data);
            $('#modal').modal('show');
            $('#modal-title').html('Data saved');
            var id = $('#post-id').val();
            $(parent).find('.menu-edit-tools a').attr('data-id', id);

        });
    }, f);

    return null;
}

function checkFiles(){  
    $('.kv-file-upload').trigger("click");
    return $('.kv-file-upload').toArray();
}

function preload(element){
    $('#preload').remove();
    $(element).css("position", "relative");
    $(element).append('<div id="preload"></b>');
}

function closeForms(){
    var btns = $(".btn-edit-undo").get();
    for (var i = 0; i < btns.length; i++) {
        if($(btns[i]).hasClass("disabled") !== true){
            $(btns[i]).trigger('click');
        }
    }
}

function itemAction(element){
    var parent = $(element).closest(".list-item");
    if ($(element).hasClass("btn-edit-add")) {
        closeForms();
        $( '<div class="row list-item"></div>' ).insertAfter( parent );
        setAction(element, $(parent).next());
    }else{
        setAction(element, parent);
    }
    
}

function rowAction(element){
    var parent = $(element).closest(".list-item");
    if ($(element).hasClass("btn-edit-add")) {
        closeForms();
        $( '<div class="row list-item"></div>' ).insertAfter( parent );
        setAction(element, $(parent).next());
    }else{
        setAction(element, parent);
    }
    
}

function zoneAction(element){
    var parent = $(element).closest(".editor-zone");
    setAction(element, parent);
}

function setAction(element, parent){
    preload(parent);
    var url = "/backend" + $(element).attr("data-action");
    if ($(element).hasClass("btn-edit-edit")) {
        closeForms();
        
    }
    if ($(element).hasClass("btn-modal")) {
        $('#modal-title').html($(element).attr('title'));
        ajaxLoad("#modal-page", url);
        return true;
    }
    if ($(element).hasClass("btn-edit-save")) {
        sendForm(element, url, parent);
        return true;
    }
    if ($(element).hasClass("btn-edit-delete")) {
        var r = confirm("Are you sure?");
        if (r === true) {
            $(parent).load(url, function(resp, status, xhr){
                $(parent).remove();
            });
        } else {
            return 0;
        }
    }
    if ($(element).hasClass("btn-edit-undo") && $(parent).find('#data-id').html() === '0') {
        $(parent).remove();
        return true;
    }
    $(parent).load(url);

    return true;
}

function filterShopList(element){
     var div = document.getElementById('list-body');
     preload(div);

     var url = "/backend" + $(element).attr("data-action") + "?js=1&filter=" + $(element).attr("data-list-type");
     $(div).load(url);
}

function switchZone(element){
    var parent = $(element).closest(".editor-zone");
    var url = $(element).attr("data-action");
    var loadUrl = url + "&zone=" + $(element).attr('data-destinity') +  "&source=" + $(element).attr('data-source');
    $("#zone-" + $(element).attr('data-destinity')).load(loadUrl, function (output) {
        loadUrl = url.replace("switchzone", "show") + "&zone=" + $(element).attr('data-source'); 
        $(parent).load(loadUrl);
    });
    
}

function sliderAction(element){
    var div = $("#myCarousel").find(".carousel-inner").find("div.active");
    var url = $(element).attr("data-action");
    var parent = $(element).closest(".editor-zone");
    var id;
    /*alert($(div).prop("tagName"));*/
    preload(div);
    
    if ($(element).hasClass("btn-edit-save")) {
        sendForm(element, url, parent);
    } else if ($(element).hasClass("btn-edit-delete")) {
        var r = confirm("Are you sure?");
        if (r === true) {
            
            $(parent).load(url, function(resp, status, xhr){
                $('#form-zone-header .btn-edit-undo').trigger('click');
            });
        } else {
            return 0;
        }
        
    } else if ($(element).hasClass("btn-edit-edit")) {
        $('#zone-header').load(url + $(div).find("img").attr("data-id"), function (resp, status, xhr) {
                    id = $('#post-id').val();
                    if(id !== undefined){
                        $(parent).find('.menu-edit-tools a').attr('data-id', id);
                        $('.file-preview-image').css({"height": "auto", "width": "100%"});
                    }
                });
    } else {
        id = $(element).attr("data-id");
        $('#zone-header').load(url + id , function (resp, status, xhr) {
            $('.carousel-indicators [data-id=' + id + ']').trigger('click');
        });
    }
    
    return true;
}


function openPopi(element){
    var window = $(element).siblings(".popi-edit")[0];
    if(window === undefined){
        $('.popi-edit').remove();
        window = '<div class="popi-edit"><a class="close-pop-edit glyphicon glyphicon-remove"></a></div>';
        $(element).closest("li").append(window);
        $(element).siblings(".popi-edit").load($(element).attr("data-action"));
    }
    
}

function closePopi(element){
    $(element).closest('.popi-edit').remove();
}

function savePopi(element){
    sendForm(element, $(element).attr("data-action"), $(element).closest(".popi-edit"));
    var value = $('.popi-edit .zone-item-social-link input').val();
    var btn = $(element).closest(".popi-edit").siblings(".popi-link")[0];
    if(value.length > 0){
        $(btn).attr('href', value);
        $(btn).removeClass('no-data');
    }else{
        $(btn).removeAttr('href');
        $(btn).addClass('no-data');
    }
}

$(document).on('keyup', function (e) {
    if (e.keyCode === 13) {
        $('.modal .btn-edit-close').click();
    }
});
$(document).on('click', '.zone-buttons a', function () {
    zoneAction(this);
});