<? if(count($bookingObjs) > 0):?>
<? foreach($bookingObjs as $bookingObj):?>
<? $offeredBy = Model_User::getUserObjById($bookingObj->getAttr('uoid'));?>
<tr>
    <td><?=$bookingObj->getId()?></td>
    <td><?=$bookingObj->getTruncatedName()?></td>
    <td><img class="img-circle avatar-40" src="<?= $offeredBy->getAvatarImageUrl();?>"> <?=$offeredBy->getTruncatedName()?></td>
    <td>$<?=$bookingObj->getAttr('soprice')?></td>
</tr>
<? endforeach;?>
<? endif;?>
