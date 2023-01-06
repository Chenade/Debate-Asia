@include('includes.language')
@extends('layouts.default', ['page_header' =>'About','page_parent' =>'Home','page_parent_path' =>'/','page_path' =>'', 'page_banner' =>'sub_banner.png'])
@section('content')
    <img class="bg" src="/img/background.png" alt="" style=" width: 100%; height: 100vh; object-fit: cover;opacity: 0.5;">
    <div class="" style="margin-top:130px; position: absolute; top: 0;left: 0;min-height: 100vh;">
        <!-- body -->
        <div class="d-flex justify-content-center align-items-center flex-column">
            <img src="/img/indextitle.png" />
            <h1 style="font-weight:700; margin: 0; color: rgba(150, 0, 0, 1);">亚洲思辨写作对抗赛</h1>
            <p style="margin-top: 15px;">用中文思辨，用写作看世界</p>
            <img src="/img/qrcode_wechat.png" style="height: 120px;" />
            <p style="margin-top: 15px;">扫码联系主办方，加入比赛资讯微信群</p>
        </div>
    </div>
@stop
@section('end_script')
    <script src="js/general.min.js?v={{Config::get('app.version')}}"></script>
    <script src="js/pindex.min.js?v={{Config::get('app.version')}}"></script>
@stop