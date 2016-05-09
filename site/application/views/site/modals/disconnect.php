<!-- Modal -->
<div class="modal fade" id="disconnectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon-remove"></i></button>
      </div>
      
	 <div class="modal-body text-center">
        <h3 class="font-book mb20">DISCONNECT</h3>
		    <div class="float_center mt10m mb20">
				<div class="float_center_childrens">
					<div class="commment-avatar no-padding fl"></div>
					<div class="fl font-medium mt3">
						<div id="name" class="fs16 green"></div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
            <button type="button" class="btn btn-success">Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
            <input id="submit" type="hidden" value="connect" />
            <input id="user" type="hidden" value="" />
			<br />
     	</div>
    </div>
  </div>
</div>
<script>	
	$('#disconnectModal .btn-success').click(function() {
		var baseUrl = '<?= PATH; ?>';
		var invite = $('#user').val();
		var submit = $("#submit").val();
		
		$.ajax({
			url: 	baseUrl + 'user/disconnect',
		  	type: 	'post',
			async: 	true,
	  		data: { user_invite: invite, submit: submit }
		})
		.done(function(res) {					
			window.location.href = baseUrl + 'user/list/connections';
		});	
	});
</script> 