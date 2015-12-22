$(window).load(function() {
	"use strict";
    /* ==============================================
    PRELOADER
    =============================================== */
    var preloaderDelay = 500;
    var preloaderFadeOutTime = 800;

    function hidePreloader() {
        var loadingAnimation = $('#loading-animation');
        var preloader = $('#preloader');

        loadingAnimation.fadeOut();
        preloader.delay(preloaderDelay).fadeOut(preloaderFadeOutTime, function() {
        	setTimeout(startPage, 1500);
         });
    }

    hidePreloader();
    
    function startPage() {
		$("#home-1").removeClass("fadeOut-1").addClass("fadeIn-1");
		setTimeout ( function () {
			$('.timer ul li').each(function( k ) {	
				var el = $(this);
				setTimeout ( function () {
					el.removeClass("fadeOut-2").addClass("fadeIn-2");
				},  k * 250 );	
			});
		},350 );
		setTimeout ( function () {
			$("#home .intro h2").removeClass("fadeOut-2").addClass("fadeIn-2");
		},700 );
		setTimeout ( function () {
			$(".menu").removeClass("fadeOut-3").addClass("fadeIn-3");
		},1500 );
		setTimeout ( function () {
			$('.menu li a').each(function( k ) {	
				var el = $(this);
				setTimeout ( function () {
					el.removeClass("fadeOut-2").addClass("fadeIn-2");
				},  k * 250 );	
			});
		},2000 );
		setTimeout ( function () {
			$(".footer-content").removeClass("fadeOut-2").addClass("fadeIn-2");
		},2300 );
		setTimeout ( function () {
			$(".footer-content h4").removeClass("fadeOut-2").addClass("fadeIn-2");
		},3300 );
		setTimeout ( function () {
			$('.footer-content .hi-icon').each(function( k ) {	
				var el = $(this);
				setTimeout ( function () {
					el.removeClass("fadeOut-1").addClass("fadeIn-1");
				},  k * 250 );	
			});
		},2500 );
	} /*  End animation section home  */

});

