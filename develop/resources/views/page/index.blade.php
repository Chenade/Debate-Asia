@include('includes.language')
@extends('layouts.default', ['page_header' =>'About','page_parent' =>'Home','page_parent_path' =>'/','page_path' =>'', 'page_banner' =>'sub_banner.png'])
@section('content')
    <img class="bg" src="/img/background.png" alt="" style=" width: 100%; height: 100vh; object-fit: cover;opacity: 0.5; position:fixed; left: 0; top: 0;">
    <div class="" style="margin-top:130px; position: absolute; top: 0;left: 0;min-height: 100vh;">
        <!-- body -->
        <div class="d-flex justify-content-center align-items-center flex-column" style="background-color: rgba(255,255,255,0.6);">
            <img src="/img/indextitle.png" />
            <h1 style="font-weight:700; margin: 0; color: rgba(150, 0, 0, 1);">亞洲思辨寫作對抗賽</h1>
            <p style="margin-top: 15px;">{{trans('dictionary.solgan1')}}</p>
            <img src="/img/qrcode_2025.jpg" style="height: 120px;" />
            <p style="margin-top: 15px;">{{trans('dictionary.solgan2')}}</p>
        </div>
    </div>
@stop
@section('end_script')
    <script src="js/general.min.js?v={{Config::get('app.version')}}"></script>
    <script src="js/index.min.js?v={{Config::get('app.version')}}"></script>
@stop