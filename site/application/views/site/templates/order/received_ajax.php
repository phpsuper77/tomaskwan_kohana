<? if(count($orderObjs) > 0):?>
<? foreach($orderObjs as $orderObj):?>
<? $buyerObj = $orderObj->getUserObj(); ?>
<? $sellerObj = $orderObj->getOwnerObj(); ?>
<tr>
    <td class="fit" align="center"><?=$orderObj->getAttr('id');?></td>
    <? if($loginUserObj->isRoleUser()):?>
    <td class="fit">
        <img class="img-circle avatar-40" src="<?=$sellerObj->getAvatarImageUrl();?>" alt="">
    </td>
    <td><a href="<?=$sellerObj->getPageUrl();?>"><?=$sellerObj->getTruncatedAttr('name');?></a></td>
    <? else:?>
    <td class="fit">
        <img class="img-circle avatar-40" src="<?=$buyerObj->getAvatarImageUrl();?>" alt="">
    </td>
    <td><a href="<?=$buyerObj->getPageUrl();?>"><?= $buyerObj->getTruncatedAttr('name');?></a></td>
    <? endif;?>
    <td><?=ucfirst($orderObj->getAttr('status'));?></td>
    <td><?=$orderObj->getAttr('op_order');?></td>
    <td>$ <?=$orderObj->getAttr('sum');?></td>
    <td><?=date('m/d/Y H:i',strtotime($orderObj->getAttr('modify_date')));?></td>
    <td>
        <div class="btn-group" style="position:absolute;">
            <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
            </span></a>
            <ul class="dropdown-menu pull-right">
                <li><a href="#" data-toggle="modal" data-target="#orderDetailsModal" data-order='<?=$orderObj->getId();?>'>Details</a></li>
            </ul>
        </div>
    </td>	
</tr>
<? endforeach;?>
<? else:?>
<tr><td align="center" colspan="10">You have no orders yet.</td></tr>
<? endif;?>
