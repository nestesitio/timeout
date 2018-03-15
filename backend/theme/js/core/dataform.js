/* global getParentByClass */

var form_errors = 0;

function getFormErrors(){return form_errors;}

function validateForm(form){
    registFormLabels(form);
    form_errors = 0;
    for (var i = 0; i < form.length; i++) {
        if (form.elements[i].hasAttribute("data-valid") && form.elements[i].getAttribute("data-valid") === 'false') {
            form_errors++;
        }else if (form.elements[i].hasAttribute("required")) {
            if (form.elements[i].tagName === "INPUT") {
                form_errors += testEmptyValue(form.elements[i]);
            } else if (form.elements[i].tagName === "SELECT") {
                form_errors += testChosen(form.elements[i]);
            } else if (form.elements[i].tagName === "FIELDSET") {
                form_errors += validateFieldsetGroup(form.elements[i], form);
            }
        }
        if (form.elements[i].tagName === "INPUT") {
            form_errors += validateFormElement(form.elements[i], form.elements[i].value);
        }

    }
    return form;
}

function processOptgroup(id, value){
    //make select return id values
    var options = document.getElementById(id).options;
    for (var i = 0; i < options.length; i++) {
        if(options[i].id !== null && options[i].value === value){
            return options[i].id;
        }
    }
    return value;
}


function processForm(form){
    form_errors = 0;
    var data = [];
    var type;
    registFormLabels(form);

    for (var i = 0; i < form.length; i++) {
        if (form.elements[i].hasAttribute("data-valid") && 
                form.elements[i].getAttribute("data-valid") === 'false') {
            form_errors++;
        }else{
            var required = (form.elements[i].hasAttribute("required")) ? true : false; 
            
            if (form.elements[i].tagName === "SELECT") {
                data = (testChosen(data, form.elements[i], required));
            } else if (form.elements[i].tagName === "FIELDSET") {
                validateFieldsetGroup(form.elements[i], form, required);
            } else {
                type = form.elements[i].getAttribute('type');
                if (type === "checkbox") {
                    if (form.elements[i].value === 'on') {
                        data.push($(form.elements[i]).serializeArray());
                    } else if (required === true) {
                        form_errors++;
                    }
                }else if(type === 'hidden'){
                    data.push($(form.elements[i]).serializeArray());
                }else{
                    data = validateFormElement(data, form.elements[i], form.elements[i].value, required);
                }
            }
            
             
            //$("#jsmonitor").append(form.elements[i].id + ": " + form.elements[i].value + "<br />");
            
        }

    }
    //console.log(data);
    return getDataArray(data);
}

function writeMessage(input, text){
    var div = getParentByClass(input, "form-group");
    var span = getChildrenByClass(div, "input-msg");
    $(span).html(text);
}

function testRegValue(reg, input) {
    var div = getParentByClass(input, "form-group");
    if (reg.test(input.value) === false) {
        div.className = div.className + " has-error";
        labelErrorMessage(input.id, " this value is not valid");
        return 1;
    } else {
        div.className = "form-group has-success";
        labelErrorMessage(input.id, "");
        return 0;
    }
}

function labelErrorMessage(id, message) {
    document.getElementById(id).label.nextSibling.innerHTML = message;
}
//on save form

function testEmptyValue(element) {
    var value = element.value;
    var div = getParentByClass(element, "form-group");
    var id = element.id;
    if (id === null || id === "") {
        id = getParentByClass(element, "input-group").id;
    }
    if (value === "" || value === null || value === 0) {
        div.className = "form-group has-error";
        labelErrorMessage(id, " this value is required");
        return 1;
    } else {
        div.className = "form-group has-success";
        labelErrorMessage(id, "");
        return 0;
    }
}