$(document).ready(function(){
	"use strict";
	
	/* ==============================================
    DIV's POSITION
    =============================================== */
	
	var windowHeight = $(window).height();
	var homePageHeight = $('#home').height();
	
	if (windowHeight >= homePageHeight){
		$('#home').css("padding-top", (((windowHeight-homePageHeight)/2)-20));
		$('#home').css("padding-bottom", (((windowHeight-homePageHeight)/2)-20));
	}

	$(window).resize(function() {		
		var windowHeight = $(window).height();
		var homePageHeight = $('#home').height();
		var aboutPageHeight = $('#about-content').height();
		var newsletterPageHeight = $('#newsletter-content').height();
		var contactPageHeight = $('#contact-content').height();

		if (windowHeight >= homePageHeight){
			$('#home').css("padding-top", ((windowHeight-homePageHeight)/2));
			$('#home').css("padding-bottom", ((windowHeight-homePageHeight)/2));
			$('#about-content').css("padding-top", ((windowHeight-aboutPageHeight)/2));
			$('#about-content').css("padding-bottom", ((windowHeight-aboutPageHeight)/2));
			$('#newsletter-content').css("padding-top", ((windowHeight-newsletterPageHeight)/2));
			$('#newsletter-content').css("padding-bottom", ((windowHeight-newsletterPageHeight)/2));
			$('#contact-content').css("padding-top", ((windowHeight-contactPageHeight)/2));
			$('#contact-content').css("padding-bottom", ((windowHeight-contactPageHeight)/2));
		}
	});
	
	/* ==============================================
    COUNTDOWN
    =============================================== */
	var now = new Date();
	var date = new Date($("#year").text(),$("#month").text(),$("#day").text(),$("#hour").text(),$("#minute").text(),$("#second").text()); // new Date( year , month , day , hour , minutes , seconds)
	var difference = date - now - (30*24*60*60*1000); //fix a gap of 30 days
	var countTo = difference + now.valueOf();
	$('.timer').countdown(countTo, function(event) {
		var $this = $(this);
		switch(event.type) {
			case "seconds":
			case "minutes":
			case "hours":
			case "days":
			case "weeks":
			case "daysLeft":
				//$this.find('span.'+event.type).html(event.value+' '+event.type);
				$this.find('h1.'+event.type).html(event.value);
				break;
			case "finished":
				$this.fadeOut();
				setTimeout ( function () { //if you want add a text
					$this.text("Ahora mismo volvemos!");
					$this.fadeIn();
				},1500 );
				break;
		}
		
	if ( ($('.days').html()) == 1 ){
		$('.daysText').text(" día ");
	}else{
		$('.daysText').text(" días ");
	}
	
	if ( ($('.hours').html()) == 1 ){
		$('.hoursText').text(" hora ");
	}else{
		$('.hoursText').text(" horas ");
	}
	
	if ( ($('.minutes').html()) == 1 ){
		$('.minutesText').text(" minuto ");
	}else{
		$('.minutesText').text(" minutos ");
	}
	
	if ( ($('.seconds').html()) == 1 ){
		$('.secondsText').text(" segundo ");
	}else{
		$('.secondsText').text(" segundos ");
	}
	
	});
	
    /* ==============================================
	/*	CONTACT FORM
	=============================================== */
	
    $('.success-message-2').hide();
    $('.error-message-2').hide();
    
	var $contactform 	= $('#contactform'),
		$success		= 'Tu mensaje se ha enviado. Gracias!';
		
	$contactform.submit(function(){
		$.ajax({
		   type: "POST",
		   url: "php/contact.php",
		   data: $(this).serialize(),
		   success: function(msg)
		   {
				if(msg.trim() == 'SEND'){
					$('.error-message-2').hide();
                    $('.success-message-2').hide();
                    $contactform.hide().delay(3000).fadeIn();
                    $('#contactform input').val('');
                    $('#contactform textarea').val('');
                    $('.success-message-2').html('<div class="success-message-2">'+ $success +'</div>');
                    $('.success-message-2').fadeIn().delay(2000).fadeOut();
				}
				else{
					$('.success-message-2').hide();
                    $('.error-message-2').hide();
                    $('.error-message-2').html('<div class="error-message-2">'+ msg +'</div>');
                    $('.error-message-2').fadeIn().delay(3000).fadeOut();
				}
			}
		 });
		return false;
	});	
	
	/* ==============================================
    /* GOOGLE MAPS
	================================================== */

	  var styles = [
	    {
	      stylers: [
	        { saturation: -100 }
	      ]
	    }
	  ];

	  // Create a new StyledMapType object, passing it the array of styles,
	  // as well as the name to be displayed on the map type control.
	  var styledMap = new google.maps.StyledMapType(styles,
	    {name: "Styled Map"});

	  // Create a map object, and include the MapTypeId to add
	  // to the map type control.
	  var mapOptions = {
	    zoom: 17,
	    scrollwheel: false,
	    center: new google.maps.LatLng(40.4693, -3.66597),
	    markers: [{
		  latitude: 40.4693, 
		  longitude: -3.66597
		}],
	    mapTypeControlOptions: {
	      mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
	    }
	  };
	  var map = new google.maps.Map(document.getElementById('map'), mapOptions);

	  //Associate the styled map with the MapTypeId and set it to display.
	  map.mapTypes.set('map_style', styledMap);
	  map.setMapTypeId('map_style');
	
	/* ==============================================
	TOOLTIPS
	=============================================== */
	
	$('.footer-content a').tooltip();
	
	/* ==============================================
	ANIMATIONS
	=============================================== */
	
	//setTimeout(startPage, 1500);
	
	/*  Start animation section home  */
	function startPage() {
		$("#home-1").removeClass("fadeOut-1").addClass("fadeIn-1");
		setTimeout ( function () {
			$('.timer ul li').each(function( k ) {	
				var el = $(this);
				setTimeout ( function () {
					el.removeClass("fadeOut-2").addClass("fadeIn-2");
				},  k * 250 );	
			});
		},350 );
		setTimeout ( function () {
			$("#home .intro h2").removeClass("fadeOut-2").addClass("fadeIn-2");
		},700 );
		setTimeout ( function () {
			$(".menu").removeClass("fadeOut-3").addClass("fadeIn-3");
		},1500 );
		setTimeout ( function () {
			$('.menu li a').each(function( k ) {	
				var el = $(this);
				setTimeout ( function () {
					el.removeClass("fadeOut-2").addClass("fadeIn-2");
				},  k * 250 );	
			});
		},2000 );
		setTimeout ( function () {
			$(".footer-content").removeClass("fadeOut-2").addClass("fadeIn-2");
		},2300 );
		setTimeout ( function () {
			$(".footer-content h4").removeClass("fadeOut-2").addClass("fadeIn-2");
		},3300 );
		setTimeout ( function () {
			$('.footer-content .hi-icon').each(function( k ) {	
				var el = $(this);
				setTimeout ( function () {
					el.removeClass("fadeOut-1").addClass("fadeIn-1");
				},  k * 250 );	
			});
		},2500 );
	} /*  End animation section home  */
	
	/*  Start animation section about  */
	$("#about").click(function() {
		$("footer").fadeOut("slow", function() {
			$("footer").addClass("footer-hide");
		});
		$("#home").fadeOut( "slow", function() {
			api.goTo(2);
			$("#about-content").attr( "style", "display: block" );
			var windowHeight = $(window).height();
			var aboutPageHeight = $('#about-content').height();
			if (windowHeight >= aboutPageHeight){
				$('#about-content').css("padding-top", ((windowHeight-aboutPageHeight)/2));
				$('#about-content').css("padding-bottom", ((windowHeight-aboutPageHeight)/2));
			}
			setTimeout ( function () {
				$("#about-content .close").removeClass("fadeOut-1").addClass("fadeIn-1");
			},1500 );
			setTimeout ( function () {
				$(".about-title h1").removeClass("fadeOut-2").addClass("fadeIn-2");
			},2000 );
			setTimeout ( function () {
				$(".about-text").removeClass("fadeOut-2").addClass("fadeIn-2");
			},2500 );
			
			$("#home-1").removeClass("fadeIn-1").addClass("fadeOut-1");
			$('.timer ul li').removeClass("fadeIn-2").addClass("fadeOut-2");
			$("#home .intro h2").removeClass("fadeIn-2").addClass("fadeOut-2");
			$(".menu").removeClass("fadeIn-3").addClass("fadeOut-3");
			$('.menu li a').removeClass("fadeIn-2").addClass("fadeOut-2");
			$(".footer-content").removeClass("fadeIn-2").addClass("fadeOut-2");
			$(".footer-content h4").removeClass("fadeIn-2").addClass("fadeOut-2");
			$('.footer-content .hi-icon').removeClass("fadeIn-1").addClass("fadeOut-1");
			
		});
	}); /*  END animation section about  */
	
	
	/*  START animation back to home from about  */
	$("#close1").click(function() {
		$("#about-content").fadeOut("slow", function() {
			api.goTo(1);
			$("#home").attr( "style", "display: block" );
			$("footer").removeClass("footer-hide");
			var windowHeight = $(window).height();
			var homePageHeight = $('#home').height();			
			if (windowHeight >= homePageHeight){
				$('#home').css("padding-top", ((windowHeight-homePageHeight)/2));
				$('#home').css("padding-bottom", ((windowHeight-homePageHeight)/2));
			}
			$("#about-content .close").removeClass("fadeIn-1").addClass("fadeOut-1");
			$(".about-title h1").removeClass("fadeIn-2").addClass("fadeOut-2");
			$(".about-text").removeClass("fadeIn-2").addClass("fadeOut-2");
			setTimeout(startPage, 500);
		});
	}); /*  END animation back to home from about  */
	
	
	/*  START animation section newsletter  */
	$("#newsletter").click(function() {
		$("footer").fadeOut("slow", function() {
			$("footer").addClass("footer-hide");
		});
		$("#home").fadeOut( "slow", function() {
			api.goTo(3);
			$("#newsletter-content").attr( "style", "display: block" );
			var windowHeight = $(window).height();
			var newsletterPageHeight = $('#newsletter-content').height();
			if (windowHeight >= newsletterPageHeight){
				$('#newsletter-content').css("padding-top", ((windowHeight-newsletterPageHeight)/2));
				$('#newsletter-content').css("padding-bottom", ((windowHeight-newsletterPageHeight)/2));
			}
			setTimeout ( function () {
				$("#newsletter-content .close").removeClass("fadeOut-1").addClass("fadeIn-1");
			},1500 );
			setTimeout ( function () {
				$(".newsletter-title h1").removeClass("fadeOut-2").addClass("fadeIn-2");
			},2000 );
			setTimeout ( function () {
				$("#newsletter-content .intro h2").removeClass("fadeOut-2").addClass("fadeIn-2");
			},2500 );
			setTimeout ( function () {
				$("#newsletter-content form").removeClass("fadeOut-2").addClass("fadeIn-2");
			},3000 );
			
			$("#home-1").removeClass("fadeIn-1").addClass("fadeOut-1");
			$('.timer ul li').removeClass("fadeIn-2").addClass("fadeOut-2");
			$("#home .intro h2").removeClass("fadeIn-2").addClass("fadeOut-2");
			$(".menu").removeClass("fadeIn-3").addClass("fadeOut-3");
			$('.menu li a').removeClass("fadeIn-2").addClass("fadeOut-2");
			$(".footer-content").removeClass("fadeIn-2").addClass("fadeOut-2");
			$(".footer-content h4").removeClass("fadeIn-2").addClass("fadeOut-2");
			$('.footer-content .hi-icon').removeClass("fadeIn-1").addClass("fadeOut-1");
			
		});
	});
	/*  END animation section newsletter  */
	
	
	/*  START animation back to home from newsletter  */
	$("#close2").click(function() {
		$("#newsletter-content").fadeOut("slow", function() {
			api.goTo(1);
			$("#home").attr( "style", "display: block" );
			$("footer").removeClass("footer-hide");
			var windowHeight = $(window).height();
			var homePageHeight = $('#home').height();		
			if (windowHeight >= homePageHeight){
				$('#home').css("padding-top", ((windowHeight-homePageHeight)/2));
				$('#home').css("padding-bottom", ((windowHeight-homePageHeight)/2));
			}
			$("#newsletter-content .close").removeClass("fadeIn-1").addClass("fadeOut-1");
			$(".newsletter-title h1").removeClass("fadeIn-2").addClass("fadeOut-2");
			$("#newsletter-content .intro h2").removeClass("fadeIn-2").addClass("fadeOut-2");
			$("#newsletter-content form").removeClass("fadeIn-2").addClass("fadeOut-2");
			setTimeout(startPage, 500);
		});
	}); /*  END animation back to home from newsletter  */
	
	
	/*  START animation section contact  */
	$("#contact").click(function() {
		$("footer").fadeOut("slow", function() {
			$("footer").addClass("footer-hide");
		});
		$("#home").fadeOut( "slow", function() {
			$("#contact-content").attr( "style", "display: block" );
			var windowHeight = $(window).height();
			var contactPageHeight = $('#contact-content').height();
			if (windowHeight >= contactPageHeight){
				$('#contact-content').css("padding-top", ((windowHeight-contactPageHeight)/2));
				$('#contact-content').css("padding-bottom", ((windowHeight-contactPageHeight)/2));
			}
			setTimeout ( function () {
				$('#map').animate({ opacity: 1 });
				$('.back-color').animate({ opacity: 0.8 });
			},750 );
			setTimeout ( function () {
				$("#contact-content .close").removeClass("fadeOut-1").addClass("fadeIn-1");
			},1500 );
			setTimeout ( function () {
				$(".contact-title h1").removeClass("fadeOut-2").addClass("fadeIn-2");
			},2000 );
			setTimeout ( function () {
				$(".address p").removeClass("fadeOut-2").addClass("fadeIn-2");
			},2500 );
			setTimeout ( function () {
				$("#contact-content form").removeClass("fadeOut-2").addClass("fadeIn-2");
			},3000 );
			
			$("#home-1").removeClass("fadeIn-1").addClass("fadeOut-1");
			$('.timer ul li').removeClass("fadeIn-2").addClass("fadeOut-2");
			$("#home .intro h2").removeClass("fadeIn-2").addClass("fadeOut-2");
			$(".menu").removeClass("fadeIn-3").addClass("fadeOut-3");
			$('.menu li a').removeClass("fadeIn-2").addClass("fadeOut-2");
			$(".footer-content").removeClass("fadeIn-2").addClass("fadeOut-2");
			$(".footer-content h4").removeClass("fadeIn-2").addClass("fadeOut-2");
			$('.footer-content .hi-icon').removeClass("fadeIn-1").addClass("fadeOut-1");
			
		});
	});
	/*  END animation section contact  */
	
	
	/*  START animation back to home from contact  */
	$("#close3").click(function() {
		$("#contact-content").fadeOut("slow", function() {
			$("#home").attr( "style", "display: block" );
			$("footer").removeClass("footer-hide");
			var windowHeight = $(window).height();
			var homePageHeight = $('#home').height();		
			if (windowHeight >= homePageHeight){
				$('#home').css("padding-top", ((windowHeight-homePageHeight)/2));
				$('#home').css("padding-bottom", ((windowHeight-homePageHeight)/2));
			}
			$("#contact-content .close").removeClass("fadeIn-1").addClass("fadeOut-1");
			$(".contact-title h1").removeClass("fadeIn-2").addClass("fadeOut-2");
			$(".address p").removeClass("fadeIn-2").addClass("fadeOut-2");
			$("#contact-content form").removeClass("fadeIn-2").addClass("fadeOut-2");
			setTimeout ( function () {
				$('#map').animate({ opacity: 0 });
				$('.back-color').animate({ opacity: 0.65 });
			},500 );
			setTimeout(startPage, 750);
		});
	}); /*  END animation back to home from contact  */
	
});