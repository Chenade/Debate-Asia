{{--@include('includes.language')--}}
@extends('layouts.manage', ['page_header' =>'關於小P'])
@section('content')

    <section id="manage_member">
        <div class="container">
            <div class="col-12">
                <div class="form-group">
                    <label class="col-form-label">{{trans('dictionary.content')}}:</label>
                    <textarea name="htmleditor"></textarea>
                    <!-- <textarea id="edit_content" name="edit_content" rows="20" cols="33"></textarea> -->
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-success save-btn col-10" data-action="add" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>" data-dismiss="modal">{{trans('dictionary.save')}}</button>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="col-form-label">{{trans('dictionary.uploadImage')}}:</label>
                    <input type="file" id="file" name='file'>
                    <input type="hidden" id="filecount" value='0'>
                </div>
            </div>
            <div class="image-box">
                <div class="d-flex flex-wrap" id="display-img"></div>
            </div>
        </div>
    </section>

@stop
@section('end_script')

<link rel="stylesheet" href="/lib/DataTables/datatables.min.css">
    <link rel="stylesheet" href="/lib/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/lib/datetimepicker/datetimepicker.min.css">

    <link rel="stylesheet" href="/lib/flatpickr/flatpickr.min.css">
    <script src="/lib/flatpickr/flatpickr.min.js"></script>

    <script src="/lib/ckeditor/ckeditor.js"></script>
    <script src="/lib/ckeditor/config.js"></script>
    
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
    <script src="/js/manage/course.min.js"></script>
    

@stop
