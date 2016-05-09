<div class="portlet light">
    <div class="portlet-title">
        <span class="caption-subject font-blue-madison bold uppercase"><?= $title ?></span>
    </div>
    <div class="portlet-body">
    <!-- SIDEBAR USERPIC -->
    <div class="profile-userpic">
        <img src="<?= $userObj->getAvatarImageUrl();?>" class="img-responsive profile" alt="" />
    </div>
    <!-- END SIDEBAR USERPIC -->
    <!-- SIDEBAR USER TITLE -->
    <div class="profile-usertitle">
        <div class="profile-usertitle-name">
            <?= $userObj->getTruncatedName();?>
        </div>
        <div class="profile-usertitle-job">
            <?= __('ROLE_'.$userObj->getRole());?>
        </div>
    </div>
    <!-- SIDEBAR BUTTONS -->
    <div class="profile-userbuttons">
        <button onclick="window.location.href='<?=PATH;?>page/<?=$userObj->getPageObj()->getRoute();?>';" class="btn btn-circle btn-success btn-sm">
            View Profile</button>
<? if ($loginUserObj) { ?>
        <button type="button" data-toggle="modal" data-target="#messageModal2" data-user="<?= $userObj->getId();?>" data-name="<?= $userObj->getName();?>" data-avatar="<?= $userObj->getAvatarImageUrl();?>" class="btn btn-circle btn-primary btn-sm">Direct Message</button>
<? } ?>
    </div>
    <!-- END SIDEBAR BUTTONS -->
    <!-- SIDEBAR MENU -->
    <div class="profile-usermenu">
        <ul class="nav">
        </ul>
    </div>
    <!-- END SIDEBAR USER TITLE -->
    </div>

</div>
