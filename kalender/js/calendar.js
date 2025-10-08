$(document).ready(function() {
    // Initialiseer de kalender met FullCalendar
    $('#calendar').fullCalendar({
        locale: 'nl',
        googleCalendarApiKey: 'AIzaSyAQ4xmvN0nJ3Zmz16LF8MvVGcDjLQq0ppA',
        events: function(start, end, timezone, callback) {
            $.ajax({
                //url: 'https://www.googleapis.com/calendar/v3/calendars/2594086083783894d322bba6abfe7e14791dcb848343be5ffaa2138f162be631@group.calendar.google.com/events?key=AIzaSyACbAXrKX9hpn10Pr2JtwaQly9XTWrM-08',
                url: 'https://www.googleapis.com/calendar/v3/calendars/astrid.ugent@gmail.com/events?key=AIzaSyAQ4xmvN0nJ3Zmz16LF8MvVGcDjLQq0ppA',

                dataType: 'json',
                success: function(data) {
                    var events = data.items.map(function(item) {
                        var eventClass = '';
                        var normalizedTitle = item.summary.toLowerCase().replace(/[^a-z0-9 ]/g, '').trim();

                        // Bepaal de eventClass op basis van de titel
                        if (normalizedTitle.includes('feest')) {
                            eventClass = 'fc-feest';
                        } else if (normalizedTitle.includes('lustrum')) {
                            eventClass = 'fc-lustrum';
                        } else if (normalizedTitle.includes('bar')) {
                            eventClass = 'fc-bar';
                        } else if (normalizedTitle.includes('cultuur')) {
                            eventClass = 'fc-cultuur';
                        } else if (normalizedTitle.includes('cantus')) {
                            eventClass = 'fc-cantus';
                        } else if (normalizedTitle.includes('sport')) {
                            eventClass = 'fc-sport';
                        } else if (normalizedTitle.includes('milieu')) {
                            eventClass = 'fc-milieu';
                        } else {
                            eventClass = 'fc-overige';
                        }

                        var startDate = item.start.dateTime || item.start.date;
                        var endDate = item.end.dateTime || item.end.date;

                        return {
                            title: item.summary,
                            start: startDate,
                            end: endDate,
                            className: eventClass,
                            url: null
                        };
                    });
                    callback(events);
                    filterEvents();
                }
            });
        },
        initialView: 'month',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        fixedWeekCount: false,
        firstDay: 1,
        dayNames: [
            "maandag", "dinsdag", "woensdag", "donderdag", "vrijdag", "zaterdag", "zondag"
        ],
        dayNamesShort: [
            "zondag", "maandag", "dinsdag", "woensdag", "vrijdag", "zaterdag", "zondag"
        ],
        height: 'auto',

        // ✅ HIER: Tekst afbreken forceren
        eventRender: function(event, element) {
            element.css({
                'white-space': 'normal',
                'word-break': 'break-word',
                'overflow-wrap': 'break-word',
                'display': 'block'
            });

            element.find('.fc-title').css({
                'white-space': 'normal',
                'word-break': 'break-word',
                'overflow-wrap': 'break-word',
                'display': 'block'
            });
        }

    });

    // Filterfunctie voor evenementen
    function filterEvents() {
        const filters = {
            feest: $('#filter-feest').prop('checked'),
            bar: $('#filter-bar').prop('checked'),
            cultuur: $('#filter-cultuur').prop('checked'),
            cantus: $('#filter-cantus').prop('checked'),
            sport: $('#filter-sport').prop('checked'),
            milieu: $('#filter-milieu').prop('checked'),
            lustrum: $('#filter-lustrum').prop('checked'),
            overige: $('#filter-overige').prop('checked'),
            all: $('#filter-all').prop('checked')
        };

        const allEvents = document.querySelectorAll('.fc-event');
        allEvents.forEach(el => {
            const eventClasses = el.classList;
            let shouldDisplay = filters.all;

            if (!shouldDisplay) {
                eventClasses.forEach(cls => {
                    if (cls.startsWith('fc-') && filters[cls.substring(3)]) {
                        shouldDisplay = true;
                    }
                });
            }

            if (shouldDisplay) {
                el.style.display = 'block';
            } else {
                el.style.display = 'none';
            }
        });
    }

    $('#filters input[type="checkbox"]').on('change', function() {
        filterEvents();
    });
});
