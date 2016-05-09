<div class="page-container">
    <?= $sidebar;?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head"> 
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>DASHBOARD</h1>
                </div>
                <!-- END PAGE TITLE --> 
            </div>

            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li> <a href="<?= PATH;?>dashboard">Dashboard</a> </li>
            </ul>
            <div class="clearfix"></div>

            <? $success = Cookie::get('success');?>
            <? if($success == 'editBooking'):?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                Booking successfully updated!</div>
            <? endif; ?>
            <? Cookie::delete('success');?>
            <!-- END PAGE BREADCRUMB --> 
            <!-- END PAGE HEADER--> 
            <!-- BEGIN PAGE CONTENT-->
            <div class="row margin-top-10">
                <div class="col-md-6 col-sm-6"> 
                    <!-- BEGIN PORTLET-->
                    <? $data = array('start_date'=>date('Y-m-d'), 'status'=>Model_Event::STATUS_ACTIVE, 'order'=>'asc', 'sort'=>'time_from'); ?>
                    <?= Partial::portlet_user_events($loginUserObj, __('UPCOMING EVENTS'), $data, 0, 5); ?>
                    <!-- END PORTLET--> 
                </div>
                <div class="col-md-6 col-sm-6"> 
                    <!-- BEGIN PORTLET-->
                    <?= Partial::portlet_suggested_classes($loginUserObj, __('CLASSES THAT MAY INTEREST YOU')); ?>
                    <!-- END PORTLET--> 
                </div>
            </div>
            <!-- END PAGE CONTENT--> 
        </div>
    </div>

