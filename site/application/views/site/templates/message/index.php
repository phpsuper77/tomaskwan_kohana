<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="page-head">
                <div class="page-title">
                    <h1><?= __("MENU_MESSAGES") ?></h1>
                </div>
            </div>

            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?= PATH;?>dashboard"><?= __("MENU_DASHBOARD") ?></a>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <a href="<?= PATH;?>message/index"><?= __("MENU_MESSAGES") ?></a>
                </li>
            </ul>
            <div class="clearfix"></div>

            <div class="portlet light">

                <div class="portlet-body">
                    <div class="row margin-top-10 inbox">
                        <div class="col-md-2">
                            <ul class="inbox-nav margin-bottom-10">
                                <li class="inbox active">
                                <a href="javascript:;" class="btn" data-title="Inbox" data-url="<?= PATH;?>message/list/inbox">
                                    <?=__('MSG_INBOX')?> <span id="check"><?= $unchecked ? '(<span id="unchecked">'.$unchecked.'</span>)' : '';?></span></a>
                                <b></b>
                                </li>
                                <li class="sent">
                                <a class="btn" href="javascript:;" data-title="Sent" data-url="<?= PATH;?>message/list/sent">
                                    <?=__('MSG_SENT')?> </a>
                                <b></b>
                                </li>
                                <li class="trash">
                                <a class="btn" href="javascript:;" data-title="Trash" data-url="<?= PATH;?>message/list/trash">
                                    <?=__('MSG_TRASH')?> </a>
                                <b></b>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-10">
                            <div class="inbox-header">
                                <h1 class="pull-left"><?= __('MSG_INBOX')?></h1>
                                <?=$newMessageModal;?>                         
                                <button class="btn green pull-right" data-toggle="modal" data-target="#messageModal2">
                                    <i class="fa fa-envelope-o"></i> <?=__('MSG_NEW')?></button>
                            </div>
                            <div class="inbox-loading">
                                <?= __('LOADING') ?>
                            </div>
                            <div class="inbox-content">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    </div>
</div>
