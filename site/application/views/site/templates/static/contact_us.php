<div class="page-container">
    <?= $sidebar;?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>CONTACT US</h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>

            <!-- BEGIN PAGE BREADCRUMB -->
            <div class="clearfix"></div>
            <!-- END PAGE BREADCRUMB -->

            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->

            <div class="row">
                <div class="col-md-6">

            <? $success = Cookie::get('success');?>
            <? if($success):?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <?= $success?></div>
            <? Cookie::delete('success');?>
            <? endif;?>

                            <form action="/static/send_us" method="post">

<div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Name</label>
                <div class="input-icon">
                  <input class="form-control placeholder-no-fix" type="text" placeholder="Name" name="name" required="required" />
                </div>
              </div>
<div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Email</label>
                <div class="input-icon">
                  <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email" required="required" />
                </div>
              </div>
<div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Message</label>
                <div class="input-icon">
                  <textarea rows="10" class="form-control placeholder-no-fix" placeholder="Message" name="message" required="required" /></textarea>
                </div>
              </div>
<button type="submit" class="btn btn-modal-action btn-login-green"> Send</button>
                            </form>

                </div>
                <div class="col-md-6">
                    <ul style="list-style: none;">
                        <li>GymHit, Inc.</li>
                        <li>1111 H Street, Suite 207</li>
                        <li>Sacramento CA 95814</li>
                        <li>916.573.5660</li>
                        <li><a href="mailto:support@gymhit.com">support@gymhit.com</a></li>
                    </ul>
                </div>
            </div> <!-- row -->
        </div>
    </div>
</div>
<div id="before-footer"></div>
