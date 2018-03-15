var flag = true;

function ajaxLoad(elem, url) {
    url += "&js=1";
    $("#preload").fadeIn(100);
    
    $(elem).load(url, function (output) {
        /*alert(url + " -> " + $(elem).attr('id'));*/
         if(output.indexOf("ERROR-PAGE-REDIRECT") === 0){
             window.top.location.href = output.substring(output.indexOf(":")+1); 
        }
        $(elem).slideDown(300, function () {
            formcontainer = $(this).height();
            flag = true;
            $("#preload").hide();
        });
    });
}

function goPage(url){
    window.location.href = url;
}

function removeByClass(a) {
    var b = document.getElementsByClassName(a);
    while (b.length > 0) {
        b[0].parentNode.removeChild(b[0]);
    }
}

function getBrotherByClass(element, classname){
    while(element.nextSibling !== null){
        element = element.nextSibling;
        if(element.className === classname){
            return element;
        }
    }
    return null;
}

function getBrotherByTag(element, tagname){
    return getChildrenByTag(element.parentElement, tagname);
}

function getParentByTag(a, tagname){
    while(a.parentElement !== null){
        a = a.parentElement;
        if(a.tagName === tagname){
            return a;
        }
    }
    return null;
}

function getParentByClass(a, classname) {
    if (a !== undefined) {
        while (a.parentElement !== null) {
            a = a.parentElement;
            if ($(a).hasClass(classname) === true) {
                return a;
            }
        }
    }
    return null;
}

function getChildrenByClass(element, classname) {
    for (var i = 0; i < element.children.length; i++) {
        if ($(element.children[i]).hasClass(classname) === true) {
            return element.children[i];
        }
    }
    return null;
}

function getChildrenByTag(element, tagname) {
    for (var i = 0; i < element.children.length; i++) {
        if (element.children[i].tagName === tagname) {
            return element.children[i];
        }
    }
    return null;
}

function createWork(close_link) {
    var window = document.createElement("DIV");
    window.setAttribute("class", "datawindow");
    //<div id="preload" style="display: none"></div>
    var preload = document.createElement("DIV");
    preload.setAttribute("id", "preload");
    preload.setAttribute("style", "display:none");

    var work = document.createElement("DIV");
    work.setAttribute("class", "datawork col-lg-11");
    work.setAttribute("style", "display: none;");
    window.appendChild(preload);

    window.appendChild(work);
    
    if (close_link === true) {
        var close = document.createElement("DIV");
        close.setAttribute("class", "drag col-lg-1");
        var aclose = document.createElement("A");
        aclose.setAttribute("class", "closework glyphicon glyphicon-remove");
        close.appendChild(aclose);
        window.appendChild(close);
    }

    return window;
}

$(function() {
    $('body').on('mousedown', '.drag', function() {
        var drag = $(this).parent();
        $(drag).addClass('draggable').parents().on('mousemove', function(e) {
            $('.draggable').offset({
                top: e.pageY - 30,
                left: e.pageX - $('.draggable').outerWidth() + 30
            }).on('mouseup', function() {
                $(drag).removeClass('draggable');
            });
        });
        //e.preventDefault();
    }).on('mouseup', function() {
        $('.draggable').removeClass('draggable');
    });
});

function clearSelection() {
    var sel = window.getSelection ? window.getSelection() : document.selection;
    if (sel) {
        if (sel.removeAllRanges) {
            sel.removeAllRanges();
        } else if (sel.empty) {
            sel.empty();
        }
    }
}

function addSupport(element){
    $(".datawindow").remove();
    $("#layer-one").show();
    var window = createWork(true);
    document.getElementById("layer-one").appendChild(window);
    ajaxLoad(getChildrenByClass(window, 'datawork'), element.getAttribute("data-action"));
}

function textFromPHP(value) {
    /* Convert <br> to newline. */
    var retval = value.replace(/<br[\s\/]?>/gi, "\n");
    retval = retval.replace("\n\n", "\n");
    return retval.trim();
}

function modalLoad(element){
    var action = element.getAttribute("data-action");
    var layer = document.getElementById(element.getAttribute("data-layer"));
    ajaxLoad(layer, action);
}

