<div class="page-container">
    <?=$sidebar;?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><?= __('MENU_INVITATIONS') ?></h1>
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
                <?= __('MENU_SOCIAL') ?>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <a href="<?=PATH;?>invite/list"><?= __('MENU_INVITATIONS') ?></a>
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
                                <span class="caption-subject theme-font-color bold uppercase"><?= __("INFO_INVITATIONS") ?></span>
                            </div>

                            <div class="actions">
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>

                            <!--
                            <div class="inputs margin-right-10">
                                <div class="portlet-input input-inline input-medium">
                                    <div class="input-icon right">
                                        <i class="icon-magnifier"></i>
                                        <input id="search" type="text" class="form-control input-circle" style="height:30px;" placeholder="search..." />
                                    </div>
                                </div>
                            </div>
                            -->

                        </div>
                        <div class="portlet-body" style="height: auto;">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table id="ajax-table" class="table table-hover table-light" data-jsbase="<?=JS;?>" data-url="<?= PATH;?>invite/list_ajax" data-src="profile" data-page="1" data-order="desc" data-sort="id">
                                    <thead>
                                        <tr class="uppercase no-hover">
                                            <th id="start" class="sorting" data-order="asc" data-sort="name"><?=__('NAME')?></th>
                                            <th class="sorting" data-order="asc" data-sort="role"><?=__('ACCOUNT_TYPE')?></th>
                                            <th class="sorting" data-order="asc" data-sort="create_date"><?=__('JOINED')?></th>
                                            <th class="sorting" data-order="asc" data-sort="active_date"><?=__('LAST_ACTIVE')?></th>
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
</div>

<script>
    $(document).ready(function() {
        tableList($('#start'));
    });
</script>
