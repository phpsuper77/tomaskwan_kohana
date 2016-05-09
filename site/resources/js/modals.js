$('#messageModal').on('shown.bs.modal', function () {
	$('#text').val('');
	$('#text').focus();
});

$('#messageModal2').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget); // Button that triggered the modal
	var user = button.data('user'); // Extract info from data-* attributes
	var name = button.data('name'); // Extract info from data-* attributes
	var avatar = button.data('avatar'); // Extract info from data-* attributes
 
	$('#name').html(name);
	$('.commment-avatar').html('<img id="avatar" src="' + avatar + '" class="img-circle" alt="">');
	$('input[name=user_to]').val(user);
	$('textarea[name=text]').val('');

    GYMHIT_STATS.track("ui.message.new", {'to':user,'src':window.location.pathname});
});

$('#orderDetailsModal').on('show.bs.modal', function (event) {
		
	var button = $(event.relatedTarget);
	var order = button.data('order');
	var url = button.data('url');
	$.ajax({
		url: 	'/order/booking_ajax',
	  	type: 	'post',
		async:  true,
  		data: { 'order': order, 'submit':'ok' }
	})
	.done(function(res) {
		$('#details').html(res);
	});	

});

$('#checkoutModal').on('show.bs.modal', function (event) {
		
	var button = $(event.relatedTarget);
	var name = button.data('club');
	var sum = button.data('sum');
	var id = button.data('id');
	
	$('#club').html(name);
	$('#sum').html('$'+sum);
	$('input[name=id]').val(id);
	$('input[name=sum]').val(sum);
});

$('#addSpecOfferModal').on('show.bs.modal', function (event) {
		
	var button = $(event.relatedTarget);
	var id = button.data('id');
		
	if(id) {		
        $('#addSpecOfferForm').attr('action','/specoffer/edit');
		var name = button.data('name');
		var category = button.data('category');
		var date_to = button.data('date_to');
		var max = button.data('max');
		var price = button.data('price');
		var text = button.data('text');
		var image = button.data('image');

		$('h3').html('EDIT SPECIAL OFFER');
		$('input[name=submit]').val('edit');
		$('input[name=id]').val(id);
		$('input[name=name]').val(name);
		$('input[name=date_to]').val(date_to);
		$('input[name=max]').val(max);
		$('input[name=price]').val(price);
		$('textarea[name=text]').val(text);
		$('select[name=category] option[value='+category+']').attr('selected','selected');
		$('select[name=category]').attr('disabled','disabled');
		$('.thumbnail img').attr('src',image);
	}
	
});

$('#addSpecOfferModal').on('hidden.bs.modal', function() {
	$('h3').html('ADD SPECIAL OFFER');
	$('select[name=category] option').removeAttr('selected');
	$('select[name=category] option').removeAttr('disabled');
	$('input').val('');
	$('textarea').val('');
	$('.thumbnail img').attr('src','http://www.placehold.it/600x200/EFEFEF/AAAAAA&amp;text=no+image');
	
});

$('#addLocationModal').on('show.bs.modal', function (event) {
		
	var button = $(event.relatedTarget);
	var id = button.data('id');
		
	if(id) {		
		var trainer_id = button.data('trainer_id');
		var trainer = button.data('trainer');
		var user_id = button.data('user_id');
		var user = button.data('user');
		var date = button.data('date');
		var form = button.data('form');
		var mode = button.data('mode');

		$('h3').html('EDIT BOOKING');
		if(mode == 'dashboard' || mode == 'cart') {
			$('input[name=trainer_id]').val(trainer_id);
		} else {
			$('select[name=trainer_id] option[value='+trainer_id+']').attr('selected','selected');
			$('select[name=trainer_id]').attr('disabled','disabled');
			$('select[name=user_id] option[value='+user_id+']').attr('selected','selected');
			$('select[name=user_id]').attr('disabled','disabled');
			$('#select2-chosen-2').html(user);
			$('#select2-chosen-3').html(trainer);
		}
		$('select[name=form] option[value='+form+']').attr('selected','selected');
		$('select[name=form]').attr('disabled','disabled');
		$('input[name=date]').val(date);
		$('input[name=id]').val(id);
		$('input[name=mode]').val(mode);
		$('input[name=submit]').val('edit');
		showCalendar();
	}	
});

$('#addLocationModal').on('hidden.bs.modal', function() {
	$('select option').removeAttr('selected');
	$('#calendar').html('');
	$('select').removeAttr('disabled');
	$('input[name=date]').val('');
	$('input[name=id]').val('');
	$('input[name=submit]').val('add');
	$('h3').html('ADD BOOKING');
	$('#select2-chosen-2').html('');
	$('#select2-chosen-3').html('');
});

