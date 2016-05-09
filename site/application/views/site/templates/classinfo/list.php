<div id="boxes">
    <div class="container-schedule">			
        <div class="row">
            <div class="col-md-12">
                <p>&nbsp;</p>
                <ul class="page-breadcrumb breadcrumb">

                    <li>
                        <a href="<?=PATH;?>page/<?= $pageObj->getRoute(); ?>"><?= $userObj->getName() ?></a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?=PATH;?>classinfo/list/<?= $pageObj->getRoute(); ?>">Classes</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
        <div class="col-md-3">
                <?= Partial::user_page_portlet($loginUserObj, $userObj); ?>
        </div>
        <div class="col-md-9">

<div class="portlet light">
                                <div class="portlet-body">
            <div class="profile-container">

            <? if(count($scheduleObjs)>0):?>
                <form method="post" action="/cart/add_classes">
                <table width="100%" >
                    <? foreach($scheduleObjs as $k => $scheduleObj):?>
                    <tr>
                        <td class="time-classes"></td>
                        <td class="time-classes" colspan="5"><h3><?= $k ?></h3></td>
                    </tr>
                    <tr>
                        <td class="green time-bold" colspan="6">&nbsp;</td>
                    </tr>
                    <? foreach($scheduleObj['classObjs'] as $classObj):?>
                        <? $weekHash = $classObj->getWeekHash();?>
                    <tr>
                        <td class="time-classes" style="width:10%">
                    <? if ($loginUserObj && $loginUserObj->isRoleUser()): ?>
                            <input type="checkbox" name="classes[]" value="<?=$classObj->getId()?>">
                    <? endif; ?>
                        </td>
                        <td class="green time-bold" style="width:30%"><?=$classObj->getAttr('name');?></td>
                        <td class="time-classes"><?= $classObj->getTrainerObj()->getName() ?></td>
                        <td class="time-classes time-bold" style="width:20%" colspan="3"><?=$classObj->getUserPrice()?></td>
                        <td><a href="/classinfo/view/<?= $classObj->getId() ?>" class="time-bold" style="float:right;">Details</a></td>
                    </tr>
                    <tr>
                        <td class="green time-bold">&nbsp;</td>
                        <td class="time-classes"><?=date('m/d/Y',strtotime($classObj->getAttr('date_to')));?>&nbsp;&nbsp;~&nbsp;&nbsp;<?=date('m/d/Y',strtotime($classObj->getAttr('date_to')));?></td>
                        <td class="time-classes" style="width:20%"><?=date('h:i A',strtotime($classObj->getAttr('time_from')));?>&nbsp;&nbsp;~&nbsp;&nbsp;<?=date('h:i A',strtotime($classObj->getAttr('time_to')));?></td>
                        <td colspan="2">
                            <? if (isset($weekHash[7])): ?>
                            <span class="badge badge-warning">Su</span>
                            <? endif; ?>
                            <? if (isset($weekHash[1])): ?>
                            <span class="badge badge-warning">M</span>
                            <? endif; ?>
                            <? if (isset($weekHash[2])): ?>
                            <span class="badge badge-warning">Tu</span>
                            <? endif; ?>
                            <? if (isset($weekHash[3])): ?>
                            <span class="badge badge-warning">W</span>
                            <? endif; ?>
                            <? if (isset($weekHash[4])): ?>
                            <span class="badge badge-warning">Th</span>
                            <? endif; ?>
                            <? if (isset($weekHash[5])): ?>
                            <span class="badge badge-warning">F</span>
                            <? endif; ?>
                            <? if (isset($weekHash[6])): ?>
                            <span class="badge badge-warning">Sa</span>
                            <? endif; ?>

                </td>
                        <td class="green time-bold">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="green time-bold" colspan="6">&nbsp;</td>
                    </tr>
                    <? endforeach;?>
                    <? endforeach;?>
                </table>
                    <? if ($loginUserObj && $loginUserObj->isRoleUser()): ?>
                    <input type="submit" class="btn green" name="submit" value="Book">
                    <? endif; ?>
                </form>
                <div class="text-center pt45">
                </div>
            <? else:?>
                <div class="text-center pt45">
                NO CLASSES FOUND
                </div>
            <? endif;?>

            </div>
        </div>
        <div class="clearfix"></div>			
        </div>
        </div>
        </div>
    </div>
</div>
