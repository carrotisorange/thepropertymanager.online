@extends('layouts.argon.main')

@section('title', 'Rooms')

@section('upper-content')
<div class="row align-items-center py-4">

  <div class="col-lg-3 text-left">

    <h6 class="h2 text-dark d-inline-block mb-0">Rooms</h6>

  </div>
  <div class="col-md-6">
    <a href="#/" class="btn btn-sm btn-primary" style="width: 85px; height: 60px;">
      <i class="fas fa-home fa-2x"></i>
      <br>
      <small> Occupied</small>
    </a>
    <a href="#/" class="btn btn-sm btn-success" style="width: 85px; height: 60px;">
      <i class="fas fa-home fa-2x"></i>
      <br>
      <small> Vacant</small>
    </a>
    <a href="#/" class="btn btn-sm btn-warning" style="width: 85px; height: 60px;">
      <i class="fas fa-home fa-2x"></i>
      <br>
      <small> Reserved</small>
    </a>
    <a href="#/" class="btn btn-sm btn-dark" style="width: 85px; height: 60px;">
      <i class="fas fa-home fa-2x"></i>
      <br>
      <small> Maintenance</small>
    </a>
    <a href="#/" class="btn btn-sm btn-gray" style="width: 85px; height: 60px;">
      <i class="fas fa-home fa-2x"></i>
      <br>
      <small> Housekeeping</small>
    </a>
  </div>

  <div class="col-md-3 text-right">
    <a href="{{ route('create-room') }}" class="btn btn-primary"><i class="fas fa-plus fa-sm"></i> New</a>
    <a href="{{ route('edit-room') }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
  </div>

</div>
<div class="row">
  <div class="col-md-12">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
          aria-controls="nav-home" aria-selected="true"><i class="fas fa-home text-indigo"></i> All <span
            class="badge badge-primary badge-counter">{{ $rooms->count() }}</span></a>
        @foreach ($buildings as $building)
        <a class="nav-item nav-link" id="nav-{{ $building->building }}-tab" data-toggle="tab"
          href="#nav-{{ $building->building }}" role="tab" aria-controls="nav-{{ $building->building }}"
          aria-selected="false"><i class="fas fa-building text-indigo"></i> {{ $building->building }} <span
            class="badge badge-primary badge-counter">{{ $building->count }}</span></a>
        @endforeach
      </div>
    </nav>
    <div class="col-md-12 mx-auto">
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
          <br>
          <div class="row text-center">
            @each('webapp.rooms.includes.rooms', $rooms,  'room', 'webapp.tenants.includes.no-record')
          </div>
        </div>
        @forelse ($buildings as $building)
          @include('webapp.rooms.includes.buildings', ['building' => $building])
        @empty
          @include('webapp.tenants.includes.no-record')
        @endforelse
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="upgradeToPro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upgrade to PRO</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-center">
          The current plan you have reached the limit of rooms that you are allowed to add.
        </p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Dismiss</button>
      </div>
    </div>
  </div>
</div>
@endsection
