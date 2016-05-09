<!-- BEGIN PORTLET-->
<div class="portlet light">
    <div class="portlet-title tabbable-line">
        <div class="caption caption-md"> <i class="icon-globe theme-font-color hide"></i> <span class="caption-subject theme-font-color bold uppercase"><?= $title ?></span> </div>
    </div>
    <div class="portlet-body">
<? if (count($connectionObj) > 0) { ?>
    <!--BEGIN TABS-->
        <div class="scroller" style="height: 337px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
            <ul class="feeds">
                <? foreach($connectionObjs as $connectionObj):?>
                <li>
                    <div class="col1">
                        <div class="cont">
                            <div class="cont-col1">
                                <div class="label label-sm label-info"> <i class="icon-user-following"></i> </div>
                            </div>
                            <div class="cont-col2">
                                <div class="desc">
                                    <span class="desc">
                                        Invitation sent by <a href="<?=PATH;?>page/<?=$connectionObj->getAttr('route');?>" class="margin-right-10"><?=$connectionObj->getTruncatedName();?></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col2">
                        <a href="#" class="connect-now btn btn-xs btn-success" data-invite="<?=$connectionObj->getAttr('user_invite');?>" data-url="<?=PATH;?>" data-mode="dashboard">Connect</a></span></span>
<!--
                        <div class="date"><?=timeElapse($connectionObj->getAttr('date'));?></div>
-->
                    </div>
                </li>
                <? endforeach;?>
            </ul>
        </div>
        <a href="/invite/list">MORE...</a>
    <? } else { ?>
        <p>No invites found.</p>
    <? } ?>
    </div>
</div>
