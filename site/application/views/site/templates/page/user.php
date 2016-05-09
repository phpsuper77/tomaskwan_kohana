<!-- IF back url == direcory -->
<!--
<a href="<?=PATH.$backUrl;?>" id="back-to-directory" class="font-medium"><i class="icon-arrow_left"></i>BACK</a>
-->
<!-- -->
<div class="profile_map cover" style="background-image: url(<?= $pageObj->getBackgroundUrl() ? $pageObj->getBackgroundUrl() : IMG.'slider_photo.jpg';?>)">
</div>
<div class="container">
    <div id="profile_main-informations">
        <div class="col-xs-6 no-padding">
            <div class="col-xs-6 text-center">
                <div class="img-circle take_avatar_to_map">
                    <div>
                        <img src="<?= $userObj->getAvatarImageUrl();?>" class="img-circle avatar-166" alt="" />
                    </div>
                </div>
                <? if($loginUserObj && $pageObj->getUserId() != $loginUserObj->getId()):?>
                <div class="directory_profile-miles text-center"><i class="glyphicon icon-position3"></i>1.4 miles</div>
                <? endif;?>
            </div>

            <div class="col-xs-6 no-padding">
                <div class="directory_profile_name green"><h1><?= $pageObj->getUserObj()->getTruncatedName();?></h1></div>
                <div class="directory_profile_address-div">
                    <div class="profile_address">
                        <?= $userObj->getCity() ? $userObj->getCity().', '.$userObj->getZip() : $userObj->getZip();?>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <? if($loginUserObj && $pageObj->getUserId() != $loginUserObj->getId()):?>
            <div class="col-xs-6 text-center">
                <? if($isConnect == false):?>
                <? if($isInvite == true):?>
                <div><a href="#" class="directory_profile-button directory_profile-button_book_appointment not-active"><?= __('INVITED') ?></a></div>
                <? else:?>
                <div><a href="<?=PATH; ?>user/" class="connect directory_profile-button directory_profile-button_book_appointment<?=$loginUserObj && $pageObj->getUserId() != $loginUserObj->getId() ? '' : ' not-active';?>" data-id="<?=$pageObj->getUserId();?>" data-action="invite">
                        <span id="progress-connect" class="dn"><i class="fa fa-spinner fa-pulse"></i></span>
                        <span id="text-connect"><?= __('CONNECT') ?></span></a></div>
                <? endif;?>
                <? else: ?>
                <div><a href="<?=PATH; ?>user/" class="connect directory_profile-button directory_profile-button_book_appointment" data-id="<?=$pageObj->getUserId();?>" data-action="disconnect">
                        <span id="progress-connect" class="dn"><i class="fa fa-spinner fa-pulse"></i></span>
                        <span id="text-connect"><?= __('DISCONNECT') ?></span></a></div>
                <? endif;?>
            </div>
            <div class="col-xs-6 no-padding">
<? if (!$loginUserObj) { ?>
                <a href="#" class="generic-modal-trigger directory_profile-button directory_profile-button_grey" data-toggle="modal" data-target="#genericModal" data-content="You must login to send direct messsage">
                    <?= __('DIRECT MESSAGE') ?></a>
<? } else { ?>
                <a href="#" class="directory_profile-button directory_profile-button_grey" data-toggle="modal" data-target="#messageModal2">
                    <?= __('DIRECT MESSAGE') ?></a>
<? } ?>
            </div>
            <div class="clearfix"></div>
            <? endif;?>
        </div>

        <div class="col-xs-6">				

            <? $userUnits = $userObj->getUnits();?>
            <? if(count($userUnits) > 0):?>
            <div class="user-amenities_container">
                <div class="font-bold mb10"><?= __('INTERESTS / ACTIVITIES') ?></div>
                <? foreach($units as $unit):?>
                <? if($userUnits[$unit['id']] == 1):?>
                <div class="main-amenities text-center pull-left">
                    <i class="<?= $unit['class'];?>"></i><br /><?= strtoupper($unit['name']);?></div>
                <? $i++;?>
                <? endif;?>
                <? endforeach;?>
                <div class="clearfix"></div>
            </div>
            <? endif;?>
        </div>
        <div class="clearfix"></div>		
    </div>
</div>

