<!-- Modal -->
<div class="modal fade" id="addLocationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
      </div>
      
	 <div class="modal-body text-center">
        <h3 class="font-book mb20">ADD LOCATION</h3>
			<div class="clearfix"></div>
			<form class="form-horizontal" role="form" action="<?= PATH;?>location/add" method="post">
				<div class="form-body">

                    <div class="form-group">
                        <label class="col-md-3 control-label">Addresss</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                <input class="form-control" placeholder="Address" type="text" name="address" required="required" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">City</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                <input class="form-control" placeholder="City" type="text" name="city" required="required" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">State</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                <input class="form-control" placeholder="State" type="text" name="state" required="required" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Zip</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                <input class="form-control" placeholder="Zip" type="text" name="zip" required="required" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Room (Optional)</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                <input class="form-control" placeholder="Room" type="text" name="room" />
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-3 control-label">NOTE (Optional)</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                <input class="form-control" placeholder="Note" type="text" name="note" />
                            </div>
                        </div>
                    </div>
                    
					<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-2 col-md-9">
                            	<input type="hidden" name="submit" value="add" />
                                <input type="hidden" name="id" value="" />
								<button type="submit" class="btn green">Save</button>
							</div>
						</div>
					
                   </div>  
                    </div>
               </form>
			</div>               
		</div>
	</div>
</div>
