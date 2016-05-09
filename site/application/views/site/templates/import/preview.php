<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">

        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>Import Data</h1>
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
                            <span class="caption-subject theme-font-color bold uppercase"><img class="img-circle avatar-40" src="<?=$userObj->getAvatarImageUrl();?>"> <?= $userObj->getName();?></span>
                        </div>

                        <div class="actions">
                            <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                        </div>

                        <div class="inputs margin-right-10">
                            <div class="portlet-input input-inline input-medium">
                                <div class="input-icon right">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="portlet-body" style="height: auto;">

                        <table class="table table-hover table-light">
                            <thead>
                                <tr class="uppercase no-hover">
                                    <th>LINE NO</th>
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th>ADDRSS</th>
                                    <th>CITY</th>
                                    <th>STATE</th>
                                    <th>ZIP</th>
                                    <th>PHONE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($info['rows'] as $row) { ?>
                                <tr>
                                    <td><?=$row['id'];?></td>
                                    <td><?=$row['name'];?></td>
                                    <td><?=$row['email'];?></td>
                                    <td><?=$row['address'];?></td>
                                    <td><?=$row['city'];?></td>
                                    <td><?=$row['state'];?></td>
                                    <td><?=$row['zip'];?></td>
                                    <td><?=$row['phone'];?></td>
                                </tr>
                                <? } ?>
                                <tr>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>...</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-4">
                                Total: <?= $info['total'];?>
                            </div>
                            <div class="col-md-5">
                            </div>
                            <div class="col-md-3">
                                <a href="/import/start/<?= $id ?>" class="btn red">Import</a>
                                <a href="/import/input/<?= $userObj->getId() ?>" class="btn red">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