function testChosen(element) {
    var div = getParentByClass(element, "form-group");
    var chosen = getChildrenByClass(div, "chosen-container");
    var choice = getChildrenByClass(chosen, "chosen-default");
    if (choice !== null) {
        div.className = "form-group has-error";
        labelErrorMessage(element.id, " this value is required");
        return 1;
    } else if (element.hasAttribute("multiple")) {
        choice = getChildrenByClass(getChildrenByClass(chosen, "chosen-choices"), "search-choice");
        if (choice === null) {
            div.className = "form-group has-error";
            labelErrorMessage(element.id, " this value is required");
            return 1;
        }
    }
    div.className = "form-group has-success";
    labelErrorMessage(element.id, "");
    return 0;
}

function validateFormElement(element, value) {
    var type = element.getAttribute('type');
    if (type === "email") {
        return testRegValue(/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/, element);
    } else if (type === "url") {
        return testRegValue(/(ftp|http|https):\/\/[^\.\/\- ].+/, element);
    } else if (type === "number") {
        if ((element.value !== parseInt(value)) || (value !== parseFloat(value))) {
            getParentByClass(element, "form-group").className = "form-group has-error";
            labelErrorMessage(element.id, " this value is not valid number");
            return 1;
        }
    } else if (type === "tel") {
        var stripped = value.replace(/[\(\)\.\-\ ]/g, '');
        if (isNaN(parseInt(stripped)) || stripped.length < 6 || stripped.length > 14) {
            getParentByClass(element, "form-group").className = "form-group has-error";
            labelErrorMessage(element.id, " this value is not valid");
            return 1;
        }
    } else if (type === "password") {
        var illegalChars = /[\W_]/;
        if ((value.length < 5) || (value.length > 15) || (illegalChars.test(value) !== false)) {
            getParentByClass(element, "form-group").className = "form-group has-error";
            labelErrorMessage(element.id, " this password is not valid");
            return 1;
        }
    }
    if (type !== 'hidden') {
        getParentByClass(element, "form-group").className = "form-group has-success";
    }
    return 0;
}

function validateFieldsetGroup(element, form){
    var id = element.id;
    var checks = 0;
    for (var i = 0; i < form.length; i++) {
        if(form.elements[i].name === id){
            if(form.elements[i].checked === true){
                checks++;
            }
        }
    }
    var div = getParentByClass(element, "form-group");
    if (checks === 0) {
        div.className = "form-group has-error";
        labelErrorMessage(id, " some value is required");
        return 1;
    } else {
        div.className = "form-group has-success";
        labelErrorMessage(id, "");
        return 0;
    }
}


function resetForm(element) {
    var form = element.parentElement.parentElement;
    //parent.parentElement.removeChild(parent);
}

function registFormLabels(form) {
    var labels = form.getElementsByTagName('LABEL');
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].htmlFor !== '') {
            var elem = document.getElementById(labels[i].htmlFor);
            if (elem)
                elem.label = labels[i];
        }
    }
}

//after save
function changeRow() {
    var b = document.getElementsByClassName("update-row");
    var a = b[0];
    var parent = getParentByClass(a, "datawindow");
    var div = parent.getElementsByClassName("data-id")[0];
    var row = parent.previousSibling;
    updateData(row, a.parentElement, div.textContent);
    $(parent).remove();
    
}

function updateDataRow() {
    var b = document.getElementsByClassName("update-row");
    var a = b[0];
    var parent = getParentByClass(a, "datawindow");
    var div = parent.getElementsByClassName("data-id")[0];
    var row = parent.previousSibling;
    if (row === null) {
        var grid = getParentByClass(parent, "datagrid");
        appendRow(grid, parent, a.parentElement, div.textContent);
        var num = parseInt($("#list-results").text()) + 1;
        $("#list-results").text(num);
        num = parseInt($("#list-total").text()) + 1;
        $("#list-total").text(num);

    } else {
        updateData(row, a.parentElement, div.textContent);
        var divlang = parent.getElementsByClassName("data-lang")[0];
        if(divlang !== undefined){
            updateLang(row, divlang.textContent);
            $(divlang).remove();
        }
    }
    $(a).remove();
    $(div).remove();
}

