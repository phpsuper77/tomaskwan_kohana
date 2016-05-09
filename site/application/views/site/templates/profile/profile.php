<div class="page-container">
    <?= $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1><?= __("MENU_ACCOUNT_SETTINGS") ?></h1>
                </div>
            </div>
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?= PATH;?>dashboard"><?= __("MENU_DASHBOARD") ?></a>
                <i class="fa fa-circle"></i>
                </li>
                <li><?= __("MENU_ACCOUNT") ?><i class="fa fa-circle"></i></li>
                <li>
                <a href="<?= PATH;?>profile/account/<?= $profileUserObj->getId() ?>"><?= __("MENU_ACCOUNT_SETTINGS") ?></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            <div class="row margin-top-10">
                <div class="col-md-12">
                    <!-- BEGIN PROFILE SIDEBAR -->
                    <div class="profile-sidebar">
                        <!-- PORTLET MAIN -->
                        <div class="portlet light profile-sidebar-portlet">
                            <!-- SIDEBAR USERPIC -->
                            <?= Partial::user_portlet($loginUserObj, $profileUserObj) ?>

                            <!-- END SIDEBAR BUTTONS -->
                            <!-- SIDEBAR MENU -->
                            <div class="profile-usermenu">
                                <ul class="nav">
                                </ul>
                            </div>
                            <!-- END SIDEBAR USER TITLE -->

                        </div>
                        <!-- END PORTLET MAIN -->
                        <!-- PORTLET MAIN -->
                        <? if($profileUserObj->getRole() != 0):?>
                        <div class="portlet light">
                            <!-- STAT -->
                            <div class="row list-separated">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title">
                                        <?=$connects['members'];?>
                                    </div>
                                    <div class="uppercase profile-stat-text">
                                        Connects
                                    </div>
                                </div> 
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <? if($profileUserObj->getRole() != 4):?>
                                    <div class="uppercase profile-stat-title">
                                        <?=$bookings['bookings'];?>
                                    </div>
                                    <div class="uppercase profile-stat-text">
                                        Bookings
                                    </div>
                                    <? endif;?>
                                </div>  
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title">
                                        <?=$likes['likes'];?>
                                    </div>
                                    <div class="uppercase profile-stat-text">
                                        Likes 
                                    </div>
                                </div>
                            </div>
                            <!-- END STAT -->

                        </div>
                        <? endif;?>
                        <!-- END PORTLET MAIN -->
                    </div>
                    <!-- END BEGIN PROFILE SIDEBAR -->

                    <?= $profileContent;?>

                </div>
            </div>
        </div>
    </div>
</div>
