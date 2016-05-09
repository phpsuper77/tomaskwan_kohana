<? $hostObj = $eventObj->getHostObj(); ?>

<!-- BEGIN PORTLET -->
<div class="portlet light gh-portlet-event">
    <div class="portlet-title">
        <span class="caption-subject font-blue-madison bold uppercase"><?= $title ?></span>
    </div>
    <div class="portlet-body">
        <div class="gh-title"><?= __('ID') ?></div>
        <div class="gh-value"><?= $eventObj->getId() ?></div>
        <div class="gh-title"><?= __('NAME') ?></div>
        <div class="gh-value"><?= $eventObj->getName() ?></div>
        <div class="gh-title"><?= __('TYPE') ?></div>
        <div class="gh-value"><?= $eventObj->getEventType() ?></div>
    </div>
</div>
<!-- END PORTLET -->
