document.addEventListener("DOMContentLoaded", function() {
    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        headerToolbar: {
            center: "dayGridMonth,timeGridWeek,timeGridDay"
        }, // buttons for switching between views

        views: {
            dayGridMonth: {
                // name of view
                titleFormat: {
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit"
                },
                // other view-specific options here
            },
        },
        events: eventData,
    });

    calendar.render();
});