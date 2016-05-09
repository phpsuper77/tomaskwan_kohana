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
		    <form id="message_send" class="form-horizontal" action="#" method="post">
            <div class="form-body">
					
            <div class="form-group">
				<label class="col-md-3 control-label">User</label>
				<div class="col-md-8">
                    <select id="select2_users" class="form-control" name="user_arr[]" multiple="multiple">
  						<? foreach($userObjs as $userObj):?>
                        <option value="<?=$userObj->getId();?>"><?=$userObj->getTruncatedName();?></option>
                        <? endforeach;?>
					</select>
                </div>
			</div>
			<div class="clearfix"></div><br />
				<div class="form-group">
                <label class="col-md-1 control-label"></label>
				<div class="col-md-10">
                	<textarea name="text" placeholder="Enter Your message" class="direct-message mb20"></textarea>
                </div>
                <input type="hidden" name="send_url" value="<?=PATH;?>message/send" />
                <input type="hidden" name="submit" value="ok" />
                <? if($mode != 'new'):?>
                	<input type="hidden" name="user_to" value="" />
                <? endif;?>
                <div class="clearfix"></div>
                <span id="progress3" class="dn"><i class="fa fa-spinner fa-pulse fa-4x" style="text-align:center;"></i></span>
				<span id="msgbutton">
                <a href="#" id="send_msg2" class="directory_profile-button directory_profile-button_book_appointment no-margin w176 mt20">SEND</a>
                </span>
                </div>
                </div>
			</form>
			<br />
     	</div>
    </div>
  </div>
</div>
