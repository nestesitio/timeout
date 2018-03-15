var xmlHttp;
var scroll = false;

function streamingLoad(layer, url) {
    var preload = document.getElementById('preload');
    if(preload === null){
        preload = document.createElement("DIV");
        preload.setAttribute("id", "preload");
        preload.setAttribute("style", "display:none");
        layer.parentElement.appendChild(preload);
    }
    

    xmlHttp = GetXmlHttpObject();
    xmlHttp.open("GET", url, true);
    xmlHttp.setRequestHeader("Accept-Charset", "UTF-8");
    if (xmlHttp === null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    $("#preload").fadeIn(100);

    xmlHttp.onreadystatechange = function () {
        var num = xmlHttp.readyState;
        if (num === 4) {
            $("#preload").hide();
            preload.remove();
            if (xmlHttp.status === 200) {

                $(layer).html(xmlHttp.responseText);
                
                if(layer.getElementsByTagName("script").length > 0){
                    evalScripts();
                }
                return true;
            }
        } else if (num === 3) {
            $(layer).html(xmlHttp.responseText);
            if(scroll === true){
                $('html, body').animate({scrollTop: $(layer).next().offset().top-200}, 200);
            }
        }
    };

    xmlHttp.send(null);

}


function GetXmlHttpObject() {
    var objXMLHttp = null;
    if (window.XMLHttpRequest) {
        objXMLHttp = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        objXMLHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return objXMLHttp;
}

function evalScripts() {
    var script = document.getElementsByTagName("script");
    for (var i = 0; i < script.length; i++)
        eval(script[i].innerHTML);
}