@include('includes.language')
@extends('layouts.default', ['page_header' =>'About','page_parent' =>'Home','page_parent_path' =>'/','page_path' =>'', 'page_banner' =>'sub_banner.png'])
@section('content')
    <img class="bg" src="/img/background.png" alt="" style=" width: 100%; height: 100vh; object-fit: cover;opacity: 0.5; position:fixed; left: 0; top: 0;">
    <div class="col-12 d-flex justify-content-center" style="margin-top:80px; position: absolute; top: 0;left: 0;">
        <!-- body -->
        <div class="container" style="background-color: rgba(255,255,255,0.6);">
                
            <div class="col-12">
                <div class="section-heading text-center">
                    <h6 class="tag">Rules</h6>
                    <h2 style="font-weight: 900">{!! trans('dictionary.competition') !!}{!! trans('dictionary.rule') !!}</h2>
                </div>
            </div>

            <div class="col-12 mb-5">
                <div class="pdf-viewer">
                    <iframe src="/pdf/rules_2025.pdf" width="100%" height="800px"></iframe>
                </div>
            </div>

        </div>
    </div>

   
@stop
@section('end_script')
<script>
</script>
    <script src="js/general.min.js?v={!! Config::get('app.version') !!}"></script>
@stop