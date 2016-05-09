<div class="portlet light">
    <div class="portlet-title">
        <div class="caption caption-md">
            <i class="icon-bar-chart theme-font hide"></i>
            <span class="caption-subject font-blue-madison bold uppercase"><?= $title ?></span>
        </div>
        <div class="inputs">
            <div class="portlet-input input-inline input-small ">
                <div class="input-icon right">
                </div>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-inline">
            <? foreach ($userObjs as $userObj) { ?>
            <li>
            <a href="<? $userObj->getPageObj()->getPageUrl(); ?>">
                <img alt="<?= $userObj->getName(); ?>" class="img-circle avatar-60" src="<?= $userObj->getAvatarImageUrl();?>">
            </a>
            </li>
            <? } ?>
        </ul>
    </div>
</div>
