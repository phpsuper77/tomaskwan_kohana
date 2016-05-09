<!-- Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
      </div>
      
	 <div class="modal-body text-center">
        <h3 class="font-book mb20">ASSOCIATE CONNECTION AS STAFF</h3>
			<div class="clearfix"></div>
<? if (count($connectedObjs) == 0) { ?>
            <p>You do not have any connection. You can create staff from existing connections.</p>
<? } else { ?>
			<form class="form-horizontal" role="form" action="<?= PATH;?>staff/add" method="post">
				<div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?= __('CONNECTION') ?></label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
<select name="user_id" class="form-control">
  <? foreach ($connectedObjs as $connectedObj) { ?>
      <option value="<?= $connectedObj->getId() ?>"><?= $connectedObj->getName() ?></option>
  <? } ?>
</select>
                            </div>
                        </div>
                    </div>

					<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-2 col-md-9">
                            	<input type="hidden" name="submit" value="add" />
								<button type="submit" class="btn green">Add</button>
							</div>
				        </div>
                    </div>
                    </div>
               </form>
<? } ?>
			</div>               
		</div>
	</div>
</div>
