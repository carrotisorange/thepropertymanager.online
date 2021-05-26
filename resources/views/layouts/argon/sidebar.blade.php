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
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/dashboard">
                <i class="fas fa-tachometer-alt text-orange"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
              @else
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/dashboard">
                <i class="fas fa-tachometer-alt text-orange"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
              @endif
            </li>
            {{-- Units/Rooms --}}
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
           <li class="nav-item">
              @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
                @if(Session::get('current-page') === 'units')
                <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/units">
                  <i class="fas fa-home text-indigo"></i>
                  <span class="nav-link-text">Units</span>
                </a>
                @else
                <a class="nav-link" href="/property/{{ Session::get('property_id') }}/units">
                  <i class="fas fa-home text-indigo"></i>
                  <span class="nav-link-text">Units</span>
                </a>
                @endif 
              @else
                @if(Session::get('current-page') === 'rooms')
                <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/rooms">
                  <i class="fas fa-home text-indigo"></i>
                  <span class="nav-link-text">Rooms</span>
                </a>
                @else
                <a class="nav-link" href="/property/{{ Session::get('property_id') }}/rooms">
                  <i class="fas fa-home text-indigo"></i>
                  <span class="nav-link-text">Rooms</span>
                </a>
                @endif 
          
              @endif
            </li>
            {{-- @elseif(Auth::user()->user_type === 'ap')
            <li class="nav-item">
              @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
                @if(Session::get('current-page') === 'units')
                <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/units/remittances">
                  <i class="fas fa-home text-indigo"></i>
                  <span class="nav-link-text">Units</span>
                </a>
                @else
                <a class="nav-link" href="/property/{{ Session::get('property_id') }}/units/remittances">
                  <i class="fas fa-home text-indigo"></i>
                  <span class="nav-link-text">Units</span>
                </a>
                @endif 
              @else
                @if(Session::get('current-page') === 'rooms')
                <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/rooms/remittances">
                  <i class="fas fa-home text-indigo"></i>
                  <span class="nav-link-text">Rooms</span>
                </a>
                @else
                <a class="nav-link" href="/property/{{ Session::get('property_id') }}/rooms/remittances">
                  <i class="fas fa-home text-indigo"></i>
                  <span class="nav-link-text">Rooms</span>
                </a>
                @endif 
          
              @endif
            </li> --}}
            @endif
            {{-- Tenants/Occupants --}}
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'treasury')
                @if(Session::get('property_type') === 'Condominium Corporation' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex' || Session::get('property_type') === 'Condominium Associations' || Session::get('property_type') === 'Commercial Complex')
                <li class="nav-item">
                  @if(Session::get('current-page') === 'occupants')
                  <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/occupants">
                    <i class="fas fa-user text-green"></i>
                    <span class="nav-link-text">Occupants</span>
                    </a>
                  @else
                  <a class="nav-link" href="/property/{{ Session::get('property_id') }}/occupants">
                    <i class="fas fa-user text-green"></i>
                    <span class="nav-link-text">Occupants</span>
                    </a>
                  @endif 
                </li>
                @else
                <li class="nav-item">
                  @if(Session::get('current-page') === 'tenants')
                  <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/tenants">
                    <i class="fas fa-user text-green"></i>
                    <span class="nav-link-text">Tenants</span>
                  </a>
                  @else
                  <a class="nav-link" href="/property/{{ Session::get('property_id') }}/tenants">
                    <i class="fas fa-user text-green"></i>
                    <span class="nav-link-text">Tenants</span>
                  </a>
                  @endif
                </li>
            @endif
          {{-- Owners --}}
                @if(Session::get('property_ownership') === 'Multiple Owners')
                <li class="nav-item">
                  @if(Session::get('current-page') === 'owners')
                  <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/owners">
                    <i class="fas fa-user-tie text-teal"></i>
                    <span class="nav-link-text">Owners</span>
                  </a>
                  @else
                  <a class="nav-link" href="/property/{{ Session::get('property_id') }}/owners">
                    <i class="fas fa-user-tie text-teal"></i>
                    <span class="nav-link-text">Owners</span>
                  </a>
                  @endif
                </li>
                @endif
            @endif
            {{-- Concerns --}}
            <li class="nav-item">
              @if(Session::get('current-page') === 'concerns')
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/concerns">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Concerns</span>
              </a>
              @else
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/concerns">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Concerns</span>
              </a>
              @endif
            </li>
            {{-- Violations --}}
            <li class="nav-item">
              @if(Session::get('current-page') === 'violations')
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/violations">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Violations</span>
              </a>
              @else
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/violations">
                <i class="fas fa-tools text-cyan"></i>
                <span class="nav-link-text">Violations</span>
              </a>
              @endif
            </li>
            {{-- Job Orders --}}
            @if(Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'manager' )
            <li class="nav-item">
              @if(Session::get('current-page') === 'job-orders')
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/joborders">
                <i class="fas fa-list text-dark"></i>
                <span class="nav-link-text">Job Orders</span>
              </a>
              @else
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/joborders">
                <i class="fas fa-list text-dark"></i>
                <span class="nav-link-text">Job Orders</span>
              </a>
              @endif
            </li>
           {{-- Personnels --}}
            <li class="nav-item">
              @if(Session::get('current-page') === 'employees')
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/personnels">
                <i class="fas fa-id-card-alt text-gray"></i>
                <span class="nav-link-text">Employees and Personnels</span>
              </a>
              @else
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/personnels">
                <i class="fas fa-id-card-alt text-gray"></i>
                <span class="nav-link-text">Employees and Personnels</span>
              </a>
              @endif
            </li>
            @endif
            {{-- Bulk billing --}}
            @if(Auth::user()->user_type === 'billing' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
              @if(Session::get('current-page') === 'bulk-billing')
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/bills">
                <i class="fas fa-file-invoice-dollar text-pink"></i>
                <span class="nav-link-text">Bills</span>
              </a>
              @else
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/bills">
                <i class="fas fa-file-invoice-dollar text-pink"></i>
                <span class="nav-link-text">Bills</span>
              </a>
              @endif
            </li>
            @endif
            {{-- Suppliers --}}
            @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin')
              <li class="nav-item">
                @if(Session::get('current-page') === 'suppliers')
                <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/suppliers">
                  <i class="fas fa-coins text-yellow"></i>
                  <span class="nav-link-text">Suppliers</span>
                </a>
                @else
                <a class="nav-link" href="/property/{{ Session::get('property_id') }}/suppliers">
                  <i class="fas fa-coins text-yellow"></i>
                  <span class="nav-link-text">Suppliers</span>
                </a>
                @endif
            </li>
            @endif
            {{-- Daily Collection Report --}}
            @if(Auth::user()->user_type === 'treasury' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'admin')
              <li class="nav-item">
                @if(Session::get('current-page') === 'daily-collection-report')
                <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/collections">
                  <i class="fas fa-coins text-yellow"></i>
                  <span class="nav-link-text">Collections</span>
                </a>
                @else
                <a class="nav-link" href="/property/{{ Session::get('property_id') }}/collections">
                  <i class="fas fa-coins text-yellow"></i>
                  <span class="nav-link-text">Collections</span>
                </a>
                @endif
            </li>
            @endif
            {{-- Remittances --}}
            @if(Auth::user()->user_type === 'ap' || Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin') 
              @if(Session::get('property_type') === 'Apartment Rentals')
              <li class="nav-item">
                @if(Session::get('current-page') === 'remittances')
                <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/remittances">
                  <i class="fas fa-hand-holding-usd text-teal"></i>
                  <span class="nav-link-text">Remittances</span>
                </a>
                @else
                <a class="nav-link" href="/property/{{ Session::get('property_id') }}/remittances">
                  <i class="fas fa-hand-holding-usd text-teal"></i>
                  <span class="nav-link-text">Remittances</span>
                </a>
                @endif
              </li>
              @endif
            @endif
            {{-- Financial reports --}}
            @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin')
            <li class="nav-item">
              @if(Session::get('current-page') === 'financial-reports')
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/financials">
                <i class="fas fa-chart-line text-purple"></i>
                <span class="nav-link-text">Financial Reports</span>
              </a>
              @else
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/financials">
                <i class="fas fa-chart-line text-purple"></i>
                <span class="nav-link-text">Financial Reports</span>
              </a>
              @endif
              
            </li>
            @endif
            {{-- Payables --}}
            @if(Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'ap' )
            <li class="nav-item">
              @if(Session::get('current-page') === 'payables')
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/payables">
                <i class="fas fa-file-export text-indigo"></i>
                <span class="nav-link-text">Payables</span>
              </a>
              @else
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/payables">
                <i class="fas fa-file-export text-indigo"></i>
                <span class="nav-link-text">Payables</span>
              </a>
              @endif
              
            </li>
            @endif
            {{-- Usage history --}}
            @if(Auth::user()->user_type === 'manager')
            <li class="nav-item">
              @if(Session::get('current-page') === 'usage-history')
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/users">
                <i class="fas fa-user-circle text-green"></i>
                <span class="nav-link-text">Usage History</span>
              </a>
              @else
              <a class="nav-link" href="/property/{{ Session::get('property_id') }}/users">
                <i class="fas fa-user-circle text-green"></i>
                <span class="nav-link-text">Usage History</span>
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
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/getting-started" target="_blank">
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
              <a class="nav-link active" href="/property/{{ Session::get('property_id') }}/system-updates" target="_blank">
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