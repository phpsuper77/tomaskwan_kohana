<div class="profile-userpic">
    <img src="<?= $userObj->getAvatarImageUrl();?>" class="img-responsive profile" alt="" />
</div>

<div class="profile-usertitle">
    <div class="profile-usertitle-name">
        <?= $userObj->getTruncatedName();?>
    </div>
    <div class="profile-usertitle-job">
        <?= __('ROLE_'.$userObj->getRole());?>
    </div>
    <? $superiorObj = $userObj->getSuperiorObj(); ?>
    <? if ($superiorObj): ?>
    <div class="profile-usertitle-job">
        <div>Of</div>
        <?= $superiorObj->getName();?>
    </div>
    <? endif; ?>
</div>

<!-- SIDEBAR BUTTONS -->
<div class="profile-userbuttons">
    <? if($userObj->getRoute()):?>
    <button onclick="window.location.href='<?=PATH;?>page/<?=$userObj->getRoute();?>';" class="btn btn-circle btn-success btn-sm">
        View Profile</button>
    <? endif;?>
    <? if($loginUserObj->getId() != $userObj->getId()):?>
    <button type="button" data-toggle="modal" data-target="#messageModal2" data-user="<?= $userObj->getId();?>" data-name="<?= $userObj->getName();?>" data-avatar="<?= $userObj->getAvatarImageUrl();?>" class="btn btn-circle btn-primary btn-sm">Direct Message</button>
    <? endif;?>
</div>
