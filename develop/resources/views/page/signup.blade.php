@include('includes.language')
@extends('layouts.default', ['page_header' =>'About','page_parent' =>'Home','page_parent_path' =>'/','page_path' =>'', 'page_banner' =>'sub_banner.png'])
@section('content')
    <img class="bg" src="/img/background.png" alt="" style=" width: 100%; height: 100vh; object-fit: cover;opacity: 0.5; position:fixed; left: 0; top: 0;">
    <div class="col-12 d-flex justify-content-center" style="margin-top:80px; position: absolute; top: 0;left: 0;">
        <!-- body -->
        <div class="container" style="background-color: rgba(255,255,255,0.9);">
                
            <div class="col-12">
                <div class="section-heading text-center">
                    <h6 class="tag">Signup</h6>
                    <h2 style="font-weight: 900">{{trans('dictionary.signup')}}</h2>
                </div>
            </div>

            <div class="d-flex flex-wrap align-items-start flex-column" style="padding: 0 90px 0 110px; margin-bottom: 50px;">

                <p style="color: black; font-weight:900; text-align:justify;">「用中文思辨，用寫作看世界。」</p>

                <p style="color: black; font-weight:500; text-align:justify;"> 主辦單位：亞洲思辨教育學會、北京縱橫思海文化發展有限公司</p>

                <p style="color: black; font-weight:500; text-align:justify;"> 請每位報名者填選以下資料，並提交成功繳費之截圖證明，成功報名者將收到電郵通知比賽平台的登入資料。</p>

                <hr style="color: black; width: 60vw;">

                <p style="color: black; font-weight:500; text-align:justify;"> 若去年有報名過比賽，請輸入帳號密碼，將自動帶入基本資料，若無，下列資料將做為未來比賽登入資訊</p>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex flex-column justify-content-center">
                        <span>{{trans('dictionary.account')}}:</span>
                    </div>
                    <input class="col-9" type="text" id="edit_account" style="margin: 0">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.password')}}:</span>
                    </div>
                    <input class="col-7" type="text" id="edit_password" style="margin: 0"  placeholder="">
                    <button class="btn btn-primary col-2" style="margin: 0;" id="getUser">{{trans('dictionary.login')}}</button>
                </div>
                
                <hr style="color: black; width: 60vw;">

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex flex-column justify-content-center">
                        <span>{{trans('dictionary.email')}}:</span>
                    </div>
                    <input class="col-9" type="email" id="edit_email" style="margin: 0">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.chinese')}}{{trans('dictionary.name')}}:</span>
                    </div>
                    <input class="col-9" type="text" id="edit_chinese_name" style="margin: 0"  placeholder="(請輸入與身份證相同的中文全名)">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.english')}}{{trans('dictionary.name')}}:</span>
                    </div>
                    <input class="col-9" type="text" id="edit_english_name" style="margin: 0"  placeholder="(將顯示於英文版參賽證明書)">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex flex-column justify-content-center">
                        <span>{{trans('dictionary.gender')}}:</span>
                        <span style="font-size: 0.8em; color: grey;">(僅作主辦方統計用途)</span>
                    </div>
                    <select class=" selectpicker col-9" id="edit_gender">
                        <option value="female">{{trans('dictionary.female')}}</option>
                        <option value="male">{{trans('dictionary.male')}}</option>
                        <option value="other">{{trans('dictionary.other')}}</option>
                    </select>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex flex-column justify-content-center">
                        <span>{{trans('dictionary.birthday')}}:</span>
                        <span style="font-size: 0.8em; color: grey;">(請選擇公曆日期)</span>
                    </div>
                    <input class="col-9" type="date" id="edit_birthday" style="margin: 0">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.phone_number')}}:</span>
                    </div>
                    <input class="col-9" type="text" id="edit_cellphone" style="margin: 0"  placeholder="(請輸入國際區號與電話號碼，例：+852 8888 8888)">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.wechat')}}:</span>
                    </div>
                    <input class="col-9" type="text" id="edit_wechat" style="margin: 0"  placeholder="(供主辦方在比賽期間聯繫參賽者)">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.address')}}:</span>
                    </div>
                    <input class="col-9" type="text" id="edit_address" style="margin: 0"  placeholder="(供主辦方寄送獎座、獎狀、證書、作品選集及紀念品)">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.region')}}:</span>
                    </div>
                    <input class="col-9" type="text" id="edit_region" style="margin: 0"  placeholder="(以就讀學校所在地為準)">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.school')}}:</span>
                    </div>
                    <input class="col-9" type="text" id="edit_school" style="margin: 0" placeholder="(請輸入學校全名)">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.mentor')}}:</span>
                    </div>
                    <input class="col-9" type="text" id="edit_mentor" style="margin: 0"  placeholder="(參賽者如有指導老師可於此欄目選填老師中文全名)">
                </div>

                <hr style="color: black; width: 60vw;">

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.select')}}{{trans('dictionary.group')}}:</span>
                    </div>
                    <select class="selectpicker col-9" id="edit_group">
                    </select>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.select')}}{{trans('dictionary.date')}}:</span>
                    </div>
                    <select class="selectpicker col-9" multiple id="edit_date">
                    </select>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.select')}}{{trans('dictionary.language')}}:</span>
                    </div>
                    <select class="selectpicker col-9" id="edit_language">
                        <option value="zh" selected>{{trans('dictionary.zh')}}</option>
                        <option value="cn">{{trans('dictionary.cn')}}</option>
                        <option value="en">{{trans('dictionary.en')}}</option>
                    </select>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.select')}}{{trans('dictionary.input')}}:</span>
                    </div>
                    <select class="selectpicker col-9" multiple id="edit_date">
                        <option value="pinyin">{{trans('dictionary.pinyin')}}</option>
                        <option value="pinyin">{{trans('dictionary.pinyin')}}</option>
                        <option value="pinyin">{{trans('dictionary.pinyin')}}</option>
                        <option value="pinyin">{{trans('dictionary.pinyin')}}</option>
                        <option value="pinyin">{{trans('dictionary.pinyin')}}</option>
                        <option value="pinyin">{{trans('dictionary.pinyin')}}</option>
                        <option value="handwriting">{{trans('dictionary.handwriting')}}</option>
                    </select>
                </div>

                <hr style="color: black; width: 60vw;">

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.proof')}}:</span>
                    </div>
                    <input class="col-5" type="file" name="file" id="edit_proof" style="margin: 0"  placeholder="（如需）">
                    <input type="checkbox" id="edit_noproof" style="margin: 0">
                    <label for="edit_noproof">&ensp;由團隊其他人繳交</label>
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.invoice_name')}}:</span>
                    </div>
                    <input class="col-9" type="text" id="edit_invoice_name" style="margin: 0"  placeholder="（如需）">
                </div>

                <div class="col-12 d-flex mb-3">
                    <div class="col-3 d-flex align-items-center">
                        <span>{{trans('dictionary.invoice_no')}}:</span>
                    </div>
                    <input class="col-9" type="text" id="edit_invoice_no" style="margin: 0"  placeholder="（如需）">
                </div>

                <hr style="color: black; width: 60vw;">

                <div class="col-12 d-flex mb-3">
                    <input type="checkbox" id="edit_agree" style="margin: 0">
                    <label for="edit_agree">我已閱讀比賽簡章，並同意參賽之合約條款及授權主辦方收集以上資料作賽務用途</label>
                </div>

                <div class="col-12 d-flex mb-3">
                    <button class="btn btn-success col-12" id="submit">Submit</button>
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