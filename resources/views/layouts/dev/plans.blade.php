@extends('layouts.material.template')

@section('title', 'Plans')
@section('content')
<div class="content">
  <div class="container-fluid">
         
      <div class="col-lg-12 col-md-12">
        <a href="#" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addPlan" data-whatever="@mdo"><i class="fas fa-plus fa-sm text-white-50"></i> Add</a>
        <div class="card">
       
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-primary">
                
                <th>Plan</th>
                <th>Price/month</th>
                <th>Price/year</th>
                <th>Room limit</th>
                <th>User limit</th>
                <th>Property limit</th>
                <th>Trial expired in</th>
         
              </thead>
              <tbody>
                @foreach ($plans as $item)
                <tr>
               
                  <td>{{ $item->plan }}</td>
                  <td>{{ number_format($item->price_per_month, 2) }}</td>
                  <td>{{ number_format($item->price_per_year, 2) }}</td>
                  <td>{{ $item->room_limit }}</td>
                  <td>{{ $item->user_limit }}</td>
                  <td>{{ $item->property_limit }}</td>
                  <td>{{ $item->trial_expired_at }} <b>days</b> </td>
                
                  
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>

  
<div class="modal fade" id="addPlan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel" >Plan Information</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
          <form id="addPlanForm" action="/plan" method="POST">
              @csrf
          </form>

          <div class="form-group">
              <label>Plan</label>
              <input form="addPlanForm" type="text" class="form-control" name="plan" required>
              
          </div>

          <div class="form-group">
              <label>Prince/month</label>
              <input form="addPlanForm" type="number" step="0.01" class="form-control" name="price_per_month" required>
              
          </div>

          <div class="form-group">
              <label>Price/year</label>
              <input form="addPlanForm" type="number" step="0.01" class="form-control" name="price_per_year" required>
              
          </div>

          
          <div class="form-group">
              <label>Room limit</label>
              <input form="addPlanForm" type="number" class="form-control" min="1" name="room_limit" required>
          </div>

          <div class="form-group">
              <label>User limit</label>
              <input form="addPlanForm" type="number" class="form-control" min="1" name="user_limit" required>
          </div>

          <div class="form-group">
              <label>Property limit</label>
              <input form="addPlanForm" type="number" class="form-control" min="1" name="property_limit" required>
          </div>

          <div class="form-group">
              <label>Trial expired at</label>
              <input form="addPlanForm" type="number" class="form-control" min="1" name="trial_expired_at" required>
              
          </div>


      </div>
      <div class="modal-footer">
        
          <button form="addPlanForm" type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want perform this action?'); this.disabled = true;"> Add</button>
          </div>
  </div>
  </div>
</div>
@endsection
