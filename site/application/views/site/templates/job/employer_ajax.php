<? if(count($employerObjs) > 0):?>
<? foreach($employerObjs as $employerObj):?>
    <tr>
        <td>
            <?= Partial::user_badge_small($loginUserObj, $employerObj); ?>
        </td>
        <td><?=$employerObj->getAttr('city');?></td>
        <td><?=$employerObj->getAttr('zip');?></td>
        <td><?=$employerObj->getCreateDate();?></td>
        <td><?=$employerObj->getActiveDate();?></td>
        <td>
        <? if($employerObj->getAttr('status') != 'paid'):?>
        <div class="btn-group" style="position:absolute;">
		<a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
		<i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
		</span></a>
        	<ul class="dropdown-menu pull-right">
                <? if($employerObj->getId() != $loginUserObj->getId()):?>
                <li><a href="#" data-toggle="modal" data-target="#messageModal2" data-user="<?=$employerObj->getId();?>" data-name="<?=$employerObj->getName();?>" data-avatar="<?=$employerObj->getAvatarImageUrl() ;?>"><?= __('Message') ?></a></li>
                <? endif;?>
  			</ul>
          </div>
          <? endif;?>
		</td>	
	</tr>
    <? endforeach;?>
    
    <? if($pages):?>
	<tr class="paginator">
    <td align="center" colspan="6"><?= $pages;?></td>
    </tr>
    <? endif;?>
<? else:?>
<tr><td align="center" colspan="6">No trainers found.</td></tr>
<? endif;?>
