<? if(!$pageObj->getBackgroundUrl()):?>
<script>
    var geocoder;
    var map;
    var address = "<?= $userObj->getCity();?>, <?= $userObj->getAddress();?>";

    function HomeControl(controlDiv, map) {
        google.maps.event.addDomListener(zoomout, 'click', function() {
            var currentZoomLevel = map.getZoom();
            if(currentZoomLevel != 0){
                map.setZoom(currentZoomLevel - 1);
            }     
        });

        google.maps.event.addDomListener(zoomin, 'click', function() {
            var currentZoomLevel = map.getZoom();
            if(currentZoomLevel != 21){
                map.setZoom(currentZoomLevel + 1);
            }
        });
    }

    function initialize() {
        geocoder = new google.maps.Geocoder();
        var mapOptions = {
            zoom: 10,
            panControl: false,
            zoomControl: false,
            scrollwheel: false,		
            center: new google.maps.LatLng(-34.397, 150.644)
        };
        map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

        var contentString = '<div class="marker"><div class="marker_body"><div class="avatar-100_container"><img src="<?= $pageObj->getAvatarImageUrl();?>" class="avatar-100 img-circle" alt="" /></div><div class="marker_txt"><div class="font-medium"><span class="green fs13"><?= $userObj->getName();?></span><br /><br /><span class="fs10"><?= $userObj->getAddress();?><br /><?= $userObj->getCity();?>, <?= $userObj->getZip();?></span></div></div></div><div class="clearfix"></div></div><div class="marker_bottom"></div>';

        if (geocoder) {
            geocoder.geocode({
                'address': address
                }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
                        map.setCenter(results[0].geometry.location);

                        var marker = new google.maps.Marker({
                            position: results[0].geometry.location,
                            map: map
                        });

                        addInfoWindow(map, marker, contentString);
                    }
                } 
            });
        }

        var homeControlDiv = document.createElement('div');

        var homeControl = new HomeControl(homeControlDiv, map);

    }
    google.maps.event.addDomListener(window, 'load', initialize);

    function addInfoWindow(map, marker, message) {

        var myOptions = {
            content: message,
            disableAutoPan: false,
            maxWidth: 0,
            closeBoxURL: "",
            pixelOffset: new google.maps.Size(-154, -160),
            boxStyle: {background: "none"},
            infoBoxClearance: new google.maps.Size(1, 1),
            isHidden: false,
            pane: "floatPane",
            enableEventPropagation: false
        };

        var ib = new InfoBox(myOptions);

        google.maps.event.addListener(marker, 'mouseover', function () {
            ib.open(map, marker);
        });
        google.maps.event.addListener(marker, 'mouseout', function () {
            ib.close(map, marker);
        });
    }	
</script>

<div id="zoomout">-</div>
<div id="zoomin">+</div>
<? endif;?>

<? if($pageObj->isVisible($loginUserObj)):?>
<!-- if back url directory -->
<!--
<a href="<?=PATH.$backUrl;?>" id="back-to-directory" class="font-medium"><i class="icon-arrow_left"></i>BACK</a>
-->

<? if($pageObj->getBackgroundUrl()):?>
<div class="profile_map cover" style="background-image: url(<?= $pageObj->getBackgroundUrl() ? $pageObj->getBackgroundUrl() : IMG.'slider_photo.jpg';?>)"></div>
<? else:?>
<div id="map-canvas" class="profile_map"></div>
<? endif;?>

