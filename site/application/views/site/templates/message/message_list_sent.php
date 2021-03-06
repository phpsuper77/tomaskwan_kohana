<table class="table table-striped table-advance table-hover">
<thead>
<tr>
	<th colspan="4">
		<input type="checkbox" class="mail-checkbox mail-group-checkbox">
        <a class="btn blue btn-xs msg-command" href="javascript:;" data-command="delete" data-url="<?=PATH;?>message/list/<?= $direction;?>" data-title="<?= $direction;?>">
        <i class="fa fa-trash-o"></i> <?=__('MSG_MOVE_TO_TRASH')?> </a>
	</th>
</tr>
</thead>
<tbody>
<tr>
    <td tyle="width:5%;"></td>
    <td style="width:25%;"><?=__('MSG_TO')?></td>
    <td style="width:50%;"><?=__('MSG_CONTENT')?></td>
    <td style="float:right;width:20%;"><?__('MSG_DATE')?></td>
</tr>

<? foreach($messageObjs as $messageObj):?>
	<? $toUserObj = $messageObj->getUserToObj() ?>
	<? $fromUserObj = $messageObj->getUserFromObj() ?>
<tr data-messageid="<?= $messageObj->getAttr('id');?>">
	<td class="inbox-small-cells"><input type="checkbox" class="mail-checkbox" name="checked" value="<?=$messageObj->getId();?>" /></td>
    <td class="view-message"><?= $toUserObj?$toUserObj->getName():'' ;?></td>
    <td class="view-message"><?= $messageObj->getTruncatedAttr('text', 20); ?></td>
	<td class="view-message text-right"><?=date('m/d/Y H:i',strtotime($messageObj->getAttr('date')));?></td>
</tr>
<? endforeach;?>
</tbody>
</table>
		<?= $pages;?>
