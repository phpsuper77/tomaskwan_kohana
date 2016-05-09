<? if(count($offerObjs) > 0):?>
<? foreach($offerObjs as $offerObj):?>
<tr>
    <td><?=$offerObj->getId();?></td>
    <td><?=$offerObj->getShortName();?></td>
    <td><?=__('OFFER_TYPE_'.$offerObj->getAttr('category'));?></td>
    <td><?=$offerObj->getAttr('date_to') ? date('m/d/Y',strtotime($offerObj->getAttr('date_to'))) : 'no date';?></td>
    <td><?=$offerObj->getAttr('max');?></td>
    <td>$<?=$offerObj->getAttr('price');?></td>
    <td><span class="label label-sm<?=$offerObj->getAttr('active') == 1 ? ' label-success' : ' label-danger';?>">
            <?=__('STATUS_'.$offerObj->getAttr('active'));?></span></td>
    <td>
        <div class="btn-group" style="position:absolute;">
            <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
            </span></a>
            <ul class="dropdown-menu pull-right">
                <li><a href="#" data-toggle="modal" data-target="#addSpecOfferModal" data-id="<?=$offerObj->getAttr('id');?>" data-name="<?=$offerObj->getAttr('name');?>" data-category="<?=$offerObj->getAttr('category');?>" data-date_to="<?= $offerObj->getAttr('date_to') ? date('m/d/Y',strtotime($offerObj->getAttr('date_to'))) : '';?>" data-max="<?=$offerObj->getAttr('max');?>" data-price="<?=$offerObj->getAttr('price');?>" data-text="<?=$offerObj->getAttr('text');?>" data-image="<?=$offerObj->getImageUrl();?>"><?=__('EDIT')?></a></li>
                <li><a href="<?=PATH;?>specoffer/delete/<?=$offerObj->getId();?>"><?=__('DELETE')?></a></li>
                <? if($offerObj->getAttr('active') == 1):?>
                <li><a href="<?=PATH;?>specoffer/deactivate/<?=$offerObj->getId();?>"><?=__('DEACTIVATE')?></a></li>
                <? else:?>
                <li><a href="<?=PATH;?>specoffer/activate/<?=$offerObj->getId();?>"><?=__('ACTIVATE')?></a></li>
                <? endif;?>
                <li><a href="<?=PATH;?>specoffer/view/<?=$offerObj->getId();?>"><?=__('VIEW')?></a></li>
            </ul>
        </div>
    </td>	
</tr>
<? endforeach;?>

<? if($pages):?>
<tr class="paginator">
    <td align="center" colspan="10"><?=$pages;?></td>
</tr>
<? endif;?>
<? else:?>
<tr><td align="center" colspan="10">There is no special offers yet.</td></tr>
<? endif;?>
