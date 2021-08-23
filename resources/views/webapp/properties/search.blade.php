@extends('layouts.argon.main')

@section('title', 'Results for ' .'"'.$search_key.'"')

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
    <h6 class="h2 text-dark d-inline-block mb-0"><span class=""> <small> You searched for </small></span> <span
        class="text-danger">"{{ $search_key }}"<span></h6>
  </div>

</div>
<div class="row" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
  <div class="col-md-12">
    <p><span class="font-weight-bold">{{ $tenants->count() }}</span> matched for tenants...</p>
    @if($tenants->count() >= 1 )
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Tenant</th>
          <th>Email</th>
          <th>Mobile</th>

          <th>Contract</th>
          <th></th>

        </tr>
      </thead>
      <?php $tenant_ctr=1;?>
      @foreach ($tenants as $tenant)
      <tr>
        <th>{{ $tenant_ctr++ }}</th>
        <th><a
            href="/property/{{Session::get('property_id')}}/tenant/{{ $tenant->tenant_id }}">{{ $tenant->first_name.' '.$tenant->middle_name.' '.$tenant->last_name }}</a>
        </th>
        <th>{{ $tenant->email }}</th>
        <td>{{ $tenant->contact_no }}</td>
        <td>{{ Carbon\Carbon::parse($tenant->created_at)->format('M d, Y') }}</td>

      </tr>
      @endforeach

    </table>
    @endif
    <br>

    <p><span class="font-weight-bold">{{ $units->count() }}</span> matched for rooms...</p>
    @if($units->count() >= 1 )
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>

          <th>Room</th>
          <th>Floor</th>
          <th>Type</th>

          <th>Status</th>
          <th>Occupancy</th>
          <th>Rent</th>
        </tr>
      </thead>
      <?php $unit_ctr=1;?>
      <?php $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL) ?>
      @foreach ($units as $unit)
      <tr>
        <th>{{ $unit_ctr++ }}</th>
        <th>
          @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
          Session::get('property_type') === '6' || Session::get('property_type') === 1 || Session::get('property_type')
          === '6'){
          <a
            href="/property/{{Session::get('property_id')}}/unit/{{ $unit->unit_id }}">{{ $unit->building.' '.$unit->unit_no }}</a>
          @else
          <a
            href="/property/{{Session::get('property_id')}}/room/{{ $unit->unit_id }}">{{ $unit->building.' '.$unit->unit_no }}</a>
          @endif
        </th>
        <td>
          @if($unit->unit_floor_id_foreign>=0)
          {{ $numberFormatter->format($unit->unit_floor_id_foreign) }} floor
          @else
          {{ $numberFormatter->format(intval($unit->unit_floor_id_foreign)*-1) }} basement</option>
          @endif
        </td>
        <td>{{ $unit->type }}</td>
        <td>{{ $unit->status }}</td>
        <td>{{ $unit->occupancy }} <b>pax</b></td>
        <td>{{ number_format($unit->rent, 2) }}</td>
      </tr>
      @endforeach
    </table>
    @endif
    <br>

    <p><span class="font-weight-bold">{{ $owners->count() }}</span> matched for owners...</p>
    @if($owners->count() >= 1 )
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>

          <th>Email</th>
          <th>Mobile</th>
          <th>Representative</th>


        </tr>
      </thead>
      <?php $owner_ctr=1;?>
      @foreach ($owners as $owner)
      <tr>
        <th>{{ $owner_ctr++ }}</th>
        <th><a href="/property/{{Session::get('property_id')}}/owner/{{ $owner->owner_id }}">{{ $owner->name }} </a>
        </th>

        <td>{{ $owner->email}}</td>
        <td>{{ $owner->mobile }}</td>
        <td>{{ $owner->representative }}</td>




      </tr>
      @endforeach

    </table>
    @endif
  </div>


</div>

@endsection

@section('main-content')

@endsection

@section('scripts')

@endsection