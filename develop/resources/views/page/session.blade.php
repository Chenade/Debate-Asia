@include('includes.language')
@extends('layouts.default', ['page_header' =>'About','page_parent' =>'Home','page_parent_path' =>'/','page_path' =>'', 'page_banner' =>'sub_banner.png'])
@section('content')
    <img class="bg" src="/img/background.png" alt="" style=" width: 100%; height: 100vh; object-fit: cover;opacity: 0.5;">
    <!-- body -->
    <div class="col-12" style="margin-top:50px; position: absolute; top: 0;left: 0;min-height: 100vh; overflow-y: auto; overflow-x: hidden;">
        <div class="col-12 d-flex flex-wrap justify-content-around" style="height: 200px;">
            <div class="col-12 col-sm-6  col-lg-2" style="background-color: white"></div>
            <div class="col-12 col-sm-6  col-lg-2" style="background-color: gray"></div>
            <div class="col-12 col-sm-12 col-lg-4" style="background-color: black"></div>
            <div class="col-12 col-sm-6  col-lg-2" style="background-color: gray"></div>
            <div class="col-12 col-sm-6  col-lg-2" style="background-color: white"></div>
        </div>
        <div id="stage0" class="col-12 d-flex flex-wrap justify-content-around mt-1" style="min-height: 61vh">
            <div class="d-flex justify-content-center">
            <iframe allowfullscreen autoplay
                height=450 width=800 
                src='https://player.youku.com/embed/XNTkzMzUwMTYyNA==' 
                frameborder=0 ></iframe>
            </div>
        </div>
        <div id="stage3" class="col-12 d-flex flex-wrap justify-content-around mt-1" style="min-height: 61vh; display:none;">
            <div class="col-6" style="background-color: white">
            <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#info_tab">{{trans('dictionary.competition')}}{{trans('dictionary.info')}}</a>
                    </li>
                    <li class="nav-item com-detail">
                        <a id="candidate-nav" class="nav-link" data-toggle="tab" href="#candidates_tab">{{trans('dictionary.candidate')}}{{trans('dictionary.manage')}}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="info_tab">
                        <div class="col-12">
                            <textarea disabled
                                rows="15" 
                                class="col-12 mt-3" 
                                style="font-size: medium; resize: none; background-color: gray">
                            </textarea>
                        </div>
                    </div>
                    <div class="tab-pane" id="candidates_tab">
                        <div class="col-12">
                            <textarea disabled
                                rows="15" 
                                class="col-12 mt-3" 
                                style="font-size: medium; resize: none; background-color: gray">
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <textarea rows="15" class="col-6" style="font-size: medium; resize: none; background-color: gray"></textarea>
        </div>
    </div>
@stop
@section('end_script')
    <script src="/js/general.min.js?v={{Config::get('app.version')}}"></script>
    <script src="/js/session.min.js?v={{Config::get('app.version')}}"></script>
@stop