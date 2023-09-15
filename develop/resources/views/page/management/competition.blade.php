{{--@include('includes.language')--}}
@extends('layouts.manage', ['page_header' => '比賽管理'])
@section('content')

<section id="manage_competition">

<div class="d-flex container">
    <div class="col-4" style="padding: 0; border: solid gray 1px; height: 85vh;">
        <div style="display: flex; align-items: center; justify-content: space-around; background-color: lightgray; height: 3em; paddin: 2em; font-weight: bold;"> 
            <span>{{trans('dictionary.competition_lst')}} </span>
            <button class="btn btn-success competition-add-btn" style="margin:0">{{trans('dictionary.add')}}</button>
        </div>
        <div id="competition_lst" style="overflow-y: auto">
        </div>
    </div>
    <div class="col-8" style="padding: 0; border: solid gray 1px; height: 85vh;">
        <div style="display: flex; align-items: center; justify-content: center; background-color: lightgray; height: 3em; paddin: 2em; font-weight: bold;"> {{trans('dictionary.config')}} </div>
        <div>
            <ul class="nav nav-pills mb-1 mt-2" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{trans('dictionary.competition')}}{{trans('dictionary.config')}}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link nav-details" id="pills-groups-tab" data-toggle="pill" data-target="#pills-groups" type="button" role="tab" aria-controls="pills-groups" aria-selected="false" style="display:none;">{{trans('dictionary.group')}}{{trans('dictionary.config')}}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link nav-details" id="pills-signup-tab" data-toggle="pill" data-target="#pills-signup" type="button" role="tab" aria-controls="pills-signup" aria-selected="false" style="display:none;">{{trans('dictionary.signup_lst')}}</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade  show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row">
                        <div class="form-group col-12">
                            <label class="col-form-label">{{trans('dictionary.competition')}}{{trans('dictionary.name')}}:</label>
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
                        <button class="col-12 btn btn-success mt-5 competition-save-btn">{{trans('dictionary.save')}}</button>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-groups" role="tabpanel" aria-labelledby="pills-groups-tab" style="padding: 1.5em">
                    <div class="row">
                        <div class="form-group col-9">
                            <label class="col-form-label">{{trans('dictionary.add')}}{{trans('dictionary.group')}}{{trans('dictionary.name')}}:</label>
                            <input type="text" class="form-control" id="add_group_name">
                        </div>
                        <div class="col-2 d-flex align-items-end justify-content-center">
                            <button class="btn btn-success group-add-btn">{{trans('dictionary.submit')}}</button>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{trans('dictionary.group')}}{{trans('dictionary.name')}}</th>
                                <th>{{trans('dictionary.t_write')}}</th>
                                <th>{{trans('dictionary.t_read')}}</th>
                                <th>{{trans('dictionary.t_debate')}}</th>
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
                                <th>{{trans('dictionary.group')}}{{trans('dictionary.name')}}</th>
                                <th>{{trans('dictionary.candidate')}}{{trans('dictionary.name')}}</th>
                                <th>{{trans('dictionary.school')}}{{trans('dictionary.name')}}</th>
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
                
                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex flex-column justify-content-center">
                        <span>{{trans('dictionary.account')}}:</span>
                    </div>
                    <p class="col-9" id="edit_account" style="margin: 0"></p>
                </div>

                <!-- <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.password')}}:</span>
                    </div>
                    <input class="col-7" type="text" id="edit_password" style="margin: 0"  placeholder="">
                    <button class="btn btn-primary col-2" style="margin: 0;" id="getUser">{{trans('dictionary.login')}}</button>
                </div> -->
                
                <hr style="color: black; width: 60vw;">

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex flex-column justify-content-center">
                        <span>{{trans('dictionary.email')}}:</span>
                    </div>
                    <p class="col-9" id="edit_email" style="margin: 0"></p>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.chinese')}}{{trans('dictionary.name')}}:</span>
                    </div>
                    <p class="col-9" id="edit_chinese_name" style="margin: 0"></p>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.en')}}{{trans('dictionary.name')}}:</span>
                    </div>
                    <p class="col-9" id="edit_english_name" style="margin: 0"></p>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex flex-column justify-content-center">
                        <span>{{trans('dictionary.gender')}}:</span>
                        <span style="font-size: 0.8em; color: grey;">{{trans('dictionary.note_birthday')}}</span>
                    </div>
                    <select class="selectpicker col-9" id="edit_gender" disabled>
                        <option value="female">{{trans('dictionary.female')}}</option>
                        <option value="male">{{trans('dictionary.male')}}</option>
                        <option value="other">{{trans('dictionary.other')}}</option>
                    </select>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex flex-column justify-content-center">
                        <span>{{trans('dictionary.birthday')}}:</span>
                        <span style="font-size: 0.8em; color: grey;">{{trans('dictionary.note_birthday')}}</span>
                    </div>
                    <input class="col-9" type="date" id="edit_birthday" style="margin: 0" disabled>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.cellphone')}}:</span>
                    </div>
                    <p class="col-9" id="edit_cellphone" style="margin: 0"></p>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.wechat')}}:</span>
                    </div>
                    <p class="col-9" id="edit_wechat" style="margin: 0"></p>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.address')}}:</span>
                    </div>
                    <p class="col-9" id="edit_address" style="margin: 0"></p>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.region')}}:</span>
                    </div>
                    <p class="col-9" id="edit_region" style="margin: 0" ></p>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.school')}}:</span>
                    </div>
                    <p class="col-9" id="edit_school" style="margin: 0"></p>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.mentor')}}:</span>
                    </div>
                    <p class="col-9" id="edit_mentor" style="margin: 0"></p>
                </div>

                <hr style="color: black; width: 60vw;">

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.select')}}{{trans('dictionary.group')}}:</span>
                    </div>
                    <p class="col-9" id="edit_group"></p>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.select')}}{{trans('dictionary.date')}}:</span>
                    </div>
                    <p class="col-9" id="edit_date"></p>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.select')}}{{trans('dictionary.language')}}:</span>
                    </div>
                    <p class="col-9" id="edit_language"></p>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.select')}}{{trans('dictionary.input')}}:</span>
                    </div>
                    <p class="col-9" multiple id="edit_input">
                    </p>
                </div>

                <hr style="color: black; width: 60vw;">

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.proof')}}:</span>
                    </div>
                    <input type="checkbox" id="edit_noproof" style="margin: 0" disabled>
                    <label for="edit_noproof">&ensp;{{trans('dictionary.note_proof')}}</label>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <img src="" id="competition_img" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                </div>


                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.invoice_name')}}:</span>
                    </div>
                    <p class="col-9" id="edit_invoice_name" style="margin: 0"></p>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.invoice_no')}}:</span>
                    </div>
                    <p class="col-9" id="edit_invoice_no" style="margin: 0"></p>
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
