<div class="page-container">
    <?=$sidebar;?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><?= __('MENU_FOR_HIRE') ?></h1>
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
                <?= __('MENU_JOBS') ?>
                <i class="fa fa-circle"></i>
                </li>
               <li>
                <a href="<?=PATH;?>job/seeker"><?= __('MENU_FOR_HIRE') ?></a>
                </li>

            </ul>
            <div class="clearfix"></div>
            <!-- END PAGE BREADCRUMB -->
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->

            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">

                        <div class="portlet-title">
                            <div class="caption caption-md margin-right-10">
                                <i class="icon-bar-chart theme-font-color hide"></i>
                                <span class="caption-subject theme-font-color bold uppercase"><?= __('INFO_FOR_HIRE') ?></span>
                            </div>

                            <div class="actions">
                                <a href="#" class="btn btn-circle btn-default btn-sm" id="filter">
                                     <i class="fa fa-filter"></i> Filter</a>
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>

                            <div class="inputs margin-right-10">
                                <div class="portlet-input input-inline input-medium">
                                    <div class="input-icon right">
                                        <i class="icon-magnifier"></i>
                                        <input id="search" type="text" class="form-control input-circle" style="height:30px;" placeholder="search..." />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="filter-options" class="row dn">
                            <div class="col-md-5">
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="filter-title" id="filter-title" style="height: 30px;">
                                    <option val="">Title</option>
                    <? foreach($professionObjs as $professionObj):?>
                    <option value="<?=$professionObj->getId();?>">
                    <?=$professionObj->getName();?>
                    </option>
                    <? endforeach;?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="filter-zip" id="filter-zip" class="form-control input-circle" style="height:30px;" placeholder="Zip" />
                            </div>
                            <div class="col-md-2">
                               <select class="form-control" id="filter-radius" name="filter-radius" style="height: 30px;">
                                    <option value=""><?= __('RADIUS') ?></option>
                                    <option value="5"><?= __('WITHIN_RADIUS',array('miles'=>5)) ?></option>
                                    <option value="10"><?= __('WITHIN_RADIUS',array('miles'=>10)) ?></option>
                                    <option value="100"><?= __('WITHIN_RADIUS',array('miles'=>100)) ?></option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <a href="#" class="btn btn-circle btn-default btn-sm" id="filter-apply">
                                    <i class="fa fa-filter"></i> <?= __('APPLY') ?></a>
                            </div>
                        </div>

                            <div id="progress-table" class="row dn">
                                <div class="col-md-4"></div>
                                <div class="col-md-4" style="text-align:center;"><i class="fa fa-spinner fa-pulse fa-4x"></i></div>
                                <div class="col-md-4"></div>
                            </div>

                        <div class="portlet-body" style="height: auto;">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table id="ajax-table" class="table table-hover table-light" data-jsbase="<?=JS;?>" data-url="<?=PATH;?>job/seeker_ajax" data-page="1" data-filters="title,radius,zip" data-order="desc" data-sort="name">
                                    <thead>
                                        <tr class="uppercase no-hover">
                                            <th id="start" class="sorting" data-order="asc" data-sort="name"><?= __('NAME') ?></th>
                                            <th class="sorting" data-order="asc" data-sort="title"><?= __('TITLE') ?></th>
                                            <th class="sorting" data-order="asc" data-sort="zip"><?= __('ZIP') ?></th>
                                            <th class="sorting" data-order="asc" data-sort="status"><?= __('CREATED') ?></th>
                                            <th class="sorting" data-order="desc" data-sort="date"><?= __('DATE') ?></th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>

            <!-- END PAGE CONTENT-->
        </div>
    </div>

    <script>
        $(document).ready(function() {
            tableList($('#start'));
        });
    </script>
