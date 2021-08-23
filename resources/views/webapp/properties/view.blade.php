@extends('layouts.argon.main')

@section('title', Session::get('property_name'))

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">{{ Session::get('property_name') }}</h6>

  </div>

</div>
<!-- Card stats -->
<div class="row">
  <div class="col">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">rooms</h5>
            <span class="h2 font-weight-bold mb-0">{{ number_format($rooms->count(),0) }}</span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
              <i class="fas fa-home"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-sm">
          @foreach ($rooms as $item)
          <span class="text-dark mr-2"><i class="fas fa-check-circle text-green"></i>
            {{ $item->building.' - '.$item->unit_no.' ('.$item->status.')' }}</span>
          <br>
          @endforeach

        </p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">tenants</h5>
            <span class="h2 font-weight-bold mb-0">{{ number_format($tenants->count(),0) }}</span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
              <i class="fas fa-user-tie"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-sm">
          @foreach ($tenants as $item)
          <span class="text-dark mr-2"><i class="fas fa-check-circle text-green"></i>
            {{ $item->first_name.' '.$item->last_name }}</span>
          <br>
          @endforeach
        </p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">users</h5>
            <span class="h2 font-weight-bold mb-0">{{ number_format($users->count(),0) }}</span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
              <i class="fas fa-user-tie"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-sm">
          @foreach ($users as $item)
          <span class="text-dark mr-2"><i class="fas fa-check-circle text-green"></i>
            {{ $item->role.' - '.$item->email }}</span>
          <br>
          @endforeach
        </p>
      </div>
    </div>
  </div>

</div>
@endsection



@section('scripts')

@endsection