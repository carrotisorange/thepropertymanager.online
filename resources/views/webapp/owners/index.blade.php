@extends('layouts.argon.main')

@section('title', 'Owners')

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
  {{-- <div class="col-md-3">
   <form action="/property/{{ Session::get('property_id') }}/tenants/filter" method="GET" onchange="submit();">
  <select class="form-control" name="tenant_status" id="">
    <option value="">All tenants</option>
    @foreach ($tenant_status as $item)
    <option value="{{ $item->status }}">{{ $item->status }} tenants only</option>
    @endforeach
  </select>

  </form>
</div> --}}
<div class="col text-right">
  <form action="/property/{{Session::get('property_id')}}/owners/search" method="GET">
    @csrf
    <div class="input-group">
      <input type="text" class="form-control" name="owner_search" placeholder="enter name..."
        value="{{ Session::get('owner_search') }}">
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit">
          <i class="fas fa-search fa-sm"></i>
        </button>
      </div>
    </div>
  </form>
</div>
</div>

  <span class=""> <small> Showing <b>{{ $owners->count() }} </b> of {{ $count_owners }}
      {{ Str::plural('owner', $count_owners) }}</span></small>

  <div style="overflow-y:scroll;overflow-x:scroll;height:450px;">
    <table class="table table-hover">
      <thead>
        <tr>
         
          <th>Name</th>
          <th>Email</th>
          <th>Mobile</th>
          <th>Address</th>
          <th>Representative</th>
        </tr>
      </thead>
      <tbody>
        @each('webapp.owners.includes.owners', $owners, 'owner', 'webapp.tenants.includes.no-record')
      </tbody>
    </table>

  </div>
  @endsection



  @section('scripts')

  @endsection