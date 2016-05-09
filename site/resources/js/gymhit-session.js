/**
 * Booking Manager
 */
var GYMHIT_SESSION_MANAGER = {
    _route: '',
    _uri: '',
    _id: '',
    init: function (id,uri,route, defaultDate) {

        $(document).on('click', '#addSessionForm #submit', function(event) {
            if ($('#sessionSelectedTimes li').length == 0)  {
                event.preventDefault();
                // TODO - move message out of JS
                GYMHIT_GENERIC_DIALOG.show('Ops!','You must select a session first.');
            }
        });


        GYMHIT_SESSION_MANAGER._id = id;
        GYMHIT_SESSION_MANAGER._uri = uri;
        GYMHIT_SESSION_MANAGER._route = route;
        var cal = $(GYMHIT_SESSION_MANAGER.getCalId());
        cal.fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            contentHeight: 600,
            allDaySlot: false,
            eventClick: GYMHIT_SESSION_MANAGER.eventClick,
            eventSources: [{
                events: GYMHIT_SESSION_MANAGER.events
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
            url: GYMHIT_SESSION_MANAGER._uri + '/session_json/'+GYMHIT_SESSION_MANAGER._route,
            dataType: 'json',
            data: {
                start: start.format('YYYY-MM-DD'),
                end: end.format('YYYY-MM-DD'),
                timezone: end.unix()
            },
            success: function(results) {
                var events = [];

                $('.staffof-host').hide();
                for (var i = 0, len = results.length; i < len; i++) {
                    var id = results[i].start_time + '_' + results[i].end_time + '_' + results[i].location_id;
                    if ($('#item-'+id).length > 0) {
                        results[i].backgroundColor = GYMHIT_SESSION_MANAGER.getSelectedColor();
                        results[i].selected = '1';
                    } else {
                        if (results[i].type == 'available') {
                            results[i].backgroundColor = GYMHIT_SESSION_MANAGER.getDefaultColor(results[i].host_no);
                        }
                    }

                    // set legend
                    $('#staffof-host-'+results[i].host_id).show();
                    $('#staffof-host-'+results[i].host_id+ ' .staffof-value .staffof-color').css('background-color', 
                        GYMHIT_SESSION_MANAGER.getDefaultColor(results[i].host_no));
                    
                    //if (!$('#sessionLegend #host-'+results[i].host_no).length > 0) {
                    //    $('#sessionLegend').append('<li id="host-'+results[i].host_no+'">' + GYMHIT_SESSION_MANAGER.getDefaultColor(results[i].host_no) + '</li>');
                    //}

                    results[i].selected = '';
                    events.push(results[i]);
                }
                callback(events);
            }
        });
    },
    eventClick: function(calEvent, jsEvent, view) {

        var id = calEvent.start_time + '_' + calEvent.end_time + '_' + calEvent.location_id;
        if (calEvent.backgroundColor == GYMHIT_SESSION_MANAGER.getSelectedColor()) {
            calEvent.backgroundColor = GYMHIT_SESSION_MANAGER.getDefaultColor(calEvent.host_no);
            calEvent.selected = '';

            $('#item-'+id).remove();
            $('#input-'+id).remove();
        } else {
            calEvent.selected = '1';
            calEvent.backgroundColor = GYMHIT_SESSION_MANAGER.getSelectedColor();

            $('#sessionSelectedTimes').append('<li id="item-' + id + '">' +
                                        '<div class="gh-value">'+
                                        GYMHIT_APP.formatDate(calEvent.start_time) + ' ' +
                                        GYMHIT_APP.formatTime(calEvent.start_time) + '-' + GYMHIT_APP.formatTime(calEvent.end_time) + ' ' +
                                        '$' + calEvent.price + 
                                        '</div>' +
                                        '</li>');
            $('#item-'+id).data(calEvent);

            // add data to form
            var params = {};
            params['start'] = calEvent.start_time;
            params['end'] = calEvent.end_time;
            params['location_id'] = calEvent.location_id;
            params['host_id'] = calEvent.host_id;
            params['price'] = calEvent.price;
            $('#addSessionForm').append('<input id="input-' + id + '" type="hidden" name="sessions[]" value=\'' + JSON.stringify(params) + '\'>');
        }

        $(GYMHIT_SESSION_MANAGER.getCalId()).fullCalendar('rerenderEvents');
    },
    getCalId: function() {
        return GYMHIT_SESSION_MANAGER._id;
    },
    getSelectedColor: function() {
        return '#aaaacc';
    },
    getDefaultColor: function(i) {
        if (i == 1) {
            return '#cc66cc';
        } else if (i == 2) {
            return '#888888';
        } else {
            return '#6666cc';
        }
    }
};
