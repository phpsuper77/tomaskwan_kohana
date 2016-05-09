var Inbox = function () {

    var content = $('.inbox-content');
    var loading = $('.inbox-loading');
    var listListing = '';

    var loadMessages = function (el, name) {
        var url = el.attr('data-url');
        var title = el.attr('data-title');
        listListing = name;

        loading.show();
        content.html('');
        toggleButton(el);

        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) 
            {
                toggleButton(el);

                $('.inbox-nav > li.active').removeClass('active');
                $('.inbox-nav > li.' + name).addClass('active');
                $('.inbox-header > h1').text(title);

                loading.hide();
                content.html(res);
                if (Layout.fixContentHeight) {
                    Layout.fixContentHeight();
                }
                Metronic.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });

        // handle group checkbox:
        jQuery('body').on('change', '.mail-group-checkbox', function () {
            var set = jQuery('.mail-checkbox');
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                $(this).attr("checked", checked);
            });
            jQuery.uniform.update(set);
        });
    }

    var loadMessage = function (el, name, resetMenu) {
        var url = '/message/view';
		var checked = $('#unchecked').html();
        loading.show();
        content.html('');
        toggleButton(el);

        var message_id = el.parent('tr').attr("data-messageid");  
        
        $.ajax({
            type: "POST",
            cache: false,
            url: url,
            dataType: "html",
            data: {'message_id': message_id},
            success: function(res) 
            {
                toggleButton(el);

                if (resetMenu) {
                    $('.inbox-nav > li.active').removeClass('active');
                }
                $('.inbox-header > h1').text('View Message');

                loading.hide();
                content.html(res);
				if(el.parent('tr').hasClass('unread')) {
					if(checked > 1) {
						$('#unchecked').html(checked-1);
						$('#bmessage').html(checked-1);
					} else {
						$('#check').addClass('hide');
						$('#bmessage').html('');
					}
				}
				Layout.fixContentHeight();
                Metronic.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });
    }

    var loadSearchResults = function (el) {
        var url = 'search';

        loading.show();
        content.html('');
        toggleButton(el);

        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) 
            {
                toggleButton(el);

                $('.inbox-nav > li.active').removeClass('active');
                $('.inbox-header > h1').text('Search');

                loading.hide();
                content.html(res);
                Layout.fixContentHeight();
                Metronic.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });
    }

    var toggleButton = function(el) {
        if (typeof el == 'undefined') {
            return;
        }
        if (el.attr("disabled")) {
            el.attr("disabled", false);
        } else {
            el.attr("disabled", true);
        }
    }

    return {
        //main function to initiate the module
        init: function () {

            // handle discard btn
            $('.inbox').on('click', '.inbox-discard-btn', function(e) {
                e.preventDefault();
                loadMessages($(this), listListing);
            });

            // handle view message
            $('.inbox-content').on('click', '.view-message', function () {
                loadMessage($(this));
            });

            // handle inbox listing
            $('.inbox-nav > li.inbox > a').click(function () {
                loadMessages($(this), 'inbox');
            });

            // handle sent listing
            $('.inbox-nav > li.sent > a').click(function () {
                loadMessages($(this), 'sent');
            });

            // handle trash listing
            $('.inbox-nav > li.trash > a').click(function () {
                loadMessages($(this), 'trash');
            });
			
			//handle loading content based on URL parameter
            if (Metronic.getURLParameter("a") === "view") {
                loadMessage();
            } else {
               $('.inbox-nav > li.inbox > a').click();
            }

        }

    };

}();
