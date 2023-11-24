@include('includes.language')
@extends('layouts.default', ['page_header' =>'About','page_parent' =>'Home','page_parent_path' =>'/','page_path' =>'', 'page_banner' =>'suneg_banner.png'])
@section('content')
    <img class="bg" src="/img/background.png" alt="" style=" width: 100%; height: 100vh; object-fit: cover;opacity: 0.5; position:fixed; left: 0; top: 0;">
    <!-- body -->
    <div class="col-12" style="margin-top:60px; position: absolute; top: 0;left: 0;min-height: 100vh; overflow-y: auto; overflow-x: hidden;">
        <div class="stages" id="stage1" style="">
            <div class="col-12 d-flex flex-wrap justify-content-around mt-1">
                <div class="col-6" style="background-color: rgba(255,255,255,0.6); ">
                    <ul class="nav nav-tabs">
                        <li class="nav-item" id="pos_argue_tab" style="">
                            <a class="nav-link" id="_pos_argue_tab" data-toggle="tab" href="#pos_argue">{{trans('dictionary.pos')}}{{trans('dictionary.argument')}}</a>
                        </li>
                        <li class="nav-item" id="pos_rebuttal_tab" style="">
                            <a class="nav-link" id="_pos_rebuttal_tab" data-toggle="tab" href="#pos_rebuttal">{{trans('dictionary.pos')}}{{trans('dictionary.rebuttal')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#info_tab">{{trans('dictionary.competition')}}{{trans('dictionary.info')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pos_score_tab">{{trans('dictionary.grade')}}{{trans('dictionary.standard')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="pos_argue">
                            <!-- <div class="col-12"> -->
                                <textarea disabled
                                    id = "pos_argue_content"
                                    rows="12" class="col-12 inputTextbox" 
                                    style="font-size: medium; resize: none; background-color: #F5F5F5; margin-top: 20px;">
                                </textarea>
                            <!-- </div> -->
                        </div>
                        <div class="tab-pane" id="pos_rebuttal">
                            <!-- <div class="col-12"> -->
                                <textarea disabled
                                    id = "pos_rebuttal_content"
                                    rows="12" class="col-12 inputTextbox" 
                                    style="font-size: medium; resize: none; background-color: #F5F5F5; margin-top: 20px;">
                                </textarea>
                            <!-- </div> -->
                        </div>
                        <div class="tab-pane active" id="info_tab">
                            <div class="col-12">
                                <h5 class="mb-0 mt-3">{{trans('dictionary.pos')}}{{trans('dictionary.title')}}：<span class="info-pos-title"></span></h5>
                                <h5 class="mb-0 mt-1">{{trans('dictionary.neg')}}{{trans('dictionary.title')}}：<span class="info-neg-title"></span></h5>
                                <hr>
                                <h6 style="margin: 5px 0;">{{trans('dictionary.t_write')}}：<span class="t_write"></span>{{trans('dictionary.mins')}}</h6>
                                <h6 style="margin: 5px 0;">{{trans('dictionary.t_read')}}：<span class="t_read"></span>{{trans('dictionary.mins')}}</h6>
                                <h6 style="margin: 5px 0;">{{trans('dictionary.t_debate')}}：<span class="t_debate"></span>{{trans('dictionary.mins')}}</h6>
                            </div>
                        </div>
                        <div class="tab-pane" id="pos_score_tab">
                            <table class="col-12">
                                <tr>
                                    <td class="col-4"><h6>{{trans('rules.score_1_title')}}（200{{trans('rules.score')}}）</h6></td>
                                    <td class="col-8"><p class="mb-0">{{trans('rules.score_1_content')}}</p class="mb-0"></td>
                                </tr>
                                <tr>
                                    <td class="col-4"><h6>{{trans('rules.score_2_title')}}（200{{trans('rules.score')}}）</h6></td>
                                    <td class="col-8"><p class="mb-0">{{trans('rules.score_2_content')}}</p class="mb-0"></td>
                                </tr>
                                <tr>
                                    <td class="col-4"><h6>{{trans('rules.score_3_title')}}（50{{trans('rules.score')}}）</h6></td>
                                    <td class="col-8"><p class="mb-0">{{trans('rules.score_3_content')}}</p class="mb-0"></td>
                                </tr>
                                <tr>
                                    <td class="col-4"><h6>{{trans('rules.score_4_title')}}（50{{trans('rules.score')}}）</h6></td>
                                    <td class="col-8"><p class="mb-0">{{trans('rules.score_4_content')}}</p class="mb-0"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6" >
                    <div class="col-12 row">
                        <div class="col-6">
                            <p>{{trans('dictionary.pos')}}{{trans('dictionary.grade')}}：</p>
                        </div>
                        <div class="col-6 row">
                            <div><p>{{trans('rules.sum_score')}}</p></div>
                            <div class="col-9 d-flex">
                                <div class="col-8" style="padding: 0"><input type="number" min="0" max="500" class="pos_score col-12 inputbox" data-id="5" disabled></div>
                                <div class="col-4 d-flex align-items-center" style="padding: 0">/500</div>
                            </div>
                        </div>
                    </div>
                    <table class="col-12">
                        <tr>
                            <td class="col-3">{{trans('rules.score_1_title')}}</td>
                            <td class="col-3">{{trans('rules.score_2_title')}}</td>
                            <td class="col-3">{{trans('rules.score_3_title')}}</td>
                            <td class="col-3">{{trans('rules.score_4_title')}}</td>
                        </tr>
                        <tr>
                            <td class="col-3">
                                <div class="col-12 d-flex">
                                    <div class="col-8" style="padding: 0"><input type="number" min="0" max="200" class="pos_score col-12 inputbox" data-id="1"></div>
                                    <div class="col-4 d-flex align-items-center" style="padding: 0">/200</div>
                                </div>
                            </td>
                            <td class="col-3">
                                <div class="col-12 d-flex">
                                    <div class="col-8" style="padding: 0"><input type="number" min="0" max="200" class="pos_score col-12 inputbox" data-id="2"></div>
                                    <div class="col-4 d-flex align-items-center" style="padding: 0">/200</div>
                                </div>
                            </td>
                            <td class="col-3">
                                <div class="col-12 d-flex">
                                    <div class="col-8" style="padding: 0"><input type="number" min="0" max="50" class="pos_score col-12 inputbox" data-id="3"></div>
                                    <div class="col-4 d-flex align-items-center" style="padding: 0">/50</div>
                                </div>
                            </td>
                            <td class="col-3">
                                <div class="col-12 d-flex">
                                    <div class="col-8" style="padding: 0"><input type="number" min="0" max="50" class="pos_score col-12 inputbox" data-id="4"></div>
                                    <div class="col-4 d-flex align-items-center" style="padding: 0">/50</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <p>{{trans('dictionary.pos')}}{{trans('dictionary.comment')}}：</p>
                    <div class="d-flex align-items-end">
                        <div class="col-11">
                            <textarea id="pos_comment"
                            rows="7" class="col-12 inputTextbox" 
                            style="
                                font-size: medium; 
                                resize: none; 
                                background-color: white"></textarea>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success save-btn" data-type="pos" id="save_pos">{{trans('dictionary.submit')}}</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <hr>
        <div class="stages" id="neg" style="">
            <div class="col-12 d-flex flex-wrap justify-content-around mt-1">
                <div class="col-6" style="background-color: rgba(255,255,255,0.6); ">
                    <ul class="nav nav-tabs">
                        <li class="nav-item" id="neg_argue_tab" style="">
                            <a class="nav-link" id="_neg_argue_tab" data-toggle="tab" href="#neg_argue">{{trans('dictionary.neg')}}{{trans('dictionary.argument')}}</a>
                        </li>
                        <li class="nav-item" id="neg_rebuttal_tab" style="">
                            <a class="nav-link" id="_neg_rebuttal_tab" data-toggle="tab" href="#neg_rebuttal">{{trans('dictionary.neg')}}{{trans('dictionary.rebuttal')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#neg_info_tab">{{trans('dictionary.competition')}}{{trans('dictionary.info')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#neg_score_tab">{{trans('dictionary.grade')}}{{trans('dictionary.standard')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="neg_argue">
                            <!-- <div class="col-12"> -->
                                <textarea disabled
                                    id = "neg_argue_content"
                                    rows="12" class="col-12 inputTextbox" 
                                    style="font-size: medium; resize: none; background-color: #F5F5F5; margin-top: 20px;">
                                </textarea>
                            <!-- </div> -->
                        </div>
                        <div class="tab-pane" id="neg_rebuttal">
                            <!-- <div class="col-12"> -->
                                <textarea disabled
                                    id = "neg_rebuttal_content"
                                    rows="12" class="col-12 inputTextbox" 
                                    style="font-size: medium; resize: none; background-color: #F5F5F5; margin-top: 20px;">
                                </textarea>
                            <!-- </div> -->
                        </div>
                        <div class="tab-pane" id="neg_info_tab">
                            <div class="col-12">
                                <h5 class="mb-0 mt-3">{{trans('dictionary.pos')}}{{trans('dictionary.title')}}：<span class="info-pos-title"></span></h5>
                                <h5 class="mb-0 mt-1">{{trans('dictionary.neg')}}{{trans('dictionary.title')}}：<span class="info-neg-title"></span></h5>
                                <hr>
                                <h6 style="margin: 5px 0;">{{trans('dictionary.t_write')}}：<span class="t_write"></span>{{trans('dictionary.mins')}}</h6>
                                <h6 style="margin: 5px 0;">{{trans('dictionary.t_read')}}：<span class="t_read"></span>{{trans('dictionary.mins')}}</h6>
                                <h6 style="margin: 5px 0;">{{trans('dictionary.t_debate')}}：<span class="t_debate"></span>{{trans('dictionary.mins')}}</h6>
                            </div>
                        </div>
                        <div class="tab-pane active" id="neg_score_tab">
                            <table class="col-12">
                                <tr>
                                    <td class="col-4"><h6>{{trans('rules.score_1_title')}}（200{{trans('rules.score')}}）</h6></td>
                                    <td class="col-8"><p class="mb-0">{{trans('rules.score_1_content')}}</p class="mb-0"></td>
                                </tr>
                                <tr>
                                    <td class="col-4"><h6>{{trans('rules.score_2_title')}}（200{{trans('rules.score')}}）</h6></td>
                                    <td class="col-8"><p class="mb-0">{{trans('rules.score_2_content')}}</p class="mb-0"></td>
                                </tr>
                                <tr>
                                    <td class="col-4"><h6>{{trans('rules.score_3_title')}}（50{{trans('rules.score')}}）</h6></td>
                                    <td class="col-8"><p class="mb-0">{{trans('rules.score_3_content')}}</p class="mb-0"></td>
                                </tr>
                                <tr>
                                    <td class="col-4"><h6>{{trans('rules.score_4_title')}}（50{{trans('rules.score')}}）</h6></td>
                                    <td class="col-8"><p class="mb-0">{{trans('rules.score_4_content')}}</p class="mb-0"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6" >
                    <div class="col-12 row">
                        <div class="col-6">
                            <p>{{trans('dictionary.neg')}}{{trans('dictionary.grade')}}：</p>
                        </div>
                        <div class="col-6 row">
                            <div><p>{{trans('rules.sum_score')}}</p></div>
                            <div class="col-9 d-flex">
                                <div class="col-8" style="padding: 0"><input type="number" min="0" max="500" class="neg_score col-12 inputbox" data-id="5" disabled></div>
                                <div class="col-4 d-flex align-items-center" style="padding: 0">/500</div>
                            </div>
                        </div>
                    </div>
                    
                    <table class="col-12">
                        <tr>
                            <td class="col-2">{{trans('rules.score_1_title')}}</td>
                            <td class="col-2">{{trans('rules.score_2_title')}}</td>
                            <td class="col-2">{{trans('rules.score_3_title')}}</td>
                            <td class="col-2">{{trans('rules.score_4_title')}}</td>
                        </tr>
                        <tr>
                            <td class="col-2">
                                <div class="col-12 d-flex">
                                    <div class="col-8" style="padding: 0"><input type="number" min="0" max="200" class="neg_score col-12 inputbox" data-id="1"></div>
                                    <div class="col-4 d-flex align-items-center" style="padding: 0">/200</div>
                                </div>
                            </td>
                            <td class="col-2">
                                <div class="col-12 d-flex">
                                    <div class="col-8" style="padding: 0"><input type="number" min="0" max="200" class="neg_score col-12 inputbox" data-id="2"></div>
                                    <div class="col-4 d-flex align-items-center" style="padding: 0">/200</div>
                                </div>
                            </td>
                            <td class="col-2">
                                <div class="col-12 d-flex">
                                    <div class="col-8" style="padding: 0"><input type="number" min="0" max="50" class="neg_score col-12 inputbox" data-id="3"></div>
                                    <div class="col-4 d-flex align-items-center" style="padding: 0">/50</div>
                                </div>
                            </td>
                            <td class="col-2">
                                <div class="col-12 d-flex">
                                    <div class="col-8" style="padding: 0"><input type="number" min="0" max="50" class="neg_score col-12 inputbox" data-id="4"></div>
                                    <div class="col-4 d-flex align-items-center" style="padding: 0">/50</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <p>{{trans('dictionary.neg')}}{{trans('dictionary.comment')}}：</p>
                    <div class="d-flex align-items-end">
                        <div class="col-11">
                            <textarea id="neg_comment"
                            rows="7" class="col-12 inputTextbox" 
                            style="
                                font-size: medium; 
                                resize: none; 
                                background-color: white"></textarea>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success save-btn" data-type="neg" id="save_neg">{{trans('dictionary.submit')}}</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="mb-5"></div>
    </div>
@stop
@section('end_script')
    <script src="/js/general.min.js?v={{Config::get('app.version')}}"></script>
    <script src="/js/grading.min.js?v={{Config::get('app.version')}}"></script>
@stop