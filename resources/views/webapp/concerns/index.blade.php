@extends('layouts.argon.main')

@section('title', 'Concerns')

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
  <div class="col-lg-6">
    <h6 class="h2 text-dark d-inline-block mb-0">Concerns</h6>

  </div>

</div>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab"
      aria-controls="nav-all" aria-selected="true"><i class="fas fa-tools text-cyan"></i> All
      ({{ $all_concerns->count() }})</a>
    <a class="nav-item nav-link" id="nav-pending-tab" data-toggle="tab" href="#nav-pending" role="tab"
      aria-controls="nav-pending" aria-selected="false"><i class="fas fa-clock text-warning"></i> Pending
      ({{ $pending_concerns->count() }})</a>
    <a class="nav-item nav-link" id="nav-active-tab" data-toggle="tab" href="#nav-active" role="tab"
      aria-controls="nav-active" aria-selected="false"><i class="fas fa-snowboarding text-primary"></i> Active
      ({{ $active_concerns->count() }})</a>
    <a class="nav-item nav-link" id="nav-closed-tab" data-toggle="tab" href="#nav-closed" role="tab"
      aria-controls="nav-closed" aria-selected="false"><i class="fas fa-check text-green"></i> Closed
      ({{ $closed_concerns->count() }})</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <br>
  <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
    <div style="overflow-y:scroll;overflow-x:scroll;height:450px;">

      <table class="table table-hover">
        <thead>
          <?php $ctr=1; ?>
          <tr>
            <th>#</th>
            <th>Reported on</th>
            <th>Reported by</th>
            <th>Room</th>
            <th>Urgency</th>
            <th>Status</th>
            <th>Endorsed to</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($all_concerns as $item)
          <tr>
            <th>{{ $ctr++ }}</th>

            <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d, Y') }}</td>
            <td>
              @if($item->concern_owner_id)
              <a target="_blank"
                href="/property/{{Session::get('property_id')}}/owner/{{$item->concern_owner_id}}/#concerns">{{ $item->concern_owner_name }}
                (owner)</a>
              @else
              <a target="_blank"
                href="/property/{{Session::get('property_id')}}/tenant/{{$item->tenant_id}}/#concerns">{{ $item->first_name.' '.$item->last_name }}
                (tenant)</a>
              @endif
            </td>
            <td>
              <a
                href="/property/{{Session::get('property_id')}}/room/{{ $item-> unit_id  }}/#concerns">{{ $item->building.' '.$item->unit_no }}</a>
            </td>

            <td>
              @if($item->urgency === 'emergency')
              <span class="text-danger"><i class="fas fa-exclamation-triangle "></i> {{ $item->urgency }}</span>
              @elseif($item->urgency === 'major')
              <span class="text-warning"><i class="fas fa-exclamation-circle "></i> {{ $item->urgency }}</span>
              @else
              <span class="text-warning"><i class="fas fa-clock "></i> {{ $item->urgency }}</span>
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
            <td><a href="/property/{{ Session::get('property_id') }}/user/{{ $item->id }}">{{ $item->name }}
                ({{ $item->role }})</a> </td>

            <td><a
                href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/endorsed_to/{{ $item->concern_user_id }}/resolved_by/{{ $item->resolved_by }}/view"><i
                  class="fas fa-eye"></i> View</a></td>

          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
  <div class="tab-pane fade" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
    <div style="overflow-y:scroll;overflow-x:scroll;height:450px;">

 <table class="table table-hover">
    <thead>
      <?php $ctr=1; ?>
      <tr>
        <th>#</th>
        <th>Reported on</th>
        <th>Reported by</th>
        <th>Room</th>
        <th>Urgency</th>
        <th>Status</th>
        <th>Endorsed to</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pending_concerns as $item)
      <tr>
        <th>{{ $ctr++ }}</th>
  
        <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d, Y') }}</td>
        <td>
          @if($item->concern_owner_id)
          <a target="_blank"
            href="/property/{{Session::get('property_id')}}/owner/{{$item->concern_owner_id}}/#concerns">{{ $item->concern_owner_name }}
            (owner)</a>
          @else
          <a target="_blank"
            href="/property/{{Session::get('property_id')}}/tenant/{{$item->tenant_id}}/#concerns">{{ $item->first_name.' '.$item->last_name }}
            (tenant)</a>
          @endif
        </td>
        <td>
          <a
            href="/property/{{Session::get('property_id')}}/room/{{ $item-> unit_id  }}/#concerns">{{ $item->building.' '.$item->unit_no }}</a>
        </td>
  
        <td>
          @if($item->urgency === 'emergency')
          <span class="text-danger"><i class="fas fa-exclamation-triangle "></i> {{ $item->urgency }}</span>
          @elseif($item->urgency === 'major')
          <span class="text-warning"><i class="fas fa-exclamation-circle "></i> {{ $item->urgency }}</span>
          @else
          <span class="text-warning"><i class="fas fa-clock "></i> {{ $item->urgency }}</span>
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
        <td><a href="/property/{{ Session::get('property_id') }}/user/{{ $item->id }}">{{ $item->name }}
            ({{ $item->role }})</a> </td>
  
        <td><a
            href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/endorsed_to/{{ $item->concern_user_id }}/resolved_by/{{ $item->resolved_by }}/view"><i
              class="fas fa-eye"></i> View</a></td>
  
      </tr>
      @endforeach
    </tbody>
  </table>

    </div>
  </div>
  <div class="tab-pane fade" id="nav-active" role="tabpanel" aria-labelledby="nav-active-tab">
    <div style="overflow-y:scroll;overflow-x:scroll;height:450px;">

     <table class="table table-hover">
        <thead>
          <?php $ctr=1; ?>
          <tr>
            <th>#</th>
            <th>Reported on</th>
            <th>Reported by</th>
            <th>Room</th>
            <th>Urgency</th>
            <th>Status</th>
            <th>Endorsed to</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($active_concerns as $item)
          <tr>
            <th>{{ $ctr++ }}</th>
      
            <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d, Y') }}</td>
            <td>
              @if($item->concern_owner_id)
              <a target="_blank"
                href="/property/{{Session::get('property_id')}}/owner/{{$item->concern_owner_id}}/#concerns">{{ $item->concern_owner_name }}
                (owner)</a>
              @else
              <a target="_blank"
                href="/property/{{Session::get('property_id')}}/tenant/{{$item->tenant_id}}/#concerns">{{ $item->first_name.' '.$item->last_name }}
                (tenant)</a>
              @endif
            </td>
            <td>
              <a
                href="/property/{{Session::get('property_id')}}/room/{{ $item-> unit_id  }}/#concerns">{{ $item->building.' '.$item->unit_no }}</a>
            </td>
      
            <td>
              @if($item->urgency === 'emergency')
              <span class="text-danger"><i class="fas fa-exclamation-triangle "></i> {{ $item->urgency }}</span>
              @elseif($item->urgency === 'major')
              <span class="text-warning"><i class="fas fa-exclamation-circle "></i> {{ $item->urgency }}</span>
              @else
              <span class="text-warning"><i class="fas fa-clock "></i> {{ $item->urgency }}</span>
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
            <td><a href="/property/{{ Session::get('property_id') }}/user/{{ $item->id }}">{{ $item->name }}
                ({{ $item->role }})</a> </td>
      
            <td><a
                href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/endorsed_to/{{ $item->concern_user_id }}/resolved_by/{{ $item->resolved_by }}/view"><i
                  class="fas fa-eye"></i> View</a></td>
      
          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
  <div class="tab-pane fade" id="nav-closed" role="tabpanel" aria-labelledby="nav-closed-tab">
    <div style="overflow-y:scroll;overflow-x:scroll;height:450px;">

