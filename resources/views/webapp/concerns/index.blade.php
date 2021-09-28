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
    <a class="nav-item nav-link active" id="nav-all" data-toggle="tab" href="#nav-all-tab" role="tab"
      aria-controls="nav-all" aria-selected="true"><i class="fas fa-tools text-indigo"></i> All <span
        class="badge badge-primary badge-counter">{{ $concerns->count() }}</span></a>
    @foreach ($status as $item)
    <a class="nav-item nav-link" id="nav-{{ $item->status }}" data-toggle="tab" href="#nav-{{ $item->status }}-tab"
      role="tab" aria-controls="nav-{{ $item->status }}" aria-selected="false">
      @if($item->status === 'pending' || $item->status === 'assessed' ||
      $item->status === 'waiting for approval' || $item->status === 'approved' ||
      $item->status === 'request for purchase' || $item->status === 'for purchase')
      <i class="fas fa-clock text-warning"></i>
      @elseif($item->status==='on-going')
      <i class="fas fa-snowboarding text-primary"></i>
      @else
      <i class="fas fa-check text-success"></i>
      @endif
      {{ $item->status }} <span class="badge badge-primary badge-counter">{{ $item->count }}</span></a>
    @endforeach
    @foreach ($category as $item)
    <a class="nav-item nav-link" id="nav-{{ $item->category }}" data-toggle="tab" href="#nav-{{ $item->category }}-tab"
      role="tab" aria-controls="nav-{{ $item->category }}" aria-selected="false">
      @if($item->category==='unit_work')
      <i class="fas fa-home text-primary"></i>
      @elseif($item->category==='hrr_violations')
      <i class="fas fa-users text-primary"></i>
      @elseif($item->category==='contract')
      <i class="fas fa-file-alt text-primary"></i>
      @elseif($item->category==='remittance')
      <i class="fas fa-hand-holding-usd text-primary"></i>
      @else
      <i class="fas fa-file-invoice-dollar text-primary"></i>
      @endif

      {{ $item->category }} <span class="badge badge-primary badge-counter">{{ $item->count }}</span></a>
    @endforeach
  </div>
