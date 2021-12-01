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
<div class="tab-content" id="nav-tabContent">
  <br>
  <div class="tab-pane fade show active" id="nav-all-tab" role="tabpanel" aria-labelledby="nav-all-tab">
    <div style="overflow-y:scroll;overflow-x:scroll;height:450px;">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Reported on</th>
            <th>Reported by</th>
            <th>Category</th>
            <th>Room</th>
            <th>Urgency</th>
            <th>Status</th>
            <th>Endorsed to</th>
            <th colspan="2" class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @each('webapp.concerns.includes.concerns', $concerns, 'concern', 'webapp.tenants.includes.no-record')
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
            <th>Reported on</th>
            <th>Reported by</th>
            <th>Category</th>
            <th>Room</th>
            <th>Urgency</th>
            <th>Status</th>
            <th>Endorsed to</th>
           <th colspan="2" class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @each('webapp.concerns.includes.concerns', $concerns, 'concern', 'webapp.tenants.includes.no-record')
        </tbody>
      </table>
    </div>
  </div>
  @endforeach
  @foreach ($category as $category)
  <div class="tab-pane fade" id="nav-{{ $category->category }}-tab" role="tabpanel" aria-labelledby="nav-{{ $category->category }}-tab">
    <div style="overflow-y:scroll;overflow-x:scroll;height:450px;">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Reported on</th>
            <th>Reported by</th>
            <th>Category</th>
            <th>Room</th>
            <th>Urgency</th>
            <th>Status</th>
            <th>Endorsed to</th>
            <th colspan="2" class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
         @each('webapp.concerns.includes.concerns', $concerns, 'concern', 'webapp.tenants.includes.no-record')
        </tbody>
      </table>
    </div>
  </div>
  @endforeach
</div>
@endsection
