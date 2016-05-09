/**
 * Booking Manager
 */
var GYMHIT_CALENDAR_MANAGER = {
    _id: '',
    _uri: '',
    init: function (id, uri, defaultDate) {
        GYMHIT_CALENDAR_MANAGER._id = id;
        GYMHIT_CALENDAR_MANAGER._uri = uri;
        var cal = $(GYMHIT_CALENDAR_MANAGER.getCalId());
        cal.fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            contentHeight: 600,
            allDaySlot: false,
            eventClick: GYMHIT_CALENDAR_MANAGER.eventClick,
            eventSources: [{
                events: GYMHIT_CALENDAR_MANAGER.events
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
    formatDate: function(t) {
        return moment(new Date(t*1000)).tz('America/Los_Angeles').format('DD/MM/YYYY HH:mm');
    },
    events: function(start, end, timezone, callback) {
        $.ajax({
            url: GYMHIT_CALENDAR_MANAGER._uri + '/json',
            dataType: 'json',
            data: {
                start: start.format('YYYY-MM-DD'),
                end: end.format('YYYY-MM-DD'),
                timezone: end.unix()
            },
            success: function(results) {
                var events = [];
                for (var i = 0, len = results.length; i < len; i++) {
                    if (results[i].type == 'session') {
                        results[i].color = GYMHIT_CALENDAR_MANAGER.getSessionColor();
                    } else if (results[i].type == 'tour') {
                        results[i].color = GYMHIT_CALENDAR_MANAGER.getTourColor();
                    } else if (results[i].type == 'class') {
                        results[i].color = GYMHIT_CALENDAR_MANAGER.getClassColor();
                    } else {
                        results[i].color = GYMHIT_CALENDAR_MANAGER.getDefaultColor();
                    }
                    results[i].selected = '';
                    events.push(results[i]);
                }
                callback(events);
            }
        });
    },
    eventClick: function(calEvent, jsEvent, view) {
        GYMHIT_STATS.track('ui.event.click', {'id':calEvent.id});
        $('#selectedEvent').empty();
        $('#selectedEvent').append('<div id="item1">' +
                                        '<div class="gh-title">ID</div>'+
                                        '<div class="gh-value">'+calEvent.id+ '</div>' +
                                        '<div class="gh-title">Name</div>'+
                                        '<div class="gh-value">'+calEvent.name+ '</div>' +
                                        '<div class="gh-title">Start Time</div>'+
                                        '<div class="gh-value">'+GYMHIT_CALENDAR_MANAGER.formatDate(calEvent.start_time)+ '</div>' +
                                        '<div class="gh-title">End Time</div>'+
                                        '<div class="gh-value">'+ GYMHIT_CALENDAR_MANAGER.formatDate(calEvent.end_time)+ '</div>' +
                                        '<div class="gh-title">Type</div>'+
                                        '<div class="gh-value">'+ calEvent.type+ '</div>' +
                                        '<div class="gh-title">Owner Name</div>'+
                                        '<div class="gh-value"><a href="' + calEvent.owner_url + '">'+ calEvent.owner_name + '</a></div>' +
                                        '<div class="gh-title">Facility</div>'+
                                        '<div class="gh-value"><a href="' + calEvent.host_url + '">'+ calEvent.host_name + '</a></div>' +
                                        '<div class="gh-title">Location</div>'+
                                        '<div class="gh-value">'+ calEvent.location+ '</div>' +
                                        '<a href="/myevent/view/' + calEvent.id + '" class="btn green-haze">Details</a>' +
                                        '</div>');
        $(GYMHIT_CALENDAR_MANAGER.getCalId()).fullCalendar('rerenderEvents');
    },
    getCalId: function() {
        return GYMHIT_CALENDAR_MANAGER._id;
    },
    getSelectedColor: function() {
        return '#aaaacc';
    },
    getClassColor: function() {
        return '#888888';
    },
    getSessionColor: function() {
        return '#444444';
    },
    getTourColor: function() {
        return '#aaaaaa';
    },
    getDefaultColor: function() {
        return '#6666cc';
    }
};
