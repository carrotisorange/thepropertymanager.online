@extends('layouts.material.template')

@section('title', 'Dashboard')

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="fas fa-building"></i>
            </div>
            <p class="card-category">Properties</p>
            <h3 class="card-title">{{ number_format($properties->count(),0) }}
              {{-- <small>GB</small> --}}
            </h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              {{-- <i class="material-icons text-danger">warning</i>
              <a href="javascript:;">Get More Space...</a> --}}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-success card-header-icon">
            <div class="card-icon">
              <i class="fas fa-user"></i>
            </div>
            <p class="card-category">Active Users</p>
            <h3 class="card-title">{{ number_format($active_users->count(),0) }}</h3>
          </div>
          <div class="card-footer">
            {{-- <div class="stats">
              <i class="material-icons">date_range</i> Last 24 Hours
            </div> --}}
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="fas fa-funnel-dollar"></i>
            </div>
            <p class="card-category">Paying users</p>
            <h3 class="card-title">{{ number_format($paying_users->count(),0) }}</h3>
          </div>
          <div class="card-footer">
            {{-- <div class="stats">
              <i class="material-icons">local_offer</i> Tracked from Github
            </div> --}}
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-danger card-header-icon">
            <div class="card-icon">
              <i class="fas fa-user-clock"></i>
            </div>
            <p class="card-category">Unverified users</p>
            <h3 class="card-title">{{ number_format($unverified_users->count(),0) }}</h3>
          </div>
          <div class="card-footer">
            {{-- <div class="stats">
              <i class="material-icons">update</i> Just Updated
            </div> --}}
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="card card-chart">
          {{-- <div class="card-header card-header-warning">
            <div class="ct-chart" id="websiteViewsChart"></div>
          </div> --}}
          <div class="card-body">
            <h4 class="card-title">Sign Up</h4>
            <p class="card-category"> {!! $signup_rate->container() !!}</p>
          </div>
          <div class="card-footer">
            {{-- <div class="stats">
              <i class="material-icons">access_time</i> campaign sent 2 days ago
            </div> --}}
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card card-chart">
          {{-- <div class="card-header card-header-primary">
            <div class="ct-chart" id="completedTasksChart"></div>
          </div> --}}
          <div class="card-body">
            <h4 class="card-title">All Active Managers</h4>
            @if($all_active_managers->count() <= 0)
            <p class="text-danger text-center"><i class="fas fa-times-circle"></i> No active managers </p>
            @else
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="text-dark">
                  
                  <th>Name</th>
                  <th>Role</th>
                  <th>Since</th>
                </thead>
                <tbody>
                  @foreach ($all_active_managers as $item)
                  <tr>
                   
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->role_id_foreign }}</td>
                      <td>{{ Carbon\Carbon::parse($item->session_last_login_at)->diffForHumans() }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            @endif
          </div>
          <div class="card-footer">
            {{-- <div class="stats">
              <i class="material-icons">access_time</i> campaign sent 2 days ago
            </div> --}}
          </div>
        </div>
      </div>
    </div>
  
      
     <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="card">
          {{-- <div class="card-header card-header-success">
            <h4 class="card-title">All Active Users</h4>
            <p class="card-category">New employees on 15th September, 2016</p>
          </div> --}}
        
          <div class="card-body table-responsive">
            <h4 class="card-title">All Active Users</h4>
            @if($all_active_users->count() <= 0)
            <p class="text-danger text-center"><i class="fas fa-times-circle"></i> No active users</p>
            @else
            <table class="table table-hover">
              <thead class="text-dark">
                
                <th>Name</th>
                <th>Role</th>
                <th>Since</th>
              </thead>
              <tbody>
                @foreach ($all_active_users as $item)
                <tr>
                 
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->role_id_foreign }}</td>
                    <td>{{ Carbon\Carbon::parse($item->session_last_login_at)->diffForHumans() }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @endif
       
          </div>
        </div>
      </div>
     </div>
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="card">
            {{-- <div class="card-header card-header-danger">
              <h4 class="card-title">ACTIVE ISSUES</h4>
               <p class="card-category">New employees on 15th September, 2016</p>
            </div> --}}
            <div class="card-body table-responsive">
              <h4 class="card-title">Active Tasks</h4>
              @if($issues->count() <= 0)
              <p class="text-success text-center"><i class="fas fa-check-circle"></i> No active tasks</p>
              @else
              <table class="table table-hover">
                <thead class="text-dark">
                  
                  <th>Name</th>
                        
                  <th>Details</th>
                  <th>Date</th>
                </thead>
                <tbody>
                  @foreach ($issues as $item)
                      <tr>
                          <td>{{ $item->name }}</td>
                          
                          <td><a href="/dev/issue/{{ $item->issue_id }}/edit">{{ $item->details }}</a></td>
                          <td>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                      </tr>
                      @endforeach
                </tbody>
              </table>

              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
  {!! $signup_rate->script() !!}
@endsection
