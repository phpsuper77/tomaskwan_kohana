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
                        <i class="fa fa-trophy"></i> <?= $classObj->getName(); ?>
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
                                <?= Partial::portlet_class($loginUserObj, __('CLASS_INFO'), $classObj); ?>
                            </div>

                            <div class="col-md-4">
<div class="portlet light gh-portlet-event">
    <div class="portlet-body">
                                <img style="height:200px;width:200px;" src="<?= $classObj->getImageUrl(); ?>">
    </div>
</div>
    
                                <?= Partial::member_list_portlet($loginUserObj, __('MEMBERS'), $memberObjs); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
