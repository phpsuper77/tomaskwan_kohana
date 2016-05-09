<? if(count($guserObjs) > 0):?>
<? foreach($guserObjs as $guserObj):?>
    <tr>		
        <td class="fit">
        	<img class="img-circle avatar-40" src="<?=$guserObj->getAvatarUrl() ? $guserObj->getAvatarUrl() : IMG.'logo_avatar.png';?>" alt="">
        </td>
		<td>
        	<? if($guserObj->isAttr('route')):?>
        		<a href="<?=PATH;?>page/index/<?=$guserObj->getAttr('route');?>" class="primary-link"><?=$guserObj->getName();?></a>
            <? else: ?>
            	<?=$guserObj->getName();?>
            <? endif;?>
        </td>
		<td>
        	<div class="stars">
				<? for($i=0;$i<$guserObj->getAttr('global');$i++):?><i class="fa fa-star"></i><? endfor;?>
			</div>
   	    </td>
        <td style="width:35%;"><?=strlen($guserObj->getAttr('text')) > 150 ? substr($guserObj->getAttr('text'),0,160) : $guserObj->getAttr('text');?>...</td>
        <td><?= date('m/d/Y H:i',strtotime($guserObj->getAttr('date')));?></td>
        <td>
        	<? $diff = 14 - floor((time() - strtotime($guserObj->getAttr('date')))/86400);?>
            <? if($diff > 0):?>
				<?=$diff;?> days
            <? else:?>
            	Out of date
            <? endif;?>
        </td>
        <td>
        <div class="btn-group" style="position:absolute;">
		<a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
		<i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
		</span></a>
        	<ul class="dropdown-menu pull-right">
    		
                <li><a href="#" data-toggle="modal" data-target="#messageModal2" data-user="<?= $guserObj->getId();?>" data-name="<?=$guserObj->getName();?>" data-avatar="<?=$guserObj->getAvatarUrl() ? $guserObj->getAvatarUrl() : IMG.'logo_avatar.png';?>">Message</a></li>
                <li><a href="#" data-toggle="modal" data-target="#reviewModal" data-name="<?=$guserObj->getName();?>" data-avatar="<?=$guserObj->getAvatarUrl() ? $guserObj->getAvatarUrl() : IMG.'logo_avatar.png';?>" data-global="<?=$guserObj->getAttr('global');?>" data-facility="<?=$guserObj->getAttr('facility');?>" data-service="<?=$guserObj->getAttr('service');?>" data-clean="<?=$guserObj->getAttr('clean');?>" data-vibe="<?=$guserObj->getAttr('vibe');?>" data-knowledge="<?=$guserObj->getAttr('knowledge');?>" data-like="<?=$guserObj->getAttr('like');?>" data-text="<?=$guserObj->getAttr('text');?>" data-role="<?= $guserObj->getAttr('role')==Model_User::ROLE_TRAINER ? 'facility' : 'trainer';?>">Details</a></li>
                <? if($guserObj->getAttr('user_id') == $loginUserObj->getId() && $diff>0):?>
                <li><a href="<?=PATH;?>user/cancelreview/<?=$guserObj->getId();?>">Cancel Review</a></li>
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
