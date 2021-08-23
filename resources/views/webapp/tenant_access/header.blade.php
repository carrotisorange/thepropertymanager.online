<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Search form -->
      <form class="navbar-search navbar-search-light form-inline mr-sm-3" action="/search" id="navbar-search-main">
        <div class="form-group mb-0">
          <div class="input-group input-group-alternative input-group-merge">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>

            <input class="form-control" placeholder="Search" type="text" name="search_key" required>

          </div>
        </div>
        <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main"
          aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </form>
      <!-- Navbar links -->
      <ul class="navbar-nav align-items-center  ml-md-auto ">


      </ul>
      <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
        <li class="nav-item d-xl-none">
          <!-- Sidenav toggler -->
          <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </li>
        <li class="nav-item d-sm-none">
          <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
            <i class="ni ni-zoom-split-in"></i>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(Session::get('notifications')->count() > 4)
            <i class="ni ni-bell-55"></i><span class="badge badge-primary">5 <sup>+</sup></span>
            @else
            <i class="ni ni-bell-55"></i><span
              class="badge badge-primary">{{  Session::get('notifications')->count() }}</span>
            @endif


          </a>
          <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
            <!-- Dropdown header -->
            <div class="px-3 py-3">
              <h6 class="text-sm text-muted m-0">Your last <strong
                  class="text-primary">{{ Session::get('notifications')->count() }}</strong> activities.</h6>
            </div>
            <!-- List group -->
            <div class="list-group list-group-flush">



              @foreach (Session::get('notifications') as $item)

              <a href="#!" class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Avatar -->
                    @if($item->type === 'tenant')
                    <i class="fas fa-user text-green fa-lg"></i>
                    @elseif($item->type === 'payable')
                    <i class="fas fa-file-export text-indigo fa-lg"></i>
                    @elseif($item->type === 'owner')
                    <i class="fas fa-user-tie text-teal fa-lg"></i>
                    @elseif($item->type === 'concern')
                    <i class="fas fa-tools text-cyan fa-lg"></i>
                    @elseif($item->type === 'payment')
                    <i class="fas fa-coins text-yellow fa-lg"></i>
                    @elseif($item->type === 'bill')
                    <i class="fas fa-file-invoice-dollar text-pink fa-lg"></i>
                    @elseif($item->type === 'joborder')
                    <i class="fas fa-list text-dark fa-lg"></i>
                    @elseif($item->type === 'unit')
                    <i class="fas fa-home text-indigo fa-lg"></i>
                    @elseif($item->type === 'contract')
                    <i class="fas fa-file-signature text-teal fa-lg"></i>
                    @elseif($item->type === 'search')
                    <i class="fas fa-search text-blue fa-lg"></i>
                    @elseif($item->type === 'financial')
                    <i class="fas fa-file-export text-indigo fa-lg"></i>
                    @elseif($item->type === 'user')
                    <i class="fas fa-user-circle text-green fa-lg"></i>
                    @elseif($item->type === 'issue')
                    <i class="fas fa-dizzy text-red text-red fa-lg"></i>
                    @elseif($item->type === 'remittance')
                    <i class="fas fa-hand-holding-usd text-teal fa-lg"></i>
                    @else
                    <i class="fas fa-building text-primary fa-lg"></i>
                    @endif
                  </div>
                  <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h4 class="mb-0 text-sm">{{ $item->message }}</h4>
                      </div>
                      <div class="text-right text-muted">
                        {{-- <small>{{ $item->created_at }}</small> --}}
                      </div>
                    </div>
                    <p class="text-sm text-muted mb-0">{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                    </p>
                  </div>
                </div>
              </a>

              @endforeach

            </div>
            <!-- View all -->
            {{-- <a href="/property/{{Session::get('property_id')}}/notifications" class="dropdown-item text-center
            text-primary font-weight-bold py-3">View all</a> --}}
          </div>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="{{ asset('/argon/assets/img/brand/logo.png') }}">
              </span>
              <div class="media-body  ml-2  d-none d-lg-block">
                <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->name }}</span>
              </div>
            </div>
          </a>
          <div class="dropdown-menu  dropdown-menu-right ">
            <div class="dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <a href="/user/{{ Auth::user()->id }}/tenant/{{ $tenant->tenant_id }}/profile" class="dropdown-item">
              <i class="fas fa-user"></i>
              <span>My profile</span>
            </a>
            {{-- <a href="/property/all" class="dropdown-item">
          <i class="fas fa-building"></i>
          <span>My Properties</span>
        </a> --}}
            {{-- <a href="/property/{{Session::get('property_id')}}/blogs" class="dropdown-item">
            <i class="fas fa-blog"></i>
            <span>Blogs</span>
            </a> --}}
            {{-- <a href="#!" class="dropdown-item">
          <i class="ni ni-calendar-grid-58"></i>
          <span>Activity</span>
        </a>
        <a href="#!" class="dropdown-item">
          <i class="ni ni-support-16"></i>
          <span>Support</span>
        </a> --}}
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
          </div>
        </li>
      </ul>

    </div>
  </div>
</nav>