<!-- Modal -->
<div class="modal fade" id="addBookingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
      </div>
      
	 <div class="modal-body text-center">
        <h3 class="font-book mb20">ADD BOOKING</h3>
			<div class="clearfix"></div>
			<form class="form-horizontal" role="form" action="<?= PATH;?>booking/index" method="post">
				<div class="form-body">
                    <? if($mode != 'dashboard' && $mode != 'cart'):?>
                    <div class="form-group">
						<label class="col-md-3 control-label">User</label>
						<div class="col-md-8">
							<select name="user_id" class="form-control select2me" data-placeholder="Select user">
								<option value=""></option>
								<? foreach($memberObjs as $memberObj):?>
                                	<option value="<?=$memberObj->getId();?>"><?=$memberObj->getName();?></option>
								<? endforeach;?>
							</select>
						</div>
					</div>                  
                    <div class="form-group">
						<label class="col-md-3 control-label">Trainer</label>
						<div class="col-md-8">
							<select name="trainer_id" id="trainer_book" class="form-control select2me" data-placeholder="Select trainer">
								<option value=""></option>
								<? foreach($trainerObjs as $trainerObj):?>
                                	<option data-price="<?=$trainerObj->getAttr('price');?>" value="<?=$trainerObj->getId();?>"><?=$trainerObj->getName();?> - <?=$trainerObj->getAttr('title');?></option>
								<? endforeach;?>
							</select>
						</div>
					</div>
                    <? endif;?>
                    
                    <div class="form-group">
						<label class="col-md-3 control-label">Date and time</label>
						<div class="col-md-8">
							<input class="form-control" type="datetime" name="date" readonly="readonly" />
						</div>
					</div>
                    
                    <div class="form-group">
                    	<span id="progress" class="dn"><i class="fa fa-spinner fa-pulse fa-2x"></i></span>
                    	<div class="col-md-12" id="calendar"></div>
                    </div>
                    
					<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-2 col-md-9">
                            	<input type="hidden" name="submit" value="add" />
                                <input type="hidden" name="mode" value="" />
                                <input type="hidden" name="sum" value="" />
                                <input type="hidden" name="id" value="" />
                                <input type="hidden" name="jsbase" value="<?=JS;?>" />
                                <input type="hidden" name="curl" value="<?=PATH;?>booking/table_calendar" />
                                <? if($mode == 'dashboard' || $mode == 'cart'):?>
                                <input type="hidden" name="trainer_id" value="" />
                                <? endif;?>
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
