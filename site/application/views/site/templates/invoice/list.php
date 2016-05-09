<div class="page-container">
    <?=$sidebar;?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><?= __("MENU_INVOICES") ?></h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>

            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?=PATH;?>dashboard"><?= __("MENU_DASHBOARD") ?></a>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <?= __("MENU_BUSINESS") ?>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <a href="<?=PATH;?>invoice/index"><?= __("MENU_INVOICES") ?></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            <!-- END PAGE BREADCRUMB -->
            <? $success = Cookie::get('success');?>
            <? if($success == 'pay'):?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                Invoice successfully paid!</div>
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
                                <span class="caption-subject theme-font-color bold uppercase"><?= __("INFO_INVOICES") ?></span>
                            </div>

                            <div class="actions">	
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>                                
                        </div>

                        <div class="portlet-body" style="height: auto;">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table id="ajax-table" class="table table-hover table-light" data-jsbase="<?=JS;?>" data-url="<?=PATH;?>invoice/invoice_list/" data-page="1" data-order="desc" data-sort="id">
                                    <thead>
                                        <tr class="uppercase no-hover">
                                            <th id="start" class="sorting" data-order="asc" data-sort="id"><?= __("ID") ?></th>
                                            <th class="sorting" data-order="asc" data-sort="period"><?= __("DESCRIPTION") ?></th>
                                            <th class="sorting" data-order="asc" data-sort="status"><?= __("STATUS") ?></th>
                                            <th class="sorting" data-order="asc" data-sort="sum"><?= __("TOTAL") ?></th>
                                            <th class="sorting" data-order="desc" data-sort="date"><?= __("CREATED") ?></th>
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
