/**
 * Generic Dialog
 */
var GYMHIT_GENERIC_DIALOG = {
    init: function() {
        $(document).on('click', '.generic-modal-trigger', function(event) {
            var e = $(this);
            var title = e.attr('data-title');
            if (title === undefined || title == '') {
                title = 'Ops, sorry!';
            }
            var content = e.attr('data-content');
            $('#genericModal #title').html(title);
            $('#genericModal #content').html(content);
            $('#genericModal').modal('show');
        });
    },
    show: function(title, content) {
        $('#genericModal #title').html(title);
        $('#genericModal #content').html(content);
        $('#genericModal').modal('show');
    }
};

