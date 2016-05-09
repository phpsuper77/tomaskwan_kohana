<!-- Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
      </div>
      
	 <div class="modal-body text-center">
     	<div id="message3_res"></div>
        <h3 class="font-book mb20">Send Direct Message</h3>
		    <div class="float_center mt10m mb20">
				<div class="float_center_childrens">
					<div class="commment-avatar no-padding fl">
						<img src="<?=$userObj->getAvatarUrl() ? $userObj->getAvatarUrl() : IMG.'logo_avatar.png';?>" class="img-circle" alt="">
					</div>
					<div class="fl font-medium mt3">
						<div class="fs16 green"><?=$userObj->getTruncatedName();?></div>
						<div class="fs11"><?=$userObj->getTitle() ? $userObj->getTitle() : '';?></div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<form id="reply_message_send" action="#" method="post">
				<textarea id="text" name="text" placeholder="Enter Your message" class="direct-message mb20"></textarea>
                <input type="hidden" name="send_url" value="<?=PATH;?>message/send" />
                <input type="hidden" name="user_arr[]" value="<?=$userObj->getId();?>" />
                <input type="hidden" name="submit" value="ok" />
				<div class="clearfix"></div>
                <span id="reply_progress3" class="dn"><i class="fa fa-spinner fa-pulse fa-4x" style="text-align:center;"></i></span>
				<span id="reply_msgbutton">
                <a href="#" id="reply_send_msg" class="directory_profile-button directory_profile-button_book_appointment no-margin w176 mt20">SEND</a>
                </span>
			</form>
			<br />
     	</div>
    </div>
  </div>
</div>
