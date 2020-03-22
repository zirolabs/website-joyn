/**
* Template Name: Avilon - v2.0.0
* Template URL: https://bootstrapmade.com/avilon-bootstrap-landing-page-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/
!(function($) {
  "use strict";

  // Header fixed and Back to top button
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('.back-to-top').fadeIn('slow');
      $('#header').addClass('header-fixed');
    } else {
      $('.back-to-top').fadeOut('slow');
      $('#header').removeClass('header-fixed');
    }
  });

  if ($(this).scrollTop() > 100) {
    $('.back-to-top').fadeIn('slow');
    $('#header').addClass('header-fixed');
  }

  $('.back-to-top').click(function() {
    $('html, body').animate({
      scrollTop: 0
    }, 1500, 'easeInOutExpo');
    return false;
  });

  // Initiate the wowjs animation library
  new WOW().init();

  // Initiate superfish on nav menu
  $('.nav-menu').superfish({
    animation: {
      opacity: 'show'
    },
    speed: 400
  });

  // Mobile Navigation
  if ($('#nav-menu-container').length) {
    var $mobile_nav = $('#nav-menu-container').clone().prop({
      id: 'mobile-nav'
    });
    $mobile_nav.find('> ul').attr({
      'class': '',
      'id': ''
    });
    $('body').append($mobile_nav);
    $('body').prepend('<button type="button" id="mobile-nav-toggle"><i class="fa fa-bars"></i></button>');
    $('body').append('<div id="mobile-body-overly"></div>');
    $('#mobile-nav').find('.menu-has-children').prepend('<i class="fa fa-chevron-down"></i>');

    $(document).on('click', '.menu-has-children i', function(e) {
      $(this).next().toggleClass('menu-item-active');
      $(this).nextAll('ul').eq(0).slideToggle();
      $(this).toggleClass("fa-chevron-up fa-chevron-down");
    });

    $(document).on('click', '#mobile-nav-toggle', function(e) {
      $('body').toggleClass('mobile-nav-active');
      $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
      $('#mobile-body-overly').toggle();
    });

    $(document).click(function(e) {
      var container = $("#mobile-nav, #mobile-nav-toggle");
      if (!container.is(e.target) && container.has(e.target).length === 0) {
        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
          $('#mobile-body-overly').fadeOut();
        }
      }
    });
  } else if ($("#mobile-nav, #mobile-nav-toggle").length) {
    $("#mobile-nav, #mobile-nav-toggle").hide();
  }

  // Smoth scroll on page hash links
  $('.nav-menu a, #mobile-nav a, .scrollto').on('click', function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      if (target.length) {
        var top_space = 0;

        if ($('#header').length) {
          top_space = $('#header').outerHeight();

          if (!$('#header').hasClass('header-fixed')) {
            top_space = top_space - 20;
          }
        }

        $('html, body').animate({
          scrollTop: target.offset().top - top_space
        }, 1500, 'easeInOutExpo');

        if ($(this).parents('.nav-menu').length) {
          $('.nav-menu .menu-active').removeClass('menu-active');
          $(this).closest('li').addClass('menu-active');
        }

        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
          $('#mobile-body-overly').fadeOut();
        }
        return false;
      }
    }
  });

  // Initiate venobox (lightbox feature used in portofilo)
  $(document).ready(function() {
    $('.venobox').venobox();
  });

//remove no-js class
    removeClass(document.getElementsByTagName("html")[0], "no-js"); 

    //Hero Slider - by CodyHouse.co
  function HeroSlider( element ) {
    this.element = element;
    this.navigation = this.element.getElementsByClassName("js-cd-nav")[0];
    this.navigationItems = this.navigation.getElementsByTagName('li');
    this.marker = this.navigation.getElementsByClassName("js-cd-marker")[0];
    this.slides = this.element.getElementsByClassName("js-cd-slide");
    this.slidesNumber = this.slides.length;
    this.newSlideIndex = 0;
    this.oldSlideIndex = 0;
    this.autoplay = hasClass(this.element, "js-cd-autoplay");
    this.autoPlayId;
    this.autoPlayDelay = 5000;
    this.init();
  };

  HeroSlider.prototype.init = function() {
    var self = this;
    //upload video (if not on mobile devices)
    this.uploadVideo();
    //autoplay slider
    this.setAutoplay();
    //listen for the click event on the slider navigation
    this.navigation.addEventListener('click', function(event){
      if( event.target.tagName.toLowerCase() == 'div' )
        return;
      event.preventDefault();
      var selectedSlide = event.target;
      if( hasClass(event.target.parentElement, 'cd-selected') )
        return;
      self.oldSlideIndex = self.newSlideIndex;
      self.newSlideIndex = Array.prototype.indexOf.call(self.navigationItems, event.target.parentElement);
      self.newSlide();
      self.updateNavigationMarker();
      self.updateSliderNavigation();
      self.setAutoplay();
    });

    if(this.autoplay) {
      // on hover - pause autoplay
      this.element.addEventListener("mouseenter", function(){
        clearInterval(self.autoPlayId);
      });
      this.element.addEventListener("mouseleave", function(){
        self.setAutoplay();
      });
    }
  };

  HeroSlider.prototype.uploadVideo = function() {
    var videoSlides = this.element.getElementsByClassName("js-cd-bg-video");
    for( var i = 0; i < videoSlides.length; i++) {
      if( videoSlides[i].offsetHeight > 0 ) {
        // if visible - we are not on a mobile device 
        var videoUrl = videoSlides[i].getAttribute("data-video");
        videoSlides[i].innerHTML = "<video loop><source src='"+videoUrl+".mp4' type='video/mp4' /><source src='"+videoUrl+".webm' type='video/webm'/></video>";
        // if the visible slide has a video - play it
        if( hasClass(videoSlides[i].parentElement, "cd-hero__slide--selected") ) videoSlides[i].getElementsByTagName("video")[0].play();
      }
    }
  };

  HeroSlider.prototype.setAutoplay = function() {
    var self = this;
    if(this.autoplay) {
      clearInterval(self.autoPlayId);
      self.autoPlayId = window.setInterval(function(){self.autoplaySlider()}, self.autoPlayDelay);
    }
  };

  HeroSlider.prototype.autoplaySlider = function() {
    this.oldSlideIndex = this.newSlideIndex;
    var self = this;
    if( this.newSlideIndex < this.slidesNumber - 1) {
      this.newSlideIndex +=1;
      this.newSlide();
      
    } else {
      this.newSlideIndex = 0;
      this.newSlide();
    }

    this.updateNavigationMarker();
    this.updateSliderNavigation();
  };

  HeroSlider.prototype.newSlide = function(direction) {
    var self = this;
    removeClass(this.slides[this.oldSlideIndex], "cd-hero__slide--selected cd-hero__slide--from-left cd-hero__slide--from-right");
    addClass(this.slides[this.oldSlideIndex], "cd-hero__slide--is-moving");
    setTimeout(function(){removeClass(self.slides[self.oldSlideIndex], "cd-hero__slide--is-moving");}, 500);

    for(var i=0; i < this.slidesNumber; i++) {
      if( i < this.newSlideIndex && this.oldSlideIndex < this.newSlideIndex) {
        addClass(this.slides[i], "cd-hero__slide--move-left");
      } else if( i == this.newSlideIndex && this.oldSlideIndex < this.newSlideIndex) {
        addClass(this.slides[i], "cd-hero__slide--selected cd-hero__slide--from-right");
      } else if(i == this.newSlideIndex && this.oldSlideIndex > this.newSlideIndex) {
        addClass(this.slides[i], "cd-hero__slide--selected cd-hero__slide--from-left");
        removeClass(this.slides[i], "cd-hero__slide--move-left");
      } else if( i > this.newSlideIndex && this.oldSlideIndex > this.newSlideIndex ) {
        removeClass(this.slides[i], "cd-hero__slide--move-left");
      }
    }

    this.checkVideo();

  };

  HeroSlider.prototype.updateNavigationMarker = function() {
    removeClassPrefix(this.marker, 'item');
    addClass(this.marker, "cd-hero__marker--item-"+ (Number(this.newSlideIndex) + 1));
  };

  HeroSlider.prototype.updateSliderNavigation = function() {
    removeClass(this.navigationItems[this.oldSlideIndex], 'cd-selected');
    addClass(this.navigationItems[this.newSlideIndex], 'cd-selected');
  };

  HeroSlider.prototype.checkVideo = function() {
    //check if a video outside the viewport is playing - if yes, pause it
    var hiddenVideo = this.slides[this.oldSlideIndex].getElementsByTagName('video');
    if( hiddenVideo.length ) hiddenVideo[0].pause();

    //check if the select slide contains a video element - if yes, play the video
    var visibleVideo = this.slides[this.newSlideIndex].getElementsByTagName('video');
    if( visibleVideo.length ) visibleVideo[0].play();
  };

  var heroSliders = document.getElementsByClassName("js-cd-hero");
  if( heroSliders.length > 0 ) {
    for( var i = 0; i < heroSliders.length; i++) {
      (function(i){
        new HeroSlider(heroSliders[i])
      })(i);
    }
  }

  //on mobile - open/close primary navigation clicking/tapping the menu icon 
  document.getElementsByClassName('js-cd-header__nav')[0].addEventListener('click', function(event){
    if(event.target.tagName.toLowerCase() == 'nav') {
      classie.toggleClass(this.getElementsByTagName('ul')[0], 'cd-is-visible');
    }
  });

  function removeClassPrefix(el, prefix) {
    //remove all classes starting with 'prefix'
        var classes = el.className.split(" ").filter(function(c) {
            return c.indexOf(prefix) < 0;
        });
        el.className = classes.join(" ");
  };

  //class manipulations - needed if classList is not supported
  function hasClass(el, className) {
      if (el.classList) return el.classList.contains(className);
      else return !!el.className.match(new RegExp('(\\s|^)' + className + '(\\s|$)'));
  }
  function addClass(el, className) {
    var classList = className.split(' ');
    if (el.classList) el.classList.add(classList[0]);
    else if (!hasClass(el, classList[0])) el.className += " " + classList[0];
    if (classList.length > 1) addClass(el, classList.slice(1).join(' '));
  }
  function removeClass(el, className) {
    var classList = className.split(' ');
      if (el.classList) el.classList.remove(classList[0]);  
      else if(hasClass(el, classList[0])) {
        var reg = new RegExp('(\\s|^)' + classList[0] + '(\\s|$)');
        el.className=el.className.replace(reg, ' ');
      }
      if (classList.length > 1) removeClass(el, classList.slice(1).join(' '));

})(jQuery);