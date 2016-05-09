<? if(count($inviteObjs) > 0):?>
<? foreach($inviteObjs as $inviteObj):?>
    <? $userObj = $inviteObj->getUserObj(); ?>
    <? $inviteUserObj = $inviteObj->getInviteUserObj(); ?>
<tr class="invite-<?=$inviteObj->getId();?>">
    <td>
        <?= Partial::user_badge_small($loginUserObj, $inviteUserObj); ?>
    </td>
    <td><?=__('ROLE_'.$inviteUserObj->getRole());?><br /><small><?=$inviteUserObj->getTitle();?></small></td>
    <td><?=$inviteUserObj->getCreateDate();?></td>
    <td><?=$inviteUserObj->getActiveDate();?></td>
    <td>
        <div class="btn-group" style="position:absolute;">
            <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
            </span></a>
            <ul class="dropdown-menu pull-right">
                <? if($inviteUserObj->getId() != $loginUserObj->getId()):?>
                <li><a href="#" data-toggle="modal" data-target="#messageModal2" data-user="<?=$inviteUserObj->getId();?>" data-name="<?=$inviteUserObj->getName();?>" data-avatar="<?=$inviteUserObj->getAvatarImageUrl();?>">Message</a></li>
                <? endif;?>
                <li><a href="/invite/connect/<?=$inviteUserObj->getId();?>"><?=__('CONNECT')?></a></li>
                <li><a href="/invite/delete/<?=$inviteUserObj->getId();?>"><?=__('DELETE')?></a></li>
            </ul>
        </div>
    </td>	
</tr>
<? endforeach;?>

<? if($pages):?>
<tr class="paginator">
    <td align="center" colspan="6"><?=$pages;?></td>
</tr>
<? endif;?>
<? else:?>
<tr>
    <td align="center" colspan="6"><?=__('NO_INVITES')?></td>
</tr>
<? endif;?>
