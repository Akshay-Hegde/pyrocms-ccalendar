$(function() {
    
  $('#ccalendar').fullCalendar({
    header: {
      left: 'prev,next,today',
      right: 'today,prev,next',
      center: 'title'
    },
    defaultDate: moment().format('YYYY-MM-DD'),
    editable: false,
    lazyFetching: true,
    events: '/ccalendar/getevents',
    eventRender: function(event, element) {
      console.log(event, element);
    },
    loading: function(bool) {
      var calendarWidth = $('#ccalendar').width();
      var calendarHeight = $('#ccalendar').height();
      
      var absCtrHeight = 100;

      $('#loading-text').css('margin-top', absCtrHeight);

      $('#loading').width(calendarWidth);
      $('#loading').height(calendarHeight);

      $('#loading').toggle(bool);
    }
  });
    
});