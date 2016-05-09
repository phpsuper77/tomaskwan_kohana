<!-- Modal -->
<div class="modal fade" id="freePassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
      </div>
      
	 <div class="modal-body text-center">
     	<div id="message3_res"></div>
        <h3 class="font-book mb20">FREE PASS</h3>
		    <div class="float_center mt10m mb20">
				<div class="float_center_childrens">
					<div class="commment-avatar no-padding fl">
						<img src="<?=$pageObj->getAvatarUrl() ? $pageObj->getAvatarUrl() : IMG.'logo_avatar.png';?>" class="img-circle" alt="">
					</div>
					<div class="fl font-medium mt3">
						<div class="fs16 green"><?=$pageObj->getName();?></div>
						<div class="fs11"><?=$pageObj->getTitle() ? $pageObj->getTitle() : '';?></div><br />
						<div class="fs12">Message with code has been sent to you</div>
                        <div class="fs14">Your code:</div>
                        <div id="code" class="fs18 green" style="text-align:center;"><span><i class="fa fa-spinner fa-pulse fa-2x"></i></span></div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<input type="hidden" name="owner_id" value="<?=$pageObj->getUserId();?>" />
            <input type="hidden" name="furl" value="<?=PATH;?>freepass/add" />
			<br />
     	</div>
	</div>
    </div>
</div>
