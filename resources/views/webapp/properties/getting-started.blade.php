@extends('templates.webapp-new.template')

@section('title', 'Getting started')

@section('sidebar')
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          {{-- <img src="{{ asset('/argon/assets/img/brand/logo.png') }}" class="navbar-brand-img" alt="...">--}}{{ $property->name }} 
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/dashboard">
                <i class="fas fa-tachometer-alt text-orange"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/home">
                <i class="fas fa-home text-indigo"></i>
                <span class="nav-link-text">Home</span>
              </a>
            </li>
            @endif
           
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
         
            @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
            <li class="nav-item">
                <a class="nav-link" href="/property/{{$property->property_id }}/occupants">
                  <i class="fas fa-user text-green"></i>
                  <span class="nav-link-text">Occupants</span>
                </a>
              </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="/property/{{$property->property_id }}/tenants">
                  <i class="fas fa-user text-green"></i>
                  <span class="nav-link-text">Tenants</span>
                </a>
              </li>
            @endif
          
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/owners">
                <i class="fas fa-user-tie text-teal"></i>
                <span class="nav-link-text">Owners</span>
              </a>
            </li>
            @endif

            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/concerns">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Concerns</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/joborders">
                <i class="fas fa-list text-dark"></i>
                <span class="nav-link-text">Job Orders</span>
              </a>
            </li>
           
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/personnels">
                <i class="fas fa-user-secret text-gray"></i>
                <span class="nav-link-text">Personnels</span>
              </a>
            </li>
            @endif

            @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
            <a class="nav-link" href="/property/{{$property->property_id }}/bills">
                <i class="fas fa-file-invoice-dollar text-pink"></i>
                <span class="nav-link-text">Bills</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/collections">
                <i class="fas fa-coins text-yellow"></i>
                <span class="nav-link-text">Collections</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/financials">
                <i class="fas fa-chart-line text-purple"></i>
                <span class="nav-link-text">Financials</span>
              </a>
            </li>
            @endif
            @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/payables">
                <i class="fas fa-file-export text-indigo"></i>
                <span class="nav-link-text">Payables</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/users">
                <i class="fas fa-user-circle text-green"></i>
                <span class="nav-link-text">Users</span>
              </a>
            </li>
          </ul>
          <!-- Divider -->
          <hr class="my-3">
          <!-- Heading -->
          <h6 class="navbar-heading p-0 text-muted">
            <span class="docs-normal">Documentation</span>
          </h6>
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item active">
              <a class="nav-link" href="/property/{{ $property->property_id }}/getting-started" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
        </li> <li class="nav-item">
              <a class="nav-link" href="/property/{{ $property->property_id }}/issues" target="_blank">
                <i class="fas fa-dizzy text-red"></i>
                <span class="nav-link-text">Issues</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/property/{{ $property->property_id }}/system-updates" target="_blank">
                <i class="fas fa-bug text-green"></i>
                <span class="nav-link-text">System Updates</span>
              </a>
            </li>
          <li class="nav-item">
              <a class="nav-link" href="/property/{{ $property->property_id }}/announcements" target="_blank">
                <i class="fas fa-microphone text-purple"></i>
                <span class="nav-link-text">Announcements</span>
              </a>
            </li>
   
             {{--  <li class="nav-item">
              <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/plugins/charts.html" target="_blank">
                <i class="ni ni-chart-pie-35"></i>
                <span class="nav-link-text">Plugins</span>
              </a>
            </li> --}}
            
          </ul>
        </div>
      </div>
    </div>
  </nav>
@endsection

@section('upper-content')
<div class="row align-items-center py-4">
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-dark d-inline-block mb-0">Getting started</h6>
    
  </div>
  

