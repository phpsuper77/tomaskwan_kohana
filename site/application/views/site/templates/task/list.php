<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">

        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1><?= __('MENU_TASKS') ?></h1>
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
                    <?= __('MENU_SITE') ?>
                <i class="fa fa-circle"></i>
                </li>
            <li>
            <a href="<?=PATH;?>dashboard"><?= __('MENU_TASKS') ?></a>
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
                            <span class="caption-subject theme-font-color bold uppercase"><?= __('INFO_TASKS') ?></span>
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

                        <table class="table table-hover table-light">
                            <thead>
                                <tr class="uppercase no-hover">
                                    <th><?= __('ID') ?></th>
                                    <th><?= __('USER') ?></th>
                                    <th><?= __('TYPE') ?></th>
                                    <th><?= __('STATUS') ?></th>
                                    <th><?= __('NOTE') ?></th>
                                    <th><?= __('UPDATED') ?></th>
                                    <th><?= __('CREATED') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($taskObjs as $taskObj) { ?>
                                    <? $userObj = $taskObj->getUserObj(); ?>
                                <tr>
                                    <td><?=$taskObj->getId();?></td>
                                    <td><?=$userObj->getName();?></td>
                                    <td><?=$taskObj->getTaskType();?></td>
                                    <td><?=$taskObj->getStatus();?></td>
                                    <td><?=$taskObj->getMsg();?></td>
                                    <td><?=$taskObj->getModifiedAt();?></td>
                                    <td><?=$taskObj->getCreatedAt();?></td>
                                </tr>
                                <? } ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-5">
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
