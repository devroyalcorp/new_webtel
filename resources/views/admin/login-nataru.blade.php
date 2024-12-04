<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Royal Corporation Authentication Page" name="description" />
    <meta content="Royal Corporation" name="author" />
    <title>Royal Authentication Page</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('royal-auth-page-master/assets/images/favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{asset('royal-auth-page-master/assets/images/favicon.ico')}}" type="image/x-icon">

    <!-- Bootstrap Css -->
    <link href="{{asset('royal-auth-page-master/assets/libs/bootstrap/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <!-- Slick -->
    <link href="{{asset('royal-auth-page-master/assets/libs/slick/slick.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('royal-auth-page-master/assets/libs/slick/slick-theme.css')}}" rel="stylesheet" type="text/css">

    <!-- Font awesome -->
    <link href="{{asset('royal-auth-page-master/assets/libs/fontawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <!-- App style -->
    <link href="{{asset('royal-auth-page-master/assets/css/login.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('royal-auth-page-master/assets/css/newlogin.css')}}" rel="stylesheet" type="text/css">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
  
    <style>
        .bg-body {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            z-index: -1; /* Ensure content appears above the video */
        }

        .video-container {
            height: 300px;
            width: 300px;
            overflow: hidden;
            position: fixed;
            z-index: -1;

        }
        
        .video-container video {
            min-width: 100%;
            min-height: 100%;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            z-index: -1;
        }

        .video-background {
            width: 100%;
            height: 100%;
            position: fixed;
            left: 0;
            top: 0;
            z-index: -1;
            object-fit: cover;
        }
    </style>
</head>
<body class="bg-body">
    <div class="video-container">
        <video autoplay muted loop no-controls>
            <source src="{{ url('royal-auth-page-master/assets/images/nataru.mp4') }}" type="video/mp4" />
        </video>
    </div>
    <div class=" main py-3 px-4 px-sm-5 ">
        <div class="row w-100 d-flex align-items-center justify-content-center mx-auto">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-2 text-center">
                <div class="dropdown-center" data-bs-theme="light">
                    <button class="btn btn-secondary rounded-pill w-75 shadow shadow-md dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        All Site
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="https://portal.royalcorp.co.id">PORTAL APPS</a></li>
                        <li><a class="dropdown-item" href="https://ems.royalcorp.co.id/login">EMS (Employee Management System)</a></li>
                        <li><a class="dropdown-item" href="https://ats.royalcorp.co.id">ATS (Attendance Timesheet
                                System)</a></li>
                        <li><a class="dropdown-item active" href="https://webtel.royalcorp.co.id" 
                            aria-current="true">WEBTEL</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mb-3 min-vh-100">
            <div class="col-lg-6 col-md-12 ps-5 left-content-wrapper d-none d-lg-block my-auto">
                <div class="d-flex align-items-start flex-column left-content">
                    <div class="mb-auto p-2">
                        <a href="{{ route('webtel.index') }}"><img class="rounded-pill img-fluid img-company" src="{{asset('royal-auth-page-master/assets/images/logo-royalcorp.png')}}"
                            alt="Royal Company"></a>
                        <div class="mt-3">
                            <h1 class="app-title">WebTel (Web Telecommunication)</h1>
                            <h3 class="app-subtitle">Royal Corporation</h3>
                        </div>
                    </div>
                    <div class="p-2 d-grid">
                        <b>Our Brands:</b>
                        <img src="{{asset('royal-auth-page-master/assets/images/brand-all.png')}}" class="img-fluid img-brand" alt="Royal Brands">
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 my-auto right-content-wrapper">
                <div class="d-flex align-items-center justify-content-md-center flex-column right-content">
                    <div class="banner-wrapper my-4 shadow shadow-md d-none d-lg-block brand-slider">
                        <img class="rounded mx-auto d-block img-fluid img-banner"
                            src="{{asset('royal-auth-page-master/assets/images/slider/slide-company.jpg')}}" alt="Royal Banner">
                        <img class="rounded mx-auto d-block img-fluid img-banner"
                            src="{{asset('royal-auth-page-master/assets/images/slider/i-royale-v2.jpg')}}" alt="Royal Banner">
                    </div>
                    <div class="alt-banner-wrapper d-lg-none d-block text-center mb-3">
                        <a href="{{ route('webtel.index') }}"><img class="rounded-pill img-fluid img-company shadow shadow-md mb-2"
                            src="{{asset('royal-auth-page-master/assets/images/logo-royalcorp.png')}}" alt="Royal Company"></a>
                        <h5 class="text-capitalize">ROYAL CORPORATION</h5>
                    </div>
                    <div class="input-form w-100">
                        <form class="row g-3 d-flex align-items-center justify-content-center" id="form_signin" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-xl-6 col-md-8">
                                <div class="col-md-12 mb-2">
                                    <label for="input-username" class="form-label">Username <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="input-username" class="form-control rounded-pill shadow"
                                        placeholder="ex: john.doe" name="username" required>
                                    <div class="invalid-feedback">
                                        This field is required!
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label for="input-password" class="form-label">Password <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control input-password-addon rounded-pill shadow"
                                            id="input-password" placeholder="Your password" aria-label="Your password"
                                            aria-describedby="basic-addon2" name="password" required>
                                        <div class="invalid-feedback">
                                            This field is required!
                                        </div>
                                        <span class="input-group-text group-password bg-transparent border-0"
                                            id="basic-addon2">
                                            <i class="fa fa-eye-slash font-size-16" id="toggle-password"
                                                onclick="showHidePassword('#input-password')"></i>
                                        </span>
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-12 text-center my-2">
                                    <button type="submit" id="sign-button-id-v2" class="btn btn-primary w-50 rounded-pill shadow">Log in</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('royal-auth-page-master/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('royal-auth-page-master/assets/libs/slick/slick.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js')}}" ></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
    <script type="text/javascript">

      toastr.options.timeOut = 1000;
    </script>

    <script type="text/javascript">
        function showHidePassword(targetId) {
            const el = $('#toggle-password');
            const inputTarget = $(targetId);

            if ($(inputTarget).attr('type') === 'password') {
                $(el).removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                $(el).removeClass('fa-eye').addClass('fa-eye-slash');
            }

            $(inputTarget).attr('type', $(inputTarget).is(':password') ? 'text' : 'password');
        }

        $(document).ready(function () {
            $('.brand-slider').slick({
                autoplay: true,
                autoplaySpeed: 5000,
                arrows: true,
                dots: true,
            });
            
            var loading = function () {
                $('#sign-button-id-v2').attr('disabled', 'disabled')
                $('#sign-button-id-v2').val('Processing...')
            }

            var loadingDone = function (response) {
                $('#sign-button-id-v2').removeAttr('disabled')
                $('#sign-button-id-v2').val('Log in')
            }

            $("#form_signin").submit(function (e) {
                e.preventDefault();
                var sendData = new FormData(this);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: "{{ route('admin.logincheck') }}",
                    method: 'POST',
                    data: sendData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    beforeSend: function () {
                        loading()
                    },
                    success: function (response) {
                        loadingDone()
                        if (response.status == 202) {
                            toastr.success(response.msg, response.title)
                            location.href = '/webtel/companies/'+response.data; 
                        } else {
                            toastr.error(response.msg, response.title)
                        }
                    },
                    error: function (response) {
                        loadingDone()
                        toastr.error(response.msg, response.title)
                    },
                    complete: function (response) {
                        loadingDone()
                    }
                });
            });

        });
    </script>
</body>

</html>