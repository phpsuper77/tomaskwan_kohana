<div class="modal fade" id="bookTourModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-auto">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
            </div>
            <div class="modal-body text-center">
                <? if(!$loginUserObj) { ?>
                <div class="directory_profile_name green mb0 mt20"><img alt="" class="img-circle avatar-86" src="<?= $clubObj->getAvatarImageUrl() ?>"><h1><?= $clubObj->getName();?></h1></div>
                <hr>
                <p><h3>Exciting tour is awaiting for you. Please login to book a tour.</h3></p>
                <img src="<?=IMG?>workout/2.jpg">
                <? } else if($pageObj->allowBooking($loginUserObj)) { ?>
                <img alt="" class="img-circle avatar-86" src="<?= $clubObj->getAvatarImageUrl();?>">
                <div class="directory_profile_name green mb0 mt20"><h1><?= $clubObj->getName();?></h1></div>
                <div class="directory_speciality mb20 font-medium">Select prefered date and time</div>
                <!-- Controls -->
                <div id="timetable-tour" class="carousel slide timetable-carousel position-relative" data-wrap="false" data-interval="false">
                    <a class="timetable-control go-left green" href="#tour" role="button" data-slide="prev"><i class="icon-arrow_left"></i></a>
                    <a class="timetable-control go-right green" href="#tour" role="button" data-slide="next"><i class="icon-arrow_right"></i></a>	
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?
                        for($i=1;$i<=60;$i=$i+7):?>
                        <div class="item<?=$i==1 ? ' active' : '';?>" style="">
                            <div class="days">
                                <? for($j=0;$j<=6;$j++):?>
                                <? $daystr = ' +'.$i+$j.' days';?>
                                <div class="rown"><span class="fs18 font-book"><?= date('l',strtotime($daystr));?></span><br />
                                    <span class="fs10 font-medium"><?= date('d/m',strtotime($daystr));?></span></div>
                                <? $days[$j] = date('N',strtotime($daystr));?>
                                <? $date[$j] = date('m/d/Y',strtotime($daystr));?>
                                <? endfor;?>
                                <div class="clearfix"></div>
                            </div>
                            <div class="hours">  
                                <? for($h=strtotime($modelSettings->getMinTime($clubObj->getId()));$h<=strtotime($modelSettings->getMaxTime($clubObj->getId()));$h=$h+3600):?>
                                <? $x=0;?>
                                <? foreach($days as $day):?>
                                <div class="rown">
                                    <div class="hour hour-active tour" data-date="<?=$date[$x].' '.date('H:i:s',$h);?>"><?=date('h:i A',$h);?></div>
                                </div>
                                <? $x++;?>   
                                <? endforeach;?>
                                <div class="clearfix"></div>
                                <? endfor;?>
                            </div>
                        </div>
                        <? endfor;?>
                    </div>
                    <div class="text-center">
                        <form id="tour" class="book" action="<?=PATH;?>order/booking/<?=$clubObj->getRoute();?>" method="post">
                            <input type="hidden" name="type" value="tour" />
                            <input type="hidden" name="submit" value="add" />
                            <input type="hidden" name="trainer" value="<?=$clubObj->getId();?>" />
                            <? if($order == 'disable'):?>
                            <span style="color:#F00;">For book first checkout for other club or empty your cart!</span>
                            <? else: ?>
                            <div class="staff">
                                <input type="submit" class="directory_profile-button directory_profile-button_orange mb10 w176" style="margin-top:0;" value="BOOK A TOUR" disabled="disabled" /></div>
                            <? endif;?>
                        </form>
                    </div>
                </div>
                <? } else { ?>
                <div class="directory_profile_name green mb0 mt20"><img alt="" class="img-circle avatar-86" src="<?= $clubObj->getAvatarImageUrl() ?>"><h1><?= $clubObj->getName();?></h1></div>
                <hr>
                <p><h3>Sorry, this feature is not available at this time.</h3></p>
                <img src="<?=IMG?>workout/2.jpg">
                <? } ?>
            </div>
        </div>
    </div>
</div>
