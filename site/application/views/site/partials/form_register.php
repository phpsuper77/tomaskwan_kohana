            <!-- BEGIN REGISTRATION FORM -->
            <form class="register-form" action="javascript:;" method="post" id="register-form">
              <input type="hidden" name="base_url" value="<?= PATH;?>" />
              <input type="hidden" name="submit" value="ok" />
              <h3><?= __('SIGN_UP') ?></h3>
              <div id="regform">
                <div class="form-group">
                  <label class="control-label"><?= __('ACCOUNT_TYPE') ?></label>
                  <select name="role" class="form-control">
                    <option value="<?=Model_User::ROLE_USER ?>"><?= __('ROLE_'.Model_User::ROLE_USER)?></option>
                    <option value="<?=Model_User::ROLE_BUSINESS?>"><?= __('ROLE_'.Model_User::ROLE_BUSINESS)?></option>
                    <option value="<?=Model_User::ROLE_TRAINER?>"><?= __('ROLE_'.Model_User::ROLE_TRAINER)?></option>
                    <option value="<?=Model_User::ROLE_SCHOOL?>"><?= __('ROLE_'.Model_User::ROLE_SCHOOL)?></option>
                  </select>
                </div>
                <div id="speciality" class="form-group dn">
                  <label class="control-label"><?= __('SPECIALTY') ?></label>
                  <select name="mortar" class="form-control">
                    <? foreach($mortarObjs as $mortarObj):?>
                    <option value="<?=$mortarObj->getName();?>">
                    <?=$mortarObj->getName();?>
                    </option>
                    <? endforeach;?>
                  </select>
                </div>
                <div id="profession" class="form-group dn">
                  <label class="control-label"><?= __('PROFESSION') ?></label>
                  <select name="profession" class="form-control">
                    <? foreach($professionObjs as $professionObj):?>
                    <option value="<?=$professionObj->getName();?>">
                    <?=$professionObj->getName();?>
                    </option>
                    <? endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label visible-ie8 visible-ie9"><?= __('NAME') ?></label>
                  <div class="input-icon">
                    <input class="form-control placeholder-no-fix" type="text" placeholder="<?= __('SIGNUP_NAME_EX') ?>" name="name" required="required"/>
                  </div>
                </div>
                <div class="form-group"> 
                  <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                  <label class="control-label visible-ie8 visible-ie9"><?= __('EMAIL') ?></label>
                  <div class="input-icon">
                    <input class="form-control placeholder-no-fix" type="text" placeholder="<?= __('SIGNUP_EMAIL_EX') ?>" name="email" required="required"/>
                  </div>
                </div>
                <div id="birth_date" class="form-group">
                  <label class="control-label visible-ie8 visible-ie9"><?= __('DATE_OF_BIRTH') ?></label>
                  <div class="input-group date date-picker" data-date-format="mm/dd/yyyy">
                    <input class="form-control" type="text" name="birth_date" placeholder="<?= __('SIGNUP_DOB_EX') ?>" />
                    <span class="input-group-btn">
                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                    </span> </div>
                </div>
                <div id="address" class="form-group dn">
                  <label class="control-label visible-ie8 visible-ie9"><?= __('ADDRESS') ?></label>
                  <div class="input-icon">
                    <input class="form-control placeholder-no-fix" type="text" placeholder="<?= __('SIGNUP_ADDRESS_EX') ?>" name="address"/>
                  </div>
                </div>
                <div id="acity" class="form-group dn">
                  <label class="control-label visible-ie8 visible-ie9"><?= __('CITY') ?></label>
                  <div class="input-icon">
                    <input class="form-control placeholder-no-fix" type="text" placeholder="<?= __('SIGNUP_CITY_EX') ?>" name="city"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label visible-ie8 visible-ie9"><?= __('ZIP') ?></label>
                  <div class="input-icon">
                    <input class="form-control placeholder-no-fix" type="text" placeholder="<?= __('SIGNUP_ZIP_EX') ?>" name="zip" required="required"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label visible-ie8 visible-ie9"><?= __('PHONE') ?></label>
                  <div class="input-icon">
                    <input class="form-control placeholder-no-fix" type="text" placeholder="<?= __('SIGNUP_PHONE_EX') ?>" name="phone"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label visible-ie8 visible-ie9"><?= __('PASSWORD') ?></label>
                  <div class="input-icon">
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="<?= __('SIGNUP_PASSWORD_EX') ?>" name="password" required="required"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label visible-ie8 visible-ie9"><?= __('PASSWORD_RETYPE') ?></label>
                  <div class="controls">
                    <div class="input-icon">
                      <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="<?= __('SIGNUP_PASSWORD_RETYPE_EX') ?>" name="rpassword" required="required"/>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="tos">
                  <div class="checker"><span>
                    <input name="tnc" type="checkbox">
                    </span> </div>
                  I agree to the <a target="_blank" href="<?=PATH;?>static/terms_of_use"> Terms of Service </a> and <a target="_blank" href="<?=PATH;?>static/privacy"> Privacy Policy </a>
                  </label>
                  <div id="register_tnc_error"> </div>
                </div>
                <div class="form-actions">
                  <button type="submit" id="register-submit-btn" class="btn btn-modal-action btn-signup-green"><?= __('SIGN_UP') ?></button>
                </div>
              </div>
              <div id="progress2" class="dn" style="text-align:center;">
                <h2><?= __('REGISTRATING') ?></h2>
                <span><i class="fa fa-spinner fa-pulse fa-4x"></i></span> </div>
              <div id="res_register"></div>
            </form>
            <!-- END REGISTRATION FORM --> 
