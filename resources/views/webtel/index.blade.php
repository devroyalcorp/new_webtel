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
    <div class="row">
        <div class="col-md-12 text-center" style="margin-top:10px;">
            <p style="margin: 1px 1px 1px 0px !important;font-size:40px;font-weight: bolder;color: #6c757d;">{{Session::get('name_company') ?? ""}}</p>
        </div>
    </div>
    <div class="row justify-content-evenly" style="margin-top:20px">
        @foreach($data_companies as $key=>$v)
            <?php
            $color_background = "#4B0082";
                    switch ($v['name']) {
                        case "PT Anugerah Cemerlang Abadi":
                            $color_background = "#663399 ";
                            break;
                        case "PT Bestari Mulia":
                            $color_background = "#6495ED";
                            break;
                        case "PT Cemerlang Abadi Mulia":
                            $color_background = "#8B0000";
                            break;
                    }
            ?>
        <div class="col-md-3" style="margin-top:10px">
            <div class="circle" style="background-color:{{$color_background}}" href="{{ route('webtel.detail', ['id' => $v->id]) }}">
                <a href="{{ route('webtel.detail', ['id' => $v->id]) }}" class="link_circle" style="color:white;">
                    <i class="fa fa-phone icon_center"></i>
                </a>
            </div>
            <p class="text-center" style="font-size:20px;font-weight:bolder;">{{$v['name']}}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection