@extends('layouts.argon.main')

@section('title', 'Collections')

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
    <h6 class="h2 text-dark d-inline-block mb-0">Collections</h6>
  </div>
  <div class="col-lg-6 col-5 text-right">
    <form action="/property/{{ Session::get('property_id') }}/payments/search" method="GET">
      @csrf
      <div class="input-group">
        <input type="date" class="form-control" name="search" required>
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit">
            <i class="fas fa-search fa-sm"></i>
          </button>
        </div>
      </div>
    </form </div> </div> </div> <small> Showing <b>{{ number_format($collections->count(), 0) }}</b>collections...</small>
    <div class="row" style="overflow-y:scroll;overflow-x:scroll;height:500px;">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Date</th>
            <th>AR No</th>
            <th>Bill No</th>
            <th>Tenant</th>
            <th>Room</th>
            <th>Mode of Payment</th>
            <th>Amount</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @each('webapp.collections.includes.collections', $collections, 'collection', 'webapp.tenants.includes.no-record')
        </tbody>
      </table>
    </div>
    @endsection

    @section('scripts')

    @endsection