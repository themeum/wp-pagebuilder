jQuery(document).ready(function($){ 'use strict';
    // Toggle Close & Open Toolbox
    $(document).on('click', '.wppb-edit-show-hide .wppb-edit-show-toggle', function(event){
        event.preventDefault();
        jQuery("body").toggleClass("wppb-pagetoops-editor-hide");
    });

    //Animated Number
    $.fn.wppbanimateNumbers = function(stop, commas, duration, ease) {
        return this.each(function() {
            var $this = $(this);
            var start = parseInt($this.text().replace(/,/g, ""));
            commas = (commas === undefined) ? true : commas;
            $({value: start}).animate({value: stop}, {
                duration: duration === undefined ? 1000 : duration,
                easing: ease === undefined ? "swing" : ease,
                step: function() {
                    $this.text(Math.floor(this.value));
                    if (commas) { $this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")); }
                },
                complete: function() {
                    if (parseInt($this.text()) !== stop) {
                        $this.text(stop);
                        if (commas){ $this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")); }
                    }
                }
            });
        });
    }

    $(document).on('rendered_addon', function(e, addon){
        let iframe = window.frames['wppb-builder-view'].window.document;
        if (typeof addon.type !== 'undefined' && ( addon.type === 'addon' || addon.type === 'inner_addon' ) && ( addon.name === 'wppb_animated_number')){
            // let counterContainer = $( iframe ).find('.wppb-counter-number');
            $( iframe ).find('.wppb-counter-number').each(function() {
                var $this = $(this);
                $this.wppbanimateNumbers( $this.data('digit'), false, $this.data('duration'), 'swing' );
                $this.unbind('inview');
            });
        }

        $( iframe ).find( '.wppb-pie-chart' ).each(function() {
            let $this = $(this);
            $this.easyPieChart({
                barColor: $this.data('barcolor'),
                trackColor: $this.data('trackcolor'),
                scaleColor: false,
                lineWidth: $this.data('width'),
                size: $this.data('size'),
                onStep: function (from, to, percent) {
                    $this.find('.wppb-chart-percent > span').text(Math.round(percent) + '%');
                }
            });
        });
    });

    // Animated Number
    $(document).on( 'inview', '.wppb-counter-number', function (event, visible, visiblePartX, visiblePartY) {
        var $this = $(this);
        if (visible) {
            $this.wppbanimateNumbers($this.data('digit'), false, $this.data('duration'), 'swing');
            $this.unbind('inview');
        }
    });

    // Pie Chart Inview
    $(document).on( 'inview', '.wppb-pie-chart', function (event, visible, visiblePartX, visiblePartY) {
        var $this = $(this);
        if ($this.easyPieChart) {
            if (visible) {
                $this.easyPieChart({
                    barColor: $this.data('barcolor'),
                    trackColor: $this.data('trackcolor'),
                    scaleColor: false,
                    lineWidth: $this.data('width'),
                    size: $this.data('size'),
                    onStep: function (from, to, percent) {
                        $this.find('.wppb-chart-percent > span').text(Math.round(percent) + '%');
                    }
                });
                $this.unbind('inview');
            }
        }
    });

    // Image Popup & Video PopUp
    if( typeof $( document ).magnificPopup !== 'undefined' ){
      $('.wppb-video-popup').magnificPopup({
          type: 'iframe',
          rtl: true,
          mainClass: 'mfp-fade',
          removalDelay: 300,
          preloader: false,
          fixedContentPos: false
      });
      $('.wppb-image-popup').magnificPopup({
          type: 'image',
          closeOnContentClick: true,
          mainClass: 'mfp-img-mobile',
          image: { verticalFit: true },
          gallery: { enabled: true }
      });
    }

    // Accordion (Done)
    $(document).on('click', '.wppb-accordion-title', function(){
        let $items = $(this).closest('.wppb-accordion-items').find('>div');
        let $handlers = $items.find('.wppb-accordion-title');
        let $panels = $items.find('.wppb-panel-collapse');
        if( $(this).hasClass('active') ) {
            $(this).removeClass('active');
            $panels.slideUp();
        } else {
            $handlers.removeClass('active');
            $panels.slideUp();
            $(this).addClass('active').next().slideDown();
        }
    });

    // Tab
    $(document).on('click', 'ul.wppb-tab-nav .wppb-tab-nav-list', function(){
        $(this).closest('ul').find('li').removeClass('active');
        $(this).closest('.wppb-tab-addon-content').find('.wppb-tab-content-wrap').find('.wppb-tab-content').removeClass('active');
        $(this).addClass('active');
        $( "#"+$(this).attr('data-tab') ).addClass('active');
    });

    // Testimonial & Person Carousel Backend
    $(document).on('rendered_addon', function(e, addon){
        if (typeof addon.type !== 'undefined' && ( addon.type === 'addon' || addon.type === 'inner_addon' ) && ( addon.name === 'wppb_testimonial_carousel' || addon.name === 'wppb_person_carousel' )){
            let Container = '';
            let iframe = window.frames['wppb-builder-view'].window.document;
            if( addon.name == 'wppb_person_carousel' ){ Container = $( iframe ).find('.wppb-person-content-carousel'); }
            if( addon.name == 'wppb_testimonial_carousel' ){ Container = $( iframe ).find('.wppb-testimonial-content-carousel'); }
            if( Container.length > 0 ){
                slickSliderCallback( Container.data('autoplay'), Container.data('speed'), Container.data('showdots'), Container.data('shownav'), Container.data('col'), Container, 'backend' );
            }
        }
    });

    // Testimonial & Person Carousel Frontend
    let testimonial = $('.wppb-testimonial-content-carousel');
    let person      = $('.wppb-person-content-carousel');
    if( testimonial.length > 0 ){
        slickSliderCallback( testimonial.data('autoplay'), testimonial.data('speed'), testimonial.data('showdots'), testimonial.data('shownav'), testimonial.data('col'), testimonial, 'frontend' );
    }
    if( person.length > 0 ){
        slickSliderCallback( person.data('autoplay'), person.data('speed') ,person.data('showdots'), person.data('shownav'), person.data('col'), person, 'frontend' );
    }
    function slickSliderCallback( auto,speed, dot, nav, col, Container, type ){
        let argument = {
            autoplay: auto,
            dots: dot,
            arrows: nav,
            speed: speed,
            slidesToShow: col,
            slidesToScroll: col,
            responsive: [
                { breakpoint: 1024, settings: { slidesToShow: col, slidesToScroll: col } },
                { breakpoint: 850, settings: { slidesToShow: 1, slidesToScroll: 1 } },
                { breakpoint: 600, settings: { slidesToShow: 1, slidesToScroll: 1 } }
            ]
        };
        if( nav == true ){
            argument.nextArrow = '<span class="wppb-carousel-prev"><i class="fas fa-angle-right"></i></span>';
            argument.prevArrow = '<span class="wppb-carousel-next"><i class="fas fa-angle-left"></i></span>';
        }
        if( type == 'backend' ){
            Container.not('.slick-initialized').slick(argument);
            Container.each(function(){
                if (!$(this).hasClass('slick-initialized')){
                    $(this).slick();
                }
            });
        }
        if( type == 'frontend' ){
            Container.slick(argument);
        }
    }


    // Alert Addons Close
    $(document).on('click','.wppb-close-alert', function(){
        $(this).closest('.wppb-alert-addon').fadeOut(200);
    });


    // Flip Box Addons
    $(document).on('click', '.wppb-flip-box-content.flipon-click .wppb-flipbox-panel, .threeD_style.flipon-click .threeD-content-wrap', function () {
        $(this).toggleClass('flip');
    });
    $(document).on('mouseenter', '.wppb-flip-box-content.flipon-hover .wppb-flipbox-panel, .threeD_style.flipon-hover .threeD-content-wrap', function () {
        $(this).addClass('flip');
    });
    $(document).on('mouseleave', '.wppb-flip-box-content.flipon-hover .wppb-flipbox-panel, .threeD_style.flipon-hover .threeD-content-wrap', function () {
        $(this).removeClass('flip');
    });


    // Widget Live Change
    let widget_live_change = function(){
        let formOperation = {
            init : function(){
                this.fire_live_change();
            },
            fire_live_change : function(){
                $(document).on('widget-added', function(){
                    $('.wppb-form-widget').on('change', function(){
                        let wppb_form_widget = $('.wppb-form-widget');
                        let widgetFormInput = wppb_form_widget.closest('form').serializeArray();
                        if (wppb_form_widget.length) {
                            let widgetFormData          = {};
                            let id_base                 = wppb_form_widget.find('[name="id_base"]').val();
                            let widget_input_base_name  = jQuery('[name="widget_input_base_name"]').val();
                            let wppb_widget_id          = wppb_form_widget.find('[name="widget-id"]').val();
                            wppb_widget_id              = parseInt(wppb_widget_id.replace('widget-', ''));

                            if( widgetFormInput.length ){
                                __.forEach(widgetFormInput, function (input, index) {
                                    let input_name              = input.name.replace(widget_input_base_name, '');
                                    input_name                  = input_name.replace('[', '').replace(']', '');
                                    widgetFormData[input_name]  = input.value;
                                });
                                widgetFormData['wppb_widget_id']        = wppb_widget_id;
                                widgetFormData['wppb_widget_id_base']   = id_base;
                                widgetFormData['addon_type']            = 'widget';
                            }
                            $.ajax({
                                type: 'POST',
                                url: page_data.ajaxurl,
                                dataType: 'json',
                                data: {
                                    action: 'wppb_render_widget',
                                    widget: {settings: widgetFormData, id: wppb_widget_id},
                                },
                                success: function (response) {
                                    $("#wppb-builder-view").contents().find("body").find(('#wppb-addon-'+wppb_widget_id)).html(response.data.html);
                                }
                            });
                        }
                    });
                });
            }
        };
        return formOperation;
    };
    widget_live_change().init();

});


/* ! WOW - v1.0.1 - 2014-08-15
 * Copyright (c) 2014 Matthieu Aussaguel; Licensed MIT */
;(function() {
    var a, b, c, d = function(a, b) {
            return function() {
                return a.apply(b, arguments)
            }
        },
        e = [].indexOf || function(a) {
            for (var b = 0, c = this.length; c > b; b++)
                if (b in this && this[b] === a) return b;
            return -1
        };
    b = function() {
        function a() {}
        return a.prototype.extend = function(a, b) {
            var c, d;
            for (c in b) d = b[c], null == a[c] && (a[c] = d);
            return a
        }, a.prototype.isMobile = function(a) {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(a)
        }, a
    }(), c = this.WeakMap || this.MozWeakMap || (c = function() {
        function a() {
            this.keys = [], this.values = []
        }
        return a.prototype.get = function(a) {
            var b, c, d, e, f;
            for (f = this.keys, b = d = 0, e = f.length; e > d; b = ++d)
                if (c = f[b], c === a) return this.values[b]
        }, a.prototype.set = function(a, b) {
            var c, d, e, f, g;
            for (g = this.keys, c = e = 0, f = g.length; f > e; c = ++e)
                if (d = g[c], d === a) return void(this.values[c] = b);
            return this.keys.push(a), this.values.push(b)
        }, a
    }()), a = this.MutationObserver || this.WebkitMutationObserver || this.MozMutationObserver || (a = function() {
        function a() {
            console.warn("MutationObserver is not supported by your browser."), console.warn("WOW.js cannot detect dom mutations, please call .sync() after loading new content.")
        }
        return a.notSupported = !0, a.prototype.observe = function() {}, a
    }()), this.WPPBWOW = function() {
        function f(a) {
            null == a && (a = {}), this.scrollCallback = d(this.scrollCallback, this), this.scrollHandler = d(this.scrollHandler, this), this.start = d(this.start, this), this.scrolled = !0, this.config = this.util().extend(a, this.defaults), this.animationNameCache = new c
        }
        return f.prototype.defaults = {
            boxClass: "wppb-wow",
            animateClass: "wppb-animated",
            offset: 0,
            mobile: !0,
            live: !0
        }, f.prototype.init = function() {
            var a;
            return this.element = window.document.documentElement, "interactive" === (a = document.readyState) || "complete" === a ? this.start() : document.addEventListener("DOMContentLoaded", this.start), this.finished = []
        }, f.prototype.start = function() {
            var b, c, d, e;
            if (this.stopped = !1, this.boxes = function() {
                var a, c, d, e;
                for (d = this.element.querySelectorAll("." + this.config.boxClass), e = [], a = 0, c = d.length; c > a; a++) b = d[a], e.push(b);
                return e
            }.call(this), this.all = function() {
                var a, c, d, e;
                for (d = this.boxes, e = [], a = 0, c = d.length; c > a; a++) b = d[a], e.push(b);
                return e
            }.call(this), this.boxes.length);
                if (this.disabled()) this.resetStyle();
                else {
                    for (e = this.boxes, c = 0, d = e.length; d > c; c++) b = e[c], this.applyStyle(b, !0);
                    window.addEventListener("scroll", this.scrollHandler, !1), window.addEventListener("resize", this.scrollHandler, !1), this.interval = setInterval(this.scrollCallback, 50)
                }
            return this.config.live ? new a(function(a) {
                return function(b) {
                    var c, d, e, f, g;
                    for (g = [], e = 0, f = b.length; f > e; e++) d = b[e], g.push(function() {
                        var a, b, e, f;
                        for (e = d.addedNodes || [], f = [], a = 0, b = e.length; b > a; a++) c = e[a], f.push(this.doSync(c));
                        return f
                    }.call(a));
                    return g
                }
            }(this)).observe(document.body, {
                childList: !0,
                subtree: !0
            }) : void 0
        }, f.prototype.stop = function() {
            return this.stopped = !0, window.removeEventListener("scroll", this.scrollHandler, !1), window.removeEventListener("resize", this.scrollHandler, !1), null != this.interval ? clearInterval(this.interval) : void 0
        }, f.prototype.sync = function() {
            return a.notSupported ? this.doSync(this.element) : void 0
        }, f.prototype.doSync = function(a) {
            var b, c, d, f, g;
            if (!this.stopped) {
                if (null == a && (a = this.element), 1 !== a.nodeType) return;
                for (a = a.parentNode || a, f = a.querySelectorAll("." + this.config.boxClass), g = [], c = 0, d = f.length; d > c; c++) b = f[c], e.call(this.all, b) < 0 ? (this.applyStyle(b, !0), this.boxes.push(b), this.all.push(b), g.push(this.scrolled = !0)) : g.push(void 0);
                return g
            }
        }, f.prototype.show = function(a) {
            return this.applyStyle(a), a.className = "" + a.className + " " + this.config.animateClass
        }, f.prototype.applyStyle = function(a, b) {
            var c, d, e;
            return d = a.getAttribute("data-wow-duration"), c = a.getAttribute("data-wow-delay"), e = a.getAttribute("data-wow-iteration"), this.animate(function(f) {
                return function() {
                    return f.customStyle(a, b, d, c, e)
                }
            }(this))
        }, f.prototype.animate = function() {
            return "requestAnimationFrame" in window ? function(a) {
                return window.requestAnimationFrame(a)
            } : function(a) {
                return a()
            }
        }(), f.prototype.resetStyle = function() {
            var a, b, c, d, e;
            for (d = this.boxes, e = [], b = 0, c = d.length; c > b; b++) a = d[b], e.push(a.setAttribute("style", "visibility: visible;"));
            return e
        }, f.prototype.customStyle = function(a, b, c, d, e) {
            return b && this.cacheAnimationName(a), a.style.visibility = b ? "hidden" : "visible", c && this.vendorSet(a.style, {
                animationDuration: c
            }), d && this.vendorSet(a.style, {
                animationDelay: d
            }), e && this.vendorSet(a.style, {
                animationIterationCount: e
            }), this.vendorSet(a.style, {
                animationName: b ? "none" : this.cachedAnimationName(a)
            }), a
        }, f.prototype.vendors = ["moz", "webkit"], f.prototype.vendorSet = function(a, b) {
            var c, d, e, f;
            f = [];
            for (c in b) d = b[c], a["" + c] = d, f.push(function() {
                var b, f, g, h;
                for (g = this.vendors, h = [], b = 0, f = g.length; f > b; b++) e = g[b], h.push(a["" + e + c.charAt(0).toUpperCase() + c.substr(1)] = d);
                return h
            }.call(this));
            return f
        }, f.prototype.vendorCSS = function(a, b) {
            var c, d, e, f, g, h;
            for (d = window.getComputedStyle(a), c = d.getPropertyCSSValue(b), h = this.vendors, f = 0, g = h.length; g > f; f++) e = h[f], c = c || d.getPropertyCSSValue("-" + e + "-" + b);
            return c
        }, f.prototype.animationName = function(a) {
            var b;
            try {
                b = this.vendorCSS(a, "animation-name").cssText
            } catch (c) {
                b = window.getComputedStyle(a).getPropertyValue("animation-name")
            }
            return "none" === b ? "" : b
        }, f.prototype.cacheAnimationName = function(a) {
            return this.animationNameCache.set(a, this.animationName(a))
        }, f.prototype.cachedAnimationName = function(a) {
            return this.animationNameCache.get(a)
        }, f.prototype.scrollHandler = function() {
            return this.scrolled = !0
        }, f.prototype.scrollCallback = function() {
            var a;
            return !this.scrolled || (this.scrolled = !1, this.boxes = function() {
                var b, c, d, e;
                for (d = this.boxes, e = [], b = 0, c = d.length; c > b; b++) a = d[b], a && (this.isVisible(a) ? this.show(a) : e.push(a));
                return e
            }.call(this), this.boxes.length || this.config.live) ? void 0 : this.stop()
        }, f.prototype.offsetTop = function(a) {
            for (var b; void 0 === a.offsetTop;) a = a.parentNode;
            for (b = a.offsetTop; a = a.offsetParent;) b += a.offsetTop;
            return b
        }, f.prototype.isVisible = function(a) {
            var b, c, d, e, f;
            return c = a.getAttribute("data-wow-offset") || this.config.offset, f = window.pageYOffset, e = f + Math.min(this.element.clientHeight, innerHeight) - c, d = this.offsetTop(a), b = d + a.clientHeight, e >= d && b >= f
        }, f.prototype.util = function() {
            return null != this._util ? this._util : this._util = new b
        }, f.prototype.disabled = function() {
            return !this.config.mobile && this.util().isMobile(navigator.userAgent)
        }, f
    }()
}).call(this);

//Initiat WOW JS
jQuery(function($){
   new WPPBWOW().init();
});