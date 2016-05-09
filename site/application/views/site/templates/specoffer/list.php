<div class="page-container">
    <?=$sidebar;?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><?= __('MENU_SPECIAL_OFFERS') ?></h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>

            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?=PATH;?>dashboard"><?= __('MENU_DASHBOARD') ?></a>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <?= __('MENU_MARKETING') ?>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <a href="<?=PATH;?>specoffer/index"><?= __('MENU_SPECIAL_OFFERS') ?></a>
                </li>

            </ul>
            <div class="clearfix"></div>
            <!-- END PAGE BREADCRUMB -->
            <? $success = Cookie::get('success');?>
            <? if($success == 'addOffer'):?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                New special offer successfully added!</div>
            <? endif; ?>
            <? if($success == 'editOffer'):?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                Special offer successfully updated!</div>
            <? endif; ?>
            <? Cookie::delete('success');?>
            <? $superiorObj = $loginUserObj->getSuperiorObj(); ?>
            <? if ($superiorObj) { ?>
            <? if (!$superiorObj->canAcceptOrder()) { ?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">Your company has not setup the payment key, and you cannot take orders without the key.</div>
            <? } ?>
            <? } else { ?>
            <? if (!$loginUserObj->canAcceptOrder()) { ?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">You have not setup the <a href="/profile/account/<?= $loginUserObj->getId();?>#billing">payment key</a>, and you cannot take orders without the key.</div>
            <? } ?>
            <? } ?>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row margin-top-10">
                <div class="col-md-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md margin-right-10">
                                <i class="icon-bar-chart theme-font-color hide"></i>
                                <span class="caption-subject theme-font-color bold uppercase"><?= __('INFO_SPECIAL_OFFERS') ?></span>
                            </div>

                            <div class="actions">
                                <?= $addSpecOfferModal;?>
                                <a href="#" class="btn btn-circle btn-default btn-sm" data-toggle="modal" data-target="#addSpecOfferModal">
                                    <i class="fa fa-plus"></i> Add Special Offer</a></a>

                            <a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" title=""></a>
                        </div>                                
                    </div>
                    <div class="portlet-body" style="height: auto;">
                        <div class="table-scrollable table-scrollable-borderless">
                            <table id="ajax-table" class="table table-hover table-light" data-jsbase="<?=JS;?>" data-url="<?= PATH;?>specoffer/list_ajax/" data-page="1" data-order="desc" data-sort="id">
                                <thead>
                                    <tr class="uppercase no-hover">
                                        <th id="start" class="sorting" data-order="desc" data-sort="name"><?=__('ID')?></th>
                                        <th class="sorting" data-order="asc" data-sort="name"><?=__('NAME')?></th>
                                        <th class="sorting" data-order="asc" data-sort="category"><?=__('CATEGORY')?></th>
                                        <th><?=__('EXPIR_DATE')?></th>
                                        <th><?=__('MAX_MEMBERS')?></th>
                                        <th class="sorting" data-order="asc" data-sort="price"><?=__('PRICE')?></th>
                                        <th class="sorting" data-order="asc" data-sort="active"><?=__('STATUS')?></th>
                                        <th><?=__('ACTION')?></th>
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
        <!-- END PAGE CONTENT-->
    </div>
</div>

<script>
    $(document).ready(function() {
        tableList($('#start'));
    });
</script>
