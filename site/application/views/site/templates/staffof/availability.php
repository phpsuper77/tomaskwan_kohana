<!-- BEGIN CONTENT -->
<div class="page-container">
    <?=$sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><?= __('MENU_STAFF_OF') ?></h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>

            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?=PATH;?>dashboard"><?= __('MENU_DASHBOARD') ?></a>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <?= __('MENU_BUSINESS') ?>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <a href="<?=PATH;?>staffof/list"><?= __('MENU_STAFF_OF') ?></a>
                </li>

            </ul>
            <div class="clearfix"></div>
            <!-- END PAGE BREADCRUMB -->
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row" style="height:500px;">
                <div class="col-md-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md margin-right-10">
                                <i class="icon-bar-chart theme-font-color hide"></i>
                                <span class="caption-subject theme-font-color bold uppercase"><?= __('MENU_AVAILABILITY') ?></span>
                            </div>

                            <div class="actions">
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>

                            <div class="inputs margin-right-10">
                                <div class="portlet-input input-inline input-medium">
                                    <div class="input-icon right">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="portlet-body" style="height: auto;">

                            <form action="<?= PATH;?>staffof/setting/<?=$hostObj->getId();?>" method="post">
                                <input name="submit" value="tour" type="hidden" />
                                <table class="table table-light table-hover">
                                    <tbody>
                                        <tr>
                                            <td style="width:25%;">Enabled</td>
                                            <td></td>
                                            <td>
<? if ($staffSettingObj->getAttr('enabled') == 1): ?>
                                                <input name="enabled" type="checkbox" checked="checked" value="1"> 
<? else: ?>
                                                <input name="enabled" type="checkbox" value="1"> 
<? endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:25%;">Business</td>
                                            <td></td>
                                            <td>
                                                <?= Partial::user_badge_small($loginUserObj, $hostObj); ?>
                                                <input type="hidden" name="owner_id" value="<?= $hostObj->getId() ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:25%;">One session time</td>
                                            <td></td>
                                            <td>
                                                <select class="form-control" name="session">
                                                    <option value="1800" <?= $staffSettingObj->getSession()==1800 ? 'selected="selected"' : '';?>>30 minuts</option>
                                                    <option value="2700" <?= $staffSettingObj->getSession()==2700 ? 'selected="selected"' : '';?>>45 minuts</option>
                                                    <option value="3600" <?= $staffSettingObj->getSession()==3600 ? 'selected="selected"' : '';?>>60 minuts</option>
                                                    <option value="5400" <?= $staffSettingObj->getSession()==5400 ? 'selected="selected"' : '';?>>90 minuts</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:25%;">Price ($)</td>
                                            <td></td>
                                            <td><input class="form-control" type="text" name="price" value="<?= $staffSettingObj->getAttr('price') ?>"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:25%;">Location</td>
                                            <td></td>
                                            <td><input class="form-control" type="text" name="room" value="<?= $staffSettingObj->getAttr('room') ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Availability</td>
                                            <td colspan="2">
                                                <table style="width:100%;">
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>Custom Time (Ex: 3,5,12-16)</td>
                                                    </tr>
                                                    <? for($i=1;$i<8;$i++):?>
                                                    <tr>
                                                        <? $time = Model_StaffTimeSettings::getTime($loginUserObj->getId(),$hostObj->getId(),$i);?>
                                                        <td><input id="<?=$i;?>" type="checkbox" class="day_check" name="check[<?=$i;?>]" value="1" <?= $time !=FALSE ? 'checked="checked"' : '';?> /> <?=getDay($i);?></td>
                                                        <td>
                                                            <div class="input-group" style="width:140px;">
                                                                <input class="form-control timepicker timepicker-no-seconds day-<?=$i;?>" type="text" name="time_from[<?=$i;?>]" value="<?=date('h:i A',strtotime($time['time_from']));?>" readonly="readonly" />
                                                                <span class="input-group-btn">
                                                                    <button class="btn default day-<?=$i;?>" type="button" <?= $time == FALSE ? 'disabled="disabled"' : '';?>><i class="fa fa-clock-o"></i></button>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group" style="width:140px;">
                                                                <input class="form-control timepicker timepicker-no-seconds day-<?=$i;?>" type="text" name="time_to[<?=$i;?>]" value="<?=date('h:i A',strtotime($time['time_to']));?>" readonly="readonly" />
                                                                <span class="input-group-btn">
                                                                    <button class="btn default day-<?=$i;?>" type="button" <?= $time == FALSE ? 'disabled="disabled"' : '';?>><i class="fa fa-clock-o"></i></button>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group" style="width:140px;">
                                                            <input class="form-control" type="text" name="time_custom[<?=$i;?>]" value="<?=$time['time_custom']?>"/>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr height="5"></tr>
                                                    <? endfor;?>

                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Exclude Dates</td>
                                            <td></td>
                                            <td><input class="form-control" type="text" placeholder="Example: 11/28/2015, 12/26/2015" name="excluded_dates" value="<?= $staffSettingObj->getAttr('excluded_dates') ?>"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="margin-top-10">
                                    <input type="submit" class="btn green-haze" value="Save Changes" />
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
</div>