</div>
<h6 class="h2 text-dark d-inline-block mb-0">Quick links - press the button of the topic you want to learn.</h6>
<br><br>
<div class="row">
<div class="col">
  <a href="#addingproperty" class="btn btn-sm btn-primary">Adding property</a>   
  <a  href="#addingusers" class="btn btn-sm btn-primary">Adding users</a>
  <a  href="#usersandtheirprivileges" class="btn btn-sm btn-primary">Users and their privileges</a>
  <a  href="#addingrooms" class="btn btn-sm btn-primary">Adding rooms</a>
  <a  href="#deletingrooms" class="btn btn-sm btn-primary">Deleting rooms</a>
  <a  href="#addingtenants" class="btn btn-sm btn-primary">Adding tenants</a>
  <a  href="#bulkbilling" class="btn btn-sm btn-primary">Bulk billing</a>
  <a  href="#singlebilling" class="btn btn-sm btn-primary">Single billing</a>
  <a  href="#recordingpayments" class="btn btn-sm btn-primary">Recording payments</a>
  <a  href="#addingowners" class="btn btn-sm btn-primary">Adding owners</a>
  <a  href="#addingpersonnels" class="btn btn-sm btn-primary">Adding personnels</a>
  <a  href="#addingconcerns" class="btn btn-sm btn-primary">Adding concerns</a>
  <a  href="#filingjoborder" class="btn btn-sm btn-primary">Filing a job order</a>
  <a  href="#addpayableentry" class="btn btn-sm btn-primary">Add payable</a>
  <a  href="#addpayableentry" class="btn btn-sm btn-primary">Request payable</a>
