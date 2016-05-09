<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <? $success = Cookie::get('success');?>
                    <? if($success == 'updatePersonal'):?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Personal info updated successfully!</div>
                    <? endif;?>
                    <? if($success == 'updateAvatar'):?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Avatar updated successfully!</div>
                    <? endif;?>
                    <? if($success == 'updateBackground'):?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Your site background updated successfully!</div>
                    <? endif;?>
                    <? if($success == 'updatePassword'):?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Your password updated successfully!</div>
                    <? endif;?>
                    <? if($success == 'updateSettings'):?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Your site settings updated successfully!</div>
                    <? endif;?>
                    <? if($success == 'updateBilling'):?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Your billing settings updated successfully!</div>
                    <? endif;?>
                    <? Cookie::delete('success');?>
                    <? if($modelSettings->checkTime($profileUserObj->getId())==FALSE && $profileUserObj->isRoleBusiness()):?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Please working time!</div>
                    <? endif;?>
                    <? if (!$loginUserObj->isActive()) { ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Your account is currently INACTIVE. Please contact support@gymhit.com for further action.</div>
                    <? } ?>
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue-madison bold uppercase"><?= __('MENU_ACCOUNT_SETTINGS') ?></span>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                        <a aria-expanded="true" href="#personal" data-toggle="tab"><?= __('MENU_PERSONAL') ?></a>
                        </li>
                        <li class="">
                        <a aria-expanded="false" href="#avatar" data-toggle="tab"><?= __('MENU_AVATAR') ?>  <? $profileUserObj->getRole() != 0 ? '& Background' : '';?></a>
                        </li>
                        <li>
                        <a href="#password" data-toggle="tab"><?= __('MENU_PASSWORD') ?></a>
                        </li>
                        <? //if(($loginUserObj->getRole() != Model_User::ROLE_TRAINER || $profileUserObj->getSuperiorId() == null) && $profileUserObj->getRole() != 0):?>
                        <li class="">
                        <a aria-expanded="false" href="#settings" data-toggle="tab"><?= __('MENU_PROFILE') ?></a>
                        </li>
                        <? if($loginUserObj->isRoleHost()): ?>
                        <? endif;?>
                        <? //endif;?>
                        <? if($profileUserObj->isRoleServiceProvider() || $profileUserObj->isRoleTrainer()): ?>
                        <li class="">
                        <a aria-expanded="false" href="#billing" data-toggle="tab"><?= __('MENU_BILLING') ?></a>
                        </li>
                        <? endif;?>
                        <li class="">
                        <a aria-expanded="false" href="#social" data-toggle="tab"><?= __('MENU_SOCIAL') ?></a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <!-- PERSONAL INFO TAB -->
                        <div class="tab-pane active" id="personal">
                            <form role="form" action="<?=PATH;?>profile/account/<?=$profileUserObj->getId();?>" method="post">
                                <div class="form-group">
                                    <label class="control-label"><strong><?= __('NAME') ?></strong></label>
                                    <input name="name" class="form-control" type="text" value="<?= $profileUserObj->getName();?>" />
                                </div>
                                <? if($profileUserObj->getRole() != Model_User::ROLE_USER && $profileUserObj->getRole() != Model_User::ROLE_ADMIN):?>
                                <div class="form-group">
                                    <label class="control-label"><strong><?= $profileUserObj->isRoleBusiness() ? __('TYPE OF BUSINESS') : ($profileUserObj->isRoleSchool() ? __('TYPE OF SCHOOL') : __('TYPE OF PROFESSIONAL'));?></strong></label>
                                    <select class="form-control" name="title">
                                        <? foreach($titleObjs as $titleObj):?> 
                                        <option value="<?=$titleObj->getId();?>" <?= $titleObj->getId()==$profileUserObj->getTitle() ? 'selected="selected"' : '';?>>
                                        <?=$titleObj->getAttr('name');?></option>
                                        <? endforeach;?>
                                    </select>
                                </div>
                                <? endif;?>
                                <div class="form-group">
                                    <label class="control-label"><strong><?= __('EMAIL') ?></strong></label>
                                    <input class="form-control" type="text" value="<?=$profileUserObj->getEmail();?>" disabled="disabled" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><strong><?= __('BIRTH_DATE') ?></strong></label>
                                    <input class="form-control" type="text" value="<?=$profileUserObj->getBirthDate();?>" disabled="disabled" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><strong><?= __('ADDRESS') ?></strong></label>
                                    <input name="address" class="form-control" type="text" value="<?= $profileUserObj->getAddress();?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><strong><?= __('CITY') ?></strong></label>
                                    <input name="city" class="form-control" type="text" value="<?= $profileUserObj->getCity();?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><strong><?= __('STATE') ?></strong></label>
                                    <input name="state" class="form-control" type="text" value="<?= $profileUserObj->getState();?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><strong><?= __('ZIP') ?></strong></label>
                                    <input name="zip" class="form-control" type="text" value="<?= $profileUserObj->getZip();?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><strong><?= __('PHONE') ?></strong></label>
                                    <input name="phone" class="form-control" type="text" value="<?= $profileUserObj->getPhone();?>" />
                                </div>
                                <? if($profileUserObj->getRole() != 0 && $profileUserObj->getRole() != Model_User::ROLE_TRAINER):?>
                                <div class="form-group">
                                    <label class="control-label"><strong><?= $profileUserObj->isRoleHost() ? __('AMENITIES') .'/'. __('SERVICES') : __('INTERESTS');?>
                                    </strong></label>
                                    <table class="table table-light">
                                        <tbody>
                                            <tr>
                                                <? $i=1;
                                                foreach($unitObjs as $unitObj):?>
                                                <td>
                                                    <label class="uniform-inline">
                                                        <div class="checker">
                                                            <input name="unit[<?=$unitObj->getId();?>]" value="1" type="checkbox" <?= $userUnits[$unitObj->getId()] == 1 ? 'checked="checked"' : '';?> />
                                                    </div> <i class="<?= $unitObj->getAttr('class');?>"></i> <?= $unitObj->getName();?></label>
                                                </td>
                                                <? if($i%4 == 0):?>
                                                </tr><tr>
                                                <? endif;
                                                $i++;?>
                                                <? endforeach;?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <? endif;?>
                                <? if($profileUserObj->getRole() != Model_User::ROLE_USER && $profileUserObj->getRole() != 0):?>
                                <div class="form-group">
                                    <label class="control-label"><strong><? __('BIOGRAPHY') ?></strong></label>
                                    <textarea class="form-control" name="about" rows="3"><?= $profileUserObj->getAbout();?></textarea>
                                </div>
                                <? endif;?>
                                <div class="margiv-top-10">
                                    <input type="hidden" name="submit" value="personal" />
                                    <input type="submit" class="btn green-haze" value="<?= __('ACTION_SAVE') ?>" />
                                </div>
                            </form>
                        </div>
                        <!-- END PERSONAL INFO TAB -->
                        <!-- CHANGE AVATAR TAB -->
                        <div class="tab-pane" id="avatar">
                            <h4><?= __('SETTING_AVATAR') ?></h4>
                            <form id="avatar_form" action="<?= PATH;?>profile/account/<?=$profileUserObj->getId();?>" role="form" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                            <img src="<?= $profileUserObj->getAvatarUrl() ? $profileUserObj->getAvatarUrl() : 'http://www.placehold.it/400x400/EFEFEF/AAAAAA&amp;text=no+image';?>" alt="" />
                                        </div>
                                        <div id="crop_img" class="fileinput-preview fileinput-exists"></div>
                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"><?= __('ACTION_SELECT_IMAGE') ?> </span>
                                                <span class="fileinput-exists" style="width:150px;"><?= __('ACTION_CHANGE') ?> </span>
                                                <input type="hidden" id="crop_x" name="x"/>
                                                <input type="hidden" id="crop_y" name="y"/>
                                                <input type="hidden" id="crop_w" name="w"/>
                                                <input type="hidden" id="crop_h" name="h"/>
                                                <input name="submit" value="avatar" type="hidden" />
                                                <input name="avatar" type="file" />
                                            </span>
                                            <a href="/profile/avatar_remove" class="btn default"><?= __('ACTION_REMOVE') ?> </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="margin-top-10">
                                    <input type="submit" class="btn green-haze" value="<?= __('ACTION_SAVE') ?>" />
                                </div>
                            </form>

                            <? if($profileUserObj->getRole() != 0):?>
                            <hr class="divider">
                            <!-- SITE BACKGROUND -->
                            <form action="<?= PATH;?>profile/account/<?=$profileUserObj->getId();?>" role="form" method="post" enctype="multipart/form-data">
                                <input name="submit" value="background" type="hidden" />
                                <input name="page_id" value="<?=$profileUserObj->getPageObj()->getId()?>" type="hidden" />
                                <? if($profileUserObj->getRole() != Model_User::ROLE_USER):?>
                                <div class="form-group">
                                    <label class="control-label"><strong><?=__('SITE_BACKGROUND_TYPE')?></strong></label><br />									
                                    <label class="checkbox-inline">
                                        <input name="backtype" value="0" type="radio" <?= $profileUserObj->getPageObj()->getBackground() == null ? 'checked="checked"' : '';?> />
                                        <?=__('MAP')?> </label>
                                    <label class="checkbox-inline">
                                        <input name="backtype" value="1" type="radio" <?= $profileUserObj->getPageObj()->getBackground() != null ? 'checked="checked"' : '';?> >
                                        <?=__('IMAGE')?> </label>
                                </div>
                                <br />
                                <? endif;?>

                                <!-- IMAGE BACKGROUND -->
                                <div id="backimg"<?= $profileUserObj->getPageObj()->getBackground() == null && $profileUserObj->getRole() != Model_User::ROLE_USER ? ' class="hide"' : '';?>>
                                    <h4><?= __('SETTING_BACKGROUND') ?></h4>
                                    <div class="form-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <img src="<?= $profileUserObj->getPageObj()->getBackgroundUrl() ? $profileUserObj->getPageObj()->getBackgroundUrl() : 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image';?>" alt="" />
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new"><?= __('ACTION_SELECT_IMAGE') ?> </span>
                                                    <span class="fileinput-exists" style="width:150px;"><?= __('ACTION_CHANGE') ?> </span>
                                                    <input name="background" type="file" />
                                                </span>
                                                <a href="#" class="btn default" data-dismiss="fileinput"><?= __('ACTION_REMOVE') ?> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="margin-top-10">
                                    <input type="submit" class="btn green-haze" value="<?= __('ACTION_SAVE') ?>" />
                                </div>
                            </form>
                            <? endif;?>


                        </div>
                        <!-- END CHANGE AVATAR TAB -->
                        <!-- CHANGE PASSWORD TAB -->
                        <div class="tab-pane" id="password">
                            <form action="<?= PATH;?>profile/account/<?=$profileUserObj->getId();?>" method="post">
                                <div class="form-group">
                                    <label class="control-label"><?= __('NEW_PASSWORD') ?></label>
                                    <input class="form-control" type="password" name="password">
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?= __('NEW_PASSWORD_RETYPE') ?></label><br />
                                    <small id="pass_nmatch" class="dn" style="color:#F00;"><?=__('ERROR_PASSWORD_NOT_MATCHED')?></small>
                                    <input class="form-control" type="password" name="password2">
                                </div>
                                <div class="margin-top-10">
                                    <input name="submit" value="password" type="hidden" />
                                    <input id="pass_submit" type="submit" class="btn green-haze" value="<?= __('ACTION_SAVE') ?>" />
                                </div>
                            </form>
                        </div>
                        <!-- END CHANGE PASSWORD TAB -->
                        <!-- PROFILE SETTINGS TAB -->
                        <div class="tab-pane" id="settings">
                            <form action="<?= PATH;?>profile/account/<?=$profileUserObj->getId();?>" method="post">
                                <input name="submit" value="settings" type="hidden" />
                                <input name="superior_id" value="<?=$profileUserObj->getSuperiorId();?>" type="hidden" />
                                <table class="table table-light table-hover">
                                    <tbody>
                                        <tr>
                                            <td><?=__('PROFILE_PUBLIC')?></td>
                                            <td style="width:30%;">
                                                <label>
                                                    <input name="public" value="1" type="radio" <?= $settingObj->isPublic() ? 'checked="checked"' : '';?> />
                                                    <?=__('ON')?> </label>
                                                </td><td style="width:30%;">
                                                <label>
                                                    <input name="public" value="0" type="radio" <?= !$settingObj->isPublic() ? 'checked="checked"' : '';?> >
                                                    <?=__('OFF')?> </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?=__('PROFILE_WHO_CAN_SEE')?></td>
                                            <td>
                                                <label>
                                                    <input name="profile_view" value="1" type="radio" <?= $settingObj->isProfileView() ? 'checked="checked"' : '';?> />
                                                    <?=__('EVERYONE')?> </label>
                                                </td><td style="width:30%;">
                                                <label>
                                                    <input name="profile_view" value="0" type="radio" <?= !$settingObj->isProfileView() ? 'checked="checked"' : '';?> >
                                                    <?=__('ONLY_CONNECTED_USERS')?> </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?=__('PROFILE_EMAIL_NOTIFY')?></td>
                                            <td>
                                                <label>
                                                    <input name="email" value="1" type="radio" <?= $settingObj->isEmail() ? 'checked="checked"' : '';?> />
                                                    <?=__('ON')?> </label>
                                                </td><td>
                                                <label>
                                                    <input name="email" value="0" type="radio" <?= !$settingObj->isEmail() ? 'checked="checked"' : '';?> >
                                                    <?=__('OFF')?> </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?=__('PROFILE_SMS_NOTIFY')?></td>
                                            <td>
                                                <label>
                                                    <input name="sms" value="1" type="radio" <?= $settingObj->isSMS() ? 'checked="checked"' : '';?> />
                                                    <?=__('ON')?> </label>
                                                </td><td>
                                                <label>
                                                    <input name="sms" value="0" type="radio" <?= !$settingObj->isSMS() ? 'checked="checked"' : '';?> >
                                                    <?=__('OFF')?> </label>
                                            </td>
                                        </tr>
                                        <? if($profileUserObj->getRole() != Model_User::ROLE_USER):?>
                                        <tr>
                                            <td><?=__('PROFILE_BOOKING_WITH_GYMHIT')?></td>
                                            <td>
                                                <label>
                                                    <input name="booking" value="1" type="radio" <?= $settingObj->isBooking() ? 'checked="checked"' : '';?> />
                                                    <?=__('YES')?> </label>
                                                </td><td>
                                                <label>
                                                    <input name="booking" value="0" type="radio" <?= !$settingObj->isBooking() ? 'checked="checked"' : '';?> >
                                                    <?=__('SHOW_ONLY_PHONE_NUMBER')?> </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?=__('PROFILE_FREE_PASS_BUTTON')?></td>
                                            <td>
                                                <label>
                                                    <input name="free_pass" value="1" type="radio" <?= $settingObj->isFreePass() ? 'checked="checked"' : '';?> />
                                                    <?=__('ON')?> </label>
                                                </td><td>
                                                <label>
                                                    <input name="free_pass" value="0" type="radio" <?= !$settingObj->isFreePass() ? 'checked="checked"' : '';?> >
                                                    <?=__('OFF')?> </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?=__('PROFILE_SPECIAL_OFFERS')?></td>
                                            <td>
                                                <label>
                                                    <input name="spec_offer" value="1" type="radio" <?= $settingObj->isSpecialOffer() ? 'checked="checked"' : '';?> />
                                                    <?=__('ON')?> </label>
                                                </td><td>
                                                <label>
                                                    <input name="spec_offer" value="0" type="radio" <?= !$settingObj->isSpecialOffer() ? 'checked="checked"' : '';?> >
                                                    <?=__('OFF')?> </label>
                                            </td>
                                        </tr>
                                        <? if($profileUserObj->isRoleServiceProvider()):?>
                                        <tr>
                                            <td><?=__('PROFILE_SHOW_IN_JOB')?></td>
                                            <td>
                                                <label>
                                                    <input name="job" value="1" type="radio" <?= $settingObj->isJob() ? 'checked="checked"' : '';?> />
                                                    <?=__('ON')?> </label>
                                                </td><td>
                                                <label>
                                                    <input name="job" value="0" type="radio" <?= !$settingObj->isJob() ? 'checked="checked"' : '';?> >
                                                    <?=__('OFF')?> </label>
                                            </td>
                                        </tr>
                                        <? endif; ?>
                                        <? endif;?>
                                    </tbody>
                                </table>
                                <!--end profile-settings-->
                                <div class="margin-top-10">
                                    <input type="hidden" name="route" value="<?= $profileUserObj->getRoute();?>" />
                                    <input type="submit" class="btn green-haze" value="Save Changes" />
                                </div>
                            </form>
                        </div>
                        <!-- END PROFILE SETTINGS TAB -->

                        <!-- BILLING SETTINGS TAB -->
                        <div class="tab-pane" id="billing">
                            <? if (!$profileUserObj->canAcceptOrder()) { ?>
                            <div class="alert alert-success alert-dismissible fade in" role="alert">You have not setup the payment key, and you cannot take orders without the key.</div>
                            <? } ?>
                            <form action="<?= PATH;?>profile/account/<?=$profileUserObj->getId();?>" method="post">
                                <table class="table table-light table-hover">
                                    <tbody>
