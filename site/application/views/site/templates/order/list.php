<div class="page-container">
    <?=$sidebar;?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><?= __('MENU_RECEIVED_ORDERS') ?></h1>
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
                <?= __('MENU_ORDERS') ?>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <a href="<?=PATH;?>order/list"><?= __('MENU_RECEIVED_ORDERS') ?></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            <?= $detailsModal;?>
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
                                <span class="caption-subject theme-font-color bold uppercase"><?= __('INFO_RECEIVED_ORDERS') ?></span>
                            </div>

                            <div class="actions">	
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>

                        </div>

                        <div class="portlet-body" style="height: auto;">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table id="ajax-table" class="table table-hover table-light" data-jsbase="<?=JS;?>" data-url="<?=PATH;?>order/list_ajax/" data-page="1" data-order="desc" data-sort="id">
                                    <thead>
                                        <tr class="uppercase no-hover">
                                            <th class="sorting" id="start" data-order="desc" data-sort="id"><?= __('ID') ?></th>
                                            <th class="sorting" data-order="asc" data-sort="uname"><?= __('USER') ?></th>
                                            <th class="sorting" data-order="asc" data-sort="status"><?= __('STATUS') ?></th>
                                            <th class="sorting" data-order="asc" data-sort="op_order"><?= __('TXID') ?></th>
                                            <th class="sorting" data-order="asc" data-sort="sum"><?= __('TOTAL') ?></th>
                                            <th class="sorting" data-order="asc" data-sort="modify_date"><?= __('DATE') ?></th>
                                            <th><?=__('ACTION')?></th>
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
