@extends('layouts.argon.main')

@section('title', 'Tenants')

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-md-3">
    <form action="/property/{{ Session::get('property_id') }}/tenants/filter" method="GET" onchange="submit();">
      <select class="form-control" name="tenant_status" id="">
        <option value="">all tenants</option>
        @foreach ($tenant_status as $item)
        <option value="{{ $item->status }}">{{ $item->status }} tenants</option>
        @endforeach
      </select>
    </form>
  </div>
  <div class="col-md-6">
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
  <div class="col-auto">
    <a href="/property/{{ Session::get('property_id') }}/tenants" class="btn btn-primary"><i class="fas fa-eraser"></i>
          Clear</a>
  </div>
</div>
  <h3 class="text-center">
    <span class=""> <small> Showing <b>{{ $tenants->count() }} </b> of {{ $count_tenants }}
          {{ Str::plural('tenant', $count_tenants) }} </span></small>
    </h3>
 
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Profile</th>
          <th>Name</th>
          <th>Room</th>
          <th>Status</th>
          <th>Movein</th>
          <th>Moveout</th>
          <th>Mobile</th>
          <th>Type</th>
          <th>Gender</th>
          <th>Civil status</th>
        </tr>
      </thead>
      <tbody>
          @each('webapp.tenants.includes.tenants', $tenants, 'tenant', 'webapp.tenants.includes.no-record')
      </tbody>
      
    </table>
{{ $tenants->links() }}
  @endsection