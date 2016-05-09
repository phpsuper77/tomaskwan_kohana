function login() {
	var email = $('.login-form input[name=email]').val();
	var password = $('.login-form input[name=password]').val();
	var baseUrl = $('.login-form input[name=base_url]').val();
	var submit = $('.login-form input[name=submit]').val();
	
	$.ajax({
    	type: "POST",
        cache: false,
        url: baseUrl + 'auth/login',
		data: {'email': email, 'password': password, 'submit': submit},
        success: function(res) 
        {
			if(res == '') {
				window.location.href = baseUrl + 'dashboard/index';
			} else {
				$('#res_login').html(res);
			}
		},
        async: true
	});
}

function register() {
	var name = $('.register-form input[name=name]').val();
	var email = $('.register-form input[name=email]').val();
	var address = $('.register-form input[name=address]').val();
	var address = $('.register-form input[name=address]').val();
	var city = $('.register-form input[name=city]').val();
	var birth_date = $('.register-form input[name=birth_date]').val();
	var zip = $('.register-form input[name=zip]').val();
	var phone = $('.register-form input[name=phone]').val();
	var role = $('.register-form select[name=role]').val();
	var password = $('.register-form input[name=password]').val();
	var baseUrl = $('.register-form input[name=base_url]').val();
	var submit = $('.register-form input[name=submit]').val();
	
	$('#progress2').removeClass('dn');
	$('#regform').hide();
	$.ajax({
    	type: "POST",
        cache: false,
        url: baseUrl + 'auth/register',
		data: {'name': name,'email': email,'address': address,'city': city,'birth_date': birth_date,'zip': zip,'phone': phone,'role': role,'password': password, 'submit': submit},
        success: function(res) 
        {
			$('#progress2').addClass('dn');
			$('#res_register').html(res);	        
		},
        async: true
	});
}

function tableList(e) {
	var sort = $('#ajax-table').attr('data-sort');
	var order = $('#ajax-table').attr('data-order');
	var url = $('#ajax-table').attr('data-url');
	var page = $('#ajax-table').attr('data-page');
	var jsbase = $('#ajax-table').attr('data-jsbase');
	var search = $('input#search').val();
	var src = $('#ajax-table').attr('data-src');
	var filters = $('#ajax-table').attr('data-filters');

	$('.portlet').css('opacity', '0.7');
	//$('.portlet').attr("disabled", "disabled");
	$('#progress-table').removeClass('dn');
	
	data = {'src': src, 'order': order, 'sort': sort, 'page': page, 'search': search};
    if (filters != undefined && filters != '') {
        attrs = filters.split(",");
        for (i in attrs) {
            data[attrs[i]] = $('#filter-'+attrs[i]).val();
        }
    }

	$.ajax({
    	type: "POST",
        cache: false,
        url: url,
		data: data,
        success: function(res) 
        {
			$('tbody.list').html(res);
	        $('#progress-table').addClass('dn');
	        $('.portlet').css('opacity', '1.0');
	        //$('.portlet').attr("disabled", "");
/*            
			if(jsbase)
				$.getScript(jsbase+"ajax.js");
			    $.getScript(jsbase+"after_ajax.js");   
 */
		},
        async: true
	});
}

/*
$(document).on('click', '.connect-now', function(event) {
	event.preventDefault();
	var e = $(this);
	var baseUrl = e.attr('data-url');
	var invite = e.attr('data-invite');
	var mode = e.attr('data-mode');
		
	$.ajax({
    	type: "POST",
        cache: false,
        url: baseUrl + 'user/connect',
		data: {'user_invite': invite, 'submit': 'submit'},
        success: function(res) 
        {
			$('.invite-'+invite).fadeOut();
			var badges = parseInt($('#binvite').html());
			if(badges > 1){
				badges = badges-1;
			} else {
				badges = '';
			}
			$('#binvite').html(badges);
			
			if(mode=='dashboard') {
				$('a.connect').remove();
			}	
		},
        async: true
	});
});
*/

