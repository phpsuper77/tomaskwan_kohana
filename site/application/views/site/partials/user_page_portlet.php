                            <div class="portlet light">
                                <div class="portlet-body">
<? if($userObj):?>
<div class="user-page-header">
    <div class="user-page-avatar">
        <img class="img-circle avatar-100" src="<?= $userObj->getAvatarImageUrl(); ?>">
    </div>
    <span class="user-page-name">
        <? if ($userObj->getPageObj()) { ?>
        <h3 class="green"><a class="primary-link" href="<?= $userObj->getPageObj()->getPageUrl() ?>"><?= $userObj->getTruncatedName(); ?></a></h3>
        <? } else { ?>
        <h3 class="gree"><?= $userObj->getTruncatedName(); ?></h3>
        <? } ?>
    </span>
<? $superiorObj = $userObj->getSuperiorObj(); ?>
<? if(false):?>
    <div class="user-page-superior">
        <div>Of</div>
    <? if($superiorObj->getRoute()):?>
       <a href="<?=$superiorObj->getPageUrl();?>" class="primary-link"><?=$superiorObj->getName();?></a>
    <? else:?>
       <?=$superiorObj->getName();?>
    <? endif;?>
    </div>
<? endif;?>
</div>
<? endif;?>
                                </div>
                              </div>
