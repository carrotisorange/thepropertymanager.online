<ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="/property/all">
        <i class="material-icons">dashboard</i>
        <p class="d-lg-none d-md-block">
          Stats
        </p>
      </a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link" href="/dev/activities" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="material-icons">notifications</i>
        @if(Session::get('notifications')->count() < 5)
        <span class="notification">5+</span>
        @else
        <span class="notification">{{ Session::get('notifications')->count() }}</span>
        @endif
        <p class="d-lg-none d-md-block">
          Some Actions
        </p>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
        @foreach (Session::get('notifications') as $item)
        <a class="dropdown-item" href="#">{{ $item->message }}</a>
        @endforeach
      </div>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="material-icons">person</i>
        <p class="d-lg-none d-md-block">
          Account
        </p>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
        <a class="dropdown-item" href="#">Profile</a>
        <a class="dropdown-item" href="#">Settings</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Log out</a>
      </div>
    </li>
  </ul>