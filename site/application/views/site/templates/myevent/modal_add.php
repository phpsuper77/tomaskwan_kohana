<!-- Modal -->
<div class="modal fade" id="addCustomEventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
      </div>
      
	 <div class="modal-body text-center">
        <h3 class="font-book mb20">SEND EVENT</h3>
			<div class="clearfix"></div>
			<form id="addCustomEventForm" class="form-horizontal" role="form" action="<?= PATH;?>myevent/add_custom" method="post">
				<div class="form-body">

                    <div class="form-group">
						<label class="col-md-3 control-label">Target User</label>
						<div class="col-md-5">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<select name="owner_id" class="form-control">
<? foreach ($friendObjs as $friendObj) { ?>
                                    <option value="<?= $friendObj->getId();?>"><?= $friendObj->getName() ?></option>
<? } ?>
								</select>
							</div>
						</div>
					</div>
                    
                    <div class="form-group">
						<label class="col-md-3 control-label">Date</label>
						<div class="col-md-5">
							<div class="input-group date date-picker" data-date-format="mm/dd/yyyy" data-date-start-date="+0d">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input class="form-control" type="text" name="date" value="<?= date('m/d/Y') ?>" />
							</div>
						</div>
					</div>

                    <div class="form-group">
						<label class="col-md-3 control-label">Start time</label>
						<div class="col-md-5">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                <input class="form-control" type="text" name="time_from" value="01:00 PM" />
							</div>
						</div>
					</div>

                    <div class="form-group">
						<label class="col-md-3 control-label">End time</label>
						<div class="col-md-5">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                <input class="form-control" type="text" name="time_to" value="02:00 PM" />
							</div>
						</div>
					</div>

                    <div class="form-group">
						<label class="col-md-3 control-label">Location</label>
						<div class="col-md-5">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-building"></i></span>
								<select name="location_id" class="form-control">
<? foreach ($locationObjs as $locationObj) { ?>
                                    <option value="<?= $locationObj->getId();?>"><?= $locationObj->getFullName() ?></option>
<? } ?>
								</select>
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
                        <label class="col-md-3 control-label">Message</label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="text" rows="5">
Hi there!

I would like to invite to a private session. You can see the details by clicking the
"Add To Cart" button below.
                            </textarea>
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
