@extends('layouts.argon.main')

@section('title', 'Employees and Personnels')

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
    <h6 class="h2 text-dark d-inline-block mb-0">Employees and Personnels</h6>

  </div>
  <div class="col-lg-6 col-5 text-right">
    <a href="#" data-toggle="modal" data-target="#addPersonnelModal" class="btn btn-primary"><i
        class="fas fa-plus "></i> New</a>
  </div>


</div>
@if($employees->count() <=0 ) <p class="text-danger text-center">No employees and personnels found!</p>

  @else


  <div style="overflow-y:scroll;overflow-x:scroll;height:450px;">

    <table class="table table-hover">
      <thead>
        <?php $ctr=1;?>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Role</th>
          <th>Email</th>
          <th>Added on</th>

        </tr>
      </thead>
      <tbody>
        @foreach ($employees as $item)
        <tr>
          <th>{{ $ctr++ }}</th>
          <td>{{ $item->name }}</td>
          <td>{{ $item->role_id_foreign }}</td>
          <td>{{ $item->email }}</td>

          <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
          {{-- <td class="text-center">
          @if(Auth::user()->role_id_foreign === 4)
          <form action="/property/{{Session::get('property_id')}}/personnel/{{ $item->personnel_id }}" method="POST">
          @csrf
          @method('delete')
          <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"
            onclick="return confirm('Are you sure you want perform this action?');"><i
              class="fas fa-trash-alt fa-sm text-white-50"></i></button>
          </form>
          @endif
          </td> --}}
        </tr>
        @endforeach
        @foreach ($personnels as $item)
        <tr>
          <th>{{ $ctr++ }}</th>
          <td>{{ $item->personnel_name }}</td>
          <td>{{ $item->personnel_type }}</td>
          <td>NA</td>

          <td>{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
          {{-- <td class="text-center">
          @if(Auth::user()->role_id_foreign === 4)
          <form action="/property/{{Session::get('property_id')}}/personnel/{{ $item->personnel_id }}" method="POST">
          @csrf
          @method('delete')
          <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"
            onclick="return confirm('Are you sure you want perform this action?');"><i
              class="fas fa-trash-alt fa-sm text-white-50"></i></button>
          </form>
          @endif
          </td> --}}
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
  @endif

  {{-- Modal to moveout tenant --}}
  <div class="modal fade" id="addPersonnelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Personnel Information</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addPersonnelForm" action="/property/{{Session::get('property_id')}}/personnel" method="POST">
            @csrf
          </form>
          <input type="hidden" form="addPersonnelForm" name="property_id" value="{{Session::get('property_id')}}"
            required>
          <div class="row">
            <div class="col">
              <label>Name</label>
              <input type="text" form="addPersonnelForm" class="form-control" name="personnel_name" required>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <label>Mobile</label>
              <input form="addPersonnelForm" type="number" class="form-control" name="personnel_contact_no" required>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <label>Role</label>
              <select class="form-control" form="addPersonnelForm" name="personnel_type" id="" required>
                <option value="" selected>Please select one</option>
                <option value="housekeeping">housekeeping</option>
                <option value="maintenance">maintenance</option>
              </select>
            </div>
          </div>


        </div>
        <div class="modal-footer">

         <button type="submit" form="addPersonnelForm" class="btn-block btn btn-primary"><i
                class="fas fa-check"></i> Submit</button>
        </div>
      </div>
    </div>
  </div>

  @endsection



  @section('scripts')

  @endsection