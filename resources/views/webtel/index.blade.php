@extends('master')
@section('title')
<title>Home</title>
@endsection
@section('style')
<link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">

<style>
    .content-wrapper{
        height:100%;
      }
      @media (min-width: 760px) {
        .container-fluid{
            height:90%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
      }

</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 text-center" style="margin-top:10px;">
            <p style="margin: 1px 1px 1px 0px !important;font-size:40px;font-weight: bolder;color: #6c757d;">{{Session::get('name_company') ?? ""}}</p>
        </div>
    <div class="row justify-content-evenly" style="margin-top:20px">
        @foreach($data_companies as $key=>$v)
            <?php
            $color_background = "#4B0082";
            $url_img = asset('img/logo-royalcorp.png');
                    switch ($v['name']) {
                        case "PT Anugerah Cemerlang Abadi":
                            $color_background = "#663399 ";
                            $url_img = asset('img/aca_logo.png');
                            break;
                        case "PT Bestari Mulia":
                            $color_background = "#6495ED";
                            $url_img = asset('img/bm_logo.png');
                            break;
                        case "PT Cemerlang Abadi Mulia":
                            $color_background = "#8B0000";
                            $url_img = asset('img/cam_logo.png');
                            break;
                    }
            ?>
        <div class="col-md-3" style="margin-top:10px">
            <div class="circle" href="{{ route('webtel.detail', ['id' => $v->id]) }}">
                <a href="{{ route('webtel.detail', ['id' => $v->id]) }}" class="text-center" style="color:white;text-align:center;">
                    <img style="display:block;" src="{{ $url_img }}" class="mx-auto rounded rounded-circle shadow center" alt="royal" width="45%" height="55%">
                </a>
            </div>
            <p class="text-center" style="font-size:30px;font-weight:bolder;margin-top:20px">{{$v['name']}}</p>
        </div>
        @endforeach
    </div>

    </div>
</div>
@endsection