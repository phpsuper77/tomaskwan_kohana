<!-- BEGIN CONTENT -->
<? if($title != 'our staff'):?>
<div class="page-content-wrapper">
    <div class="page-content">

        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1><?=ucfirst($title);?></h1>
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
            <a href="<?=PATH;?>user/list/<?= $type;?>"><?= ucfirst($title);?></a>
            </li>

        </ul>
        <div class="clearfix"></div>
        <!-- END PAGE BREADCRUMB -->
        <? else:?>
        <div class="profile-content">			
            <? endif;?>
            <? $success = Cookie::get('success');
            if($success == 'addStaff'):?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                New staff successfully added!</div>
            <? Cookie::delete('success');?>
            <? endif; ?>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row" style="height:500px;">
                <div class="col-md-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md margin-right-10">
                                <i class="icon-bar-chart theme-font-color hide"></i>
                                <span class="caption-subject theme-font-color bold uppercase"><?= $title;?></span>
                            </div>

                            <div class="actions">
                                <? if($type == 'all'):?>
                                <a class="btn btn-circle btn-default btn-sm" href="#" data-toggle="modal">Import </a>
                                <? endif;?>
                                <? if($type == 'staff'):?>
                                <?= $addEmployeeModal;?>
                                <a href="#" class="btn btn-circle btn-default btn-sm" data-toggle="modal" data-target="#addEmployeeModal">
                                    <i class="fa fa-plus"></i> <?= $user['role'] == Model_User::ROLE_ADMIN && $title != 'our staff' ? 'Add Administrator' : 'Add Employee';?></a></a>
                            <? endif;?>
                            <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                        </div>

                        <? if($type != 'staff'):?>
                        <div class="inputs margin-right-10">
                            <div class="portlet-input input-inline input-medium">
                                <div class="input-icon right">
                                    <i class="icon-magnifier"></i>
                                    <input id="search" type="text" class="form-control input-circle" style="height:30px;" placeholder="search..." />
                                </div>
                            </div>
                        </div>
                        <? endif;?>

                    </div>
                    <div class="portlet-body" style="height: auto;">
                        <? if($title != 'our staff' && $user['role'] == Model_User::ROLE_ADMIN):?>
                        <div class="row list-separated margin-top-20 margin-bottom-30">
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="font-grey-mint font-sm text-center">All Accounts</div>
                                <div class="uppercase font-hg font-red-flamingo text-center"><?=$all;?></div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="font-grey-mint font-sm text-center">Users</div>
                                <div class="uppercase font-hg theme-font-color text-center"><?=$users;?></div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="font-grey-mint font-sm text-center">Individual Personal Trainers</div>
                                <div class="uppercase font-hg font-purple text-center"><?=$trainers;?></div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="font-grey-mint font-sm text-center">Health Clubs</div>
                                <div class="uppercase font-hg font-blue-sharp text-center"><?=$clubs;?></div>
                            </div>
                        </div>
                        <? endif;?>
                        <div class="table-scrollable table-scrollable-borderless">
                            <table id="ajax-table" class="table table-hover table-light" data-jsbase="<?=JS;?>" data-url="<?= PATH;?>user/list_ajax/<?= $type;?>" data-src="profile" data-page="1" data-superior="<?= $superior;?>">
                                <thead>
                                    <tr class="uppercase no-hover">
                                        <th id="start" class="sorting" data-order="asc" data-sort="name" colspan="2">Name</th>
                                        <th class="sorting" data-order="asc" data-sort="role">ACCOUNT TYPE</th>
                                        <th class="sorting" data-order="asc" data-sort="create_date">JOINED</th>
                                        <th class="sorting" data-order="asc" data-sort="active_date">LAST ACTIVE</th>
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
        <? if($title != 'our staff'):?>
        <!-- END PAGE CONTENT-->
    </div>
    <? endif;?>

    <script>
        $(document).ready(function() {
            tableList($('#start'));
        });
    </script>