function updateLang(row, lang){
    var ul = getChildrenByTag(row, 'UL');
    for (var i = 0; i < ul.children.length; i++) {
        if (ul.children[i].getAttribute('data-lang') === lang) {
            var a = getChildrenByClass(ul.children[i], 'row-action');
            $(a).css({'opacity' : '1'});
            return;
        }
    }
}

function appendRow(grid, elem, source, id) {
    var row = document.createElement("DIV");
    row.setAttribute("class", "datarow");

    var ul = document.createElement("UL");
    ul.removeAttribute("class");
    ul.setAttribute("class", "grid");
    row.appendChild(ul);

    //bodygrid
    var nodes = grid.previousElementSibling.childNodes;
    for (var i = 0; i < nodes.length; i++) {
        ul.appendChild(nodes[i].cloneNode(true));
    }
    var body = grid.getElementsByClassName("bodygrid")[0];
    body.insertBefore(row, elem);
    updateData(ul, source, id);
    adjustRowWidth();
    $(row).css('background-color', '#ff9');

}

function updateData(ul, source, id) {
    var showdata = source.getElementsByClassName("show-data");
    var li = ul.getElementsByTagName("li");
    var ii;
    li[0].textContent = ":";
    li[0].title = id;
    $(ul).find('a').attr('data-id', id);
    for (var i = 0; i < showdata.length; i++) {
        for (ii = 0; ii < li.length; ii++) {
            if (li[ii].hasAttribute("data-field")
                    && showdata[i].getAttribute("data-field") === li[ii].getAttribute("data-field")) {
                //alert(showdata[i].getAttribute("data-field"));
                li[ii].innerHTML = showdata[i].innerHTML;
                setBool(showdata[i], li[ii]);
                li[ii].title = showdata[i].textContent;
                
            }
            
        }
    }
    var btn = source.getElementsByClassName("editform")[0];
    if (undefined !== btn) {
        btn.removeAttribute("data-id");
        btn.setAttribute("data-id", id);
        var btns = ul.getElementsByClassName("row-action");
        for (i = 0; i < btns.length; i++) {
            btns[i].removeAttribute("data-id");
            btns[i].setAttribute("data-id", id);
        }
    }


}

function setBool(element, li){
    boolGlyph();
    if($(li).hasClass("bool") === true){
        if(li.getAttribute("title") === '1'){
            element.innerHTML = 'Sim';
        }else{
            element.innerHTML = 'Não';
        }
    }
}

// to delete
function delForm(element) {
    var r = confirm("Are you sure?");
    if (r === true) {
        var action = element.getAttribute("data-action");
        var str_id = element.getAttribute("data-id");
        var url = "/" + action + "/" + str_id;
        var parent = getParentByClass(element, "datawork");
        $("#" + parent.id).load(url).slideDown("slow");
    } else {
        return 0;
    }
}


function deleteRow(row, url) {
    var r = confirm("Are you sure?");
    if (r === true) {
        var window = appendDataWork(row);
        setWork(window, url);
    } else {
        return 0;
    }
}

function confirmAction(element){
    var r = confirm(element.getAttribute("data-text"));
    if (r === true) {
        var url = element.getAttribute("data-url");
        if(null !== url){
            window.location=url;
        }
    }
    return 0;
}

function substracTotals(element) {
    var window = getParentByClass(element, "datawork");
    if (window === null) {
        var num = parseInt($("#list-results").text()) - 1;
        $("#list-results").text(num);
        num = parseInt($("#list-total").text()) - 1;
        $("#list-total").text(num);
    }

}

function removeDataRow() {
    var a = document.getElementsByClassName("remove-row")[0];
    var parent = getParentByClass(a, "datawindow");
    var result = 0;
    var row;
    if (null === parent) {
        parent = getParentByClass(a, "row-editable");
        result = parent.getElementsByClassName("data-id")[0].textContent;
        if (result === "0") {
            $(parent).html("");
        }else{
            row = getParentByClass(parent, "datarow");
            $(row).remove();
        }
    } else {
        result = parent.getElementsByClassName("data-id")[0].textContent;
        if (result !== "0") {
            row = parent.previousSibling;
            updateList();
            substracTotals(parent);
            $(row).remove();
            setTimeout(function () {
                if (parent.parentElement !== null) {
                    $(parent).remove();
                }
            }, 4000);

        }
    }
}

