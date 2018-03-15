function getUrl(element){
    var action = element.getAttribute("data-action");
    if(action === null){
        action = element.getAttribute("data-edit");
    }
    var url = "/" + action + "/";
    url = url.replace('//', '/');
    var str_id = element.getAttribute("data-id");
    url += (null !== str_id && str_id !== "")? str_id + "/?" : "?";
    var key;
    var attr = element.attributes;
    for(var i = 0; i <  attr.length; i++){
        key = attr[i].name;
        if(key.indexOf("data-") > -1){
            if(key !== "data-command" && 
                    key !== "data-action" && 
                    key !== "data-edit" && 
                    key !== "data-id" && 
                    key !== "data-layer"){
                url += key.substr(5) + "=" + attr[i].value + "&";
            }
        }
    }
    return url;
}

function sortList(element){
    var url = getUrl(element) + "sort=" + element.getAttribute("data-field");
    var parent = getParentByClass(element.parentElement, "mothergrid");
    ajaxLoad(getChildrenByClass(parent, "datagrid"), url);
}

function setBtnEdit(element){
    var url = getUrl(element);
    var div = getChildrenByClass(element, 'row-editable');
    $(div).show();
    if ($(div).html() === "") {
        var selectaction = element.getAttribute("data-select");
        element.removeAttribute("title");
        if (selectaction !== null) {
            $(div).editable(url, {
                loadurl: "/" + selectaction + "/" + element.getAttribute("data-id"),
                type: 'select', submit: 'OK', tooltip: null
            });
        } else {
            $(div).editable(url, {
                data: function (value, settings) {
                    return textFromPHP(value);
                },
                type: 'text', id: 'content', cancel: 'Cancel', submit: 'Gravar',
                indicator: 'Saving...', tooltip: 'Click to edit...'
            });
        }
        $(div).trigger("click");
    }else{
        $(div).hide();
        $(div).html("");
    }
    
}

function setThumbAction(element) {
    $(".row-editable").hide();
    var command = element.getAttribute("data-command");
    var row = getParentByClass(element, "file-gallery");
    var url = getUrl(element);
    if (command === "del") {
        deleteRow(row, url);
        row.parentNode.removeChild(row);
    }
}

function closeModal(){
    $('.modal').find('.modal-body').text('');
    $('.modal').modal('hide');
    $('.modal-backdrop').remove();
}

function setModalAction(element) {
    $('.datawindow').remove();
    $('.modal').modal('show');
    $('.modal').on('shown.bs.modal', function (event) {
        var modal = $(this);
        modal.find('h2').text(element.getAttribute("title"));
        var url = getUrl(element);
        ajaxLoad(modal.find('.modal-body'), url);
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        
    });
}

function setRowAction(element) {
    $(".row-editable").hide();
    if(element.getAttribute("data-edit") !== null){
        setBtnEdit(element);
        
    }else if (element.getAttribute("href") === null) {
        var command = element.getAttribute("data-command");
        var row = getParentByClass(element, "datarow");
        var url = getUrl(element);
        //$(".grid-filters").hide();
        closeFilter(document.getElementsByClassName("btn-hidefilter")[0]);
        closeDataWindow(getParentByClass(element, "bodygrid"));
        if (command === "del") {
            deleteRow(row, url);
        }else if (command === "transfer") {
            transferTask(element, row, url);
        }else{
            flag = true;
            var window = appendDataWork(row);
            if(command === "langs"){
                $(window).find(".datawork").attr("class", "datawork window-float col-lg-11");
            }else{
                $(window).find(".datawork").attr("class", "datawork window-normal col-lg-11");
            }
            setWork(window, url);
            adjustRowWidth();
        }
    }

}

function setFloatAction(element){
    var url = getUrl(element);
    var window = getParentByClass(element, "datawindow");
    $(window).find(".datawork").attr("class", "datawork window-normal col-lg-11");
    setWork(window, url);
    adjustRowWidth();
}


function appendDataWork(element) {
    var parent = element.parentElement;
    var window = createWork(true);
    var next = element.nextSibling;
    if (next === null) {
        parent.appendChild(window);
    } else {
        parent.insertBefore(window, next);
    }
    return window;
    
}

