@extends('layouts.argon.main')

@section('title', 'Usage History')

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

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Usage History</h6>
  </div>
</div>
<div class="table-responsive text-nowrap" style="overflow-y:scroll;overflow-x:scroll;height:450px;">
  <table class="table table-hover">
    <?php $ctr = 1; ?>
    <thead>
      <tr>
    
        <th>Name</th>
        <th>Role</th>

        <th>IP Address</th>
        <th>Login at</th>
        <th>Logout at</th>
        <th>Usage time</th>

      </tr>
    </thead>
    <tbody>
      @each('webapp.users.includes.users', $sessions, 'item', 'webapp.tenants.includes.no-record')
    </tbody>
  </table>

</div>
@endsection

@section('scripts')

@endsection