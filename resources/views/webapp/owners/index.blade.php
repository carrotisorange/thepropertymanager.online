@extends('layouts.argon.main')

@section('title', 'Owners')

@section('upper-content')
<div class="row align-items-center py-4">
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
<h3 class="text-center">
  <span class=""> <small> Showing <b>{{ $owners->count() }} </b> of {{ $count_owners }}
      {{ Str::plural('owner', $count_owners) }}</span></small>
</h3>
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
{{ $owners->links() }}
@endsection