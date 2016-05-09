<div class="page-container">
    <?=$sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content"> 
            <!-- BEGIN PAGE HEADER--> 
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head"> 
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><?= __('MENU_DASHBOARD') ?></h1>
                </div>
                <!-- END PAGE TITLE --> 
            </div>
            <!-- END PAGE HEAD -->
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li><a href="<?=PATH;?>dashboard"><?= __('MENU_DASHBOARD') ?></a></li>
            </ul>

            <div class="row margin-top-10">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-green-sharp"><?=$countMember['members'];?></h3>
                                <small><?= __('MEMBERS_AND_CONNECTIONS') ?></small> </div>
                            <div class="icon"> <i class="icon-user-following"></i> </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress"> <span style="width: 100%;" class="progress-bar progress-bar-success green-sharp"> <span class="sr-only">76% progress</span> </span> </div>
                            <div class="status"> </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-blue-sharp"><small class="font-blue-sharp">$</small><?=$countRevenue['revenue'];?></h3>
                                <small><?= __('REVENUE') ?></small> </div>
                            <div class="icon"> <i class="icon-basket"></i> </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress"> <span style="width: 100%;" class="progress-bar progress-bar-success blue-sharp"> <span class="sr-only">45% grow</span> </span> </div>
                            <div class="status"> </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze"><?=$countVisit['visit'];?></h3>
                                <small><?= __('PROFILE_VISITS') ?></small> </div>
                            <div class="icon"> <i class="icon-eye"></i> </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress"> <span style="width: 100%;" class="progress-bar progress-bar-success red-haze"> <span class="sr-only">45% grow</span> </span> </div>
                            <div class="status"> </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze"><?=$countVisit['visit'];?></h3>
                                <small><?= __('EMAILS') ?></small> </div>
                            <div class="icon"> <i class="icon-eye"></i> </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress"> <span style="width: 100%;" class="progress-bar progress-bar-success red-haze"> <span class="sr-only">45% grow</span> </span> </div>
                            <div class="status"> </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze"><?=$countVisit['visit'];?></h3>
                                <small><?= __('SMS') ?></small> </div>
                            <div class="icon"> <i class="icon-eye"></i> </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress"> <span style="width: 100%;" class="progress-bar progress-bar-success red-haze"> <span class="sr-only">45% grow</span> </span> </div>
                            <div class="status"> </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6"> 
                    <? $data = array('status'=>Model_Event::STATUS_ACTIVE, 'order'=>'desc', 'sort'=>'id'); ?>
                    <?= Partial::portlet_user_events($loginUserObj, __('UPCOMING_EVENTS'), $data, 0, 5); ?>
                </div>
                <div class="col-md-6 col-sm-6"> 
                    <? $data = array(); ?>
                    <?= Partial::portlet_user_invites($loginUserObj, __('INVITATIONS'), $data, 0, 5); ?>
                    <? $data = array(); ?>
                    <?= Partial::portlet_user_reviews($loginUserObj, __('REVIEWS'), $data, 0, 5); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-12"> 
                </div>
                <div class="col-md-6 col-sm-6"> 
                </div>
            </div>
            <!--END TABS--> 
        </div>
    </div>
    <!-- END PORTLET--> 
</div>
      </div>
  </div>
    </div>
</div>
