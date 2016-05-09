<div class="page-container">
    <?= $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1><?=__('MENU_OFFERS')?></h1>
                </div>
            </div>
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?= PATH;?>dashboard"><?=__('MENU_DASHBOARD')?></a>
                <i class="fa fa-circle"></i>
                </li>
                <li><?=__('MENU_BOOKING')?><i class="fa fa-circle"></i></li>
                <li>
                <a href="<?= PATH;?>specoffer/list"><?=__('MENU_OFFERS')?></a>
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

                    <div class="gh-caption">
                        <i class="fa fa-trophy"></i> <?=__('OFFER')?> #<?= $offerObj->getId(); ?>
                    </div>
                    <div class="row margin-top-10">
                        <div class="col-md-12">
                            <!-- BEGIN PROFILE SIDEBAR -->
                            <!-- END BEGIN PROFILE SIDEBAR -->

                            <div class="col-md-4">
                                <!-- BEGIN PORTLET -->
                                <div class="portlet light">
                                    <div class="portlet-title">
                                        <span class="caption-subject font-blue-madison bold uppercase"><?=__('OFFER_INFO')?></span>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="gh-title"><?=__('NAME')?></div>
                                        <div class="gh-value"><?= $offerObj->getName() ?></div>
                                        <div class="gh-title"><?=__('TYPE')?></div>
                                        <div class="gh-value"><?= __('OFFER_TYPE_'.$offerObj->getAttr('category')) ?></div>
                                    </div>
                                </div>
                                <!-- END PORTLET -->
                            </div>

                            <div class="col-md-4">
                                <div class="portlet light">
                                    <div class="portlet-title">
                                        <span class="caption-subject font-blue-madison bold uppercase"><?=__('OFFER')?></span>
                                    </div>
                                    <div class="portlet-body">
                                        <img src="<?= $offerObj->getImageUrl(); ?>">
                                        <p>&nbsp;</p>
                                        <div class="gh-value"><?= $offerObj->getAttr('text') ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <?= Partial::member_list_portlet($loginUserObj, __('USERS'), $buyerObjs); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