<div class="container">
    <div id="profile_main-informations">
        <div class="col-xs-3 text-center">
            <div class="img-circle take_avatar_to_map">
                <div><img src="<?= $pageObj->getAvatarImageUrl();?>" class="img-circle avatar-166" alt="" />
                </div>
            </div>
            <? if($distance):?>
            <div class="directory_profile-miles text-center"><i class="glyphicon icon-position3"></i><?= $distance;?> miles</div>
            <? endif;?>
            <? if($isConnect == false):?>
            <? if($isInvite == true):?>
            <div><a href="#" class="directory_profile-button directory_profile-button_book_appointment no-active"><?=__('INVITED')?></a></div>
            <? else:?>
            <div><a href="<?=PATH; ?>user/" class="connect directory_profile-button directory_profile-button_book_appointment<?=$loginUserObj && $pageObj->getUserId() != $loginUserObj->getId() ? '' : ' not-active';?>" data-id="<?=$pageObj->getUserId();?>" data-action="invite">
                    <span id="progress-connect" class="dn"><i class="fa fa-spinner fa-pulse"></i></span>
                    <span id="text-connect"><?=__('CONNECT')?></span></a></div>
            <? endif;?>
            <? else: ?>
            <div><a href="<?=PATH; ?>user/" class="connect directory_profile-button directory_profile-button_book_appointment" data-id="<?=$pageObj->getUserId();?>" data-action="disconnect">
                    <span id="progress-connect" class="dn"><i class="fa fa-spinner fa-pulse"></i></span>
                    <span id="text-connect"><?=__('DISCONNECT')?></span></a></div>
            <? endif;?>
            <div class="socials">
                <?=$settingObj->getFacebook() || $settingObj->getLinkedIn() || $settingObj->getPinterest() || $settingObj->getTwitter() || $settingObj->getGoogle() ? '<div>Visit our page</div>' : '';?>
                <?=$settingObj->getFacebook() ? '<a target="_blank" href="https://www.facebook.com/'.$settingObj->getFacebook().'"><i class="icon-facebook"></i></a>' : '';?>
                <?=$settingObj->getLinkedIn() ? '<a target="_blank" href="http://linkedin.com/in/'.$settingObj->getLinkedIn().'"><i class="icon-linkedin"></i></a>' : '';?>
                <?=$settingObj->getPinterest() ? '<a target="_blank" href="https://www.pinterest.com/'.$settingObj->getPinterest().'"><i class="icon-pintrest"></i></a>' : '';?>
                <?=$settingObj->getTwitter() ? '<a target="_blank" href="https://twitter.com/'.$settingObj->getTwitter().'"><i class="icon-twitter"></i></a>' : '';?>
                <?=$settingObj->getGoogle() ? '<a target="_blank" href="https://plus.google.com/'.$settingObj->getGoogle().'"><i class="icon-googleplus"></i></a>' : '';?>
            </div>
        </div>

        <div class="col-xs-5 no-padding">
            <div class="directory_profile_name green mb0"><h1><?= $pageObj->getName();?></h1></div>
            <div class="directory_speciality"><?= $pageObj->getTitle();?></div>
            <div class="directory_profile_address-div pull-left mb20">
                <div class="pull-left">
                    <div class="stars">
                        <? for($i=0;$i<$ratingObj->getGlobal();$i++):?><i class="fa fa-star"></i><? endfor;?>
                        <? for($j=0;$j<5-$ratingObj->getGlobal();$j++):?><i class="fa fa-star-o"></i><? endfor;?>
                    </div>
                </div>
                <div class="pull-left ml5">( <?= count($reviewObjs);?> )</div>
                <div class="clearfix"></div>
                <div class="profile_address"><?= $userObj->getAddress();?><br /><?= $userObj->getCity();?>, <?= $userObj->getZip();?></div>
            </div>		
            <div class="main-amenities_container">
                <? if($userObj->isRoleTrainer()):?>
                <? if(count($credentialObjs)>0):?>
                <div class="font-bold mb10"><?=__('CREDENTIALS')?></div>
                <div class="credentials">
                    <? foreach($credentialObjs as $credentialObj):?>
                    <img src="<?=$credentialObj->getImageUrl();?>" alt="" />
                    <? endforeach;?>
                </div>
                <? endif;?>
                <div class="clearfix"></div>
            </div>
            <? else:?>
            <? $userUnits = $userObj->getUnits();?>
            <? if(count($userUnits) >= 0):?>
            <div class="font-bold mb10"><?=__('MAIN AMENITIES/SERVICES')?></div>	
            <? $i = 0;?>
            <? foreach($unitObjs as $unitObj):?>
            <? if($userUnits[$unitObj->getId()] == 1):?>
            <div class="main-amenities text-center pull-left">
                <i class="<?= $unitObj->getAttr('class');?>"></i><br /><?= strtoupper($unitObj->getAttr('name'));?></div>
            <? $i++;?>
            <? endif;?>
            <? if($i == 4) break;?>
            <? endforeach;?>
            <? if(count($userUnits) > 4):?>
            <div class="pull-right">				
                <a href="#amenities" class="link_with_plus"><span class="glyphicon glyphicon-plus green"></span><?=__('see all amenities/services')?></a>
            </div>
            <? endif;?>
        </div>
        <? endif;?>
        <div class="clearfix"></div>
        <? endif;?>
    </div>

    <div class="col-xs-4 text-center">

        <div class="profile_actions">
