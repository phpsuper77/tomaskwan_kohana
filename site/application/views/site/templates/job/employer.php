<div class="page-container">
    <?=$sidebar;?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><?= __('MENU_JOB_OPP') ?></h1>
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
                <a href="<?=PATH;?>job/employer"><?= __('MENU_JOB_OPP') ?></a>
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
                                <span class="caption-subject theme-font-color bold uppercase"><?= __('INFO_JOB_OPP') ?></span>
                            </div>

                            <div class="actions">
     <a href="#" class="btn btn-circle btn-default btn-sm" id="filter">
                                    <i class="fa fa-filter"></i> <?= __('FILTER') ?></a>
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>

                            <div class="inputs margin-right-10">
                                <div class="portlet-input input-inline input-medium">
                                    <div class="input-icon right">
                                        <i class="icon-magnifier"></i>
                                        <input id="search" type="text" class="form-control input-circle" style="height:30px;" placeholder="<?= __('SEARCH') ?>" />
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="filter-options" class="row dn">
                            <div class="col-md-5">
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="filter-zip" id="filter-zip" class="form-control input-circle" style="height:30px;" placeholder="<?= __('ZIP') ?>" />
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

                        <div class="portlet-body" style="height: auto;">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table id="ajax-table" class="table table-hover table-light" data-jsbase="<?=JS;?>" data-url="<?=PATH;?>job/employer_ajax" data-page="1" data-filters="zip,radius" data-order="desc" data-sort="name">
                                    <thead>
                                        <tr class="uppercase no-hover">
                                            <th id="start" class="sorting" data-order="asc" data-sort="name"><?= __('NAME') ?></th>
                                            <th class="sorting" data-order="asc" data-sort="city"><?= __('CITY') ?></th>
                                            <th class="sorting" data-order="asc" data-sort="zip"><?= __('ZIP') ?></th>
                                            <th class="sorting" data-order="asc" data-sort="date"><?= __('CREATED') ?></th>
                                            <th class="sorting" data-order="desc" data-sort="date"><?= __('LAST_ACTIVE') ?></th>
                                            <th><?= __('ACTION') ?></th>
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