$('#addBookingModal').on('show.bs.modal', function (event) {
/*		
	var button = $(event.relatedTarget);
	var id = button.data('id');
		
	if(id) {		
		var trainer_id = button.data('trainer_id');
		var trainer = button.data('trainer');
		var user_id = button.data('user_id');
		var user = button.data('user');
		var date = button.data('date');
		var form = button.data('form');
		var mode = button.data('mode');

		$('h3').html('EDIT BOOKING');
		if(mode == 'dashboard' || mode == 'cart') {
			$('input[name=trainer_id]').val(trainer_id);
		} else {
			$('select[name=trainer_id] option[value='+trainer_id+']').attr('selected','selected');
			$('select[name=trainer_id]').attr('disabled','disabled');
			$('select[name=user_id] option[value='+user_id+']').attr('selected','selected');
			$('select[name=user_id]').attr('disabled','disabled');
			$('#select2-chosen-2').html(user);
			$('#select2-chosen-3').html(trainer);
		}
		$('select[name=form] option[value='+form+']').attr('selected','selected');
		$('select[name=form]').attr('disabled','disabled');
		$('input[name=date]').val(date);
		$('input[name=id]').val(id);
		$('input[name=mode]').val(mode);
		$('input[name=submit]').val('edit');
		showCalendar();
	}	
    */
});

$('#addBookingModal').on('hidden.bs.modal', function() {
        /*
	$('select option').removeAttr('selected');
	$('#calendar').html('');
	$('select').removeAttr('disabled');
	$('input[name=date]').val('');
	$('input[name=id]').val('');
	$('input[name=submit]').val('add');
	$('h3').html('ADD BOOKING');
	$('#select2-chosen-2').html('');
	$('#select2-chosen-3').html('');
*/	
});

$('#addClassModal').on('show.bs.modal', function (event) {
		
	var button = $(event.relatedTarget);
	var id = button.data('id');
		
	if(id) {		
        $('#addClassForm').attr('action','/class/edit');
		var name = button.data('name');
		var description = button.data('description');
		var instructions = button.data('instructions');
		var trainer_id = parseInt(button.data('trainer_id'));
		//var location_id = parseInt(button.data('location_id'));
		var time_from = button.data('time_from');
		var time_to = button.data('time_to');
		var max = button.data('max');
		var week = button.data('week').split(',');
		var price = button.data('price');
		var date_to = button.data('date_to');
		var date_from = button.data('date_from');
		var image = button.data('image');

		$('h3').html('EDIT CLASS');
		$('input[name=submit]').val('edit');
		$('input[name=id]').val(id);
		$('input[name=name]').val(name);
		$('input[name=description]').val(description);
		$('input[name=instructions]').val(instructions);
		$('input[name=max]').val(max);
		$('input[name=time_from]').val(time_from);
		$('input[name=time_to]').val(time_to);
		$('input[name=date_to]').val(date_to);
		$('input[name=date_from]').val(date_from);
		$('input[name=price]').val(price);
		$('select[name=trainer_id] option[value='+trainer_id+']').attr('selected','selected');
		$('.thumbnail img').attr('src',image);
		//$('select[name=location_id] option[value='+location_id+']').attr('selected','selected');
		$.each(week , function(i, val) { 
			$('select#my_multi_select1 option[value='+val+']').attr('selected','selected');
			$('.ms-selectable ul > li#'+sanitize(val)+'-selectable').css('display','none');
			$('.ms-selection ul > li#'+sanitize(val)+'-selection').attr('style','');
			$('.ms-selection ul > li#'+sanitize(val)+'-selection').addClass('ms-selected');
		});
	}
});

$('#addClassModal').on('hidden.bs.modal', function() {
	$('h3').html('ADD CLASS');
	$('input').val('');
	$('select#my_multi_select1 option').removeAttr('selected');
	$('.ms-selectable ul > li').attr('style','');
	$('.ms-selection ul > li').css('display','none');
	$('.ms-selection ul > li').removeClass('ms-selected');
});
	
function sanitize(value){
	var hash = 0, i, character;
    if (value.length == 0) return hash;
    var ls = 0;
    for (i = 0, ls = value.length; i < ls; i++) {
    	character  = value.charCodeAt(i);
        hash  = ((hash<<5)-hash)+character;
        hash |= 0; // Convert to 32bit integer
    }
	return hash;
};

$('#shareStatusModal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);

	var id = button.data('id');
	var share_id = button.data('share_id');
	var subject = button.data('subject');
	var top_pic = button.data('top_pic');
	var text = button.data('text');
  				
	$('.note').html(text);
	$('img#top_pic').attr('src',top_pic);
		
	$('input[name=id]').val(id);
	$('input[name=share_id]').val(share_id);
	$('input[name=top_pic]').val(top_pic);
	$('input[name=subject]').val(subject);
	$('textarea').html(text);
});	

