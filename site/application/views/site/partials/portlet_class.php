                                <!-- BEGIN PORTLET -->
                                <div class="portlet light">
                                    <div class="portlet-title">
                                        <span class="caption-subject font-blue-madison bold uppercase"><?= $title ?></span>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="gh-title"><?= __('ID') ?></div>
                                        <div class="gh-value"><?= $classObj->getId() ?></div>
                                        <div class="gh-title"><?= __('NAME') ?></div>
                                        <div class="gh-value"><?= $classObj->getName() ?></div>
                                        <div class="gh-title"><?= __('DATE') ?></div>
                                        <div class="gh-value"><?= $classObj->getDateFrom() ?> - <?= $classObj->getDateTo() ?></div>
                                        <div class="gh-title"><?= __('TIME') ?></div>
                                        <div class="gh-value"><?= $classObj->getTimeFrom() ?> - <?= $classObj->getTimeTo() ?></div>
                                        <div class="gh-title"><?= __('DAYS') ?></div>
                                        <div class="gh-value"><?= $classObj->getWeekdays() ?></div>
<? $locationObj = $classObj->getLocationObj() ?>
                                        <div class="gh-title"><?= __('LOCATION') ?></div>
                                        <div class="gh-value"><?= $locationObj?$locationObj->getFullName():'' ?></div>
                                        <div class="gh-title"><?= __('DESCRIPTION') ?></div>
                                        <div class="gh-value"><?= $classObj->getDescription() ?></div>
<? if ($paid) { ?>
                                        <div class="gh-title"><?= __('INSTRUCTIONS') ?></div>
                                        <div class="gh-value"><?= $classObj->getInstructions() ?></div>
<? } ?>
                                    </div>
                                </div>
                                <!-- END PORTLET -->
