<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @yield('title')
  <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-royalcorp.png') }}">
  <script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
  
    <!-- fontawesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <!-- Bootstrap CSS -->
    <link href="{{ asset('bootstrap5/css/bootstrap.min.css')}}" rel="stylesheet"">
    
    <!-- custom css -->
    <link href="{{ asset('css/custom-detail.css') }}" rel="stylesheet">

    {{-- datatables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
  
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css" /> --}}

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
      html,body,.wrapper{
        height:100%;
      }

      .content-wrapper {
          height: 100%;
      }
      .content-footer{
          position: relative;
          bottom: 0; 
          left: 0; 
          right: 0;
      }

      .blockquote-footer {
          margin-bottom: 0 !important;
          margin-top: -3rem !important;
          width: fit-content !important;
      }
      figure {
          margin: 0 0 0 !important;
          width:100px !important;
      }

      .blockquote-footer::before {
          content: none !important;
      }
    </style>
</head>
@yield('style')
<body class="">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      @include('template.header')
    </div>
      <div class="container-fluid">
        @yield('content')
      </div><!-- /.container-fluid -->
      <div class="content-footer">
        <!-- /.content-footer -->
        @include('template.footer')
      </div>
  </div>
</div>

    <!-- Option 1: Bootstrap Bundle with Popper Datatables Debounce-->
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js')}}" ></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
    <script type="text/javascript">

      toastr.options.timeOut = 1000;
    </script>
@yield('script')
</body>
</html>
