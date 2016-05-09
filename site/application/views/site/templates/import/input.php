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

                            <form class="form-horizontal" action="/import/upload/<?=$userObj->getId()?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-md-2 control-label"><h4>COLUMN MAPPING</h4></label>
                                    <div class="col-md-6">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>First Name/Name</strong></label>
                                    <div class="col-md-6">
                                        <select name="col-firstname">
                                            <? for ($i = 1; $i < 20; $i++) { ?>
                                            <option <?=($i==4)?'selected':''?> value="<?= $i ?>">Column #<?= $i ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>Last Name</strong></label>
                                    <div class="col-md-6">
                                        <select name="col-lastname">
                                            <option value="-">-</option>
                                            <? for ($i = 1; $i < 20; $i++) { ?>
                                            <option <?=($i==4)?'selected':''?> value="<?= $i ?>">Column #<?= $i ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>Email</strong></label>
                                    <div class="col-md-6">
                                        <select name="col-email">
                                            <? for ($i = 1; $i < 20; $i++) { ?>
                                            <option <?=($i==2)?'selected':''?> value="<?= $i ?>">Column #<?= $i ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>Address</strong></label>
                                    <div class="col-md-6">
                                        <select name="col-address">
                                            <option value="-">-</option>
                                            <? for ($i = 1; $i < 20; $i++) { ?>
                                            <option <?=($i==3)?'selected':''?> value="<?= $i ?>">Column #<?= $i ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>City</strong></label>
                                    <div class="col-md-6">
                                        <select name="col-city">
                                            <option value="-">-</option>
                                            <? for ($i = 1; $i < 20; $i++) { ?>
                                            <option <?=($i==3)?'selected':''?> value="<?= $i ?>">Column #<?= $i ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>State</strong></label>
                                    <div class="col-md-6">
                                        <select name="col-state">
                                            <option value="-">-</option>
                                            <? for ($i = 1; $i < 20; $i++) { ?>
                                            <option <?=($i==3)?'selected':''?> value="<?= $i ?>">Column #<?= $i ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>Zip</strong></label>
                                    <div class="col-md-6">
                                        <select name="col-zip">
                                            <option value="-">-</option>
                                            <? for ($i = 1; $i < 20; $i++) { ?>
                                            <option <?=($i==4)?'selected':''?> value="<?= $i ?>">Column #<?= $i ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>Phone</strong></label>
                                    <div class="col-md-6">
                                        <select name="col-phone">
                                            <option value="-">-</option>
                                            <? for ($i = 1; $i < 20; $i++) { ?>
                                            <option <?=($i==3)?'selected':''?> value="<?= $i ?>">Column #<?= $i ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label"><h4>OPTIONS</h4></label>
                                    <div class="col-md-6">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>File Format</strong></label>
                                    <div class="col-md-6">
                                        <select name="file-format">
                                            <option value="csv">csv</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>Skip Header</strong></label>
                                    <div class="col-md-6">
                                        <select name="skip-header">
                                            <option value="0">No</option>
                                            <option value="1">Yes<option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label"><h4>FILE</h4></label>
                                    <div class="col-md-6">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>Data File</strong></label>
                                    <div class="col-md-6">
                                        <span class="btn btn-warning fileinput-button">SELECT
                                            <input name="file" type="file" />
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        &nbsp;
                                    </div>
                                    <div class="col-md-6">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="submit" class="image-add btn green" value="Preview">
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
</div>
