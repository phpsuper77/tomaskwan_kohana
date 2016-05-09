<? if($userObj):?>
<div class="user-badge">
    <div class="badge-avatar">
        <img class="img-circle avatar-40" src="<?= $userObj->getAvatarImageUrl(); ?>">
    </div>
    <span class="badge-name"><a class="primary-link" href="<?= $userObj->getPageObj()->getPageUrl() ?>"><?= $userObj->getName(); ?></a></span>
<? if($showSuperior):?>
<? $superiorObj = $userObj->getSuperiorObj(); ?>
<? if($superiorObj):?>
    <div class="badge-superior">
    <? if($superiorObj->getRoute()):?>
        <br /><small><a href="<?=$superiorObj->getPageUrl();?>" class="primary-link"><?=$superiorObj->getName();?></a></small>
    <? else:?>
        <br /><small><?=$superiorObj->getName();?></small>
    <? endif;?>
    </div>
<? endif;?>
<? endif;?>
</div>
<? endif;?>
