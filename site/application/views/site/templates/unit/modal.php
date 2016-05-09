<!-- Modal -->
<div class="modal fade" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
      </div>
      
	 <div class="modal-body text-center">
        <h3 class="font-book mb20"><span id="type" class="uppercase"></span></h3>
			<div class="clearfix"></div>
			<form class="form-horizontal" role="form" action="<?= PATH;?>unit/list/<?=$type;?>" method="post">
				<div class="form-body">
					<div class="form-group">
						<label class="col-md-3 control-label">Name</label>
						<div class="col-md-9">
                        	<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-font"></i></span>
								<input class="form-control" type="text" name="name" required="required" value="" />
                        	</div>
						</div>
					</div>
					
                    <div class="form-group">
						<label class="col-md-3 control-label">Icon class</label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-cog"></i></span>
								<input class="form-control" type="text" name="class" required="required" value="" />
							</div>
						</div>
					</div>
					<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-2 col-md-9">
                            	<input type="hidden" name="submit" value="" />
                                <input type="hidden" name="type" value="" />
                                <input type="hidden" name="id" value="" />
								<button type="submit" class="btn green uppercase"></button>
							</div>
						</div>
					
                   	</div>  
                    </div>
               </form>
			</div>               
		</div>
	</div>
</div>
