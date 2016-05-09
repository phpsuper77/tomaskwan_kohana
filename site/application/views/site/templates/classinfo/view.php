<?= $addBookingModal ?>
<div id="boxes">
    <div class="container-schedule">			
            <!-- BEGIN PAGE BREADCRUMB -->
        <div class="row">
            <div class="col-md-12">
                <p>&nbsp;</p>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?=PATH;?>page/<?= $pageObj->getRoute(); ?>"><?= $userObj->getName() ?></a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?=PATH;?>classinfo/list/<?= $pageObj->getRoute(); ?>">Classes</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?=PATH;?>classinfo/view/<?= $classObj->getId(); ?>"><?= $classObj->getFullName() ?></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?= Partial::user_page_portlet($loginUserObj, $userObj); ?>
                <?= Partial::portlet_user_large($loginUserObj, __('TRAINER_INFO'), $trainerObj); ?>
            </div>
            <div class="col-md-6">
                <?= Partial::portlet_class($loginUserObj, __('CLASS_INFO'), $classObj); ?>
            </div>
            <div class="col-md-3">
                <?= Partial::portlet_class_order($loginUserObj, __('ORDER_INFO'), $classObj); ?>
<div class="portlet light gh-portlet-event">
    <div class="portlet-body">
                                <img style="height:200px;width:200px;" class="" src="<?= $classObj->getImageUrl(); ?>">
    </div>
</div>
            </div>
        </div>
        <div class="row">
            <p><br/></p>
        </div>
    </div>
</div>
