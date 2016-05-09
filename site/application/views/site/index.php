<?php defined('SYSPATH') or die('No direct script access.'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name='viewport' content='width=1170'>
        <title>GYMHIT</title>
        <meta name="author" content="gymhit.com" />
        <meta name="description" content="" />
        <link rel="image_src" href="<?= IMG;?>logo_fb.jpg" />
        <meta property="og:image" content="<?= IMG;?>logo_fb.jpg" />
        <meta property="og:url" content="http://gymhit.com" />
        <meta property="og:title" content="GYMHIT" />
        <meta property="og:description" content="" />
        <meta name="keywords" content="" />
        <meta name="robots" content="indeks, follow" />
        <link rel="shortcut icon" type="image/x-icon" href="<?= IMG;?>favicon.gif" />
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link href="//cloud.typography.com/6633554/633126/css/fonts.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?= CSS;?>bootstrap.css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href='<?= R;?>fullcalendar-2.4.0/fullcalendar.css' rel='stylesheet' />
        <link href="<?= MCSS;?>select2.css" rel="stylesheet" type="text/css"/>
        <link href="<?= MCSS;?>login-soft.css" rel="stylesheet" type="text/css"/>
        <link href="<?= MCSS;?>simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME STYLES -->
        <link href="<?= MCSS;?>components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
        <link href="<?= MCSS;?>plugins.css" rel="stylesheet" type="text/css"/>
        <link href="<?= MCSS;?>layout.css" rel="stylesheet" type="text/css"/>
        <link href="<?= MCSS;?>light.css" rel="stylesheet" type="text/css"/>
        <link href="<?= MCSS;?>custom.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= CSS;?>fonts.css">
        <link rel="stylesheet" href="<?= CSS;?>font-icons.css" />
        <!-- PROFILE & MESSAGE & SPEC. OFFER -->
        <link href="<?= MCSS;?>profile.css" rel="stylesheet" type="text/css"/>
        <link href="<?= MCSS;?>tasks.css" rel="stylesheet" type="text/css"/>
        <link href="<?= MCSS;?>bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
        <link href="<?= CSS;?>tooltipster.css" rel="stylesheet" type="text/css"/>
        <link href="<?= CSS;?>tooltipster-themes/tooltipster-shadow.css" rel="stylesheet" type="text/css"/>
        <link href="<?= MCSS;?>inbox.css" rel="stylesheet" type="text/css"/>
        <link href="<?= MCSS;?>jquery.Jcrop.min.css" rel="stylesheet"/>
        <!-- PAGE -->
        <link href="<?= CSS;?>bootstrap-slider.css" rel="stylesheet" type="text/css" />
        <!-- GALLERY -->
        <link href="<?= MCSS;?>jquery.fancybox.css" rel="stylesheet" type="text/css" />
        <link href="<?= MCSS;?>blueimp-gallery.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= MCSS;?>jquery.fileupload.css" rel="stylesheet" type="text/css" />
        <link href="<?= MCSS;?>jquery.fileupload-ui.css" rel="stylesheet" type="text/css" />
        <!-- CLASS & SPEC OFFER-->
        <link href="<?= MCSS;?>bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= MCSS;?>datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- CLASS & PROFILE -->
        <link rel="stylesheet" type="text/css" href="<?= MCSS;?>multi-select.css"/>
        <!-- OUR -->
        <link href="<?= CSS;?>style.css?v=<?= Kohana::$config->load('version.release') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= CSS;?>gymhit.css?v=<?= Kohana::$config->load('version.release') ?>" rel="stylesheet" type="text/css"/>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
        <script src="<?=JS; ?>jquery-1.11.1.min.js" type="text/javascript"></script> 
        <script src="<?=JS; ?>bootstrap.js" type="text/javascript"></script>
        <script src="<?=JS; ?>jquery.tooltipster.min.js" type="text/javascript"></script> 
        <script type="text/javascript">var switchTo5x=true;</script>
        <script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
        <script src="<?=JS; ?>jqueryui/jquery-ui.min.js" type="text/javascript"></script>
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
<script type="text/javascript">
<? if ($loginUserObj) { ?>
var loginUserId = '<?= $loginUserObj->getId(); ?>';
<? } else { ?>
var loginUserId = '';
<? } ?>
</script>
    </head>
    <body>
        <!-- Modal -->
        <?=$genericModal;?>
        <?=$loginModal;?>
        <?=$registerModal;?>
        <?=$reviewModal;?>
        <?= $messageModal;?>
        <section id="wrapper">
        <header class="container" id="header">
        <div id="home_header"> <a href="<?= PATH;?>" class="back-to-home" id="logo"></a>
            <form id="search-form" action="/search/users">
                <div class="input-group">
                    <input type="text" name="name" placeholder="search user by name" class="user_list form-control" autocomplete="off" />
                    <input type="hidden" name="role" value="4" />
                    <input type="hidden" name="send" value="ok" />
                    <span class="input-group-addon"> <i class="fa fa-search"></i></span>
                </div>
            </form>
            <div role="navigation" class="navbar my-navbar navbar-default" style="float:right;">
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav tk-proxima-nova-soft">
                        <!--
                        <li class="menu-item"><a href="javascript: void(0);" class="back-to-home" id="home-buttom">FEATURES</a></li>
                        -->
                        <? if(!Auth::instance()->logged_in_user()): ?>
                        <li class="menu-item"><a href="#" class="special-menu-button" data-toggle="modal" data-target="#loginBox">LOG IN</a></li>
                        <li class="menu-item"><a href="#" class="special-menu-button" data-toggle="modal" data-target="#registerModal">SIGN UP</a></li>
                        <? endif;?>
                    </ul>
                </div>
            </div>
        </div>
        </header>
        <section id="main">
        <?= $buttons;?>
        <?= $userBar;?>
        <div class="clearfix"></div>
        <? if($sidebar):?>
        <div class="page-container">
            <?= $sidebar;?>
            <? endif;?>
            <?= $content;?>
            </section>
            <footer>
            <div class="container">
                <div class="col-xs-3"> <span class="footer-head-menu"><?=__('About')?></span>
                    <ul>
                        <li> <a href="<?=PATH;?>static/about_us"><?=__('About Us')?></a> </li>
                        <li> <a href="<?=PATH;?>static/dmca"><?=__('DMCA')?></a> </li>
                        <li> <a href="<?=PATH;?>static/terms_of_use"><?=__('Terms of use')?></a> </li>
                        <li> <a href="<?=PATH;?>static/privacy"><?=__('Privacy')?></a> </li>
                        <li> <a href="<?=PATH;?>static/contact_us"><?=__('Contact Us')?></a> </li>
                    </ul>
                </div>
                <div class="col-xs-3"> <span class="footer-head-menu">Join Us</span>
                    <ul>
                        <li> <a href=""><?=__('Facebook')?></a> </li>
                        <li> <a href=""><?=__('Twitter')?></a> </li>
                        <li> <a href=""><?=__('Instagram')?></a> </li>
                    </ul>
                </div>
                <div class="col-xs-3"> <span class="footer-head-menu">Popular Specialities</span>
                    <ul>
                        <? if(count($specSearchs)>0):?>
                        <? foreach($specSearchs as $specSearch):?>
                        <li><a href="<?=PATH;?>directory/index?title=<?=$specSearch['speciality'];?>&send=ok"><?=$specSearch['speciality'];?></a></li>
                        <? endforeach;?>
                        <? endif;?>
                    </ul>
                </div>
                <div class="col-xs-3"> <span class="footer-head-menu">Popular Searches</span>
                    <ul>
                        <? if(count($citySearchs)>0):?>
                        <? foreach($citySearchs as $citySearch):?>
                        <li><a href="<?=PATH;?>directory/index?city=<?=$citySearch['city'];?>&title=<?=$citySearch['speciality'];?>&send=ok"><?=$citySearch['speciality'];?>, <?=$citySearch['city'];?></a></li>
                        <? endforeach;?>
                        <? endif;?>
                    </ul>
                </div>
                <div class="col-xs-12 text-center">
                    <div class="copyrights"> Copyrights 2015 <span class="green">GYM</span>HIT </div>
                </div>
            </div>
            </footer>
            </section>
            <script src="<?=JS;?>infobox.js" type="text/javascript"></script>
            <script src="<?=MJS;?>jquery-migrate.min.js" type="text/javascript"></script> 
            <script src="<?=MJS;?>jquery.blockui.min.js" type="text/javascript"></script> 
            <script src="<?=MJS;?>jquery.uniform.min.js" type="text/javascript"></script> 
            <script src="<?=MJS;?>jquery.cokie.min.js" type="text/javascript"></script>
            <script src="<?=MJS;?>jquery.slimscroll.min.js" type="text/javascript"></script>
            <!-- END CORE PLUGINS --> 
            <!-- BEGIN PAGE LEVEL PLUGINS --> 
            <script src="<?=MJS;?>jquery.validate.min.js" type="text/javascript"></script>
            <script src="<?=MJS;?>additional-methods.js"></script>
            <script src="<?=MJS;?>metronic.js" type="text/javascript"></script> 
            <script src="<?=MJS;?>layout.js" type="text/javascript"></script>
            <script src="<?=MJS;?>login-soft.js" type="text/javascript"></script>  
            <!-- PAGE -->
            <script src="<?=JS;?>bootstrap-slider.js"></script>
            <!-- PROFILE & SPEC. OFFER -->
            <script type="text/javascript" src="<?=MJS;?>jquery.Jcrop.min.js"></script>
            <!-- PAGE & PROFILE -->
            <script src="<?=MJS;?>bootstrap-fileinput.js?v=<?= Kohana::$config->load('version.release') ?>" type="text/javascript"></script>
            <? if($active == 'message'):?>
            <!-- MESSAGE -->
            <script src="<?=MJS;?>inbox.js" type="text/javascript"></script>
            <? endif;?>
            <!-- GALLERY -->
            <script src="<?=MJS;?>jquery.fancybox.pack.js" type="text/javascript"></script>
            <script src="<?=MJS;?>jquery.blueimp-gallery.min.js" type="text/javascript"></script>
            <!-- CLASSES & SPEC. OFFER-->
            <script src="<?=MJS;?>bootstrap-timepicker.min.js" type="text/javascript"></script>
            <script src="<?=MJS;?>bootstrap-datepicker.js" type="text/javascript"></script>
            <script src="<?=MJS;?>components-pickers.js"></script>
            <!-- DASHBOARD -->
            <script src="<?=MJS;?>moment.min.js" type="text/javascript"></script> 
            <script src="<?=JS;?>moment-timezone-with-data-2010-2020.min.js" type="text/javascript"></script> 
            <!-- CLASSES AND PROFILE & MESSAGE-->
            <script type="text/javascript" src="<?=MJS;?>select2.min.js"></script>
            <script type="text/javascript" src="<?=MJS;?>jquery.multi-select.js"></script>
            <!-- -->
            <script src="<?=JS;?>site.js?v=<?= Kohana::$config->load('version.release') ?>" type="text/javascript"></script>
            <script src="<?=JS;?>infobox.js?v=<?= Kohana::$config->load('version.release') ?>"></script>
            <script src="<?=JS;?>stars.js?v=<?= Kohana::$config->load('version.release') ?>"></script>
            <script src="<?=JS;?>directory.js?v=<?= Kohana::$config->load('version.release') ?>"></script>
            <script src="<?=JS;?>ajax.js?v=<?= Kohana::$config->load('version.release') ?>" type="text/javascript"></script>
            <script src="<?=JS;?>modals.js?v=<?= Kohana::$config->load('version.release') ?>" type="text/javascript"></script>
            <script src="<?=JS;?>gymhit.js?v=<?= Kohana::$config->load('version.release') ?>" type="text/javascript"></script>
            <script src="<?=JS;?>gymhit-session.js?v=<?= Kohana::$config->load('version.release') ?>" type="text/javascript"></script>
            <script src="<?=JS;?>gymhit-tour.js?v=<?= Kohana::$config->load('version.release') ?>" type="text/javascript"></script>
            <script src="<?=JS;?>gymhit-calendar.js?v=<?= Kohana::$config->load('version.release') ?>" type="text/javascript"></script>
            <script src="<?=JS;?>gymhit-stats.js?v=<?= Kohana::$config->load('version.release') ?>" type="text/javascript"></script>
            <script src="<?=JS;?>gymhit-app.js?v=<?= Kohana::$config->load('version.release') ?>" type="text/javascript"></script>
            <script src='<?=R;?>fullcalendar-2.4.0/fullcalendar.min.js'></script>
            <script>
                jQuery(document).ready(function() {	  
                    Metronic.init();
                    Layout.init(); 
                    Login.init();
                    <? if($active == 'message'):?>
                    Inbox.init();
                    <? endif;?>
                    //class
                    ComponentsPickers.init();
                    //class & profile
                });
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
            <script type="text/javascript">stLight.options({publisher: "45c60ab0-cd43-40b9-814e-3af2955bf439"});</script>
        </body>
    </html>
