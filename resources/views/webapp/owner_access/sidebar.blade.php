<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main" <div
  class="scrollbar-inner">
  <!-- Brand -->
  <div class="sidenav-header  align-items-center">
    <a class="navbar-brand" href="javascript:void(0)">
      Owner Portal
    </a>
  </div>
  <div class="navbar-inner">
    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="sidenav-collapse-main">
      <!-- Nav items -->
      <ul class="navbar-nav">
        <li class="nav-item">
          @if(Session::get('current-page') === 'dashboard')
          <a class="nav-link active" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/dashboard">
            <i class="fas fa-tachometer-alt text-orange"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
          @else
          <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/dashboard">
            <i class="fas fa-tachometer-alt text-orange"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
          @endif
        </li>
        <li class="nav-item">
          @if(Session::get('current-page') === 'rooms')
          <a class="nav-link active" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/rooms">
            <i class="fas fa-file-signature text-indigo"></i>
            <span class="nav-link-text">Rooms & Contracts</span>
          </a>
          @else
          <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/rooms">
            <i class="fas fa-file-signature text-indigo"></i>
            <span class="nav-link-text">Rooms & Contracts</span>
          </a>
          @endif
        </li>
        <li class="nav-item">
          @if(Session::get('current-page') === 'remittances')
          <a class="nav-link active" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/remittances">
            <i class="fas fa-hand-holding-usd text-teal"></i>
            <span class="nav-link-text">Remittances</span>
          </a>
          @else
          <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/remittances">
            <i class="fas fa-hand-holding-usd text-teal"></i>
            <span class="nav-link-text">Remittances</span>
          </a>
          @endif
        </li>
        <li class="nav-item">
          @if(Session::get('current-page') === 'expenses')
          <a class="nav-link active" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/expenses">
            <i class="fas fa-search-dollar text-red"></i>
            <span class="nav-link-text">Expenses</span>
          </a>
          @else
          <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/expenses">
            <i class="fas fa-search-dollar text-red"></i>
            <span class="nav-link-text">Expenses</span>
          </a>
          @endif
        </li>
        <li class="nav-item">
          @if(Session::get('current-page') === 'financials')
          <a class="nav-link active" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/financials">
            <i class="fas fa-coins text-yellow"></i>
            <span class="nav-link-text">Financial Reports</span>
          </a>
          @else
          <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/financials">
            <i class="fas fa-coins text-yellow"></i>
            <span class="nav-link-text">Financial Reports</span>
          </a>
          @endif
        </li>
        <li class="nav-item">
          @if(Session::get('current-page') === 'concerns')
          <a class="nav-link active" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/concerns">
            <i class="fas fa-tools text-cyan"></i>
            <span class="nav-link-text">Concerns</span>
          </a>
          @else
          <a class="nav-link" href="/user/{{ Auth::user()->id }}/owner/{{ $owner->owner_id }}/concerns">
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