function removeThumbnail(){
    var a = document.getElementsByClassName("remove-thumb")[0];
    var parent = getParentByClass(a, "datawindow");
    var result = parent.getElementsByClassName("data-id")[0].textContent;
    if (result !== "0") {
       $(parent).remove(); 
    }
    
}

function addDataRow() {
    var a = document.getElementsByClassName("remove-row")[0];
    var url = a.parentElement.getElementsByClassName("data-id")[0].textContent;
    ajaxLoad(getParentByClass(a, "datagrid"), url);
}


function clearInput(element) {
    var id = element.getAttribute("data-id");
    resetInput(document.getElementById(id), id);
    element.children[0].className = "glyphicon glyphicon-repeat";
    element.className = "repeat-input";
}

function resetInput(input, id){
    if (input.tagName === "SELECT") {
        input.setAttribute("value", input.selectedIndex);
        if(input.hasAttribute("multiple")){
            input.selectedIndex = -1;
        }else{
            input.selectedIndex = 0;
        }
        $(input).trigger('chosen:updated');
        repareChosen();
    } else if (input.tagName === "DIV") {
        var input = input.getElementsByTagName("INPUT")[0];
        input.setAttribute("value", input.value);
        input.value = "";
    }else if(input.getAttribute("type") === "checkbox"){
        $( "input[id='"+id+"']" ).prop('checked', false);
    } else {
        input.value = "";
    }
    inputChanged(input);
}

function repeatInput(element) {
    var id = element.getAttribute("data-id");
    var input = document.getElementById(id);
    if (input.tagName === "SELECT") {
        var multi = input.multiple;
        if (multi === true) {
            var options = input.options;
            for (var i = 0; i < options.length; i++) {
                options[i].selected = true;
            }
        } else {
            input.selectedIndex = input.getAttribute("value");
        }
        $(input).trigger('chosen:updated');
        repareChosen();
    } else if (input.tagName === "DIV") {
        var input = input.getElementsByTagName("INPUT")[0];
        input.value = input.getAttribute("value");
    }else if(input.getAttribute("type") === "checkbox"){
        $( "input[id='"+id+"']" ).prop('checked', true);
    } else {
        input.value = input.getAttribute("value");
    }
    inputChanged(input);
    element.children[0].className = "glyphicon glyphicon-refresh";
    element.className = "clear-input";
}


function convertInputToSelect(element){
    var select = document.createElement("SELECT");
    element.removeAttribute("list");
    var datalist = getBrotherByTag(element, "DATALIST");
    if(null !== datalist){
        $(datalist).remove();
    }
    var attr = element.attributes;
    for (var i = 0; i < attr.length; i++) {
        select.setAttribute(attr[i].name, attr[i].value);
    }
    $(element).replaceWith(select);
    return select;
}

function addValueInput(element) {
    var f = element.getAttribute("data-function");
    if (f === "addService") {
        addServiceToInput(element);
    }else if(f === "addSupply"){
        addSupplyToInput(element);
    }else{
        addValueToInput(element, element.getAttribute("data-action"));
    }
}

