var Login = function () {

	var handleLogin = function() {
		$('.login-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
					email: {
	                    required: true,
						email:true
	                },
	                password: {
	                    required: true
	                },
	                remember: {
	                    required: false
	                }
	            },

	            messages: {
					email: {
	                    required: "Email is required."
	                },
	                password: {
	                    required: "Password is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-danger', $('.login-form')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
					login();
	            }
	        });

	        $('.login-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.login-form').validate().form()) {
	                    login();
	                }
	                return false;
	            }
	        });
	}

	var handleForgetPassword = function () {
		$('.forget-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                email: {
	                    required: true,
	                    email: true
	                }
	            },

	            messages: {
	                email: {
	                    required: "Email is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

	        $('.forget-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.forget-form').validate().form()) {
	                    $('.forget-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#forget-password').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.forget-form').show();
	        });
			
			jQuery('#back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.forget-form').hide();
	        });

	}

	var handleRegister = function () {

		var path = $('#register-form :input[name="base_url"]').val();
		
		$('.register-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                
	                name: {
	                    required: true,
						minlength: 3,
						remote:
                    	{
                      		url: path + "ajax/validateName",
                      		type: "post",
                      		data:
                      		{
                         		name: function()
                          		{
                              		return $('#register-form :input[name="name"]').val();
                          		}
                      		}
                    	}
	                },
	                email: {
	                    required: true,
	                    email: true,
						remote:
                    	{
                      		url: path + "ajax/validateEmail",
                      		type: "post",
                      		data:
                      		{
                         		email: function()
                          		{
                              		return $('#register-form :input[name="email"]').val();
                          		}
                      		}
                    	}
	                },
					birth_date: {
						date: true,
						remote:
                    	{
                      		url: path + "ajax/validateAge",
                      		type: "post",
                      		data:
                      		{
                         		birth_date: function()
                          		{
                              		return $('#register-form :input[name="birth_date"]').val();
                          		}
                      		}
                    	}
	                },
	                zip: {
	                    required: true
	                },
					phone: {
						remote:
                    	{
                      		url: path + "ajax/validatePhone",
                      		type: "post",
                      		data:
                      		{
                         		email: function()
                          		{
                              		return $('#register-form :input[name="phone"]').val();
                          		}
                      		}
                    	}
	                },
					zip: {
	                    zipcodeUS: true
	                },
	                role: {
	                    required: true
	                },
	                password: {
	                    required: true
	                },
	                rpassword: {
	                    equalTo: "#register_password"
	                },

	                tnc: {
	                    required: true
	                }
	            },

	            messages: { // custom messages for radio buttons and checkboxes
	                name:
                 	{
                    	required: "Please enter your name.",
                    	minlength: "Name must be at least 3 characters.",
                    	remote: "Name can only contain 0-9, A-Z and the following symbols ()-."
                 	},
					tnc: {
	                    required: "Please accept TNC first."
	                },
					zip: {
	                    required: "Please enter zip code."
	                },
					email:
                 	{
                    	required: "Please enter your email address.",
                    	email: "Please enter a valid email address.",
                    	remote: "This email is already taken."
                 	},
					birth_date:
                 	{
                    	required: "Please enter your birth_date.",
                    	date: "Please enter a valid date.",
                    	remote: "You must be at least 13 years old to register."
                 	},
					phone:
                 	{
                    	remote: "Phone number should be in (XXX) XXX-XXXX"
                 	},
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
	                    error.insertAfter($('#register_tnc_error'));
	                } else if (element.closest('.input-icon').size() === 1) {
	                    error.insertAfter(element.closest('.input-icon'));
	                } else {
	                	error.insertAfter(element);
	                }
	            },

	            submitHandler: function (form) {
console.log("XXX 1");
	                register();
	            }
	        });

			$('.register-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.register-form').validate().form()) {
console.log("XXX 2");
	                    register();
	                }
	                return false;
	            }
	        });
	}
    
    return {
        //main function to initiate the module
        init: function () {
        	
            handleLogin();
            handleForgetPassword();
            handleRegister();    
        }

    };

}();
