<div class="page-container">
    <?=$sidebar;?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>My Orders</h1>
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
                <a href="<?=PATH;?>myorder/list"><?= __('MENU_MY_ORDERS') ?></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            <?= $detailsModal;?>
            <!-- END PAGE BREADCRUMB -->
            <? $success = Cookie::get('success');?>
            <? if($success == 'pay'):?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                Order successfully paid!</div>
            <? Cookie::delete('success');?>
            <? endif; ?>
            <? $error = Cookie::get('error');?>
            <? if($error):?>
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                Payment error! <?=$error;?></div>
            <? Cookie::delete('error');?>
            <? endif; ?>        
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">

                        <div class="portlet-title">
                            <div class="caption caption-md margin-right-10">
                                <i class="icon-bar-chart theme-font-color hide"></i>
                                <span class="caption-subject theme-font-color bold uppercase"><?= __('INFO_MY_ORDERS') ?></span>
                            </div>

                            <div class="actions">	
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>

                        </div>

                        <div class="portlet-body" style="height: auto;">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table id="ajax-table" class="table table-hover table-light" data-jsbase="<?=JS;?>" data-url="<?=PATH;?>myorder/list_ajax" data-page="1" data-order="desc" data-sort="id">
                                    <thead>
                                        <tr class="uppercase no-hover">
                                            <th class="sorting" id="start" data-order="desc" data-sort="id">ID</th>
                                            <th data-order="asc" data-sort="cname">OFFERED BY</th>
                                            <th class="sorting" data-order="asc" data-sort="status">STATUS</th>
                                            <th class="sorting" data-order="asc" data-sort="op_order">TXID</th>
                                            <th class="sorting" data-order="asc" data-sort="sum">TOTAL</th>
                                            <th class="sorting" data-order="asc" data-sort="modify_date">DATE</th>
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
