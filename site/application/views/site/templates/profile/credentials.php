<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue-madison bold uppercase"><?= __('MENU_CREDENTIALS') ?></span>
                    </div>
                </div>
                <div class="portlet-body">

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
                        <form class="form-horizontal" action="#">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><strong><?= __('NAME') ?></strong></label>
                                <div class="col-md-7">
                                    <input class="form-control" placeholder="Image title" type="text" name="title" required="required" />
                                    <input type="hidden" name="type" value="credential" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"><strong><?= __('ACTION_PREVIEW') ?></strong></label>
                                <div class="col-md-6">           
                                    <div class="fileinput" data-provides="fileinput">
                                        <div id="credential" class="fileinput-preview fileinput-exists"></div><br />
                                        <span class="btn btn-warning fileinput-button"><i class="fa fa-plus"></i> <?= __('ACTION_ADD_IMAGE') ?>
                                            <input name="picture" type="file" /></span>
                                    </div>
                                </div>
                            </div>		

                            <div class="form-group" style="text-align:center;">
                                <div class="col-md-12">
                                    <button type="button" class="image-add btn green" data-url="<?= PATH;?>gallery/add/<?=$id;?>" data-jsbase="<?=JS;?>"><?= __('ACTION_SAVE') ?></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- The table listing the files available for upload/download -->
                    <table role="presentation" class="table table-striped clearfix" style="margin-top:20px;">
                        <tbody class="files">
                            <? if(count($credentialObjs) > 0):?>
                            <? foreach($credentialObjs as $credentialObj):?>
                            <tr id="image-<?=$credentialObj->getId();?>" class="template-download fade in">
                                <td>
                                    <span class="preview">                        
                                        <a href="<?=$credentialObj->getImageUrl();?>" title="<?=$credentialObj->getTitle();?>" download="<?=$credentialObj->getTitle();?>" data-gallery="">
                                            <img src="<?=$credentialObj->getImageUrl();?>" style="width:120px;"></a>    
                                    </span>
                                </td>
                                <td>
                                    <p class="name"><strong><?=$credentialObj->getTitle();?></strong></p>
                                </td>
                                <td align="right">
                                    <button class="image-delete btn red btn-sm" data-id="<?=$credentialObj->getId();?>" data-url="<?= PATH;?>gallery/delete/<?=$credentialObj->getId();?>">
                                        <i class="fa fa-trash-o"></i>
                                        <span><?= __('DELETE') ?></span>
                                    </button>
                                    <!--
                                    <input name="delete[]" value="<?=$credentialObj->getId();?>" class="toggle" type="checkbox">
                                    -->
                                </td>
                            </tr>
                            <? endforeach;?>
                            <? endif;?>
                        </tbody>
                    </table> 
                    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
                        <div class="slides"> </div>
                        <h5 class="title"></h5>
                        <a class="prev"> ‹ </a> <a class="next"> › </a> <a class="close white"> </a> <a class="play-pause"> </a>
                        <ol class="indicator">
                        </ol>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PROFILE CONTENT -->
