@extends('layouts.argon.main')

@section('title', 'Delinquents')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Watchout for delinquents ({{ $delinquents->count() }})...</h6>

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
            <th>Tenant</th>
            <th>Room</th>

            <th>Status</th>
            <th>Mobile</th>
            <th>Balance</th>
          </tr>
        </thead>
        <tbody>
          @foreach($delinquents as $item)
          <tr>
            <th>{{ $ctr++ }}</th>
            <td>
              <a href="/property/{{ Session::get('property_id') }}/tenant/{{ $item->tenant_id }}#bills">{{ $item->first_name.' '.$item->last_name }}
            </td>
            <td>
              @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1 )
              <a
                href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id   }}">{{$item->building.' '.$item->unit_no }}</a>
              @else
              {{ $item->unit_no }}
              @endif
            </td>

            <td>
              @if($item->contract_status === 'active')
              <span class="text-success"><i class="fas fa-check-circle"></i> {{ $item->contract_status }}</span>
              @else
              <span class="text-warning"><i class="fas fa-clock"></i> {{ $item->contract_status }}</span>

              @endif
            </td>
            <td>{{ $item->contact_no }}</td>
            <td>
              <a>{{ number_format($item->balance,2) }}
            </td>
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