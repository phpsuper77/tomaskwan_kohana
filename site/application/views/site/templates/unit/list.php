<div class="page-container">
    <?= $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1><?= __('MENU_UNITS') ?></h1>
                </div>
            </div>
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?= PATH;?>dashboard"><?= __('MENU_DASHBOARD') ?></a>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                    <?= __('MENU_SITE') ?>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <a href="<?= PATH;?>unit/list/<?= $type;?>"><?= __('MENU_UNITS') ?></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            <? if($successAction):?>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <strong><?= ucfirst($type);?> successfully <?= $successAction;?>!</strong></div>
                </div>
            </div>
            <? endif; ?>
            <!-- END PAGE BREADCRUMB -->
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md margin-right-10">
                                <i class="icon-bar-chart theme-font-color hide"></i>
                                <span class="caption-subject theme-font-color bold uppercase"><?= __('UNIT_INTERESTS') ?></span>
                            </div>
                            <div class="actions">
                                <?= $unitModal;?>
                                <a href="#" class="btn btn-circle btn-default btn-sm" data-toggle="modal" data-target="#unitModal" data-type="interest" data-action="add">
                                    <i class="fa fa-plus"></i><?= __('UNIT_ADD_INTERESTS') ?></a>
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-hover table-light">
                                <thead>
                                    <tr>
                                        <th><?= __('NAME') ?></th>
                                        <th><?= __('ICON_NAME') ?></th>
                                        <th><?= __('ICON') ?></th>
                                        <th><?= __('ACTION') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? if(count($interestObjs) > 0):?>
                                    <? foreach($interestObjs as $interestObj):?>
                                    <tr>
                                        <td><?= $interestObj->getAttr('name');?></td>
                                        <td><?= $interestObj->getAttr('class');?></td>
                                        <td><i class="<?= $interestObj->getAttr('class');?>"></i></td>  
                                        <td>
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                    <i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
                                                </span></a>
                                                <ul class="dropdown-menu pull-right" role="menu">
                                                    <li>
                                                    <a href="#" data-toggle="modal" data-target="#unitModal" data-type="interest" data-id="<?= $interestObj->getId();?>" data-action="edit" data-cl="<?=$interestObj->getAttr('class');?>" data-name="<?=$interestObj->getAttr('name');?>"><?= __('EDIT') ?></a></li>
                                                    <li><a href="<?=PATH;?>unit/delete/<?=$interestObj->getId();?>"><?= __('DELETE') ?></a></li>
                                                </ul>
                                            </div>
                                        </td>	
                                    </tr>
                                    <? endforeach;?>
                                    <? endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md margin-right-10">
                                <i class="icon-bar-chart theme-font-color hide"></i>
                                <span class="caption-subject theme-font-color bold uppercase"><?= __('UNIT_BRICK_AND_MORTAR') ?></span>
                            </div>
                            <div class="actions">
                                <?= $unitModal;?>
                                <a href="#" class="btn btn-circle btn-default btn-sm" data-toggle="modal" data-title="Brick and Mortar" data-target="#unitModal" data-type="mortar" data-action="add">
                                    <i class="fa fa-plus"></i><?= __('UNIT_ADD_BRICK_AND_MORTAR') ?></a>
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-hover table-light">
                                <thead>
                                    <tr>
                                        <th><?= __('NAME') ?></th>
                                        <th><?= __('ICON_NAME') ?></th>
                                        <th><?= __('ICON') ?></th>
                                        <th><?= __('ACTION') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? if(count($mortarObjs) > 0):?>
                                    <? foreach($mortarObjs as $mortarObj):?>
                                    <tr>
                                        <td><?= $mortarObj->getAttr('name');?></td>
                                        <td><?= $mortarObj->getAttr('class');?></td>
                                        <td><i class="<?= $mortarObj->getAttr('class');?>"></i></td>  
                                        <td>
                                            <div class="btn-group">
                                                <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down"></span></a>
                                                <ul class="dropdown-menu pull-right">
                                                    <li>
                                                    <a href="#" data-toggle="modal" data-target="#unitModal" data-title="Brick and Mortar" data-type="mortar" data-id="<?= $mortarObj->getId();?>" data-action="edit" data-name="<?=$mortarObj->getAttr('name');?>" data-cl="<?=$mortarObj->getAttr('class');?>"><?= __('EDIT') ?></a></li>
                                                    <li><a href="<?=PATH;?>unit/delete/<?=$mortarObj->getId();?>"><?= __('DELETE') ?></a></li>
                                                </ul>
                                            </div>
                                        </td>	
                                    </tr>
                                    <? endforeach;?>
                                    <? endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md margin-right-10">
                                <i class="icon-bar-chart theme-font-color hide"></i>
                                <span class="caption-subject theme-font-color bold uppercase"><?= __('UNIT_PROFESSIONS') ?></span>
                            </div>
                            <div class="actions">
                                <?= $unitModal;?>
                                <a href="#" class="btn btn-circle btn-default btn-sm" data-toggle="modal" data-target="#unitModal" data-type="profession" data-action="add">
                                    <i class="fa fa-plus"></i><?= __('UNIT_ADD_PROFESSIONS') ?></a>
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-hover table-light">
                                <thead>
                                    <tr>
                                        <th><?= __('NAME') ?></th>
                                        <th><?= __('ICON_NAME') ?></th>
                                        <th><?= __('ICON') ?></th>
                                        <th><?= __('ACTION') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? if(count($professionObjs) > 0):?>
                                    <? foreach($professionObjs as $professionObj):?>
                                    <tr>
                                        <td><?= $professionObj->getName();?></td>
                                        <td><?= $professionObj->getAttr('class');?></td>
                                        <td><i class="<?= $professionObj->getAttr('class');?>"></i></td>  
                                        <td>
                                            <div class="btn-group">
                                                <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down"></span></a>
                                                <ul class="dropdown-menu pull-right">
                                                    <li>
                                                    <a href="#" data-toggle="modal" data-target="#unitModal" data-type="profession" data-id="<?= $professionObj->getId();?>" data-action="edit" data-name="<?=$professionObj->getAttr('name');?>" data-cl="<?=$professionObj->getAttr('class');?>"><?= __('EDIT') ?></a></li>
                                                    <li><a href="<?=PATH;?>unit/delete/<?=$professionObj->getId();?>"><?= __('DELETE') ?></a></li>
                                                </ul>
                                            </div>
                                        </td>	
                                    </tr>
                                    <? endforeach;?>
                                    <? endif;?>

                                </tbody>
                            </table>
                        </div>      
                    </div>               

                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md margin-right-10">
                                <i class="icon-bar-chart theme-font-color hide"></i>
                                <span class="caption-subject theme-font-color bold uppercase"><?= __('UNIT_SCHOOLS') ?></span>
                            </div>
                            <div class="actions">
                                <?= $unitModal;?>
                                <a href="#" class="btn btn-circle btn-default btn-sm" data-toggle="modal" data-target="#unitModal" data-type="school" data-action="add">
                                    <i class="fa fa-plus"></i><?= __('UNIT_ADD_SCHOOL') ?></a>
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-hover table-light">
                                <thead>
                                    <tr>
                                        <th><?= __('NAME') ?></th>
                                        <th><?= __('ICON_NAME') ?></th>
                                        <th><?= __('ICON') ?></th>
                                        <th><?= __('ACTION') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? if(count($schoolObjs) > 0):?>
                                    <? foreach($schoolObjs as $schoolObj):?>
                                    <tr>
                                        <td><?= $schoolObj->getName();?></td>
                                        <td><?= $schoolObj->getAttr('class');?></td>
                                        <td><i class="<?= $schoolObj->getAttr('class');?>"></i></td>  
                                        <td>
                                            <div class="btn-group">
                                                <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down"></span></a>
                                                <ul class="dropdown-menu pull-right">
                                                    <li>
                                                    <a href="#" data-toggle="modal" data-target="#unitModal" data-type="profession" data-id="<?= $schoolObj->getId();?>" data-action="edit" data-name="<?=$schoolObj->getAttr('name');?>" data-cl="<?=$schoolObj->getAttr('class');?>"><?= __('EDIT') ?></a></li>
                                                    <li><a href="<?=PATH;?>unit/delete/<?=$schoolObj->getId();?>"><?= __('DELETE') ?></a></li>
                                                </ul>
                                            </div>
                                        </td>	
                                    </tr>
                                    <? endforeach;?>
                                    <? endif;?>

                                </tbody>
                            </table>
                        </div>      
                    </div>               

                </div>
                <!---- SECOND COL -->
                <div class="col-md-6 col-sm-6">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md margin-right-10">
                                <i class="icon-bar-chart theme-font-color hide"></i>
                                <span class="caption-subject theme-font-color bold uppercase"><?= __('UNIT_SERVICES') ?></span>
                            </div>
                            <div class="actions">
                                <?= $unitModal;?>
                                <a href="#" class="btn btn-circle btn-default btn-sm" data-toggle="modal" data-target="#unitModal" data-type="amenity" data-action="add">
                                    <i class="fa fa-plus"></i><?= __('UNIT_ADD_SERVICES') ?></a>
                                <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-hover table-light">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Icon name</th>
                                        <th>Icon</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? if(count($amenityObjs) > 0):?>
                                    <? foreach($amenityObjs as $amenityObj):?>
                                    <tr>
                                        <td><?= $amenityObj->getAttr('name');?></td>
                                        <td><?= $amenityObj->getAttr('class');?></td>
                                        <td><i class="<?= $amenityObj->getAttr('class');?>"></i></td>  
                                        <td>
                                            <div class="btn-group">
                                                <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down"></span></a>
                                                <ul class="dropdown-menu pull-right">
                                                    <li>
                                                    <a href="#" data-toggle="modal" data-target="#unitModal" data-type="amenity" data-id="<?= $amenityObj->getId();?>" data-action="edit" data-name="<?=$amenityObj->getAttr('name');?>" data-cl="<?=$amenityObj->getAttr('class');?>">Edit</a></li>
                                                    <li><a href="<?=PATH;?>unit/delete/<?=$amenityObj->getId();?>">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>	
                                    </tr>
                                    <? endforeach;?>
                                    <? endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div> 


                </div>
            </div>
        </div>
    </div>