</nav>
{{-- <nav>
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
</nav> --}}
<div class="tab-content" id="nav-tabContent">
  <br>
  <div class="tab-pane fade show active" id="nav-all-tab" role="tabpanel" aria-labelledby="nav-all-tab">
    <div style="overflow-y:scroll;overflow-x:scroll;height:450px;">

      <table class="table table-hover">
        <thead>
          <?php $ctr=1;?>
          <tr>
            <th>#</th>
            <th>Reported on</th>
            <th>Reported by</th>
            <th>Category</th>
            <th>Room</th>
            <th>Urgency</th>
            <th>Status</th>
            <th>Endorsed to</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($concerns as $item)
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
            <td>{{ $item->category }}</td>
            <td>
              <a href="/property/{{Session::get('property_id')}}/room/{{ $item-> unit_id  }}/#concerns"
                target="_blank">{{ $item->building.' '.$item->unit_no }}</a>
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
              @if($item->concern_status === 'pending' || $item->concern_status === 'assessed' ||
              $item->concern_status === 'waiting for approval' || $item->concern_status === 'approved' ||
              $item->concern_status === 'request for purchase' || $item->concern_status === 'for purchase' )
              <span class="text-warning"><i class="fas fa-clock "></i> {{ $item->concern_status }}</span>
              @elseif($item->concern_status === 'on-going')
              <span class="text-primary"><i class="fas fa-snowboarding "></i> {{ $item->concern_status }}</span>
              @else
              <span class="text-success"><i class="fas fa-check-circle "></i> {{ $item->concern_status }}</span>
              @endif
            </td>
            <td><a href="/property/{{ Session::get('property_id') }}/user/{{ $item->id }}">{{ $item->name }}
                ({{ $item->role }})</a> </td>

            <td>
              @if(Auth::user()->role_id_foreign == '1' || Auth::user()->role_id_foreign == '4')
                @if($item->concern_status === 'pending')
                <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/assessment/"
                  target="_blank"><i class="fas fa-eye"></i> View</a>
                @elseif($item->concern_status === 'assessed')
                <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/scope_of_work/"
                  target="_blank"><i class="fas fa-eye"></i> View</a>
                @elseif($item->concern_status === 'waiting for approval')
                <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/approval/"
                  target="_blank"><i class="fas fa-eye"></i> View</a>
                @elseif($item->concern_status === 'request for purchase')
                <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/materials/"
                  target="_blank"><i class="fas fa-eye"></i> View</a>
                @elseif($item->concern_status === 'approved')
                <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/payment-options/"
                  target="_blank"><i class="fas fa-eye"></i> View</a>
                @endif
                 @else
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/communications/"
                target="_blank"><i class="fas fa-eye"></i> View</a>
              @endif
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>


  @foreach ($status as $status)
  <div class="tab-pane fade" id="nav-{{ $status->status }}-tab" role="tabpanel"
    aria-labelledby="nav-{{ $status->status }}-tab">



    <div style="overflow-y:scroll;overflow-x:scroll;height:450px;">

      <table class="table table-hover">
        <thead>

          <tr>
            <th>#</th>
            <th>Reported on</th>
            <th>Reported by</th>
            <th>Category</th>
            <th>Room</th>
            <th>Urgency</th>
            <th>Status</th>
            <th>Endorsed to</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($concerns as $item)
          @if($item->concern_status === $status->status)
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
            <td>{{ $item->category }}</td>
            <td>
              <a href="/property/{{Session::get('property_id')}}/room/{{ $item-> unit_id  }}/#concerns"
                target="_blank">{{ $item->building.' '.$item->unit_no }}</a>
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
              @if($item->concern_status === 'pending' || $item->concern_status === 'assessed' ||
              $item->concern_status === 'waiting for approval' || $item->concern_status === 'approved' ||
              $item->concern_status === 'request for purchase' || $item->concern_status === 'for purchase' )
              <span class="text-warning"><i class="fas fa-clock "></i> {{ $item->concern_status }}</span>
              @elseif($item->concern_status === 'on-going')
              <span class="text-primary"><i class="fas fa-snowboarding "></i> {{ $item->concern_status }}</span>
              @else
              <span class="text-success"><i class="fas fa-check-circle "></i> {{ $item->concern_status }}</span>
              @endif
            </td>
            <td><a href="/property/{{ Session::get('property_id') }}/user/{{ $item->id }}">{{ $item->name }}
                ({{ $item->role }})</a> </td>

            <td>
              @if(Auth::user()->role_id_foreign == '1' || Auth::user()->role_id_foreign == '4')
              @if($item->concern_status === 'pending')
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/assessment/"
                target="_blank"><i class="fas fa-eye"></i> View</a>
              @elseif($item->concern_status === 'assessed')
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/scope_of_work/"
                target="_blank"><i class="fas fa-eye"></i> View</a>
              @elseif($item->concern_status === 'waiting for approval')
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/approval/"
                target="_blank"><i class="fas fa-eye"></i> View</a>
              @elseif($item->concern_status === 'request for purchase')
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/materials/"
                target="_blank"><i class="fas fa-eye"></i> View</a>
              @elseif($item->concern_status === 'approved')
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/payment-options/"
                target="_blank"><i class="fas fa-eye"></i> View</a>
              @endif
              @else
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/communications/"
                target="_blank"><i class="fas fa-eye"></i> View</a>
                @endif
            </td>

          </tr>
          @else

          @endif

          @endforeach
        </tbody>
      </table>

    </div>

  </div>
  @endforeach

  @foreach ($category as $category)
  <div class="tab-pane fade" id="nav-{{ $category->category }}-tab" role="tabpanel"
    aria-labelledby="nav-{{ $category->category }}-tab">



    <div style="overflow-y:scroll;overflow-x:scroll;height:450px;">

      <table class="table table-hover">
        <thead>

          <tr>
            <th>#</th>
            <th>Reported on</th>
            <th>Reported by</th>
            <th>Category</th>
            <th>Room</th>
            <th>Urgency</th>
            <th>Status</th>
            <th>Endorsed to</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($concerns as $item)
          @if($item->category === $category->category)
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
            <td>{{ $item->category }}</td>
            <td>
              <a href="/property/{{Session::get('property_id')}}/room/{{ $item-> unit_id  }}/#concerns"
                target="_blank">{{ $item->building.' '.$item->unit_no }}</a>
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
              @if($item->concern_status === 'pending' || $item->concern_status === 'assessed' ||
              $item->concern_status === 'waiting for approval' || $item->concern_status === 'approved' ||
              $item->concern_status === 'request for purchase' || $item->concern_status === 'for purchase' )
              <span class="text-warning"><i class="fas fa-clock "></i> {{ $item->concern_status }}</span>
              @elseif($item->concern_status === 'on-going')
              <span class="text-primary"><i class="fas fa-snowboarding "></i> {{ $item->concern_status }}</span>
              @else
              <span class="text-success"><i class="fas fa-check-circle "></i> {{ $item->concern_status }}</span>
              @endif
            </td>
            <td><a href="/property/{{ Session::get('property_id') }}/user/{{ $item->id }}">{{ $item->name }}
                ({{ $item->role }})</a> </td>

            <td>
              @if(Auth::user()->role_id_foreign == '1' || Auth::user()->role_id_foreign == '4')
              @if($item->concern_status === 'pending')
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/assessment/"
                target="_blank"><i class="fas fa-eye"></i> View</a>
              @elseif($item->concern_status === 'assessed')
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/scope_of_work/"
                target="_blank"><i class="fas fa-eye"></i> View</a>
              @elseif($item->concern_status === 'waiting for approval')
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/approval/"
                target="_blank"><i class="fas fa-eye"></i> View</a>
              @elseif($item->concern_status === 'request for purchase')
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/materials/"
                target="_blank"><i class="fas fa-eye"></i> View</a>
              @elseif($item->concern_status === 'approved')
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/payment-options/"
                target="_blank"><i class="fas fa-eye"></i> View</a>
              @endif
              @else
              <a href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/tenant/{{ $item->tenant_id }}/concern/{{ $item->concern_id }}/communications/"
                target="_blank"><i class="fas fa-eye"></i> View</a>
                @endif
            </td>

          </tr>
          @else

          @endif

          @endforeach
        </tbody>
      </table>

    </div>

  </div>
  @endforeach


</div>

@endsection

@section('scripts')

@endsection