<? if (!$loginUserObj) { ?>
        <a href="#" class="generic-modal-trigger directory_profile-button directory_profile-button_grey pull-left" data-toggle="modal" data-target="#genericModal" data-content="You must login to send direct message."><?=__('DIRECT MESSAGE')?></a>                
<? } else { ?>
        <a href="#" class="directory_profile-button directory_profile-button_grey pull-left<?= $pageObj->allowMessage($loginUserObj) ? '' : '  not-active';?>" data-toggle="modal" data-target="#messageModal2" data-user="<?=$userObj->getId();?>" data-name="<?=$userObj->getName();?>" data-avatar="<?=$userObj->getAvatarImageUrl() ;?>"><?=__('DIRECT MESSAGE')?></a>                
<? } ?>
            <? if ($userObj->isRoleHost() && $settingObj->isBooking()): ?>
            <a href="/calendar/tour/<?= $pageObj->getRoute(); ?>" class="directory_profile-button directory_profile-button_orange pull-left ml20"><?=__('BOOK A TOUR')?></a>			
            <div class="clearfix"></div>
            <? endif; ?>
            <? if ($settingObj->isFreePass()): ?>
            <?= $freePassModal;?>
            <a href="#" id="free-pass-button" class="directory_profile-button directory_profile-button_view_profile no-margin<?= $pageObj->allowFreePass($loginUserObj) ? '' : ' not-active';?>" data-toggle="modal" data-target="#freePassModal"><?=__('FREE PASS')?></a>
            <div class="clearfix"></div><br />
            <? endif; ?>
            <div class="clearfix"></div><br />
            <div class="socials">
                <h4><?=__('Share this page')?></h4>
                <a href="#" class="st_facebook_custom social" st_url="http://sharethis.com"><i class="icon-facebook"></i></a>
                <a href="#" class="st_linkedin_custom social" st_url="http://sharethis.com"><i class="icon-linkedin"></i></a>
                <a href="#" class="st_pinterest_custom social" st_url="http://sharethis.com"><i class="icon-pintrest"></i></a>
                <a href="#" class="st_twitter_custom social" st_url="http://sharethis.com"><i class="icon-twitter"></i></a>
                <a href="#" class="st_googleplus_custom social" st_url="http://sharethis.com"><i class="icon-googleplus"></i></a>
            </div>
        </div>		
    </div>
    <div class="clearfix"></div>
