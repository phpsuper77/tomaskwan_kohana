<h3>Hello <?=$userObj->getName();?>!</h3><br />
You recently requested to reset your account password.
<br/>
Please click the following link to continue.
<br/>
<a href="<?=Kohana::$config->load('site.main.url')?>auth/password_review?email=<?=$userObj->getEmail();?>&code=<?=$code?>">Password Reset Link</a>
<br/>
If you did not request this information, please contact GymHit customer support immediately.
