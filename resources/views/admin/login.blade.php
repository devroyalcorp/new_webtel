@extends('master')
@section('title')
<title>Login</title>
@endsection
@section('style')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
    <style>
        .content-wrapper{
            height:100%;
        }
        .logo-img-header{
            display:none !important;
        }
        .back-button-hide{
            display:block !important;
        }

        .login-button-hide{
            display:none !important;
        }

        .navbar-check{
            padding: 14px 20px 14px 20px !important;
        }

        .navbar-brand{
            margin-left: 1rem;
        }

        @media (min-width: 920px) {
            .container-fluid{
                height:90%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        @media (max-width: 1024px) {
            main{
                padding-top:3rem;
            }
        }

        small{
            margin-left: 1rem !important;
        }
    </style>
@endsection
@section('content')
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <form id="form_login" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="mb-3 d-grid align-items-center justify-content-center">
                            <img src="{{ asset('img/logo-royalcorp.png') }}" class="mx-auto rounded rounded-circle shadow" alt="royal" width="75">
                            <h4 class="text-uppercase mt-2">ROYAL CORPORATION</h4>
                        </div>

                        <div class="heading mb-2">
                            <h5>Welcome Back !</h5>
                            <span>Please login to continue</span>
                        </div>

                        <div class="actual-form">
                            <div class="form-group mb-3">
                                <div class="content d-block">
                                    <i class="lock fa fa-user"></i>
                                    <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" required>
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <div class="content d-block">
                                    <i class="lock fa fa-lock"></i>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
                                </div>
                            </div>
                            <div class=" form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="show-hide-password" onchange="showHidePassword(this, $('#password'))">
                                <label class="form-check-label position-relative font-size-12" style="transform: none;" for="show-hide-password">
                                    Show Password
                                </label>
                            </div>

                            <button type="submit" id="sign-btn-id" class="sign-btn mt-2 btn-login">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>

                <div class="carousel-container">
                    <div class="images-wrapper">
                        <img src="{{ asset('img/dirgahayu-ri-2024.gif') }}" class="bg-img-right" alt="Royal Company">
                    </div>
                    <div class="text-slider">
                        <img src="{{ asset('img/brand-all.png') }}" class="image img-1 show" alt="Royal Brands">
                        <div class="">
                            <div class="text-group mb-3">
                                <h2 class="mb-0">Jl. Raya Cimareme No 275 Padalarang - 40552</h2>
                                <h2>Tlp. +622-6866360</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script type="text/javascript">
        function showHidePassword(el, inputTarget) {
            $(inputTarget).attr('type', $(inputTarget).is(':password') ? 'text' : 'password');

            // if ($(inputTarget).attr('type') === 'password') {
            //     $(el).removeClass('fa-eye').addClass('fa-eye-slash');
            // } else {
            //     $(el).removeClass('fa-eye-slash').addClass('fa-eye');
            // }
        }

        $(document).ready(function () {
            var loading = function () {
                $('#sign-btn-id').attr('disabled', 'disabled')
                $('#sign-btn-id').val('Processing...')
            }

            var loadingDone = function (response) {
                $('#sign-btn-id').removeAttr('disabled')
                $('#sign-btn-id').val('Sign In')
            }

            $("#form_login").submit(function (e) {
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
@endsection