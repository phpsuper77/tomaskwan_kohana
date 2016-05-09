<div class="page-container">
    <?= $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content"> 
            <!-- BEGIN PAGE HEADER--> 
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head"> 
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><?= __('MENU_GALLERY') ?></h1>
                </div>
                <!-- END PAGE TITLE --> 

            </div>
            <!-- END PAGE HEAD -->
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li><a href="<?= PATH;?>dashboard"><?= __('MENU_DASHBOARD') ?></a><i class="fa fa-circle"></i></li>
                <li><?= __('MENU_ACCOUNT') ?><i class="fa fa-circle"></i></li>
                <li><a href="<?= PATH;?>gallery/index/<?= $loginUserObj->getId();?>"><?= __('MENU_GALLERY') ?></a></li>
            </ul>
            <!-- END PAGE BREADCRUMB --> 
            <!-- END PAGE HEADER--> 
            <!-- BEGIN PAGE CONTENT-->
            <div class="row margin-top-10">
                <div class="col-md-12">
                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                    <div class="row fileupload-buttonbar">
                        <div class="col-lg-7" style="margin-bottom:20px;"> 
                            <!-- The fileinput-button span is used to style the file input field as button --> 
                            <span id="show-add" class="btn green" style="width:86px;"><i class="fa fa-plus"></i> <?= __('ACTION_ADD') ?></span>
                            <!--
                            <button type="button" class="btn red delete"><i class="fa fa-trash-o"></i><span> Delete</span> </button>
                            -->
                        </div>
                    </div>

                    <div id="add-image" class="dn">
                        <form class="form-horizontal" action="#" id="gallery-form">
                            <div class="form-group">
                                <label class="col-md-2 control-label"><strong><?= __('TITLE') ?></strong></label>
                                <div class="col-md-8">
                                    <input class="form-control" placeholder="Image title" type="text" name="title" required="required" />
                                    <input type="hidden" name="type" value="gallery" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label"><strong><?= __('ACTION_PREVIEW') ?></strong></label>
                                <div class="col-md-6">           
                                    <div class="fileinput" data-provides="fileinput">
                                        <div id="gallery" class="fileinput-preview fileinput-exists"></div><br />
                                        <span class="btn btn-warning fileinput-button"><i class="fa fa-plus"></i> <?= __('ACTION_ADD_IMAGE') ?>
                                            <input name="picture" type="file" /></span>
                                    </div>
                                </div>
                            </div>		

                            <div class="form-group" style="text-align:center;">
                                <div class="col-md-12">
                                    <button type="button" class="image-add btn green" data-url="<?= PATH;?>gallery/add/<?=$loginUserObj->getId();?>" data-jsbase="<?=JS;?>"><?= __('ACTION_SAVE') ?></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- The table listing the files available for upload/download -->
                    <table role="presentation" class="table table-striped clearfix" style="margin-top:20px;">
                        <tbody class="files">
                            <? if(count($imageObjs) > 0):?>
                            <? foreach($imageObjs as $imageObj):?>
                            <tr id="image-<?=$imageObj->getId();?>" class="template-download fade in">
                                <td>
                                    <span class="preview">                        
                                        <a href="<?=$imageObj->getImageUrl();?>" title="<?=$imageObj->getTitle();?>" download="<?=$imageObj->getTitle();?>" data-gallery="">
                                            <img src="<?=$imageObj->getImageUrl();?>" style="width:120px;"></a>    
                                    </span>
                                </td>
                                <td>
                                    <p class="name"><strong><?=$imageObj->getTitle();?></strong></p>
                                </td>
                                <td align="right">
                                    <button class="image-delete btn red btn-sm" data-id="<?=$imageObj->getId();?>" data-url="<?= PATH;?>gallery/delete/<?=$loginUserObj->getId();?>">
                                        <i class="fa fa-trash-o"></i>
                                        <span><?= __('ACTION_DELETE') ?></span>
                                    </button>
                                    <!--
                                    <input name="delete[]" value="<?=$imageObj->getId();?>" class="toggle" type="checkbox">
                                    -->
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
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"> </div>
    <h5 class="title"></h5>
    <a class="prev"> ‹ </a> <a class="next"> › </a> <a class="close white"> </a> <a class="play-pause"> </a>
    <ol class="indicator">
    </ol>
</div>
