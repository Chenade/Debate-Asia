{{--@include('includes.language')--}}
@extends('layouts.manage', ['page_header' =>'比賽管理'])
@section('content')

    <section id="manage_session">
        <div class="container">
            <div class="d-flex">
                <div class="col-6">
                    <h5 style="margin: 0 0 0 5px;">{{trans('dictionary.select')}}{{trans('dictionary.competition')}}：</h5>
                    <select class="selectpicker col-12" id="select_competition" title="Choose one of the following..." style="margin-bottom: 5px;">
                    </select>
                </div>
                <div class="col-6">
                    <h5 style="margin: 0 0 0 5px;">{{trans('dictionary.select')}}{{trans('dictionary.group')}}：</h5>
                    <select class="selectpicker col-12" id="select_groups" title="Choose one of the following..." style="margin-bottom: 5px;">
                    </select>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-6">
                    <h5 style="margin: 0 0 0 5px;">{{trans('dictionary.select')}}{{trans('dictionary.session')}}：</h5>
                    <select class="selectpicker col-12" id="select_session" title="Choose one of the following..." style="margin-bottom: 5px;">
                    </select>
                </div>
                <div class="col-6 d-flex justify-content-end align-items-center">
                    <button style="display:none;" class="btn btn-primary mx-1 my-0" id="download-competition-btn" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>">下載比賽文稿</button>
                    <button style="display:none;" class="btn btn-primary mx-1 my-0" id="download-groups-btn" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>">下載組別文稿</button>
                    <button style="display:none;" class="btn btn-warning my-0" id="end-rounds-btn" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>">結束所有回合</button>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col-3">正方名稱</th>
                        <th scope="col">畫面</th>
                        <th scope="col">狀態</th>
                        <th scope="col"></th>
                        <th scope="col">狀態</th>
                        <th scope="col">畫面</th>
                        <th scope="col-3">反方名稱</th>
                        </tr>
                    </thead>
                    <tbody id="session_list">
        
                    </tbody>
                    <tfoot>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col-3">正方名稱</th>
                        <th scope="col">畫面</th>
                        <th scope="col">狀態</th>
                        <th scope="col"></th>
                        <th scope="col">狀態</th>
                        <th scope="col">畫面</th>
                        <th scope="col-3">反方名稱</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

    
    <div class="modal fade" id="article_modal" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="md-method">查看</span>選手狀態 </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#article_tab">{{trans('dictionary.pos')}}{{trans('dictionary.candidate')}}</a>
                    </li>
                    <li class="nav-item com-detail">
                        <a id="candidate-nav" class="nav-link" data-toggle="tab" href="#candidates_tab">{{trans('dictionary.neg')}}{{trans('dictionary.candidate')}}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="article_tab">
                        <div class="d-flex flex-wrap">
                            <div class="col-12 col-lg-4" style="padding: 30px;">
                                <div><img src="" width=250 height=150 alt="camera" id="a_camera"/></div>
                                <h6>{{trans('dictionary.pos')}}{{trans('dictionary.name')}}：<span id="a_name" class="info"></span></h6>
                                <h6>{{trans('dictionary.pos')}}{{trans('dictionary.school')}}：<span id="a_school" class="info"></span></h6>
                                <h6>{{trans('dictionary.pos')}}{{trans('dictionary.status')}}：<span id="a_status" class="info"></span></h6>
                                <h6>{{trans('dictionary.lastUpdate')}}{{trans('dictionary.time')}}：<span id="a_updated_at" class="info"></span></h6>
                            </div>
                            <div class="col-12 col-lg-8">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{trans('dictionary.pos')}}{{trans('dictionary.argument')}}:</label>
                                        <textarea class="info" rows="8" cols="15" id="a_0" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{trans('dictionary.pos')}}{{trans('dictionary.rebuttal')}}:</label>
                                        <textarea class="info" rows="8" cols="15" id="a_1" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="candidates_tab">
                        <div class="d-flex flex-wrap">
                            <div class="col-12 col-lg-4" style="padding: 30px;">
                                <div><img src="" width=250 height=150 alt="camera" id="neg_camera"/></div>
                                <h6>{{trans('dictionary.neg')}}{{trans('dictionary.name')}}：<span id="neg_name" class="info"></span></h6>
                                <h6>{{trans('dictionary.neg')}}{{trans('dictionary.school')}}：<span id="neg_school" class="info"></span></h6>
                                <h6>{{trans('dictionary.neg')}}{{trans('dictionary.status')}}：<span id="neg_status" class="info"></span></h6>
                                <h6>{{trans('dictionary.lastUpdate')}}{{trans('dictionary.time')}}：<span id="neg_updated_at" class="info"></span></h6>
                            </div>
                            <div class="col-12 col-lg-8">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{trans('dictionary.neg')}}{{trans('dictionary.argument')}}:</label>
                                        <textarea class="info" rows="8" cols="15" id="neg_0" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{trans('dictionary.neg')}}{{trans('dictionary.rebuttal')}}:</label>
                                        <textarea class="info" rows="8" cols="15" id="neg_1" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="download-articles-btn">
                        下載場次文稿
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="judge_modal" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="md-method">查看</span>評委反饋</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#pos_tab">{{trans('dictionary.pos')}}{{trans('dictionary.candidate')}}</a>
                        </li>
                        <li class="nav-item com-detail">
                            <a id="candidate-nav" class="nav-link" data-toggle="tab" href="#neg_tab">{{trans('dictionary.neg')}}{{trans('dictionary.candidate')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="pos_tab">
                        </div>
                        <div class="tab-pane" id="neg_tab">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('end_script')

    <link rel="stylesheet" href="/lib/DataTables/datatables.min.css">

    <script src="/lib/DataTables/datatables.min.js"></script>
    <script src="/js/lib/moment.min.js"></script>
    <script src="/js/lib/moment-timezone.min.js"></script>

    <!-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>  -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.0/jspdf.debug.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.2.0/jspdf.umd.min.js" integrity="sha512-YnVU8b8PyEw7oHtil6p9au8k/Co0chizlPltAwx25CMWX6syRiy24HduUeWi/WpBbJh4Y4562du0CHAlvnUeeQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jspdf-customfonts@0.0.4-rc.4/dist/jspdf.customfonts.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> -->
    <script src="https://unpkg.com/docx"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <!-- <script src="/lib/jsPDF-v.1.4.0/KAIU-normal.js"></script> -->

    <script src="/js/lib/jquery-ui.min.js"></script>
    <script src="/js/lib/jquery.ui.touch-punch.min.js"></script>
    <script src="/js/general.min.js"></script>
    <script src="/js/manage/session.min.js"></script>

@stop

