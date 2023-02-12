{{--@include('includes.language')--}}
@extends('layouts.manage', ['page_header' =>'比賽管理'])
@section('content')

    <section id="manage_competition">
            
        <table id="competitionTable" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tag</th>
                    <th>Title</th>
                    <th>Datetime</th>
                    <th>Candidate</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Tag</th>
                    <th>Title</th>
                    <th>Datetime</th>
                    <th>Candidate</th>
                </tr>
            </tfoot>
        </table>

        </div>
    </section>

    <div class="modal fade" id="competition_modal" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="md-method">新增</span>{{trans('dictionary.round')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#info_tab">{{trans('dictionary.round')}}{{trans('dictionary.info')}}</a>
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
                                <label class="col-form-label">{{trans('dictionary.round')}}{{trans('dictionary.name')}}:</label>
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
                                <label class="col-form-label">{{trans('dictionary.competition')}}{{trans('dictionary.time')}}:</label>
                                <input type="text" class="form-control" id="datetimepicker_competition_time" placeholder="{{trans('dictionary.birthday')}}">
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
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-success save-btn" data-action="add" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>" data-dismiss="modal">{{trans('dictionary.save')}}</button>
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
                                    <th scope="col">Operate</th>
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
                                    <th scope="col">Operate</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-success pair-btn">{{trans('dictionary.pairs')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="judges_tab">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.add')}}{{trans('dictionary.judge')}}:</label>
                                <select class="selectpicker col-12" data-size="5"  data-live-search="true" id="select_judges" title="Choose one of the following...">
                                    <option data-subtext="School" value="1">Name</option>
                                </select>
                            </div>
                            <hr>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Operation</th>
                                    </tr>
                                </thead>
                                <tbody id="judges_list">

                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Operation</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-success judge-end-btn">評分結束</button>
                            </div>
                        </div>
                    </div>
                </div>


                            
                </div>
                <div class="modal-footer">
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
    <script src="/js/manage/competition.min.js"></script>
    

@stop
