$(document).ready(function () {
    /***************** Page Scroll ******************/

    $(function () {
        $('a.page-scroll').bind('click', function (event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });
    });


    /***************** Owl Carousel ******************/

    $("#owl-hero").owlCarousel({

        navigation: true, // Show next and prev buttons
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true,
        transitionStyle: "fadeUp",
        autoPlay: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]

    });


    /***************** Full Width Slide ******************/

    var slideHeight = $(window).height();

    $('#owl-hero .item').css('height', slideHeight);

    $(window).resize(function () {
        $('#owl-hero .item').css('height', slideHeight);
    });
    /***************** Owl Carousel Testimonials ******************/

    $("#owl-testi").owlCarousel({

        navigation: false, // Show next and prev buttons
        paginationSpeed: 400,
        singleItem: true,
        transitionStyle: "backSlide",
        autoPlay: true

    });

    /***************** Google Maps ******************/

    function initialize() {
        (new google.maps.Marker({position: new google.maps.LatLng(51.026965, 3.7119277)})).setMap(new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(51.026965, 3.7119277),
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }));
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    /***************** Preloader ******************/

    var preloader = $('.preloader');
    $(window).load(function () {
        preloader.remove();
    });
})
