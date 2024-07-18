/*************************/
/* LAZYLOADING OVERRIDES */
/*************************/
//add simple support for background images:
document.addEventListener('lazybeforeunveil', function(e){
    var bg = e.target.getAttribute('data-bg');
    if(bg){
        e.target.style.backgroundImage = 'url(' + bg + ')';
    }
});


/* ************************************************************ */
/* On DOC ready */
/* ************************************************************ */
jQuery(document).ready(function($){
    
    /* ************************************************************ */
    /* Global sticky scrolling behavior */
    /* ************************************************************ */
    var pos;
    var formEndPoint = 300; //Modify this value as needed
    var prevPos = $('body').scrollTop() || $('html').scrollTop();
    $(window).scroll(function(e) {
        pos = $('body').scrollTop() || $('html').scrollTop();
        // Show sticky desktop.
        if(pos > formEndPoint) {
            $('.section-nav').addClass('has-scrolled');
            $('.section-sticky').addClass('sticky');
        }
        else {
            $('.section-nav').removeClass('has-scrolled');
            $('.section-sticky').removeClass('sticky');
        }
        // For Mobile.
        if( pos > prevPos || pos == 0) {
            // Scrolling down, hide sticky mobile.
            $('.section-nav').removeClass('scrolling-up');
        }
        else {
            // Scrolling up, show sticky mobile.
            if( $('.section-nav').hasClass('has-scrolled') ){
                $('.section-nav').addClass('scrolling-up');
            } else {
                $('.section-nav').removeClass('scrolling-up');
            }
        }
        // Set previous scroll position to new scroll position for tracking (of scroll direction).
        prevPos = pos;
    
    });
    
    //Check for sticky on page load
    function display_sticky() {
        if(prevPos > formEndPoint) {
            $('.section-sticky').addClass('sticky');
        } else {
            $('.section-sticky').removeClass('sticky');
        }
    }
    
    display_sticky();

    $('img').addClass('img-fluid');
    $('a[href*="tel"]').on('click', function() {
        gtag( 'event', 'click', {'event_category' : 'Call', 'event_action' : 'Click', 'event_label' : 'Click to Call'});
    });
    
    /* ************************************************************ */
    /* GALLERY LIGHTBOX FUNCTIONS */
    /* ************************************************************ */
    if( $('.lightbox-form').length > 0 ) {
        // Lightbox Form Scripts
        var lightboxForm = $('.lightbox-form');
        $("[data-fancybox].custom-lightbox").fancybox({
            buttons: [
                "close"
            ],
            loop: true,
            thumbs: {
                autoStart: false,
                axis: "x",
            },
            transitionEffect: "slide",
            beforeShow: function (current, event) {
                if (lightboxForm.parent().hasClass('.fancybox-container')) {
                    // Do nothing - form already appended to fancybox
                    $('.fancybox-container').addClass('lightbox-form-container');
                } else {
                    lightboxForm.prependTo('.fancybox-container');
                    $('.fancybox-container').addClass('lightbox-form-container');
                }
                lightboxForm.addClass('shown');
                
                // If gallery item has data-offer-id set then make that offer text visible.
                // data-offer-id is set by editing the media attachment (Like alt and title) - "offer_link" field in "Media Options" ACF Gropu
                var fancyboxGalleryType;
                var serviceOfferTextWrap;
                if( event.opts.offerId ) {
                    fancyboxGalleryType = event.opts.offerId;
                    serviceOfferTextWrap = lightboxForm.find('[data-offer-id="' + fancyboxGalleryType + '"]').last();
                }else if( lightboxForm.find('[data-product]').length > 0 ) {
                    fancyboxGalleryType = event.opts.product;
                    serviceOfferTextWrap = lightboxForm.find('[data-product="' + fancyboxGalleryType + '"]').last();
                }else {
                    serviceOfferTextWrap = lightboxForm.find('.form-text-wrapper').last();
                }
                
                if(serviceOfferTextWrap.length > 0){
                    lightboxForm.find('.show').removeClass('show');
                    serviceOfferTextWrap.addClass('show');
                }else{
                    lightboxForm.find('.show').removeClass('show');
                    serviceOfferTextWrap = lightboxForm.find('[data-product]:first-child').addClass('show');
                }
                var fullOfferText = lightboxForm.find('[data-product].show .full-offer').text();
                fullOfferText = $.trim(fullOfferText);
                // Insert offer name into hidden form field
                lightboxForm.find('.full-offer-field').val(fullOfferText);
                // Insert image URL into hidden form field
                lightboxForm.find('.image-url-field').val(event.src);
            },
            beforeClose: function () {
                lightboxForm.removeClass('shown');
            }
        });
    }

    // Limit video size in Fancybox
    $('a.fancybox.video').fancybox({
       width  : 1280,
       height : 720,
       autoSize : false,
       autoPlay : true, //Chrome prevents autoplay
    });    
    
    /* ************************************************************ */
    /* DESIGN SYSTEM - CUSTOM FUNCTIONS */
    /* ************************************************************ */
    $('.sm-accordion .collapse.show').each(function(){
        addAccordionClasses($(this));
    });
    $('.sm-accordion .card-header button').click(function(){
       addAccordionClasses($(this));
    });
    function addAccordionClasses(element) {
        element.closest('.sm-accordion').find('.card').not(element.closest('.card')).removeClass('active');
        if( element.closest('.card').hasClass('active') ) {
           element.closest('.card').removeClass('active');
       }else{
           element.closest('.card').addClass('active');
       }
    }
    
    // Replace img tas with background image for uniformity
    $('.sm-card-deck .card').each(function () {
        if ($(this).find('img')) {
            var img = $(this).find('img');
            if( img.parent().is('p') ) {
                img.unwrap();
            }
            var imgSrc = img.attr('src');
            img.replaceWith('<div class="card-bg-image" style="background-image: url(' + imgSrc + ');"></div>');
        }
    });
    
    /* ************************************************************ */
    /* FORMS FUNCTIONS */
    /* ************************************************************ */
    // Create custom minlength validation to make things backwards compatible - new js uses minlen
    bValidator.validators.minlength = function(value, amount){
        if(value.length >= amount) {
			return true;
        }else {
            return false;
        }
    }
    // Create custom maxlength validation to make things backwards compatible - new js uses maxlen
    bValidator.validators.maxlength = function(value, amount){
        if(value.length <= amount) {
			return true;
        }else {
            return false;
        }
    }
    // Settings/Options for bvalidator
    var options = {
        position: {x:'left', y:'top'},
        validClass: true,
        validateOn: 'keyup',
        useTheme: 'portfolio',
    }
    // Call bvalidator on forms with the class "wufoo"
    $('.wufoo').bValidator(options);
    
    $('.phone_us').mask('(000) 000-0000', {'translation': { A: { pattern: /[2-9*]/ } } } );
    $('.zip_us').mask('00000'); 

    // datepicker
    $('.form-date input').datepicker({
        //startDate: '-1d',
        startDate: 'today', //disable dates before today
        //daysOfWeekDisabled: '0', //disable Sundays
        //datesDisabled: ['12/25/2020','01/01/2021'], //disable holidays
    });

    // Schedule Toggle Switch    
    $('form .form-schedule').on( 'click', function() {
        var form = $(this).closest('form');
        form.find('.switch').toggleClass('toggled-switch', 1000 );
        form.find('.expanding-container').toggleClass('toggled-container', 1000 );
    });

    /* ************************************************************ */
    /* MMENU */
    /* ************************************************************ */
    new Mmenu( '#mmenu', {
        extensions: [
            "position-right", //menu location: position-left, position-right
            "position-front", //keeps sticky in place
            "border-full", //dividers full-width
            "fx-listitems-slide", //new fancy animate-in effect: slide, fade, drop
            "pagedim-black", //dim page when menu is open
            "fullscreen", //fullscreen menu
        ],
        navbars: [
            // {
            //     "position": "top",
            //     "content": [
            //         "<span>" + settings.company.name + "</span>", "close"
            //     ]
            // },
            {
                "position": "bottom",
                "content": [
                    "<a class='btn btn-primary' href='" + settings.company.quote + "'>Get a Quote</a>",
                ]
            }
        ],
    });
    
    $( "#mmenu li.dummy a.mm-next" ).each( function( index ) {
        var mobileurl = $( this ).attr('href');
        $( this ).next('a').attr('href',mobileurl);
    });
    
    /* ************************************************************ */
    /* ELEMENT ANIMATION */
    /* ************************************************************ */
    
    $('.to-animate').each(function() {
        //  Control offset per element by adding data-offset
        var customOffset = 100;
        if( $(this).data('offset') ) {
            customOffset = $(this).data('offset');
        }
        $(this).viewportChecker({
            classToAdd: 'visible animated',
            offset: customOffset,
            callbackFunction: function(elem, action){
            },
        });
    });

    /* ************************************************************ */
    /* SLICK CONFIGS */
    /* ************************************************************ */   
    $('.ds-section .slider-wrapper').each(function() {
        var slider = $(this);
        slider.slick({
            fade: true,
            autoplay: false,
            infinite: false,
            speed: 700,
            slidesToShow: 1,
            arrows: true,
            prevArrow: slider.find('.arrow-left'),
            nextArrow: slider.find('.arrow-right'),
            dots: true,
            appendDots: slider.find('.slider-dots'),
            customPaging: function(slider, i) {
                return '<span class="custom-dot"></span>';
            },
            slide: '.slide',
            rows: 0,
            mobileFirst: true,
            // responsive: [
            //     {
            //         breakpoint: 767,
            //         settings: {
            //             slidesToShow: 2,
            //         }
            //     },
            //     {
            //         breakpoint: 991,
            //         settings: {
            //             slidesToShow: 3,
            //         }
            //     },
            // ]
        });
    });
    
    $('.ds-section .slider-wrapper-equal').each(function() {
        var slider = $(this);
        slider.slick({
            fade: false,
            autoplay: false,
            infinite: true,
            speed: 700,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            prevArrow: slider.find('.arrow-left'),
            nextArrow: slider.find('.arrow-right'),
            dots: true,
            appendDots: slider.next('.slider-dots'),
            customPaging: function(slider, i) {
                return '<span class="custom-dot"></span>';
            },
            slide: '.slide',
            rows: 0,
            mobileFirst: true,
            responsive: [
                {
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 3,
                    }
                },
            ]
        });
    });

    // Recent Projects Sliders
    $(".project-images-slider").slick({
        asNavFor: ".project-text-slider",
        prevArrow: ".recent-projects .slider-buttons .slick-prev",
        nextArrow: ".recent-projects .slider-buttons .slick-next",
    });

    $(".project-text-slider").slick({
        asNavFor: ".project-images-slider",
        prevArrow: ".recent-projects .slider-buttons .slick-prev",
        nextArrow: ".recent-projects .slider-buttons .slick-next",
    });

    // Home Product Selector Slider
    $(".nav-tabs-slider").slick({
        arrows: false,
        asNavFor: ".prod-selector-slides",
        focusOnSelect: true,
        slidesToShow: 5
    });
    $(".prod-selector-slides").slick({
        arrows: false,
        asNavFor: ".nav-tabs-slider",
    });

    // Reviews Slider
    $(".reviews-image-slider").slick({
        arrows: false,
        asNavFor: ".reviews-text-column",
        slidesToShow: 1,
        dots: false,
        autoplay: true,
        autoplaySpeed: 6000,
    });

    $(".reviews-text-column").slick({
        arrows: false,
        asNavFor: ".reviews-image-slider",
        slidesToShow: 1,
        dots: false,
        autoplay: true,
        autoplaySpeed: 6000,
    });
    

    /* ************************************************************ */
    /* WEB ACCESSIBILITY */
    /* ************************************************************ */

    // Primary Nav accessibility tabbing
    $(".primary-nav a").focus(function () {
        $(this).parents("li").addClass("focus");
    });
    $(".primary-nav a").blur(function () {
        $(this).parents("li").removeClass("focus");
    });

    // Gallery Lightbox trigger + accessibility tabbing in Gallery Lightbox
    $('.custom-lightbox').on('click', function () {
        var mmenuElement = $('#mmenu');
        var mmPageElement = $('.mm-page');
        var mmWrapperBlockerElement = $('.mm-wrapper__blocker');

        setTimeout(function () {
            // Focus on modal/popup
            $('.lightbox-form-container.fancybox-is-open').focus();
            // Prevent Tabbing to outside modal/popup
            $(mmenuElement).on('focusin', function () {
                $('.lightbox-form.shown').focus();
            });
            $(mmPageElement).on('focusin', function () {
                $('.lightbox-form.shown').focus();
            });
            $(mmWrapperBlockerElement).on('focusin', function () {
                $('.lightbox-form.shown').focus();
            });
        }, 200);
    });

}); //End doc.ready



/* ************************************************************ */
/* VIEWPORT FUNCTION */
/* ************************************************************ */
function viewport() {
    var e = window, a = 'inner';
    if (!('innerWidth' in window )) {
        a = 'client';
        e = document.documentElement || document.body;
    }
    return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
}

function sample_function() {
    var vpWidth = viewport().width; //This should match media query
    if (vpWidth < 768) {
        //Do something
    } else {
        //Do something else
    }
}