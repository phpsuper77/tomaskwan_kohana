<!-- Modal -->
<div class="modal fade" id="messageModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
					<div class="commment-avatar no-padding fl"></div>
					<div class="fl font-medium mt3">
						<div id="name" class="fs16 green"></div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<form id="message_send" class="not-logged" action="#" method="post">
				<div class="mb10">
					<input type="text" name="name" class="direct-input mr5" placeholder="NAME" />
					<input type="text" name="email" class="direct-input" placeholder="EMAIL" />
                    <input type="hidden" name="send_url" value="<?=PATH;?>message/send" />
                    <input type="hidden" name="user_arr[]" value="" />
                    <input type="hidden" name="submit" value="ok" />
				</div>
				<textarea name="text" placeholder="Enter Your message" class="direct-message mb20"></textarea>
				<div class="clearfix"></div>
				<a id="nl_send_msg2" href="#" class="directory_profile-button directory_profile-button_book_appointment no-margin w176 mt20 not-active">SEND</a>
			</form>
			<br />
     	</div>
    </div>
  </div>
</div>
