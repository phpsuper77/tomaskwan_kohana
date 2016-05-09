<div id="boxes">
    <a href="<?=PATH;?>page/<?=$route;?>" id="back-to-profile" class="font-medium"><i class="icon-arrow_left"></i>BACK TO PROFILE</a>
    <div class="container">			
        <div class="text-center">
            <h1 class="main-h3 ttn">Full Schedule</h1>
            <h2 class="main-h4 ttn">Book Classes</h2>
        </div>
        <div class="col-xs-12">
            <div class="profile_container">
                <div id="timetable-schedule" class="carousel slide schedule-carousel" data-wrap="false" data-interval="false">
                    <a class="timetable-control go-left green" href="#schedule" role="button" data-slide="prev"><i class="icon-arrow_left"></i></a>
                    <a class="timetable-control go-right green" href="#schedule" role="button" data-slide="next"><i class="icon-arrow_right"></i></a>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">

                        <? for($i=1;$i<=60;$i=$i+7):?>
                        <!-- WEEK -->
                        <div class="item<?=$i==1 ? ' active' : '';?>" style="">
                            <div class="weekname text-center fs18 font-medium  mb50"><?= date('F, Y',strtotime('+'.$i.'days'));?></div>

                            <div class="mb10">
                                <ul class="days">
                                    <? for($j=0;$j<=6;$j++):?>
                                    <? $daystr = ' +'.$i+$j.' days';?>
                                    <li class="text-center"><div class="fs18 font-book"><?= date('l',strtotime($daystr));?></div><div class="fs10 font-medium">
                                        <?= date('d/m',strtotime($daystr));?></div></li>
                                    <? $day[$j] = date('N',strtotime($daystr));?>
                                    <? $date[$j] = date('m/d/Y',strtotime($daystr));?>
                                    <? endfor;?>
                                </ul>
                                <div class="clearfix"></div>
                            </div>

                            <? foreach($classObjs as $classObj):?>
                                <? $trainerObj = $classObj->getTrainerObj(); ?>
                            <ul class="days hours">
                                <? for($k=0;$k<=6;$k++):?>
                                <li id="<?=$classObj->getAttr('id');?>" style="cursor:pointer;">
                                <? if(in_array($day[$k],unserialize($classObj->getAttr('week'))) && ($classObj->getAttr('date_to') == NULL || strtotime($classObj->getAttr('date_to'))>=strtotime($date[$k]))):?>
                                <div class="font-bold green"><?=$classObj->getAttr('name');?></div>
                                <? if($loginUserObj && $modelOrder->checkBooking($date[$k],NULL,$loginUserObj->getId(),$classObj->getAttr('id')) == FALSE):?>
                                <div class="details font-medium">
                                    <?=date('h:ia',strtotime($classObj->getAttr('time_from')));?> - <?=date('h:ia',strtotime($classObj->getAttr('time_to')));?><br />
                                    Trainer: <?=$trainerObj->getName();?><br />
                                    Rm: <?=$classObj->getAttr('room');?><br />
                                    Expiried: <?=$classObj->getAttr('date_to')==NULL ? 'No expire' : date('m/d/Y',strtotime($classObj->getAttr('date_to')));?>
                                </div>
                                <div class="action dn" style="cursor:pointer;">
                                    <div class="directory_profile-button directory_profile-button_orange no-margin fs10" data-date="<?=$date[$k];?>" data-class="<?=$classObj->getAttr('id');?>">SIGNED</div>
                                </div>
                                <? else :?>
                                <p class="signed">ALREADY SIGNED</p>
                                <? endif;?>
                                <? endif;?>
                                </li>
                                <? endfor;?>
                            </ul>
                            <div class="clearfix"></div>	
                            <? endforeach;?>					
                        </div>

                        <!-- END WEEK -->
                        <? endfor;?>
                    </div>
<!---
                    <div class="text-center">
                        <form id="schedule" class="book" action="<?=PATH;?>order/booking/<?=$route;?>" method="post">
                            <input type="hidden" name="trainer" value="<?=$owner;?>" />
                            <input type="hidden" name="type" value="class" />
                            <input type="hidden" name="submit" value="add" />
                            <? if($loginUserObj && $loginUserObj->getRole() == Model_User::ROLE_USER):?>
                            <? if($order == 'disable'):?>
                            <span style="color:#F00;">For book first checkout for other club or empty your cart!</span>
                            <? else: ?>
                            <?= $age==TRUE ? '<input type="submit" class="directory_profile-button directory_profile-button_orange mb10 w176" value="BOOK CLASS" disabled="disabled" />' : '';?>
                            <? endif;?>
                            <? endif;?>
                        </form>
                    </div>
--->
                </div>
            </div>
        </div>
        <div class="clearfix"></div>			
    </div>
</div>
