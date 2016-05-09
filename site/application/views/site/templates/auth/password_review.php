<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>Password Reset</h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>

            <? $error = Cookie::get('error');?>
            <? if($error):?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <?=$error?></div>
            <? endif; ?>
            <? Cookie::delete('error');?>

            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-8">
                    <!-- BEGIN FORGOT PASSWORD FORM -->
                    <form class="password-reset-form" action="<?=PATH?>auth/password_reset" method="post">
                        <p> Please specify a new passsword. </p>
                        <div class="form-group">
                            <div class="input-icon">
                                <input class="form-control placeholder-no-fix" type="text" value="<?= $email ?>" placeholder="Email" name="email" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <input class="form-control placeholder-no-fix" type="text" value="<?= $code ?>" placeholder="Auth Code" name="code" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password Again" name="password_again"/>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn red"> Reset</button>
                        </div>
                    </form>
                    <!-- END FORGOT PASSWORD FORM -->
                </div>
            </div>
        </div>
    </div>
</div>
<div id="before-footer"></div>
