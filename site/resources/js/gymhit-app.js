var GYMHIT_APP = {
    init: function() {
        GYMHIT_GENERIC_DIALOG.init();
    },
    formatDateTime: function(t) {
        return moment(new Date(t*1000)).tz('America/Los_Angeles').format('DD/MM/YYYY HH:mm');
    },
    formatDate: function(t) {
        return moment(new Date(t*1000)).tz('America/Los_Angeles').format('DD/MM/YYYY');
    },
    formatTime: function(t) {
        return moment(new Date(t*1000)).tz('America/Los_Angeles').format('HH:mm');
    }
};

$(function() {
    GYMHIT_APP.init();
});