<!--
                                        <tr>
                                            <td>Billing method</td>
                                            <td style="width:25%;">
                                                <label>
                                                    <input name="period" value="1" type="radio" <?= $profileUserObj->getPeriod() == 1 ? 'checked="checked"' : '';?> <?=$profileUserObj->getId()!=$loginUserObj->getId() ? 'readonly="readonly"' : '';?> />
                                                    Monthly </label>
                                                <input class="form-control" type="text" name="price_1" value="<?=$profileUserObj->getPrice1();?>" <?=$loginUserObj->getRole()!=0 ? 'readonly="readonly"' : '';?> placeholder="0.00" style="width:120px;" />
                                                </td><td style="width:25%;">
                                                <label>
                                                    <input name="period" value="3" type="radio" <?= $profileUserObj->getPeriod() == 3 ? 'checked="checked"' : '';?> <?=$profileUserObj->getId()!=$loginUserObj->getId() ? 'readonly="readonly"' : '';?> />
                                                    Quarterly </label>
                                                <input class="form-control" type="text" name="price_3" value="<?=$profileUserObj->getPrice3();?>" <?=$loginUserObj->getRole()!=0 ? 'readonly="readonly"' : '';?> placeholder="0.00" style="width:120px;" />
                                                </td><td style="width:25%;">
                                                <label>
                                                    <input name="period" value="12" type="radio" <?= $profileUserObj->getPeriod() == 12 ? 'checked="checked"' : '';?> <?=$profileUserObj->getId()!=$loginUserObj->getId() ? 'readonly="readonly"' : '';?> />
                                                    Yearly </label>
                                                <input class="form-control" type="text" name="price_12" value="<?=$profileUserObj->getPrice12();?>" <?=$loginUserObj->getRole()!=0 ? 'readonly="readonly"' : '';?> placeholder="0.00" style="width:120px;" />
                                            </td>
                                        </tr>
