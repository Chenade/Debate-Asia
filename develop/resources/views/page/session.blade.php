@include('includes.language')
@extends('layouts.default', ['page_header' =>'About','page_parent' =>'Home','page_parent_path' =>'/','page_path' =>'', 'page_banner' =>'sub_banner.png'])
@section('content')
    <img class="bg" src="/img/background.png" alt="" style=" width: 100%; height: 100vh; object-fit: cover;opacity: 0.5; position:fixed; left: 0; top: 0;">
    <!-- body -->
    <div class="col-12" style="margin-top:50px; position: absolute; top: 0;left: 0;min-height: 100vh; overflow-y: auto; overflow-x: hidden;">
        <div class="col-12 d-flex flex-wrap justify-content-around" style="min-height: 200px;">
            <div id="pos_box" class="col-12 col-sm-6 col-lg-2" style="background-color: white; margin: 0; padding: 0">  </div>
            <div class="col-12 col-sm-6 col-lg-2 d-flex flex-column justify-content-start align-items-around" style="padding:10px;background-color: lightgray; height: 225px;" id="size_default">
                <p class="roles"><span class="badge badge-secondary"  style="margin-top: 35px; font-size: 14px;">{{trans('dictionary.pos')}}：</span></p>
                <h4 id="a_name" class="mt-3 mb-1"></h4>
                <h5 id="a_school" class="mt-1"></h5>
            </div>
            <div class="col-12 col-sm-12 col-lg-4 d-flex flex-column align-items-center justify-content-around" style="background-color: black; min-height 225px;">
                <h3 style="color: white;" id="tag" class="mt-3 mb-1"></h3>
                <div class="col-2"><hr></div>
                <h4 style="color: white;" class="countDown mt-1 align-center">{{trans('dictionary.competition')}}{{trans('dictionary.countdown')}}：<span id="CountDownTime"></span></h4>
                <h4 style="color: white;" class="roles mt-1 align-center"><span id="curStage"></span>{{trans('dictionary.section')}}，{{trans('dictionary.t_remain')}}：<span id="remainTime"></span></h4>
            </div>
            <div class="col-12 col-sm-6 col-lg-2 d-flex flex-column justify-content-start align-items-around" style="padding:10px;background-color: lightgray;height: 225px;">
                <p class="roles"><span class="badge badge-secondary"  style="margin-top: 35px; font-size: 14px;">{{trans('dictionary.neg')}}：</span></p>
                <h4 id="b_name" class="mt-3 mb-1"></h4>
                <h5 id="b_school" class="mt-1"></h5>
            </div>
            <div id="neg_box" class="col-12 col-sm-6  col-lg-2" style="background-color: white; padding:0;"></div>
        </div>
        <div class="stages" id="stage0" style="display:none;">
            <div class="col-12 d-flex flex-wrap justify-content-around mt-1 align-items-center" style="min-height: 61vh">
                <div class="col-12 col-lg-8 d-flex justify-content-center">
                    <iframe id="videos" allowfullscreen autoplay
                        height=450 width=800 
                        src='' 
                        frameborder=0 >
                    </iframe>
                </div>
                <div class="col-12 col-lg-4 d-flex flex-column justify-content-around align-items-start   ">
                    <p style="text-indent: -1em;">{{trans('rules.rv1')}}</p>
                    <p style="text-indent: -1em; margin-bottom: 2px;">{{trans('rules.rv2')}}</p>
                    <p style="text-indent: -1em; margin-bottom: 2px;">{{trans('rules.rv3')}}</p>
                    <p style="text-indent: -1em; margin-bottom: 2px;">{{trans('rules.rv4')}}</p>
                    <p style="text-indent: -1em; margin-bottom: 2px;">{{trans('rules.rv5')}}</p>
                    <p style="text-indent: -1em; margin-bottom: 2px;">{{trans('rules.rv6')}}</p>
                    <p style="text-indent: -1em;">{{trans('rules.rv7')}}</p>
                    <p style="text-indent: -1em; margin-bottom: 2px;">{{trans('rules.rv8')}}</p>
                    <button class="btn btn-success next-stage" data-stage="1">確認</button>
                </div>
                <div class="col-1"></div>
            </div>
        </div>
        <div class="stages" id="stage1" style="height: 55vh; display:none;">
            <div class="col-12 d-flex flex-wrap justify-content-around mt-1">
                <div class="col-6" style="background-color: rgba(255,255,255,0.6); height: 60vh;">
                    <ul class="nav nav-tabs">
                        <li class="nav-item" id="b_article_tab" style="display: none;">
                            <a class="nav-link" id="_b_article_tab" data-toggle="tab" href="#b_article">{{trans('dictionary.op')}}{{trans('dictionary.argument')}}</a>
                        </li>
                        <li class="nav-item" id="a_article_tab" style="display: none;">
                            <a class="nav-link" id="_a_article_tab" data-toggle="tab" href="#a_article">{{trans('dictionary.me')}}{{trans('dictionary.argument')}}</a>
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
                                    rows="15" class="col-12" 
                                    style="font-size: medium; resize: none; background-color: #F5F5F5; margin-top: 20px;">
                                </textarea>
                            <!-- </div> -->
                        </div>
                        <div class="tab-pane" id="a_article">
                            <!-- <div class="col-12"> -->
                                <textarea disabled
                                    id = "a_article_content"
                                    rows="15" class="col-12" 
                                    style="font-size: medium; resize: none; background-color: #F5F5F5; margin-top: 20px;">
                                </textarea>
                            <!-- </div> -->
                        </div>
                        <div class="tab-pane active" id="info_tab">
                            <div class="col-12" style="height: 40vh;">
                                <h3 class="mb-0">{{trans('dictionary.title')}}：</h3>
                                <div class="mt-1 d-flex flex-column" id="title">
                                    <h4 class="mt-0 mb-1" style="text-indent: 1em;">{{trans('dictionary.pos')}}：<span id="pos_title"></span></h4>
                                    <h4 class="mt-0 mb-1" style="text-indent: 1em;">{{trans('dictionary.neg')}}：<span id="neg_title"></span></h4>
                                </div>
                                <hr>
                                <h5 style="margin: 5px 0;">{{trans('dictionary.t_write')}}：<span class="t_write"></span>&ensp;{{trans('dictionary.mins')}}</h4>
                                <h5 style="margin: 5px 0;">{{trans('dictionary.t_read')}}：<span class="t_read"></span>&ensp;{{trans('dictionary.mins')}}</h4>
                                <h5 style="margin: 5px 0;">{{trans('dictionary.t_debate')}}：<span class="t_debate"></span>&ensp;{{trans('dictionary.mins')}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6" >
                    <textarea id="input"
                        rows="15" class="col-12" 
                        style="
                            margin: 20px 0;
                            font-size: medium; 
                            resize: none; 
                            background-color: white"></textarea>
                    <div class="d-flex">
                        <div class="mr-auto" style="font-weight: 700">
                            中文字數統計:&ensp;<span id="character-count" >0</span><br>
                            English word count:&ensp;<span id="words-count" >0</span>
                        </div>
                        <button id="saveArticle" class="btn btn-success">{{trans('dictionary.save')}}</button>&emsp;
                        <button id="moveStage" class="btn btn-success">{{trans('dictionary.submitEarly')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-5"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="explain_modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{trans('dictionary.t_buffer')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>{{trans('dictionary.note_buffer')}}</p>
                </div>
            </div>
        </div>
    </div>

@stop
@section('end_script')
    <script src="/js/general.min.js?v={{Config::get('app.version')}}"></script>
    <script src="/js/session.min.js?v={{Config::get('app.version')}}"></script>
@stop