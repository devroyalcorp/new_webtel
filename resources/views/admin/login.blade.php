@extends('master')
@section('title')
<title>Login</title>
@endsection
@section('style')
<style>
</style>
@endsection
@section('content')
    <div class="container-fluid">
        <section class="bg-light py-3 py-md-5">
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="card border border-light-subtle rounded-3 shadow-sm">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                    <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Login</h2>
                    <form id="form_login" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row gy-2 overflow-hidden">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                <input type="username" class="form-control" name="username" id="username" placeholder="Username" required>
                                <label for="username" class="form-label">Username</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                                <label for="password" class="form-label">Password</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-grid my-3">
                                <button class="btn btn-primary btn-lg btn-login" type="submit">Log in</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            var loading = function () {
                $('.btn-simpan').attr('disabled', 'disabled')
                $('.btn-simpan').val('Login...')
            }

            var loadingDone = function (response) {
                $('.btn-simpan').removeAttr('disabled')
                $('.btn-simpan').val('Simpan')
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
                        // loading()
                    },
                    success: function (response) {
                        // loadingDone()
                        if (response.status == 202) {
                            toastr.success(response.msg, response.title)
                            location.href = '/' 
                        } else {
                            toastr.error(response.msg, response.title)
                        }
                    },
                    error: function (response) {
                        loadingDone()
                        toastr.error(response.msg, response.title)
                    },
                    complete: function (response) {}
                });
            });

        });
    </script>
@endsection