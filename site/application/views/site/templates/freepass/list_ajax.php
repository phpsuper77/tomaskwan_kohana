<? if(count($freepassObjs) > 0):?>
<? foreach($freepassObjs as $freepassObj):?>
    <tr>		
        <td class="fit" align="center"><?=$freepassObj->getId();?></td>
		<td>
            <?= Partial::user_badge_small($loginUserObj, $freepassObj->getUserObj()); ?>
        </td>
        <td><?=$freepassObj->getName();?></td>
        <td><?=date('m/d/Y',strtotime($freepassObj->getAttr('date')));?></td>
        <td><?=$freepassObj->getAttr('code');?></td>
	</tr>
    <? endforeach;?>
    <? if($pages):?>
	<tr class="paginator">
    <td align="center" colspan="10"><?=$pages;?></td>
    </tr>
    <? endif;?>
<? else:?>
<tr><td align="center" colspan="10"><?=__('NO_FREE_PASSES')?></td></tr>
<? endif;?>