$('#unitModal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
  	var type = button.data('type');
	var action = button.data('action');
	var id = button.data('id');
	var name = button.data('name');
	var cl = button.data('cl');
	var title = button.data('title');
 
  	if(title)
		var head = action+' '+title;
	else
		var head = action+' '+type;
	
	$('#type').html(head);
	$('input[name=type]').val(type);
	$('input[name=submit]').val(action);
	$('input[name=id]').val(id);
	$('input[name=name]').val(name);
	$('input[name=class]').val(cl);
	$('button[type=submit]').html(action);
});

$('#disconnectModal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
  	var user = button.data('user');
	var name = button.data('name');
	var avatar = button.data('avatar');
 
	$('.green').html(name);
	$('.commment-avatar').html('<img id="avatar" src="' + avatar + '" class="img-circle" alt="">');
	$('#user').val(user);
});

$('#reviewModal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var text = button.data('text');
	var name = button.data('name');
	var avatar = button.data('avatar');
	var global = parseInt(button.data('global'));
	var facility = parseInt(button.data('facility'));
	var service = parseInt(button.data('service'));
	var clean = parseInt(button.data('clean'));
	var vibe = parseInt(button.data('vibe'));
	var knowledge = parseInt(button.data('knowledge'));
	var like = parseInt(button.data('like'));
	var role = button.data('role');
	var url = button.data('url');
	var id = button.data('id');
			
	checkReview(url,id);
	$('.'+role).remove();
	$('#ravatar').attr('src',avatar);
	$('#rname').html('<strong>'+name+'</strong>');
	$('.review-text').html(text);
		
	for(var i=0; i<global;i++)
		$('#star-global').html($('#star-global').html()+'<i class="fa fa-star"></i>');
	for(var i=0; i<facility;i++)
		$('#star-facility').html($('#star-facility').html()+'<i class="fa fa-star"></i>');
	for(var i=0; i<service;i++)
		$('#star-service').html($('#star-service').html()+'<i class="fa fa-star"></i>');
	for(var i=0; i<clean;i++)
		$('#star-clean').html($('#star-clean').html()+'<i class="fa fa-star"></i>');
	for(var i=0; i<vibe;i++)
		$('#star-vibe').html($('#star-vibe').html()+'<i class="fa fa-star"></i>');
	for(var i=0; i<knowledge;i++)
		$('#star-knowledge').html($('#star-knowledge').html()+'<i class="fa fa-star"></i>');
	for(var i=0; i<like;i++)
		$('#star-like').html($('#star-like').html()+'<i class="fa fa-star"></i>');
			
	$('#reviewModal').on('hide.bs.modal', function() {
		$('.star-modal').html('');
	});
});

$('#detailsModal').on('show.bs.modal', function (event) {
	
	var button = $(event.relatedTarget); // Button that triggered the modal
	var order = button.data('order'); // Extract info from data-* attributes
	var row;
	//var n=1;
	$.each(order, function( index, value ) {
  		
		row += '<tr><td>'+(index+1)+'</td><td>';
		if(value['type'] == 'specoffer') {
			row += 'special offer';
		} else {
			row += value['type'];
		}
		row += '</td><td>';
		if(value['type'] == 'booking') {
			row += value['tname'];
		} else if(value['type'] == 'class') {
			row += value['cname'];
		} else {
			row += value['name'];
		}
		row += '</td><td>';
		if(value['type'] == 'specoffer') {
			row += 'no date';
		} else {
			row += value['date'].substr(0,16);
		}
		row += '</td><td>';
		if(value['type'] == 'booking') {
			row += value['price'];
		} else if(value['type'] == 'class') {
			row += value['cprice'];
		} else {
			row += value['soprice'];
		}
		row += '$</td></tr>';
	});
	$('#details').html(row);
	
});

$('#freePassModal').on('shown.bs.modal', function () {
	var owner_id = $('input[name=owner_id]').val();
	var url = $('input[name=furl]').val();
		
	$.ajax({
		url: 	url,
	  	type: 	'post',
		async:  true,
  		data: { 'owner_id': owner_id, 'submit': 'add'}
	})
	.done(function(res) {
		$('div#code').html(res);
		$('#free-pass-button').addClass('not-active');
	});	
});

$('#registerModal').on('hidden.bs.modal', function() {
	$('#regform').show();
	$('#res_register').html('');
	$('#regform input').val('');
});

$('#bookingInfoModal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);

	var name = button.data('name');
	var avatar = button.data('avatar');
	var route = button.data('route');
  				
	$('#bname').html(name);
	$('#broute').attr('href',route);
	$('img#bavatar').attr('src',avatar);
});
