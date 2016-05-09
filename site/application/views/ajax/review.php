<div class="review">
	<div class="reviews-1-col">
		<div class="review-avatar text-center">
			<img src="<?=$review['avatar'] ? Kohana::$config->load('site.s3.url')."/users/".$review['user_id']."/avatar/". $review['avatar'] : IMG.'logo_avatar.png';?>" class="img-circle avatar-86" alt="" />
			<?= $review['name'];?>
		</div>
	</div>
	<div class="reviews-23-col">
		<div class="review-text"><?=$review['text'];?></div>
		<div class="small_notifications mt20">
			<div class="pull-left">
				<div><i class="icon-post_time green"></i><span class="value ml5"><?=date('F Y',strtotime($review['date']));?> </span>
           			<span class="stars" style="padding-left:20px;">
           			<? for($i=0;$i<$review['global'];$i++):?>
              			<i class="fa fa-star"></i>
           			<? endfor;?>
       			 	<? for($j=0;$j<5-$review['global'];$j++):?>
               			<i class="fa fa-star-o"></i>
           			<? endfor;?>
      				</span>
       			</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="clearfix"></div>	
</div>
