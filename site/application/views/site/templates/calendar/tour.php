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
                        <a href="<?=PATH;?>calendar/tour/<?= $pageObj->getRoute(); ?>">Book A Tour</a>
                       </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?= Partial::user_page_portlet($loginUserObj, $userObj); ?>
            </div>
            <div class="col-md-6">

                            <div class="portlet light">
                                <div class="portlet-body">
                    <div id="calendar-tour" class="calendar"></div>
                                </div>
                              </div>

            </div>
            <div class="col-md-3">
                            <div class="portlet light">
                                <div class="portlet-body">
                    <div>
                    <p>Please select the time by clicking on the available time slot in the calendar.</p></div>
                    <div><h3>Selected Time:</h3></div>
                    <div id="tourSelectedTimes">
                        <div class="gh-value">NONE</div>
                    </div>
                    <p>&nbsp;</p>
                    <div>
                        <form id="addTourForm" method="post" action="/calendar/tour_book">
                            <input type="hidden" name="owner_id" value="<?= $userObj->getId() ?>">
                            <input type="hidden" name="start_time" value="">
                            <input type="hidden" name="end_time" value="">
                            <input type="hidden" name="location_id" value="">
<? if (!$loginUserObj) { ?>
        <a href="#" class="btn green-haze generic-modal-trigger" data-title="<?= __('OPS') ?>" data-content="<?= __('YOU MUST LOGIN TO BOOK A TOUR.') ?>"><?= __('BOOK A TOUR') ?></a>
<? } else if ($loginUserObj->isRoleUser()) { ?>
                        <input type="submit" class="btn green" value="<?= __('BOOK A TOUR') ?>">
<? } else { ?>
        <a href="#" class="btn green-haze generic-modal-trigger" data-title="<?= __('OPS') ?>" data-content="<?= __('THIS FEATURE IS FOR USER ONLY.') ?>"><?= __('BOOK A TOUR') ?></a>
                        </form>
<? } ?>
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
    GYMHIT_TOUR_MANAGER.init('#calendar-tour','/calendar','<?=$pageObj->getRoute();?>', '<?= date('Y-m-d', time() + 60 * 60 * 24 * 7);?>');
});
</script>
