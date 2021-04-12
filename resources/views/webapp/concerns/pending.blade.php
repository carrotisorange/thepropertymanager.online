@extends('layouts.argon.main')

@section('title', 'Pending concerns')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">List of pending/active concern/s ({{ $pending_concerns->count() }})</h6>
    
  </div>
  

</div>
<div class="row">
    <div class="col">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-condensed">
                <thead>
                    <?php $ctr=1; ?>
                  <tr>
                    <th>#</th>
                    <th>Date reported</th>
                    <th>Tenant</th>
                    <th>Room</th>
                    <th>Status</th>
                    <th>Title</th>
                    <th>Assigned to</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($pending_concerns as $item)
                  <tr>
                    <th>{{ $ctr++ }}</th>
                    <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d, Y') }}</td>
                    <th>
          
                      <a href="/property/{{ Session::get('property_id') }}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}
                
                    </th>
                    <th>
                      @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin' )
                      <a href="/property/{{ Session::get('property_id') }}/home/{{ $item->unit_id   }}">{{ $item->unit_no }}</a>
                      @else
                      {{ $item->unit_no }}
                      @endif
                    </th>
                    <th>
                      @if($item->concern_status === 'pending')
                    <span class="text-warning"><i class="fas fa-clock "></i> {{ $item->concern_status }}</span>
                    @elseif($item->concern_status === 'active')
                    <span class="text-primary"><i class="fas fa-snowboarding "></i> {{ $item->concern_status }}</span>
                    @else
                    <span class="text-success"><i class="fas fa-check-circle "></i> {{ $item->concern_status }}</span>
                    @endif
                    </th>
                    <th>
                      <a href="/property/{{ Session::get('property_id') }}/concern/{{ $item->concern_id   }}">{{ $item->title }}</a>
                    </th>
                    <td>{{ $item->name }}</td>
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



