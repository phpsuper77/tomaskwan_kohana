<!-- BEGIN PORTLET -->
<div class="portlet light gh-portlet-event">
    <div class="portlet-title">
        <span class="caption-subject font-blue-madison bold uppercase"><?= $title ?></span>
    </div>
    <div class="portlet-body">
        <div class="gh-title"><?= __('ID') ?></div>
        <div class="gh-value"><?= $locationObj->getId() ?></div>
        <div class="gh-title"><?= __('ADDRESS') ?></div>
        <div class="gh-value"><?= $locationObj->getAddress() ?></div>
        <div class="gh-title"><?= __('CITY') ?></div>
        <div class="gh-value"><?= $locationObj->getCity() ?></div>
        <div class="gh-title"><?= __('STATE') ?></div>
        <div class="gh-value"><?= $locationObj->getState() ?></div>
        <div class="gh-title"><?= __('ZIP') ?></div>
        <div class="gh-value"><?= $locationObj->getZip() ?></div>
        <div class="gh-title"><?= __('ROOM') ?></div>
        <div class="gh-value"><?= $locationObj->getRoom() ?></div>
        <div class="gh-title"><?= __('NOTE') ?></div>
        <div class="gh-value"><?= $locationObj->getNote() ?></div>
        <div class="gh-title"><?= __('STATUS') ?></div>
        <div class="gh-value">
            <span class="label label-sm<?=$locationObj->getStatus() == 1 ? ' label-success' : ' label-danger';?>">
            <?= $locationObj->getStatus()==1?'Active':'Inactive';?></span>
        </div>
    </div>
</div>
<!-- END PORTLET -->
