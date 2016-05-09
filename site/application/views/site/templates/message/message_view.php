<div class="inbox-header inbox-view-header">
</div>
<div class="inbox-view-info">
	<div class="row">
		<div class="col-md-8">
            <span class="green"><?= $fromUserObj->getName(); ?></span>
		     sent to 
            <span class="green"><?= $toUserObj->getName(); ?></span>
             on <?=date('m/d/Y H:i:s',strtotime($messageObj->getAttr('date')));?>
		</div>
		<div class="col-md-4 inbox-info-btn">
        		<?= $modal;?>
				<a class="btn blue" data-toggle="modal" data-target="#messageModal"><i class="fa fa-reply"></i> <?= __('MSG_REPLY') ?> </a>
<!--
                    <button data-messageid="<?= $messageObj->getId();?>" data-command="delete" class="btn blue msg-command"><i class="fa fa-trash-o"></i> Delete </button>
-->
		</div>
	</div>
</div>
<div class="inbox-view"><?=$messageObj->getTextAttr('text');?></div>
<? if ($messageObj->hasAction()) {?>
<hr>
<a href="<?= $messageObj->getActionLink()?>" class="green-haze btn"><?= $messageObj->getActionName()?></a>
<? } ?>
