<div class="page-container">
    <?= $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>My Orders</h1>
                </div>
            </div>
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?= PATH;?>dashboard">Dashboard</a>
                <i class="fa fa-circle"></i>
                </li>
                <li>Orders<i class="fa fa-circle"></i></li>
                <li>
                <a href="<?= PATH;?>myorder/list">My Orders</a>
                </li>
            </ul>
            <div class="clearfix"></div>

            <div class="tabbable-line">
                <!--
                <ul class="nav nav-tabs">
                    <li class="active">
                    <a href="#main" data-toggle="tab">
                        Class </a>
                    </li>
                </ul>
                -->
            </div>

            <div class="tab-content">
                <div class="tab-pane fade active in" id="main">

                    <div class="row margin-top-10">
                        <div class="col-md-3">
                            <!-- BEGIN PROFILE SIDEBAR -->

                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">ORDER</span>
                                    </div>
                                    <div class="inputs">
                                        <div class="portlet-input input-inline input-small ">
                                            <div class="input-icon right">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="gh-title">ID</div>
                                    <div class="gh-value"><?= $orderObj->getId() ?></div>
                                    <div class="gh-title">SELLER</div>
                                    <div class="gh-value">
                                        <?= Partial::user_badge_small($loginUserObj, $ownerObj); ?>
                                </div>
                                    <div class="gh-title">STATUS</div>
                                    <div class="gh-value"><?= $orderObj->getAttr("status") ?></div>
                                    <div class="gh-title">TXID</div>
                                    <div class="gh-value"><?= $orderObj->getAttr("op_order") ?></div>
                                    <div class="gh-title">TOTAL</div>
                                    <div class="gh-value">$<?= number_format($orderObj->getAttr("sum"),2) ?></div>
                                    <div class="gh-title">DATE</div>
                                    <div class="gh-value"><?= $orderObj->getUserDate() ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">ITEMS</span>
                                    </div>
                                    <div class="inputs">
                                        <div class="portlet-input input-inline input-small ">
                                            <div class="input-icon right">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-hover table-light">
                                        <thead>
                                            <tr>
                                                <td class="gh-title">ID</td>
                                                <td class="gh-title">DESCRIPTION</td>
                                                <td class="gh-title">TYPE</td>
                                                <td class="gh-title">TRAINER</td>
                                                <td class="gh-title">PRICE</td>
                                            </tr>
                                        </thead>
                                        <tbody>
<? foreach ($itemObjs as $itemObj) { ?>
    <? $obj = $itemObj->getItemObj(); ?>
    <? if ($obj) { ?>
      <? $trainerObj = $obj->getTrainerObj(); ?>
    <? } ?>
                                            <tr>
                                            <td class="gh-value"><?= $itemObj->getId(); ?></td>
                                            <td class="gh-value"><?= $obj?$obj->getName():''; ?></td>
                                            <td class="gh-value"><?= __('ITEM_'.$itemObj->getAttr('type')); ?></td>
                                            <td class="gh-value">
                                                <?= Partial::user_badge_small($loginUserObj, $trainerObj); ?>
                                            </td>
                                            <td class="gh-value">$<?= number_format($itemObj->getAttr('price'),2); ?></td>
                                            </tr>
<? } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
