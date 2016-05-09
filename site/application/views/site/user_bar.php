<nav class="navbar navbar-inverse">
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <div class="page-logo">

            <div class="menu-toggler sidebar-toggler<?= $toggler;?>">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>

        </div>
        <!-- NOTYFICATIONS -->
        <ul class="nav navbar-nav navbar-right notyfy">

            <? if($loginUserObj->isRoleServiceProvider()):?>
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <i class="icon-calendar icon-badges"></i>
                <span id="bbooking" class="badge badge-bg-lb"><?=count($bookingOrderObjs)>0 ? count($bookingOrderObjs) : '';?></span>
                <div class="clearfix"></div>
            </a>
            <ul class="dropdown-menu dropdown-menu-default user-bar" role="menu">   
                <? if(count($bookingOrderObjs)>0):?>
                <? $i=1;?>
                <? foreach($bookingOrderObjs as $bookingOrderObj):?>
                <li id="booking-<?= $bookingOrderObj->getId();?>">
                <? if($i==1):?>
                <div class="text-center notification-header">YOU HAVE NEW BOOKINGS:</div>
                <? endif;?>
                <div class="notification-row<?= $i%2==0 ? ' notification-row-color' : '';?>">
                    <div class="avatar-cont"> 
                        <img src="<?= $bookingOrderObj->getAvatarUrl() ? $bookingOrderObj->getAvatarUrl() : IMG.'logo_avatar.png';?>" class="img-circle" alt="" />
                    </div>
                    <div class="name-cont"> 
                        <div class="name-cont-txt"> <?= $bookingOrderObj->getUserName();?></div> 
                        <div class="directory_profile-miles"><?= $bookingOrderObj->getDate();?></div>
                    </div>	

                    <div class="action-cont text-right">
                        <div class="pull-right no-padding">
                            <div class="bthrow throw-to-basket" data-id="<?=$bookingOrderObj->getId();?>" data-url="<?=PATH;?>">
                                <i class="icon-remove"></i></div></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                </li>
                <? $i++;?>
                <? endforeach;?>
                <? else: ?>
                <li>
                <div class="text-center notification-header">YOU HAVEN'T NEW BOOKINGS</div>
                </li>
                <? endif;?>

                <li>
                <div class="notification-see-all notification-row-color text-center">
                    <a href="<?=PATH;?>booking/index" class="mr5">BOOKING TABLE</a> | <a href="<?=PATH;?>booking/calendar" class="ml5">BOOKING ON CALENDAR</a>
                </div>	
                </li>
            </ul>
            </li>
            <? endif;?>
            <!-- MAIL -->

            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <i class="icon-mail2 icon-badges"></i>
                <span id="bmessage" class="badge badge-bg-or"><?=count($messageObjs)>0 ? count($messageObjs) : '';?></span>
                <div class="clearfix"></div>
            </a>
            <ul class="dropdown-menu dropdown-menu-default user-bar" role="menu">
                <? if(count($messageObjs)>0):?>
                <? $i=1;?>
                <? foreach($messageObjs as $messageObj):?>
                <li>
                <? if($i>5):?>
                <div class="text-center notification-header"> <?= count($messageObjs) - 5 ?> more messages </div>
                <? break;?>	
                <? endif;?>	
                <? if($i==1):?>
                <div class="text-center notification-header">YOU HAVE NEW MESSAGES FROM:</div>
                <? endif;?>	
                <div class="notification-row<?= $i%2==0 ? ' notification-row-color' : '';?>">
                    <div class="avatar-cont"> 
                        <img src="<?= $messageObj->getAvatarUrl() ? $messageObj->getAvatarUrl() : IMG.'logo_avatar.png';?>" class="img-circle" alt="" />
                    </div>
                    <div class="name-cont"> 
                        <div class="name-cont-txt"> <?= $messageObj->getUserName();?></div>
                        <? $gcode = $mapObject->getGeoCode($messageObj->getAddress().' '.$messageObj->getCity().', '.$messageObj->getZip());?>
                        <div class="directory_profile-miles"><i class="glyphicon icon-position3"></i>
                            <?= round($mapObject->geoGetDistance($start['lat'],$start['lon'],$gcode['lat'],$gcode['lon']),1);?> miles</div>
                    </div>	

                    <div class="text-right directory_profile-miles">
                        <?= $messageObj->getDate();?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                </li>
                <? $i++;?>
                <? endforeach;?>
                <? else: ?>
                <li>
                <div class="text-center notification-header">YOU HAVEN'T NEW MESSAGES</div>
                </li>
                <? endif;?>

                <li>
                <div class="notification-see-all notification-row-color text-center">
                    <a href="<?=PATH;?>message/index">READ MESSAGES</a>
                </div>	
                </li>
            </ul>
            </li>

            <? if($loginUserObj->isRoleServiceProvider()):?>
            <!-- BELL -->
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <i class="icon-notification5 icon-badges"></i>
                <span id="breview" class="badge badge-bg-db"><?=count($reviewObjs)>0 ? count($reviewObjs) : '';?></span>
                <div class="clearfix"></div>
            </a>
            <ul class="dropdown-menu dropdown-menu-default user-bar" role="menu">
                <? if(count($reviewObjs)>0):?> 
                <? $j=1;?>
                <? foreach($reviewObjs as $reviewObj):?>
                <li id="review-<?= $reviewObj->getId();?>">
                <? if($j==1):?>
                <div class="text-center notification-header">YOU HAVE NEW REVIEWS:</div>
                <? endif;?>
                <div class="notification-row<?= $j%2==0 ? ' notification-row-color' : '';?>">
                    <div class="avatar-cont"> 
                        <img src="<?= $reviewObj->getAvatarUrl() ? $reviewObj->getAvatarUrl() : IMG.'logo_avatar.png';?>" class="img-circle" alt="" />
                    </div>
                    <div class="name-cont"> 
                        <div class="name-cont-txt"> <?= $reviewObj->getName();?></div>
                        <div class="stars">
                            <? for($i=0;$i<round($review['global']);$i++):?><i class="fa fa-star"></i><? endfor;?>
                        </div>
                    </div>
                    <div class="action-cont text-right pull-left">
                        <a href="#" class="notification-button notification-button-dblue text-center" data-toggle="modal" data-target="#reviewModal" data-name="<?= $reviewObj->getName();?>" data-avatar="<?= $reviewObj->getAvatarUrl() ? $reviewObj->getAvatarUrl() : IMG.'logo_avatar.png';?>" data-global="<?=$reviewObj->getAttr('global');?>" data-facility="<?=$reviewObj->getAttr('facility');?>" data-service="<?=$reviewObj->getAttr('service');?>" data-clean="<?=$reviewObj->getAttr('clean');?>" data-vibe="<?=$reviewObj->getAttr('vibe');?>" data-knowledge="<?=$reviewObj->getAttr('knowledge');?>" data-like="<?=$reviewObj->getAttr('like');?>" data-text="<?=$reviewObj->getText();?>" data-role="<?= $reviewObj->getAttr('role')==Model_User::ROLE_TRAINER ? 'facility' : 'trainer';?>" data-id="<?= $reviewObj->getId();?>" data-url="<?=PATH;?>">DETAILS</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                </li>
                <? $j++;?>
                <? endforeach;?>
                <? else:?>
                <li>
                <div class="text-center notification-header">YOU HAVEN'T NEW REVIEWS</div>
                </li>
                <? endif;?>            
                <li>
                <div class="notification-see-all notification-row-color text-center">
                    <a href="<?=PATH;?>user/list/reviews">READ ALL REVIEWS</a>
                </div>	
                </li>
            </ul>
            </li>
            <? endif;?>

            <!-- INVITATIONS -->
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <i class="icon-new_connections icon-badges"></i>
                <span id="binvite" class="badge badge-bg-gr"><?=count($invitationObjs)>0 ? count($invitationObjs) : '';?></span>
                <div class="clearfix"></div>
            </a>
            <ul class="dropdown-menu dropdown-menu-default user-bar" role="menu">
                <? if(count($invitationObjs)>0):?> 
                <? $j=1;?>
                <? foreach($invitationObjs as $invitationObj):?>
                <li class="invite-<?= $invitationObj->getId();?>">
                <? if($j==1):?>
                <div class="text-center notification-header">NEW CONNECTION INVITATIONS:</div>
                <? endif;?>
                <div class="notification-row<?= $j%2==0 ? ' notification-row-color' : '';?>">
                    <div class="avatar-cont"> 
                        <img src="<?= $invitationObj->getAvatarUrl() ? $invitationObj->getAvatarUrl() : IMG.'logo_avatar.png';?>" class="img-circle" alt="" />
                    </div>
                    <div class="name-cont"> 
                        <div class="name-cont-txt"> <?= $invitationObj->getName();?></div>
                        <? $gcode = $mapObject->getGeoCode($invitationObj->getAddress().' '.$invitationObj->getCity().', '.$invitationObj->getZip());?>
                        <div class="directory_profile-miles"><i class="glyphicon icon-position3"></i>
                            <?= round($mapObject->geoGetDistance($start['lat'],$start['lon'],$gcode['lat'],$gcode['lon']),1);?> miles</div>
                    </div>	

                    <div class="action-cont text-right">
                        <a href="#" class="connect-now notification-button notification-button-green text-center" data-invite="<?= $invitationObj->getId();?>" data-url="<?= PATH;?>">CONNECT</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                </li>
                <? $j++;?>
                <? endforeach;?>
                <? else:?>
                <li>
                <div class="text-center notification-header">YOU HAVEN'T NEW CONNECTION INVITATIONS</div>
                </li>
                <? endif;?>
                <li>
                <div class="notification-see-all notification-row-color text-center">
                    <a href="<?=PATH;?>invite/list" class="mr5">ALL INVITATIONS</a> | <a href="<?=PATH;?>connection/list" class="ml5">YOUR CONNECTIONS</a>
                </div>	
                </li>
            </ul>
            </li>

            <? if($loginUserObj->isRoleUser()):?>
            <!-- CART -->
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="height:53px;">
                <i class="fa fa-shopping-cart cart" style="line-height:22px;"></i>
                <span id="binvite" class="badge badge-bg-gr"><?=count($orderItemObjs)>0 ? count($orderItemObjs) : '';?></span>
                <div class="clearfix"></div>
            </a>
            <div class="clearfix"></div>
            <ul class="dropdown-menu dropdown-menu-default user-bar" role="menu" style="width:340px;">   
                <li>
                <div class="text-center notification-header">YOUR CART:</div>
                <? if(count($orderItemObjs)>0):?>
                <table class="table carto">
                    <tr>
                        <td colspan="4" align="center">
                            <img class="img-circle avatar-40" src="<?= $clubObj->getAvatarImageUrl();?>" class="img-circle" alt="" />
                            <strong><?=$clubObj->getName();?></strong>
                        </td>
                    </tr>
                    <? foreach($orderItemObjs as $orderItemObj):?>
                    <tr>
                        <td>
                            <? if($orderItemObj->getAttr('type')=='specoffer'):?>
                            Special offer
                            <? else:?>
                            <?=ucfirst($orderItemObj->getAttr('type'));?>
                            <? endif;?>
                        </td>
                        <td>
                            <? if($orderItemObj->getAttr('type')=='specoffer'):?>
                            <?=$orderItemObj->getTruncatedAttr('name');?>
                            <? else:?>
                            <?=date('m/d/Y h:i a',strtotime($orderItemObj->getAttr('date')));?>
                            <? endif;?>
                        </td>