$(document).on('click', '.msg-command', function(event) {
	var e = $(this);
	var content = $('.inbox-content');
    var loading = $('.inbox-loading');
	var url = e.attr('data-url');
	var title = e.attr('data-title');
	var command = e.attr('data-command');
	var index = 0;
	var checked = $('#unchecked').html();
		
	var checks = new Array();
    $('input[name=checked]:checked').each(function() {
    	checks.push($(this).val());
		if($(this).closest('tr').hasClass('unread'))
			index++;
	});
		
	if(checked > index) {
		$('#unchecked').html(checked-index);
		$('#bmessage').html(checked-index);
	} else {
		$('#check').addClass('hide');
		$('#bmessage').html('');
	}
		
    loading.show();
    content.html('');

    $.ajax({
    	type: "POST",
        cache: false,
        url: url,
		data: {'checks': checks, 'command': command},
        success: function(res) 
        {
         	$('.inbox-nav > li.active').removeClass('active');
            $('.inbox-nav > li.' + title).addClass('active');
            $('.inbox-header > h1').text(title);

            loading.hide();
            content.html(res);
            if (Layout.fixContentHeight) {
            	Layout.fixContentHeight();
            }
            Metronic.initUniform();
		},
        async: false
	});
});

$(document).on('click', '.like', function(event) {
	var e = $(this);
	var url = e.attr('data-url');
	var item_id = e.attr('data-item');
	var category = e.attr('data-category');
	var value = e.prev();
		
	$.ajax({
		url: 	url+'page/like',
	  	type: 	'post',
		async: 	true,
  		data: { 'item_id': item_id, 'category': category, 'submit': 'ok' }
	})
	.done(function(res) {		
		e.attr('disabled','disabled');
		value.html(parseInt(value.html())+1);
		
	});	
});

$(document).on('click', 'button.status', function(event) {
	event.preventDefault();
	var id = $(this).attr('data-id');
	var url = $(this).attr('data-url');
	var subject = $('#post-'+id+' input[name=subject]').val();
	var text = $('#post-'+id+' textarea[name=text]').val();
	var submit = $(this).html();
	var top_pic = $('#post-'+id+' .fileinput-exists img').attr('src');
	var side = $(this).attr('data-side');
	//var jsbase = $(this).attr('data-jsbase');
		
	$.ajax({
		url: 	url,
	  	type: 	'post',
		async:  true,
  		data: { 'subject': subject, 'text': text, 'top_pic': top_pic, 'submit': submit, 'id': id, 'side': side }
	})
	.done(function(res) {
		if(res == '') {
			$('#post-'+id+' .subject-edit').replaceWith('<h3>'+subject+'</h3>');
			$('#post-'+id+' .text-edit').replaceWith('<div id="text-'+id+'" class="fs12 lh18 font-book mb20">'+text+'</div>');
			$('#post-'+id+' #text-'+id).removeAttr('style');
			$('#post-'+id+' #save-'+id).addClass('dn');
			$('#post-'+id+' #actions-'+id).removeClass('dn');
		} else {
			$('#new_status').slideUp();
			$('.item').removeClass('active');
			$('.profile_container').removeClass('dn');				
			$('.new-post').after(res);
			$('input[name=subject]').val('');
			$('textarea[name=text]').val('');
			$('.fileinput-exists img').remove();		
			//$.getScript(jsbase+"ajax.js");
		}
	});	
});

$(document).on('click', '.delete-post', function(event) {
	event.preventDefault();
	var id = $(this).attr('data-id');
	var url = $(this).attr('data-url');
		
	$.ajax({
		url: 	url,
	  	type: 	'post',
		async:  true,
  		data: { 'id': id, 'submit': 'delete' }
	})
	.done(function(res) {
		$('#post-'+id).fadeOut();
	});	
});

$(document).on('click', 'button#comment', function(event) {
	event.preventDefault();
	var status_id = $(this).attr('data-id');
	var text = $('#add-comment-'+status_id+' .comment-text').val();
	var url = $(this).attr('data-url');
	var side = $(this).attr('data-side');
	var value = $('#actions-'+status_id+' .count-comments');
		
	$.ajax({
		url: 	url,
	  	type: 	'post',
		async:  true,
  		data: { 'status_id': status_id, 'text': text, 'submit': 'add', 'side': side }
	})
	.done(function(res) {
		$('div#new-comment-'+status_id).after(res);
		$('#add-comment-'+status_id+' .comment-text').val('');
		value.html(parseInt(value.html())+1);
	});	
});

