<!-- Modal -->
<div class="modal fade" id="specOfferModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
      </div>
      
	 <div class="modal-body text-center">
        <h3 class="font-book mb20"><?=$offerObj->getAttr('name');?></h3>
			<div class="clearfix"></div>
			<form class="form-horizontal" role="form" action="<?= PATH;?>cart/add_specoffer" method="post" enctype="multipart/form-data">
				<div class="form-body">
                    
                    <div class="form-group">
						<label class="col-md-3 control-label">Price</label>
						<div class="col-md-5">$<?=$offerObj->getAttr('price');?></div>
					</div>
                    
                    <div class="form-group">
                    	<label class="col-md-3 control-label">Picture</label>
                    	<div class="col-md-8">
							<div class="fileinput-new">
								<img style="height:320px;" src="<?= $offerObj->getImageUrl(); ?>" alt="" />
							</div>
                    	</div>
                    </div>
                    
                    <div class="form-group">
                    	<label class="col-md-3 control-label">Description</label>
                        <div class="col-md-8"><?=$offerObj->getAttr('text');?></div>
                    </div>
                        
                    
					<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-2 col-md-9">
                            	<input type="hidden" name="submit" value="add" />
                                <input type="hidden" name="offer_id" value="<?=$offerObj->getAttr('id');?>" />
                                <input type="hidden" name="owner_id" value="<?=$offerObj->getAttr('owner_id');?>" />
                                <input type="hidden" name="route" value="<?=$route;?>" />
								<? if(!$loginUserObj->isRoleUser()):?> 
                                    Only user can purchase this special offer.
								<? elseif($offerObj->getAttr('quant')<=0):?> 
                                    Sorry, this offer has been sold out.
								<? elseif($offerObj->getAttr('expire')==true):?> 
                                    Sorry, this offer has expired.
                    			<? else: ?>
                                <button type="submit" class="btn green">Add to Cart</button>
                                <? endif;?>
							</div>
						</div>
					</div>  
               </div>
            </form>
			</div>               
		</div>
	</div>
</div>
