@extends('master')
@section('title')
<title>Home</title>
@endsection
@section('style')
<style>
</style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-evenly" style="margin-top:10px">
            <div class="col" style="margin-top:10px">
                <div class="circle">
                    <a href="{{route('webmail.index')}}" class="link_circle" style="color:white;">
                        <i class="fa fa-envelope icon_center"><br>Webmail</i>
                    </a>
                </div>
            </div>
            <div class="col" style="margin-top:10px">
                <div class="circle">
                    <a href="{{route('webtel.index')}}" class="link_circle" style="color:white;">
                        <i class="fa fa-phone icon_center"><br>Webtel</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection