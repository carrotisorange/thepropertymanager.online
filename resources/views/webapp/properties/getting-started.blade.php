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
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/calendar">
                <i class="fas fa-calendar-alt text-red"></i>
                <span class="nav-link-text">Calendar</span>
              </a>
            </li>
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
            <li class="nav-item">
              <a class="nav-link" href="/property/{{$property->property_id }}/tenants">
                <i class="fas fa-user text-green"></i>
                <span class="nav-link-text">Tenants</span>
              </a>
            </li>
          
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
              <a class="nav-link" href="/property/{{$property->property_id }}}/personnels">
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
              <a class="nav-link" href="/property/{{ $property->property_id }}/issues" target="_blank">
                <i class="fas fa-microphone text-purple"></i>
                <span class="nav-link-text">Announcements</span>
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
<div class="row">
  <div class="col">
    <ol>
      <li>Setting up your first property.</li>
      <br>
        <p class="text-justify">
          There are two things that you need to set-up to start managing a property.
          Firstly, you need to create a property itself. It is being done after the registration. The other one is to add your co-users. These other users are the equivalent of employees in a real property management office. 
          The <button class="btn btn-sm btn-primary">Users (1/2)</button> allows you to add additional users such as the admin, billing, treasury, and the account payables (ap). 
          By default, the one who created the account is going to be the manager of the property. 
          If you notice a (1/2) number on the Users button, this indicates the number of users you can create.
          For the Basic plan, including the Free trial (7 days), you can only add up to 2 users (manager and admin). 
          In comparison, the Advance plan gives you 3 with the addition of billing,  and the Enterprise plan unlocks the feature to create all five types of users, including the 
          treasury and the ap to execute your property management processes seamlessly.
          <br><br>
          The Property Manager allows you to add and manage multiple properties using one account. 
          However, the Basic plan, including the Free trial (7 days), limits the property to one,
           which is automatically selected when you click the <button class="btn btn-sm btn-primary">Manage</button>on the My Properties page.
           If you are on Advance or Enterprise plan, you can add more properties by clicking the <button class="btn btn-sm btn-primary"> Property </button>. 
          </p>
          <li>Adding rooms to your property.</li>
          <br>
            <p class="text-justify">
              After you have added your first property and other users, press the <button class="btn btn-sm btn-primary">Manage</button> to start adding rooms. You will be redirected to the  
              Dashboard <a><i class="fas fa-tachometer-alt text-orange"></i></a>
              and you will see the overview of all the metrics and charts that your property will need to fill once you started adding tenants. Go to the Home <a><i class="fas fa-home text-indigo"></i></a>
              and at the right side click the <button class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Add</button> and fill-up the information to add the rooms. By default, the name of the rooms
              will start with the floor number you have selected, which you have the option to change by clicking the <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</button>. 
              Furthermore, the status of the newly created rooms will be vacant. The rooms will be sorted out based on the name of the building.
              </p>
              <li>Adding tenants to rooms.</li>
              <br>
              <p class="text-justify">
                
              </p>
              <li>Mass billing to tenants (rent, utilities, and etc.)</li>
              <br>
              <p class="text-justify">
                    
              </p>
              <li>Recording payment transactions.</li>
              <br>
              <p class="text-justify">
                    
              </p>
              <li>Adding owners to a room. (Not applicable to all)</li>
              <br>
              <p class="text-justify">
                    
              </p>
              <li>Adding personnels to your property.</li>
              <br>
              <p class="text-justify">
                    
              </p>
              <li>Adding concern to a tenant.</li>
              <br>
              <p class="text-justify">
                    
              </p>
              <li>Filing a job order for a concern.</li>
              <br>
              <p class="text-justify">
                    
              </p>
              <li>Add payable entry and request for payables.</li>
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



