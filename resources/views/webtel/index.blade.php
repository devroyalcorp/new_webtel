@extends('master')
@section('title')
<title>Home</title>
@endsection
@section('style')
<style>
    .circle {
        display: flex;
        margin:auto;
        justify-content: center;
        align-items: center;
        width: 200px;
        height: 200px;
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

    .text {
        font-size: 24px;
    }
    .link_circle{
        color:white;
    }

    .link_circle:hover{
        color:blueviolet;
    }
</style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-evenly" style="margin-top:10px">
            <div class="col-md-3" style="margin-top:10px">
                <div class="circle">
                    <a href="#" class="link_circle" style="color:white;">
                        <i class="fa fa-phone icon_center"></i>
                    </a>
                </div>
                <p class="text-center">PT ROYAL ABADI SEJAHTERA</p>
            </div>
            <div class="col-md-3" style="margin-top:10px">
                <div class="circle">
                    <a href="#" class="link_circle" style="color:white;">
                        <i class="fa fa-phone icon_center"></i>
                    </a>
                </div>
                <p class="text-center">PT BESTARI MULIA</p>
            </div>
            <div class="col-md-3" style="margin-top:10px">
                <div class="circle">
                    <a href="#" class="link_circle" style="color:white;">
                        <i class="fa fa-phone icon_center"></i>
                    </a>
                </div>
                <p class="text-center">PT CEMERLANG ABADI MULIA</p>
            </div>
            <div class="col-md-3" style="margin-top:10px">
                <div class="circle">
                    <a href="#" class="link_circle" style="color:white;">
                        <i class="fa fa-phone icon_center"></i>
                    </a>
                </div>
                <p class="text-center">PT ANUGRAH CEMERLANG ABADI</p>
            </div>
        </div>
    </div>
@endsection

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>