function monitor() {
    width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
    $('#jsmonitor').html(
            " dim: " + width + " x " + window.innerHeight);
}



function boolGlyph(){
    var bools = document.getElementsByClassName("bool");
    var content;
    for(var i = 0; i < bools.length; i++){
        content = bools[i].innerHTML;
        if(content === "1" || bools[i].title === "1" || bools[i].title === "Sim"){
            bools[i].className = 'bool col fa fa-check ok';
            bools[i].innerHTML = '';
        }else if(content === "0"){
            bools[i].innerHTML = "x";
            bools[i].className = 'bool col';
        }else if(content === ""){
            bools[i].innerHTML = "-";
            bools[i].className = 'bool col';
        }
    }
}

function postCsv(form, filename) {
    form = validateForm(form);
    var form_data = serializeForm(form);
    if (getFormErrors() === 0) {
        $("#preload").fadeIn(100);
        $.post(form.action, form_data, function (data) {
            if (data) {
                csv(filename, data);
                $("#preload").hide();
            }

        });
    };
}

function saveForm(element) {
    //alert("teste");
    var form = validateForm(getParentByTag(element.parentElement, "FORM"));
    //var types = ['input', 'textarea', 'button', 'select', 'option', 'optgroup', 'fieldset', 'label'];
    var form_data = serializeForm(form);
    
    if (getFormErrors() === 0) {
        //$("#jsmonitor").append(JSON.stringify(data) + "<br />" +form.action+ "<br />");
        //$("#jsmonitor").append(form.action+ "<br />");
        if (flag === true) {
            $("#preload").fadeIn(100);
            $.post(form.action + "&js=1", form_data, function (data, status) {
                $(form.parentElement).html(data);
                $("#preload").hide();
                flag = false;
            });
        }else{
            flag = true;
        }
    }

}

//buttons
function editForm(element) {
    flag = true;
    var action = element.getAttribute("data-action");
    var str_id = element.getAttribute("data-id");
    var url = "/" + action + "/" + str_id;
    var parent = getParentByClass(element, "datawork");
    $(parent).load(url).slideDown("slow");

}

function serializeForm(form){
    
    var data = $(form).serializeArray();
    
    var modifiedArray = [];
    var counts = {};
    var multipleValues = {};
    $.each(data, function(index, value) {
        if ($('#'+value.name).is('select') && $('#'+value.name).has('optgroup').length) {
            //select with optgroup return labels not id, so to return id
            value.value = processOptgroup(value.name, value.value);
        }
        data[index] = {name: value.name, value: convertValue(value.name, value.value)};
        counts[value.name] = (counts[value.name])? counts[value.name] + 1 : 1;

    });
    //process multiple values
    $.each(data, function(index, value) {
        if (multipleValues[value.name] || counts[value.name] > 1){
            if (!multipleValues[value.name]) { 
                multipleValues[value.name] = 1; 
            } else { 
                multipleValues[value.name] += 1; 
            }
            
            modifiedArray.push({name: value.name + "_" + multipleValues[value.name], value: value.value});
            
        }else{
            modifiedArray.push({name: value.name, value: value.value});
        }
        
    });

    /*$.each(modifiedArray, function(index, value) {
        //$("#jsmonitor").append(value.name + ": " + value.value + "<br />");
    });*/
    return modifiedArray;
}


function changeContent(element){
    
    var option = 0;
    $('#' + element.id + ' :selected').each(function (i, selected) {
        option = $(selected).val();
    });
    var layer = element.getAttribute("data-layer");
    var url = element.getAttribute("data-action") + "/?value=" + option + "&js=1&id=" + element.getAttribute("data-id");
     $("#" + layer).load(url, function (output) {
        $(layer).html(output);
    });
}

function toEdit() {
    var element, url, input;
    var elements = document.getElementsByClassName("to-edit");
    for (var i = 0; i < elements.length; i++) {
        element = elements[i];
        url = element.getAttribute("data-action");
        input = element.getAttribute("data-input");
        $(element).editable(url, {
            data: function (value, settings) {
                return textFromPHP(value);
            },
            type: input, id: 'content', cancel: 'Cancel', submit: 'Gravar',
            indicator: 'Saving...', tooltip: 'Click to edit...',
            cssclass : 'jedit'
        });
    }
}