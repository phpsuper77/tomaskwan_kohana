(function($) {

	//LOGIN FORM
	
	$('select[name=role]').change(function () {
		var account = $("select[name=role] option:selected" ).val();
		if(account==1) { // business
			$('#speciality').removeClass('dn');
			$('#profession').addClass('dn');
			$('#address').removeClass('dn');
			$('#birth_date').addClass('dn');
			$('#acity').removeClass('dn');
		}
		if(account==2) { // trainer
			$('#speciality').addClass('dn');
			$('#profession').removeClass('dn');
			$('#address').removeClass('dn');
			$('#birth_date').removeClass('dn');
			$('#acity').removeClass('dn');
		}
		if(account==4) { // user
			$('#speciality').addClass('dn');
			$('#profession').addClass('dn');
			$('#address').addClass('dn');
			$('#birth_date').removeClass('dn');
			$('#acity').addClass('dn');
		}
		if(account==5) { // school
			$('#profession').addClass('dn');
			$('#address').removeClass('dn');
			$('#birth_date').addClass('dn');
			$('#acity').removeClass('dn');
		}
	});	
		
	// LOOKING FOR .... HOME SITE
	
	$("#im-looking-for_select .dropdown-menu li span").click(function(){
		$('#dropdown-my-select').text($(this).text());
		$('#dropdown-my-select').removeClass().addClass($(this).attr("class"));
	});
	
	$('#im-looking-for_select').on('show.bs.dropdown', function () {
		$('#dropdown-my-select').css("background-position", "right 17px bottom");
		$('#im-looking-for_select nav').addClass("bottom-radius-none");

	});	
	
	$('#im-looking-for_select').on('hide.bs.dropdown', function () {
		$('#dropdown-my-select').css("background-position", "right 17px top");
		$('#im-looking-for_select nav').removeClass("bottom-radius-none");
	});
	
	
	// LOCATION .... HOME SITE
	
	$('#location_select .dropdown-menu span').click(function(){
		var location=$(this).attr("rel");
		$('#location_select input').val(location);
	});
	
	$('#location_select input').click(function(){
		$('#location_select input').val("");
	});	
	
	$('#location_select').on('show.bs.dropdown', function () {
		$('#location_select nav').addClass("bottom-radius-none");
	});	
	
	$('#location_select').on('hide.bs.dropdown', function () {
		$('#location_select nav').removeClass("bottom-radius-none");
		if($('#location_select input').val()=="")$('#location_select input').val("Location");
	});
	
	//BUTTONS
	$('ul#profession > li > span').click(function() {
        var title = $(this).attr('rel');
		$('input[name=title]').val(title);
    });
	$('ul#amenity > li > span').click(function() {
        var amenity = $(this).attr('rel');
		$('input[name=amenity]').val(amenity);
    });
    

	// LOCATION .... OTHER THAN HOME SITES

	$('#location_other_select .dropdown-menu span').click(function(){
		var location=$(this).attr("rel");
		$('#location_other_select input').val(location);
	});
	
	$('#location_other_select input').click(function(){
		$('#location_other_select input').val("");
	});	
	
	$('#location_other_select').on('show.bs.dropdown', function () {
		$('#location_other_select nav').addClass("bottom-radius-none");
	});	
	
	$('#location_other_select').on('hide.bs.dropdown', function () {
		$('#location_other_select nav').removeClass("bottom-radius-none");
		if($('#location_other_select input').val()=="")$('#location_other_select input').val("Location");
	});

	
	// I"M LOOKING FOR .... OTHER THAN HOME SITES
	$("#im-looking-for_other_select .dropdown-menu li span").click(function(){
		$('#dropdown-my-select').text($(this).text());
		$('#dropdown-my-select').removeClass().addClass($(this).attr("class"));
	});
	
	$('#im-looking-for_other_select').on('show.bs.dropdown', function () {
		$('#dropdown-my-select').css("background-position", "right 17px bottom");
		$('#im-looking-for_other_select nav').addClass("bottom-radius-none");

	});	
	
	$('#im-looking-for_other_select').on('hide.bs.dropdown', function () {
		$('#dropdown-my-select').css("background-position", "right 17px top");
		$('#im-looking-for_other_select nav').removeClass("bottom-radius-none");
	});
	
	// LIST OF USERS
	
	$('ul#users>li span').click(function(){
		var user_id=$(this).attr("rel");
		var user=$(this).html();
		$('input#user').val(user);
		$('input[name=user_to]').val(user_id);
	});
	
	// SERVICES SELECT
	$("#services_select .dropdown-menu li span").click(function(){
		$('#dropdown-services-my-select').text($(this).text());
		$('#dropdown-services-my-select').removeClass().addClass($(this).attr("class"));
	});
	
	$('#services_select').on('show.bs.dropdown', function () {
		$('#dropdown-services-my-select').css("background-position", "right 17px bottom");
		$('#services_select nav').addClass("bottom-radius-none");
	});	
	
	$('#services_select').on('hide.bs.dropdown', function () {
		$('#dropdown-services-my-select').css("background-position", "right 17px top");
		$('#services_select nav').removeClass("bottom-radius-none");
	});
	
	// DIRECTORY SITE LEFT COLUMN = MAP COLUMN
	$("#directory_right-side").height($("#directory_left-side").height());

	// SHOW NUMBER ON DIRECTORY
	$('.directory_profile-button_show-number').click(function(){
		$(this).removeClass('directory_profile-button_show-number').addClass('directory_profile-button_book_appointment');
		var phone = $(this).attr('data-phone');
		$(this).html(phone);
		return false;
	});
	

	// SORT BY - DIRECTORIES
	$("#directory_sort-by-dropdown .dropdown-menu li a").click(function(){
		$('.directory_sort-by').text($(this).text());
	});
	
	$('#directory_sort-by-dropdown').on('show.bs.dropdown', function () {
		$('.directory_sort-by').addClass("directory_sort-by-changed");
	});	
	
	$('#directory_sort-by-dropdown').on('hide.bs.dropdown', function () {
		$('.directory_sort-by').removeClass("directory_sort-by-changed");
	});	


	//HIDE/SHOW BACK IMG
	$('input[name="backtype"]').on( "click", function() {
       var value = $('input[name="backtype"]:checked').val();
	   if(value == 0) 
		   $('#backimg').addClass('hide');
	   if(value == 1) 
		   $('#backimg').removeClass('hide');   
    });
	
	//DAYS in PROFILE
	$('input.day_check').on( "click", function() {
    	
		var id = $(this).attr('id');
		if($(this).prop('checked')) 
			$('.day-'+id).removeAttr('disabled');
		else 
			$('.day-'+id).attr('disabled','disabled');
    }); 
	
	
	//SEE MORE BIOPGRAPHY - FACILITY
	$('#show-more-biography').click(function() {
	
		var className = $(this).find('i').attr('class');
		
		if(className=="icon-arrow_down") {
			$("#read-more-biography").slideDown();
			$(this).find("span").html("READ LESS");
			$(this).find("i").removeClass('icon-arrow_down').addClass('icon-arrow_up');
			return false;
		}
		else {
			$("#read-more-biography").slideUp();
			$(this).find("span").html("READ MORE");
			$(this).find("i").removeClass('icon-arrow_up').addClass('icon-arrow_down');
			return false;
		}
		
    });
	
	// TOGGLE HIDDEN NEW POST
	
	$('#show-add').click(function(){
		if($(this).hasClass('green'))
		{
			$('#add-image').slideDown();
			$(this).removeClass('green');
			$(this).addClass('grey-cascade');
			$(this).html('<i class="fa fa-minus"></i> Hide');
			return false;
		} else {
			$('#add-image').slideUp();
			$(this).removeClass('grey-cascade');
			$(this).addClass('green');
			$(this).html('<i class="fa fa-plus"></i> Add');
			return false;
		}
	});
	
	
	// TOGGLE HIDDEN NEW GALLERY IMAGE
	
	$('input[name=subject]').click(function(){
		$('#new_status').slideDown();
		return false;
	});
	$('#new_hide').click(function(){
		$('#new_status').slideUp();
		return false;
	});
	
	// MAKE EDITABLE POST
	$('a.edit-post').click(function(event) {
	event.preventDefault();
	var id = $(this).attr('data-id');
	var subject = $('#post-'+id+' h3').html();
	var text = $('#text-'+id).html();
	$('#post-'+id+' h3').replaceWith('<div class="subject-edit form-group"><div class="col-md-13"><input class="form-control" type="text" name="subject" value="'+subject+'" required="required" /></div></div>');
	$('#text-'+id).replaceWith('<div class="text-edit form-group"><div class="col-md-13"><textarea class="form-control" name="text">'+text+'</textarea></div></div>');
	$('#save-'+id).removeClass('dn');
	$('#actions-'+id).addClass('dn');
	});

	// TOGGLE HIDDEN REVIEWS/COMMENTS
	
	$('.toggle-reviews').click(function(){
		var hiddenReviews="#review-" + $(this).attr('id');
		$(hiddenReviews).slideToggle();
		return false;
	});
	
	// TOGGLE HIDDEN MORE
	
	$('.show-more').click(function(){
		var more="#more-" + $(this).attr('data-status');
		$(more).slideToggle();
		return false;
	});
	
	// TOGGLE HIDDEN DISCOVER
	
	$('#toggle-discover').click(function(){
		$('#more-discover').slideToggle();
		return false;
	});
	
	// SHOW MORE TEXT
	
	$('.show-more-text').click(function(){
		$(this).next('.more-text-hidden').show();
		$(this).hide();
		return false;	
	});
	
	// OPEN STAFF TIMETABLE
	
	$('.open-staff-timetable').click(function(){
		$(this).parent('div').find('.staff-timetable').show();
		return false;
	});
	
	// CLOSE STAFF TIMETABLE
	
	$('.timetable-close').click(function(){
		$(this).parent('div').hide();
		return false;
	});
	
	// SORT TABLES
	
	$('th.sorting').click(function() {
	
/*
		$('#start').removeAttr('id');
		$(this).attr('id','start');
*/

        var order = $('#ajax-table').attr('data-order');
		if(order == 'asc')
			order = 'desc';
		else
			order = 'asc';
        $('#ajax-table').attr('data-order', order);
		tableList($('#start'));
	});
	
	// SELECT TIMETABLE HOUR
	
	$(".hour-active,.hour-bordered").click(function(){
		if($(this).hasClass('hour-highlighted')) {
			$(this).removeClass("hour-highlighted");
			$(this).removeClass("booked");
		} else {
			if($(this).hasClass('tour')) {
				$('.hour-active').removeClass("hour-highlighted");
				$('.hour-active').removeClass("booked");
			}
			$(this).addClass("hour-highlighted");
			$(this).addClass("booked");
		}		
		if($(".hour-active").hasClass('booked')) {
			$('form.book input[type=submit]').removeAttr('disabled');
		} else {
			$('form.book input[type=submit]').attr('disabled','disabled');
		}
	});
	
	//BOOKING PREPARE
	$('form.book').submit(function(event) {
		id = $(this).attr('id');
	
		var $dates = $('div#timetable-'+id+" .booked");
	
		$dates.each(function(k,v) {
		$('<input />').attr('type', 'hidden')
            .attr('name', 'date[]')
            .attr('value', $(v).attr('data-date'))
            .appendTo('form#'+id);
		$('<input />').attr('type', 'hidden')
            .attr('name', 'class[]')
            .attr('value', $(v).attr('data-class'))
            .appendTo('form#'+id);
		});
	return true;
	});
	
	//AJAX IF TRAINER SELECT
	$('select#trainer_book').change(function () {
		showCalendar();
	});
	
	//passwords matching
	$('input[name=password2],input[name=password]').blur(function() {
  		var pass1 = $('input[name=password]').val();
		var pass2 = $('input[name=password2]').val();
		if(pass1 == pass2) {
			$('#pass_submit').removeAttr('disabled');
			$('#pass_nmatch').addClass('dn');
		} else {
			$('#pass_submit').attr('disabled','disabled');
			$('#pass_nmatch').removeClass('dn');		
		}
	});
	
	$("#select2_users").select2();
	
    $('#my_multi_select1').multiSelect();
    $('#my_multi_select2').multiSelect({
    	selectableOptgroup: true
    });
    
	function IsEmail(email) {
  		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  		return regex.test(email);
	};
	
	//message not logged validation
	$('form.not-logged input,form.not-logged textarea').keyup(function() {
        
      	var name = $('form.not-logged input[name=name]').val();
		var email = $('form.not-logged input[name=email]').val();
		var text = $('form.not-logged textarea[name=text]').val();
		
		if(name.length>3 && text.length>5 && IsEmail(email)) {
			$('a#send_msg').removeClass('not-active');		
		} else {
			if(!$('a#send_msg').hasClass('not-active')) {
				$('a#send_msg').addClass('not-active');	
			}			
		}
	});
	
	//review limit
	$(".review-textarea").keyup(function(){
    	if($(this).val().length > 250){
        	$(this).val($(this).val().substr(0, 250));
		}
	});
	
	//disable social
	$('.social').click(function(event) {
		event.preventDefault();
	});
		
}(window.jQuery));
