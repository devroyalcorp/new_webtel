
<nav class="navbar navbar-expand-lg navbar-dark bg-light" style="background-color: #4B0082 !important">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="#">
          <img src="{{ asset('img/royalcorp_1.jpg')}}" alt="" width="30" height="24" class="d-inline-block align-text-top">
        </a>
        @if(Session::get('login_status'))
          <a class="navbar-brand" href="#"">Web Telekomunikasi</a>
        @else
          <a class="navbar-brand" href="{{route('webtel.index')}}">Web Telekomunikasi</a>
        @endif
        <ul class="navbar-nav" style="border-left:3px solid #6c757d;margin-left:auto;">
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
            <a class="nav-link disabled" href="#"><i class="fa fa-book" aria-hidden="true"></i>Docs</a>
          </li>
        </ul>
        <div class="d-flex">
            {{-- <p style="margin: 1px 1px 1px 0px !important;font-size:25px;font-weight: bolder;color: #6c757d;">{{Session::get('name_company') ?? ""}}</p> --}}
        </div>
      </div>
    </div>
</nav>