<? if(count($guserObjs) > 0):?>
<? foreach($guserObjs as $guserObj):?>
    <?
        $superiorObj = $guserObj->getSuperiorObj();
    ?>
<tr class="invite-<?=$guserObj->getId();?>">
    <td><?=$guserObj->getId();?></td>
    <td>
        <?= $guserObj->getShortName(); ?>
    </td>
    <td><a href="mailto:<?=$guserObj->getEmail();?>"><?=$guserObj->getEmail();?></a></td>
    <td><?=__('ROLE_'.$guserObj->getRole());?></td>
    <td><?=$guserObj->getTitle();?></td>
    <td><?=$guserObj->getCreateDate();?></td>
    <td><?=$guserObj->getActiveDate();?></td>
    <td><span class="label label-sm<?=$guserObj->getActive() == 1 ? ' label-success' : ' label-danger';?>">
            <?= $guserObj->getActive()==1?'Active':'Inactive';?></span></td>
    <td>
        <div class="btn-group" style="position:absolute;">
            <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
            </span></a>
            <ul class="dropdown-menu pull-right">
                <? if($guserObj->getActive() == 1):?>
                <li><a href="<?=PATH;?>alluser/user_deactivate/<?=$guserObj->getId();?>?page=<?=$filter['page']?>&sort=<?=$filter['sort']?>&order=<?=$filter['order']?>&role=<?=$filter['role']?>&enabled=<?=$filter['enabled']?>"><?= __("DEACTIVATE") ?></a></li>
                <? else:?>
                <li><a href="<?=PATH;?>alluser/user_activate/<?=$guserObj->getId();?>?page=<?=$filter['page']?>&sort=<?=$filter['sort']?>&order=<?=$filter['order']?>&role=<?=$filter['role']?>&enabled=<?=$filter['enabled']?>"><?= __("ACTIVATE") ?></a></li>
                <? endif;?>
                <li><a href="<?=PATH;?>auth/login_as/<?=$guserObj->getId();?>"><?= __("LOGIN_AS") ?></a></li>
<? if ($guserObj->isRoleServiceProvider()) { ?>
                <li><a href="<?=PATH;?>import/input/<?=$guserObj->getId();?>"><?= __("IMPORT") ?></a></li>
<? } ?>
            </ul>
        </div>
    </td>	
</tr>
<? endforeach;?>

<? if($pages):?>
<tr class="paginator">
    <td colspan="10"><?=$pages;?></td>
</tr>
<? endif;?>
<? else:?>
<tr><td colspan="10"><?= __('No users found.')?></td></tr>
<? endif;?>
