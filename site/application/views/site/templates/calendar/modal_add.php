<!-- Modal -->
<div class="modal fade" id="addBookingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
      </div>
      
	 <div class="modal-body text-center">
        <h3 class="font-book mb20">ADD SESSIONS</h3>
			<div class="clearfix"></div>
			<form id="addClassForm" class="form-horizontal" role="form" action="/cart/add_sessions" method="post">
                <input type="hidden" name="owner_id" value="<?= $userObj->getId();?>">
				<div class="form-body">
					<div class="form-group">
                        <label class="col-md-1 control-label">Trainer:</label>
						<div class="col-md-8">
                        	<div class="input-group">
                                <img src="<?= $userObj->getAvatarImageUrl();?>" class="img-circle avatar-40" alt="" />
                                <label class="control-label"><?= $userObj->getName();?></label>
                                <? $superiorObj = $userObj->getSuperiorObj(); ?>
                                <? if ($superiorObj) { ?>
                                <label class="control-label">&nbsp;of <?= $superiorObj->getName();?></label>
                                <? } ?>
                        	</div>
						</div>
					</div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Location</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody id="details"></tbody>
                    </table>
                    
					<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-2 col-md-9">
                                <input type="hidden" name="id" value="" />
								<button type="submit" class="btn green">Order</button>
							</div>
						</div>
					
                   </div>  
                    </div>
               </form>
			</div>               
		</div>
	</div>
</div>
