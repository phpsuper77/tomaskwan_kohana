<div class="page-container">
   <?=$sidebar;?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><?= __('MENU_CART') ?></h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>

            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?=PATH;?>dashboard"><?= __('MENU_DASHBOARD') ?></a>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <?= __('MENU_ORDERS') ?>
                <i class="fa fa-circle"></i>
                </li>
                <li>
                <a href="<?=PATH;?>cart/list"><?= __('MENU_CART') ?></a>
                </li>
            </ul>
            <div class="clearfix"></div>

            <? $error = Cookie::get('error');?>
            <? if($error):?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                We have problems processing your payment. The reason returned is '<?=$error?>'. Please try to checkout again.</div>
            <? endif; ?>
            <? Cookie::delete('error');?>

            <?=$addBookingModal;?>
            <?=$checkoutModal;?>

            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">

                        <div class="portlet-title">
                            <div class="caption caption-md margin-right-10">
                                <i class="icon-bar-chart theme-font-color hide"></i>
                                <span class="caption-subject theme-font-color bold uppercase"><?= __('INFO_CART') ?></span>
                            </div>

                        </div>

                        <div class="portlet-body" style="height: auto;">
            <? if (count($orderObjs) > 0) { ?>
                            <a class="btn green-haze" href="/cart/empty"><?= __('CART_EMPTY') ?></a>
            <? } ?>
                            <div class="table-scrollable table-scrollable-borderless">
                                <table class="table table-hover table-light">
                                    <tbody>
                                        <? if(count($orderObjs) > 0):?>
                                        <? foreach($orderObjs as $orderObj):?>
                                        <? $orderOwnerObj = $orderObj['cartObj']->getOwnerObj(); ?>
                                        <tr>
                                            <td colspan="3">
                                                <?= Partial::user_badge_small($loginUserObj, $orderOwnerObj); ?>
                                            </td>
                                            <td align="right" colspan="5">ORDER #<?= $orderObj['cartObj']->getId(); ?>
                                        </tr>
                                        <tr>
                                            <th><?= __('ID') ?></th>
                                            <th><?= __('DESC') ?></th>
                                            <th><?= __('TYPE') ?></th>
                                            <th><?= __('TRAINER') ?></th>
                                            <th><?= __('PRICE') ?></th>
                                            <th><?= __('DATE') ?></th>
                                            <th><?= __('ACTION') ?></th>
                                        </tr>
                                        <? $sum = 0; ?>
                                        <? foreach($orderObj['orderItemObjs'] as $orderItemObj):?>
                                                <? $obj = $orderItemObj->getItemObj(); ?>
                                                <?  if (!$obj) { ?>
                                                     <? continue; ?>
                                                <? } ?>
                                                <? $trainerObj = $obj->getTrainerObj(); ?>
                                        <tr>
                                            <td class="fit" align="center"><?=$orderItemObj->getAttr('id');?></td>
                                            <td><?=$obj->getName() ?></td>
                                            <td><?=$orderItemObj->getItemType();?></td>
                                            <td>
                                            <? if($trainerObj) {?>
                                                <?= Partial::user_badge_small($loginUserObj, $trainerObj); ?>
                                            <? } ?>
                                            </td>
                                            <? $price = $orderItemObj->getAttr('price');?>
                                            <td>$<?=$price;?></td>
                                            <td><?=date('m/d/Y H:i',strtotime($orderItemObj->getAttr('date')));?></td>
                                            <? $sum=$sum+$price;?>
                                            <td>
                                                <div class="btn-group" style="position:absolute;">
                                                    <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" style="position:relative; bottom:15px;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                        <i class="fa fa-cog margin-right-10"></i><span class="fa fa-angle-down"></span></a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li><a href="<?=PATH;?>cart/delete_orderitem/<?=$orderItemObj->getId();?>"><?= __('DELETE') ?></a></li>
                                                    </ul>
                                                </div>
                                            </td>	
                                        </tr>
                                        <? endforeach;?>
                                        <tr>
                                            <td align="right" colspan="6"><h4><strong><?= __('TOTAL') ?>: $<?=$sum;?></strong></h4></td>
                                            <td align="right" colspan="2">
                                                <a href="#" data-toggle="modal" data-target="#checkoutModal" class="btn green-haze" data-club="<?=$orderOwnerObj->getName();?>" data-id="<?=$orderObj['cartObj']->getId();?>" data-sum="<?=$sum;?>"><?= __('CART_CHECKOUT') ?></a>
                                            </td>
                                        </tr>
                                        <? endforeach;?>
                                        <? else:?>
                                        <tr><td align="center" colspan="8"><?= __('NO_CART_ITEMS') ?></td></tr>
                                        <? endif;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
</div>
