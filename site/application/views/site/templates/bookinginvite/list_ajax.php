<? if(count($bookingObjs) > 0):?>
<? foreach($bookingObjs as $bookingObj):?>
    <tr>
    	<td class="fit" align="center"><?=$bookingObj->getAttr('id');?></td>
		<td class="fit">
        <img class="img-circle avatar-40" src="<?=$bookingObj->getAvatarUrl() ? $bookingObj->getAvatarUrl() : IMG.'logo_avatar.png';?>" alt="">
        </td>
        <td><?=$bookingObj->getTruncatedAttr('uname');?></td>
      	<? if($bookingObj->getAttr('type')=='class'):?>
        <td class="fit">
		<img class="img-circle avatar-40" src="<?=$bookingObj->getgetClassAvatarUrl() ? $bookingObj->getClassAvatarUrl() : IMG.'logo_avatar.png';?>" alt="">
        </td>
		<td><a href="'.PATH.'profile/index/<?=$bookingObj->getAttr('cid');?>"><?=$bookingObj->getAttr('ctname');?></a></td>
        <? elseif($bookingObj->getAttr('type')=='booking'):?>
        <td class="fit">
		<img class="img-circle avatar-40" src="<?=$bookingObj->getTrainerAvatarUrl() ? $bookingObj->getTrainerAvatarUrl() : IMG.'logo_avatar.png';?>" alt="">
        </td>
		<td><a href="'.PATH.'profile/index/<?=$bookingObj->getAttr('trainer_id');?>"><?=$bookingObj->getAttr('tname');?></a></td>
        <? else:?>
		<td colspan="2" align="center">No trainer</td>
		<? endif;?>
        <? if($bookingObj->getAttr('type') == 'class'):?>
        	<td><?=date('m/d/Y',strtotime($bookingObj->getAttr('date')));?></td>
        <? else:?>
        	<td><?=date('m/d/Y H:i',strtotime($bookingObj->getAttr('date')));?></td>
        <? endif;?>
        <td><?=ucfirst($bookingObj->getAttr('type'));?><?=$bookingObj->getAttr('cname') ? ' ('.$bookingObj->getAttr('cname').')' : '';?></td>
        <td><?=ucfirst($bookingObj->getAttr('status'));?></td>
        <td>
        <div class="btn-group" style="position:absolute;">
		<a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
		<i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
		</span></a>
        	<ul class="dropdown-menu pull-right">
                <? if($bookingObj->getAttr('type') == 'booking'):?>
                <li><a href="#" data-toggle="modal" data-target="#addBookingModal" data-id="<?=$bookingObj->getAttr('id');?>" data-date="<?=date('m/d/Y H:i',strtotime($bookingObj->getAttr('date')));?>" data-trainer_id="<?=$bookingObj->getAttr('trainer_id');?>" data-trainer="<?=$bookingObj->getAttr('tname');?>" data-user="<?=$bookingObj->getAttr('uname');?>" data-user_id="<?=$bookingObj->getAttr('user_id');?>" data-form="<?=$bookingObj->getAttr('form');?>">Edit</a></li>
                <? endif;?>
                <li><a href="<?=PATH;?>booking/delete/<?= $bookingObj->getAttr('id');?>">Delete</a></li>
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
<tr><td align="center" colspan="10">There is no booking yet.</td></tr>
<? endif;?>
