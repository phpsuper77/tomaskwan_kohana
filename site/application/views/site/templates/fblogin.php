<div class="row">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</div>
<div class="row">
    <div class="col-xs-4"></div>
    <div class="col-xs-3">
        <img src="http://graph.facebook.com/<?= $fbProfile->getField("id") ?>/picture?type=large">
        <p><?= $fbProfile->getField("name") ?></p>
        <p>&nbsp;</p>
    </div>
    <div class="col-xs-3">
        <img src="<?=IMG;?>FB-f-Logo__blue_100.png">
    </div>
    <div class="col-xs-4"></div>
</div>
<div class="row">
    <div class="col-xs-4"></div>
    <div class="col-xs-6">
        <div class="content"> 
            <!-- BEGIN LOGIN FORM -->
            <? if ($userObj): ?>
            <form class="fblogin-form" action="/auth/fbconnect" method="post">
                <input type="hidden" name="base_url" value="<?= PATH;?>" />
                <input type="hidden" name="submit" value="ok" />
                <input type="hidden" name="accessToken" value="<?=$accessToken?>" />
                <h3 class="form-title">Almost there! Is this you?</h3>

                <div class="alert alert-danger"> <span>Please enter your gymhit password below to authorize the facebook connect. </span> </div>
                <div class="form-group"> 
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
                    <div class="input-icon">
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" value="<?= $userObj->getEmail() ?>" required="required" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <div class="input-icon">
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" required="required" />
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-modal-action btn-login-green w176"> Connect</button> <a href="/" class="btn btn-modal-action btn-login-green w176"> Cancel</a>
                </div>
            </form>
            <? else: ?>
            <h3>Sorry, we could not locate your gymhit account. If you are new to gymhit, please sign up first and then connect your account with facebook.</h3>
            <? endif; ?>
            <!-- END LOGIN FORM --> 
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <div>
            </div>
            <div class="col-xs-4"></div>
        </div>
        <div class="row">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </div>
