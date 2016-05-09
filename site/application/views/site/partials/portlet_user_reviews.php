                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md"> <i class="icon-bar-chart theme-font-color hide"></i> <span class="caption-subject theme-font-color bold uppercase"><?= $title ?></span> </div>
                        </div>
                        <div class="portlet-body">
<? if (count($reviewObjs) > 0) { ?>
                            <div class="scroller" style="height: 305px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                <div class="general-item-list">
                                    <? foreach($reviewObjs as $reviewObj):?>
                                    <div class="item">
                                        <div class="item-head">
                                            <div class="item-details">
                                                <img class="item-pic" src="<?=$reviewObj->getOwnerObj()->getAvatarImageUrl();?>">
                                                <a href="<?=PATH;?>page/<?=$reviewObj->getAttr('route');?>" class="item-name primary-link"><?=$reviewObj->getName();?></a>
                                                <span class="item-label"><?=timeElapse(strtotime($reviewObj->getAttr('date')));?> ago</span>
                                            </div>
                                            <span class="item-status">
                                            </span>
                                        </div>
                                        <div class="item-body"><?=$reviewObj->getText();?></div>
                                    </div>
                                    <? endforeach;?>
                                </div>
                            </div>
<? } else { ?>
 <p>No reviews found.</p>
<? } ?>
                        </div>
                    </div>