</div>
</div>
<hr>
<div class="row">
  <div class="col">
    <ol>
      <li id="addingproperty">Adding property.</li>
      <br>
        <p class="text-justify">
          There are two things that you need to set-up to start managing a property.
          Firstly, you need to add the property itself. It is being done after the registration. The other one is to add your co-users, which will be explained below.
          The Property Manager allows you to add and manage multiple properties using one account. 
          However, the Basic plan, including the Free trial (7 days), limits the property to one,
           which is automatically selected when you click the <button class="btn btn-sm btn-primary">Manage</button>on the My Properties page.
           If you are on Advance or Enterprise plan, you can add more properties by clicking the <button class="btn btn-sm btn-primary"> Property </button>. 
          </p>
          <li id="addingusers">Adding users.</li>
              <br>
              <p class="text-justify">
                These other users are the equivalent of employees in a real property management office. 
          The <button class="btn btn-sm btn-primary">Users (1/2)</button> allows you to add additional users such as the admin, billing, treasury, and the account payables (ap). 
          By default, the one who created the account is going to be the manager of the property. 
          If you notice a (1/2) number on the Users button, this indicates the number of users you can create.
          For the Basic plan, including the Free trial (7 days), you can only add up to 2 users (manager and admin). 
          In comparison, the Advance plan gives you 3 with the addition of billing,  and the Enterprise plan unlocks the feature to create all five types of users, including the 
          treasury and the ap to execute your property management processes seamlessly.
              </p>
              <p class="font-italic" id="usersandtheirprivileges">Users and their privileges</p>
              <ol>
                <li>Property management

                  <table class="table">
                    <tr>
                      <th>User</th>
                      <th>Can add property?</th>
                      <th>Can add user?</th>
                      <th>Can assign user to a property?</th>
                      <th>Can view other property?</th>
                      
                    </tr>
                    <tr>
                      <td>Manager</td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                      <td>Admin</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                    </tr>
                    <tr>
                      <td>Billing</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                    </tr>
                    <tr>
                      <td>Treasury</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                    </tr>
                    <tr>
                      <td>AP</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                    </tr>
                  </table>
                </li>
                <li>Room management

                  <table class="table">
                    <tr>
                      <th>User</th>
                      <th>Can add room?</th>
                      <th>Can view room?</th>
                      <th>Can edit room?</th>
                      <th>Can delete room?</th>
                   
                      
                    </tr>
                    <tr>
                      <td>Manager</td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                   
                    </tr>
                    <tr>
                      <td>Admin</td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                   
                  
                    </tr>
                    <tr>
                      <td>Billing</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
             
                    </tr>
                    <tr>
                      <td>Treasury</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                  
                    </tr>
                    <tr>
                      <td>AP</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
              
                    </tr>
                  </table>
                </li>
                <li>Tenant management

                  <table class="table">
                    <tr>
                      <th>User</th>
                      <th>Can add tenant?</th>
                      <th>Can edit tenant?</th>
                      <th>Can view tenant</th>
                      <th>Can add contract?</th>
                      <th>Can edit contract?</th>
                      <th>Can delete contract?</th>
                      <th>Can terminate contract?</th>
                      <th>Can extend contract?</th>
                   
                      
                    </tr>
                    <tr>
                      <td>Manager</td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                      <td>Admin</td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                  
                    </tr>
                    <tr>
                      <td>Billing</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                    </tr>
                    <tr>
                      <td>Treasury</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                    </tr>
                    <tr>
                      <td>AP</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                    </tr>
                  </table>
                </li>
                <li>Owner management

                  <table class="table">
                    <tr>
                      <th>User</th>
                      <th>Can add owner?</th>
                      <th>Can edit owner?</th>
                      <th>Can view owner</th>
                      
                   
                      
                    </tr>
                    <tr>
                      <td>Manager</td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
         
                    </tr>
                    <tr>
                      <td>Admin</td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                  
                  
                    </tr>
                    <tr>
                      <td>Billing</td>
                  
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                      <td>Treasury</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                      <td>AP</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                    </tr>
                  </table>
                </li>
                <li>Billing management

                  <table class="table">
                    <tr>
                      <th>User</th>
                      <th>Can add bill?</th>
                      <th>Can edit bill?</th>
                      <th>Can view bill?</th>
                      <th>Can delete bill?</th>
                   
                      
                    </tr>
                    <tr>
                      <td>Manager</td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                   
                    </tr>
                    <tr>
                      <td>Admin</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                   
                  
                    </tr>
                    <tr>
                      <td>Billing</td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
             
                    </tr>
                    <tr>
                      <td>Treasury</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                     
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                  
                    </tr>
                    <tr>
                      <td>AP</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                     
                     
                      <td><i class="fas fa-times text-danger"></i></td>
              
                    </tr>
                  </table>
                </li>
                <li>Collection/Payment management

                  <table class="table">
                    <tr>
                      <th>User</th>
                      <th>Can add collection?</th>
                      
                      <th>Can view collection?</th>
                      <th>Can delete collection?</th>
                   
                      
                    </tr>
                    <tr>
                      <td>Manager</td>
                      <td><i class="fas fa-check text-success"></i></td>
                   
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                   
                    </tr>
                    <tr>
                      <td>Admin</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                 
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                   
                  
                    </tr>
                    <tr>
                      <td>Billing</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                 
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
             
                    </tr>
                    <tr>
                      <td>Treasury</td>
                      <td><i class="fas fa-check text-success"></i></td>
                    
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      
                  
                    </tr>
                    <tr>
                      <td>AP</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                   
                      <td><i class="fas fa-check text-success"></i></td>
                     
                     
                      <td><i class="fas fa-times text-danger"></i></td>
              
                    </tr>
                  </table>
                </li>
                <li>Concern management

                  <table class="table">
                    <tr>
                      <th>User</th>
                      <th>Can add concern?</th>
                      
                      <th>Can edit concern?</th>
                      <th>Can respond to concern?</th>
                      <th>Can resolve concern</th>
                      <th>Can file a job order?</th>
                      <th>Can rank assigned user?</th>
                   
                      
                    </tr>
                    <tr>
                      <td>Manager</td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                   
                    </tr>
                    <tr>
                      <td>Admin</td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                   
                  
                    </tr>
                    <tr>
                      <td>Billing</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
             
                    </tr>
                    <tr>
                      <td>Treasury</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                  
                    </tr>
                    <tr>
                      <td>AP</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                    </tr>
                  </table>
                </li>
                <li>Personnel management

                  <table class="table">
                    <tr>
                      <th>User</th>
                      <th>Can add personnel?</th>
                      
                      <th>Can view personnel?</th>
                      <th>Can delete personnel?</th>
                   
                      
                    </tr>
                    <tr>
                      <td>Manager</td>
                      <td><i class="fas fa-check text-success"></i></td>
                   
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                   
                    </tr>
                    <tr>
                      <td>Admin</td>
                      <td><i class="fas fa-check text-success"></i></td>
                   
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                  
                    </tr>
                    <tr>
                      <td>Billing</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
             
                    </tr>
                    <tr>
                      <td>Treasury</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      
                  
                    </tr>
                    <tr>
                      <td>AP</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                    
              
                    </tr>
                  </table>
                </li>
                <li>Account payable management

                  <table class="table">
                    <tr>
                      <th>User</th>
                      <th>Can add entry?</th>
                      
                      <th>Can request payable?</th>
                      <th>Can approve payable?</th>
                      <th>Can release payable?</th>
                      <th>Can decline payable?</th>
                      <th>Can see financials?</th>
                      
                    </tr>
                    <tr>
                      <td>Manager</td>
                      <td><i class="fas fa-check text-success"></i></td>
                   
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
               
                   
                    </tr>
                    <tr>
                      <td>Admin</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                  
                    </tr>
                    <tr>
                      <td>Billing</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
             
                    </tr>
                    <tr>
                      <td>Treasury</td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      
                  
                    </tr>
                    <tr>
                      <td>AP</td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-check text-success"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                      <td><i class="fas fa-times text-danger"></i></td>
                    
              
                    </tr>
                  </table>
                </li>
              </ol>
              <br>
              
          <li id="addingrooms">Adding rooms.</li>
          <br>
            <p class="text-justify">
              After you have added your first property and other users, press the <button class="btn btn-sm btn-primary">Manage</button>to start adding rooms. You will be redirected to the  
              Dashboard <a><i class="fas fa-tachometer-alt text-orange"></i></a>
              and you will see the overview of all the metrics and charts that your property will need to fill as you add rooms, tenants, contracts, and etc. 
              Go to the Home <a><i class="fas fa-home text-indigo"></i></a>
              and at the right side click the <button class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Add</button>, and fill-up the information, and hit the submit button. 
              The Add button allows you to add as many rooms as you want in a single click (consider upgrading your plan if you're going to add more.).
               There will be values by default, which you can change depending on your liking. The name of the rooms
              will start with the floor number you have selected, and which you have the option to change later by clicking the <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</button>. 
              <br><br>
              Furthermore, the status of the newly created rooms will be vacant. The rooms can be viewed as a whole, sorted based on the floor no, and categorically per building, which allows you to navigate easily
              to all the rooms.
              </p>
              <li id="deletingrooms">Archiving/Deleting rooms.</li>
              <br>
              <p class="text-justify">
                If you accidentally added incorrect number of rooms or just want to delete a room, you can do so by clicking the  <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</button> located beside
                the <button class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Add</button> in the Home <a><i class="fas fa-home text-indigo"></i></a>. But remember rooms are not totally deleted
                ,rather rooms are just put on deleted status, and which can be restored anytime. Rooms with deleted status will no longer appear anywhere in the property, but in the <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</button>.
              </p>
              <li id="addingtenants">Adding tenants.</li>
              <br>
              <p class="text-justify">
                To add a tenant to your property, select a particular room from the Home <a><i class="fas fa-home text-indigo"></i></a>. 
                Inside the room navigate to the           <a href="#/" role="tab" aria-controls="nav-tenants" aria-selected="false"><i class="fas fa-users fa-sm text-primary-50"></i> Tenants</a> tab, 
                and click the <button class="btn btn-sm btn-primary"><i class="fas fa-user-plus"></i> Add</button>. Once clicked, you will be redirected to a page to add the tenant information,
                contract details, and bill information. If you wish to go back to the room, you can click the <button class="btn btn-sm btn-primary"><i class="fas fa-home"></i> Home</button> at the top-left of the page.
                <br><br>
                There will be three input fields on the topmost part of the page: Room, Referrer, and Point of contact. Fields with a red asterisk indicate that it is required. 
                For instance,  the Referrer <b class="text-danger">(*)</b> needs to be selected in order to submit the form. Firstly, the room's field is automatically filled up as you selected the room.
                The Referrer's field will let you select the person who referred the tenant to stay in the property. The list of user all users will show in this field, 
                including the manager. If no one referred the tenant, select the None option. Lastly, the point of contact will allow you to choose the point 
                of contact between the Referrer's tenant, such as Facebook, Flyers, etc.

              </p>
              <li id ="bulkbilling" >Mass billing to tenants (rent, utilities, and etc.)</li>
              <br>
              <p class="text-justify">
                    
              </p>
              <li id ="singlebilling">Single billing to tenants (rent, utilities, and etc.)</li>
              <br>
              <p class="text-justify">
                    
              </p>
              <li id ="recordingpayments">Recording payment transactions.</li>
              <br>
              <p class="text-justify">
                    
              </p>
              <li id ="addingowners">Adding owners to a room. (Not applicable to all)</li>
              <br>
              <p class="text-justify">
                    
              </p>
              <li id ="addingpersonnels">Adding personnels to your property.</li>
              <br>
              <p class="text-justify">
                    
              </p>
              <li id ="addingconcerns">Adding concern to a tenant.</li>
              <br>
              <p class="text-justify">
                    
              </p>
              <li id ="filingjoborder">Filing a job order for a concern.</li>
              <br>
              <p class="text-justify">
                    
              </p>
              <li id ="addpayableentry">Add payable entry.</li>
              <br>
              <p class="text-justify">
                    
              </p>
              <li id ="addpayableentry">Request payables.</li>
              <br>
              <p class="text-justify">
                    
              </p>
    </ol>
  </div>
</div>

@endsection

@section('main-content')

@endsection

@section('scripts')
  
@endsection



