<? if(count($myOfferObjs) > 0):?>
<? foreach($myOfferObjs as $myOfferObj):?>
    <? $trainerObj = $myOfferObj->getOwnerObj(); ?>
<tr>
    <td><?=$myOfferObj->getId();?></td>
    <td><?=$myOfferObj->getName();?></td>
    <td><a href="<?= $trainerObj->getPageObj()->getPageUrl()?>"><?= $trainerObj->getName(); ?></a> </td>
    <td><?=$myOfferObj->getAttr('order_id');?></td>
    <td><a href="/myoffer/view/<?=$myOfferObj->getId();?>"><i class="fa fa-arrow-right"></i></td>
</tr>
<? endforeach;?>

<? if($pages):?>
<tr class="paginator">
    <td align="center" colspan="10"><?= $pages;?></td>
</tr>
<? endif;?>
<? else:?>
<tr><td align="center" colspan="10"><?=__('NO_OFFERS')?></td></tr>
<? endif;?>
