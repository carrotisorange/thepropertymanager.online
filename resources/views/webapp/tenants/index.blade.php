@extends('layouts.argon.main')

@section('title', 'Tenants')

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
  <div class="col-md-3">
    <form action="/property/{{ Session::get('property_id') }}/tenants/filter" method="GET" onchange="submit();">
      <select class="form-control" name="tenant_status" id="">
        <option value="all">All tenants</option>
        @foreach ($tenant_status as $item)
        <option value="{{ $item->status }}">{{ $item->status }} tenants only</option>
        @endforeach
      </select>

    </form>
  </div>
  <div class="col text-right">
    <form action="/property/{{Session::get('property_id')}}/tenants/search" method="GET">
      @csrf
      <div class="input-group">
        <input type="text" class="form-control" name="tenant_search" placeholder="enter name..."
          value="{{ Session::get('tenant_search') }}">
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit">
            <i class="fas fa-search fa-sm"></i>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

@if($tenants->count() <=0 ) <p class="text-danger text-center">No tenants found!</p>

  @else

  {{-- @if(Session::get('tenant_search'))
  <p class="text-center"> <span class=""> <small> You searched for </small></span> <span class="text-danger">{{
      Session::get('tenant_search') }}"<span>
  </p>
  @endif --}}

  <span class=""> <small> Showing <b>{{ $tenants->count() }} </b> of {{ $count_tenants }}
      {{ Str::plural('tenant', $count_tenants) }} </span></small>



  <div style="overflow-y:scroll;overflow-x:scroll;height:450px;">
    <table class="table table-hover">
      <?php $ctr=1;?>
      <thead>
        <tr>
          <th>#</th>
          <th>Profile</th>
          {{-- <th>Tenant ID</th> --}}

          <th>Name</th>
          <th>Room</th>
          <th>Status</th>
          <th>Movein</th>
          <th>Moveout</th>
          <th>Mobile</th>

          {{-- <th>Email</th> --}}
          <th>Type</th>
          <th>Gender</th>
          <th>Civil status</th>
          {{-- <th>Movein </th> --}}
        </tr>
      </thead>
      <tbody>
        @foreach ($tenants as $item)
        <tr>
          <th>{{ $ctr++ }}</th>
          <td> <span class="avatar avatar-sm rounded-circle">
              <img alt="Image placeholder"
                src="{{ $item->tenant_img? asset('/storage/img/tenants/'.$item->tenant_img): asset('/arsha/assets/img/no-image.png') }}">
            </span>
          </td>
          <th><a
              href="{{ url('property/'.Session::get('property_id'), ['tenant', 'tenant_id'=>$item->tenant_id]) }}">{{$item->first_name.'
              '.$item->last_name }}</a></th>
          <th><a
              href="{{ url('property/'.Session::get('property_id'), ['room', 'room_id'=>$item->unit_id]) }}">{{$item->building.'
              '.$item->unit_no }}</a></th>
          <td>
            @if($item->contract_status === 'active')
            <span class="text-success"><i class="fas fa-check"></i> {{ $item->contract_status }}</span>
            @elseif($item->contract_status === 'pending')
            <span class="text-warning"><i class="fas fa-clock"></i> {{ $item->contract_status }}</span>
            @elseif($item->contract_status === 'inactive')
            <span class="text-danger"><i class="fas fa-times"></i> {{ $item->contract_status }}</span>
            @endif
          </td>
          <td>{{ Carbon\Carbon::parse($item->movein_at)->format('M d, Y') }}</td>
          <td>{{ Carbon\Carbon::parse($item->moveout_at)->format('M d, Y') }}</td>
          <td>{{ $item->contact_no }}</td>
          {{-- <td>{{ $item->email_address }}</td> --}}
          <td>{{ $item->type_of_tenant }}</td>
          <td>{{ $item->gender }}</td>
          <td>{{ $item->civil_status }}</td>

        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
  @endif
  @endsection



  @section('scripts')

  @endsection