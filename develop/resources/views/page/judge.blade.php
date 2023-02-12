@include('includes.language')
@extends('layouts.default', ['page_header' =>'About','page_parent' =>'Home','page_parent_path' =>'/','page_path' =>'', 'page_banner' =>'sub_banner.png'])
@section('content')
    <img class="bg" src="/img/background.png" alt="" style=" width: 100%; height: 100vh; object-fit: cover;opacity: 0.5;">
    <!-- body -->
    <div class="col-12 d-flex flex-wrap justify-content-around" style="margin-top:50px; position: absolute; top: 0;left: 0;min-height: 100vh;  overflow-y: auto; overflow-x: hidden;">
        <div class="col-12 col-sm-6 col-lg-5">
            <h3 class="mb-0">{{trans('dictionary.judge')}}{{trans('dictionary.info')}}</h3>
            <div class="mb-0">
                <div class="col-11 d-flex flex-column" style="background-color: lightgrey; height: 100px; margin: 10px;">
                    <h4 class="mt-3 mb-1">
                        <span id="name"></span>
                        <span style="font-size: 0.8em; color: gray;">(Account: <span id="account"></span>)</span>
                    </h4>
                    <h5 class="mt-1 mb-1" id="school_name"></h5>
                </div>
            </div>
            <h3 class="mb-0 mt-3">{{trans('dictionary.future')}}{{trans('dictionary.competition')}}</h3>
            <div id="upcomingEvent" style="height: 51vh; overflow-y: auto; overflow-x: hidden;">
                <!-- <div class="col-11" style="background-color: black; height: 180px; margin: 10px;"></div> -->
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-7">
            <h3 class="mb-0">{{trans('dictionary.past')}}{{trans('dictionary.competition')}}</h3>
                <div id="pastEvent" style="height: 72vh; overflow-y: auto; overflow-x: hidden;">
                    <!-- <div class="col-12" style="background-color: black; height: 220px; margin: 10px;"></div> -->
                </div>
        </div>
    </div>
@stop
@section('end_script')
    <script src="/js/general.min.js?v={{Config::get('app.version')}}"></script>
    <script src="/js/judge.min.js?v={{Config::get('app.version')}}"></script>
@stop