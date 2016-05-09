<div id="boxes">
    <div class="container">			
        <div class="text-center">
            <h1 class="main-h3 ttn">User Search</h1>
        </div>
        <div class="text-center">
            <br/>
            <? foreach($dirObjs as $dirObj):?>
                <? $dirObj = $dirObj->getUserObj(); ?>
                <? $userPageObj = $dirObj->getPageObj() ?>
            <? if(count($dirObjs) == 1):?>
            <div class="col-xs-4"></div>
            <? endif;?>
            <div class="col-xs-4">
                <div class="profile_container staff-container text-center position-relative">
                    <div class="mt20"><img src="<?=$dirObj->getAvatarImageUrl();?>" class="img-circle avatar-138" alt="" /></div>
                    <div class="directory_profile_name green mb0 mt20"><h1><?=$dirObj->getTruncatedName();?></h1></div>
                    <div class="directory_speciality mb30"><?=$dirObj->getAttr('title');?></div>
                    <div class="staff">
                        <? if($userPageObj && $userPageObj->isPageActive()):?>
                        <a href="<?= $userPageObj->getPageUrl() ?>" class="directory_profile-button directory_profile-button_view_profile">
                            SEE PROFILE</a>
                        <? endif;?>
<? if ($loginUserObj) { ?>
                        <a href="#" class="directory_profile-button directory_profile-button_view_profile ml30" data-toggle="modal" data-target="#messageModal2" data-user="<?=$dirObj->getId();?>" data-name="<?=$dirObj->getName();?>" data-avatar="<?=$dirObj->getAvatarImageUrl();?>">
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
        <br/>
        <br/>
        <br/>
        <br/>
    </div>        
</div>
