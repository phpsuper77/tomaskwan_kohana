<script>
    var map;
    var current;
    var users = [
    <? if(count($dirObjs) > 0):?>
    <? foreach($dirObjs as $dirObj):?>
      <? $userObj = $dirObj->getUserObj(); ?>
    ['<?=$userObj->getName();?>',<?=$userObj->getLat();?>,<?=$userObj->getLon();?>,'<?=$userObj->getTitle();?>','0','<?=$userObj->getAvatarImageUrl();?>',0,'<?=$userObj->getRole();?>'],
    <? endforeach;?>
    <? endif;?>
    ];

    function initialize() {
        var mapOptions = {
            zoom: <?= $zoom;?>,
            scrollwheel: false,		
            center: new google.maps.LatLng(<?=$start['lat'];?>, <?=$start['lon'];?>)
        };
        map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

        for (var i = 0; i < users.length; i++) {

            var contentString = '<div class="marker"><div class="marker_body"><div class="avatar-100_container"><img src="'+users[i][5]+'" class="avatar-100 img-circle" alt="" /></div><div class="marker_txt"><div class="font-medium"><span class="green fs13">'+users[i][0]+'</span><br /><span class="fs10">'+users[i][3]+'</span></div><div class="marker_details">';

                            if(users[i][7]!='4') {
                                contentString += '<div class="stars pull-left">';

                                    for (var j = 0; j < users[i][6]; j++)
                                    {
                                        contentString += '<i class="fa fa-star"></i>';
                                    }
                                    for (var j = 0; j < 5-users[i][6]; j++)
                                    {
                                        contentString += '<i class="fa fa-star-o"></i>';
                                    }
                                    contentString += '</div>';
                            }

                            contentString += '<div class="small_notifications no-margin pull-left"><div><? if($slider!='hide'):?><i class="icon-position3 green"></i><span class="value ml5">'+users[i][4]+' miles</span><? endif;?></div></div></div><div class="clearfix"></div></div><div class="clearfix"></div></div><div class="marker_bottom"></div></div>';

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(users[i][1], users[i][2]),
                map: map,
                title: users[i][0]
            });

            addInfoWindow(map, marker, contentString);

        }
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

        google.maps.event.addListener(marker, 'click', function () {
            if(current != null)
            current.close();
            ib.open(map, marker);
            current = ib;
        });
        google.maps.event.addListener(map, 'click', function () {
            ib.close(map, marker);
        });

    }	
</script>

