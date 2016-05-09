var GYMHIT_STATS = {
    init: function() {
        mixpanel.identify(loginUserId);
    },
    track: function(evt, params) {
        mixpanel.track(evt, params);
    }
};

$(function() {
    GYMHIT_STATS.init();
});
