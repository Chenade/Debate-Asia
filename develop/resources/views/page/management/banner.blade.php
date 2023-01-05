{{--@include('includes.language')--}}
@extends('layouts.manage', ['page_header' =>'首頁橫幅'])
@section('content')

    <section id="manage_banner">
            
        <table id="bannerTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Start At</th>
                    <th>End At</th>
                    <th>Order</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Start At</th>
                    <th>End At</th>
                    <th>Order</th>
                    <th>Operation</th>
                </tr>
            </tfoot>
        </table>

        </div>
    </section>

    <div class="modal fade" id="banner_modal" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="md-method">新增</span>首頁橫幅</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="col-form-label">{{trans('dictionary.title')}}:</label>
                            <input type="text" class="form-control" id="edit_title">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="col-form-label">{{trans('dictionary.link')}}:</label>
                            <input type="text" class="form-control" id="edit_link">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.start_at')}}:</label>
                                <input type="text" class="form-control" id="datetimepicker_start" placeholder="{{trans('dictionary.time')}}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.end_at')}}:</label>
                                <input type="text" class="form-control" id="datetimepicker_end" placeholder="{{trans('dictionary.time')}}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.ord')}}:</label>
                                <input type="number" class="form-control" id="edit_ord" min="1" max="99" value="1">
                            </div>
                        </div>
                        <div class="col-6 image-box">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.uploadImage')}}:</label>
                                <input type="file" id="file" name='file'>
                                <input type="hidden" id="filecount" value='0'>
                            </div>
                        </div>
                    </div>
                    <div class="image-box">
                        <div class="d-flex flex-wrap" id="display-img"></div>
                    </div>
                </div>
                <div class="modal-footer">
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
    <script src="/js/manage/banner.min.js"></script>
    

@stop
