@extends('layouts.argon.main')

@section('title', 'Tenants')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Tenants</h6>
    
  </div>
  <div class="col-lg-6 col-5 text-right">
    <form  action="/property/{{Session::get('property_id')}}/tenants/search" method="GET" >
      @csrf
      <div class="input-group">
          <input type="text" class="form-control" name="tenant_search" placeholder="Enter name..." value="{{ Session::get('tenant_search') }}">
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
<p class="text-danger text-center">No tenants found!</p>

@else
Showing <b>{{ $tenants->count() }} </b> of {{ $count_tenants }} tenants
@if(Session::get('tenant_search'))
<p class="text-center"> <span class=""> <small> you searched for </small></span> <span class="text-danger">{{ Session::get('tenant_search') }}"<span></p>
@endif


<div class="table">
    <table class="table">
      <?php $ctr=1;?>
      <thead>
        <tr>
          <th>#</th>
          <th>Profile</th>
          <th>Tenant ID</th>
        
          <th>Name</th>
      
          <th>Mobile</th>
         
          <th>Email</th>
          <th>Type</th>
          <th>Gender</th>
          <th>Civil status</th>
          <th>Movein </th>
       </tr>
      </thead>
      <tbody>
        @foreach ($tenants as $item)
        <tr>
            <th>{{ $ctr++ }}</th>
            <td>  <span class="avatar avatar-sm rounded-circle">
              <img alt="Image placeholder"  src="{{ $item->tenant_img? asset('/storage/img/tenants/'.$item->tenant_img): asset('/arsha/assets/img/no-image.png') }}">
              </span>
            </td>
            <td>{{ $item->tenant_unique_id }}</td>
            <th><a href="/property/{{Session::get('property_id')}}/tenant/{{ $item->tenant_id }}">{{ $item->first_name.' '.$item->last_name }}</a></th>
            <td>{{ $item->contact_no }}</td>
            <td>{{ $item->email_address }}</td>
            <td>{{ $item->type_of_tenant }}</td>
            <td>{{ $item->gender }}</td>
            <td>{{ $item->civil_status }}</td>
            <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
@endif
@endsection



@section('scripts')
  
@endsection



