<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <!-- BEGIN BODY -->
        <div class="login"> 
          <!-- END SIDEBAR TOGGLER BUTTON --> 
          <!-- BEGIN LOGIN -->
          <div class="content"> 
            <!-- BEGIN REGISTRATION FORM -->
            <?= Partial::form_register() ?>
            <!-- END REGISTRATION FORM --> 
          </div>
          <!-- END LOGIN --> 
          
        </div>
      </div>
    </div>
  </div>
</div>
