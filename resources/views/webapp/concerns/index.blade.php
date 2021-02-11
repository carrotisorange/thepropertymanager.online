@extends('layouts.argon.main')

@section('title', 'Concerns')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6">
    <h6 class="h2 text-dark d-inline-block mb-0">Concerns</h6>
    
  </div>

</div>
@if($concerns->count() <=0 )
<p class="text-danger text-center">No concerns found!</p>

@else
<div class="table-responsive text-nowrap">
     
  <table class="table" >
    <thead>
      <?php $ctr=1; ?>
      <tr>
          <th>#</th>
          <th>Reported</th>
          <th>Reported By</th>
          @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
          <th>Unit</th>
          @else
          <th>Room</th>
          @endif
          <th>Title</th>
          <th>Urgency</th>
          <th>Status</th> 
          <th>Assigned to</th>
          <th>Rating</th>

     </tr>
    </thead>
    <tbody>
      @foreach ($concerns as $item)
      <tr>
        <th>{{ $ctr++ }}</th>
     
        <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d Y') }}</td>
          <th>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager')
            <a href="/property/{{Session::get('property_id')}}/tenant/{{$item->tenant_id}}/#concerns">{{ $item->first_name.' '.$item->last_name }}</a>
            @else
           {{ $item->first_name.' '.$item->last_name }}
            @endif
         
          </th>
          <th>
            @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
              @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager')
              <a href="/property/{{Session::get('property_id')}}/unit/{{ $item-> unit_id  }}/#concerns">{{$item->unit_no }}</a>
              @else
              {{$item->unit_no }}
              @endif
            @else
              @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager')
              <a href="/property/{{Session::get('property_id')}}/room/{{ $item-> unit_id  }}/#concerns">{{$item->unit_no }}</a>
              @else
              {{$item->unit_no }}
              @endif
            @endif
             
           
          </th>
          @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager')
          <th ><a href="/property/{{Session::get('property_id')}}/concern/{{ $item->concern_id }}">{{ $item->title }}</a></th>
          @else
          <th ><a href="/property/{{Session::get('property_id')}}/concern/{{ $item->concern_id }}/assign/{{ Auth::user()->id }}">{{ $item->title }}</a></th>
          @endif
                
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
        
        
      </tr>
      @endforeach
    </tbody>
  </table>
 
</div>
@endif
@endsection



@section('scripts')
  
@endsection