<section id="profile-main">
<div class="container">
    <div class="col-xs-8 profile_left_column">
        <? if($loginUserObj && $pageObj->getUserId() == $loginUserObj->getId()):?>	
        <div class="post_container new-post" style="padding-bottom:10px;">
            <div class="plr25">
                <form id="post-new" class="form-horizontal" role="form" action="#" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input class="form-control" placeholder="New status" type="text" name="subject" required="required" />
                        </div>
                    </div>

                    <div id="new_status" class="dn">
                        <div class="form-group">
                            <div class="col-md-12">	
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>		
                                    <span class="btn btn-warning fileinput-button"><i class="fa fa-plus"></i> <?= __('Add picture') ?>
                                        <input name="picture" type="file" /></span>
                                </div>
                            </div>
                        </div>		

                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea class="form-control" name="text"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12" style="text-align:center;">
                                <button class="status btn green" data-id="new" data-url="<?= PATH;?>page/status/<?=$pageObj->getRoute();?>" data-jsbase="<?=JS;?>" data-side="left"><?= __('Add') ?></button>
                                <button id="new_hide" class="btn default"><?= __('Hide') ?></button>
                            </div>
                        </div>
                    </div> 
                </form>
            </div>
        </div>
        <? endif;?>

        <? if(count($statusObjs) > 0):?>
        <? foreach($statusObjs as $statusObj):?>
        <div id="post-<?=$statusObj->getAttr('id');?>" class="post_container">
            <? if($loginUserObj && $pageObj->getUserId() == $loginUserObj->getId()):?>
            <div class="status-menu">
                <a href="" class="dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <span class="fa fa-angle-down"></span></a>
                <ul class="dropdown-menu pull-right" style="">
                    <li><a class="edit-post" href="#" data-id="<?=$statusObj->getAttr('id');?>"><?= __('Edit') ?></a></li>
                    <li><a class="delete-post" href="#" data-url="<?=PATH;?>page/delete_status/<?=$pageObj->getRoute();?>" data-id="<?=$statusObj->getAttr('id');?>">
                        Delete</a></li>
                </ul>
            </div>
            <? endif;?>
            <div class="plr25">
                <? if($statusObj->getPicUrl()):?>
                <div class="post-img"><img src="<?=$statusObj->getPicUrl();?>" alt="" /></div>
                <? endif;?>
                <div class="mt20 mb10">
                    <h3><?= $statusObj->getAttr('subject');?></h3>
                    <? if($statusObj->getAttr('share_id')):?>
                    <div class="post-taken-from"><i class="icon-share_post mr5"></i>
                        <a href="<?=PATH;?>page/<?=$statusObj->getAttr('route');?>" class="green font-medium"><?= $statusObj->getAttr('name');?></a></div>
                    <? endif;?>
                    <div class="clearfix"></div>
                </div>

                <div id="text-<?=$statusObj->getAttr('id');?>" class="fs12 lh18 font-book mb20">
                    <?=htmlspecialchars_decode($statusObj->getAttr('text'));?>
                </div>
                <div class="clearfix"></div>

                <div id="save-<?=$statusObj->getAttr('id');?>" class="form-group dn">
                    <div class="col-md-12" style="text-align:center; padding-top:10px; padding-bottom:10px;">
                        <button class="status btn green" data-id="<?=$statusObj->getAttr('id');?>" data-url="<?= PATH;?>page/status/<?=$pageObj->getRoute();?>">Save</button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <? $comments = $modelStatus->getCommentList($statusObj->getAttr('id'));?>
            <div id="actions-<?=$statusObj->getAttr('id');?>" class="post-actions">
                <div class="small_notifications plr25">
                    <div class="pull-left">
                        <div><i class="icon-post_time green"></i><span class="value ml5"><?=timeElapse(strtotime($statusObj->getAttr('date')));?> ago</span></div>
                    </div>
                    <div class="pull-left">
                        <? $slikes = $modelStatus->getLikeList($statusObj->getAttr('id'),'status');?>
                        <div class="pull-left"><span class="value like-value"><?= count($slikes);?></span>
                            <button type="button" class="icon-social like" title="Like" data-item="<?= $statusObj->getAttr('id');?>" data-category="status" data-url="<?=PATH;?>" <?= Auth::instance()->logged_in_user() && $modelStatus->checkLike($loginUserObj->getId(),$statusObj->getAttr('id'),'status') == FALSE ? '' : 'disabled="disabled"';?>>
                                <i class="icon-like ml5"></i></button>
                        </div>
                        <div class="pull-left"><span class="value count-comments"><?= count($comments);?></span>
                            <button type="button" id="<?= $statusObj->getAttr('id');?>" class="icon-social toggle-reviews" title="Comment"><i class="icon-comments ml5"></i></button></div>
                        <div class="pull-left no-margin"><span class="value"><?= (int)$statusObj->getAttr('shares');?></span>
                            <button type="button" class="icon-social" title="Share" data-toggle="modal" data-target="#shareStatusModal" data-share_id="<?= $statusObj->getAttr('user_id');?>" data-subject="<?= $statusObj->getAttr('subject');?>" data-id="<?= $statusObj->getAttr('id');?>" data-top_pic="<?= $statusObj->getAttr('top_pic');?>" data-text="<?= $statusObj->getAttr('text');?>" <?= Auth::instance()->logged_in_user() && $statusObj->getAttr('user_id') != $loginUserObj->getId() ? '' : ' disabled="disabled"';?>>
                                <i class="icon-share_post ml5"></i></button></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="dn hidden-reviews" id="review-<?= $statusObj->getAttr('id');?>">	
                <? if($loginUserObj):?>
                <div class="reviews-1-col">
                    <img src="<?= $loginUserObj->getAvatarImageUrl();?>" class="img-circle avatar-86" alt="" />
                </div>
                <div class="reviews-23-col">
                    <form id="add-comment-<?=$statusObj->getAttr('id');?>" action="<?=PATH;?>page/comment/<?=$pageObj->getRoute();?>" method="post">
                        <textarea name="text" placeholder="Write Comment Here" class="review-textarea comment-text"></textarea>
                        <div class="pull-right mt10">
                            <button id="comment" type="button" class="btn green" data-id="<?=$statusObj->getAttr('id');?>" data-url="<?= PATH;?>page/comment/<?=$pageObj->getRoute();?>" data-side="left">
                                <?= __('SEND') ?></button>
                        </div>
                    </form>
                </div>
                <? endif;?>
                <div class="clearfix"></div>
                <div id="new-comment-<?=$statusObj->getAttr('id');?>"></div>
                <? $i = 0;?>
                <? foreach($comments as $comment):?>
                <? if($i == 3):?>
                <div id="more-<?=$statusObj->getAttr('id');?>" class="dn">
                    <? endif;?>
                    <div class="review">
                        <div class="reviews-1-col">
                            <div class="review-avatar text-center">
                                <img src="<?= $comment['avatar'] ? Kohana::$config->load('site.s3.url')."/users/".$comment['user_id']."/avatar/". $comment['avatar'] : IMG.'logo_avatar.png';?>" class="img-circle avatar-86" alt="" />
                                <?= $comment['name'];?>
                            </div>	
                        </div>
                        <div class="reviews-23-col">
                            <div class="review-text">
                                <?= $comment['text'];?>
                            </div>
                            <div class="small_notifications mt20">
                                <div class="pull-left">
                                    <div><i class="icon-post_time green"></i><span class="value ml5"><?= date('d F Y',strtotime($comment['date']));?></span></div>
                                </div>
                                <div class="pull-left">
                                    <? $clikes = $modelStatus->getLikeList($comment['id'],'comment');?>
                                    <div class="pull-left"><span class="value like-value"><?= count($clikes);?></span>
                                        <button class="icon-social like" title="Like" data-item="<?= $comment['id'];?>" data-category="comment" data-url="<?=PATH;?>"<?= $loginUserObj && $modelStatus->checkLike($loginUserObj->getId(),$comment['id'],'comment') == FALSE ? '' : ' disabled="disabled"';?>>
                                            <i class="icon-like ml5"></i></button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>	
                    </div>
                    <? $i++;?>
                    <? endforeach;?>

                    <? if(count($comments) > 3):?>
                </div>		
                <div class="text-center pt45 load-more">
                    <a href="#" class="directory_profile-button directory_profile-button_view_profile no-margin w176 show-more" data-status="<?=$statusObj->getAttr('id');?>">
                        <?= __('LOAD MORE') ?>
                        <i class="icon-arrow_down"></i>
                    </a>
                </div>
                <? endif;?>			
            </div>	
        </div>
        <? endforeach;?>
        <? endif;?>

    </div>
    <div class="col-xs-4 profile_right_column">
        <!-- LATEST -->
