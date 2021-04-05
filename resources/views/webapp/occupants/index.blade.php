@extends('layouts.argon.main')

@section('title', 'Occupants')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Occupants</h6>
    
  </div>
  <div class="col-lg-6 col-5 text-right">
    <form  action="/property/{{Session::get('property_id')}}/occupants/search" method="GET" >
      @csrf
      <div class="input-group">
          <input type="text" class="form-control" name="tenant_search" placeholder="Enter name..." >
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
              <i class="fas fa-search fa-sm"></i>
            </button>
          </div>
      </div>
  </form>
  </div>

</div>

@if($tenants->count() <=0 )
<p class="text-danger text-center">No occupants found!</p>

@else
Showing <b>{{ $tenants->count() }} </b> of {{ $count_tenants }} occupants
@if(Session::get('tenant_search'))
<p class="text-center"> <span class=""> <small> you searched for </small></span> <span class="text-danger">{{ Session::get('tenant_search') }}"<span></p>
@endif


<div style="overflow-y:scroll;overflow-x:scroll;height:450px;">
    <table class="table table-condensed table-bordered table-hover">
      <thead>
        <?php $ctr=1;?>
        <tr>
          <th>#</th>
          <th>Profile</th>
          <th>Tenant ID</th>
          {{-- <th>Room</th> --}}
          <th>Tenant</th>
          {{-- <th>User ID</th> --}}
          <th>Mobile</th>
          {{-- <th>Email</th> --}}
          <th>Resided</th>
       </tr>
      </thead>
      <tbody>
        @foreach ($tenants as $item)
        <tr>
          <th>{{ $ctr++ }}</th>
          <td>  <span class="avatar avatar-sm rounded-circle">
            <img alt="Image placeholder"  src="{{ $item->tenant_img? asset('/storage/img/tenants/'.$item->tenant_img): asset('/arsha/assets/img/no-image.png') }}">
          </span></td>
          <td>{{ $item->tenant_unique_id }}</td>
          {{-- <td>{{ $item->building.' '.$item->unit_no }}</td> --}}
          <th>
            {{-- @if($item->user_id_foreign == null) --}}
            <a href="/property/{{Session::get('property_id')}}/occupant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}</a>
            {{-- @else
            <a  href="/asa/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}
            @endif --}}
          </th>
          {{-- <td>{{ $item->user_id_foreign }} </td> --}}
            <td>{{ $item->contact_no }}</td>
            {{-- <td>{{ $item->email_address }}</td> --}}
            <td>{{ Carbon\Carbon::parse($item->movein_at)->format('M d, Y') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
@endif
@endsection



@section('scripts')
  
@endsection



