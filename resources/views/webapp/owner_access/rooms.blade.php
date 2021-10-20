@extends('webapp.owner_access.template')

@section('title', 'Rooms')

@section('upper-content')
<div class="col-lg-6 col-7">
  <h6 class="h2 text-dark d-inline-block mb-0">Rooms</h6>

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
          <th>Enrollment Date</th>
          <th>Building</th>
          <th>Room</th>

          <th>Status</th>
          <th>Rent(/month)</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($rooms as $item)
        <tr>
          <th>{{ $ctr++ }}</th>
          <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
          <td>{{ $item->building }}</td>
          <td>{{$item->unit_no }}</td>

          <td>
            @if($item->status === 'occupied')
            <span class="text-success"><i class="fas fa-check "></i> {{ $item->status }}</span>
            @elseif($item->status === 'reserved')
            <span class="text-warning"><i class="fas fa-hand-paper "></i> {{ $item->status }}</span>
            @else
            <span class="text-danger"><i class="fas fa-times "></i> {{ $item->status }}</span>
            @endif

          </td>
          <td>{{ number_format($item->rent,2) }}</td>
          <th><a href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/room/{{ $item->unit_id }}/contracts"><i class="fas fa-eye"></i> View</a></th>
        </tr>
        @endforeach
      </tbody>

    </table>
  </div>

</div>
@endsection

@section('scripts')

@endsection