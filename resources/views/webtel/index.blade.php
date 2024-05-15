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
        @foreach($data_companies as $key=>$v)
        <div class="col-md-3" style="margin-top:10px">
            <div class="circle">
                <a href="{{ route('webtel.detail', ['id' => $v->id]) }}" class="link_circle" style="color:white;">
                    <i class="fa fa-phone icon_center"></i>
                </a>
            </div>
            <p class="text-center">{{$v['name']}}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection