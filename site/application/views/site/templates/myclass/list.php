<!-- BEGIN CONTENT -->
<div class="page-container">
    <?=$sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>My Classes</h1>
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
                Bookings
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <a href="<?=PATH;?>myclass/list">My Classes</a>
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
                                <span class="caption-subject theme-font-color bold uppercase">Subscribed classes</span>
                            </div>

                            <div class="actions">
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>

<!---
                            <div class="inputs margin-right-10">
                                <div class="portlet-input input-inline input-medium">
                                    <div class="input-icon right">
                                        <i class="icon-magnifier"></i>
                                        <input id="search" type="text" class="form-control input-circle" style="height:30px;" placeholder="search..." />
                                    </div>
                                </div>
                            </div>
--->
                        </div>

                            <div id="progress-table" class="row dn">
                                <div class="col-md-4"></div>
                                <div class="col-md-4" style="text-align:center;"><i class="fa fa-spinner fa-pulse fa-4x"></i></div>
                                <div class="col-md-4"></div>
                            </div>

                        <div class="portlet-body" style="height: auto;">
                            <div class="table-scrollable table-scrollable-borderless">
                                <table id="ajax-table" class="table table-hover table-light" data-jsbase="<?=JS;?>" data-url="<?= PATH;?>myclass/list_ajax" data-src="profile" data-page="1" data-order="desc" data-sort="order_item_id">
                                    <thead>
                                        <tr class="uppercase no-hover">
                                            <th id="start" class="sorting" data-order="desc" data-sort="order_item_id">Id</th>
                                            <th class="sorting" data-order="asc" data-sort="name">Name</th>
                                            <th class="sorting" data-order="asc" data-sort="trainer_id">TRAINER ID</th>
                                            <th class="sorting" data-order="asc" data-sort="time_from">START DATE</th>
                                            <th class="sorting" data-order="asc" data-sort="time_to">END DATE</th>
                                            <th class="sorting" data-order="asc" data-sort="location_id">LOCATION</th>
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
