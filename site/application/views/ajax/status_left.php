<div class="post_container">
	<div class="plr25">
		<div class="post-img"><img src="<?=$statusObj->getPicUrl();?>" alt="" /></div>
		<div class="mt20 mb10">
			<h3><?=$statusObj->getAttr('subject');?></h3>
			<div class="clearfix"></div>
		</div>
		<div class="fs12 lh18 font-book mb20"><?= htmlspecialchars_decode($statusObj->getAttr('text'));?></div>
	</div>
	
	<div class="post-actions">
		<div class="small_notifications plr25">
				<div class="pull-left">
					<div><i class="icon-post_time green"></i><span class="value ml5">1 second ago</span></div>
				</div>
				<div class="pull-left">
					<div class="pull-left"><span class="value like-value">0</span>
                    <button type="button" class="icon-social like" title="Like" data-item="<?= $statusObj->getId();?>" data-category="status" data-url="<?=PATH;?>" disabled="disabled">
                    <i class="icon-like ml5"></i></button>
                    </div>
					<div class="pull-left"><span class="value">0</span>
                    <button id="<?= $statusObj->getId();?>" class="icon-social toggle-reviews" title="Comment" disabled="disabled">
                    <i class="icon-comments ml5"></i></button></div>
					<div class="pull-left no-margin"><span class="value">0</span>
                    <button class="icon-social" title="Share" disabled="disabled">
                    <i class="icon-share_post ml5"></i></button></div>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
		</div>
	</div>	
</div>