$(document).on('click', 'button.image-add', function(event) {
	event.preventDefault();
	var title = $('.form-horizontal input[name=title]').val();
	var image = $('form .fileinput-exists img').attr('src');
	var url = $(this).attr('data-url');
	var type = $('.form-horizontal input[name=type]').val();
	var jsbase = $(this).attr('data-jsbase');
	$.ajax({
		url: 	url,
	  	type: 	'post',
		async:  true,
  		data: { 'title': title, 'image': image, 'type': type, 'submit': 'add'}
	})
	.done(function(res) {
		$('tbody.files:first').prepend(res);
		$('form .fileinput-exists img').fadeOut();
		$('form input[name=title]').val('');
	});	
});

$(document).on('click', 'button.image-delete', function(event) {
	event.preventDefault();
	var id = $(this).attr('data-id');
	var url = $(this).attr('data-url');
		
	$.ajax({
		url: 	url,
	  	type: 	'post',
		async:  true,
  		data: { 'id': id, 'submit': 'delete'}
	})
	.done(function(res) {
		$('tr#image-'+id).fadeOut();
	});	
});

$(document).on('click', '#add-review', function(event) {
	event.preventDefault();
	var owner_id = $(this).attr('data-owner');
	var text = $('.review-textarea').val();
	var facility = parseInt($('#star-facility').attr('data-rating'));
	var service = parseInt($('#star-service').attr('data-rating'));
	var clean = parseInt($('#star-clean').attr('data-rating'));
	var vibe = parseInt($('#star-vibe').attr('data-rating'));
	var knowledge = parseInt($('#star-knowledge').attr('data-rating'));
	var like = parseInt($('#star-like').attr('data-rating'));
	var global = parseInt($('#star-global').attr('data-rating'));	
	var url = $(this).attr('data-url');
		
	$('#review-form').fadeOut();
	$('#progress-review').removeClass('dn');
	$.ajax({
		url: 	url,
	  	type: 	'post',
		async:  true,
  		data: { 'owner_id': owner_id, 'text': text, 'facility': facility, 'service': service, 'clean': clean, 'vibe': vibe, 'knowledge': knowledge, 'like': like, 'global': global, 'submit': 'add'}
	})
	.done(function(res) {
		$('#progress-review').addClass('dn');
		$('#review-new').after(res);
	});	
});

$(document).on('click', '.bthrow', function(event) {
	var id = $(this).attr('data-id');
	var baseUrl = $(this).attr('data-url');
	$.ajax({
    	type: "POST",
        cache: false,
        url: baseUrl + 'ajax/checkBooking',
		data: {'id': id, 'submit': 'check'},
        success: function(res) 
        {
			$('#booking-'+id).fadeOut();
			var badges = parseInt($('#bbooking').html());
			if(badges > 1){
				badges = badges-1;
			} else {
				badges = '';
			}
			$('#bbooking').html(badges);	
		},
        async: true
	});

});

function checkReview(baseUrl,id) {
			
	$.ajax({
    	type: "POST",
        cache: false,
        url: baseUrl + 'ajax/checkReview',
		data: {'id': id, 'submit': 'check'},
        success: function(res) 
        {
			$('#review-'+id).fadeOut();
			var badges = parseInt($('#breview').html());
			if(badges > 1){
				badges = badges-1;
			} else {
				badges = '';
			}
			$('#breview').html(badges);	
		},
        async: true
	});
};

function showCalendar() {
	
    var mode = $('input[name=mode]').val();
	if(mode == 'dashboard') {
		var trainer_id = $('input[name=trainer_id]').val();	
	} else {
		var trainer_id = $("select[name=trainer_id] option:selected" ).val();
		var sum = $("select[name=trainer_id] option:selected" ).attr('data-price');
	}
	var url = $('input[name=curl]').val();
	var type = $('input[name=type]').val();
	$('input[name=sum]').val(sum);
	$('#progress').show();
		
	$.ajax({
		url: 	url,
	  	type: 	'post',
		async: 	true,
  		data: { 'trainer_id': trainer_id,'type': type,'submit': 'ok' },
		success: function(res) 
        {		
			var jsbase = $('input[name=jsbase]').val();
			$('#progress').hide();
			$('#calendar').html(res);
			$.getScript(jsbase+"after_ajax.js");
		},
        async: true
	});	
};

