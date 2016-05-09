<? if(count($guserObjs) > 0):?>
<? foreach($guserObjs as $guserObj):?>
    <tr class="invite-<?=$guserObj->getId();?>">
		
        <td class="fit">
        	<img class="img-circle avatar-40" src="<?=$guserObj->getAvatarUrl()? $guserObj->getAvatarUrl() : IMG.'logo_avatar.png';?>" alt="">
        </td>
		<td>
        	<? if($guserObj->getRoute()):?>
        		<a href="<?= PATH;?>page/index/<?=$guserObj->getRoute();?>" class="primary-link"><?=$guserObj->getTruncatedName();?></a>
            <? else: ?>
            	<?=$guserObj->getTruncatedName();?>
            <? endif;?>
            <? if($guserObj->getSuperiorId() != NULL):?>
            	<? if($guserObj->getSuperiorRoute()):?>
                	<br /><small><a href="<?= PATH;?>page/index/<?=$guserObj->getSuperiorRoute();?>" class="primary-link"><?=$guserObj->getSuperiorName();?></a></small>
                <? else:?>
                	<br /><small><?=$guserObj->getSuperiorName();?></small>
                <? endif;?>
			<? endif;?>
        </td>
		<td><?=getRole($guserObj->getRole());?><br /><small><?=$guserObj->getTitle();?></small></td>
		<td><?=$guserObj->getCreateDate();?></td>
        <td><?=$guserObj->getActiveDate();?></td>
        	<td><span class="label label-sm<?=$guserObj->getActive() == 1 ? ' label-success' : ' label-danger';?>">
        	<?= $guserObj->isActive()?'Active':'Inactive';?></span></td>
        <td>
        <div class="btn-group" style="position:absolute;">
		<a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
		<i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
		</span></a>
        	<ul class="dropdown-menu pull-right">
    		<? if($guserObj->getId() != $loginUserObj->getId()):?>
                	<li><a href="#" data-toggle="modal" data-target="#messageModal2" data-user="<?=$guserObj->getId();?>" data-name="<?=$guserObj->getName();?>" data-avatar="<?=$guserObj->getAvatarUrl() ? $guserObj->getAvatarUrl() : IMG.'logo_avatar.png';?>">Message</a></li>
		<? endif;?>
		<? if($type == 'invitations'):?>
                	<li><a class="connect-now" href="#" data-invite="<?=$guserObj->getId();?>" data-url="<?=PATH;?>" data-mode="list">Connect</a></li>
                <? endif;?>
               	<? if($type == 'staff' || ($loginUserObj->getRole() == Model_User::ROLE_ADMIN && $guserObj->getRole() != Model_User::ROLE_USER)):?>
                	<li><a href="<?=PATH;?>profile/index/<?=$guserObj->getId();?>">Profile Settings</a></li>
    			 <? endif;?>
                <? if($type == 'connections'):?>
    			<li><a href="<?=PATH;?>user/" class="connect" data-id="<?=$guserObj->getId();?>" data-action="disconnect" data-mode="list">Disconnect</a></li>
    			<? endif;?>
  			</ul>
          </div>
		</td>	
	</tr>
    <? endforeach;?>
    
    <? if($pages):?>
	<tr class="paginator">
    <td align="center" colspan="10"><?=$pages;?></td>
    </tr>
    <? endif;?>
<? else:?>
<tr><td align="center" colspan="10">No items found.</td></tr>
<? endif;?>
