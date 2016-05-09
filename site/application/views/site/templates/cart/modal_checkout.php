<!-- Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
      </div>
      
	 <div class="modal-body text-center">
        <h2 class="font-book mb20">CHECKOUT</h2>
        <h4>INITIATING PAYMENT FOR: <span class="green" id="club"></span></h4>
			<div class="clearfix"></div>
				<h4>TOTAL: <strong><span id="sum"></span></strong></h4>
				<br />
                <form class="form-horizontal" role="form" action="<?= PATH;?>cart/checkout" method="post">
				<div class="form-body">
					<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-2 col-md-9">
                            	<input type="hidden" name="submit" value="finalize" />
                                <input type="hidden" name="sum" value="" />
                                <input type="hidden" name="id" value="" />
								<button type="submit" class="btn green uppercase">CHECKOUT</button>
							</div>
						</div>
					</div>  
               </div>
               </form>
			</div>               
		</div>
	</div>
</div>
