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

$('#registerModal').on('hidden.bs.modal', function() {
    $('#regform').show();
    $('#res_register').html('');
    $('#regform input').val('');
});

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
