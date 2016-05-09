<? if(count($seekerObjs) > 0):?>
<? foreach($seekerObjs as $seekerObj):?>
    <tr>
        <td>
            <?= Partial::user_badge_small($loginUserObj, $seekerObj); ?>
        </td>
        <td><?=$seekerObj->getAttr('title');?></td>
        <td><?=$seekerObj->getAttr('zip');?></td>
        <td><?=$seekerObj->getCreateDate();?></td>
        <td><?=$seekerObj->getActiveDate();?></td>
        <td>
        <? if($seekerObj->getAttr('status') != 'paid'):?>
        <div class="btn-group" style="position:absolute;">
		<a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
		<i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
		</span></a>
        	<ul class="dropdown-menu pull-right">
                <? if($seekerObj->getId() != $loginUserObj->getId()):?>
                <li><a href="#" data-toggle="modal" data-target="#messageModal2" data-user="<?=$seekerObj->getId();?>" data-name="<?=$seekerObj->getName();?>" data-avatar="<?=$seekerObj->getAvatarImageUrl() ;?>"><?= __('MESSAGE') ?></a></li>
                <? endif;?>
  			</ul>
          </div>
          <? endif;?>
		</td>	
	</tr>
    <? endforeach;?>
    
    <? if($pages):?>
	<tr class="paginator">
    <td align="center" colspan="10"><?= $pages;?></td>
    </tr>
    <? endif;?>
<? else:?>
<tr><td align="center" colspan="10">No trainers found.</td></tr>
<? endif;?>
