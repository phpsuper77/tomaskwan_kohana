<div class="page-container">
    <?=$sidebar;?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>Received Orders</h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>

            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?=PATH;?>dashboard">Dashboard</a>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                Orders
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <a href="<?=PATH;?>order/received">Received Orders</a>
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
                                <span class="caption-subject theme-font-color bold uppercase">Orders from users</span>
                            </div>

                            <div class="actions">	
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>

                        </div>

                        <div class="portlet-body" style="height: auto;">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table id="ajax-table" class="table table-hover table-light" data-jsbase="<?=JS;?>" data-url="<?=PATH;?>order/received_ajax/" data-page="1">
                                    <thead>
                                        <tr class="uppercase no-hover">
                                            <th class="sorting" id="start" data-order="desc" data-sort="id">ID</th>
                                            <? if($loginUserObj->isRoleUser()):?>
                                            <th colspan="2"  data-order="asc" data-sort="cname">OFFERED BY</th>
                                            <? else:?>
                                            <th colspan="2" class="sorting" data-order="asc" data-sort="uname">
                                                USER</th>
                                            <? endif;?>
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
