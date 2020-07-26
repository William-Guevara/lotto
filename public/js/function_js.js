
/*----------------------------------------------------*/
/*	Revolution Slider
/*----------------------------------------------------*/

if ($.fn.cssOriginal != undefined) {
    $.fn.css = $.fn.cssOriginal;
}

$(document).ready(function() {
    $('.fullwidthbanner').revolution({
        delay: 9000,
        startwidth: 1180,
        startheight: 470,
        onHoverStop: "on", // Stop Banner Timet at Hover on Slide on/off
        navigationType: "none", //bullet, none
        navigationArrows: "verticalcentered", //nexttobullets, verticalcentered, none
        navigationStyle: "none", //round, square, navbar, none
        touchenabled: "on", // Enable Swipe Function : on/off
        navOffsetHorizontal: 0,
        navOffsetVertical: 20,
        stopAtSlide: -
            1, // Stop Timer if Slide "x" has been Reached. If stopAfterLoops set to 0, then it stops already in the first Loop at slide X which defined. -1 means do not stop at any slide. stopAfterLoops has no sinn in this case.
        stopAfterLoops: -
            1, // Stop Timer if All slides has been played "x" times. IT will stop at THe slide which is defined via stopAtSlide:x, if set to -1 slide never stop automatic
        fullWidth: "on",
    });
});


/*----------------------------------------------------*/
/*	FlexSlider
/*----------------------------------------------------*/

$(window).load(function() {
    $('.flexslider').flexslider({
        animation: "fade",
        controlNav: false,
        animationSpeed: 10000,
        smoothHeight: true
    });
});


/*----------------------------------------------------*/
/*	ShowBiz Carousel
/*----------------------------------------------------*/

function is_mobile() {
    var agents = ['android', 'webos', 'iphone', 'ipad', 'blackberry', 'Android', 'webos', , 'iPod', 'iPhone', 'iPad',
        'Blackberry', 'BlackBerry'
    ];
    var ismobile = false;
    for (i in agents) {
        if (navigator.userAgent.split(agents[i]).length > 1)
            ismobile = true;
    }
    return ismobile;
}

jQuery('#recent-work').showbizpro({
    dragAndScroll: (is_mobile() ? "on" : "off"),
    visibleElementsArray: [4, 4, 3, 1],
    carousel: "off",
    entrySizeOffset: 0,
    allEntryAtOnce: "off"
});

jQuery('#our-clients').showbizpro({
    dragAndScroll: "off",
    visibleElementsArray: [5, 4, 3, 1],
    carousel: "off",
    entrySizeOffset: 0,
    allEntryAtOnce: "off"
});

jQuery('#testimonials').showbizpro({
    dragAndScroll: "off",
    visibleElementsArray: [1, 1, 1, 1],
    carousel: "off",
    entrySizeOffset: 0,
    allEntryAtOnce: "off"
});

jQuery('#happy-clients').showbizpro({
    dragAndScroll: "off",
    visibleElementsArray: [1, 1, 1, 1],
    carousel: "off",
    entrySizeOffset: 0,
    allEntryAtOnce: "off"
});

jQuery('#team').showbizpro({
    dragAndScroll: "off",
    visibleElementsArray: [3, 3, 3, 1],
    carousel: "off",
    entrySizeOffset: 0,
    allEntryAtOnce: "off"
});
