<div id="boxes">
    <a href="<?=PATH;?>page/<?=$route;?>" id="back-to-profile" class="font-medium"><i class="icon-arrow_left"></i>BACK TO PROFILE</a>
    <div class="container">			
        <div class="text-center">
            <h1 class="main-h3 ttn">Meet Our Staff</h1>
            <h2 class="main-h4 ttn">Book Appointment</h2>
        </div>
        <div class="text-center">
            <? foreach($staffObjs as $staffObj):?>
                <? $staffObj = $staffObj->getUserObj(); ?>
                <? $staffPageObj = $staffObj->getPageObj() ?>
            <? if(count($staffObjs) == 1):?>
            <div class="col-xs-4"></div>
            <? endif;?>
            <div class="col-xs-4">
                <div class="profile_container staff-container text-center position-relative">
                    <div class="mt20"><img src="<?=$staffObj->getAvatarImageUrl();?>" class="img-circle avatar-138" alt="" /></div>
                    <div class="directory_profile_name green mb0 mt20"><h1><?=$staffObj->getTruncatedName();?></h1></div>
                    <div class="directory_speciality mb30"><?=$staffObj->getAttr('title');?></div>
                    <div class="staff">
                        <? if($staffPageObj && $staffPageObj->isPageActive()):?>
                        <a href="<?= $staffPageObj->getPageUrl() ?>" class="directory_profile-button directory_profile-button_view_profile">
                            SEE PROFILE</a>
                        <? endif;?>
<? if ($loginUserObj) { ?>
                        <a href="#" class="directory_profile-button directory_profile-button_view_profile ml30" data-toggle="modal" data-target="#messageModal2" data-user="<?=$staffObj->getId();?>" data-name="<?=$staffObj->getName();?>" data-avatar="<?=$staffObj->getAvatarImageUrl();?>">
                            DIRECT MESSAGE</a>
<? } else { ?>
                        <a href="#" class="generic-modal-trigger directory_profile-button directory_profile-button_view_profile ml30" data-toggle="modal" data-target="#genericModal" data-content="You must login to send direct message">
                            DIRECT MESSAGE</a>
<? } ?>
                    </div>
                </div>

            </div>   

            <? endforeach;?>
        </div>
        <div class="clearfix"></div>
    </div>        
</div>