function appendNewWork(element) {
    var window = createWork(true);
    var next = element.firstChild;

    if (next === null) {
        element.appendChild(window);
    } else {
        element.insertBefore(window, next);
    }
    window.className += " new-work";
    $(window).attr("class", "datawindow new-work");
    $(window).find(".datawork").attr("class", "datawork window-normal col-lg-11");
    return window;
}

function setWork(window, url) {
    var work = getChildrenByClass(window, 'datawork');
    flag = true;
    ajaxLoad(work, url);
}

function getButtonAction(element){
    var bodygrid;
    var parent = getParentByClass(element, "grid-buttons");
    var datagrid = getBrotherByClass(parent, "datagrid");
    if(datagrid === null){
        datagrid = getBrotherByClass(parent.parentElement, "datagrid");
    }else{
        closeFilter(document.getElementsByClassName("btn-hidefilter")[0]);
    }
    flag = true;
    bodygrid = getChildrenByClass(datagrid, "bodygrid");
    closeDataWindow(bodygrid);
    return bodygrid;
}

function setButtonAction(element) {
    var url = getUrl(element);
    var layer = $(element).attr('data-layer');
    var window;
    if (layer !== undefined){
        window = document.getElementById(layer);
    }else{
        var bodygrid = getButtonAction(element);
        window = appendNewWork(bodygrid);
    }
    setWork(window, url);
}

function setButtonActionFlush(element) {
    var work;
    var url = getUrl(element);
    var layer = $(element).attr('data-layer');
    if (layer === null) {
        var bodygrid = getButtonAction(element);
        var work = getChildrenByClass(appendNewWork(bodygrid), 'datawork');
        work.style.display = "block";
    }else if(layer === 'next'){
        work = element.parentNode.nextElementSibling;
        scroll = true;
    }else if (layer !== null){
        work = document.getElementById(layer);
    }
    
    flag = true;
    streamingLoad(work, url);
}

function setButtonActionForLayer(element, layer) {
    var url = getUrl(element);
    var bodygrid = getButtonAction(element);
    var window = appendNewWork(bodygrid);
    setWork(window, url);
}

function closeDataWindow(element){
    var div = getChildrenByClass(element, 'datawindow');
    if(div !== null){
        $(div).remove();
    }
}


function closeWorkRow(element) {
    var parent = element.parentElement.parentElement;
    parent.parentElement.removeChild(parent);
    formcontainer = 0;
}

function closeForm(element) {
    var layer = $(element).attr('data-layer');
    if (undefined !== layer) {
        setButtonAction(element);
    } else {
        var parent = element.parentElement;
        while ($(parent).hasClass("datawindow") === false) {
            //while(parent.className !== "datawindow"){
            parent = parent.parentElement;
        }
        formcontainer = 0;
        $(parent).slideUp(300, function () {
            $(this).remove();
        });
    }

}


//after list
function updateList(){ 
    
    var a = document.getElementsByClassName("list-nums")[0];
    if(undefined !== a){
        var text = a.textContent;
        var nums = text.split("/");
        $("#list-results").text(nums[0]);
        $("#list-total").text(nums[1]);
        $(a).remove();
    }
}

////////filters and paginate
function filterList(element){
    var form = getParentByTag(element, "FORM");
    closeFilter(document.getElementsByClassName("btn-hidefilter")[0]);
    //$("#jsmonitor").append(form.action+ " by filter<br />");
    
    var data = serializeForm(form);
    $.post(form.action, data, function(data) {
        var parent = getParentByClass(element, "headgrid");
        $(getBrotherByClass(parent, "datagrid")).html(data);
    });
}

function filterAllList(element){
    var form = getParentByTag(element, "FORM");
    var id;
    for (var i = 0; i < form.length; i++) {
        id = form.elements[i].id;
        resetInput(form.elements[i], form.elements[i].id);
        $( "a.repeat-input[data-id='"+ id + "']" ).attr('class', 'clear-input');
    }
    $("span.glyphicon-repeat").attr('class', 'glyphicon glyphicon-refresh');
    //closeFilter(document.getElementsByClassName("btn-hidefilter")[0]);
    var parent = getParentByClass(element, "headgrid");
    ajaxLoad(getBrotherByClass(parent, "datagrid"), element.getAttribute("data-action") + "&clear-filters=1");
}

