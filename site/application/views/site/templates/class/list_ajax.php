<? if(count($classObjs) > 0):?>
<? foreach($classObjs as $classObj):?>
    <? $trainerObj = $classObj->getTrainerObj(); ?>
<tr>
    <td><?=$classObj->getId();?></td>
    <td><?=$classObj->getShortName();?></td>
    <td>
        <? if ($trainerObj) { ?>
        <a href="<?=$trainerObj->getPageObj()->getPageUrl();?>"><?= $trainerObj->getTruncatedName();?></a>
        <? } else { ?>
            <?= __('UNASSIGNED') ?>
        <? } ?>
    </td>
    <td><?=$classObj->getAttr('date_from') == NULL ? 'No start date' : date('m/d/Y',strtotime($classObj->getAttr('date_from')));?></td>
    <td><?=$classObj->getAttr('date_to') == NULL ? 'No end date' : date('m/d/Y',strtotime($classObj->getAttr('date_to')));?></td>
    <td><?=$classObj->getAttr('max')==0 ? 'No limits' : $classObj->getAttr('max');?></td>
    <td>$<?=$classObj->getAttr('price');?></td>
    <td><span class="label label-sm<?=$classObj->getStatus() == 1 ? ' label-success' : ' label-danger';?>">
            <?= __('STATUS_'.$classObj->getStatus());?></span></td>
    <td>
        <div class="btn-group" style="position:absolute;">
            <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
            </span></a>
            <ul class="dropdown-menu pull-right">
                <? $week = implode(',',unserialize($classObj->getAttr('week')));?>
                <li><a href="#" data-toggle="modal" data-target="#addClassModal" data-id="<?=$classObj->getId();?>" data-location_id="<?=$locationObj?$locationObj->getId():''?>" data-name="<?=$classObj->getAttr('name');?>" data-room="<?=$classObj->getAttr('room');?>" data-time_from="<?=date('h:i A',strtotime($classObj->getAttr('time_from')));?>" data-time_to="<?= date('h:i A',strtotime($classObj->getAttr('time_to')));?>" data-date_from="<?=date('m/d/Y',strtotime($classObj->getAttr('date_from')));?>" data-date_to="<?=date('m/d/Y',strtotime($classObj->getAttr('date_to')));?>" data-trainer_id="<?=$trainObj?$trainerObj->getId():'';?>" data-max="<?=$classObj->getAttr('max');?>" data-week="<?=$week ;?>,8,9" data-price="<?=$classObj->getAttr('price');?>" data-image="<?=$classObj->getImageUrl();?>"><?= __('EDIT') ?></a></li>
                <li><a href="<?=PATH;?>class/view/<?= $classObj->getId();?>"><?= __('VIEW') ?></a></li>
<? if ($classObj->getStatus() == 1) { ?>
                <li><a href="<?=PATH;?>class/deactivate/<?= $classObj->getId();?>"><?= __('DEACTIVATE') ?></a></li>
<? } else { ?>
                <li><a href="<?=PATH;?>class/activate/<?= $classObj->getId();?>"><?= __('ACTIVATE') ?></a></li>
<? } ?>
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
<tr><td align="center" colspan="10">There is no registered classes yet.</td></tr>
<? endif;?>
