<div class="page-container">
    <?= $sidebar;?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>Calendar</h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>

            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?= PATH;?>dashboard">Dashboard</a>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                Booking
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <a href="<?= PATH;?>booking/calendar">Calendar</a>
                </li>

            </ul>
            <div class="clearfix"></div>
            <?=$bookingInfoModal;?>
            <!-- END PAGE BREADCRUMB -->
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md margin-right-10">
                                <i class="icon-bar-chart theme-font-color hide"></i>
                                <span class="caption-subject theme-font-color bold uppercase">Calendar</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                <a aria-expanded="true" href="#tab_1_1" data-toggle="tab">Day</a>
                                </li>
                                <li>
                                <a href="#tab_1_2" data-toggle="tab">Week</a>
                                </li>
                            </ul>          
                        </div>
                        <div class="portlet-body" style="height: auto;">
                            <div class="tab-content">
                                <!-- DAY TAB -->
                                <div class="tab-pane active" id="tab_1_1">

                                    <!-- DAY CALENDAR -->
                                    <div id="day_calendar" class="carousel slide schedule-carousel" data-wrap="false" data-interval="false">
                                        <a class="timetable-control go-left green" href="#day_calendar" role="button" data-slide="prev">
                                            <i class="icon-arrow_left"></i></a>
                                        <a class="timetable-control go-right green" href="#day_calendar" role="button" data-slide="next">
                                            <i class="icon-arrow_right"></i></a>
                                        <!-- Wrapper for slides -->
                                        <div class="carousel-inner" role="listbox">
                                            <? for($i=0;$i<=31;$i++):?>
                                            <!-- DAY -->
                                            <div class="item<?=$i==0 ? ' active' : '';?>" style="">
                                                <div class="weekname text-center fs18 font-medium mb10"><?=date('d F, Y (l)',strtotime('+'.$i.'days'));?></div>
                                                <table class="table table-light calendar">
                                                    <thead>
                                                        <tr>
                                                            <? foreach($trainerObjs as $trainerObj):?>
                                                            <td align="center"><h4><?=$trainerObj->getName();?></h4></td>
                                                            <? endforeach;?>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="max-height:300px;">
                                                        <? for($h=strtotime($modelSettings->getMinTime($loginUserObj->getId()));$h<strtotime($modelSettings->getMaxTime($loginUserObj->getId()));$h=$h+900):?>
                                                        <tr >

                                                            <? foreach($trainerObjs as $trainerObj):?>	
                                                            <? if($m>0 && $trainerObj->getId() == $cid):?>
                                                            <? $m--;?>
                                                            <? elseif($n>0 && $trainerObj->getId() == $bid):?>
                                                            <? $n--;?>
                                                            <? else:?>
                                                            <? $booking = $modelOrder->checkBooking(date('m/d/Y',strtotime('+'.$i.'days')).' '.date('H:i:s',$h),$trainerObj->getId());?>										
                                                            <? $class = $modelClass->checkClass(date('H:i:s',$h),date('Y-m-d',strtotime('+'.$i.'days')),date('N',strtotime('+'.$i.'days')),$trainerObj->getId());?>														
                                                            <? if($booking==FALSE && $class==FALSE):?>
                                                            <td align="center"><?=date('h:i a',$h);?> - <?=date('h:i a',$h+900);?></td>                   
                                                            <? else:?>
                                                            <? if($class!=FALSE):?>
                                                            <? $cid = $trainerObj->getId();?>
                                                            <? $m=(strtotime($class['time_to'])-strtotime($class['time_from']))/900;?>
                                                            <td class="cal-check" rowspan="<?=$m;?>" align="center" style="padding:0;">
                                                                <p><?=date('h:i a',$h);?> - <?=date('h:i a',$h+$m*900);?></p>
                                                                <p>CLASS</p>
                                                                <p><?=$class['name'];?></p>
                                                            </td>
                                                            <? $m--;?>
                                                            <? else:?>
                                                            <? $bid = $trainerObj->getId();?>
                                                            <? $n=$trainerObj->getAttr('session')/900;?>
                                                            <td rowspan="<?=$n;?>" align="center" style="padding:0;">
                                                                <button class="btn green binfo" style="padding:<?=$n*14;?>px 25px;" data-toggle="modal" data-target="#bookingInfoModal" data-name="<?=$booking['name'];?>" data-avatar="<?=$booking['avatar'] ? Kohana::$config->load('site.s3.url')."/users/".$booking['uid']."/avatar/". $booking['avatar'] : IMG.'logo_avatar.png';?>" data-route="<?=PATH;?>page/<?=$booking['route'];?>"><?=date('h:i a',$h);?> - <?=date('h:i a',$h+$n*900);?><br />Booking</button>
                                                            </td>
                                                            <? $n--;?>
                                                            <? endif;?>                                                      
                                                            <? endif;?>
                                                            <? endif;?>
                                                            <? endforeach;?>
                                                        </tr>
                                                        <? endfor;?>  
                                                    </tbody>
                                                </table>
                                            </div>
                                            <? endfor;?>
                                        </div>
                                    </div>
                                </div>
                                <!-- WEEK TAB -->
                                <div class="tab-pane" id="tab_1_2">
                                    <select id="trainer_book" class="form-control" name="trainer_id">
                                        <option>Choose trainer</option>
                                        <? foreach($trainerObjs as $trainerObj):?>
                                        <option data-price="<?=$trainerObj->getAttr('price');?>" value="<?=$trainerObj->getId();?>"><?=$trainerObj->getName();?> - <?=$trainerObj->getAttr('title');?> 
                                        </option>
                                        <? endforeach;?>
                                    </select>
                                    <input type="hidden" name="curl" value="<?=PATH;?>booking/table_calendar" />
                                    <input type="hidden" name="type" value="calendar" />
                                    <div id="progress" class="dn" style="text-align:center; margin-top:10px;">
                                        <i class="fa fa-spinner fa-pulse fa-2x"></i></div>
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>

            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
