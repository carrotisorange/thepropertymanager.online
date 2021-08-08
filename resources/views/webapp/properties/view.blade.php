@extends('layouts.argon.main')

@section('title', 'Portforlio')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Dashboard</h6>
    
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
            <span class="text-white mr-2"> | </span>
            <span class="text-nowrap"></span>
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
            <span class="text-white mr-2"> | </span>
            <span class="text-nowrap"></span>
          </p>
        </div>
      </div>
    </div>
    
    
  </div>  
@endsection



@section('scripts')

@endsection

