{{--@include('includes.language')--}}
@extends('layouts.manage', ['page_header' =>'最新消息'])
@section('content')

    <section id="manage_member">
            
        <table id="newsTable" class="display" style="width:100%">
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

    <div class="modal fade" id="news_modal" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="md-method">新增</span>最新消息</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="col-form-label">{{trans('dictionary.category')}}:</label>
                            <select class="col-12 selectpicker nopadding" id="edit_category">
                                <option value="1">活動資訊</option>
                                <option value="2">小P部落格</option>
                            </select>
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
                            <label class="col-form-label">{{trans('dictionary.content')}}:</label>
                            <textarea style="white-space: pre-wrap;" id="edit_content" name="edit_content" rows="5" cols="33"></textarea>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.link')}}:</label>
                                <input type="text" class="form-control" id="edit_link">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.link_alt')}}:</label>
                                <input type="text" class="form-control" id="edit_link_alt"  >
                            </div>
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
                        <div class="col-6 d-flex flex-column justift-content-around">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.ord')}}:</label>
                                <input type="number" class="form-control" id="edit_ord" min="1" max="99" value="1">
                            </div>
                            <hr>
                            <div class="form-group image-box">
                                <label class="col-form-label">{{trans('dictionary.uploadThumbnail')}}:</label>
                                <input type="file" id="file-t" name='file-t'>
                                <input type="hidden" id="file-tcount" value='0'>
                            </div>
                        </div>
                        <!-- <div class="col-5 image-box">
                            
                        </div> -->
                        <div class="col-6 image-box">
                            <div class="d-flex flex-wrap">
                                <div class="col-12 d-flex flex-column align-items-center" style="margin: 10px; padding: 10px; border-radius: 10px; background-color: #e5e5e5;">
                                    <h6>縮圖</h6>
                                    <div id="display-thumb" class="d-flex justify-content-center align-items-center" style="height: 180px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="col-6 image-box">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('dictionary.uploadImage')}}:</label>
                                <input type="file" id="file" name='file'>
                                <input type="hidden" id="filecount" value='0'>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 image-box">
                        <div class="d-flex" style="overflow-y: auto;" id="display-img"></div>
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
    <script src="/js/manage/news.min.js"></script>
    

@stop