<div class="wrapper" >
    <div id="directory_left-side" style="min-height:500px;">
        <div class="directory_left-side_cont">
            <div id="directory_search-info">
                <form action="<?=PATH;?>search/index" method="get">
                    <input type="hidden" name="sort" value="<?=$filter['sort'];?>" />
                    <input type="hidden" name="title" value="<?=$filter['title'];?>" />
                    <input type="hidden" name="city" value="<?=$filter['city'];?>" />
                    <input type="hidden" name="page" value="<?=$filter['page'];?>" />
                    <input type="hidden" name="role" value="<?=$filter['role'];?>" />
                    <input type="hidden" name="name" value="<?=$filter['name'];?>" />
                    <input type="hidden" name="send" value="ok" />
                    <div class="col-xs-8 no-padding">
                        <?= __('Found') ?> <span class="green"><?= $count;?></span> <?= $filter['title'] ? $filter['title'].'s' : __('results');?><?= $filter['city'] ? __(' near ') .'<span class="green">'.$filter['city'].'</span>' : __(' near You');?>
                        <? if($slider != 'hide'):?>
                        <div class="miles_slider">
                            <?= __('Distance') ?> <input id="ex6" type="text" name="distance" data-slider-min="1" data-slider-max="400" data-slider-step="1" data-slider-value="<?=$filter['distance'];?>"/>
                            <span id="ex6CurrentSliderValLabel"><span id="ex6SliderVal"><?=$filter['distance'];?></span> Miles</span>
                        </div>
                        <? endif;?>		
                    </div>
                    <div class="col-xs-4 no-padding">
                        <div class="dropdown pull-right" id="directory_sort-by-dropdown">
                            <div data-toggle="dropdown" role="button" class="directory_sort-by">
                                <?= __('SORT BY') ?> <?=$filter['sort'];?>
                            </div>		  
                            <ul class="dropdown-menu dropdown-sort" role="menu" aria-labelledby="dropdownMenu">
                                <? if($filter['role']!=4):?>
                                <li><a<?=$filter['sort'] == 'rating' ? ' class="hide"' :  '';?> href="<?=PATH;?>search/index?city=<?=$filter['city'];?>&page=<?=$filter['page'];?>&sort=rating&distance=<?=$filter['distance'];?>&title=<?=$filter['title'];?>&role=<?=$filter['role'];?>&send=ok"><?=__('RATING')?></a></li>
                                <? endif;?>
                                <? if($slider != 'hide'):?>
                                <li><a<?=$filter['sort'] == 'distance' ? ' class="hide"' :  '';?> href="<?=PATH;?>search/index?city=<?=$filter['city'];?>&page=<?=$filter['page'];?>&sort=distance&distance=<?=$filter['distance'];?>&title=<?=$filter['title'];?>&name=<?=$filter['name'];?>&role=<?=$filter['role'];?>&send=ok"><?=__('distance')?></a></li>
                                <? endif;?>
                                <? if($filter['role']!=4):?>
                                <li><a<?=$filter['sort'] == 'role' ? ' class="hide"' :  '';?> href="<?=PATH;?>search/index?city=<?=$filter['city'];?>&page=<?=$filter['page'];?>&sort=role&distance=<?=$filter['distance'];?>&title=<?=$filter['title'];?>&role=<?=$filter['role'];?>&send=ok"><?=__('PROFILE TYPE')?></a></li>
                                <? endif;?>
                                <li><a<?=$filter['sort'] == 'name' ? ' class="hide"' :  '';?> href="<?=PATH;?>search/index?city=<?=$filter['city'];?>&page=<?=$filter['page'];?>&sort=name&distance=<?=$filter['distance'];?>&title=<?=$filter['title'];?>&name=<?=$filter['name'];?>&role=<?=$filter['role'];?>&send=ok"><?=__('NAME')?></a></li>
                                <li><a<?=$filter['sort'] == 'name' ? ' class="hide"' :  '';?> href="<?=PATH;?>search/index?city=<?=$filter['city'];?>&page=<?=$filter['page'];?>&sort=relevance&distance=<?=$filter['distance'];?>&title=<?=$filter['title'];?>&name=<?=$filter['name'];?>&role=<?=$filter['role'];?>&send=ok"><?=__('RELEVANCE')?></a></li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>

            <div id="directory_profiles">
                <? if(count($dirObjs) > 0):?>
                <? foreach($dirObjs as $dirObj):?>
                    <? $userObj = $dirObj->getUserObj(); ?>
                    <? $pageObj = $userObj->getPageObj(); ?>
                    <? $ratingObj = $pageObj->getRatingObj(); ?>
                <div class="directory_profile">
                    <div class="avatar_cont pull-left">
                        <div class="img-circle avatar-105_container">
                            <img src="<?= $userObj->getAvatarImageUrl();?>" class="img-circle avatar-105" alt="" />
                        </div>
                        <? if($slider != 'hide'):?>
                        <div class="directory_profile-miles text-center"><i class="glyphicon icon-position3"></i><?= $dirObj->getDistance() ?> <?= __('miles') ?></div>
                        <? endif;?>
                    </div>
                    <div class="details_cont pull-left">
                        <div class="directory_profile_name green"><?= $userObj->getName();?></div>
                        <div class="directory_speciality"><?= $userObj->getTitle();?></div>
                        <div class="directory_profile_address-div pull-left mb30">

                            <div class="stars">
                            </div>

                            <?= $userObj->getAddress();?><br />
                            <?= $userObj->getCity()? $userObj->getCity().', '.$userObj->getZip() : $userObj->getZip();?>
                        </div>
                        <div class="directory_latest_reviev pull-left mb30">
                            <div class="directory_latest_reviev_header"><?= __('RATING') ?></div>
                           <div id="star-global" class="stars" data-rating="<?=$ratingObj->getGlobal();?>">
                              <? for($i=0;$i<$ratingObj->getGlobal();$i++):?><i class="fa fa-star"></i><? endfor;?><? for($j=0;$j<5-$ratingObj->getGlobal();$j++):?><i class="fa fa-star-o"></i><? endfor;?>
                           </div>
                        </div>
                        <div class="clearfix"></div>	
                        <? if($pageObj):?>
                        <div class="directory_profile_address-div pull-left">
                            <a href="<?= $pageObj->getPageUrl();?>" class="directory_profile-button directory_profile-button_view_profile">
                                <?= __('VIEW PROFILE') ?>
                            </a>
                        </div>
                        <? if($userObj->getRole() != Model_User::ROLE_USER):?>
                        <? if($userObj->isRoleServiceProvider() && $userObj->canAcceptTour()) { ?>
                        <div class="directory_latest_reviev pull-left">
                            <a href="<?=PATH;?>calendar/tour/<?=$pageObj->getRoute();?>" class="directory_profile-button directory_profile-button_book_appointment">
                                <?= __('BOOK A TOUR') ?>
                            </a>
                        </div>
                        <? } else if($userObj->isRoleTrainer() && $userObj->canAcceptSession()) { ?>
                        <div class="directory_latest_reviev pull-left">
                            <a href="<?=PATH;?>calendar/session/<?=$pageObj->getRoute();?>" class="directory_profile-button directory_profile-button_book_appointment">
                                <?= __('BOOK SESSION') ?>
                            </a>
                        </div>
                        <? } else {?>
                        <div class="directory_latest_reviev pull-left">
                            <a href="#" class="directory_profile-button directory_profile-button_show-number" autocomplete="off" data-phone="<?=$userObj->getPhone();?>">
                                <?= __('SHOW NUMBER') ?>
                            </a>
                        </div>
                        <? } ?>
                        <? endif;?>
                        <div class="clearfix"></div>
                        <? endif;?>		
                    </div>
                    <div class="clearfix"></div>
                </div>
                <? endforeach;?>
                <? else: ?>
                <p><?= __('Nothing found! Change search criteria or distance')?></p>
                <? endif;?>
            </div>	

            <? if($filter['page_count'] > 1):?>
            <div class="my_pagination">


                <div class="col-xs-2 pull-left no-padding text-left">
                    <? if($filter['page'] > 1):?>
                    <a id="prev" href="<?=PATH;?>search/index?city=<?=$filter['city'];?>&page=<?=$filter['page']-1;?>&sort=<?=$filter['sort'];?>&distance=<?=$filter['distance'];?>&title=<?=$filter['title'];?>&name=<?=$filter['name'];?>&role=<?=$filter['role'];?>&send=ok" class="next_pages"><i class="icon-arrow_left"></i></a>
                    <? endif;?>
                </div>

                <div class="col-xs-8 pull-left no-padding text-center">
                    <? for ($i = $filter['page'] - 2; $i <= $filter['page'] + 2; $i++):?>
                    <? if($i > 0 && $i <= $filter['page_count']):?>
                    <? if($i == $filter['page']):?>
                    <div class="my_pages" style="background-color: #cfd2da;"><?=$i;?></div>
                    <? else:?>
                    <a href="<?=PATH;?>search/index?city=<?=$filter['city'];?>&page=<?=$i;?>&sort=<?=$filter['sort'];?>&distance=<?=$filter['distance'];?>&title=<?=$filter['title'];?>&name=<?=$filter['name'];?>&role=<?=$filter['role'];?>&send=ok" class="my_pages"><?=$i;?></a>
                    <? endif;?>
                    <? endif;?>
                    <? endfor;?>
                </div>

                <div class="col-xs-2 pull-left no-padding text-right">
                    <? if($filter['page'] < $filter['page_count']):?>
                    <a id="next" href="<?=PATH;?>search/index?city=<?=$filter['city'];?>&page=<?=$filter['page']+1;?>&sort=<?=$filter['sort'];?>&distance=<?=$filter['distance'];?>&title=<?=$filter['title'];?>&name=<?=$filter['name'];?>&role=<?=$filter['role'];?>&send=ok" class="next_pages"><i class="icon-arrow_right"></i></a>
                    <? endif;?>
                </div>
                <div class="clearfix"></div>		
            </div>
            <? endif;?>
        </div>
        <div class="clearfix"></div>	
    </div>		
</div>
<div id="directory_right-side">
    <div id="map-canvas"  style="width: 100%; height: 100%; min-height:500px;"></div>
</div>
</div>
<div id="before-footer"></div>
