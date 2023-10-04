@include('includes.language')
@extends('layouts.default', ['page_header' =>'About','page_parent' =>'Home','page_parent_path' =>'/','page_path' =>'', 'page_banner' =>'sub_banner.png'])
@section('content')
    <img class="bg" src="/img/background.png" alt="" style=" width: 100%; height: 100vh; object-fit: cover;opacity: 0.5; position:fixed; left: 0; top: 0;">
    <div class="col-12 d-flex justify-content-center" style="margin-top:80px; position: absolute; top: 0;left: 0;">
        <!-- body -->
        <div class="container" style="background-color: rgba(255,255,255,0.9);">
                
            <div class="col-12">
                <div class="section-heading text-center">
                    <h6 class="tag">Competition Registration</h6>
                    <h2 style="font-weight: 900">{{trans('dictionary.signup')}}</h2>
                </div>
            </div>

            <div class="d-flex flex-wrap align-items-start flex-column" style="padding: 0 90px 0 110px; margin-bottom: 50px;">

                <p style="color: black; font-weight:900; text-align: center; color: #B20E17; width:100%; font-size: 1.4em;">「{{trans('dictionary.solgan1')}}」</p>

                <p style="color: black; font-weight:500; text-align:justify;"> {{trans('dictionary.host')}}：{{trans('dictionary.DebateAsia')}}</p>

                <p style="color: black; font-weight:500; text-align:justify;"> {{trans('dictionary.note_signup')}}</p>

                <hr style="color: black; width: 60vw;">

                <p style="color: black; font-weight:500; text-align:justify;">{{trans('dictionary.account_condition')}}</p>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex flex-column justify-content-center">
                        <span>{{trans('dictionary.account')}}<span class="redStar">*</span>：</span>
                    </div>
                    <input class="col-9 charnum mandatory" type="text" id="edit_account" style="margin: 0; padding-right:30px;"  autocomplete="off">
                    <span class="charCount" style="  position: absolute; top: 50%;right: 25px;transform: translateY(-50%);color: gray;">0 / 12</span>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.password')}}<span class="redStar">*</span>：</span>
                    </div>
                    <input class="col-9 charnum mandatory" type="password" id="edit_password" style="margin: 0; padding-right:30px;"  placeholder=""  autocomplete="off">
                    <span class="charCount" style="  position: absolute; top: 50%;right: 25px;transform: translateY(-50%);color: gray;">0 / 12</span>

                    <!-- <button class="btn btn-primary col-2" style="margin: 0;" id="getUser">{{trans('dictionary.login')}}</button> -->
                </div>
                
                <hr style="color: black; width: 60vw;">

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex flex-column justify-content-center">
                        <span>{{trans('dictionary.email')}}<span class="redStar">*</span>：</span>
                    </div>
                    <input class="col-9 mandatory" type="email" id="edit_email" style="margin: 0"  autocomplete="off">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.chinese')}}{{trans('dictionary.name')}}<span class="redStar">*</span>：</span>
                    </div>
                    <input class="col-9 mandatory" type="text" id="edit_chinese_name" style="margin: 0"  placeholder="{{trans('dictionary.note_name_zh')}}"  autocomplete="off">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.en')}}{{trans('dictionary.name')}}<span class="redStar">*</span>：</span>
                    </div>
                    <input class="col-9 mandatory" type="text" id="edit_english_name" style="margin: 0"  placeholder="{{trans('dictionary.note_name_en')}}"  autocomplete="off">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.gender')}}<span class="redStar">*</span>：</span>
                    </div>
                    <select class=" selectpicker col-9" id="edit_gender">
                        <option value="female">{{trans('dictionary.female')}}</option>
                        <option value="male">{{trans('dictionary.male')}}</option>
                        <option value="other">{{trans('dictionary.other')}}</option>
                    </select>
                </div>
                
                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex flex-column justify-content-center">
                        <span>{{trans('dictionary.birthday')}}<span class="redStar">*</span>：</span>
                        <span style="font-size: 0.8em; color: grey;">{{trans('dictionary.note_birthday')}}</span>
                    </div>
                    <input class="col-9 mandatory" type="date" id="edit_birthday" style="margin: 0"  autocomplete="off">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.cellphone')}}<span class="redStar">*</span>：</span>
                    </div>
                    <input class="col-9 mandatory" type="text" id="edit_cellphone" style="margin: 0"  placeholder="{{trans('dictionary.note_cellphone')}}"  autocomplete="off">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.wechat')}}<span class="redStar">*</span>：</span>
                    </div>
                    <input class="col-9 mandatory" type="text" id="edit_wechat" style="margin: 0"  placeholder="{{trans('dictionary.note_wechat')}}"  autocomplete="off">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.address')}}<span class="redStar">*</span>：</span>
                    </div>
                    <input class="col-9 mandatory" type="text" id="edit_address" style="margin: 0"  placeholder="{{trans('dictionary.note_address')}}"  autocomplete="off">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.region')}}<span class="redStar">*</span>：</span>
                    </div>
                    <input class="col-9 mandatory" type="text" id="edit_region" style="margin: 0"  placeholder="{{trans('dictionary.note_region')}}"  autocomplete="off">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.school')}}<span class="redStar">*</span>：</span>
                    </div>
                    <input class="col-9 mandatory" type="text" id="edit_school" style="margin: 0" placeholder="{{trans('dictionary.note_school')}}"  autocomplete="off">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.mentor')}}：</span>
                    </div>
                    <input class="col-9" type="text" id="edit_mentor" style="margin: 0"  placeholder="{{trans('dictionary.note_mentor')}}"  autocomplete="off">
                </div>

                <hr style="color: black; width: 60vw;">

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.select')}}{{trans('dictionary.group')}}<span class="redStar">*</span>：</span>
                    </div>
                    <select class="selectpicker col-9 " id="edit_group">
                    </select>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex flex-column justify-content-center">
                        <span>{{trans('dictionary.firstRoundAvailability')}}{{trans('dictionary.session')}}<span class="redStar">*</span>：</span>
                        <span style="font-size: 0.8em; color: grey;">{{trans('dictionary.mutliple')}}</span>
                    </div>
                    <select class="selectpicker col-9 mandatory-select" multiple id="edit_date">
                    </select>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.select')}}{{trans('dictionary.language')}}<span class="redStar">*</span>：</span>
                    </div>
                    <select class="selectpicker col-9" id="edit_language">
                        <option value="zh" selected>{{trans('dictionary.zh')}}</option>
                        <option value="cn">{{trans('dictionary.cn')}}</option>
                        <option value="en">{{trans('dictionary.en')}}</option>
                    </select>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex flex-column justify-content-center">
                        <span>{{trans('dictionary.input')}}<span class="redStar">*</span>：</span>
                        <span style="font-size: 0.8em; color: grey;">{{trans('dictionary.mutliple')}}</span>
                    </div>
                    <select class="selectpicker col-9" multiple id="edit_input">
                        <option value="zhuyin" selected>{{trans('dictionary.zhuyin')}}</option>
                        <option value="cangjie">{{trans('dictionary.cangjie')}}</option>
                        <option value="sucheng">{{trans('dictionary.sucheng')}}</option>
                        <option value="pinyin_m">{{trans('dictionary.pinyin_m')}}</option>
                        <option value="pinyin_c">{{trans('dictionary.pinyin_c')}}</option>
                        <option value="stroke">{{trans('dictionary.stroke')}}</option>
                        <option value="wubi">{{trans('dictionary.wubi')}}</option>
                        <option value="handwriting">{{trans('dictionary.handwriting')}}</option>
                        <option value="other">{{trans('dictionary.other')}}</option>
                    </select>
                </div>

                <hr style="color: black; width: 60vw;">

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.proof')}}<span class="redStar">*</span>：</span>
                    </div>
                    <input class="col-5" type="file" name="file" id="edit_proof" style="margin: 0"  placeholder="{{trans('dictionary.if_nes')}}"  autocomplete="off">
                    <input type="checkbox" id="edit_noproof" style="margin: 0"  autocomplete="off">
                    <label for="edit_noproof">&ensp;{{trans('dictionary.note_proof')}}</label>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.invoice_name')}}：</span>
                    </div>
                    <input class="col-9" type="text" id="edit_invoice_name" style="margin: 0"  placeholder="{{trans('dictionary.if_nes')}}"  autocomplete="off">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.invoice_no')}}：</span>
                    </div>
                    <input class="col-9" type="text" id="edit_invoice_no" style="margin: 0"  placeholder="{{trans('dictionary.if_nes')}}"  autocomplete="off">
                </div>

                <hr style="color: black; width: 60vw;">

                <div class="col-12 d-flex mb-3">
                    <input type="checkbox" id="edit_agree" style="margin: 0"  autocomplete="off">
                    <label for="edit_agree">{{trans('dictionary.signup_condition')}}</label>
                </div>

                <div class="col-12 d-flex mb-3">
                    <button class="btn btn-success col-12" id="submit">{{trans('dictionary.submit')}}</button>
                </div>

            </div>
        </div>
    </div>

   
@stop
@section('end_script')
<script>
</script>
    <script src="js/general.min.js?v={{Config::get('app.version')}}"></script>
    <script src="js/signup.min.js?v={{Config::get('app.version')}}"></script>
@stop