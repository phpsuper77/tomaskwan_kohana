<div class="page-container">
    <?=$sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content"> 
            <!-- BEGIN PAGE HEADER--> 
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head"> 
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>Dashboard <small>dashboard &amp; statistics</small></h1>
                </div>
                <!-- END PAGE TITLE --> 
            </div>
            <!-- END PAGE HEAD -->
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li><a href="<?=PATH;?>">Home</a><i class="fa fa-circle"></i></li>
                <li><a href="<?=PATH;?>dashboard">Dashboard</a></li>
            </ul>
            <div class="row margin-top-10">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-green-sharp"><?=$countAccount['accounts'];?></h3>
                                <small>ACCOUNTS</small> </div>
                            <div class="icon"> <i class="icon-user-following"></i> </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress"> <span style="width: 100%;" class="progress-bar progress-bar-success green-sharp"> <span class="sr-only">76% progress</span> </span> </div>
                            <div class="status"> </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-blue-sharp"><small class="font-blue-sharp">$</small><?=$countRevenue['revenue'];?></h3>
                                <small>REVENUE</small> </div>
                            <div class="icon"> <i class="icon-basket"></i> </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress"> <span style="width: 100%;" class="progress-bar progress-bar-success blue-sharp"> <span class="sr-only">45% grow</span> </span> </div>
                            <div class="status"> </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze"><?=$visits['totalsForAllResults']['ga:visits'];?></h3>
                                <small>SITE VISITS</small> </div>
                            <div class="icon"> <i class="icon-eye"></i> </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress"> <span style="width: 100%;" class="progress-bar progress-bar-success red-haze"> <span class="sr-only">45% grow</span> </span> </div>
                            <div class="status"> </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- END PAGE CONTENT-->
        </div>
    </div>
</div>
      </div>

  </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        tableList($('#start'));
    });
</script>
