<? if(count($staffObjs) > 0):?>
<? foreach($staffObjs as $obj):?>
    <? $staffObj = $obj->getUserObj(); ?>
    <? $pageObj = $staffObj->getPageObj(); ?>
<tr class="invite-<?=$staffObj->getId();?>">

    <td>
        <?= Partial::user_badge_small($loginUserObj, $staffObj); ?>
    </td>
    <td><?=__('ROLE_'.$staffObj->getRole());?><br /><small><?=$staffObj->getTitle();?></small></td>
    <td><?=$staffObj->getCreateDate();?></td>
    <td><?=$staffObj->getActiveDate();?></td>
    <td>
        <div class="btn-group" style="position:absolute;">
            <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
            </span></a>
            <ul class="dropdown-menu pull-right">
                <? if($staffObj->getId() != $loginUserObj->getId()):?>
                <li><a href="#" data-toggle="modal" data-target="#messageModal2" data-user="<?=$staffObj->getId();?>" data-name="<?=$staffObj->getName();?>" data-avatar="<?=$staffObj->getAvatarImageUrl() ;?>"><?=__('MESSAGE')?></a></li>
                <? endif;?>
                <li><a href="/staff/disconnect/<?=$staffObj->getId();?>"><?=__('DISCONNECT')?></a></li>
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
<tr><td align="center" colspan="6"><?=__('NO_STAFF')?></td></tr>
<? endif;?>
