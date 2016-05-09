<div class="page-container">
    <?= $sidebar;?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>Bookings</h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>

            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?= PATH;?>dashboard">Dashboard</a>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                Booking
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <a href="<?= PATH;?>booking/index">Bookings</a>
                </li>
            </ul>
            <div class="clearfix"></div>
            <!-- END PAGE BREADCRUMB -->
            <? $success = Cookie::get('success');?>
            <? if($success == 'addBooking'):?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                New booking successfully added!</div>
            <? endif; ?>
            <? if($success == 'editBooking'):?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                Booking successfully updated!</div>
            <? endif; ?>
            <? Cookie::delete('success');?>

            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">
                        <?= $addBookingModal;?>
                        <div class="portlet-title">
                            <div class="caption caption-md margin-right-10">
                                <i class="icon-bar-chart theme-font-color hide"></i>
                                <span class="caption-subject theme-font-color bold uppercase">Bookings</span>
                            </div>

                            <div class="actions">
                            <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                        </div>

                    </div>
                    <div class="portlet-body" style="height: auto;">
                        <div class="table-scrollable table-scrollable-borderless">
                            <table id="ajax-table" class="table table-hover table-light" data-jsbase="<?=JS;?>" data-url="<?=PATH;?>booking/list_ajax/" data-page="1">
                                <thead>
                                    <tr class="uppercase no-hover">
                                        <th id="start" class="sorting" data-order="desc" data-sort="id">ORDER NO.</th>
                                        <th colspan="2" class="sorting" data-order="asc" data-sort="uname">USER</th>
                                        <th colspan="2" class="sorting" data-order="asc" data-sort="tname">TRAINER</th>
                                        <th class="sorting" data-order="asc" data-sort="date">DATE</th>
                                        <th class="sorting" data-order="asc" data-sort="type">TYPE</th>
                                        <th>STATUS</th>
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