function paginate(element){
    var action = element.getAttribute("data-action");
    var pagin = element.getAttribute("data-id");
    ajaxLoad(getParentByClass(element, "datagrid"), "/" + action + "?paging=" + pagin);
}

function reFilter(layer, url){
    ajaxLoad(document.getElementById(layer), url);
}


function openFilter(element){
    if (element !== undefined) {
        var headgrid = getChildrenByClass(getParentByClass(element.parentElement, "table-responsive"), "headgrid");
        var formdiv = getChildrenByClass(headgrid, "grid-filters");
        $(formdiv).slideToggle("slow", function() {
            filtercontainer = $(this).height();
        });
        element.textContent = "";
        var span = document.createElement("SPAN");
        span.className = "glyphicon glyphicon-remove";
        element.appendChild(span);
        var t = document.createTextNode(" Fechar");     // Create a text node
        element.appendChild(t);
        element.className = "btn-hidefilter btn btn-xs btn-primary";
        $(".chosen-container").css( "width", "100%" );
        repareChosen();
    }
}

function closeFilter(element){
    if (element !== undefined) {
        var headgrid = getChildrenByClass(getParentByClass(element.parentElement, "table-responsive"), "headgrid");
        var formdiv = getChildrenByClass(headgrid, "grid-filters");
        $(formdiv).slideToggle("slow", function() {
            filtercontainer = 0;
        });
        //<a href="#" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-filter"></span> Filtrar</a>
        element.textContent = "";
        var span = document.createElement("SPAN");
        span.className = "glyphicon glyphicon-filter";
        element.appendChild(span);
        var t = document.createTextNode(" Filtrar");     // Create a text node
        element.appendChild(t);
        element.className = "btn-showfilter btn btn-xs btn-primary";
    }
}

////////////////
function adjustRowWidth() {
    //$("#jsmonitor").text("");

    var bodygrid = document.getElementsByClassName("bodygrid");
    var w;
    for (var i = 0; i < bodygrid.length; i++) {
        w = getDataRowSize(bodygrid[i]);
        var datarow = bodygrid[i].children;
        if (w > 0) {
            for (var x = 0; x < datarow.length; x++) {
                if(datarow[x].className === "datarow"){
                    datarow[x].style.width = w + "px";
                }
            }
        }
        //$("#jsmonitor").append(bodygrid[i].children[i].className + "<br />");
    }
}

function getDataRowSize(element){
    var w = 0;
    var datarow = element.children;
    if (datarow[0] !== undefined) {
        for (var x = 0; x < datarow.length; x++) {
            if(datarow[x].className === "datarow"){
                var ul = datarow[0].getElementsByTagName("LI");
                //$.trim( $(ul).text().replace( /[\s\n\r]+/g, ' ' ) );
                for (var i = 0; i < ul.length; i++) {
                    w += ul[i].offsetWidth + 4;
                }
                return w;
            }
        }
    }
    return 0;
}


function transferTask(element, row, url) {

    $.ajax({url: url,
        success: function (output) {
            var layer = document.getElementById(element.getAttribute("data-layer"));
            $(layer).html(output);
            $(row).remove();
        }});
}

function addToGallery(src, id){
    var div = getChildrenByClass(document.getElementById('modal-bodygrid'), 'file-gallery');
    var item = div.cloneNode(true);
    item.style.display = "block";
    $( item ).find( "img" ).attr("src", src);
    $( item ).find( "a" ).attr("data-id", id);
    $( item ).find( "a" ).attr("data-htm", $("#data-htm").text());
    $(div.parentElement).prepend(item);
}

function imageChoose(element){
    var thumb = $(element).closest('div[class^="thumbnail"]');
    
    $.post(getUrl(element) + "&js=1", 
    {media: $(element).attr('data-id'), htm: $(element).attr('data-htm')}, function (data, status) {
        if (data === '1') {
            if ($(thumb).hasClass("media-choice")) {
                $(thumb).removeClass("media-choice");
            } else {
                $(thumb).addClass("media-choice");
            }
        }
    });
    
    
}



