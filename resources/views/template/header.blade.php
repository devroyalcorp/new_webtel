<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="{{route('home')}}"">Webtel & Webmail</a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            @if(!Session::get('login_status'))
              <a class="nav-link" href="{{route('admin.login')}}"><i class="fa fa-sign-in" aria-hidden="true"></i>
                  Login</a>
            @else
              <a class="nav-link" href="{{route('admin.logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i>
                Logout</a>
            @endif
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa fa-book" aria-hidden="true"></i>Docs</a>
          </li>
        </ul>
      </div>
    </div>
</nav>