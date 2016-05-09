<? $commentUserObj = $commentObj->getUserObj(); ?>
<div class="review">
	<div class="reviews-1-col">
		<div class="review-avatar text-center">
		<img src="<?=$commentUserObj->getAvatarUrl() ? $commentUserObj->getAvatarUrl()  : IMG.'logo_avatar.png';?>" class="img-circle avatar-86" alt="" />
		<?=$commentObj->getAttr('name'];?>
		</div>	
	</div>
	<div class="reviews-23-col">
		<div class="review-text">
			<?= $commentObj->getTextAttr('text');?>
		</div>
		<div class="small_notifications mt20">
			<div class="pull-left">
				<div><i class="icon-post_time green"></i><span class="value ml5"><?=date('d F Y',strtotime($commentObj->getAttr('date')));?></span></div>
			</div>
			<div class="pull-left">
				<div class="pull-left"><span class="value like-value">0</span>
    	            <button class="icon-social like" title="Like" disabled="disabled">
                    <i class="icon-like ml5"></i></button>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
    <div class="clearfix"></div>	
</div>
