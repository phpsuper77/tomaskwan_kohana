<!-- Modal -->
<div class="modal fade" id="addSpecOfferModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
      </div>
      
	 <div class="modal-body text-center">
        <h3 class="font-book mb20">ADD SPECIAL OFFER</h3>
			<div class="clearfix"></div>
			<form id="addSpecOfferForm" class="form-horizontal" role="form" action="<?= PATH;?>specoffer/add" method="post" enctype="multipart/form-data">
				<div class="form-body">
					<div class="form-group">
						<label class="col-md-3 control-label">Special Offer Name</label>
						<div class="col-md-8">
                        	<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-font"></i></span>
								<input class="form-control" placeholder="Enter name" type="text" name="name" required="required" />
                        	</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-group">
						<label class="col-md-3 control-label">Category</label>
						<div class="col-md-5" style="padding-left:23px;">
							<select class="form-control" name="category">
                                <option value="item">Item</option>
                                <option value="class">Class</option>
                                <option value="booking">Booking</option>
							</select>
						</div>
					</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label">Max. users (optional)</label>
						<div class="col-md-5">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-male"></i></span>
								<input class="form-control" placeholder="Maximum" type="text" name="max" />
							</div>
						</div>
					</div>
                    
                    <div class="form-group">
						<label class="col-md-3 control-label">Expire date (optional)</label>
						<div class="col-md-5">
							<div class="input-group date date-picker" data-date-format="mm/dd/yyyy" data-date-start-date="+0d">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input class="form-control" type="text" name="date_to" />
							</div>
						</div>
					</div>
                    
                    <div class="form-group">
						<label class="col-md-3 control-label">Price</label>
						<div class="col-md-5">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-usd"></i></span>
								<input class="form-control" placeholder="0.00" type="text" name="price" required="required" />
							</div>
						</div>
					</div>
                    
                    <div class="form-group">
                    <label class="col-md-3 control-label">Picture</label>
                    <div class="col-md-8">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-new thumbnail">
                            <img id="specoffer-pic" style="height:320px;" src="<?=Model_Specoffer::DEFAULT_IMAGE?>" alt="" />
							</div>
                          	<div id="crop_img" class="fileinput-preview fileinput-exists" style="line-height: 10px;"></div>
							<div>
                           		<span class="btn default btn-file">
									<span class="fileinput-new">Select image </span>
									<span class="fileinput-exists">Change </span>
									<input type="hidden" id="crop_x" name="x"/>
									<input type="hidden" id="crop_y" name="y"/>
									<input type="hidden" id="crop_w" name="w"/>
									<input type="hidden" id="crop_h" name="h"/>
                                	<input name="offer" type="file" />
								</span>
							</div>
						</div>
                    </div>
					</div>
                    
                    <div class="form-group">
                    	<label class="col-md-3 control-label">Special Offer Text</label>
                        <div class="col-md-8">
                        	<textarea class="form-control" name="text" rows="5"></textarea>
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
