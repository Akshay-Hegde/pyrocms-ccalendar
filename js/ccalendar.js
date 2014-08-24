$(function() {
    
  $('#calendar').fullCalendar({
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,basicWeek,basicDay'
    },
    defaultDate: moment().format('YYYY-MM-DD'),
    editable: false,
    lazyFetching: true,
    events: '/ccalendar/fetchevents',
    loading: function(bool) {
      var calendarWidth = $('#calendar').width();
      var calendarHeight = $('#calendar').height();
      
      var absCtrHeight = 100;

      $('#loading-text').css('margin-top', absCtrHeight);

      $('#loading').width(calendarWidth);
      $('#loading').height(calendarHeight);

      $('#loading').toggle(bool);
    }
  });
    
});