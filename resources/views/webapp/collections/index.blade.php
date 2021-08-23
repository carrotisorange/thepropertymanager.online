@extends('layouts.argon.main')

@section('title', 'Collections')

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
    <h6 class="h2 text-dark d-inline-block mb-0">Collections</h6>

  </div>

  <div class="col-lg-6 col-5 text-right">
    <form action="/property/{{ Session::get('property_id') }}/payments/search" method="GET">
      @csrf
      <div class="input-group">
        <input type="date" class="form-control" name="search" required>
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit">
            <i class="fas fa-search fa-sm"></i>
          </button>
        </div>
      </div>
    </form </div> </div> </div> <small> Showing <b>{{ number_format($collections->count(), 0) }}</b>
    collections...</small>

    <div class="row" style="overflow-y:scroll;overflow-x:scroll;height:500px;">
      <?php $ctr = 1;?>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>AR No</th>
            <th>Bill No</th>
            <th>Tenant</th>
            <th>Room</th>
            <th>Mode of Payment</th>
            <th>Amount</th>
            <th></th>

          </tr>
        </thead>
        <tbody>
          @foreach ($collections as $item)
          <tr>
            <th>{{ $ctr++ }}</th>
            <td>{{ Carbon\Carbon::parse($item->payment_created)->format('M d, Y') }}</td>
            <td>

              {{ $item->ar_no }}

            </td>
            <td>{{ $item->payment_bill_no }}</td>



            <td>
              @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
              Session::get('property_type') === '6' || Session::get('property_type') === 1 ||
              Session::get('property_type') === '6')
              <a
                href="/property/{{Session::get('property_id')}}/occupant/{{ $item->tenant_id }}#payments">{{ $item->first_name.' '.$item->last_name }}</a>
              @else
              <a
                href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}#payments">{{ $item->first_name.' '.$item->last_name }}</a>
              @endif

            </td>

            <td>
              @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
              Session::get('property_type') === '6' || Session::get('property_type') === 1 ||
              Session::get('property_type') === '6')
              <a
                href="/property/{{Session::get('property_id')}}/unit/{{ $item->unit_id }}#payments">{{  $item->building.' '.$item->unit_no }}</a>
              @else
              <a
                href="/property/{{Session::get('property_id')}}/room/{{ $item->unit_id }}#payments">{{  $item->building.' '.$item->unit_no }}</a>
              @endif

            </td>

            <td>{{ $item->form }}</td>

            <td>
              @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 2 ||
              Auth::user()->role_id_foreign === 1)
              <a
                href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}/contract/{{ $item->contract_id }}/tenant/{{ $item->tenant_id }}/bill/{{ $item->bill_id }}/payment/{{ $item->payment_id }}/remittance/create">{{ number_format($item->amt_paid,2) }}</a>
              @else
              {{ number_format($item->amt_paid,2) }}
              @endif
            </td>
            <td><a class="text-danger" href="/payment/{{ $item->payment_id }}/delete/payment"><i
                  class="fas fa-times"></i> Remove</a></td>

          </tr>


          @endforeach
        </tbody>
      </table>
    </div>
    {{-- @endif --}}
    @endsection

    @section('scripts')

    @endsection