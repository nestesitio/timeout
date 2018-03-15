$(function () {

    var tmh = {
        vars: {
            TIME_SLIDER: 10000,
            control: 0,
            time: null
        },
        el: {
            swipe: null,
            win: $(window),
            main: $('.home')
        },
        changeSlider: function () {
            clearTimeout(tmh.vars.time);

            tmh.el.main.find('.home-slideshow__slider--active').removeClass('home-slideshow__slider--active');
            tmh.el.main.find('.home-slideshow__slider').eq(tmh.vars.control).addClass('home-slideshow__slider--active');

            tmh.el.main.find('.home-slideshow__control--active').removeClass('home-slideshow__control--active');
            tmh.el.main.find('.home-slideshow__control').eq(tmh.vars.control).addClass('home-slideshow__control--active');

            tmh.vars.time = setTimeout(function () {
                tmh.vars.control++;
                if (tmh.vars.control >= tmh.el.main.find('.home-slideshow__slider').size())
                    tmh.vars.control = 0;

                tmh.changeSlider();
            }, tmh.vars.TIME_SLIDER);
        },
        init: function () {
            tmh.changeSlider();

            tmh.el.main.find('.home-slideshow').swipe({
                allowPageScroll: "vertical",
                preventDefaultEvents: false,
                tap: function (event, target) {
                    //window.open(tmh.el.main.find('.home-slideshow__slider').eq(tmh.vars.control).attr('href'), "_self");
                },
                swipeLeft: function (event, direction, distance, duration, fingerCount) {
                    tmh.vars.control++;
                    if (tmh.vars.control >= tmh.el.main.find('.home-slideshow__slider').size())
                        tmh.vars.control = 0;
                    tmh.changeSlider();
                },
                swipeRight: function (event, direction, distance, duration, fingerCount) {
                    tmh.vars.control--;
                    if (tmh.vars.control < 0)
                        tmh.vars.control = tmh.el.main.find('.home-slideshow__slider').size() - 1;
                    tmh.changeSlider();
                },
                //Default is 75px, set to 0 for demo so any distance triggers swipe
                threshold: 25,
                excludedElements: ""
            });

            tmh.el.main.on('click', '.home-slideshow__control', function (event) {
                event.preventDefault();
                var el = $(this);
                tmh.vars.control = el.index();
                tmh.changeSlider();
            });

            tmh.el.win.resize(function () {
                var h = $(window).height() - tmh.el.main.find('.site-header').height();
                tmh.el.main.find('.home-slideshow').height(h);
            }).trigger('resize');
        }

    };

    var tmc = {
        vars: {
        },
        el: {
            win: $(window),
            main: $('.contacts'),
            map: null
        },
        init: function () {
            var styles = [{"featureType": "all", "elementType": "labels.text.fill", "stylers": [{"saturation": 36}, {"color": "#000000"}, {"lightness": 100}]}, {"featureType": "all", "elementType": "labels.text.stroke", "stylers": [{"visibility": "on"}, {"color": "#000000"}, {"lightness": 16}]}, {"featureType": "all", "elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {"featureType": "administrative", "elementType": "geometry.fill", "stylers": [{"color": "#000000"}, {"lightness": 20}]}, {"featureType": "administrative", "elementType": "geometry.stroke", "stylers": [{"color": "#000000"}, {"lightness": 17}, {"weight": 1.2}]}, {"featureType": "landscape", "elementType": "geometry", "stylers": [{"color": "#000000"}, {"lightness": 20}]}, {"featureType": "poi", "elementType": "geometry", "stylers": [{"color": "#000000"}, {"lightness": 21}]}, {"featureType": "road.highway", "elementType": "geometry.fill", "stylers": [{"color": "#000000"}, {"lightness": 17}]}, {"featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{"color": "#000000"}, {"lightness": 29}, {"weight": 0.2}]}, {"featureType": "road.arterial", "elementType": "geometry", "stylers": [{"color": "#000000"}, {"lightness": 18}]}, {"featureType": "road.local", "elementType": "geometry", "stylers": [{"color": "#000000"}, {"lightness": 16}]}, {"featureType": "transit", "elementType": "geometry", "stylers": [{"color": "#000000"}, {"lightness": 19}]}, {"featureType": "water", "elementType": "geometry", "stylers": [{"color": "#000000"}, {"lightness": 17}]}];

            var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});

            var mapOptions = {
                zoom: 15,
                center: new google.maps.LatLng(38.7067345, -9.145906),
                disableDefaultUI: true,
                mapTypeControlOptions: {
                    mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
                }
            };

            tmc.el.map = new google.maps.Map(document.getElementById('contacts__map'), mapOptions);
            tmc.el.map.mapTypes.set('map_style', styledMap);
            tmc.el.map.setMapTypeId('map_style');

            var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|00aae5");
            /*var image = 'http://timeout.loadhtl.com/wp-content/themes/timeout/img/timeoutlogo.jpg';*/

            var marker = new google.maps.Marker({
                position: {lat: 38.7067324, lng: -9.145906},
                map: tmc.el.map,
                icon: pinImage
            });
        }
    }

    var tmaet = {
        vars: {
            types: null
        },
        el: {
            header: $('.eat-and-shop-archive-header'),
            items: $('.eat-and-shop-archive')
        },
        init: function () {

            tmaet.el.header.on('click', 'button', function (event) {
                event.preventDefault();
                var _this = $(this);

                if (_this.hasClass("eat-and-shop-archive-header__filter--active")) {
                    _this.removeClass('eat-and-shop-archive-header__filter--active');
                } else {
                    _this.parent().find('.eat-and-shop-archive-header__filter--active').removeClass('eat-and-shop-archive-header__filter--active');
                    _this.addClass('eat-and-shop-archive-header__filter--active');
                    _this.blur();
                }


                tmaet.checkTypes();
            });
        },
        checkTypes: function () {
            tmaet.vars.types = [];
            tmaet.el.header.find('.eat-and-shop-archive-header__filter').each(function (index, el) {
                var _this = $(el);
                if (_this.hasClass('eat-and-shop-archive-header__filter--active')) {
                    tmaet.vars.types.push(_this.attr('data-list-type'));
                }
            });

            tmaet.filterTypes();
        },
        filterTypes: function () {
            tmaet.el.items.each(function (index, el) {
                var _this = $(el);

                var n_filters = tmaet.vars.types.length;
                if (n_filters > 0) {
                    for (var i = 0; i < tmaet.vars.types.length; i++) {
                        if (_this.attr('data-type') == tmaet.vars.types[i]) {
                            _this.show();
                        } else {
                            _this.hide();
                        }
                    }
                } else {
                    _this.show();
                }
            });
        }
    }

    var tm = {
        vars: {
        },
        el: {
            brand: $('.site-branding'),
            doc: $(document),
            win: $(window)
        },
        init: function () {
            tm.el.win.on('scroll', function (event) {

                var per = (tm.el.win.scrollTop() / (tm.el.doc.height() - tm.el.win.height())) * 100;

                if (per > 5) {
                    tm.el.brand.addClass('site-branding--hide');
                } else {
                    tm.el.brand.removeClass('site-branding--hide');
                }

                $('.scroll').each(function (i) {
                    var el = $(this);
                    var bottom_of_object = el.offset().top + el.outerHeight() * .5;
                    var bottom_of_window = tm.el.win.scrollTop() + tm.el.win.height();

                    if (bottom_of_window > bottom_of_object) {
                        el.addClass('scroll--show');
                    }

                });

            });
        }
    }

    var tmconcept = {
        vars: {
            drag: false,
            x_el: 0,
            x_pos: 0,
            canvasMask: null,
            pigMask: null
        },
        el: {
            win: $(window),
            timeline: $('.concept__timeline'),
            holder: $('.concept__timeline-holder'),
            wrapper: $('.concept__timeline-wrapper'),
            pig: $('.concept__timeline-pig')
        },
        init: function () {
            tmconcept.arrangeItems();
            tmconcept.addEvents();
        },
        arrangeItems: function () {
            var _w = 0;
            tmconcept.el.timeline.find('.concept__timeline-item').each(function (index, el) {
                var _this = $(this);
                _w += _this.outerWidth();
                _this.css('left', (index * _this.outerWidth()) + 'px');
            });

            tmconcept.el.wrapper.css('width', _w + 'px');
        },
        addEvents: function () {
            tmconcept.vars.canvasMask = new Dragdealer('concept__timeline-holder', {
                x: 0,
                y: 0,
                vertical: false,
                //speed: 0.2,
                //loose: true,
                animationCallback: function (x, y) {
                    if (tmconcept.vars.pigMask) {
                        tmconcept.vars.pigMask.setValue(x, 0, true);
                    }
                }
            });
            tmconcept.vars.pigMask = new Dragdealer('concept__timeline-pig', {
                animationCallback: function (x, y) {
                    tmconcept.vars.canvasMask.setValue(x, 0, true);
                }
            });

            tmconcept.el.win.on('resize', function (event) {
                event.preventDefault();

                if (tmconcept.el.win.width() < 600) {
                    tmconcept.el.wrapper.css('width', '100%');
                } else {
                    tmconcept.arrangeItems();
                    //if(tmconcept.vars.pigMask) tmconcept.vars.pigMask.reflow();
                    //if(tmconcept.vars.canvasMask) tmconcept.vars.canvasMask.reflow();
                }


            }).trigger('resize');
        }

    }



    if ($('body').hasClass('home'))
        tmh.init();
    if ($('body').hasClass('page-id-533') || $('body').hasClass('page-id-539'))
        tmc.init();
    if ($('body').hasClass('post-type-archive-comer-e-beber'))
        tmaet.init();
    if ($('body').hasClass('page-template-concept'))
        tmconcept.init();

    tm.init();
    var theLanguage = $('html').attr('lang');


    $(".site-header .menu-lang").append($(".search-container"));
    $('header .menu-main-pt-container').css("height", $(window).height());

    $('.middle').imagesLoaded(function () {
        if ($(".sampleClass").css("float") == "none") {
            $(".home-module__col .home-module__image-wrapper .home-module__image").css({'height': (($(".col--two").outerHeight() - $(".home-module__header").outerHeight()) + 'px')});
            $(".branding").append($("#lang_sel_list"));
            $(".reff-small").css({'height': ($(".reff-big").height() + 'px')});
            $('.icl-pt-pt a').html('Portuguese');
            $('.icl-en a').html('English');


        } else {
            $(".home-module__col .home-module__image-wrapper .home-module__image").css({'height': 'auto'});
            $(".reff-small").css({'height': 'auto'});
            $(".menu-lang").append($("#lang_sel_list"));
            $('.icl-pt-pt a').html('pt');
            $('.icl-en a').html('en');
        }

    });

    multiply(ch, cw);


    $(function () {checkSize();});
    $(window).resize(checkSize);


    function checkSize() {
        if ($(".sampleClass").css("float") == "none") {
            $(".middle-east-image").css({'height': ($(".middle-west").outerHeight() - $(".middle-west header:first").outerHeight())});
            
            $(".event-class").css({'height': ($(".img-map").outerHeight() + $(".newsletter-module").outerHeight() + 'px')});
            $(".event-parent").css({'height': ($(".img-map").outerHeight() + $(".newsletter-module").outerHeight() + 'px')});
            $(".event-parent").css({'width': ($(".home").outerWidth() / 2 + 'px')});
            $(".reff-small").css({'height': ($(".reff-big").height() + 'px')});

            $(".branding").append($("#lang_sel_list"));
            $('.icl-pt-pt a').html('Portuguese');
            $('.icl-en a').html('English');
        } else {
            $(".event-class").css({'height': 'auto'});
            $(".event-parent").css({'height': 'auto'});
            $(".event-parent").css({'width': 'auto'});
            $(".home-module__col .home-module__image-wrapper .home-module__image").css({'height': 'auto'});
            $(".menu-lang").append($("#lang_sel_list"));
            $('.icl-pt-pt a').html('pt');
            $('.icl-en a').html('en');
            $(".reff-small").css({'height': 'auto'});
        }

        multiply(ch, cw);
        multiply(mch, mcw);
        multiply(mche, mcwe);
        $('header .menu-main-pt-container').css("height", $(window).height());
    }


    var ch = $('.home .academia-parent').height();
    var cw = $('.home .academia-child').height();
    function multiply(pheight, cwidth) {
        var parentHeight = pheight;
        var childHeight = cwidth;
        if ($(".sampleClass").css("float") == "none") {
            $('.home .academia-child').css('margin-top', (parentHeight - childHeight) / 2.7);// your code here

        } else {
            $('.home .academia-child').css('margin-top', 0);
        }

    }
    multiply(ch, cw);

    var mch = $('.page-id-533 .academia-parent').height();
    var mcw = $('.page-id-533 .academia-child').height();
    function multiply(pheight, cwidth) {
        var parentHeight = pheight;
        var childHeight = cwidth;
        if ($(".sampleClass").css("float") == "none") {
            $('.page-id-533 .academia-child').css('margin-top', (parentHeight - childHeight) / 2);// your code here

        } else {
            $('.page-id-533 .academia-child').css('margin-top', 0);
        }

    }
    multiply(mch, mcw);

    var mche = $('.page-id-539 .academia-parent').height();
    var mcwe = $('.page-id-539 .academia-child').height();
    function multiply(pheight, cwidth) {
        var parentHeight = pheight;
        var childHeight = cwidth;
        if ($(".sampleClass").css("float") == "none") {
            $('.page-id-539 .academia-child').css('margin-top', (parentHeight - childHeight) / 2);// your code here

        } else {
            $('.page-id-539 .academia-child').css('margin-top', 0);
        }

    }
    multiply(mche, mcwe);



    // this is a Jquery plugin function that fires an event when the size of an element is changed
    // usage: $().sizeChanged(function(){})

    (function ($) {

        $.fn.sizeChanged = function (handleFunction) {
            var element = this;
            var lastWidth = element.width();
            var lastHeight = element.height();

            setInterval(function () {
                if (lastWidth === element.width() && lastHeight === element.height())
                    return;
                if (typeof (handleFunction) == 'function') {
                    handleFunction({width: lastWidth, height: lastHeight},
                            {width: element.width(), height: element.height()});
                    lastWidth = element.width();
                    lastHeight = element.height();
                }
            }, 100);


            return element;
        };

    }(jQuery));


    $('.academia-parent').sizeChanged(function () {
        var ch = $('.academia-parent').height();
        var cw = $('.academia-child').height();
        multiply(ch, cw);
    });

    $('.inputform').focus(function () {
        if (!$(this).data("DefaultText"))
            $(this).data("DefaultText", $(this).val());
        if ($(this).val() != "" && $(this).val() == $(this).data("DefaultText"))
            $(this).val("");
    }).blur(function () {
        if ($(this).val() == "")
            $(this).val($(this).data("DefaultText"));
    });


});