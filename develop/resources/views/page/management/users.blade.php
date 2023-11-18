{{--@include('includes.language')--}}
@extends('layouts.manage', ['page_header' =>'最新消息'])
@section('content')

    <section id="manage_member">
            
        <table id="usersTable" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <!-- <th>Type</th> -->
                    <th>School</th>
                    <th>Name</th>
                    <th>Account</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <!-- <th>Type</th> -->
                    <th>School</th>
                    <th>Name</th>
                    <th>Account</th>
                    <th>Role</th>
                </tr>
            </tfoot>
        </table>

        </div>
    </section>

    <div class="modal fade" id="users_modal" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="md-method">新增</span>成員 </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="col-form-label">{{trans('dictionary.authority')}}:</label>
                            <select class="col-12 selectpicker nopadding" id="edit_authority">
                                <option value="1">選手</option>
                                <option value="2">裁判</option>
                                <option value="7">工作人員</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="col-form-label">{{trans('dictionary.email')}}:</label>
                            <input type="text" class="form-control" id="edit_email">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.account')}}:</label>
                                <input type="text" class="form-control" id="edit_account">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.password')}}:</label>
                                <input type="text" class="form-control" id="edit_password"  >
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-wrap">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.school_cn')}}:</label>
                                <input type="text" class="form-control" id="edit_school_cn">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.school_zh')}}:</label>
                                <input type="text" class="form-control" id="edit_school_zh"  >
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.name_cn')}}:</label>
                                <input type="text" class="form-control" id="edit_name_cn">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.name_zh')}}:</label>
                                <input type="text" class="form-control" id="edit_name_zh"  >
                            </div>
                        </div>
                    </div>
                   
                    <div class="d-flex flex-wrap">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.cellphone')}}:</label>
                                <input type="text" class="form-control" id="edit_cellphone">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.birthday')}}:</label>
                                <input type="text" class="form-control" id="datetimepicker_birthday" placeholder="{{trans('dictionary.birthday')}}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.wechat')}}:</label>
                                <input type="text" class="form-control" id="edit_wechat">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">Whatsapp:</label>
                                <input type="text" class="form-control" id="edit_whatsapp"  >
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">Line:</label>
                                <input type="text" class="form-control" id="edit_linid">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-danger delete-btn" data-action="delete" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>">{{trans('dictionary.delete')}}</button>
                        <button type="button" class="btn btn-primary lock-btn" data-action="lock" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>">{{trans('dictionary.lock')}}</button>
                    </div>
                    <button type="button" class="btn btn-success save-btn" data-action="add" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>" data-dismiss="modal">{{trans('dictionary.save')}}</button>
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
    <script src="/js/manage/users.min.js"></script>
    

@stop
