<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @yield('title')
  <script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
  
    <!-- fontawesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    {{-- <script src="{{ url('assets/js/jquery-3.7.1.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{ url('public/new_assets/css/style.css') }}" /> --}}

    {{-- datatables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
  
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css" /> --}}

    <style>
  
      .circle {
          display: flex;
          margin:auto;
          justify-content: center;
          align-items: center;
          width: 300px;
          height: 300px;
          background-color: red;
          border-radius: 50%;
          color: white;
          font-size: 24px;
          position: relative;
      }
    
      .icon_center {
          font-size: 48px;
          text-align: center;
      }
    
      .link_circle{
          color:white;
      }
    
      .link_circle:hover{
          color:blueviolet;
      }
    </style>
</head>
@yield('style')
<body class="">
<div class="wrapper">
@include('template.header')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
    @yield('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  </div>
  <!-- /.content-footer -->
  @include('template.footer')
</div>

    <!-- Option 1: Bootstrap Bundle with Popper Datatables-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
      toastr.options.timeOut = 1000;
    </script>
@yield('script')
</body>
</html>
