{{--@include('includes.language')--}}
@extends('layouts.manage', ['page_header' => '比賽管理'])
@section('content')

<section id="manage_competition">

<div class="d-flex container">
    <div class="col-4" style="padding: 0; border: solid gray 1px; height: 85vh;">
        <div style="display: flex; align-items: center; justify-content: space-around; background-color: lightgray; height: 3em; paddin: 2em; font-weight: bold;"> 
            <span>Competition </span>
            <button class="btn btn-success competition-add-btn" style="margin:0">Add</button>
        </div>
        <div id="competition_lst" style="overflow-y: auto">
        </div>
    </div>
    <div class="col-8" style="padding: 0; border: solid gray 1px; height: 85vh;">
        <div style="display: flex; align-items: center; justify-content: center; background-color: lightgray; height: 3em; paddin: 2em; font-weight: bold;"> Competition Setting </div>
        <div>
            <ul class="nav nav-pills mb-1 mt-2" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">比賽設定</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link nav-details" id="pills-groups-tab" data-toggle="pill" data-target="#pills-groups" type="button" role="tab" aria-controls="pills-groups" aria-selected="false" style="display:none;">組別設定</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link nav-details" id="pills-signup-tab" data-toggle="pill" data-target="#pills-signup" type="button" role="tab" aria-controls="pills-signup" aria-selected="false" style="display:none;">報名清單</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade  show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row">
                        <div class="form-group col-12">
                            <label class="col-form-label">{{trans('dictionary.competition_name')}}:</label>
                            <input type="hidden" class="form-control" id="competition_id">
                            <input type="text" class="form-control" id="edit_competition_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.start_date')}}:</label>
                                <input type="text" class="form-control datetimepicker" id="edit_competition_start" placeholder="{{trans('dictionary.start_date')}}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.end_date')}}:</label>
                                <input type="text" class="form-control datetimepicker" id="edit_competition_end" placeholder="{{trans('dictionary.end_date')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="col-12 btn btn-success mt-5 competition-save-btn">SAVE</button>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-groups" role="tabpanel" aria-labelledby="pills-groups-tab" style="padding: 1.5em">
                    <div class="row">
                        <div class="form-group col-9">
                            <label class="col-form-label">{{trans('dictionary.add')}}{{trans('dictionary.group_name')}}:</label>
                            <input type="text" class="form-control" id="add_group_name">
                        </div>
                        <div class="col-2 d-flex align-items-end justify-content-center">
                            <button class="btn btn-success group-add-btn">Submit</button>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Group Name</th>
                                <th>立論時間</th>
                                <th>閱讀時間</th>
                                <th>駁論時間</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody id="group_lst">
                        <tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="pills-signup" role="tabpanel" aria-labelledby="pills-signup-tab" style="padding: 1.5em; width:100%">
                    <table id="signupTable" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Group Name</th>
                                <th>選手姓名</th>
                                <th>所在學校</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</section>

<div class="modal fade" id="competition_modal" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">報名資訊</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                
                <!-- <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="col-form-label">{{trans('dictionary.start_date')}}:</label>
                            <input type="text" class="form-control" id="datetimepicker_start_date" placeholder="{{trans('dictionary.start_date')}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="col-form-label">{{trans('dictionary.end_date')}}:</label>
                            <input type="text" class="form-control" id="datetimepicker_end_date" placeholder="{{trans('dictionary.end_date')}}">
                        </div>
                    </div>
                </div> -->

                <div class="row">
                    <div class="form-group col-12">
                        <img src="" id="competition_img" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                </div>

            <div class="modal-footer">
                <button style="margin:0" class="btn btn-success approval-btn" data-action="approval" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>" data-dismiss="modal">{{trans('dictionary.approve')}}</button>
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
