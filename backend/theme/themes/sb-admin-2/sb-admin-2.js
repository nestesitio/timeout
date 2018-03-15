$( document ).ready(function() {

    $('#side-menu').metisMenu();
    
    var url = window.location;

    var str = (url.toString()).replace("http://", "");
    str = str.substring(str.indexOf("/") + 1);
    var app = (str.indexOf("/") === -1) ? '' : "/" + str.substring(0, str.indexOf("/"));
    //$("#jsmonitor").append("<br />: " + str + " -> " + app);
    $('ul.nav a[href^="'+ app +'"]').addClass('active').parent().parent().addClass('in').parent().addClass('active');

    // Will also work for relative and absolute hrefs
    $('ul.nav a').filter(function() {
        return (this.href == url);
    }).addClass('active').parent().parent().addClass('in').parent().addClass('active');

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        //if (width < 768) {
        if (width < 992) {
            $('div.navbar-collapse-sitio').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse-sitio').removeClass('collapse');
        }

        height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });
});

