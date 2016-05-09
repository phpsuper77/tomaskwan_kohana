<? if(count($locationObjs) > 0):?>
<? foreach($locationObjs as $locationObj):?>
    <tr>
    	<td class="fit" align="center"><?=$locationObj->getAttr('id');?></td>
        <td><?=$locationObj->getAddress();?></td>
        <td><?=$locationObj->getCity();?></td>
        <td><?=$locationObj->getState();?></td>
        <td><?=$locationObj->getZip();?></td>
        <td><?=$locationObj->getRoom();?></td>
        <td><?=$locationObj->getNote();?></td>
        <td><span class="label label-sm<?=$locationObj->getStatus() == 1 ? ' label-success' : ' label-danger';?>">
            <?= __('STATUS_'.$locationObj->getStatus());?></span></td>
        <td>
        <div class="btn-group" style="position:absolute;">
		<a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
		<i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
		</span></a>
        	<ul class="dropdown-menu pull-right">
                <li><a href="<?=PATH;?>location/view/<?= $locationObj->getAttr('id');?>"><?= __("VIEW") ?></a></li>
<? if ($locationObj->getStatus() == Model_Location::STATUS_ACTIVE) { ?>
                <li><a href="<?=PATH;?>location/deactivate/<?= $locationObj->getAttr('id');?>"><?= __("DEACTIVATE") ?></a></li>
<? } else { ?>
                <li><a href="<?=PATH;?>location/activate/<?= $locationObj->getAttr('id');?>"><?= __("ACTIVATE") ?></a></li>
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
<tr><td align="center" colspan="10"><?= __("NO_LOCATIONS") ?></td></tr>
<? endif;?>
