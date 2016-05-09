<div class="page-container">
    <?= $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>My Classes</h1>
                </div>
            </div>
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?= PATH;?>dashboard">Dashboard</a>
                <i class="fa fa-circle"></i>
                </li>
                <li>Bookings<i class="fa fa-circle"></i></li>
                <li>
                <a href="<?= PATH;?>myclass/list">My Classes</a>
                </li>
            </ul>
            <div class="clearfix"></div>

            <div class="tabbable-line">
<!--
                <ul class="nav nav-tabs">
                    <li class="active">
                    <a href="#class" data-toggle="tab">
                        Class </a>
                    </li>
                </ul>
                -->
            </div>

            <div class="tab-content">
                <div class="tab-pane fade active in" id="class">

                    <div class="gh-caption">
                        <i class="fa fa-trophy"></i> <?= $myClassObj->getName(); ?>
                    </div>
                    <div class="row margin-top-10">
                        <div class="col-md-12">
                            <!-- BEGIN PROFILE SIDEBAR -->
                            <div class="profile-sidebar">
                                <!-- PORTLET MAIN -->
                                <?= Partial::portlet_user_large($loginUserObj, __('TRAINER'), $trainerObj); ?>
                                <!-- END PORTLET MAIN -->
                                <!-- PORTLET MAIN -->
                                <!-- END PORTLET MAIN -->
                            </div>
                            <!-- END BEGIN PROFILE SIDEBAR -->

                            <div class="col-md-5">
                                <!-- BEGIN PORTLET -->
                                <div class="portlet light">
                                    <div class="portlet-title">
                                        <span class="caption-subject font-blue-madison bold uppercase">CLASS INFO</span>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="gh-title">Name</div>
                                        <div class="gh-value"><?= $myClassObj->getName() ?></div>
                                        <div class="gh-title">Date</div>
                                        <div class="gh-value"><?= $myClassObj->getDateFrom() ?> - <?= $myClassObj->getDateTo() ?></div>
                                        <div class="gh-title">Time</div>
                                        <div class="gh-value"><?= $myClassObj->getTimeFrom() ?> - <?= $myClassObj->getTimeTo() ?></div>
                                        <div class="gh-title">Days</div>
                                        <div class="gh-value"><?= $myClassObj->getWeekdays() ?></div>
                                        <div class="gh-title">Location</div>
                                        <? $locationObj = $myClassObj->getLocationObj();  ?>
                                        <div class="gh-value"><?= $locationObj ? $locationObj->getFullName():'' ?></div>
                                    </div>
                                </div>
                                <!-- END PORTLET -->
                            </div>

                            <div class="col-md-4">
                                <?= Partial::member_list_portlet($loginUserObj, 'MEMBERS', $memberObjs); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
