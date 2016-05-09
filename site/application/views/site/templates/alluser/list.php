<!-- BEGIN CONTENT -->
<? if($title != 'our staff'):?>
<div class="page-content-wrapper">
    <div class="page-content">

        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1><?= __("MENU_USERS") ?></h1>
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
                    <?= __('MENU_SITE') ?>
                <i class="fa fa-circle"></i>
                </li>
            <li>
            <a href="<?=PATH;?>alluser/list/"><?= __("MENU_USERS") ?></a>
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
                New employee successfully added!</div>
            <? Cookie::delete('success');?>
            <? endif; ?>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-body" style="height: auto;">
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="height:500px;">
                <div class="col-md-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md margin-right-10">
                                <i class="icon-bar-chart theme-font-color hide"></i>
                                <span class="caption-subject theme-font-color bold uppercase"><?= __("MENU_USERS") ?></span>
                            </div>

                            <div class="actions">
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>

                            <div class="inputs margin-right-10">
                                <div class="portlet-input input-inline input-medium">
                                    <div class="input-icon right">
                                        <i class="icon-magnifier"></i>
                                        <input id="search" type="text" class="form-control input-circle" style="height:30px;" placeholder="<?= __('SEARCH') ?>" />
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="portlet-body" style="height: auto;">

                            <div>
                                &nbsp;ACCOUNT TYPE:
                                    <select class="search-filter" id="filter-role" name="role">
                                        <option <?= $filter['role']==''?'selected':'' ?> value="">ALL</option>
                                        <option <?= $filter['role']==1?'selected':'' ?> value="1"><?=__('ROLE_1')?></option>
                                        <option <?= $filter['role']==2?'selected':'' ?> value="2"><?=__('ROLE_2')?></option>
                                        <option <?= $filter['role']==4?'selected':'' ?> value="4"><?=__('ROLE_4')?></option>
                                        <option <?= $filter['role']==5?'selected':'' ?> value="5"><?=__('ROLE_5')?></option>
                                    </select>
                                &nbsp;
                                &nbsp;STATUS:
                                    <select class="search-filter" id="filter-enabled" name="enabled">
                                        <option <?= $filter['enabled']==''?'selected':'' ?> value=""><?=__('ALL')?></option>
                                        <option <?= $filter['enabled']===1?'selected':'' ?> value="1"><?=__('ACTIVE')?></option>
                                        <option <?= $filter['enabled']===0?'selected':'' ?> value="0"><?=__('INACTIVE')?></option>
                                    </select>
                            </div>

                            <div id="progress-table" class="row dn">
                                <div class="col-md-4"></div>
                                <div class="col-md-4" style="text-align:center;"><i class="fa fa-spinner fa-pulse fa-4x"></i></div>
                                <div class="col-md-4"></div>
                            </div>

                            <div class="table-scrollable table-scrollable-borderless">
                                <table id="ajax-table" class="table table-hover table-light" data-jsbase="<?=JS;?>" data-url="<?= PATH;?>alluser/list_ajax" data-src="profile" data-page="<?=$filter['page']?>" data-order="<?=$filter['order']?>" data-sort="<?=$filter['id']?>" data-filters="role,enabled">
                                    <thead>
                                        <tr class="uppercase no-hover">
                                            <th id="start" class="sorting" data-order="desc" data-sort="id"><?= __("ID") ?></th>
                                            <th class="sorting" data-order="asc" data-sort="name"><?= __("NAME") ?></th>
                                            <th class="sorting" data-order="asc" data-sort="email"><?= __("EMAIL") ?></th>
                                            <th class="sorting" data-order="asc" data-sort="role"><?= __("ACCOUNT_TYPE") ?></th>
                                            <th class="sorting" data-order="asc" data-sort="role"><?= __("TITLE") ?></th>
                                            <th class="sorting" data-order="asc" data-sort="create_date"><?= __("JOINED") ?></th>
                                            <th class="sorting" data-order="asc" data-sort="active_date"><?= __("LAST_ACTIVE") ?></th>
                                            <th><?= __("STATUS") ?></th>
                                            <th><?= __("ACTION") ?></th>
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
