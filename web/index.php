
<!DOCTYPE HTML>
<html>
	<head>
		<title>OBEM | Home </title>
		<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/jquery.min.js"></script>
		 <!-- Custom Theme files -->
		<link href="css/style.css" rel='stylesheet' type='text/css' />
   		 <!-- Custom Theme files -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		</script>
		 <!---- start-smoth-scrolling---->
		<script type="text/javascript" src="js/move-top.js"></script>
		<script type="text/javascript" src="js/easing.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});
		</script>
		 <!---- start-smoth-scrolling---->
		<!----webfonts--->
		<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
		<!---//webfonts--->
		<!----start-top-nav-script---->
		<script>
			$(function() {
				var pull 		= $('#pull');
					menu 		= $('nav ul');
					menuHeight	= menu.height();
				$(pull).on('click', function(e) {
					e.preventDefault();
					menu.slideToggle();
				});
				$(window).resize(function(){
	        		var w = $(window).width();
	        		if(w > 320 && menu.is(':hidden')) {
	        			menu.removeAttr('style');
	        		}
	    		});
			});
		</script>
		<!----//End-top-nav-script---->
	</head>
	<body>
		<!----- start-header---->
			<div id="home" class="header">
					<div class="top-header">
						<div class="container">
						<div class="logo">
							<a href="#"><img src="images/logo.png" title="OBEM" /></a>
						</div>
						<!----start-top-nav---->
						 <nav class="top-nav">
							<ul class="top-nav">
								<li class="active"><a href="#home" class="scroll">Home </a></li>
								<li><a href="#services" class="scroll">Login</a></li>
							</ul>
							<a href="#" id="pull"><img src="images/menu-icon.png" title="menu" /></a>
						</nav>
						<div class="clearfix"> </div>
					</div>
				</div>
			</div>
		<!----- //End-header---->
		<!----start-slider-script---->
			<script src="js/responsiveslides.min.js"></script>
			 <script>
			    // You can also use "$(window).load(function() {"
			    $(function () {
			      // Slideshow 4
			      $("#slider4").responsiveSlides({
			        auto: true,
			        pager: true,
			        nav: true,
			        speed: 500,
			        namespace: "callbacks",
			        before: function () {
			          $('.events').append("<li>before event fired.</li>");
			        },
			        after: function () {
			          $('.events').append("<li>after event fired.</li>");
			        }
			      });
			
			    });
			  </script>
			<!----//End-slider-script---->
			<!-- Slideshow 4 -->
			    <div  id="top" class="callbacks_container">
			      <ul class="rslides" id="slider4">
			        <li>
			          <img src="images/slide1.jpg" alt="">
			          <div class="caption">
			          	<div class="slide-text-info">
			          		<h1>OBEM</h1>
			          		<label>OBESITY SECURED MONITORING SYSTEM</label>
			          	</div>
			          </div>
			        </li>
			        <li>
			          <img src="images/slide1.jpg" alt="">
			          <div class="caption">
			          	<div class="slide-text-info">
			          	<h1>OBEM</h1>
			          		<label>OBESITY SECURED MONITORING SYSTEM</label>
			          		<a class="slide-btn" href="#services" >Login</a>
			          	</div>
			          </div>
			        </li>
			      </ul>
			    </div>
			    <div class="clearfix"> </div>
			<!----- //End-slider---->
		

			<!--- services --->
			<div id="services" class="services">
				<div class="container">
					<div class="header services-header text-center">
						<h2>Login</h2>
						<p> Obesity Secured Monitoring System</p>
					</div>
					<!---- service-grids--->
					<div class="service-grids">
						<div class="col-md-4">
							<div class="service-grid text-center">
								<a href="hms/admin/"><span class="s1-icon"> </span></a>
								<h3><a href="hms/admin/">Admin Login</a></h3>
							</div>
						</div>
						<div class="col-md-4">
							<div class="service-grid text-center">
								<a href="hms/user-login.php"><span class="s2-icon"> </span></a>
								<h3><a href="hms/user-login.php">Nurse Login</a></h3>
							</div>
						</div>
						<div class="col-md-4">
							<div class="service-grid text-center">
								<a href="hms/doctor/"><span class="s4-icon"> </span></a>
								<h3><a href="hms/doctor/">Doctor Login</a></h3>
							</div>
						</div>
						<div class="clearfix"> </div>
					</div>
					<!----//service-grids--->
				</div>
				<!--    <div class="content-grids">
		    	<div class="wrap">
		    	<div class="section group">
								
							
				<div class="listview_1_of_3 images_1_of_3">
					<div class="listimg listimg_1_of_2">
						  <img src="images/grid-img3.png">
					</div>
					<div class="text list_1_of_2">
						  <h3>Nurses Login</h3>
						  <div class="button"><span><a href="hms/user-login.php">Click Here</a></span></div>
				    </div>
				</div>	

				<div class="listview_1_of_3 images_1_of_3">
					<div class="listimg listimg_1_of_2">
						  <img src="images/grid-img1.png">
					</div>
					<div class="text list_1_of_2">
						  <h3>Doctors Login</h3>
						
						  <div class="button"><span><a href="hms/doctor/">Click Here</a></span></div>
					</div>
				</div>


					<div class="listview_1_of_3 images_1_of_3">
					<div class="listimg listimg_1_of_2">
						  <img src="images/grid-img2.png">
					</div>
					<div class="text list_1_of_2">
						  <h3>Admin Login</h3>
						
						  <div class="button"><span><a href="hms/admin">Click Here</a></span></div>
				     </div>
				</div>			
			</div>
		    </div>
		   </div> -->
			</div>
			<!--- services --->
			<!--- team --->

			
			<!--- team --->
			<!---- contact ---->
			
			<!---- contact ---->
	
			<!--- copy-right ---->
			<div class="copy-right">
				<div class="container">
				<div class="copy-right-left">
					<p>OBEM 2020</a></p>
					<script type="text/javascript">
									$(document).ready(function() {
										/*
										var defaults = {
								  			containerID: 'toTop', // fading element id
											containerHoverID: 'toTopHover', // fading element hover id
											scrollSpeed: 1200,
											easingType: 'linear' 
								 		};
										*/
										
										$().UItoTop({ easingType: 'easeOutQuart' });
										
									});
								</script>
					<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
			
			<!--- copy-right ---->
	</body>
</html>

