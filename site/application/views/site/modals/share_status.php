<!-- Modal -->
<div class="modal fade" id="shareStatusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="padding-right:0;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
      </div>
      
	 <div class="modal-body text-center">
        <h3 class="font-book mb20">SHARE STATUS</h3>
			<div class="clearfix"></div>
			<form class="form-horizontal" role="form" action="<?= PATH;?>page/share_status/<?=$route;?>" method="post" enctype="multipart/form-data">
				<div class="form-body">
					<div class="form-group">
						<label class="col-md-2 control-label">Subject</label>
						<div class="col-md-10">
							<div class="input-group">
								<input class="form-control" placeholder="Status subject" type="text" name="subject" required="required" size="78" />
							</div>
						</div>
					</div>
                    
                    <div class="form-group">
                    	<label class="col-md-2 control-label">Top picture</label>
						<div class="col-md-10">	
								<div class="thumbnail" style="width:621px;">
                            		<img id="top_pic" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
								</div>
						</div>
					</div>
				                    
                    <div class="form-group">
                        <div class="note"></div>
                        <textarea name="text" style="visibility:hidden; height:1px;"></textarea>
					</div>
                    
					 <div class="form-group">		
							<div class="col-md-12">
                            	<input type="hidden" name="submit" value="add" />
                                <input type="hidden" name="id" value="" />
                                <input type="hidden" name="share_id" value="" />
                                <input type="hidden" name="top_pic" value="" />
								<button type="submit" class="btn green">Save</button>
							</div>
                    </div>
               </form>
			</div>               
		</div>
	</div>
</div>