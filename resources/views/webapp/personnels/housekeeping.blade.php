@extends('templates.webapp.template')

@section('title', 'Housekeeping')

@section('sidebar')
   
      
           <!-- Heading -->
      
          <!-- Nav Item - Pages Collapse Menu -->
          <li class="nav-item">
                <a class="nav-link" href="/board">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span>Dashboard</span></a>
              </li>
      
            <hr class="sidebar-divider">
      
            <div class="sidebar-heading">
              Interface
            </div>  
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
          <li class="nav-item">
            <a class="nav-link" href="/home">
              <i class="fas fa-home"></i>
              <span>Home</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/calendar">
              <i class="fas fa-calendar-alt"></i>
              <span>Calendar</span></a>
          </li>
          @endif
        
          @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
            <li class="nav-item">
              <a class="nav-link" href="/tenants">
                <i class="fas fa-users fa-chart-area"></i>
                <span>Tenants</span></a>
            </li>
            @endif
      
       @if((Auth::user()->user_type === 'admin' && Auth::user()->property_ownership === 'Multiple Owners') || (Auth::user()->user_type === 'manager' && Auth::user()->property_ownership === 'Multiple Owners'))
        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="/owners">
            <i class="fas fa-user-tie"></i>
            <span>Owners</span></a>
        </li>
         @endif
      
         <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="/concerns">
          <i class="far fa-comment-dots"></i>
              <span>Concerns</span></a>
        </li>
    
        @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
        <li class="nav-item">
            <a class="nav-link" href="/joborders">
              <i class="fas fa-tools fa-table"></i>
              <span>Job Orders</span></a>
        </li>
        @endif
      
             <!-- Nav Item - Tables -->
        @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
          <li class="nav-item">
            <a class="nav-link collapsed" href="/personnels" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
              <i class="fas fa-user-cog"></i>
                <span>Personnels</span>
              </a>
              <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <a class="collapse-item active" href="/housekeeping">Housekeeping</a>
                  <a class="collapse-item" href="/maintenance">Maintenance</a>
                </div>
              </div>
            </li>
        @endif
      
           @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
            <!-- Nav Item - Tables -->
            <li class="nav-item">
              <a class="nav-link" href="/bills">
                <i class="fas fa-file-invoice-dollar fa-table"></i>
                <span>Bills</span></a>
            </li>
           @endif
      
           @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
              <li class="nav-item">
              <a class="nav-link" href="/collections">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Collections</span></a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/financials">
                <i class="fas fa-coins"></i>
                <span>Financials</span></a>
            </li>
            @endif
      
               @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
            <a class="nav-link" href="/payables">
            <i class="fas fa-hand-holding-usd"></i>
              <span>Payables</span></a>
          </li>
          @endif
      
          @if(Auth::user()->user_type === 'manager')
           <!-- Nav Item - Tables -->
           <li class="nav-item">
            <a class="nav-link" href="/users">
              <i class="fas fa-user-circle"></i>
              <span>Users</span></a>
          </li>
          @endif
          
          <!-- Divider -->
          <hr class="sidebar-divider d-none d-md-block">
      
          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div>
    
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Housekeeping</h1>
  <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls=""> <i class="fas fa-user-plus  fa-sm text-white-50"></i> Add Housekeeping</a> 
  
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
                  <input form="addPersonnelForm" type="hidden" class="form-control" name="personnel_type" value="housekeeping" required>
              </div>
              <div class="col">
                  <label for="recipient-name" class="col-form-label"><b>Contact No</b></label>
                  <input form="addPersonnelForm" type="text" class="form-control" name="personnel_contact_no" required>
              </div>
             
          </div>
          <br>
            <p class="text-right">
              <button class="btn btn-primary" type="submit" form="addPersonnelForm" onclick="return confirm('Are you sure you want perform this action?');" ><i class="fas fa-check fa-sm text-white-50"></i> Add Housekeeping</button>
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