-->
                                        <? if($profileUserObj->getId() == $loginUserObj->getId()):?>
                                        <tr>
                                            <td><?=__('PROFILE_PAYMENT_KEY')?></td>
                                            <td colspan="3"><input class="form-control" type="text" name="op_key" value="<?=$billingSettObj?$billingSettingObj->getAttr('op_key'):'';?>" /></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td colspan="3">
                                                <a href="https://login.netbanx.com/office/public/registration.htm?pfToken=4600|6010" target="_blank">Optimal Payments Register Page</a>
                                            </td>
                                        </tr>
                                        <? endif;?>
                                    </tbody>
                                </table>
                                <div class="margin-top-10">
                                    <input name="submit" value="billing" type="hidden" />
                                    <input type="submit" class="btn green-haze" value="<?=__('ACTION_SAVE')?>" />
                                </div>
                            </form>
                        </div>
                        <!-- END BILLING SETTINGS TAB -->
                        <div class="tab-pane" id="social">
                            <form action="<?= PATH;?>profile/account/<?=$profileUserObj->getId();?>" method="post">
                                <input name="submit" value="social" type="hidden" />
                                <table class="table table-light table-hover">
                                    <tbody>
                                        <tr>
                                            <td><?=__('FACEBOOK')?></td>
                                            <td colspan="2">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                                                    <input class="form-control" placeholder="Facebook" type="text" name="facebook" value="<?=$settingObj->getFacebook();?>" />											</div>
                                            </td>
                                            <td colspan="1">
                            <? if($profileUserObj->getFacebookId()):?>
                            <a href="/auth/fbdisconnect" class="btn btn-modal-action btn-login-green w176"><?=__('DISCONNECT')?></a>
                            &nbsp;&nbsp;<?=__('FACEBOOK_CONNECTED')?>
                            <? else: ?>
                                <div class="fb-login-button" onlogin="checkLoginState();" data-scope="<?=Kohana::$config->load('site.fb.perms')?>" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="false">    </div> &nbsp;&nbsp;<?=__('FACEBOOK_DISCONNECTED')?>
                            <? endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?=__('LINKEDIN')?></td>
                                            <td colspan="2">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
                                                    <input class="form-control" placeholder="Linked In" type="text" name="linkedin" value="<?=$settingObj->getLinkedIn();?>" />											</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?=__('PINTEREST')?></td>
                                            <td colspan="2">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-pinterest"></i></span>
                                                    <input class="form-control" placeholder="Pinterest" type="text" name="pinterest" value="<?=$settingObj->getPinterest();?>" />											</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?=__('TWITTER')?></td>
                                            <td colspan="2">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                                                    <input class="form-control" placeholder="Twitter" type="text" name="twitter" value="<?=$settingObj->getTwitter();?>" />											</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?=__('GOOGLE_PLUS')?></td>
                                            <td colspan="2">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-google-plus"></i></span>
                                                    <input class="form-control" placeholder="Google+" type="text" name="google" value="<?=$settingObj->getGoogle();?>" />											</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                <div class="margin-top-10">
                                    <input type="submit" class="btn green-haze" value="Save" />
                                </div>
                             </form>
                        </div>
                        <!-- SOCIAL TAB -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PROFILE CONTENT -->
<script>
    // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().
        if (response.status === 'connected') {
            // Logged into your app and Facebook.
            //testAPI();
            window.location = '/auth/fblogin';
            } else if (response.status === 'not_authorized') {
            // The person is logged into Facebook, but not your app.
            document.getElementById('status').innerHTML = 'Please log ' +
            'into this app.';
            } else {
            // The person is not logged into Facebook, so we're not sure if
            // they are logged into this app or not.
            document.getElementById('status').innerHTML = 'Please log ' +
            'into Facebook.';
        }
    }

    // This function is called when someone finishes with the Login
    // Button.  See the onlogin handler attached to it in the sample
    // code below.
    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }
</script>
