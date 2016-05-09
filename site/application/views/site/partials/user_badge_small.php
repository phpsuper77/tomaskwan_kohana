<? if($userObj):?>
<div class="user-badge-small">
    <div class="avatar">
        <img class="img-circle avatar-40" src="<?= $userObj->getAvatarImageUrl(); ?>">
    </div>
    <div class="name">
        <? if ($userObj->getPageObj()) { ?>
        <a class="primary-link" href="<?= $userObj->getPageObj()->getPageUrl() ?>"><?= $userObj->getTruncatedName($truncate); ?></a>
        <? } else { ?>
        <?= $userObj->getTruncatedName($truncate); ?>
        <? } ?>
    </div>
</div>
<? endif;?>
