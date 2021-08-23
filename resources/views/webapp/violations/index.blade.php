@extends('layouts.argon.main')

@section('title', 'Violations')

@section('css')

@endsection

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 text-left">
    <h6 class="h2 text-dark d-inline-block mb-0">Violations</h6>
  </div>

</div>

<div style="overflow-y:scroll;overflow-x:scroll;">
  <div class="row">
    <div class="col-md-12">
      <table class="table table-hover">
        <?php $violation_ctr = 1; ?>
        <thead>
          <tr>
            <th>#</th>
            <th>Date committed</th>
            <th>Tenant</th>
            <th>Room</th>
            <th>Category</th>
            <th>Frequency</th>
            <th>Severity</th>
            <th>Status</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($violations as $item)
          <tr>
            <th>{{ $violation_ctr++ }}</th>
            <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d Y') }}</td>
            <td><a
                href="/property/{{ Session::get('property_id') }}/tenant/{{ $item->tenant_id }}#violations">{{ $item->first_name.' '.$item->last_name }}</a>
            </td>
            <td><a
                href="/property/{{ Session::get('property_id') }}/room/{{ $item->unit_id }}#violations">{{ $item->building.' '.$item->unit_no }}</a>
            </td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->frequency }}</td>
            <td>{{ $item->severity }}</td>
            <td>
              @if($item->status === 'received')
              <i class="fas fa-clock text-warning"></i> {{ $item->status }}
              @elseif($item->status === 'pending')
              <i class="fas fa-snowboarding text-primary"></i> {{ $item->status }}
              @else
              <i class="fas fa-check-circle text-success"></i> {{ $item->status }}
              @endif
            </td>

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