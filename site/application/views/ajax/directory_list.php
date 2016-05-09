<? foreach($dusers as $duser):?>
	<div class="directory_profile">
		<div class="avatar_cont pull-left">
			<div class="img-circle avatar-105_container">
				<img src="<?= $duser['avatar'] ? UPU.$duser['id'].'/'.$duser['avatar'] : IMG.'logo_avatar.png';?>" class="img-circle avatar-105" alt="" />
			</div>
			<div class="directory_profile-miles text-center"><i class="glyphicon icon-position3"></i>1.4 miles</div>
		</div>
		<div class="details_cont pull-left">
			<div class="directory_profile_name green"><?= $duser['name'];?></div>
			<div class="directory_speciality"><?= $duser['title'];?></div>
			<div class="directory_profile_address-div pull-left mb30">
				<div class="stars">
				<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>
				</div>
				<?= $duser['address'];?><br />
				<?= $duser['city'];?>, <?= $duser['zip'];?>
			</div>
			<div class="directory_latest_reviev pull-left mb30">
				<div class="directory_latest_reviev_header">latest review</div>
				In publishing and graphic design, lorem ipsum is a filler text used to demonstrate ...
			</div>
			<div class="clearfix"></div>	
			<div class="directory_profile_address-div pull-left">
				<a href="<?= PATH.'page/index/'.$duser['route'];?>" class="directory_profile-button directory_profile-button_view_profile" autocomplete="off">
					VIEW PROFILE
				</a>
			</div>
			<div class="directory_latest_reviev pull-left">
				<a href="appointment.php" class="directory_profile-button directory_profile-button_book_appointment" autocomplete="off">
					BOOK APPOINTMENT
				</a>
			</div>
			<div class="clearfix"></div>			
		</div>
		<div class="clearfix"></div>
	</div>
<? endforeach;?>