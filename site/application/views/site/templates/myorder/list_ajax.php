<? if(count($orderObjs) > 0):?>
<? foreach($orderObjs as $orderObj):?>
<? $buyerObj = $orderObj->getUserObj(); ?>
<? $sellerObj = $orderObj->getOwnerObj(); ?>
<tr>
    <td class="fit" align="center"><?=$orderObj->getAttr('id');?></td>
    <td><a href="<?= $sellerObj->getPageObj()->getPageUrl(); ?>"><?= $sellerObj->getName(); ?></a></td>
    <td><?=ucfirst($orderObj->getAttr('status'));?></td>
    <td><?=$orderObj->getAttr('op_order');?></td>
    <td>$ <?= number_format($orderObj->getAttr('sum'),2);?></td>
    <td><?=$orderObj->getUserModifyDate();?></td>
    <td><a href="/myorder/view/<?=$orderObj->getId();?>"><i class="fa fa-arrow-right"></i></td>
</tr>
<? endforeach;?>
<? else:?>
<tr><td align="center" colspan="10">You have no orders yet.</td></tr>
<? endif;?>