$(document).on('click', '#send_msg2', function(event) {
	var url = $('input[name=send_url]').val();
	$('#progress3').removeClass('dn');
	$('#msgbutton').hide();
	$.ajax({
		url: 	url,
	  	type: 	'post',
		async: 	true,
  		data: $("#message_send").serialize()
	})
	.done(function(res) {
		$('#progress3').addClass('dn');
		$('#msgbutton').show();						
		//$('#message3_res').html(res);
		// close modal
		$('#messageModal2').modal('hide');
	});	
});

$(document).on('click', '#reply_send_msg', function(event) {
	var url = $('input[name=send_url]').val();
	$('#reply_progress3').removeClass('dn');
	$('#reply_msgbutton').hide();
	$.ajax({
		url: 	url,
	  	type: 	'post',
		async: 	true,
  		data: $("#reply_message_send").serialize()
	})
	.done(function(res) {
		$('#reply_progress3').addClass('dn');
		$('#reply_msgbutton').show();						
		//$('#message3_res').html(res);
		// close modal
		$('#messageModal').modal('hide');
	});	
});

$(document).on('click', 'a.connect', function(event) {
	event.preventDefault();
	var url = $(this).attr('href');
	var user_id = $(this).attr('data-id');
	var action = $(this).attr('data-action');
	var mode = $(this).attr('data-mode');
	
	$('#text-connect').remove();
	$('#progress-connect').removeClass('dn');
	
	$.ajax({
		url: 	url+action,
	  	type: 	'post',
		async: 	true,
  		data: { 'user_id': user_id,'submit': 'ok' }
	})
	.done(function(res) {
		if(action == 'invite') {
			$('a.connect').addClass('not-active');
			$('a.connect').html('INVITED');
		} else {
			$('a.connect').attr('action','invite');
			$('a.connect').html('CONNECT');
		}
		if(mode == 'list') {
			$('tr.invite-'+user_id).fadeOut();
		}
		if(mode == 'dashboard') {
			$('a.connect').remove();
		}				
	});	
});

$(function() {
                $("#location-city").autocomplete({
                    source: '/search/city_typedown',
                    html: true,
                    minLength: 1
                });
                $("input.user_list").autocomplete({
                    source: '/search/user_typedown',
                    html: true,
                    minLength: 1
                }).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.label + "</a>" )
        .appendTo( ul );
    };
});


/*
$(document).on('keyup', 'input.user_list', function(event) {
		var form = $(this).closest('form');
		var url = form.find('input[name=url]').val();
		$.ajax({
        	type: "POST",
			cache: false,
        	url: url,
			data: form.serialize(),
        	success: function(res) 
        	{
				$("input.user_list").autocomplete({
					source: JSON.parse(res)
				});    
			},
        	async: true
		});
});
*/


$(document).on('click', '.paging', function(event) {
        event.preventDefault();
        var page = $(this).attr('data-page');
        $('#ajax-table').attr('data-page',page);
        tableList($('#start'))
    });

    //CALENDAR
$('button.mbook').click(function() {
        var date = $(this).attr('data-date');
        $('input[name=date]').val(date);
});

$(document).on('keyup', '#search', function(event) {
    var searchValue = $('#search').val();
    setTimeout(function(){
        if(searchValue == $('#search').val() && searchValue != null && searchValue != "") {
            tableList($('#start'));
        } else if(searchValue == "") {
            tableList($('#start'));
        }
    },300);
});

// filter options
$(document).on('click', '#filter', function(event) {
	if ($('#filter-options').hasClass('dn')) {
	    $('#filter-options').removeClass('dn');
    } else {
	    $('#filter-options').addClass('dn');
    }
});

$(document).on('click', '#filter-apply', function(event) {
    tableList($('#start'));
});


    //SELECT CLASS
$(document).on('click', '.schedule-carousel .hours li', function(event) {
        if($(this).find('.details').hasClass('dn')) {
            $(this).find('.details').removeClass('dn');
            $(this).find('.action').addClass('dn');
            $(this).find('.action div').removeClass('booked');
        } else {
            $(this).find('.details').addClass('dn');
            $(this).find('.action').removeClass('dn');
            $(this).find('.action div').addClass('booked');
        }
        if($(".action div").hasClass('booked')) {
            $('form.book input[type=submit]').removeAttr('disabled');
        } else {
            $('form.book input[type=submit]').attr('disabled','disabled');
        }
});

$(document).on('change', '.search-filter', function(event) {
    tableList($('#start'));
});
