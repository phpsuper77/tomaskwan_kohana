<? if(count($myClassObjs) > 0):?>
<? foreach($myClassObjs as $myClassObj):?>
    <? $trainerObj = $myClassObj->getTrainerObj(); ?>
    <? $locationObj = $myClassObj->getLocationObj(); ?>
<tr>
    <td><?=$myClassObj->getId();?></td>
    <td><?=$myClassObj->getName();?></td>
    <td>
        <?= Partial::user_badge_small($loginUserObj, $trainerObj); ?>
    </td>
    <td><?=$myClassObj->getAttr('date_from') == NULL ? 'No start date' : date('m/d/Y',strtotime($myClassObj->getAttr('date_from')));?></td>
    <td><?=$myClassObj->getAttr('date_to') == NULL ? 'No end date' : date('m/d/Y',strtotime($myClassObj->getAttr('date_to')));?></td>
    <td><?=$locationObj?$locationObj->getFullName():'';?></td>
    <td><a href="/myclass/view/<?=$myClassObj->getId();?>"><i class="fa fa-arrow-right"></i></td>
</tr>
<? endforeach;?>

<? if($pages):?>
<tr class="paginator">
    <td align="center" colspan="10"><?= $pages;?></td>
</tr>
<? endif;?>
<? else:?>
<tr><td align="center" colspan="10">No purchased classes found.</td></tr>
<? endif;?>
