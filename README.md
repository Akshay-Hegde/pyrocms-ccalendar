pyrocms-ccalendar
=================

A simple calendar module for PyroCMS (2.2.x).

Features
=================
- Fully uses PyroStreams
- Simple event management for the administrator
- Events has color "tags"
- Events can have banner images
- Upcoming events widget
- FullCalendar view

Installation
=================
1. Clone or download the source code
2. Extract it to the addons directory (you can also upload it using the upload module tool from the administrator's panel). Rename the pyrocms-ccalendar directory to ccalendar before installing. :)
3. Install it (just click the install button from the module pages of the administrator's panel)

TODO
=================
- Add settings for javascripts (or even css?) to fix the possible conflict with templates that uses the libraries that we are using. Examples are:
    - is_moment_enabled
    - is_jquery_admin
    - is_jquery_public
    - is_jquery_ui_admin
    - is_jquery_ui_public
- inlucde json header for those actions that are emitting json
- Implement the FullCalendar on the Administrator's panel
- Make the fields that we need "undeletable" via PyroStreams (is this even possible?)
- Create more Widgets
    - Events for a specific range (today, next week, next month, etc)
    - A quick calendar view with number of events for a speficic day
- Replace the "color" tags with categories (includes selecting a custom color)
- Add roles

NOTE
=================
Just override the calendar event view via your template to fit your needs.

Thanks!
=================
- [PyroCMS](https://www.pyrocms.com/)
- [FullCalendar](https://github.com/arshaw/fullcalendar)
