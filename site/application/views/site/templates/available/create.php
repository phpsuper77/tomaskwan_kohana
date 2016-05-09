<!-- BEGIN CONTENT -->
<div class="page-container">
    <?=$sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><?= __('MENU_AVAILABILITY') ?></h1>
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
                <a href="<?=PATH;?>staffof/list"><?= __('MENU_AVAILABILITY') ?></a>
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
                                <span class="caption-subject theme-font-color bold uppercase"><?= __('INFO_AVAILABILITY') ?></span>
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

                            <form action="<?= PATH;?>available/add" method="post">
                                <input name="submit" value="tour" type="hidden" />
                                <table class="table table-light table-hover">
                                    <tbody>
                                        <tr>
                                            <td style="width:25%;"><?= __('DURATION') ?></td>
                                            <td></td>
                                            <td>
                                                <select class="form-control" name="session">
                                                    <option value="1800">30 <?= __('MINUTES') ?></option>
                                                    <option value="2700">45 <?= __('MINUTES') ?></option>
                                                    <option value="3600">60 <?= __('MINUTES') ?></option>
                                                    <option value="5400">90 <?= __('MINUTES') ?></option>
                                                </select>
                                            </td>
                                        </tr>
<? if ($loginUserObj->isRoleTrainer()) { ?>
                                        <tr>
                                            <td style="width:25%;"><?= __('PRICE') ?> ($)</td>
                                            <td></td>
                                            <td><input class="form-control" type="text" name="price" value="0"></td>
                                        </tr>
<? } ?>
                                        <tr>
                                            <td style="width:25%;"><?= __('TYPE') ?></td>
                                            <td></td>
                                            <td>
<select name="type" class="form-control">
<? if ($loginUserObj->isRoleTrainer()) { ?>
    <option value="<?= Model_Availability::TYPE_SESSION ?>"><?= __('SESSION') ?></option>
<? } else { ?>
    <option value="<?= Model_Availability::TYPE_TOUR ?>"><?= __('TOUR') ?></option>
<? } ?>
</select>
                                            </td>
                                        </tr>
<? if ($loginUserObj->isRoleTrainer()) { ?>
                                        <tr>
                                            <td style="width:25%;"><?= __('HOST') ?></td>
                                            <td></td>
                                            <td>
<select name="owner_id" class="form-control">
    <option value="">-</option>
    <? foreach ($staffOfObjs as $staffOfObj) { ?>
        <? $hostObj = $staffOfObj->getHostObj() ?>
        <option value="<?= $hostObj->getId() ?>"><?= $hostObj->getName() ?></option>
    <? } ?>
</select>
                                            </td>
                                        </tr>
<? } ?>
                                        <tr>
                                            <td style="width:25%;"><?= __('LOCATION') ?></td>
                                            <td></td>
                                            <td>
<select name="location_id" class="form-control">
    <? foreach ($locationObjs as $locationObj) { ?>
        <option value="<?= $locationObj->getId() ?>"><?= $locationObj->getFullName() ?></option>
    <? } ?>
</select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= __('AVAILABILITY') ?></td>
                                            <td colspan="2">
                                                <table style="width:100%;">
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><?= __('CUSTOM_TIME') ?> (Ex: 3,5,12-16)</td>
                                                    </tr>
                                                    <? for($i=1;$i<8;$i++):?>
                                                    <tr>
                                                        <td><input id="<?=$i;?>" type="checkbox" class="day_check" name="check[<?=$i;?>]" value="1" /> <?=getDay($i);?></td>
                                                        <td>
                                                            <div class="input-group" style="width:140px;">
                                                                <input class="form-control timepicker timepicker-no-seconds day-<?=$i;?>" type="text" name="time_from[<?=$i;?>]" value="10:00 AM" readonly="readonly" />
                                                                <span class="input-group-btn">
                                                                    <button class="btn default day-<?=$i;?>" type="button"><i class="fa fa-clock-o"></i></button>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group" style="width:140px;">
                                                                <input class="form-control timepicker timepicker-no-seconds day-<?=$i;?>" type="text" name="time_to[<?=$i;?>]" value="16:00 PM" readonly="readonly" />
                                                                <span class="input-group-btn">
                                                                    <button class="btn default day-<?=$i;?>" type="button"><i class="fa fa-clock-o"></i></button>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group" style="width:140px;">
                                                            <input class="form-control" type="text" name="time_custom[<?=$i;?>]" value=""/>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr height="5"></tr>
                                                    <? endfor;?>

                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= __('EXCLUDED_DATES') ?></td>
                                            <td></td>
                                            <td><input class="form-control" type="text" placeholder="Example: 11/28/2015, 12/26/2015" name="excluded_dates" value=""></td>
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
