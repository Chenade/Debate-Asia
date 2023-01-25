@include('includes.language')
@extends('layouts.default', ['page_header' =>'About','page_parent' =>'Home','page_parent_path' =>'/','page_path' =>'', 'page_banner' =>'sub_banner.png'])
@section('content')
    <img class="bg" src="/img/background.png" alt="" style=" width: 100%; height: 100vh; object-fit: cover;opacity: 0.5;">
    <!-- body -->
    <div class="col-12" style="margin-top:50px; position: absolute; top: 0;left: 0;min-height: 100vh; overflow-y: auto; overflow-x: hidden;">
        <div class="col-12 d-flex flex-wrap justify-content-around" style="height: 200px;">
            <div class="col-12 col-sm-6  col-lg-2" style="background-color: white"></div>
            <div class="col-12 col-sm-6 col-lg-2" style="background-color: lightgray">
                <p class="roles"><span class="badge badge-secondary"  style="margin-top: 25px;">正方：</span></p>
                <h4 id="a_name" class="mt-3 mb-1"></h4>
                <h5 id="a_school" class="mt-1"></h5>
            </div>
            <div class="col-12 col-sm-12 col-lg-4" style="background-color: black">
                <span style="color: white;" id="remainTime"></span>
            </div>
            <div class="col-12 col-sm-6 col-lg-2" style="background-color: lightgray">
                <p class="roles"><span class="badge badge-secondary"  style="margin-top: 25px;">反方：</span></p>
                <h4 id="b_name" class="mt-3 mb-1"></h4>
                <h5 id="b_school" class="mt-1"></h5>
            </div>
            <div class="col-12 col-sm-6  col-lg-2" style="background-color: white"></div>
        </div>
        <div class="stages" id="stage0" style="display:none;">
            <div class="col-12 d-flex flex-wrap justify-content-around mt-1" style="min-height: 61vh">
                <div class="col-9 d-flex justify-content-center">
                    <iframe id="videos" allowfullscreen autoplay
                        height=450 width=800 
                        src='https://player.youku.com/embed/XNTkzMzUwMTYyNA==' 
                        frameborder=0 >
                    </iframe>
                </div>
                <div class="col-2 d-flex flex-column justify-content-end">
                    <p></p>
                    <button class="btn btn-success next-stage" data-stage="1">確認</button>
                </div>
                <div class="col-1"></div>
            </div>
        </div>
        <div class="stages" id="stage1" style="min-height: 61vh; display:none;">
            <div class="col-12 d-flex flex-wrap justify-content-around mt-1">
                <div class="col-6" style="background-color: rgba(255,255,255,0.6)">
                    <ul class="nav nav-tabs">
                        <li class="nav-item" id="b_article_tab" style="display: none;">
                            <a class="nav-link" id="_b_article_tab" data-toggle="tab" href="#b_article">{{trans('dictionary.candidate')}}{{trans('dictionary.article')}}</a>
                        </li>
                        <li class="nav-item" id="a_article_tab" style="display: none;">
                            <a class="nav-link" id="_a_article_tab" data-toggle="tab" href="#a_article">{{trans('dictionary.candidate')}}{{trans('dictionary.argument')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#info_tab">{{trans('dictionary.competition')}}{{trans('dictionary.info')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="b_article">
                            <!-- <div class="col-12"> -->
                                <textarea disabled
                                    id = "b_article_content"
                                    rows="15" class="col-12 mt-3" 
                                    style="font-size: medium; resize: none; background-color: gray">
                                </textarea>
                            <!-- </div> -->
                        </div>
                        <div class="tab-pane" id="a_article">
                            <!-- <div class="col-12"> -->
                                <textarea disabled
                                    id = "a_article_content"
                                    rows="15" class="col-12 mt-3" 
                                    style="font-size: medium; resize: none; background-color: gray">
                                </textarea>
                            <!-- </div> -->
                        </div>
                        <div class="tab-pane active" id="info_tab">
                            <div class="col-12">
                                <h3>辯題：<br><span id="title"></span></h3>
                                <hr>
                                <h5 style="margin: 5px 0;">立論時間：<span class="t_write"></span>分鐘</h4>
                                <h5 style="margin: 5px 0;">閱讀時間：<span class="t_read"></span>分鐘</h4>
                                <h5 style="margin: 5px 0;">駁論時間：<span class="t_debate"></span>分鐘</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <textarea id="input"
                    rows="15" class="col-6" 
                    style="
                        margin: 20px 0;
                        font-size: medium; 
                        resize: none; 
                        background-color: white"></textarea>
            </div>
        </div>
        <div id="stage3" style="min-height: 61vh; display:none;">
            <div class="col-12 d-flex flex-wrap justify-content-around mt-1">
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
    </div>
@stop
@section('end_script')
    <script src="/js/general.min.js?v={{Config::get('app.version')}}"></script>
    <script src="/js/session.min.js?v={{Config::get('app.version')}}"></script>
@stop