function addValueToInput(element, url) {
    var select = getBrotherByTag(element, "SELECT");
    var importFrom;
    if(null !== select) {
        importFrom = document.getElementById(select.getAttribute("data-import"));
        var value = 0;
        if (importFrom !== null) {
            value = $(importFrom).val();
            if (value === '0') {
                alert("Seleccione Categoria");
                return;
            }
        }
        $(getBrotherByTag(element, "DIV")).remove();
        select.style.display = "block";
        var datalist = document.createElement("DATALIST");
        datalist.setAttribute("id", select.id + "_list");
        $.ajax({url: url,
            success: function (output) {
                $(datalist).html(output);
            }});
        /*
        var x = select.children.length;
        for (var i = 0; i < x; i++) {
            select.children[i].removeAttribute("value");
            datalist.appendChild(select.children[i].cloneNode(true));
        }
        */
        element.parentElement.insertBefore(datalist, element);
        var newelement = document.createElement("INPUT");
        var attr = select.attributes;
        for (i = 0; i < attr.length; i++) {
            newelement.setAttribute(attr[i].name, attr[i].value);
        }
        newelement.setAttribute("list", select.id + "_list");
        $(select).replaceWith(newelement);
        newelement.focus();
        inputChanged(newelement);
    }else{
        
        var select = getBrotherByTag(element, "INPUT");
        var value = select.value;
        select = convertInputToSelect(select);
        var option = document.createElement("option");
        option.text = value;
        option.setAttribute("selected", "selected");
        importFrom = document.getElementById(select.getAttribute("data-import"));
        var selectvalue = $(importFrom).val();
        url = importFrom.getAttribute("data-action") + "/" + selectvalue;
        $.ajax({url: url,
            success: function (output) {
                $(select ).html(output);
                select .add(option);
                $(select).trigger('chosen:updated');
                inputChanged(element);
            }});
        
        //generateOptions(select, option, null);
    }

}

function importOptionsIfEmpty(element){
    var options = document.getElementById(element.id).options;
    if(options.length === 1 && options[0].text === ""){
        var importFrom = document.getElementById(element.getAttribute("data-import"));
        var field = importFrom.getAttribute("data-field");
        var values = "";
        $('#' + importFrom.id + ' :selected').each(function (i, selected) {
            values += $(selected).val() + "-";
        });
        if(values !== ""){
            var url = element.getAttribute("data-action") + "/?values=" + values + "&field=" + field;
            generateOptions(element, url);
        }
    }
}

function exportValue(element) {
    var exportTo = document.getElementById(element.getAttribute("data-export"));
    var tag = element.tagName;
    if (tag === 'SELECT') {
        var field = element.getAttribute("data-field");
        var options = "";
        $('#' + element.id + ' :selected').each(function (i, selected) {
            options += $(selected).val() + "-";
        });
        var url = element.getAttribute("data-action") + "/?values=" + options + "&field=" + field;
        generateOptions(exportTo, url);
    }else{
        if($(exportTo).val() === ''){
            $(exportTo).val( $(element).val() );
            inputChanged(exportTo);
        }
        
    }
}

function generateOptions(element, url) {
    url += "&js=1";
    $(element).load(url, function (output) {
        if(output.indexOf("error-routing") >= 0){
            alert(output);
        }
        $(element).html(output);
        $(element).trigger('chosen:updated');
        inputChanged(element);
    });
}

function checkAvailability(element){
    var id = element.getAttribute("data-idsource");
    var url = element.getAttribute("data-action") + '/' + $('#' + id).val() + 
            "/?value=" + $(element).val();
    var label = getChildrenByClass(element.parentNode, 'input-msg');
    $(element).load(url, function (output) {
        if(output.indexOf("error-routing") >= 0){
            alert(output);
        }
        //$(element).html(output);
        if(output === '1'){
            element.parentNode.className = "form-group has-error";
            label.innerHTML = " not valid (already in use)";
            $(element).attr("data-valid", false);
            
        }else{
            element.parentNode.className = "form-group has-success";
            label.innerHTML = " is valid";
            $(element).attr("data-valid", true);
        }
    });
}

function chosenSelectGroup(element){
    var input = element.getAttribute("data-input");
    var group = element.getAttribute("data-group");
    $('#' + input).find('option').prop('selected', false);
    if(group !== null){
        $('#' + input).find('optgroup[label="' + group + '"] option').prop('selected', true);
    }
    $('#' + input).trigger("chosen:updated");
    repareChosenHeight(input + "_chosen");
}