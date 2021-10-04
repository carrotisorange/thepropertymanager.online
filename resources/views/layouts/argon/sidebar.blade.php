{{-- sidebar --}}
<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header align-items-center">
      <a class="navbar-brand" href="javascript:void(0)">
        {{Session::get('property_name')}}
      </a>
    </div>
    <div class="navbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
          {{-- Dashboard --}}
          <li class="nav-item">
            @if(Session::get('current-page') === 'dashboard')
            <a class="nav-link active"
              href={{ route('show-dashboard', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-tachometer-alt text-orange"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-dashboard', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-tachometer-alt text-orange"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
            @endif
          </li>
          {{-- Units/Rooms --}}
          @if(Auth::user()->role_id_foreign === 1 || Auth::user()->role_id_foreign === 4 )
          <li class="nav-item">
            @if(Session::get('property_type') === '5' || Session::get('property_type') === '1' ||
            Session::get('property_type') === '6')
            @if(Session::get('current-page') === 'units')
            <a class="nav-link active"
              href={{ route('show-all-unit', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-home text-indigo"></i>
              <span class="nav-link-text">Units</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-unit', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-home text-indigo"></i>
              <span class="nav-link-text">Units</span>
            </a>
            @endif
            @else
            @if(Session::get('current-page') === 'rooms')
            <a class="nav-link active"
              href={{ route('show-all-room', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-home text-indigo"></i>
              <span class="nav-link-text">Rooms</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-room', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-home text-indigo"></i>
              <span class="nav-link-text">Rooms</span>
            </a>
            @endif

            @endif
          </li>
          @endif
          {{-- Tenants/Occupants --}}
          @if(Auth::user()->role_id_foreign === 1 || Auth::user()->role_id_foreign === 4 ||
          Auth::user()->role_id_foreign === 3 || Auth::user()->role_id_foreign === 5)
          @if(Session::get('property_type') === '5' || Session::get('property_type') === 1 ||
          Session::get('property_type') === '6')
          <li class="nav-item">
            @if(Session::get('current-page') === 'occupants')
            <a class="nav-link active"
              href={{ route('show-all-occupant', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-user text-green"></i>
              <span class="nav-link-text">Occupants</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-occupant', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-user text-green"></i>
              <span class="nav-link-text">Occupants</span>
            </a>
            @endif
          </li>
          @else
          <li class="nav-item">
            @if(Session::get('current-page') === 'tenants')
            <a class="nav-link active"
              href={{ route('show-all-tenant', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-user text-green"></i>
              <span class="nav-link-text">Tenants</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-tenant', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-user text-green"></i>
              <span class="nav-link-text">Tenants</span>
            </a>
            @endif
          </li>
          @endif
          {{-- Owners --}}
          {{-- @if(Session::get('property_ownership') === 'Multiple Owners') --}}
          <li class="nav-item">
            @if(Session::get('current-page') === 'owners')
            <a class="nav-link active"
              href={{ route('show-all-owner', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-user-tie text-teal"></i>
              <span class="nav-link-text">Owners</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-owner', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-user-tie text-teal"></i>
              <span class="nav-link-text">Owners</span>
            </a>
            @endif
          </li>
          {{-- @endif --}}
          @endif
          {{-- Concerns --}}
          <li class="nav-item">
            @if(Session::get('current-page') === 'concerns')
            <a class="nav-link active"
              href={{ route('show-all-concern', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-tools text-cyan"></i>
              <span class="nav-link-text">Concerns</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-concern', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-tools text-cyan"></i>
              <span class="nav-link-text">Concerns</span>
            </a>
            @endif
          </li>
          {{-- Violations --}}
          <li class="nav-item">
            @if(Session::get('current-page') === 'violations')
            <a class="nav-link active"
              href={{ route('show-all-violation', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-smoking-ban text-primary"></i>
              <span class="nav-link-text">Violations</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-violation', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-smoking-ban text-primary"></i>
              <span class="nav-link-text">Violations</span>
            </a>
            @endif
          </li>
          {{-- Job Orders --}}
          @if(Auth::user()->role_id_foreign === 1 || Auth::user()->role_id_foreign === 4 )
          <li class="nav-item">
            @if(Session::get('current-page') === 'job-orders')
            <a class="nav-link active"
              href={{ route('show-all-joborder', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-list text-dark"></i>
              <span class="nav-link-text">Job Orders</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-joborder', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-list text-dark"></i>
              <span class="nav-link-text">Job Orders</span>
            </a>
            @endif
          </li>
          {{-- Personnels --}}
          <li class="nav-item">
            @if(Session::get('current-page') === 'employees')
            <a class="nav-link active"
              href={{ route('show-all-personnel', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-id-card-alt text-gray"></i>
              <span class="nav-link-text">Employees and Personnels</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-personnel', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-id-card-alt text-gray"></i>
              <span class="nav-link-text">Employees and Personnels</span>
            </a>
            @endif
          </li>
          @endif

          {{-- Suppliers --}}
          @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1)
          <li class="nav-item">
            @if(Session::get('current-page') === 'suppliers')
            <a class="nav-link active"
              href={{ route('show-all-supplier', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-boxes text-dark"></i>
              <span class="nav-link-text">Suppliers</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-supplier', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-boxes text-dark"></i>
              <span class="nav-link-text">Suppliers</span>
            </a>
            @endif
          </li>
          @endif


        </ul>

        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading p-0 text-muted">
          <span class="docs-normal">Financials</span>
        </h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          {{-- Bulk billing --}}
          @if(Auth::user()->role_id_foreign === 3 || Auth::user()->role_id_foreign === 4 ||
          Auth::user()->role_id_foreign === 1)
          <li class="nav-item">
            @if(Session::get('current-page') === 'bulk-billing')
            <a class="nav-link active"
              href={{ route('show-all-bill', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-file-invoice-dollar text-pink"></i>
              <span class="nav-link-text">Bills</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-bill', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-file-invoice-dollar text-pink"></i>
              <span class="nav-link-text">Bills</span>
            </a>
            @endif
          </li>
          @endif
          {{-- Daily Collection Report --}}
          @if(Auth::user()->role_id_foreign === 5 || Auth::user()->role_id_foreign === 4 ||
          Auth::user()->role_id_foreign === 2 || Auth::user()->role_id_foreign === 1)
          <li class="nav-item">
            @if(Session::get('current-page') === 'daily-collection-report')
            <a class="nav-link active"
              href={{ route('show-all-collection', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-coins text-yellow"></i>
              <span class="nav-link-text">Collections</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-collection', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-coins text-yellow"></i>
              <span class="nav-link-text">Collections</span>
            </a>
            @endif
          </li>
          @endif
          {{-- Remittances --}}
          @if(Auth::user()->role_id_foreign === 2 || Auth::user()->role_id_foreign === 4 ||
          Auth::user()->role_id_foreign === 1)
          @if(Session::get('property_type') === '7')
          <li class="nav-item">
            @if(Session::get('current-page') === 'remittances')
            <a class="nav-link active"
              href={{ route('show-all-remittance', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-hand-holding-usd text-teal"></i>
              <span class="nav-link-text">Remittances</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-remittance', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-hand-holding-usd text-teal"></i>
              <span class="nav-link-text">Remittances</span>
            </a>
            @endif
          </li>
          @endif
          @endif

          {{-- Payables --}}
          @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 2 )
          <li class="nav-item">
            @if(Session::get('current-page') === 'payables')
            <a class="nav-link active"
              href={{ route('show-all-payable', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-file-export text-indigo"></i>
              <span class="nav-link-text">Payables</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-payable', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-file-export text-indigo"></i>
              <span class="nav-link-text">Payables</span>
            </a>
            @endif

          </li>
          @endif
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading p-0 text-muted">
          <span class="docs-normal">Reports</span>
        </h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          {{-- Financial reports --}}
          @if(Auth::user()->role_id_foreign === 4 || Auth::user()->role_id_foreign === 1)
          <li class="nav-item">
            @if(Session::get('current-page') === 'financial-reports')
            <a class="nav-link active"
              href={{ route('show-all-financial', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-chart-line text-purple"></i>
              <span class="nav-link-text">Financial Reports</span>
            </a>
            @else
            <a class="nav-link" href={{ route('show-all-financial', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-chart-line text-purple"></i>
              <span class="nav-link-text">Financial Reports</span>
            </a>
            @endif

          </li>
          @endif
          {{-- Usage history --}}
          @if(Auth::user()->role_id_foreign === 4)
          <li class="nav-item">
            @if(Session::get('current-page') === 'usage-history')
            <a class="nav-link active"
              href={{ route('show-all-usage-history', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-user-circle text-green"></i>
              <span class="nav-link-text">Usage History</span>
            </a>
            @else
            <a class="nav-link"
              href={{ route('show-all-usage-history', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-user-circle text-green"></i>
              <span class="nav-link-text">Usage History</span>
            </a>
            @endif

          </li>
          @endif
          @if(Auth::user()->role_id_foreign === 4)
          <li class="nav-item">
            @if(Session::get('current-page') === 'audit-trails')
            <a class="nav-link active"
              href={{ route('show-all-audit-trails', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-calculator text-yellow"></i>
              <span class="nav-link-text">Audit Trails</span>
            </a>
            @else
            <a class="nav-link"
              href={{ route('show-all-audit-trails', ['property_id' => Session::get('property_id')]) }}>
              <i class="fas fa-calculator text-yellow"></i>
              <span class="nav-link-text">Audit Trails</span>
            </a>
            @endif

          </li>
          @endif
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading p-0 text-muted">
          <span class="docs-normal">Documentation</span>
        </h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            @if(Session::get('current-page') === 'getting-started')
            <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/getting-started"
              target="_blank">
              <i class="ni ni-spaceship"></i>
              <span class="nav-link-text">Getting started</span>
            </a>
            @else
            <a class="nav-link" href="/property/{{ Session::get('property_id') }}/getting-started" target="_blank">
              <i class="ni ni-spaceship"></i>
              <span class="nav-link-text">Getting started</span>
            </a>
            @endif

          </li>
          </li>
          <li class="nav-item">
            @if(Session::get('current-page') === 'issues')
            <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/issues" target="_blank">
              <i class="fas fa-dizzy text-red"></i>
              <span class="nav-link-text">Issues</span>
            </a>
            @else
            <a class="nav-link" href="/property/{{ Session::get('property_id') }}/issues" target="_blank">
              <i class="fas fa-dizzy text-red"></i>
              <span class="nav-link-text">Issues</span>
            </a>
            @endif

          </li>
          <li class="nav-item">
            @if(Session::get('current-page') === 'system-updates')
            <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/system-updates"
              target="_blank">
              <i class="fas fa-bug text-green"></i>
              <span class="nav-link-text">System Updates</span>
            </a>
            @else
            <a class="nav-link" href="/property/{{ Session::get('property_id') }}/system-updates" target="_blank">
              <i class="fas fa-bug text-green"></i>
              <span class="nav-link-text">System Updates</span>
            </a>
            @endif
          </li>
          <li class="nav-item">
            @if(Session::get('current-page') === 'announcements')
            <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/announcements" target="_blank">
              <i class="fas fa-microphone text-purple"></i>
              <span class="nav-link-text">Announcements</span>
            </a>
            @else
            <a class="nav-link" href="/property/{{ Session::get('property_id') }}/announcements" target="_blank">
              <i class="fas fa-microphone text-purple"></i>
              <span class="nav-link-text">Announcements</span>
            </a>
            @endif
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>