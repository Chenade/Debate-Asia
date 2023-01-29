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
                    <h2 style="font-weight: 900">{{trans('dictionary.competition')}}{{trans('dictionary.rule')}}</h2>
                </div>
            </div>

            <div class="d-flex flex-wrap align-items-center" style="padding: 0 90px 0 110px; margin-bottom: 50px;">

                <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify;">{{trans('rules.r1')}}</p>

                <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify;">{{trans('rules.r2')}}</p>

                <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify;"> {{trans('rules.r3')}}</p>

                <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify;"> {{trans('rules.r4')}}</p>

                <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify;"> {{trans('rules.r5')}}</p>

                <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify;"> {{trans('rules.r6')}}</p>

                <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify; margin :0;"> {{trans('rules.r7')}} <br> 
                {{trans('rules.r71')}} </p>
                    <p style="color: rgba(150, 0, 0, 1); font-weight: 700;"> 
                        {{trans('rules.r72')}}<br> 
                        {{trans('rules.r73')}}<br> 
                        {{trans('rules.r74')}}</p>

                <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify;"> {{trans('rules.r8')}}<br>
                    {{trans('rules.r81')}}
                    <br>
                    {{trans('rules.r82')}}
                    <br>
                    <p>
                        {{trans('rules.ps1')}}<br>
                        {{trans('rules.ps2')}}
                    </p>

            </div>
        </div>
    </div>

   
@stop
@section('end_script')
<script>
</script>
    <script src="js/general.min.js?v={{Config::get('app.version')}}"></script>
@stop