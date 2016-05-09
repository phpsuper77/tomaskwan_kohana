<div class="item active">
    <h3><?=$statusObj->getAttr('subject');?></h3>
	<div class="text-center">
		<img src="<?=$statusObj->getPicUrl();?>" alt="" class="mb30" />
        <div id="text-<?=$statusObj->getId();?>"><?= $statusObj->getAttr('text');?></div><br />
	</div>

	<div class="small_notifications">
		<div class="pull-left">
			<div><i class="icon-post_time green"></i><span class="value ml5"><?=timeElapse(strtotime($statusObj->getAttr('date')));?> ago</span></div>
		</div>
		<div class="pull-right">
        	<div class="pull-left">
               	<span class="value">0</span>
               	<button type="button" class="icon-social like" title="Like" disabled="disabled">
            	<i class="icon-like ml5"></i></button>	
			</div>
			<div class="pull-left"><span class="value">0</span><i class="icon-comments ml5"></i></div>
			<div class="pull-left no-margin"><span class="value">0</span>
            	<button type="button" class="icon-social" title="Share" disabled="disabled">
                <i class="icon-share_post ml5"></i></button>
            </div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