</div>
    </div>
    <? endif;?>

    <section id="profile-main">
    <? if($pageObj->isVisible($loginUserObj)):?>
    <div class="container">
        <div class="col-xs-8 profile_left_column">
            <div class="profile_container" id="bio">
                <h3><?=__('Biography')?></h3>
                <? if(strlen($userObj->getAbout()) > 360):?>
                <? $pos = strpos($userObj->getAbout(),' ',360);?>
                <?= substr($userObj->getAbout(),1,$pos);?>
                <div class="dn" id="read-more-biography">
                    <?= substr($userObj->getAbout(),$pos+1);?>
                </div>
                <div class="text-center pt45 load-more">
                    <a href="#" class="directory_profile-button directory_profile-button_view_profile no-margin w176" id="show-more-biography" >
                        <span><?__('READ MORE')?></span>
                        <i class="icon-arrow_down"></i></a>
                </div>
                <? else:?>
                <? if($userObj->getAbout()):?>
                    <?= $userObj->getAbout();?>
                <? else: ?>
                    <?=__('NO BIO FOUND')?>
                <? endif;?>
                <? endif;?>
            </div>	
            <div class="profile_container">
                <h3><?=__('Profile Gallery')?></h3>
                <? if(count($imageObjs) > 0):?>
                <div id="photo_gallery" class="carousel slide" data-ride="carousel" data-interval="9000"> 
                    <a class="new-carousel-control go-left" href="#photo_gallery" role="button" data-slide="prev">
                        <i class="icon-arrow_left"></i></a>
                    <a class="new-carousel-control go-right" href="#photo_gallery" role="button" data-slide="next">
                        <i class="icon-arrow_right"></i></a>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <? $i = 1;?>
                        <? foreach($imageObjs as $imageObj):?>
                        <div class="item<?= $i==1 ?' active' : '';?>">
                            <img style="border-radius:0px;padding:3px; border:1px solid #ccc; background-color:#fff;" src="<?=$imageObj->getImageUrl();?>" alt="...">
                            <div class="carousel-caption"><?=$imageObj->getAttr('title');?></div>
                        </div>
                        <? $i++;?>
                        <? endforeach;?>
                    </div>
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <? $j = 0;?>
                        <? foreach($imageObjs as $imageObj):?>
                        <li data-target="#photo_gallery" data-slide-to="<?=$j;?>"<?= $j==0 ? ' class="active"' : '';?>></li>
                        <? $j++;?>
                        <? endforeach;?>
                    </ol>
                </div>
                <? else:?>
                    <?=__('NO IMAGES FOUND')?>
                <? endif;?>
            </div>
            <? if(count($unitObjs) > 0 && !$userObj->isRoleTrainer()):?>
            <a href="#" name="amenities"></a>
            <div class="profile_container">
                <h3><?=__('Amenities / Services')?></h3>
                <div class="all-amenities">
                    <div class="all-amenities_row">
                        <? $k = 1;?>
                        <? foreach($unitObjs as $unitObj):?>
                        <? if($userUnits[$unitObj->getId()] == 1):?>
                        <div class="main-amenities text-center pull-left">
                            <i class="<?= $unitObj->getAttr('class');?>"></i><br /><?= strtoupper($unitObj->getAttr('name'));?>
                        </div>
                        <? if($k%6 == 0):?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="all-amenities_row">
                        <? endif;?>
                        <? $k++;?>
                        <? endif;?>
                        <? endforeach;?>
                        <div class="clearfix"></div>
                    </div>
                    <? if ($k == 1): ?>
                    <?=__('NO AMENITIES FOUND')?>
                    <? endif; ?>
                </div>
            </div>
            <? endif;?>

            <!-- REVIEWS -->
            <div class="profile_container" id="reviews">

                <div class="reviews-1-col">
                    <h3><?= count($reviewObjs)>0 ? '<span class="font-book">'.count($reviewObjs).'</span>' : 'No';?> Reviews</h3>
                </div>
                <div class="clearfix"></div>
                <div class="reviews-23-col">
                    <div class="reviews-2-col mb30">
                        <div id="star-global" class="stars" data-rating="<?=$ratingObj->getGlobal();?>">
                            <? for($i=0;$i<$ratingObj->getGlobal();$i++):?><i class="fa fa-star"></i><? endfor;?><? for($j=0;$j<5-$ratingObj->getGlobal();$j++):?><i class="fa fa-star-o"></i><? endfor;?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <? if($userObj->isRoleTrainer()):?>
                    <div class="reviews-3-col mb30">
                        <div class="starrr-header"><?=__('CUSTOMER SERVICE')?></div>
                        <? if($loginUserObj && $checkReview == false && $isConnect == true && $pageObj->getUserId() != $loginUserObj->getId() && $loginUserObj->getRole() !=0):?>
                        <div id="star-service" class="starrr pull-left" data-rating='<?=$ratingObj->getService();?>'></div>
                        <? else:?>
                        <div id="star-service" class="stars pull-left" data-rating='<?=$ratingObj->getService();?>'>
                            <? for($i=0;$i<$ratingObj->getService();$i++):?><i class="fa fa-star"></i><? endfor;?><? for($j=0;$j<5-$ratingObj->getService();$j++):?><i class="fa fa-star-o"></i><? endfor;?>
                        </div>
                        <? endif;?>
                    </div>
                    <div class="reviews-2-col  mb30">
                        <div class="starrr-header"><?=__('KNOWLEDGE BASE')?></div>
                        <? if($loginUserObj && $checkReview == false && $isConnect == true && $pageObj->getUserId() != $loginUserObj->getId() && $loginUserObj->getRole() !=0):?>
                        <div id="star-knowledge" class="starrr pull-left" data-rating='<?=$ratingObj->getKnowledge();?>'></div>
                        <? else:?>
                        <div id="star-knowledge" class="stars pull-left" data-rating='<?=$ratingObj->getKnowledge();?>'>
                            <? for($i=0;$i<$ratingObj->getKnowledge();$i++):?><i class="fa fa-star"></i><? endfor;?><? for($j=0;$j<5-$ratingObj->getKnowledge();$j++):?><i class="fa fa-star-o"></i><? endfor;?>
                        </div>
                        <? endif;?>
                    </div>                    
                    <div class="reviews-2-col  mb30">
                        <div class="starrr-header"><?=__('LIKEABILITY')?></div>
                        <? if($loginUserObj && $checkReview == false && $isConnect == true && $pageObj->getUserId() != $loginUserObj->getId() && $loginUserObj->getRole() !=0):?>
                        <div id="star-like" class="starrr pull-left" data-rating='<?=$ratingObj->getLike();?>'></div>
                        <? else:?>
                        <div id="star-like" class="stars pull-left" data-rating='<?=$ratingObj->getLike();?>'>
                            <? for($i=0;$i<$ratingObj->getLike();$i++):?><i class="fa fa-star"></i><? endfor;?><? for($j=0;$j<5-$ratingObj->getLike();$j++):?><i class="fa fa-star-o"></i><? endfor;?>
                        </div>
                        <? endif;?>
                    </div>                    
                    <? else:?>
                    <div class="reviews-3-col mb30">
                        <div class="starrr-header"><?=__('CUSTOMER SERVICE')?></div>
                        <? if($loginUserObj && $checkReview == false && $isConnect == true && $pageObj->getUserId() != $loginUserObj->getId() && $loginUserObj->getRole() !=0):?>
                        <div id="star-service" class="starrr pull-left" data-rating='<?=$ratingObj->getService();?>'></div>
                        <? else:?>
                        <div id="star-service" class="stars pull-left" data-rating='<?=$ratingObj->getService();?>'>
                            <? for($i=0;$i<$ratingObj->getService();$i++):?><i class="fa fa-star"></i><? endfor;?><? for($j=0;$j<5-$ratingObj->getService();$j++):?><i class="fa fa-star-o"></i><? endfor;?>
                        </div>
                        <? endif;?>
                    </div>
                    <div class="reviews-2-col  mb30">
                        <div class="starrr-header"><?=__('FACILITY')?></div>
                        <? if($loginUserObj && $checkReview == false && $isConnect == true && $pageObj->getUserId() != $loginUserObj->getId() && $loginUserObj->getRole() !=0):?>
                        <div id="star-facility" class="starrr pull-left" data-rating='<?=$ratingObj->getFacility();?>'></div>
                        <? else:?>
                        <div id="star-facility" class="stars pull-left" data-rating='<?=$ratingObj->getFacility();?>'>
                            <? for($i=0;$i<$ratingObj->getFacility();$i++):?><i class="fa fa-star"></i><? endfor;?><? for($j=0;$j<5-$ratingObj->getFacility();$j++):?><i class="fa fa-star-o"></i><? endfor;?>
                        </div>
                        <? endif;?>
                    </div>
                    <div class="reviews-2-col mb30">
                        <div class="starrr-header"><?=__('CLEANLINESS')?></div>
                        <? if($loginUserObj && $checkReview == false && $isConnect == true && $pageObj->getUserId() != $loginUserObj->getId() && $loginUserObj->getRole() !=0):?>
                        <div id="star-clean" class="starrr pull-left" data-rating='<?=$ratingObj->getClean();?>'></div>
                        <? else:?>
                        <div id="star-clean" class="stars pull-left" data-rating='<?=$ratingObj->getClean();?>'>
                            <? for($i=0;$i<$ratingObj->getClean();$i++):?><i class="fa fa-star"></i><? endfor;?><? for($j=0;$j<5-$ratingObj->getClean();$j++):?><i class="fa fa-star-o"></i><? endfor;?>
                        </div>
                        <? endif;?>
                    </div>
                    <div class="reviews-3-col mb30">
                        <div class="starrr-header"><?=__('VIBE')?></div>
                        <? if($loginUserObj && $checkReview == false && $isConnect == true && $pageObj->getUserId() != $loginUserObj->getId() && $loginUserObj->getRole() !=0):?>
                        <div id="star-vibe" class="starrr pull-left" data-rating='<?=$ratingObj->getVibe();?>'></div>
                        <? else:?>
                        <div id="star-vibe" class="stars pull-left" data-rating='<?=$ratingObj->getVibe();?>'>
                            <? for($i=0;$i<$ratingObj->getVibe();$i++):?><i class="fa fa-star"></i><? endfor;?><? for($j=0;$j<5-$ratingObj->getVibe();$j++):?><i class="fa fa-star-o"></i><? endfor;?>
                        </div>
                        <? endif;?>
                    </div>
                    <? endif;?>
                    <div class="clearfix"></div>
                    <div class="clearfix"></div>		
                </div>
                <div class="clearfix"></div>
                <? if($loginUserObj && $checkReview == false && $isConnect == true && $pageObj->getUserId() != $loginUserObj->getId() && $loginUserObj->getRole() !=0):?>
                <div id="review-form">
                    <div class="reviews-1-col">
                        <img src="<?= $loginUserObj->getAvatarImageUrl();?>" class="img-circle avatar-86" alt="" />
                    </div>
                    <div class="reviews-23-col">
                        <form action="#" method="post">
                            <textarea placeholder="Write Review Here" class="review-textarea" ></textarea>
                            <div class="pull-right mt10">
                                <button id="add-review" type="button" class="directory_profile-button directory_profile-button_view_profile no-margin w176" data-owner="<?=$pageObj->getUserId();?>" data-url="<?=PATH;?>page/review/<?=$pageObj->getRoute();?>">SEND</button>
                            </div>
                        </form>
                        <div id="progress-review" class="dn" style="text-align:center;">
                            <span><i class="fa fa-spinner fa-pulse fa-4x"></i></span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="review-new"></div>
                <? endif;?>
                <? if(count($reviewObjs)>0):?>
                <!-- REVIEW LIST -->
                <? $x = 0;?>
                <? foreach($reviewObjs as $reviewObj):?>
                <? if($x == 3):?>
                <div class="dn ajax-more-reviews">
                    <? endif;?>
                    <div class="review">
                        <div class="reviews-1-col">
                            <div class="review-avatar text-center">
                                <img src="<?= $reviewObj->getOwnerObj()->getAvatarImageUrl();?>" class="img-circle avatar-86" alt="" />
                                <?= $reviewObj->getOwnerObj()->getTruncatedName();?>
                            </div>
                        </div>
                        <div class="reviews-23-col">
                            <div class="review-text"><?= $reviewObj->getText();?></div>
                            <div class="small_notifications mt20">
                                <div class="pull-left">
                                    <div><i class="icon-post_time green"></i><span class="value ml5"><?= date('F Y',strtotime($reviewObj->getAttr('date')));?> </span>
                                        <span class="stars" style="padding-left:20px;">
                                            <? for($i=0;$i<$reviewObj->getAttr('global');$i++):?>
                                            <i class="fa fa-star"></i>
                                            <? endfor;?>
                                            <? for($j=0;$j<5-$reviewObj->getAttr('global');$j++):?>
                                            <i class="fa fa-star-o"></i>
                                            <? endfor;?>
                                        </span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>	
                    </div>
                    <? $x++;?>
                    <? endforeach;?>
                    <? if(count($reviewObjs)>3):?>
                </div>
                <div class="text-center pt45 load-more">
                    <a href="#" class="directory_profile-button directory_profile-button_view_profile no-margin w176 show-more-reviews" >
                        <?=__('MORE REVIEWS')?>
                        <i class="icon-arrow_down"></i>
                    </a>
                </div>
                <? endif;?>
                <? endif;?>
            </div>         
        </div>

        <div class="col-xs-4 profile_right_column">
            <? if($loginUserObj && $pageObj->getUserId() == $loginUserObj->getId()):?>	
            <div class="profile_container pt45">
                <form id="post-new" class="form-horizontal" role="form" action="#" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input class="form-control" placeholder="New status" type="text" name="subject" required="required" />
                        </div>
                    </div>

                    <div id="new_status" class="dn">
                        <div class="form-group">
                            <div class="col-md-12">	
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview fileinput-exists small-status thumbnail"></div>		
                                    <span class="btn btn-warning fileinput-button"><i class="fa fa-plus"></i> Add picture
                                        <input name="picture" type="file" /></span>
                                </div>
                            </div>
                        </div>		

                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea class="form-control" name="text"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12" style="text-align:center;">
                                <button class="status btn green" data-id="new" data-url="<?= PATH;?>page/status/<?=$pageObj->getRoute();?>" data-jsbase="<?=JS;?>" data-side="right">Add</button>
                                <button id="new_hide" class="btn default">Hide</button>
                            </div>
                        </div>
                    </div> 
                </form>
            </div>
            <? endif;?>

            <div class="profile_container pt45<?=count($statusObjs) > 0 ? '' : ' dn';?>">
                <div id="comments-carousel" class="carousel slide" data-wrap="false" data-pause="true">
                    <a class="new-carousel-control go-left" href="#comments-carousel" role="button" data-slide="prev">
                        <i class="icon-arrow_left"></i></a>
                    <a class="new-carousel-control go-right" href="#comments-carousel" role="button" data-slide="next">
                        <i class="icon-arrow_right"></i></a>
                    <div class="carousel-inner">
                        <div class="new-post"></div>
                        <? if(count($statusObjs) > 0):?>
                        <!-- STATUSES -->
                        <? $k = 0;?>
                        <? foreach($statusObjs as $statusObj):?>
                        <div id="post-<?=$statusObj->getId();?>" class="item<?= $k == 0 ? ' active' : '';?>">
                            <h3><?= $statusObj->getAttr('subject');?></h3>
                            <? if($loginUserObj && $loginUserObj->getId() == $pageObj->getUserId()):?>
                            <div class="status-menu" style="right:0;">
                                <a href="" class="dropdown-toggle" style="position:relative; bottom:45px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <span class="fa fa-angle-down"></span></a>
                                <ul class="dropdown-menu pull-right" style="">
                                    <li><a class="edit-post" href="#" data-id="<?=$statusObj->getId();?>"><?=__('Edit')?></a></li>
                                    <li><a class="delete-post" href="#" data-url="<?=PATH;?>page/delete_status/<?=$pageObj->getRoute();?>" data-id="<?=$statusObj->getId();?>">
                                        <?=__('Delete')?></a></li>
                                </ul>
                            </div>
                            <? endif;?>
                            <div class="text-center">
                                <img style="border-radius:0px;padding:3px; border:1px solid #ccc; background-color:#fff;" class="post-img" src="<?= $statusObj->getPicUrl();?>" alt="" class="mb30" />
                                <div id="text-<?=$statusObj->getId();?>"><?= $statusObj->getAttr('text');?></div><br />
                                <div id="save-<?=$statusObj->getId();?>" class="form-group dn">
                                    <div class="col-md-12" style="text-align:center; padding-bottom:10px;">
                                        <button class="status btn green" data-id="<?=$statusObj->getId();?>" data-url="<?= PATH;?>page/status/<?=$pageObj->getRoute();?>"><?=__('Save')?></button>
                                    </div>
                                </div>
                            </div>

                            <div id="actions-<?=$statusObj->getId();?>">
                                <div class="small_notifications">
                                    <div class="pull-left">
                                        <div><i class="icon-post_time green"></i><span class="value ml5"><?=timeElapse(strtotime($statusObj->getAttr('date')));?> ago</span></div>
                                    </div>
                                    <div class="pull-right">
                                        <? $slikes = $modelStatus->getLikeList($statusObj->getId(),'status');?>
                                        <? $comments = $modelStatus->getCommentList($statusObj->getId());?>
                                        <div class="pull-left">
                                            <span class="value"><?= count($slikes);?></span>
                                            <button type="button" class="icon-social like" title="Like" data-item="<?= $statusObj->getId();?>" data-category="status" data-url="<?=PATH;?>" <?= $loginUserObj && $modelStatus->checkLike($loginUserObj->getId(),$statusObj->getId(),'status') == FALSE ? '' : 'disabled="disabled"';?>>
                                                <i class="icon-like ml5"></i></button>	
                                        </div>
                                        <div class="pull-left"><span class="value count-comments"><?= count($comments);?></span><i class="icon-comments ml5"></i></div>
                                        <div class="pull-left no-margin"><span class="value"><?= (int)$statusObj->getAttr('shares');?></span>
                                            <button type="button" class="icon-social" title="Share" data-toggle="modal" data-target="#shareStatusModal" data-share_id="<?= $statusObj->getAttr('user_id');?>" data-subject="<?= $statusObj->getAttr('subject');?>" data-id="<?= $statusObj->getId();?>" data-top_pic="<?= $statusObj->getAttr('top_pic');?>" data-text="<?= $statusObj->getAttr('text');?>" <?= $loginUserObj && $statusObj->getAttr('user_id') != $loginUserObj->getId() ? '' : ' disabled="disabled"';?>>
                                                <i class="icon-share_post ml5"></i></button></div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="clearfix"></div>
                            </div></div><br />

                            <div class="comment">
                                <? if($loginUserObj):?>
                                <div class="commment-avatar pull-left no-padding">
                                    <img src="<?= $loginUserObj->getAvatarImageUrl();?>" class="img-circle" alt="" />
                                </div>

                                <div class="commment-text pull-left no-padding">
                                    <form id="add-comment-<?=$statusObj->getId();?>" action="<?=PATH;?>page/comment/<?=$pageObj->getRoute();?>" method="post">
                                        <div id="comment-send">
                                            <input type="text" name="text" class="pull-left no-padding comment-text" placeholder="add comment ..."/>
                                            <button id="comment" type="button" class="icon-social pull-left no-padding comment_submit" data-id="<?=$statusObj->getId();?>" data-url="<?= PATH;?>page/comment/<?=$pageObj->getRoute();?>" data-side="right"><i class="icon-send4"></i></button>
                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                                <? endif;?>
                                <div class="clearfix"></div>
                            </div><br />
                            <div id="new-comment-<?=$statusObj->getId();?>"></div>
                            <? if(count($comments) > 0):?>
                            <? $n = 0;?>
                            <? foreach($comments as $comment):?>
                            <? if($n == 3):?>
                            <div id="more-<?=$statusObj->getId();?>" class="dn">
                                <? endif;?>
                                <div class="comment">
                                    <div class="commment-avatar pull-left no-padding">
                                        <img src="<?= $comment['avatar'] ? Kohana::$config->load('site.s3.url')."/users/".$comment['user_id']."/avatar/". $comment['avatar'] : IMG.'logo_avatar.png';?>" class="img-circle" alt="" />
                                    </div>
                                    <div class="commment-text pull-left no-padding"><?= $comment['text'];?>			
                                        <? $clikes = $modelStatus->getLikeList($comment['id'],'comment');?>
                                        <div class="small_notifications">
                                            <div><span class="value  ml5"><?= count($clikes);?></span>
                                                <button class="icon-social like" title="Like" data-item="<?= $comment['id'];?>" data-category="comment" data-url="<?=PATH;?>"<?= $loginUserObj && $modelStatus->checkLike($loginUserObj->getId(),$comment['id'],'comment') == FALSE ? '' : ' disabled="disabled"';?>>
                                                    <i class="icon-like ml5"></i></button>
                                            </div>
                                        </div>
                                    </div>	
                                    <div class="clearfix"></div>
                                </div>
                                <? $n++;?>
                                <? endforeach;?><br />
                                <? if(count($comments) > 3):?>
                            </div>
                            <div class="text-center">
                                <a href="#" class="link_with_plus show-more" data-status="<?=$statusObj->getId();?>">
                                    <span class="glyphicon glyphicon-plus green"></span><?=__('more comments')?></a>
                            </div>
                            <? endif;?>
                            <? endif;?>
                        </div>
                        <? $k++;?>
                        <? endforeach;?>
                        <? endif;?>
                        <!-- END STATUSES -->    
                    </div>
                </div>
            </div>


            <!-- SPECIAL OFFER -->
            <? if($settingObj->isSpecialOffer() && $offerObj):?>
            <div class="profile_container">
                <h3>Special Offer</h3>
                <h4 style="text-align:center;"><?=$offerObj->getAttr('name');?></h4>
                <?= $specOfferModal;?>
                <div class="text-center mb30">
                    <? if (!$loginUserObj): ?>
                    <a href="#" class= generic-modal-trigger" data-title="<?=__('Ops, sorry!')?>" data-content="<?=__('You must login to buy this special offer!')?>">
                        <img src="<?= $offerObj->getImageUrl();?>" alt="" /></a>
                    <? elseif ($loginUserObj->getId() == $userObj->getId()): ?>
                    <a href="#" class="generic-modal-trigger" data-title="<?=__('Ops, sorry!')?>" data-content="<?=__('You are the owner of this special offer.')?>">
                        <img src="<?= $offerObj->getImageUrl();?>" alt="" /></a>
                    <? else: ?>
                    <a href="#" data-toggle="modal" data-target="#specOfferModal">
                        <img src="<?= $offerObj->getImageUrl();?>" alt="" /></a>
                    <? endif; ?>
                </div>
                <div class="small_notifications">
                    <div class="pull-left">
                        <? if($offerObj->getAttr('date')):?>
                        <div><i class="icon-post_time green"></i><span class="value ml5">Active to: <?=date('m/d/Y',strtotime($offerObj->getAttr('date')));?></span></div>
                        <? endif;?>
                    </div>
                    <div class="pull-right">
                        <? if($offerObj->getAttr('max')):?>
                        <div class="pull-left no-margin"><?=__('Only')?> <?=$offerObj->getAttr('quant');?> <?=__('remains!')?></div>
                        <? endif;?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <? endif;?>

            <!-- CLASSES -->
            <div class="profile_container" id="classes">
                <h3><?=__('Classes')?></h3>
            <? if(count($classObjs)>0):?>
                <table width="100%">
                    <? foreach($classObjs as $classObj):?>
                        <? $weekHash = $classObj->getWeekHash();?>
                    <td class="green time-bold"></td>
                    <tr>
                        <td class="green time-bold"><?=$classObj->getAttr('name');?></td>
                        <td class="time-classes" colspan="3"><?=date('m/d/Y',strtotime($classObj->getAttr('date_to')));?>&nbsp;&nbsp;~&nbsp;&nbsp;<?=date('m/d/Y',strtotime($classObj->getAttr('date_to')));?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <? if (isset($weekHash[7])): ?>
                            <span class="badge badge-warning">Su</span>
                            <? endif; ?>
                            <? if (isset($weekHash[1])): ?>
                            <span class="badge badge-warning">M</span> 
                            <? endif; ?>
                            <? if (isset($weekHash[2])): ?>
                            <span class="badge badge-warning">Tu</span> 
                            <? endif; ?>
                            <? if (isset($weekHash[3])): ?>
                            <span class="badge badge-warning">W</span> 
                            <? endif; ?>
                            <? if (isset($weekHash[4])): ?>
                            <span class="badge badge-warning">Th</span> 
                            <? endif; ?>
                            <? if (isset($weekHash[5])): ?>
                            <span class="badge badge-warning">F</span> 
                            <? endif; ?>
                            <? if (isset($weekHash[6])): ?>
                            <span class="badge badge-warning">Sa</span> 
                            <? endif; ?>
                        </td>
                        <td class="time-classes" colspan="2"><?=date('h:i A',strtotime($classObj->getAttr('time_from')));?>&nbsp;&nbsp;~&nbsp;&nbsp;<?=date('h:i A',strtotime($classObj->getAttr('time_to')));?></td>
                    </tr>
                    <? endforeach;?>
                </table>
                <div class="text-center pt45">
                    <a href="<?=PATH;?>classinfo/list/<?=$pageObj->getRoute();?>" class="directory_profile-button directory_profile-button_view_profile no-margin w176">
                        <?=__('SEE FULL SCHEDULE')?></a>
                </div>
            <? else:?>
                <div class="text-center pt45">
                <?=__('NO CLASSES FOUND')?>
                </div>
            <? endif;?>
            </div>
            <!-- END CLASSES -->

            <? if($userObj->isRoleTrainer()):?>
            <div class="profile_container">
                <h3><?=__('Private Sessions')?></h3>
                <div class="text-center pt45">
            <? if($userObj->canAcceptSession()):?>
                    <a href="<?=PATH;?>calendar/session/<?=$pageObj->getRoute();?>" class="directory_profile-button directory_profile-button_view_profile no-margin w176">
                        <?=__('SEE MY SCHEDULE')?></a>
            <? else: ?>
                    <?=__('NO SESSIONS OFFERED')?>
            <? endif; ?>
                </div>
            </div>
            <? endif;?>

            <? if(!$userObj->isRoleTrainer() && count($staffObjs)>0):?>
            <!-- STAFF -->
            <div class="profile_container">
                <h3><?=__('Meet Our Staff')?></h3>
                <? foreach($staffObjs as $staffObj):?>
                    <? $staffObj = $staffObj->getUserObj(); ?>
                <div class="staff">
                    <div class="staff-avatar pull-left no-padding">
                        <img src="<?= $staffObj->getAvatarImageUrl();?>" class="img-circle" />
                    </div>
                    <div class="staff-text pull-left no-padding">
                        <div class="directory_profile_name green"><?= $staffObj->getTruncatedName();?></div>
                        <div class="directory_speciality"><?= $staffObj->getAttr('title');?></div>
                        <? if($staffObj->getAttr('route') != NULL):?>
                        <a href="<?=PATH;?>page/<?=$staffObj->getAttr('route');?>?back_url=page/<?=$pageObj->getRoute();?>" class="directory_profile-button directory_profile-button_view_profile">
                            <?=__('SEE PROFILE')?></a>
                        <? endif;?>
                        <!-- END AVAILABILITY MODAL -->
                    </div>	
                    <div class="clearfix"></div>
                </div>
                <? endforeach;?>
                <div class="text-center pt20 load-more">
                    <a href="<?=PATH;?>page/staff/<?=$pageObj->getRoute();?>" class="directory_profile-button directory_profile-button_view_profile no-margin w176"><?=__('SEE ALL')?></a>
                </div>		
            </div>
            <!-- END STAFF -->
            <? endif;?>
        </div>				
    </div>
    <? else:?>
    <?=$boxes;?>
    <? endif;?>
    </section>
    <?= $shareStatusModal;?>	
