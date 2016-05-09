<? $hostObj = $eventObj->getHostObj(); ?>

<!-- BEGIN PORTLET -->
<div class="portlet light gh-portlet-event">
    <div class="portlet-title">
        <span class="caption-subject font-blue-madison bold uppercase"><?= $title ?></span>
    </div>
    <div class="portlet-body">
        <div class="gh-title"><?= __('START_TIME') ?></div>
        <div class="gh-value"><?= $eventObj->getUserTimeFrom() ?></div>
        <div class="gh-title"><?= __('END_TIME') ?></div>
        <div class="gh-value"><?= $eventObj->getUserTimeTo() ?></div>
        <div class="gh-title"><?= __('HOST') ?></div>
        <div class="gh-value"><?= Partial::user_badge_small($loginUserObj, $hostObj) ?></div>
<? $locationObj = $eventObj->getLocationObj() ?>
        <div class="gh-title"><?= __('LOCATION') ?></div>
        <div class="gh-value"><?= $locationObj?$locationObj->getFullname():'' ?></div>
    </div>
</div>
<!-- END PORTLET -->
