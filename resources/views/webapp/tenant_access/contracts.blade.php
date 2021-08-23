@extends('webapp.tenant_access.template')

@section('title', 'Contracts')

@section('upper-content')
<div class="col-lg-6 col-7">
  <h6 class="h2 text-dark d-inline-block mb-0">Contracts</h6>

</div>
@endsection

@section('main-content')
<div class="container-fluid mt--6">
  <div class="table-responsive text-nowrap">
    <table class="table table-bordered table-condensed">
      <?php $ctr = 1; ?>
      <thead>
        <tr>
          <th>#</th>
          <th>Room</th>
          <th>Movein </th>
          <th>Moveout at</th>
          <th>Status</th>
          <th>Rent</th>

        </tr>
      </thead>
      <tbody>
        @foreach ($rooms as $item)
        <tr>
          <th>{{ $ctr++ }}</th>
          <td>{{ $item->building.' '.$item->unit_no }}</td>
          <td>{{ $item->movein_at }}</td>
          <td>{{ $item->moveout_at }}</td>
          <td>{{ $item->contract_status }}</td>
          <td>{{ number_format($item->contract_rent,2) }}</td>
        </tr>
        @endforeach
      </tbody>

    </table>
  </div>

</div>
@endsection

@section('scripts')

@endsection