<table class="table table-hover">
  <thead>
    <?php $ctr=1; ?>
    <tr>
      <th>#</th>
      <th>Reported on</th>
      <th>Reported by</th>
      <th>Room</th>
      <th>Urgency</th>
      <th>Status</th>
      <th>Endorsed to</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($closed_concerns as $item)
    <tr>
      <th>{{ $ctr++ }}</th>

      <td>{{ Carbon\Carbon::parse($item->reported_at)->format('M d, Y') }}</td>
      <td>
        @if($item->concern_owner_id)
        <a target="_blank"
          href="/property/{{Session::get('property_id')}}/owner/{{$item->concern_owner_id}}/#concerns">{{ $item->concern_owner_name }}
          (owner)</a>
        @else
        <a target="_blank"
          href="/property/{{Session::get('property_id')}}/tenant/{{$item->tenant_id}}/#concerns">{{ $item->first_name.' '.$item->last_name }}
          (tenant)</a>
        @endif
      </td>
      <td>
        <a
          href="/property/{{Session::get('property_id')}}/room/{{ $item-> unit_id  }}/#concerns">{{ $item->building.' '.$item->unit_no }}</a>
      </td>

      <td>
        @if($item->urgency === 'emergency')
        <span class="text-danger"><i class="fas fa-exclamation-triangle "></i> {{ $item->urgency }}</span>
        @elseif($item->urgency === 'major')
        <span class="text-warning"><i class="fas fa-exclamation-circle "></i> {{ $item->urgency }}</span>
        @else
        <span class="text-warning"><i class="fas fa-clock "></i> {{ $item->urgency }}</span>
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
      <td><a href="/property/{{ Session::get('property_id') }}/user/{{ $item->id }}">{{ $item->name }}
          ({{ $item->role }})</a> </td>

      <td><a
          href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/endorsed_to/{{ $item->concern_user_id }}/resolved_by/{{ $item->resolved_by }}/view"><i
            class="fas fa-eye"></i> View</a></td>

    </tr>
    @endforeach
  </tbody>
</table>

    </div>
  </div>
</div>
@endsection



@section('scripts')

@endsection