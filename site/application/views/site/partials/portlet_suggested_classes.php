<div class="portlet light">
    <div class="portlet-title porlet-title-schedule">
        <div class="caption"> <i class="icon-bar-chart font-green-sharp hide"></i> <span class="caption-subject theme-font-color bold uppercase"><i class="fa icon-trophy"></i> <?= $title ?></span></div>
    </div>

    <div class="portlet-body" style="height: auto;">
<? if(count($classObjs) > 0):?>
        <div class="table-scrollable table-scrollable-borderless">
            <table class="table table-hover table-light">
                <thead>
                    <tr class="uppercase no-hover">
                        <th class="sorting" data-order="asc" data-sort="type"><?=__('NAME')?></th>
                        <th class="sorting" data-order="asc" data-sort="time_from"><?=__('START_DATE')?></th>
                        <th class="sorting" data-order="asc" data-sort="time_from"><?=__('END_DATE')?></th>
                        <th class="sorting" data-order="asc" data-sort="owner_id"><?=__('TRAINER')?></th>
                        <th class="sorting" data-order="asc" data-sort="room"><?=__('LOCATION')?></th>
                    </tr>
                </thead>
                <tbody class="list">

<? foreach($classObjs as $classObj):?>
    <? $trainerObj = $classObj->getTrainerObj(); ?>
    <? $locationObj = $classObj->getLocationObj(); ?>
<tr>
    <td><a href="/classinfo/view/<?=$classObj->getId();?>"><?=$classObj->getShortName();?></a></td>
    <td><?=$classObj->getDateFrom();?></td>
    <td><?=$classObj->getDateTo();?></td>
    <td><a href="<?= $trainerObj?$trainerObj->getPageObj()->getPageUrl():'#';?>"><?= $trainerObj?$trainerObj->getShortName():''; ?></a></td>
    <td><?=$locationObj?$locationObj->getShortName():'';?></td>
</tr>
<? endforeach;?>

                </tbody>
            </table>
        </div>
<? else:?>
<p>No suggestions found</p>
<? endif;?>
    </div>
</div>
