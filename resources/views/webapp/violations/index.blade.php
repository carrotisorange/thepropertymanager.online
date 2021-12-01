@extends('layouts.argon.main')

@section('title', 'Violations')

@section('css')

@endsection

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 text-left">
    <h6 class="h2 text-dark d-inline-block mb-0">Violations</h6>
  </div>

</div>

<div style="overflow-y:scroll;overflow-x:scroll;">
  <div class="row">
    <div class="col-md-12">
      <table class="table table-hover">

        <thead>
          <tr>
            <th>#</th>
            <th>Date committed</th>
            <th>Tenant</th>
            <th>Room</th>
            <th>Category</th>
            <th>Frequency</th>
            <th>Severity</th>
            <th>Status</th>

          </tr>
        </thead>
        <tbody>
          @each('webapp.violations.includes.violations', $violations, 'violation', 'webapp.tenants.includes.no-record')
        </tbody>
      </table>
    </div>
  </div>

</div>

@endsection



@section('scripts')

@endsection