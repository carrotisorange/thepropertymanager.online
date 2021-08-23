@extends('layouts.argon.main')

@section('title', 'Housekeeping')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Housekeeping</h1>
  <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false"
    aria-controls=""> <i class="fas fa-user-plus  fa-sm text-white-50"></i> Add Housekeeping</a>

</div>

<div class="row">
  <div class="col">
    <div class="collapse multi-collapse" id="multiCollapseExample1">
      <div class="card card-body">
        <form id="addPersonnelForm" action="/personnels" method="POST">
          {{ csrf_field() }}
        </form>
        <div class="row">
          <div class="col">
            <label for="recipient-name" class="col-form-label"><b>Name</b></label>
            <input form="addPersonnelForm" type="text" class="form-control" name="personnel_name" required>
            <input form="addPersonnelForm" type="hidden" class="form-control" name="personnel_type" value="housekeeping"
              required>
          </div>
          <div class="col">
            <label for="recipient-name" class="col-form-label"><b>Contact No</b></label>
            <input form="addPersonnelForm" type="text" class="form-control" name="personnel_contact_no" required>
          </div>

        </div>
        <br>
        <p class="text-right">
          <button class="btn btn-primary" type="submit" form="addPersonnelForm"
            onclick="return confirm('Are you sure you want perform this action?');"><i
              class="fas fa-check fa-sm text-white-50"></i> Add Housekeeping</button>
        </p>

      </div>
    </div>
  </div>
</div>
<br>
<div class="table-responsive text-nowrap">

  <table class="table table-striped" table-bordered" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th>ID</th>
        <th>PERSONNEL</th>
        <th>CONTACT NO</th>
        <th>AVAILABILITY</th>
        <th>PERSONNEL TYPE</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($housekeeping as $item)
      <tr>
        <td>{{ $item->personnel_id }}</td>
        <td>{{ $item->personnel_name }}</td>
        <td>{{ $item->personnel_contact_no }}</td>
        <td>{{ $item->personnel_availability }}</td>
        <td>{{ $item->personnel_type }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

</div>
@endsection

@section('scripts')

@endsection