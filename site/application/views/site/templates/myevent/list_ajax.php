<? if(count($myEventObjs) > 0):?>
<? foreach($myEventObjs as $myEventObj):?>
    <? $trainerObj = $myEventObj->getTrainerObj(); ?>
    <? $locationObj = $myEventObj->getLocationObj(); ?>
<tr>
    <td><?=$myEventObj->getId();?></td>
    <td><?=$myEventObj->getName();?></td>
    <td><?= __('EVENT_TYPE_'.$myEventObj->getEventType());?></td>
    <td><a href="<?= $trainerObj->getPageObj()->getPageUrl() ?>"><?= $trainerObj->getName(); ?></a></td>
    <td><?=$myEventObj->getUserTimeFrom();?></td>
    <td><?=$myEventObj->getUserTimeTo();?></td>
    <td><?=$locationObj?$locationObj->getShortName():'';?></td>
    <td><?=$myEventObj->getUserDate();?></td>
    <td><a href="/myevent/view/<?=$myEventObj->getId();?>"><i class="fa fa-arrow-right"></i></td>
</tr>
<? endforeach;?>

<? if($pages):?>
<tr class="paginator">
    <td align="center" colspan="10"><?= $pages;?></td>
</tr>
<? endif;?>
<? else:?>
<tr><td align="center" colspan="10"><?=__('NO_EVENTS')?></td></tr>
<? endif;?>
