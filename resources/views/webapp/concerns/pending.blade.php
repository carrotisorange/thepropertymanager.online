@extends('layouts.argon.main')

@section('title', 'Pending concerns')

@section('css')
 <style>
/*This will work on every browser*/
thead tr:nth-child(1) th {
  background: white;
  position: sticky;
  top: 0;
  z-index: 10;
}
</style>   
@endsection

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">List of pending/active concern/s ({{ $pending_concerns->count() }})</h6>
    
  </div>
  

</div>
<div class="row">
    <div class="col">
        <div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
             
      <table class="table table-hover">
        <thead>
          <?php $ctr=1; ?>
          <tr>
              <th>#</th>
              <th>Received On</th>
              <th>Reported By</th>
             <th>Room</th>
              
              <th>Urgency</th>
              <th>Status</th> 
              <th>Assigned to</th>
              <th>Rating</th>
              <th></th>
    
         </tr>
        </thead>
        <tbody>
          @foreach ($pending_concerns as $item)
          <tr>
            <th>{{ $ctr++ }}</th>
         
            <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d Y') }}</td>
              <td>
                @if(Auth::user()->role_id_foreign === 1 || Auth::user()->role_id_foreign === 4)
                <a href="/property/{{Session::get('property_id')}}/tenant/{{$item->tenant_id}}/#concerns">{{ $item->first_name.' '.$item->last_name }}</a>
                @else
               {{ $item->first_name.' '.$item->last_name }}
                @endif
             
              </td>
              <td>
                @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 || Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type') === '6')
                  @if(Auth::user()->role_id_foreign === 1 || Auth::user()->role_id_foreign === 4)
                  <a href="/property/{{Session::get('property_id')}}/unit/{{ $item-> unit_id  }}/#concerns"> {{$item->building.' '.$item->unit_no }}</a>
                  @else
                  {{$item->building.' '.$item->unit_no }}
                  @endif
                @else
                  @if(Auth::user()->role_id_foreign === 1 || Auth::user()->role_id_foreign === 4)
                  <a href="/property/{{Session::get('property_id')}}/room/{{ $item-> unit_id  }}/#concerns"> {{$item->building.' '.$item->unit_no }}</a>
                  @else
                  {{$item->building.' '.$item->unit_no }}
                  @endif
                @endif
                 
               
              </td>
             
                    
              <td>
                  @if($item->urgency === 'urgent')
                  <span class="badge badge-danger">{{ $item->urgency }}</span>
                  @elseif($item->urgency === 'major')
                  <span class="badge badge-warning">{{ $item->urgency }}</span>
                  @else
                  <span class="badge badge-primary">{{ $item->urgency }}</span>
                  @endif
              </td>
              <td>
                @if($item->concern_status === 'pending')
                <span class="text-warning"><i class="fas fa-clock "></i> {{ $item->concern_status }}</span>
                @elseif($item->concern_status === 'active')
                <span class="text-primary"><i class="fas fa-snowboarding "></i> {{ $item->concern_status }}</span>
                @else
                <span class="text-success"><i class="fas fa-check-circle "></i> {{ $item->concern_status }}</span>
                @endif
              </td>
              <td>{{ $item->name }}</td>
              <td>{{ $item->rating? $item->rating.'/5' : 'NA' }}</td>
              <td><a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/endorsed_to/{{ $item->concern_user_id }}/resolved_by/{{ $item->resolved_by }}/view"><i class="fas fa-eye"></i> View</a></td>
            
          </tr>
          @endforeach
        </tbody>
      </table>
            </div>
    </div>
</div>

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



