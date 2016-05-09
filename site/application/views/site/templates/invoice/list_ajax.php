<? if(count($invoiceObjs) > 0):?>
<? foreach($invoiceObjs as $invoiceObj):?>
    <tr>
        <td><?=$invoiceObj->getAttr('id');?></td>
        <td><?=ucfirst($invoiceObj->getAttr('msg'));?></td>
        <td><?=ucfirst($invoiceObj->getAttr('status'));?></td>
        <td>$<?=$invoiceObj->getAttr('sum');?></td>
		<td><?=date('m/d/Y',strtotime($invoiceObj->getAttr('date')));?></td>
        <td>
        <? if($invoiceObj->getAttr('status') != 'paid'):?>
        <div class="btn-group" style="position:absolute;">
		<a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
		<i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down">
		</span></a>
        	<ul class="dropdown-menu pull-right">
                <li><a href="<?=PATH;?>invoice/pay/<?=$invoiceObj->getId();?>"><?= __("ACTION_PAY") ?></a></li>
  			</ul>
          </div>
          <? endif;?>
		</td>	
	</tr>
    <? endforeach;?>
    
    <? if($pages):?>
	<tr class="paginator">
    <td align="center" colspan="10"><?= $pages;?></td>
    </tr>
    <? endif;?>
<? else:?>
<tr><td align="center" colspan="10"><?= __("NO_INVOICES") ?></td></tr>
<? endif;?>
