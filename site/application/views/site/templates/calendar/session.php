<?= $addBookingModal ?>
<div id="boxes">
    <div class="container-schedule">			
            <!-- BEGIN PAGE BREADCRUMB -->
        <div class="row">
            <div class="col-md-12">
                <p>&nbsp;</p>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <a href="<?=PATH;?>page/<?= $pageObj->getRoute(); ?>"><?= $userObj->getName() ?></a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?=PATH;?>calendar/session/<?= $pageObj->getRoute(); ?>">Book A Private Sessions</a>
                       </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?= Partial::user_page_portlet($loginUserObj, $userObj); ?>
                            <div class="portlet light">
                                <div class="portlet-body">
                    <div><h3></h3></div>
                    <table id="staffof-legend">
                    <tr class="staffof-host" id="staffof-host-<?= $userObj->getId(); ?>">
                        <td class="staffof-name"><?= Partial::user_badge_small($loginUserObj, $userObj, 30) ?></td>
                        <td class="staffof-value"><div class="staffof-color"></div></td>
                    </tr>
<? foreach ($staffOfObjs as $staffOfObj) { ?>
    <? $hostObj = $staffOfObj->getHostObj(); ?>
                    <tr class="staffof-host" id="staffof-host-<?= $hostObj->getId(); ?>">
                        <td class="staffof-name"><?= Partial::user_badge_small($loginUserObj, $hostObj, 30) ?></td>
                        <td class="staffof-value"><div class="staffof-color"></div></td>
                    </tr>
<? } ?>
                    </table>
                                </div>
                              </div>
            </div>
            <div class="col-md-6">

            <? if ($userObj->canAcceptSession()):?>
                            <div class="portlet light">
                                <div class="portlet-body">
                    <div id="calendar-session" class="calendar"></div>
                                </div>
                              </div>
            <? else:?>
                    <div class="text-center pt45">
                        <p><?= __('NO SESSION OFFERED CURRENTLY') ?></p>
                    </div>
                    <div class="text-center pt45">
                    </div>
            <? endif;?>

            </div>
            <div class="col-md-3">
                            <div class="portlet light">
                                <div class="portlet-body">
                    <div>
                    <p><?= __('Please select the time by clicking on the available time slot in the calendar.') ?></p></div>
                    <div><h3><?= __('SELECTED SESSIONS') ?>:</h3></div>
                    <ul id="sessionSelectedTimes">
                    </ul>
                    <p>&nbsp;</p>
                    <div>
                        <form id="addSessionForm" method="post" action="/cart/add_sessions">
                            <input type="hidden" name="owner_id" value="<?= $userObj->getId() ?>">
<? if (!$loginUserObj) { ?>
        <a href="#" class="btn green-haze generic-modal-trigger" data-title="<?= __('OPS') ?>" data-content="<?= __('YOU MUST LOGIN TO BOOK A SESSION.') ?>"><?= __('BOOK SESSIONS') ?></a>
<? } else if ($loginUserObj->isRoleUser()) { ?>
                        <input id="submit" type="submit" class="btn green" value="<?= __('BOOK SESSIONS') ?>">
<? } else { ?>
        <a href="#" class="btn green-haze generic-modal-trigger" data-title="<?= __('OPS') ?>" data-content="<?= __('THIS FEATURE IS FOR USER ONLY.') ?>"><?= __('BOOK SESSIONS') ?></a>
<? } ?>
                        </form>
                    </div>

                                </div>
                              </div>
            </div>
        </div>
        <div class="row">
            <p><br/></p>
        </div>
    </div>
</div>

<script>
$(function() {
    GYMHIT_SESSION_MANAGER.init('#calendar-session','/calendar','<?=$pageObj->getRoute();?>', '<?= date('Y-m-d', time() + 60 * 60 * 24 * 7);?>');
});
</script>
