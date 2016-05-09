<div class="portlet light">
    <div class="portlet-title porlet-title-schedule">
        <div class="caption"> <i class="icon-bar-chart font-green-sharp hide"></i> <span class="caption-subject theme-font-color bold uppercase"><i class="fa icon-calendar"></i> <?= $title ?></span></div>
    </div>

    <div class="portlet-body" style="height: auto;">
<? if(count($eventObjs) > 0):?>
        <div class="table-scrollable table-scrollable-borderless">
            <table class="table table-hover table-light">
                <thead>
                    <tr class="uppercase no-hover">
                        <th class="sorting" data-order="asc" data-sort="id"><?=__('ID')?></th>
                        <th class="sorting" data-order="asc" data-sort="time_from"><?=__('START_TIME')?></th>
                        <th class="sorting" data-order="asc" data-sort="type"><?=__('TYPE')?></th>
                        <th class="sorting" data-order="asc" data-sort="owner_id"><?=__('USER')?></th>
                        <th class="sorting" data-order="asc" data-sort="room"><?=__('LOCATION')?></th>
                    </tr>
                </thead>
                <tbody class="list">

<? foreach($eventObjs as $eventObj):?>
    <? $ownerObj = $eventObj->getOwnerObj(); ?>
    <? $trainerObj = $eventObj->getTrainerObj(); ?>
    <? $locationObj = $eventObj->getLocationObj(); ?>
<tr>
    <td><a href="/myevent/view/<?= $eventObj->getId()?>"><?= $eventObj->getId()?></td>
    <td><?=$eventObj->getUserTimeFrom();?></td>
    <td><?=__('EVENT_TYPE_'.$eventObj->getEventType());?></td>
    <td><a href="<?= $ownerObj->getPageObj()->getPageUrl() ?>"><?= $ownerObj->getName(); ?></a></td>
    <td><?=$locationObj?$locationObj->getShortName():'';?></td>
</tr>
<? endforeach;?>

                </tbody>
            </table>
<a href="/myevent/list"><?=__('MORE')?></a>
        </div>
<? else:?>
<p>No events found</p>
<? endif;?>
    </div>
</div>
