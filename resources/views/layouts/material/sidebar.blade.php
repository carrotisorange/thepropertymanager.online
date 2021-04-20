<div class="sidebar-wrapper">
    <ul class="nav">
      {{-- dashboard --}}
        @if(Session::get('current-page') === 'dashboard')
        <li class="nav-item active">
        <a class="nav-link" href="/property/all">
          <i class="material-icons">dashboard</i>
          <p>Dashboard</p>
        </a>
        </li>
        @else
        <li class="nav-item">
        <a class="nav-link" href="/property/all">
          <i class="material-icons">dashboard</i>
          <p>Dashboard</p>
        </a>
        </li>
        @endif
        {{-- Tasks --}}
        @if(Session::get('current-page') === 'tasks')
        <li class="nav-item active">
          <a class="nav-link" href="/dev/issues">
            <i class="material-icons">content_paste</i>
            <p>Tasks</p>
          </a>
        </li>
        @else
        <li class="nav-item ">
          <a class="nav-link" href="/dev/issues">
            <i class="material-icons">content_paste</i>
            <p>Tasks</p>
          </a>
        </li>
        @endif
        {{-- User activities --}}
        @if(Session::get('current-page') === 'user-activities')
        <li class="nav-item active">
          <a class="nav-link" href="/dev/activities">
            <i class="material-icons">notifications</i>
            <p>User activities</p>
          </a>
        </li>
        @else
        <li class="nav-item ">
          <a class="nav-link" href="/dev/activities">
            <i class="material-icons">notifications</i>
            <p>User activities</p>
          </a>
        </li>
        @endif
        {{-- System users --}}
        @if(Session::get('current-page') === 'system-users')
        <li class="nav-item active">
          <a class="nav-link" href="/dev/users">
            <i class="material-icons">person</i>
            <p>System Users</p>
          </a>
        </li>
        @else
        <li class="nav-item ">
          <a class="nav-link" href="/dev/users">
            <i class="material-icons">person</i>
            <p>System Users</p>
          </a>
        </li>
        @endif
         {{-- Properties --}}
         @if(Session::get('current-page') === 'properties')
         <li class="nav-item active">
          <a class="nav-link" href="/dev/properties">
            <i class="fas fa-building"></i>
            <p>Properties</p>
          </a>
        </li>
         @else
         <li class="nav-item ">
          <a class="nav-link" href="/dev/properties">
            <i class="fas fa-building"></i>
            <p>Properties</p>
          </a>
        </li>
         @endif
       
         {{-- Property types --}}
         @if(Session::get('current-page') === 'property_types')
         <li class="nav-item active">
          <a class="nav-link" href="/dev/property/types">
            <i class="fas fa-building"></i>
            <p>Property types</p>
          </a>
        </li>
         @else
         <li class="nav-item ">
          <a class="nav-link" href="/dev/property/types">
            <i class="fas fa-building"></i>
            <p>Property types</p>
          </a>
        </li>
         @endif
     {{-- System updates --}}
     @if(Session::get('current-page') === 'system-updates')
     <li class="nav-item active">
      <a class="nav-link" href="/dev/updates/">
        <i class="material-icons">language</i>
        <p>System Updates</p>
      </a>
    </li>
     @else
     <li class="nav-item ">
      <a class="nav-link" href="/dev/updates/">
        <i class="material-icons">language</i>
        <p>System Updates</p>
      </a>
    </li>
     @endif
      {{-- Announcements --}}
     @if(Session::get('current-page') === 'announcements')
     <li class="nav-item active">
      <a class="nav-link" href="/dev/announcements">
        <i class="material-icons">library_books</i>
        <p>Announcements</p>
      </a>
    </li>
     @else
     <li class="nav-item ">
      <a class="nav-link" href="/dev/announcements">
        <i class="material-icons">library_books</i>
        <p>Announcements</p>
      </a>
    </li>
     @endif
      {{-- Plans --}}
      @if(Session::get('current-page') === 'plans')
      <li class="nav-item active">
        <a class="nav-link" href="/dev/plans">
          <i class="material-icons">bubble_chart</i>
          <p>Plans</p>
        </a>
      </li>
      @else
      <li class="nav-item ">
        <a class="nav-link" href="/dev/plans">
          <i class="material-icons">bubble_chart</i>
          <p>Plans</p>
        </a>
      </li>
      @endif
      {{-- Documentation --}}
      @if(Session::get('current-page') === 'documentation')
      <li class="nav-item active">
        <a class="nav-link" href="/starter">
          <i class="material-icons">unarchive</i>
          <p>Documentation</p>
        </a>
      </li>
      @else
      <li class="nav-item ">
        <a class="nav-link" href="/starter">
          <i class="material-icons">unarchive</i>
          <p>Documentation</p>
        </a>
      </li>
      @endif
    </ul>
  </div>