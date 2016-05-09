<div class="page-container">
    <?= $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1><?= __('MENU_MY_EVENTS') ?></h1>
                </div>
            </div>
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?= PATH;?>dashboard"><?= __('MENU_DASHBOARD') ?></a>
                <i class="fa fa-circle"></i>
                </li>
                <li>Bookings<i class="fa fa-circle"></i></li>
                <li>
                <a href="<?= PATH;?>myevent/list"><?= __('MENU_MY_EVENTS') ?></a>
                </li>
            </ul>
            <div class="clearfix"></div>

            <div class="tabbable-line">
<!--
                <ul class="nav nav-tabs">
                    <li class="active">
                    <a href="#main" data-toggle="tab">
                        Class </a>
                    </li>
                </ul>
                -->
            </div>

            <div class="tab-content">
                <div class="tab-pane fade active in" id="main">

                    <div class="row margin-top-10">
                        <div class="col-md-12">
                            <!-- BEGIN PROFILE SIDEBAR -->
                            <div class="col-md-3">
                                <!-- PORTLET MAIN -->
                                <?= Partial::portlet_user_large($loginUserObj, __('OWNER'), $ownerObj); ?>
                                <!-- END PORTLET MAIN -->
                                <!-- PORTLET MAIN -->
                                <!-- END PORTLET MAIN -->
                            </div>
                            <!-- END BEGIN PROFILE SIDEBAR -->

                            <div class="col-md-5">
                                <? if ($myEventObj->isTypeClass()) { ?>
                                <?= Partial::portlet_class($loginUserObj, __('CLASS_INFO'), $classObj, true); ?>
                                <? } ?>
                                <? if ($myEventObj->isTypeSession()) { ?>
                                <?= Partial::portlet_session($loginUserObj, __('SESSION_INFO'), $myEventObj); ?>
                                <? } ?>
                                <? if ($myEventObj->isTypeTour()) { ?>
                                <?= Partial::portlet_tour($loginUserObj, __('TOUR_INFO'), $myEventObj); ?>
                                <? } ?>
                            </div>
                            <div class="col-md-4">
                                <?= Partial::portlet_event($loginUserObj, __('EVENT_INFO'), $myEventObj); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
