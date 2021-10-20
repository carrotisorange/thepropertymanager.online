@extends('webapp.owner_access.template')

@section('title', 'Contracts')

@section('upper-content')
<div class="col-lg-6 col-7">
  <h6 class="h2 text-dark d-inline-block mb-0">Contracts in <b>{{ $room->building.' '.$room->unit_no }}</b></h6>
<a title="Edit this property." href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/room/{{ $room->unit_id }}/room/edit"><i class="fas fa-edit"></i></a>
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
          <th>Starts on</th>
          <th>Ends on</th>
          <th>Term</th>
          <th>Status</th>
          <th>Rent (/month)</th>
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
          <td>{{ $item->term }}</td>
          <td>@if($item->status === 'active')
          <span class="text-success"><i class="fas fa-check "></i> {{ $item->status }}</span>
          @elseif($item->status === 'pending')
          <span class="text-warning"><i class="fas fa-hand-paper "></i> {{ $item->status }}</span>
          @else
          <span class="text-danger"><i class="fas fa-times "></i> {{ $item->status }}</span>
          @endif</td>
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