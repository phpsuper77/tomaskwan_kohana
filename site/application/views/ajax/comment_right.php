<? $commentUserObj = $commentObj->getUserObj(); ?>
<div class="comment">
	<div class="commment-avatar pull-left no-padding">
		<img src="<?= $commentUserObj->getAvatarUrl() ? $commentUserObj->getAvatarUrl() : IMG.'logo_avatar.png';?>" class="img-circle" alt="" />
	</div>
	<div class="commment-text pull-left no-padding"><?= $commentObj->getTextAttr('text');?>			
    	<div class="small_notifications">
			<div><span class="value  ml5">0</span>
            	<button class="icon-social like" title="Like" disabled="disabled"><i class="icon-like ml5"></i></button>
            </div>
		</div>
	</div>	
	<div class="clearfix"></div>
</div>
