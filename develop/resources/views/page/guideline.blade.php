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
                <h6 class="tag">Guideline</h6>
                <h2>{{trans('dictionary.competition')}}{{trans('dictionary.borcher')}}</h2>
            </div>
        </div>

        <div class="d-flex flex-wrap align-items-center ">
            <iframe 
                    src="/pdf/guidelines.pdf#toolbar=0"
                    width="100%" height="500px">
            </iframe>
        </div>

        <div style="margin-top:20px;"></div>

    </div>

   
@stop
@section('end_script')
    <!-- <script src="js/general.min.js?v={{Config::get('app.version')}}"></script> -->
@stop