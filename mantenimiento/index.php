<?php
	require_once '../config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  
  	<!-- ==============================================
	Title and basic Meta Tags
	=============================================== -->
    <title>Innova - Digital Solutions</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
	
	<!-- ==============================================
	Mobile Metas
	=============================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		
    <!-- ==============================================
	CSS
	=============================================== -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css" type="text/css" media="screen"  />
    <link rel="stylesheet" href="css/supersized.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/supersized.shutter.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/metrize.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    <!--[if lte IE 8]>
		  <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
		<![endif]-->

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
	
    <!-- ==============================================
	Fonts
	=============================================== -->
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Bevan' rel='stylesheet' type='text/css'>
	
	<!-- ==============================================
	JS
	=============================================== -->
	<script type="text/javascript" src="js/modernizr.js"></script>
	<script type="text/javascript" src="js/device.min.js"></script>
	
    <!-- ==============================================
	Favicons
	=============================================== -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/favicon/apple-touch-icon-144-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/favicon/apple-touch-icon-114-precomposed.html">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/favicon/apple-touch-icon-72-precomposed.html">
                    <link rel="apple-touch-icon-precomposed" href="img/favicon/apple-touch-icon-57-precomposed.html">
                                   <link rel="shortcut icon" href="img/favicon/favicon.png">

  <body>
  
  	<!-- ==============================================
	Preloader
	=============================================== -->
	<div id="preloader">
    	<div id="loading-animation">&nbsp;</div>
	</div> <!-- End Preloader -->
	
	<!-- ==============================================
	Background color
	=============================================== -->
	<div class="back-color"></div>
	
	<!-- ==============================================
	Home
	=============================================== -->
	<section id="home">
		<div class="container">
		    <div class="row twitter-list">
			    <div class="col-md-3 col-md-offset-9 col-sm-6">
			    	<div id="home-1" class="fadeOut-1">
			    		<ul id="twitter-feed" class="list-tweets"></ul>
			    	</div>
				</div>
			</div>	
			<div class="row">			   
			    <div class="col-md-8">
			    	<div class="timer">
			    		<!--googleoff: index-->
				    		<span style="display:none" id="year"  ><?=$maintenance['year']?></span>
				    		<span style="display:none" id="month" ><?=$maintenance['month']?></span>
				    		<span style="display:none" id="day"   ><?=$maintenance['day']?></span>
				    		<span style="display:none" id="hour"  ><?=$maintenance['hour']?></span>
				    		<span style="display:none" id="minute"><?=$maintenance['minute']?></span>
				    		<span style="display:none" id="second"><?=$maintenance['second']?></span>
				    	<!--googleon: index -->
				    	<ul>
				    		<li class="fadeOut-2"><h1 class="days"></h1><p class="daysText">Días</p></li>
				    		<li class="fadeOut-2"><h1 class="hours"></h1><p class="hoursText">Horas</p></li>
				    		<li class="fadeOut-2"><h1 class="minutes"></h1><p class="minutesText">Minutos</p></li>
				    		<li class="fadeOut-2"><h1 class="seconds"></h1><p class="secondsText">Segundos</p></li>
				    	</ul> 
					</div>
			    </div>
			</div>
			<div class="row">	
			    <div class="col-md-5 col-md-offset-1 intro">
			    	<h2 class="fadeOut-2"><?=$maintenance['message']?></h2>
			    </div>
			</div>
			<div class="row">
				<div class="col-md-2 col-md-offset-1">	    	
			    	<ul class="menu fadeOut-3">
				    	<li><a id="about" class="fadeOut-2" href="javascript:;" title="About"><span class="menu-back"></span>Sobre nosotros</a></li>
				    	<li class="last"><a id="contact" class="fadeOut-2" href="javascript:;" title="Contact"><span class="menu-back"></span>Contacto</a></li>
				    </ul>
			    </div>
		    </div>
		    <div class="row visible-xs">
		    	<div class="col-md-3 col-md-offset-7 footer-content footer-xs fadeOut-4">
    				<h4 class="fadeOut-2"><?=$maintenance['company']?> <span>&#64;Copyright <?=date('Y')?></span></h4>
    				<a href="<?=$maintenance['facebook_url']?>" class="hi-icon icon-social-facebook fadeOut-1" title="Facebook" aria-hidden="true" data-gal="tooltip" data-placement="top" data-original-title="Facebook"></a>
    				<a href="<?=$maintenance['twitter_url']?>" class="hi-icon icon-social-twitter fadeOut-1" title="Twitter" aria-hidden="true" data-gal="tooltip" data-placement="top" data-original-title="Twitter"></a>
    				<a href="<?=$maintenance['gplus_url']?>" class="hi-icon icon-social-google-plus fadeOut-1" title="Google Plus" aria-hidden="true" data-gal="tooltip" data-placement="top" data-original-title="Google Plus"></a>
    				<a href="<?=$maintenance['pinterest_url']?>" class="hi-icon icon-social-pinterest fadeOut-1" title="Pinterest" aria-hidden="true" data-gal="tooltip" data-placement="top" data-original-title="Pinterest"></a>
    				<a href="<?=$maintenance['youtube_url']?>" class="hi-icon icon-social-youtube fadeOut-1" title="Youtube" aria-hidden="true" data-gal="tooltip" data-placement="top" data-original-title="Youtube"></a>
    				<a href="<?=$maintenance['linkedin_url']?>" class="hi-icon icon-social-linkedin fadeOut-1" title="Linkedin" aria-hidden="true" data-gal="tooltip" data-placement="top" data-original-title="Linkedin"></a>
    			</div>
    		</div>
		</div>
	</section>
	
	<!-- ==============================================
	Footer
	=============================================== -->
	
	<footer class="hidden-xs">
		<div class="container">
    		<div class="row">
    			<div class="col-md-3 col-md-offset-7 footer-content fadeOut-2">
    				<h4 class="fadeOut-2"><?=$maintenance['company']?> <span>&#64;Copyright <?=date('Y')?></span></h4>
    				<a href="<?=$maintenance['facebook_url']?>" class="hi-icon icon-social-facebook fadeOut-1" title="Facebook" aria-hidden="true" data-gal="tooltip" data-placement="top" data-original-title="Facebook"></a>
    				<a href="<?=$maintenance['twitter_url']?>" class="hi-icon icon-social-twitter fadeOut-1" title="Twitter" aria-hidden="true" data-gal="tooltip" data-placement="top" data-original-title="Twitter"></a>
    				<a href="<?=$maintenance['gplus_url']?>" class="hi-icon icon-social-google-plus fadeOut-1" title="Google Plus" aria-hidden="true" data-gal="tooltip" data-placement="top" data-original-title="Google Plus"></a>
    				<a href="<?=$maintenance['pinterest_url']?>" class="hi-icon icon-social-pinterest fadeOut-1" title="Pinterest" aria-hidden="true" data-gal="tooltip" data-placement="top" data-original-title="Pinterest"></a>
    				<a href="<?=$maintenance['youtube_url']?>" class="hi-icon icon-social-youtube fadeOut-1" title="Youtube" aria-hidden="true" data-gal="tooltip" data-placement="top" data-original-title="Youtube"></a>
    				<a href="<?=$maintenance['linkedin_url']?>" class="hi-icon icon-social-linkedin fadeOut-1" title="Linkedin" aria-hidden="true" data-gal="tooltip" data-placement="top" data-original-title="Linkedin"></a>
    			</div>
    		</div>
    	</div>
    </footer>
	
	<!-- ==============================================
	About
	=============================================== -->
	<section id="about-content">
		<div class="container">
		    <div class="row">
			    <div class="col-md-2 col-md-offset-10">
			    	<div>
			    		<p><a id="close1" class="close fadeOut-1" href="javascript:;" title="Close"><img src="img/close.png" alt="Close"/></a></p>
			    	</div>
				</div>
			</div>	
			<div class="row">			   
			    <div class="col-md-7 about-title">
				    <h1 class="fadeOut-2">Sobre nosotros</h1>
			    </div>
			</div>
			<div class="row">	
			    <div class="col-md-5 col-md-offset-1">
			    	<p class="about-text fadeOut-2">
			    	<em><?=$maintenance['about_header']?></em><br/><br/>
						<?=$maintenance['about_text']?>
			    	</p>
			    </div>
			</div>
		</div>
	</section>
	
	<!-- ==============================================
	Contact
	=============================================== -->
	<div id="map"></div>
  	<section id="contact-content">
		<div class="container">
		    <div class="row">
			    <div class="col-md-2 col-md-offset-10">
			    	<div>
			    		<p><a id="close3" class="close fadeOut-1" href="javascript:;" title="Close"><img src="img/close.png" alt="Close"/></a></p>
			    	</div>
				</div>
			</div>	
			<div class="row">			   
			    <div class="col-md-7 contact-title">
				    <h1 class="fadeOut-2">Contacto</h1>
			    </div>
			</div>
			<div class="row">	
			    <div class="col-md-7 col-md-offset-1 address">
			    	<p class="fadeOut-2"><?=$maintenance['address']?><br/>
					Tel: (+34) <?=$maintenance['telephone']?>  &#183; <a href="mailto:<?=$maintenance['email']?>" title="Email Contacto"><?=$maintenance['email']?></a></p>
			    </div>
			</div>
			<div class="row">	
			    <div class="col-md-5 col-md-offset-1">
			    	<form class="fadeOut-2" action="#" id="contactform">
                		<input type="text" name="name" placeholder="Nombre">
						<input type="text" name="email" placeholder="Email">
						<textarea name="message" cols="35" rows="5" placeholder="Mensaje"></textarea>
						<br/>
						<button class="button" type="submit" value="Send">Enviar</button>
					</form>
					<div class="success-message-2"></div>
            		<div class="error-message-2"></div> 
			    </div>
			</div>
		</div>
	</section>
  	
  	
 	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/supersized.3.2.7.min.js"></script>
	<script type="text/javascript" src="js/supersized.shutter.min.js"></script>
	<script type="text/javascript" src="js/jquery.countdown.js"></script>
	<script type="text/javascript" src="js/twitterfeed.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="js/jquery.gmap.min.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
    <script type="text/javascript" src="js/images.js"></script>

    
  </body>
</html>