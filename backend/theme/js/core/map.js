
var google;
var markers = [];
var map;
var lat;
var lng;
var zoom;
var url;

function initialize() {
    var mapProp = {
        center: new google.maps.LatLng(lat, lng),
        /*center: new google.maps.LatLng(0, 0),*/
        zoom: zoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    if (document.getElementById("googleMap") !== null) {
        map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
        getJson(null, null);
    }
    
}
google.maps.event.addDomListener(window, 'load', initialize);

function populateMap(spots) {

    $("#list-results").html(spots.length);

    var infowindow = new google.maps.InfoWindow(), marker, i;

    for (var i = 0; i < spots.length; i++) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(spots[i].lat, spots[i].lng),
            map: map,
            icon: spots[i].icon,
            title: spots[i].name
        });
        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent('<a target="_blank" href="' + spots[i].url + '">' + spots[i].name + '</a>');
                infowindow.open(map, marker);
            };
        })(marker, i));
        markers[i] = marker;

    }
    $("#map-preload").fadeOut();
}

function cleanMap() {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    $("#map-preload").fadeIn();
}

function filterMap(element) {
    var form = getParentByTag(element, "FORM");
    /*closeFilter(document.getElementsByClassName("btn-hidefilter")[0]);*/
    cleanMap();

    getJson(form, null);
}

function filterAllMap(element) {
    var form = getParentByTag(element, "FORM");
    closeFilter(document.getElementsByClassName("btn-hidefilter")[0]);
    cleanMap();
    var id;
    for (var i = 0; i < form.length; i++) {
        id = form.elements[i].id;
        resetInput(form.elements[i], form.elements[i].id);
        $("a.repeat-input[data-id='" + id + "']").attr('class', 'clear-input');
    }
    $("span.glyphicon-repeat").attr('class', 'glyphicon glyphicon-refresh');
    getJson(form, "&clear-filters=1");
}

function getJson(form, vars) {
    
    if (form !== null) {
        var data = serializeForm(form);
        $.post(form.action + vars, data, function (output) {
            $("#map-arguments").html(output);
            populateMap(JSON.parse(output));
        });
    } else {
        $("#map-arguments").load(url, function (response, status, xhr) {
            if(status === 'success'){
                populateMap(JSON.parse(response));
            }else{
                $("#map-preload").fadeOut();
            }
            
        });
    }
}

function moveMap(element) {
    var id = $(element).find(":selected").val();
    $("#map-arguments").load('/clients/center_maps/' + id, function (response, status, xhr) {
        var coords = JSON.parse(response);
        map.setCenter({lat: parseFloat(coords[0].lat), lng: parseFloat(coords[0].lng)});
        map.setZoom(parseInt(coords[0].zoom));


    });
}

