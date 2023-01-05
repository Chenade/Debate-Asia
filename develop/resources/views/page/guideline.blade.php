@include('includes.language')
@extends('layouts.default', ['page_header' =>'About','page_parent' =>'Home','page_parent_path' =>'/','page_path' =>'', 'page_banner' =>'sub_banner.png'])
@section('content')
    <div class="container" style="margin-top:80px; min-height: 100vh;">
        <!-- body -->
        <div class="carousel-container">
            <div class="owl-carousel owl-theme"></div>
        </div>

        <div class="col-12">
            <div class="section-heading text-center">
                <h6 class="tag">Guidelines</h6>
                <h2>{{trans('dictionary.competition')}}{{trans('dictionary.borcher')}}</h2>
            </div>
        </div>

        <div class="d-flex flex-wrap align-items-center ">
            <embed src="/pdf/guidelines.pdf#toolbar=0" type="application/pdf" width="100%" height="500px" />. 
        </div>

        <div style="margin-top:20px;"></div>

    </div>

   
@stop
@section('end_script')
<script>
// <style>
// html, body {height:100%; overflow:hidden}
// body {overflow:auto; -webkit-overflow-scrolling:touch}
// </style>
    // $(document).ready(function() {
    //     $('body').css('height', '100%');
    //     $('html').css('height', '100%');
    //     $('body').css('overflow', 'hidden');
    //     $('html').css('overflow', 'hidden');

    //     $('body').css('overflow', 'auto');
    //     $('body').css('-webkit-overflow-scrolling', '-webkit-overflow-scrolling');

    //     $('.language').on('click', function () {
    //         var val = $(this).attr('id');
    //         window.location.href = '/language/' + val;
    //     });
    // });    
</script>
    <!-- <script src="js/general.min.js?v={{Config::get('app.version')}}"></script> -->
@stop