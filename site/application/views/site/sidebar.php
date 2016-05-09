<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200">
            <li class="start<?= $active == 'dashboard' ?  ' active' : '';?>">
            <a href="<?= PATH;?>dashboard"><i class="icon-home"></i><span class="title"><?= __("MENU_DASHBOARD") ?></span></a>
            </li>
            <li <?= $open == 'account' ? 'class="active open"' : '';?>>
            <a href="javascript:;">
                <i class="icon-user"></i>
                <span class="title"><?= __("MENU_ACCOUNT") ?></span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li <?= $active == 'account' ? 'class="active"' : '';?>><a href="<?= PATH;?>profile/account/<?= $loginUserObj->getAttr('id');?>"><?= __("MENU_ACCOUNT_SETTINGS") ?></a></li>
                <? if($loginUserObj->isRoleTrainer()):?>
                <li <?= $active == 'credentials' ? 'class="active"' : '';?>><a href="<?= PATH;?>profile/credentials/<?= $loginUserObj->getId();?>"><?= __("MENU_CREDENTIALS") ?></a></li>
                <? endif;?>
                <? if($loginUserObj->getRole() != 0 && $loginUserObj->getRole() != 4):?>
                <li <?= $active == 'gallery' ? 'class="active"' : '';?>><a href="<?= PATH;?>gallery/index/<?= $loginUserObj->getId();?>"><?= __("MENU_GALLERY") ?></a></li>
                <? endif;?>
            </ul>
            </li>
            <li class="start<?= $active == 'message' ?  ' active' : '';?>">
            <a href="<?= PATH;?>message/index"><i class="icon-envelope"></i><span class="title"><?= __("MENU_MESSAGES") ?></span></a>
            </li>
            <li <?= $open == 'user' ? 'class="active open"' : '';?>>
            <a href="javascript:;">
                <i class="icon-new_connections"></i>
                <span class="title"><?= __("MENU_SOCIAL") ?></span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li <?= $active == 'connections' ? 'class="active"' : '';?>><a href="<?= PATH;?>connection/list"><?= __("MENU_CONNECTIONS") ?></a></li>
                <li <?= $active == 'invitations' ? 'class="active"' : '';?>><a href="<?= PATH;?>invite/list"><?= __("MENU_INVITATIONS") ?></a></li>
            <? if ($loginUserObj->isRoleUser()) { ?>
                <li <?= $active == 'reviews' ? 'class="active"' : '';?>><a href="<?= PATH;?>myreview/list"><?= __("MENU_MY_REVIEWS") ?></a></li>
            <? } else { ?>
                <li <?= $active == 'reviews' ? 'class="active"' : '';?>><a href="<?= PATH;?>review/list"><?= __("MENU_REVIEWS") ?></a></li>
            <? } ?>
            </ul>
            </li>
            <? if($loginUserObj->isRoleServiceProvider()):?>
            <li <?= $open == 'business' ? 'class="active open"' : '';?>>
            <a href="javascript:;">
                <i class="fa fa-building"></i>
                <span class="title"><?= __("MENU_BUSINESS") ?></span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <? if($loginUserObj->isRoleHost()):?>
                <li <?= $active == 'staff' ? 'class="active"' : '';?>><a href="<?= PATH;?>staff/list"><?= __("MENU_STAFF") ?></a></li>
                <? else:?>
                <li <?= $active == 'staffof' ? 'class="active"' : '';?>><a href="<?= PATH;?>staffof/list"><?= __("MENU_STAFF_OF") ?></a></li>
                <? endif;?>
                <li <?= $active == 'location' ? 'class="active"' : '';?>>
                <a href="<?= PATH;?>location/list"><?= __("MENU_LOCATIONS") ?></a></li>
                <li <?= $active == 'invoice' ? 'class="active"' : '';?>>
                <a href="<?= PATH;?>invoice/list"><?= __("MENU_INVOICES") ?></a></li>
            </ul>
            </li>
            <? endif; ?>
            <? if($loginUserObj->isRoleBusiness()):?>
            <li <?= $open == 'marketing' ? 'class="active open"' : '';?>>
            <a href="javascript:;">
                <i class="fa fa-suitcase"></i>
                <span class="title"><?= __("MENU_MARKETING") ?></span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li <?= $active == 'spec_offer' ? 'class="active"' : '';?>>
                <a href="<?= PATH;?>specoffer/list"><?= __("MENU_OFFERS") ?></a></li>
                <li <?= $active == 'free_pass' ? 'class="active"' : '';?>>
                <a href="<?= PATH;?>freepass/list"><?= __("MENU_PASSES") ?></a></li>
            </ul>
            </li>
            <? endif;?>
            <? if(!$loginUserObj->isRoleSchool()){?>
            <li <?= $open == 'calendar' ? 'class="active open"' : '';?>>
            <a href="javascript:;">
                <i class="fa fa-calendar"></i>
                <span class="title"><?= __("MENU_CALENDAR") ?></span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li <?= $active == 'calendar' ? 'class="active"' : '';?>>
                <a href="<?= PATH;?>mycalendar/show"><?= __("MENU_MY_CALENDAR") ?></a></li>
            </ul>
            </li>
            <? }?>
            <? if($loginUserObj->isRoleServiceProvider()):?>
            <li <?= $open == 'booking' ? 'class="active open"' : '';?>>
            <a href="javascript:;">
                <i class="fa fa-ticket"></i>
                <span class="title"><?= __("MENU_OFFERINGS") ?></span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
            <? if(!$loginUserObj->isRoleSchool()){?>
                <li <?= $active == 'available' ? 'class="active"' : '';?>>
                <a href="<?= PATH;?>available/list"><?= __("MENU_AVAILABILITY") ?></a></li>
            <? } ?>
                <li <?= $active == 'class' ? 'class="active"' : '';?>>
                <a href="<?= PATH;?>class/list"><?= __("MENU_CLASSES") ?></a></li>
            </ul>
            </li>
            <? endif;?>
            <? if(!$loginUserObj->isRoleSchool()){?>
            <li <?= $open == 'purchased' ? 'class="active open"' : '';?>>
            <a href="javascript:;">
                <i class="fa fa-trophy"></i>
                <span class="title"><?= __("MENU_BOOKINGS") ?></span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li <?= $active == 'myevents' ? 'class="active"' : '';?>>
                <a href="<?= PATH;?>myevent/list"><?= __("MENU_MY_EVENTS") ?></a></li>
                <? if($loginUserObj->isRoleUser()):?>
                <li <?= $active == 'offers' ? 'class="active"' : '';?>>
                <a href="<?= PATH;?>myoffer/list"><?= __("MENU_MY_OFFERS") ?></a></li>
                <? endif;?>
            </ul>
            </li>
            <? }?>
            <? if(!$loginUserObj->isRoleAdmin() && !$loginUserObj->isRoleTrainer()):?>
            <li <?= $open == 'payment' ? 'class="active open"' : '';?>>
            <a href="javascript:;">
                <i class="fa fa-money"></i>
                <span class="title"><?= __("MENU_ORDERS") ?></span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <? if($loginUserObj->isRoleUser()):?>
                <li <?= $active == 'cart' ? 'class="active"' : '';?>>
                <a href="<?= PATH;?>cart/list"><?= __("MENU_CART") ?></a></li>
                <li <?= $active == 'order' ? 'class="active"' : '';?>>
                <a href="<?= PATH;?>myorder/list"><?= __("MENU_MY_ORDERS") ?></a></li>
                <? endif;?>
                <? if($loginUserObj->isRoleServiceProvider()):?>
                <li <?= $active == 'order' ? 'class="active"' : '';?>>
                <a href="<?= PATH;?>order/list"><?= __("MENU_RECEIVED_ORDERS") ?></a></li>
                <? endif;?>
            </ul>
            </li>
            <? endif;?>
            <? if($loginUserObj->isRoleServiceProvider()):?>
            <li <?= $open == 'job' ? 'class="active open"' : '';?>>
            <a href="javascript:;">
                <i class="fa fa-briefcase"></i>
                <span class="title"><?= __("MENU_JOBS") ?></span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <? if($loginUserObj->isRoleHost()):?>
                <li <?= $active == 'seeker' ? 'class="active"' : '';?>>
                <a href="<?= PATH;?>job/seeker"><?= __("MENU_FOR_HIRE") ?></a></li>
                <? endif; ?>
                <? if($loginUserObj->isRoleTrainer()):?>
                <li <?= $active == 'employer' ? 'class="active"' : '';?>>
                <a href="<?= PATH;?>job/employer"><?= __("MENU_JOB_OPP") ?></a></li>
                <? endif; ?>
            </ul>
            </li>
            <? endif;?>
            <? if($loginUserObj->isRoleAdmin()):?>
            <li <?= $open == 'admin' ? 'class="active open"' : '';?>>
            <a href="javascript:;">
                <i class="icon-settings"></i>
                <span class="title"><?= __("MENU_SITE") ?></span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li <?= $active == 'units' ? 'class="active"' : '';?>><a href="<?= PATH;?>unit/list"><?= __("MENU_UNITS") ?></a></li>
                <li <?= $active == 'user' ? 'class="active"' : '';?>><a href="<?= PATH;?>alluser/list"><?= __("MENU_USERS") ?></a></li>
                <li <?= $active == 'task' ? 'class="active"' : '';?>><a href="<?= PATH;?>task/list"><?= __("MENU_TASKS") ?></a></li>
            </ul>
            </li>
            <? endif;?>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->
