@extends('webapp.owner_access.template')

@section('title', 'Contracts')

@section('upper-content')
<div class="col-lg-6 col-7">
  <h6 class="h2 text-dark d-inline-block mb-0">Contracts in <b>{{ $room->building.' '.$room->unit_no }}</b></h6>

</div>
@endsection

@section('main-content')
<div class="container-fluid mt--6">
  <div class="table-responsive text-nowrap">
    <table class="table">
      <?php $ctr = 1; ?>
      <thead>
        <tr>
          <th>#</th>
          <th>Contract ID</th>
          <th>Started on</th>
          <th>Ended on</th>
          <th>Status</th>
          <th>Rent</th>
          <th>Moveout</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($contracts as $item)
        <tr>
          <th>{{ $ctr++ }}</th>
          <td>{{ $item->contract_id }}</td>
          <td>{{ Carbon\Carbon::parse($item->movein_at)->format('M d, Y') }}</td>
          <td>{{ Carbon\Carbon::parse($item->moveout_at)->format('M d, Y') }}</td>
          <td>{{ $item->status }}</td>
          <td>{{ number_format($item->rent,2) }}</td>
          <td>{{ $item->moveout_reason? $item->moveout_reason: 'NA' }}</td>
        </tr>
        @endforeach
      </tbody>

    </table>
  </div>

</div>
@endsection

@section('scripts')

@endsection