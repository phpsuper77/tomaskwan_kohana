<? if(count($avaObjs) > 0):?>
<? foreach($avaObjs as $avaObj):?>
    <? $locationObj = $avaObj->getLocationObj(); ?>
    <? $ownerObj = $avaObj->getOwnerObj(); ?>
<tr>
    <td><?=$avaObj->getId();?></td>
    <td><?=$locationObj?$locationObj->getShortName():'';?></td>
    <td><?=$avaObj->getAvailabilityType()==Model_Availability::TYPE_TOUR?'tour':'session';?></td>
<? if ($loginUserObj->isRoleTrainer()) { ?>
    <td>
<? if ($ownerObj) { ?>
        <a href="<?= $ownerObj->getPageObj()->getPageUrl() ?>"><?=$ownerObj->getName();?></a>
<? } ?>
    </td>
    <td><?=$avaObj->getPrice();?></td>
<? } ?>
    <td><?=$avaObj->getSession()/60;?></td>
    <td>
       <span class="label label-sm<?=$avaObj->getStatus() == 1 ? ' label-success' : ' label-danger';?>">
            <?= __('STATUS_'.$avaObj->getStatus());?></span>
    </td>
    <td>
        <div class="btn-group" style="position:absolute;">
            <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
            </span></a>
            <ul class="dropdown-menu pull-right">
                <li><a href="<?=PATH;?>available/view/<?= $avaObj->getId();?>"><?= __('ACTION_VIEW') ?></a></li>
            </ul>
        </div>
    </td>	
</tr>
<? endforeach;?>

<? if($pages):?>
<tr class="paginator">
    <td align="center" colspan="10"><?= $pages;?></td>
</tr>
<? endif;?>
<? else:?>
<tr><td align="center" colspan="10"><?= __('NO_AVAILABILITY') ?></td></tr>
<? endif;?>
