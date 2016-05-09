/**
 * Booking Manager
 */
var GYMHIT_TOUR_MANAGER = {
    _route: '',
    _uri: '',
    _id: '',
    _lastCalEvent: false,
    init: function (id,uri,route, defaultDate) {
        GYMHIT_TOUR_MANAGER._id = id;
        GYMHIT_TOUR_MANAGER._uri = uri;
        GYMHIT_TOUR_MANAGER._route = route;
        var cal = $(GYMHIT_TOUR_MANAGER.getCalId());
        cal.fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            contentHeight: 600,
            allDaySlot: false,
            eventClick: GYMHIT_TOUR_MANAGER.eventClick,
            eventSources: [{
                events: GYMHIT_TOUR_MANAGER.events
            }],
            defaultDate: defaultDate,
            defaultView: 'agendaWeek',
            editable: false,
            timezone: 'America/Los_Angeles',
            eventLimit: true, // allow "more" link when too many events
            events: [
            ]

        });
    },
    events: function(start, end, timezone, callback) {
        $.ajax({
            url: GYMHIT_TOUR_MANAGER._uri+'/tour_json/'+GYMHIT_TOUR_MANAGER._route,
            dataType: 'json',
            data: {
                start: start.format('YYYY-MM-DD'),
                end: end.format('YYYY-MM-DD'),
                timezone: end.unix()
            },
            success: function(results) {
                var events = [];
                for (var i = 0, len = results.length; i < len; i++) {
                    if (results[i].type == 'available') {
                        results[i].color = GYMHIT_TOUR_MANAGER.getDefaultColor();
                    }
                    results[i].selected = '';
                    events.push(results[i]);
                }
                callback(events);
            }
        });
    },
    eventClick: function(calEvent, jsEvent, view) {
        if (GYMHIT_TOUR_MANAGER._lastCalEvent) {
            GYMHIT_TOUR_MANAGER._lastCalEvent.backgroundColor = GYMHIT_TOUR_MANAGER.getDefaultColor();
            GYMHIT_TOUR_MANAGER._lastCalEvent.selected = '';
        } 

        // select current one
        calEvent.selected = '1';
        calEvent.backgroundColor = GYMHIT_TOUR_MANAGER.getSelectedColor();

        $('#tourSelectedTimes').empty();
        $('#tourSelectedTimes').append('<div id="item1">' +
                                        '<div class="gh-title">Start Time</div>'+
                                        '<div class="gh-value">'+GYMHIT_APP.formatDateTime(calEvent.start_time)+ '</div>' +
                                        '<div class="gh-title">End Time</div>'+
                                        '<div class="gh-value">'+ GYMHIT_APP.formatDateTime(calEvent.end_time)+ '</div>' +
                                        '<div class="gh-title">Location</div>'+
                                        '<div class="gh-value">' + calEvent.location+ '</div>' +
                                        '</div>');
        // add data to form
        $('#addTourForm input[name=start_time]').val(calEvent.start_time);
        $('#addTourForm input[name=end_time]').val(calEvent.end_time);
        $('#addTourForm input[name=location_id]').val(calEvent.location_id);

        GYMHIT_TOUR_MANAGER._lastCalEvent = calEvent;

        $(GYMHIT_TOUR_MANAGER.getCalId()).fullCalendar('rerenderEvents');
    },
    getCalId: function() {
        return GYMHIT_TOUR_MANAGER._id;
    },
    getSelectedColor: function() {
        return '#aaaacc';
    },
    getDefaultColor: function() {
        return '#6666cc';
    }
};
