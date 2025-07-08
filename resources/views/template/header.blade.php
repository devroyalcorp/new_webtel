<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #d1e7dd; color: #32294B;">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse navbar-check" id="navbarTogglerDemo01" style="padding: 0 20px; color: #32294B;">
            {{-- @if(Session::get('login_status') == true && (Session::get('user_session_details')['username'] !== 'admin.it' && Session::get('user_session_details')['username'] !== 'reynold'))
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('img/logo-royalcorp.png')}}" alt="" width="60" height="60" class="d-inline-block align-text-top logo-img-header">
                </a>
                <figure>
                    <blockquote class="blockquote">
                        <a class="navbar-brand" style="font-size: 22px; font-weight: bolder;" href="#">Webtel</a>
                    </blockquote>
                    <figcaption class="blockquote-footer text-end">
                        <a class="navbar-brand text-muted" style="font-size:15px;" href="#"><br><small style="padding-left: 0.8rem !important;">version 2.0</small></a>
                    </figcaption>
                </figure>
            @else --}}
                <a class="navbar-brand" href="{{route('webtel.index')}}">
                    <img src="{{ asset('img/logo-royalcorp.png')}}" alt="" width="60" height="60" class="d-inline-block align-text-top logo-img-header">
                </a>
                <figure>
                    <blockquote class="blockquote">
                        <a class="navbar-brand" style="font-size: 22px; font-weight: bolder;" href="{{route('webtel.index')}}">Webtel</a>
                    </blockquote>
                    <figcaption class="blockquote-footer text-end">
                        <a class="navbar-brand text-muted" style="font-size:15px;" href="{{route('webtel.index')}}"><br><small style="padding-left: 0.8rem !important;">version 2.0</small></a>
                    </figcaption>
                  </figure>
            {{-- @endif --}}
            <ul class="navbar-nav" style="border-left: 2px solid #32294B; margin-left: auto; padding-left: 5px;">
                <li class="nav-item pr-5">
                    @if(!Session::get('login_status'))
                        <a class="nav-link login-button-hide" href="{{route('admin.login')}}"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
                        <a class="nav-link back-button-hide" style="display: none;" href="{{route('webtel.index')}}"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Back</a>
                    @else
                        <a class="nav-link" href="{{route('admin.logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                    @endif
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#"><i class="fa fa-book me-1" aria-hidden="true"></i> Help</a>
                </li>
            </ul>
            <div class="d-flex">
                {{-- <p style="margin: 1px 1px 1px 0px !important;font-size:25px;font-weight: bolder;color: #32294B;">{{Session::get('name_company') ?? ""}}</p> --}}
            </div>
        </div>
    </div>
</nav>