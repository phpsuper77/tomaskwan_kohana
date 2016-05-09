<? if(count($orderObjs) > 0):?>
<? foreach($orderObjs as $orderObj):?>
<? $buyerObj = $orderObj->getUserObj(); ?>
<? $sellerObj = $orderObj->getOwnerObj(); ?>
<tr>
    <td class="fit" align="center"><?=$orderObj->getAttr('id');?></td>
    <td>
        <?= Partial::user_badge_small($loginUserObj, $buyerObj); ?>
    </td>
    <td><?=ucfirst($orderObj->getAttr('status'));?></td>
    <td><?=$orderObj->getAttr('op_order');?></td>
    <td>$ <?=number_format($orderObj->getAttr('sum'),2);?></td>
    <td><?=date('m/d/Y H:i',strtotime($orderObj->getAttr('modify_date')));?></td>
    <td><a href="/order/view/<?=$orderObj->getId();?>"><i class="fa fa-arrow-right"></i></td>
</tr>
<? endforeach;?>
<? else:?>
<tr><td align="center" colspan="10"><?= __('NO_ORDERS') ?></td></tr>
<? endif;?>
