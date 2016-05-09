<? if(count($reviewObjs) > 0):?>
<? foreach($reviewObjs as $reviewObj):?>
  <? $userObj = $reviewObj->getUserObj(); ?>
  <? $ownerObj = $reviewObj->getOwnerObj(); ?>
<tr>		
    <td>
        <?= Partial::user_badge_small($loginUserObj, $ownerObj); ?>
    </td>
    <td>
        <div class="stars">
            <? for($i=0;$i<$reviewObj->getAttr('global');$i++):?><i class="fa fa-star"></i><? endfor;?>
        </div>
    </td>
    <td style="width:35%;"><?=strlen($reviewObj->getAttr('text')) > 150 ? substr($reviewObj->getAttr('text'),0,160) : $reviewObj->getAttr('text');?>...</td>
    <td><?= date('m/d/Y H:i',strtotime($reviewObj->getAttr('date')));?></td>
    <td>
        <? $diff = 14 - floor((time() - strtotime($reviewObj->getAttr('date')))/86400);?>
        <? if($diff > 0):?>
        <?=$diff;?> <?=__('DAYS')?>
        <? else:?>
        <?=__('OUT_OF_DATE')?>
        <? endif;?>
    </td>
    <td>
        <div class="btn-group" style="position:absolute;">
            <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
            </span></a>
            <ul class="dropdown-menu pull-right">

                <li><a href="#" data-toggle="modal" data-target="#messageModal2" data-user="<?= $reviewObj->getId();?>" data-name="<?=$reviewObj->getOwnerObj()->getName();?>" data-avatar="<?=$reviewObj->getOwnerObj()->getAvatarImageUrl() ;?>"><?=__('MESSAGE')?></a></li>
                <li><a href="#" data-toggle="modal" data-target="#reviewModal" data-name="<?=$reviewObj->getOwnerObj()->getName();?>" data-avatar="<?=$reviewObj->getOwnerObj()->getAvatarImageUrl();?>" data-global="<?=$reviewObj->getAttr('global');?>" data-facility="<?=$reviewObj->getAttr('facility');?>" data-service="<?=$reviewObj->getAttr('service');?>" data-clean="<?=$reviewObj->getAttr('clean');?>" data-vibe="<?=$reviewObj->getAttr('vibe');?>" data-knowledge="<?=$reviewObj->getAttr('knowledge');?>" data-like="<?=$reviewObj->getAttr('like');?>" data-text="<?=$reviewObj->getAttr('text');?>" data-role="<?= $reviewObj->getAttr('role')==Model_User::ROLE_TRAINER ? 'facility' : 'trainer';?>"><?=__('VIEW')?></a></li>
                <? if($reviewObj->getAttr('user_id') == $loginUserObj->getId() && $diff>0):?>
                <li><a href="<?=PATH;?>review/cancel/<?=$reviewObj->getId();?>"><?=__('CANCEL')?></a></li>
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
<tr><td align="center" colspan="10"><?=__('NO_REVIEWS')?></td></tr>
<? endif;?>