<!---
        <div class="profile_container" id="latest-in-network">
            <h3 class="green no-margin"><?= __('Latest in Your Network') ?></h3>
            <div class="mb30"><?= __('Whats happening in Your network') ?></div>
            <? if(count($news) > 0):?>
            <? $j = 1;?>
            <? foreach($news as $new):?>
            <div class="comment">
                <div class="commment-avatar pull-left no-padding">
                    <img src="<?= $new['from_avatar'] ? Kohana::$config->load('site.s3.url')."/users/".$new['from_id']."/avatar/". $new['from_avatar'] : IMG.'logo_avatar.png';?>" class="img-circle" alt="" />
                </div>
                <div class="latest-text pull-left no-padding">
                    <div><a class="network" href="<?=PATH;?>page/<?= $new['from_route'];?>"><span class="fs13 green"><?= $new['from_name'];?></span></a> 
                        <?= $new['from_title'] ? '<span class="fs10 orange">'.$new['from_title'].'</span>' : '';?></div>
                    <? if($new['type'] == 'connect'):?>
                    and <a class="network" href="<?=PATH;?>page/<?= $new['to_route'];?>"><span class="darkblue">
                            <?= $new['to_name'];?></span></a> are connected now.
                    <? elseif($new['type'] == 'comment'):?>
                    commented on <a class="network" href="<?=PATH;?>page/<?= $new['to_route'];?>"><span class="darkblue">
                            <?= $new['to_name'];?></span></a> status.	
                    <? elseif($new['type'] == 'like_status'):?>
                    likes <a class="network" href="<?=PATH;?>page/<?= $new['to_route'];?>"><span class="darkblue">
                            <?= $new['to_name'];?></span></a> status. 
                    <? elseif($new['type'] == 'like_comment'):?>
                    likes <a class="network" href="<?=PATH;?>page/<?= $new['to_route'];?>"><span class="darkblue">
                            <?= $new['to_name'];?></span></a> comment.
                    <? endif;?>
                </div>	
                <div class="clearfix"></div>
            </div>
            <? $j++;?>
            <? if($j > 6) break;?>
            <? endforeach;?>
            <? endif;?>	
        </div>
