<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header  align-items-center">
      <a class="navbar-brand" href="javascript:void(0)">
        Tenant Portal
      </a>
    </div>
    <div class="navbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
          <li class="nav-item">
            @if(Session::get('current-page') === 'dashboard')
            <a class="nav-link active" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/dashboard">
              <i class="fas fa-tachometer-alt text-orange"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
            @else
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/dashboard">
                <i class="fas fa-tachometer-alt text-orange"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            @endif
         
          </li>
          <li class="nav-item">
            @if(Session::get('current-page') === 'contract')
            <a class="nav-link active" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/rooms">
                <i class="fas fa-file-signature text-indigo"></i>
                <span class="nav-link-text">Contracts</span>
              </a>
            @else
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/rooms">
                <i class="fas fa-file-signature text-indigo"></i>
                <span class="nav-link-text">Contracts</span>
              </a>
            @endif
          
          </li>
          <li class="nav-item">
            @if(Session::get('current-page') === 'bill')
            <a class="nav-link active" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/bills">
                <i class="fas fa-file-invoice-dollar text-pink"></i>
                <span class="nav-link-text">Bills</span>
              </a>
            @else
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/bills">
                <i class="fas fa-file-invoice-dollar text-pink"></i>
                <span class="nav-link-text">Bills</span>
              </a>
            @endif
            
          </li>
          <li class="nav-item">
            @if(Session::get('current-page') === 'payment')
            <a class="nav-link active" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/payments">
                <i class="fas fa-coins text-yellow"></i>
                <span class="nav-link-text">Payments</span>
              </a>
            @else
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/payments">
                <i class="fas fa-coins text-yellow"></i>
                <span class="nav-link-text">Payments</span>
              </a>
            @endif
          
          </li>
          <li class="nav-item">
            @if(Session::get('current-page') === 'concern')
            <a class="nav-link active" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/concerns">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Concerns</span>
              </a>
            @else
            <a class="nav-link" href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/concerns">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Concerns</span>
              </a>
            @endif
           
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
