<!-- BEGIN CONTENT -->
<div class="page-container">
    <?=$sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><?= __("MENU_CALENDAR") ?></h1>
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
                <?= __("MENU_BOOKINGS") ?>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <a href="<?=PATH;?>calendar/show"><?= __("MENU_CALENDAR") ?></a>
                </li>

            </ul>
            <div class="clearfix"></div>
            <!-- END PAGE BREADCRUMB -->
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-8">
                            <div class="portlet light">
                                <div class="portlet-body">
                                    <div id="my-calendar" class="calendar"></div>
                                </div>
                             </div>

                </div>
                <div class="col-md-4">
                            <div class="portlet light">
                                <div class="portlet-body">
                                    <p><?= __('MYCAL_INFO') ?></p>
                                    <h3><?= __('EVENT_OVERVIEW')?></h3>
                                    <hr>
                                    <div id="selectedEvent">
                                        <div><?= __('NONE')?></div>
                                    </div>
                                </div>
                             </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    GYMHIT_CALENDAR_MANAGER.init('#my-calendar', '/mycalendar', '<?= date('Y-m-d', time());?>');
});
</script>