-->

        <!-- DISCOVER -->
<!---
        <div class="profile_container" id="discover-network">
            <h3 class="orange no-margin "><?= __('Discover Your Network') ?> </h3>
            <div class="mb30"><?= __('Find people and places you might know') ?></div>
            <? if(count($discovers) > 0):?>
            <? $k = 0;?>
            <? foreach($discovers as $discover):?>
            <? if($k == 6):?>
            <div id="more-discover" class="dn">
                <? endif;?>
                <div class="comment">
                    <div class="commment-avatar pull-left no-padding">
                        <img src="<?= $discover['avatar'] ? Kohana::$config->load('site.s3.url')."/users/".$discover['id']."/avatar/". $discover['avatar'] : IMG.'logo_avatar.png';?>" class="img-circle" alt="" />
                    </div>
                    <div class="discover-text pull-left no-padding">
                        <div><span class="fs13 green"><?= $discover['name'];?></span></div>
                        <? if($discover['title']):?>
                        <div><span class="fs10 orange"><?= $discover['title'];?></span></div>
                        <? endif;?>
                        <div class="small_notifications no-margin">
                            <div><i class="icon-position3 green"></i><span class="value ml5"><?= $discover['distance'];?> miles</span></div>
                        </div>
                    </div>	
                    <div class="discover-button pull-left no-padding">
                        <a href="<?=PATH;?>page/<?= $discover['route'];?>" class="directory_profile-button directory_profile-button_view_profile">
                            <?= __('SEE PROFILE') ?>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <? endforeach;?>
                <? if(count($discovers) > 6):?>
            </div>
            <div class="text-center pt20">
                <a id="toggle-discover" href="#" class="directory_profile-button directory_profile-button_view_profile no-margin w176">
                    <?= __('DISCOVER MORE') ?>
                </a>
            </div>
            <? endif;?>
            <? endif;?>	
        </div>
-->
    </div>				
</div>
</section>
<?= $shareStatusModal;?>
