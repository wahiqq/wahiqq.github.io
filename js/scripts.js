(function($) {
    "use strict";


	
	// BACK BUTTON RELOAD
    window.onpageshow = function (event) {
      if (event.persisted) {
        window.location.reload()
      }
    };
	
	
	
    function randomBetween(range) {
        var min = range[0],
            max = range[1];
        if (min < 0) {
            return min + Math.random() * (Math.abs(min)+max);
        }else {
            return min + Math.random() * max;
        }
    }
	
	
	
	
	/* TREE MENU */
(function ($) {
  $.fn.liHarmonica = function (params) {
    var p = $.extend({
      currentClass: 'cur', 
      onlyOne: true, 
      speed: 500 
    }, params);
    return this.each(function () {
      var
      el = $(this).addClass('harmonica'),
        linkItem = $('ul', el).prev('i');
      el.children(':last').addClass('last');
      $('ul', el).each(function () {
        $(this).children(':last').addClass('last');
      });
      $('ul', el).prev('i').addClass('harFull');
      el.find('.' + p.currentClass).parents('ul').show().prev('i').addClass(p.currentClass).addClass('harOpen');
      linkItem.on('click', function () {
        if ($(this).next('ul').is(':hidden')) {
          $(this).addClass('harOpen');
        } else {
          $(this).removeClass('harOpen');
        }
        if (p.onlyOne) {
          $(this).closest('ul').closest('ul').find('ul').not($(this).next('ul')).slideUp(p.speed).prev('i').removeClass('harOpen');
          $(this).next('ul').slideToggle(p.speed);
        } else {
          $(this).next('ul').stop(true).slideToggle(p.speed);
        }
        return false;
      });
    });
  };
})(jQuery);

$(function () {
  $('.hamburger-navigation ').liHarmonica({
    onlyOne: true,
    speed: 400
  });
});
	
	

    // BUTTONS AUDIO
    if( $('#hamburger').length !== 0 ) {

        if( data.enable_hamburger_menu_click_sound != false ) {
            document.getElementById("hamburger").addEventListener('click', function (e) {
                document.getElementById("link").play();
            });
        }
    }

  

    // EQUALIZER TOGGLE
    if( data.audio_source !== '' ) {
        var source = data.audio_source;
        var audio = new Audio(); // use the constructor in JavaScript, just easier that way
        audio.addEventListener("load", function() {
            audio.play();
        }, true);
        audio.src = source;
        audio.autoplay = true;
        audio.loop = true;
        audio.volume = 0.2;

        $('.equalizer').click();
        var playing = true;
        $('.equalizer').on('click', function(e) {
            if (playing == false) {
                audio.play();
                playing = true;

            } else {
                audio.pause();
                playing = false;
            }
        });

        // EQUALIZER

        $.fn.equalizerAnimation = function(speed, barsHeight){
            var $equalizer = $(this);
            setInterval(function(){
                $equalizer.find('span').each(function(i){
                    $(this).css({ height:randomBetween(barsHeight[i])+'px' });
                });
            },speed);
            $equalizer.on('click',function(){
                $equalizer.toggleClass('paused');
            });
        };

        var barsHeight = [
            [2, 10],
            [5, 14],
            [11, 8],
            [4, 18],
            [8, 3]
        ];
        $('.equalizer').equalizerAnimation(180, barsHeight);
    }

    // MOUSE MASK
    var $window = $(window);
    var windowWidth = $window.width();
    var windowHeight = $window.height();
    var mousePos = {x:windowWidth/2,y:windowHeight/2};

    $(window).resize(function(){
        windowWidth = $window.width();
        windowHeight = $window.height();
    });

    clip(mousePos);

    $(document).mousemove(function(e){
        mousePos = {x:e.pageX,y:e.pageY};
        clip(mousePos);
    });

    function clip(mousePos) {
        var pourcPos = {'x':mousePos.x * 100 / windowWidth * 2,
            'y':mousePos.y * 100 / windowHeight};
        var gapX = pourcPos.x * 30 / 200 - 15;
        var gapY = (15 *(pourcPos.y * 30 / 100 - 15)) / 100;
        var pointTop;
        var pointBottom;
        if (pourcPos.y<50) {
            pointTop = 150 - pourcPos.x + gapY * gapX;
            pointBottom = 150 - pourcPos.x;
        } else {
            pointTop = 150 - pourcPos.x;
            pointBottom = 150 - pourcPos.x - gapY * gapX;
        }
        if (pourcPos.x<100) {
            $('.split-back').addClass('on');
            $('.split-front').removeClass('on');
        }else if (pourcPos.x>100) {
            $('.split-back').removeClass('on');
            $('.split-front').addClass('on');
        } else {
            $('.split-back').add('.split-front').removeClass('on');
        }
        $('.split-front').css({'clip-path':'polygon('+pointTop+'% 0%, 100% 0%, 100% 100%, '+pointBottom+'% 100%)'});
    }

    // INT HERO FADE
    var divs = $('.int-hero .inner');
    $(window).on('scroll', function() {
        var st = $(this).scrollTop();
        divs.css({ 'opacity' : (1 - st/300) });
    });

    
    // DATA BACKGROUND IMAGE
    var pageSection = $(".bg-image");
    pageSection.each(function(indx){
        if ($(this).attr("data-background")){
            $(this).css("background-image", "url(" + $(this).data("background") + ")");
        }
    });

    // DATA BACKGROUND COLOR
    var pageSectionBg = $(".bg-color");
    pageSectionBg.each(function(indx){
        if ($(this).attr("data-background")){
            $(this).css("background-color", $(this).data("background"));
        }
    });


    // PAGE TRANSITION
    $('body a').on('click', function (e) {
      if ($('body').hasClass('no-transition')) {

      } else {
        var target = $(this).attr('target');
        var fancybox = $(this).data('fancybox');
        var url = this.getAttribute("href");
        if (target != '_blank' && typeof fancybox == 'undefined' && url.indexOf('#') < 0) {


          e.preventDefault();
          var url = this.getAttribute("href");
          if (url.indexOf('#') != -1) {
            var hash = url.substring(url.indexOf('#'));


            if ($('body ' + hash).length != 0) {
              $('.page-transition').removeClass("active");


            }
          } else {
            $('.page-transition').toggleClass("active");
            setTimeout(function () {
              window.location = url;
            }, 800);

          }
        }
      }
    });

    

    // SLIDER
    var swiper = new Swiper('.slider .swiper-container', {
				speed: 600,	
				parallax: true,
				loop: true,
					autoplay: {
					delay: 4500,
					disableOnInteraction: false,
				  },
				pagination: {
					el: '.swiper-pagination',
					type: 'fraction',
				  },
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
			});

    // WOW ANIMATION
    var wow = new WOW(
        {
            animateClass: 'animated',
            offset:       50
        }
    );
    wow.init();

    // MASONRY
    $(window).load(function(){

        $('.works').isotope({
            itemSelector: '.works li',
            percentPosition: true
        });

        $('.masonry-row').isotope({
            itemSelector: '.masonry-cols',
            percentPosition: true
        });

    });

    // ISOTOPE FILTER
    var $container = $('.works');
    $container.isotope({
        filter: '*',
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false
        }
    });

    $('.isotope-filter li span').on('click', function(e) {
        $('.isotope-filter li span.current').removeClass('current');
        $(this).addClass('current');

        var selector = $(this).attr('data-filter');
        $container.isotope({
            filter: selector,
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });
        return false;
    });
	
	
	
	// COUNTER
  $(document).scroll(function () {
    $('.odometer').each(function () {
      var parent_section_postion = $(this).closest('section').position();
      var parent_section_top = parent_section_postion.top;
      if ($(document).scrollTop() > parent_section_top - 300) {
        if ($(this).data('status') == 'yes') {
          $(this).html($(this).data('count'));
          $(this).data('status', 'no');
        }
      }
    });
  });
	
	
	

    $(window).load(function(){
        $("body").addClass("page-loaded");
    });

})(jQuery);