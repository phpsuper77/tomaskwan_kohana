<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>GYMHIT | Connect. It’s Free to Use.</title>
		<meta name="title" content="Connect. It’s Free to Use." />
		<meta name="description" content="#" />
		<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=no">
		<link type="text/css" href="http://cloud.typography.com/6633554/633126/css/fonts.css" rel="stylesheet" />
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="/resources/home2/css/animate.css">
		<link rel="stylesheet" type="text/css" href="/resources/home2/css/style.css">
		<link rel="stylesheet" type="text/css" href="/resources/home2/css/misc.css">
		<link rel="stylesheet" type="text/css" href="/resources/home2/css/login.css">
   <link href="<?= MCSS;?>datepicker3.css" rel="stylesheet" type="text/css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-65778726-1', 'auto');
            ga('send', 'pageview');

        </script>
<!-- start Mixpanel -->
<script type="text/javascript">
(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:"file:"===e.location.protocol&&"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f)}})(document,window.mixpanel||[]);
mixpanel.init("<?= Kohana::$config->load('site.mixpanel.token') ?>");
</script>
<!-- end Mixpanel -->
	</head>
	<body>
        <?=$loginModal;?>
        <?=$registerModal;?>
		<div class="wrapper">
			<div class="main">
				<section class="page1">
					<div class="row">
						<div class="col-xs-12 text-center"><a href="#"><img class="logo" src="/resources/home2/img/logo.svg"></a></div>
					</div>
					<div class="row">
						<div class="col-xs-10"></div>
						<div class="col-xs-2"><a href="#" class="btn btn-success btn-lg" data-toggle="modal" data-target="#loginBox">Sign In</a></div>
					</div>
					<div class="row">
						<div class="col-xs-12 text-center">
							<h1 class="screen1-h1">Get GymHit. <br class="visible-xs">Connect.
							<br class="visible-xs">It’s Free to Use.</h1>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<a href="#" data-toggle="modal" data-target="#registerModal" class="action-btn wow zoomIn">SIGN UP NOW</a>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 text-center">
							<a href="#" style="opacity:0;" class="play-btn" data-toggle="modal" data-target="#videoModal" data-theVideo="http://www.youtube.com/embed/loFtozxZG0s"><i class="fa fa-play-circle play-btn"></i><span class="play-label">Watch How GymHit Works</span></a>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 text-center">
							<div class="city-wrapper">
								<img id="city" class="city center-block img-responsive  wow zoomIn" src="/resources/home2/img/gymhit_city_web_800px.png" alt="GymHit City">
							</div>
						</div>
					</div>
				</section>
				<section class="page2">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h1 class="screen2-h1">Discover the GymHit Network.</h1>
							</div>
						</div>
						<div class="row search-boxes">
							<div class="container">
								<div class="col-xs-12 col-md-4 mb-3em wow slideInLeft">
									<a href="http://gymhit.thomaskwan.com/search/index">
										<div class="bg-cover main-image img-responsive" style="background-image: url('/resources/home2/img/healthclub.jpg');">
											<div class="my-overlay">
											</div>
											<span class="overlay-top">Click To Find</span>
											<span class="overlay-bottom">HEALTH CLUBS</span>
										</div></a>
									</div>
									<div class="col-xs-12 col-md-4 mb-3em wow zoomIn">
										<a href="http://gymhit.thomaskwan.com/search/index">
											<div class="bg-cover main-image img-responsive" style="background-image: url('/resources/home2/img/studio.jpg');">
												<div class="my-overlay">
												</div>
												<span class="overlay-top">Click To Find</span>
												<span class="overlay-bottom">STUDIOS</span>
											</div></a>
										</div>
										<div class="col-xs-12 col-md-4 mb-3em wow slideInRight">
											<a href="http://gymhit.thomaskwan.com/search/index">
												<div class="bg-cover main-image img-responsive" style="background-image: url('/resources/home2/img/trainer.jpg');">
													<div class="my-overlay">
													</div>
													<span class="overlay-top">Click To Find</span>
													<span class="overlay-bottom">PERSONAL TRAINERS</span>
												</div></a>
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>
					</div>
					<footer>
						<div class="container">
							<div class="col-xs-12 col-md-3">
								<ul>
									<li>
										<a href="/static/about_us">About GYMHIT</a>
									</li>
									<li>
										<a href="/static/terms_of_use">Terms Of Use</a>
									</li>
									<li>
										<a href="/static/privacy">Privacy Policy</a>
									</li>
									<li>
										<a href="/static/dmca">DMCA</a>
									</li>
								</ul>
							</div>
							<div class="col-xs-12 col-md-3">
								<ul>
									<li>
										<a href="/static/contact_us">Contact Us</a>
									</li>
									<li>
										<a href="/search/index">Search</a>
									</li>
								</ul>
							</div>
							<div class="col-xs-12 col-md-3">
								<ul>
									<li>
										<a href="/search/index">Find a Trainer</a>
									</li>
									<li>
										<a href="/search/index">Find a Gym</a>
									</li>
									<li>
										<a href="/search/index">Log In</a>
									</li>
								</ul>
							</div>
							<div class="col-xs-12 col-md-3">
								<ul>
									<li>
										<a href="/search/index">BUSINESS SIGN UP</a>
									</li>
									<li>
										<a href="/search/index">WELLNESS SIGN UP</a>
									</li>
									<li>
										<a href="/search/index">INDIVIDUAL SIGN UP</a>
									</li>
								</ul>
							</div>
							<div class="col-xs-12 text-center">
								<div class="copyrights">
									Copyright &copy; 2014  <span class="green">GYM</span>HIT Inc.
								</div>
							</div>
						</div>
					</footer>

					<!-- SIGNUP Modal  ******   REPLACE WITH OUR  SINGUP MODAL ********  -->

								<div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								  <div class="modal-dialog" role="document">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								      </div>
								      <div class="modal-body">
								        *** SIGNUP FORM GOES HERE ***
								      </div>
								      <div class="modal-footer">
								        ...
								      </div>
								    </div>
								  </div>
								</div>

					<!-- END SINGUP MODAL // ALL CSS STYLES SHOULD WORK FROM GYMHIT // I'VE USED STANDARD BOOTSTRAP WINDOW-->

					<!-- <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<div>
										<iframe width="100%" height="350" src="#"></iframe>
									</div>
								</div>
							</div>
						</div>
					</div> -->
					<!-- Latest compiled and minified JavaScript -->
					<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
					<script src="/resources/home2/js/wow.min.js" type="text/javascript"></script>
	                <script src="/resources/metronic/js/jquery.validate.min.js" type="text/javascript"></script>
            <script src="<?=MJS;?>additional-methods.js"></script>
                    <script src="<?=MJS;?>bootstrap-datepicker.js" type="text/javascript"></script>
		            <script src="/resources/home2/js/login.js"></script>
		            <script src="/resources/home2/js/misc.js"></script>
					<script>
              new WOW().init();
              </script>
            <script>
                window.fbAsyncInit = function() {
                    FB.init({
                        appId      : '<?=Kohana::$config->load('site.fb.app-id')?>',
                        cookie     : true,  // enable cookies to allow the server to access
                        // the session
                        xfbml      : true,  // parse social plugins on this page
                        version    : 'v2.2' // use version 2.2
                    });

                    // Now that we've initialized the JavaScript SDK, we call
                    // FB.getLoginStatus().  This function gets the state of the
                    // person visiting this page and can return one of three states to
                    // the callback you provide.  They can be:
                    //
                    // 1. Logged into your app ('connected')
                    // 2. Logged into Facebook, but not your app ('not_authorized')
                    // 3. Not logged into Facebook and can't tell if they are logged into
                    //    your app or not.
                    //
                    // These three cases are handled in the callback function.
                };

                // Load the SDK asynchronously
                (function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_US/sdk.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));

            </script>
            <script>
                jQuery(document).ready(function() {
                    Login.init();
                });
            </script>
				</body>
			</html>
