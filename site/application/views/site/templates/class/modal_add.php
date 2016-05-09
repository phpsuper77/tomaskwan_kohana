<!-- Modal -->
<div class="modal fade" id="addClassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
      </div>
      
	 <div class="modal-body text-center">
        <h3 class="font-book mb20"><?= __('ADD_CLASS') ?></h3>
			<div class="clearfix"></div>
			<form id="addClassForm" class="form-horizontal" role="form" action="/class/add" method="post" enctype="multipart/form-data">
				<div class="form-body">
					<div class="form-group">
						<label class="col-md-3 control-label"><?= __('NAME') ?></label>
						<div class="col-md-8">
                        	<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-font"></i></span>
								<input class="form-control" placeholder="Enter name" type="text" name="name" required="required" />
                        	</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label"><?= __('DESCRIPTION') ?></label>
						<div class="col-md-8">
                        	<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-font"></i></span>
								<input class="form-control" placeholder="Description" type="text" name="description" />
                        	</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label"><?= __('INSTRUCTIONS') ?></label>
						<div class="col-md-8">
                        	<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-font"></i></span>
								<input class="form-control" placeholder="Instructions shown to who has signed up" type="text" name="instructions" />
                        	</div>
						</div>
					</div>

                    <div class="form-group">
						<label class="col-md-3 control-label"><?= __('LOCATION') ?></label>
						<div class="col-md-8">
                        	<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-building"></i></span>
<select name="location_id" class="form-control">
    <? foreach ($locationObjs as $locationObj) { ?>
        <option value="<?= $locationObj->getId() ?>"><?= $locationObj->getFullName() ?></option>
    <? } ?>
</select>
                        	</div>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label"><?= __('MAX_MEMBERS') ?> (<?= __('OPTIONAL') ?>)</label>
						<div class="col-md-8">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-male"></i></span>
								<input class="form-control" placeholder="Maximum" type="text" name="max" />
							</div>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label"><?= __('TRAINER') ?></label>
						<div class="col-md-8">
							<select class="form-control" name="trainer_id">
<? if ($loginUserObj->isRoleTrainer()) { ?>
                                	<option value="<?=$loginUserObj->getId();?>"><?=$loginUserObj->getName();?></option>
<? } else { ?>
								<? foreach($staffObjs as $staffObj):?>
								    <? $trainerObj = $staffObj->getUserObj(); ?>
                                	<option value="<?=$trainerObj->getId();?>"><?=$trainerObj->getName();?> - <?=$trainerObj->getAttr('title');?></option>
								<? endforeach;?>
<? } ?>
							</select>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label"><?= __('START_DATE') ?></label>
						<div class="col-md-5">
							<div class="input-group date date-picker" data-date-format="mm/dd/yyyy" data-date-start-date="+0d">
								<input class="form-control" type="text" name="date_from" required="required" />
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label"><?= __('END_DATE') ?></label>
						<div class="col-md-5">
							<div class="input-group date date-picker" data-date-format="mm/dd/yyyy" data-date-start-date="+0d">
								<input class="form-control" type="text" name="date_to" required="required" />
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label"><?= __('START_TIME') ?></label>
						<div class="col-md-5">
							<div class="input-group">
								<input class="form-control timepicker timepicker-no-seconds" type="text" name="time_from" required="required" />
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
								</span>
							</div>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label"><?= __('END_TIME') ?></label>
						<div class="col-md-5">
							<div class="input-group">
								<input class="form-control timepicker timepicker-no-seconds" type="text" name="time_to" required="required" />
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
								</span>
							</div>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label"><?= __('WEEK_TIME') ?></label>
						<div class="col-md-5">
							<div class="input-group">
								<select multiple="multiple" class="multi-select" id="my_multi_select1" name="week[]">
									<option value="1"><?= __('MONDAY') ?></option>
									<option value="2"><?= __('TUESDAY') ?></option>
									<option value="3"><?= __('WEDNESDAY') ?></option>
									<option value="4"><?= __('THURSDAY') ?></option>
									<option value="5"><?= __('FRIDAY') ?></option>
									<option value="6"><?= __('SATURDAY') ?></option>
									<option value="7"><?= __('SUNDAY') ?></option>
								</select>
							</div>
						</div>
					</div>

                    <div class="form-group">
                    <label class="col-md-3 control-label">Picture</label>
                    <div class="col-md-8">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                            <img id="class-pic" style="height:320px;" src="<?=Model_Class::DEFAULT_IMAGE?>" alt="" />
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
                                    <input name="image" type="file" />
                                </span>
                            </div>
                        </div>
                    </div>
                    </div>
                    
                    <div class="form-group">
						<label class="col-md-3 control-label"><?= __('PRICE') ?></label>
						<div class="col-md-8">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
<? if ($loginUserObj->canAcceptOrder()) { ?>
								<input class="form-control" placeholder="Enter price" type="text" name="price" value="0.0" required="required" />
<? } else { ?>
								<input class="form-control" placeholder="Enter price" type="text" name="price" value="0.0" readonly />
<? } ?>
							</div>
						</div>
					</div>

                    
					<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-2 col-md-9">
                                <input type="hidden" name="id" value="" />
								<button type="submit" class="btn green"><?= __('ACTION_SAVE') ?></button>
							</div>
						</div>
					
                   </div>  
                    </div>
               </form>
			</div>               
		</div>
	</div>
</div>
