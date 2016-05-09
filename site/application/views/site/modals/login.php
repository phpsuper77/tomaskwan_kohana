<div class="modal fade" id="loginBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <!-- BEGIN BODY -->
        <div class="login"> 
          <!-- END SIDEBAR TOGGLER BUTTON --> 
          <!-- BEGIN LOGIN -->
          <div class="content"> 
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="javascript:;" method="post">
              <input type="hidden" name="base_url" value="<?= PATH;?>" />
              <input type="hidden" name="submit" value="ok" />
              <h3 class="form-title">Login to Your Account</h3>
              <div class="alert alert-danger display-hide"> <span>Enter any email and password. </span> </div>
              <div class="form-group"> 
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Email</label>
                <div class="input-icon">
                  <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" required="required" />
                </div>
              </div>
              <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <div class="input-icon">
                  <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" required="required" />
                </div>
              </div>
              <div class="form-actions">
                <label>
                <div class="checker"><span>
                  <input name="tnc" type="checkbox">
                  </span></div>
                Remember Me
                </label>
                <button type="submit" class="btn btn-modal-action btn-login-green"> Login</button>
              </div>
              <div>
		<p> - OR - </p>
              </div>
              <div>
			<div class="fb-login-button" onlogin="checkLoginState();" data-scope="<?=Kohana::$config->load('site.fb.perms')?>" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="false">	</div>
              </div>
              <div id="res_login">
              </div>
              <div class="forget-password">
                <h4>Forgot your password ?</h4>
                <p> no worries, click <a href="javascript:;" id="forget-password"> here </a> to reset your password. </p>
              </div>
            </form>
            <!-- END LOGIN FORM --> 
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form class="forget-form" action="<?=PATH?>auth/password_forgot" method="post">
              <h3>Forget Password ?</h3>
              <p> Enter your e-mail address below to reset your password. </p>
              <div class="form-group">
                <div class="input-icon">
                  <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" required="required"/>
                </div>
              </div>
              <div class="form-actions">
                <button type="button" id="back-btn" class="btn red">Back</button>
                <button type="submit" class="btn red pull-right"> Submit</button>
              </div>
            </form>
            <!-- END FORGOT PASSWORD FORM --> 
          </div>
          <!-- END LOGIN --> 
          
        </div>
      </div>
    </div>
  </div>
</div>
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
