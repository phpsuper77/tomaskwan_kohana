<div class="page-container">
    <?= $sidebar;?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head"> 
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>BOOKING SCHEDULE</h1>
                </div>
                <!-- END PAGE TITLE --> 
            </div>

            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li> <a href="<?= PATH;?>dashboard">Dashboard</a> <i class="fa fa-circle"></i> </li>
                <li> Marketing <i class="fa fa-circle"></i> </li>
                <li> <a href="<?= PATH;?>dashboard/schedule">Schedule</a> </li>
            </ul>
            <div class="clearfix"></div>
            <? $success = Cookie::get('success');?>
            <? if($success == 'editBooking'):?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                Booking successfully updated!</div>
            <? endif; ?>
            <? Cookie::delete('success');?>
            <!-- END PAGE BREADCRUMB --> 
            <!-- END PAGE HEADER--> 
            <!-- BEGIN PAGE CONTENT-->
            <div class="row margin-top-10">
                <div class="col-md-12 col-sm-12"> 
                    <!-- BEGIN PORTLET-->
                    <div class="todo-content">
                        <div class="portlet light"> 
                            <!-- PROJECT HEAD -->
                            <div class="portlet-title porlet-title-schedule">
                                <div class="caption"> <i class="icon-bar-chart font-green-sharp hide"></i> <span class="caption-subject theme-font-color bold uppercase">SCHEDULE</span> </div>
                                <div class="actions"> <a title="" data-original-title="" class="btn btn-circle btn-default btn-icon-only fullscreen" href="#"></a> </div>
                            </div>
                            <!-- end PROJECT HEAD -->
                            <div class="portlet-body portlet-body-schedule">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="scroller" style="max-height: 900px;" data-always-visible="0" data-rail-visible="0" data-handle-color="#dae3e7">
                                            <div class="todo-tasklist">
                                                <?=$addBookingModal;?>
                                                <? foreach($bookingObjs as $bookingObj):?>
                                                <div class="todo-tasklist-item">
                                                    <div class="row">
                                                        <div class="col-xs-10">
                                                            <div class="avatar-schedule">
                                                                <? if($bookingObj->isTypeTour()):?>
                                                                <img class="todo-userpic pull-left" src="<?= $bookingObj->getTrainerAvatarUrl() ? $bookingObj->getTrainerAvatarUrl() : IMG.'logo_avatar.png';?>">
                                                                <? else:?>
                                                                <img class="todo-userpic pull-left" src="<?= $bookingObj->getOwnerAvatarUrl() ? $bookingObj->getOwnerAvatarUrl() : IMG.'logo_avatar.png';?>">
                                                                <? endif;?>
                                                            </div>
                                                            <div class="details-schedule">
                                                                <div class="todo-tasklist-item-title">
                                                                    <? if($bookingObj->isTypeClass()):?>
                                                                    CLASS: <?=$bookingObj->getAttr('cname');?>
                                                                    <? elseif($bookingObj->isTypeBooking()):?>
                                                                    <?=$bookingObj->getAttr('tname');?>
                                                                    <? else:?>
                                                                    TOUR
                                                                    <? endif;?>
                                                                </div>								
                                                                <div class="todo-tasklist-item-healthclub">
                                                                    <? if($bookingObj->isTypeTour()):?>
                                                                    <?=$bookingObj->getAttr('troute') ? '<a href="'.PATH.'page/'.$bookingObj->getAttr('troute').'">'.$bookingObj->getAttr('tname').'</a>' : $bookingObj->getAttr('tname');?> 
                                                                    <? else:?>
                                                                    <?=$bookingObj->getAttr('uroute') ? '<a href="'.PATH.'page/'.$bookingObj->getAttr('uroute').'">'.$bookingObj->getAttr('uoname').'</a>' : $bookingObj->getAttr('uoname');?>
                                                                    <? endif;?>
                                                                </div>
                                                                <? if($bookingObj->isTypeBooking()):?>
                                                                <div class="todo-tasklist-item-text"><?=$bookingObj->getAttr('title');?></div>
                                                                <? endif;?>
                                                                <div class="todo-tasklist-controls pull-left"> <span class="todo-tasklist-date">
                                                                        <i class="icon icon-calendar"></i> <?=date('d M Y',strtotime($bookingObj->getAttr('date')));?></span> <span class="todo-tasklist-date">
                                                                        <? if($bookingObj->isTypeBooking()):?>
                                                                        <i class="icon icon-clock"></i> <?=date('H:i A',strtotime($bookingObj->getAttr('date')));?> - <?=date('H:i A',strtotime($bookingObj->getAttr('date').' +'.$bookingObj->getAttr('session').' seconds'));?>
                                                                        <? elseif($bookingObj->isTypeClass()):?>
                                                                        <i class="icon icon-clock"></i> <?=date('H:i A',strtotime($bookingObj->getAttr('time_from')));?> - <?=date('H:i A',strtotime($bookingObj->getAttr('time_to')));?>
                                                                        <? else:?>
                                                                        <i class="icon icon-clock"></i> <?=date('H:i A',strtotime($bookingObj->getAttr('date')));?>								
                                                                        <? endif;?>
                                                                </span></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-2">
                                                            <div class="btn-group" style="position:absolute;">
                                                                <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle btn-actions-schedule" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down"></span></a>
                                                                <ul class="dropdown-menu pull-right" style="margin-top:15px;">
                                                                    <li><a href="#" data-toggle="modal" data-target="#messageModal2" data-user="<?= $bookingObj->getAttr('trainer_id');?>" data-name="<?= $bookingObj->getAttr('tname');?>" data-avatar="<?= $bookingObj->getTrainerAvatarUrl() ? $bookingObj->getTrainerAvatarUrl() : IMG.'logo_avatar.png';?>">Direct Message</a></li>
                                                                    <? if($bookingObj->getAttr('troute')):?>
                                                                    <li><a href="<?=PATH.'page/'.$bookingObj->getAttr('troute');?>">Visit Profile</a></li>
                                                                    <? endif;?>
                                                                    <? if($bookingObj->isTypeBooking()):?>
                                                                    <li><a href="#" data-toggle="modal" data-target="#addBookingModal" data-id="<?=$bookingObj->getId();?>" data-date="<?=date('m/d/Y H:i',strtotime($bookingObj->getAttr('date')));?>" data-trainer_id="<?=$bookingObj->getAttr('trainer_id');?>" data-user_id="<?=$bookingObj->getAttr('user_id');?>" data-form="<?=$bookingObj->getAttr('form');?>" data-mode="dashboard">Reschedule</a></li>
                                                                    <? endif;?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <? endforeach;?>
                                            </div>
                                        </div>
                                    </div>
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