<?$price = $orderItemObj->getAttr('price');?>
                        <td>$<?=$price;?></td>
                        <td><div class="throw-to-basket"><a href="<?=PATH;?>cart/delete_orderitem/<?=$orderItemObj->getAttr('id');?>"><i class="icon-remove"></i></a></div></td>
                    </tr>
                    <? $sum = $sum + $price;?>
                    <? endforeach;?>
                    <tr height="10"></tr>
                    <tr>
                        <td><strong>SUMMARY:</strong></td>
                        <td></td>
                        <td colspan="2">$<?=$sum;?></td>                      
                    </tr>  
                </table>
                </li>

                <li>
                <div class="notification-see-all notification-row-color text-center">
                    <a href="<?=PATH;?>cart/list" class="mr5">CHECKOUT</a>
                </div>	
                </li>
                <? else: ?>
                <li>
                <div class="notification-see-all notification-row-color text-center">
                    Your cart is empty.
                </div>	
                </li>           
                <? endif;?>
            </ul>
            </li>
            <!-- -->
            <? endif;?>

<? $session = Session::instance(); ?>
<? $login_as_id = $session->get('login_as.id'); ?>

            <li class="dropdown">
            <a href="#" class="dropdown-toggle bar-profile" data-toggle="dropdown" role="button" aria-expanded="false">
                <div class="avatar-cont"> 
                    <img src="<?= $loginUserObj->getAvatarImageUrl();?>" class="img-circle" alt="" />
                </div>
<? if ($login_as_id) { ?>
                <span><?= $loginUserObj->getTruncatedName();?> (LOGIN AS FROM <?= $session->get('login_as.name') ?>)</span>
<? } else { ?>
                <span><?= $loginUserObj->getTruncatedName();?></span>
<? } ?>
                <div class="clearfix"></div>
            </a>
            <ul class="dropdown-menu dropdown-menu-default user-menu user-bar" role="menu">
                <li><a href="/dashboard"><i class="icon-home"></i> Dashboard </a></li>
                <li><a href="/profile/account/<?= $loginUserObj->getId();?>"><i class="icon-user"></i> My Account </a></li>
                <li><a href="<?= $loginUserObj->getPageObj()->getPageUrl();?>"><i class="icon-globe"></i> My Profile </a></li>
                <li><a href="/message/index"><i class="icon-envelope"></i> Inbox </a></li>
                <!--<li class="divider"></li>-->
<? if ($login_as_id) { ?>
                <li><a href="/auth/login_as_back"><i class="fa fa-magic"></i> Back As <?= $session->get('login_as.name') ?> </a></li>
<? } ?>
                <li><a href="/auth/logout">Log Out</a></li>
            </ul>
            </li>
        </ul>
    </div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>
