<? if(count($staffObjs) > 0):?>
<? foreach($staffObjs as $staffObj):?>
    <? $ownerObj = $staffObj->getHostObj(); ?>
    <? $pageObj = $ownerObj->getPageObj(); ?>
<tr class="invite-<?=$ownerObj->getId();?>">

    <td>
        <?= Partial::user_badge_small($loginUserObj, $ownerObj); ?>
    </td>
    <td><?=__('ROLE_'.$ownerObj->getRole());?><br /><small><?=$ownerObj->getTitle();?></small></td>
    <td><?=$ownerObj->getCreateDate();?></td>
    <td><?=$ownerObj->getActiveDate();?></td>
    <td>
        <div class="btn-group" style="position:absolute;">
            <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
            </span></a>
            <ul class="dropdown-menu pull-right">
                <? if($ownerObj->getId() != $loginUserObj->getId()):?>
                <li><a href="#" data-toggle="modal" data-target="#messageModal2" data-user="<?=$ownerObj->getId();?>" data-name="<?=$ownerObj->getName();?>" data-avatar="<?=$ownerObj->getAvatarImageUrl() ;?>"><?= __('MESSAGE') ?></a></li>
                <? endif;?>
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
<tr><td align="center" colspan="6"><?= __("NO_STAFF") ?></td></tr>
<? endif;?>
