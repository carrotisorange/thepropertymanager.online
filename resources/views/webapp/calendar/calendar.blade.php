@extends('layouts.argon.main')

@section('title', 'Calendar')

@section('css')
    
@endsection

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Calendar</h6>
    
  </div>

</div>
<div class='row'>

  <div class="col-md-3">
      <div id='external-events'>
          <h4>Draggable Events</h4>
    
          <div id='external-events-list'>
            @foreach ($events as $item)
            <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
              <div class='fc-event-main'>{{ $item->event_name }}</div>
            </div>
            @endforeach
            
          </div>
    
          <p>
            <input type='checkbox' id='drop-remove' checked/>
            <label for='drop-remove'>remove after drop</label>
          </p>
        </div>
  </div>

 <div class="col-md-9">
  <div id='calendar-wrap'>
      <div id='calendar'></div>
    </div>
 </div>

</div>
<br>
         {{-- Modal for warning message --}}
         <div class="modal fade" id="addEvent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Event</h5>
              
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <div class="modal-body">
                <form id="eventForm" action="/event" method="POST">
                  @csrf
                  <input form="eventForm" type="text" class="form-control" name="event_name" required>

                  <input form="eventForm" type="hidden" class="form-control" name="property_id" value="{{Session::get('property_id')}}" required>
                
               
              </form>
              </div>
              <div class="modal-footer">
                  <p class="text-right">
                      <button form="eventForm" class="btn btn-primary btn btn-primary" type="submit" onclick="this.form.submit(); this.disabled = true;"><i class="fas fa-check fa-sm text-white-50"></i> Submit</button>
                  </p>
              </div>
              
          </div>
          </div>
</div>
@endsection



@section('scripts')
<script src="{{ asset('fullcalendar/lib/main.js') }}"></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {

    /* initialize the external events
    -----------------------------------------------------------------*/

    var containerEl = document.getElementById('external-events-list');
    new FullCalendar.Draggable(containerEl, {
      itemSelector: '.fc-event',
      eventData: function(eventEl) {
        return {
          title: eventEl.innerText.trim()
        }
      }
    });

    //// the individual way to do it
    // var containerEl = document.getElementById('external-events-list');
    // var eventEls = Array.prototype.slice.call(
    //   containerEl.querySelectorAll('.fc-event')
    // );
    // eventEls.forEach(function(eventEl) {
    //   new FullCalendar.Draggable(eventEl, {
    //     eventData: {
    //       title: eventEl.innerText.trim(),
    //     }
    //   });
    // });

    /* initialize the calendar
    -----------------------------------------------------------------*/

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      editable: true,
      selectable: true,
      droppable: true, // this allows things to be dropped onto the calendar
      drop: function(arg) {
        // is the "remove after drop" checkbox checked?
        if (document.getElementById('drop-remove').checked) {
          // if so, remove the element from the "Draggable Events" list
          arg.draggedEl.parentNode.removeChild(arg.draggedEl);
        }
      },
      eventResize:function(){
        alert('even Resize')
      },
    dayClick:function(date, event, view){

      }
    });
    calendar.render();

  });

</script>
@endsection



