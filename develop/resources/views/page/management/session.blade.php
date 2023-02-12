{{--@include('includes.language')--}}
@extends('layouts.manage', ['page_header' =>'比賽管理'])
@section('content')

    <section id="manage_session">
        <div class="container">
            <div class="col-12"><h5 style="margin-bottom: 5px;">{{trans('dictionary.select')}}{{trans('dictionary.round')}}：</h5></div>
            <div class="col-12 d-flex flex-wrap">
                <select class="selectpicker col-12" id="select_competition" title="Choose one of the following...">
                    <option value="1">[test_tag] test_title</option>
                </select>
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
                        <a class="nav-link active" data-toggle="tab" href="#article_tab">{{trans('dictionary.candidate')}}{{trans('dictionary.article')}}</a>
                    </li>
                    <!-- <li class="nav-item com-detail">
                        <a id="candidate-nav" class="nav-link" data-toggle="tab" href="#candidates_tab">{{trans('dictionary.candidate')}}{{trans('dictionary.manage')}}</a>
                    </li> -->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="article_tab">
                        <div class="d-flex flex-wrap">
                            <div class="col-12 col-lg-4" style="padding: 30px;">
                                <div><img src="" width=250 height=150 alt="camera" id="a_camera"/></div>
                                <h6>{{trans('dictionary.pos')}}{{trans('dictionary.name')}}：<span id="a_name"></span></h6>
                                <h6>{{trans('dictionary.pos')}}{{trans('dictionary.school')}}：<span id="a_school"></span></h6>
                                <h6>{{trans('dictionary.pos')}}{{trans('dictionary.status')}}：<span id="a_status"></span></h6>
                                <h6>{{trans('dictionary.lastUpdate')}}{{trans('dictionary.time')}}：<span id="a_updated_at"></span></h6>
                            </div>
                            <div class="col-12 col-lg-8">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{trans('dictionary.pos')}}{{trans('dictionary.argument')}}:</label>
                                        <textarea rows="8" cols="15" id="a_1"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{trans('dictionary.pos')}}{{trans('dictionary.rebuttal')}}:</label>
                                        <textarea rows="8" cols="15" id="a_2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-wrap">
                        <div class="col-12 col-lg-4" style="padding: 30px;">
                                <div><img src="" width=250 height=150 alt="camera" id="b_camera"/></div>
                                <h6>{{trans('dictionary.neg')}}{{trans('dictionary.name')}}：<span id="b_name"></span></h6>
                                <h6>{{trans('dictionary.neg')}}{{trans('dictionary.school')}}：<span id="b_school"></span></h6>
                                <h6>{{trans('dictionary.neg')}}{{trans('dictionary.status')}}：<span id="b_status"></span></h6>
                                <h6>{{trans('dictionary.lastUpdate')}}{{trans('dictionary.time')}}：<span id="b_updated_at"></span></h6>
                            </div>
                            <div class="col-12 col-lg-8">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{trans('dictionary.neg')}}{{trans('dictionary.argument')}}:</label>
                                        <textarea rows="8" cols="15" id="b_1"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{trans('dictionary.neg')}}{{trans('dictionary.rebuttal')}}:</label>
                                        <textarea rows="8" cols="15" id="b_2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success save-btn" data-action="add" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>" data-dismiss="modal">{{trans('dictionary.save')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="session_modal" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="md-method">新增</span>比賽組別 </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#info_tab">{{trans('dictionary.session')}}{{trans('dictionary.info')}}</a>
                    </li>
                    <li class="nav-item com-detail">
                        <a id="candidate-nav" class="nav-link" data-toggle="tab" href="#candidates_tab">{{trans('dictionary.candidate')}}{{trans('dictionary.manage')}}</a>
                    </li>
                    <li class="nav-item com-detail">
                        <a id="judge-nav" class="nav-link" data-toggle="tab" href="#judges_tab">{{trans('dictionary.judge')}}{{trans('dictionary.manage')}}</a>
                    </li>
                    
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="info_tab">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.tag')}}:</label>
                                <input type="text" class="form-control" id="edit_tag">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.title')}}:</label>
                                <input type="text" class="form-control" id="edit_title">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.session')}}{{trans('dictionary.time')}}:</label>
                                <input type="text" class="form-control" id="datetimepicker_session_time" placeholder="{{trans('dictionary.birthday')}}">
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="col-form-label">{{trans('dictionary.t_write')}}:</label>
                                    <input type="number" class="form-control" id="edit_t_write">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="col-form-label">{{trans('dictionary.t_read')}}:</label>
                                    <input type="number" class="form-control" id="edit_t_read">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="col-form-label">{{trans('dictionary.t_debate')}}:</label>
                                    <input type="number" class="form-control" id="edit_t_debate">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="candidates_tab">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.add')}}{{trans('dictionary.candidate')}}:</label>
                                <select class="selectpicker col-12" data-size="5"  data-live-search="true" id="select_candidates"  title="Choose one of the following...">
                                    <option data-subtext="School" value="0">Name</option>
                                </select>
                            </div>
                            <hr>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">Room ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Score</th>
                                    </tr>
                                </thead>
                                <tbody id="candidate_list">

                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th scope="col">Room ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Score</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="judges_tab">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.add')}}{{trans('dictionary.judge')}}:</label>
                                <select class="selectpicker col-12" data-size="5"  data-live-search="true" id="select_judges"  title="Choose one of the following...">
                                    <option data-subtext="School" value="1">Name</option>
                                </select>
                            </div>
                            <hr>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Score</th>
                                    </tr>
                                </thead>
                                <tbody id="judges_list">

                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Score</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>


                            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pair-btn">{{trans('dictionary.pairs')}}</button>
                    <button type="button" class="btn btn-success save-btn" data-action="add" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>" data-dismiss="modal">{{trans('dictionary.save')}}</button>
                    <button type="button" class="btn btn-danger delete-btn" data-action="delete" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>">{{trans('dictionary.delete')}}</button>
                </div>
            </div>
        </div>
    </div>



@stop
@section('end_script')

    <link rel="stylesheet" href="/lib/DataTables/datatables.min.css">
    <link rel="stylesheet" href="/lib/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/lib/datetimepicker/datetimepicker.min.css">

    <link rel="stylesheet" href="/lib/flatpickr/flatpickr.min.css">
    <script src="/lib/flatpickr/flatpickr.min.js"></script>

    <script src="/lib/DataTables/datatables.min.js"></script>
    <!-- <script src="js/lib/jquery.fileDownload.min.js"></script> -->
    <script src="/js/lib/moment.min.js"></script>
    <script src="/js/lib/moment-timezone.min.js"></script>

    <script src="/lib/daterangepicker/daterangepicker.js"></script>
    <script src="/lib/datetimepicker/moment-with-locales.min.js"></script>
    <script src="/lib/datetimepicker/datetimepicker.min.js"></script>
    <script src="/lib/jstree/jstree.min.js"></script>
    <script src="/lib/jstree/jstree-grid.js"></script>

    <script src="/js/lib/jquery-ui.min.js"></script>
    <script src="/js/lib/jquery.ui.touch-punch.min.js"></script>
    <script src="/lib/bootstrap/js/bootbox.min.js"></script>
    <script src="/js/general.min.js"></script>
    <script src="/js/manage/session.min.js"></script>
    

@stop
