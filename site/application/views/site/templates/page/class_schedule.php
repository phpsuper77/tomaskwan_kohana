<div id="boxes">
    <a href="<?=PATH;?>page/<?=$route;?>" id="back-to-profile" class="font-medium"><i class="icon-arrow_left"></i>BACK TO PROFILE</a>
    <div class="container">			
        <div class="text-center">
            <h1 class="main-h3 ttn">Full Schedule</h1>
            <h2 class="main-h4 ttn">Classes</h2>
        </div>
        <div class="col-xs-12">
            <div class="profile-container">

            <? if(count($scheduleObjs)>0):?>
                <form method="post" action="/cart/add_classes">
                <table width="100%" >
                    <? foreach($scheduleObjs as $k => $scheduleObj):?>
                    <tr>
                        <td class="time-classes"></td>
                        <td class="time-classes" colspan="4"><h3><?= $k ?></h3></td>
                    </tr>
                    <tr>
                        <td class="green time-bold" colspan="5">&nbsp;</td>
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
                        <td class="time-classes" style="width:40%"><?=date('h:i A',strtotime($classObj->getAttr('time_from')));?>&nbsp;&nbsp;~&nbsp;&nbsp;<?=date('h:i A',strtotime($classObj->getAttr('time_to')));?></td>
                        <td class="time-classes time-bold" style="width:20%" colspan="2">$<?=$classObj->getAttr('price')?></td>
                    </tr>
                    <tr>
                        <td class="green time-bold">&nbsp;</td>
                        <td class="time-classes"><?=date('m/d/Y',strtotime($classObj->getAttr('date_to')));?>&nbsp;&nbsp;~&nbsp;&nbsp;<?=date('m/d/Y',strtotime($classObj->getAttr('date_to')));?></td>
                        <td colspan="1"><span class="badge <?=isset($weekHash[1])?'badge-warning':'badge-success'?>">M</span> <span class="badge <?=isset($weekHash[2])?'badge-warning':'badge-success'?>">T</span> <span class="badge <?=isset($weekHash[3])?'badge-warning':'badge-success'?>">W</span> <span class="badge <?=isset($weekHash[4])?'badge-warning':'badge-success'?>">T</span> <span class="badge <?=isset($weekHash[5])?'badge-warning':'badge-success'?>">F</span> <span class="badge <?=isset($weekHash[6])?'badge-warning':'badge-success'?>">S</span> <span class="badge <?=isset($weekHash[7])?'badge-warning':'badge-success'?>">S</span></td>
                        <td class="green time-bold" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="green time-bold" colspan="5">&nbsp;</td>
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
