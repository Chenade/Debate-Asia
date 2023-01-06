@include('includes.language')
@extends('layouts.default', ['page_header' =>'About','page_parent' =>'Home','page_parent_path' =>'/','page_path' =>'', 'page_banner' =>'sub_banner.png'])
@section('content')
    <img class="bg" src="/img/background.png" alt="" style=" width: 100%; min-height: 1000px; object-fit: fill;opacity: 0.3;">
    <div class="col-12 d-flex justify-content-center" style="margin-top:80px; position: absolute; top: 0;left: 0;">
        <!-- body -->
        <div class="container">
                
            <div class="col-12">
                <div class="section-heading text-center">
                    <h6 class="tag">Guidelines</h6>
                    <h2 style="font-weight: 900">{{trans('dictionary.competition')}}{{trans('dictionary.borcher')}}</h2>
                </div>
            </div>

            <div class="d-flex flex-wrap align-items-center" style="padding: 0 90px 0 110px; margin-bottom: 50px;">
                <p>

                    <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify;"> 一、请选手确保网络的流畅度，以全屏形式使用比赛页面，并于比赛全程保持摄像头开启状态，主办方将于后台检查双方选手摄像头。每轮作答环节前30分钟选⼿不得离开座位，比赛摄像将每3秒更新一次。 </p>

                    <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify;"> 二、比赛过程中，若因任何问题退出比赛页面，只需重新点击【进入比赛】即可回到比赛页面，但比赛时间不作调整，且已书写内容有遗失的风险，请参赛选手使用平台时谨慎操作。若选手在比赛期间出现连线或其他技术问题，须由选手自行承担后果。 </p>

                    <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify;"> 三、⽐赛进行期间，选手可运用除语音输入以外的任何⼀种中文输入法作答；另系统将呈现选手于登入时选择的繁体与简体中文。 </p>

                    <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify;"> 四、选手可自由上网查阅资料，但所有作答内容须由本人独立输⼊完成，不可有他⼈在旁指导或代替作答。若发现选⼿稿件由他⼈代写，或于⽐赛过程中经由他⼈帮助完成，则直接取消该选手比赛成绩，以维持赛事公平性。 </p>

                    <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify;"> 五、大赛组委会将按照学术抄袭惯例系统查核所有晋级或得奖的作品，若⽂稿涉及整段抄袭，经对手检举或评审质疑，则该场比赛将由评审共同商议并重新评核确认，若确认为抄袭则直接判定失去比赛资格。 </p>

                    <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify;"> 六、大赛组委会于评核过程将保留每份作品的匿名性，评审会按照作品编号给予评分，选手不得于文稿中直接提及自己的姓名或间接暗示身份。 </p>

                    <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify; margin :0;"> 七、赛事共分成【⽴论】与【反驳】两轮环节。 <br> 
                    每轮环节限时结束时，选手所输入的内容将被系统自动提交，不达最低字数限制的文稿将遭扣分。每轮作答时限及字数分别为： </p>
                        <p style="color: rgba(150, 0, 0, 1); font-weight: 700;"> 
                            A组立论80分钟，最少撰写600字；反驳40分钟，最少撰写300字。<br> 
                            B组立论70分钟，最少撰写450字；反驳30分钟，最少撰写200字。<br> 
                            C组立论60分钟，最少撰写300字；反驳30分钟，最少撰写120字。</p>

                    <p style="text-indent: -2em; color: black; font-weight:500; text-align:justify;"> 八、环节说明：<br>
                        【⽴论】环节 —— 选⼿根据所分配的辩题及站方进行立论，以打字形式在作答区内输⼊，确认立论内容已完成后选手可选择点击【提前交卷】。一旦点击后将直接进入等待时间，无法重返输入立论稿，另第二轮反驳环节将按时进行，以确保双方皆有一样的输入时间。
                        <br>
                        【反驳】环节 —— 选手可随时点阅回顾双方的立论稿。若反驳内容已完成并确定无误后，可以点击【提前交卷】等待系统提示【稿件已成功上传】后方可离开比赛页面结束比赛；若在系统宣布稿件成功上传前已关闭视窗，可能会导致文稿无法完整上传，影响比赛结果。
                        比赛结束后，系统将自动为您提交⽂稿，在此之前请勿关闭比赛视窗。

                        <br>
                        <p>注1：所有有关比赛规则及赛果，主办方保留最终诠释权。</p>
                        <p>注2：选手在比赛过程中遇到任何问题请点击右上方【即时咨询】扫二维码微信赛会，或透过【反映问题】留言给主办方。</p>
                </p>
            </div>
        </div>
    </div>

   
@stop
@section('end_script')
<script>
</script>
    <!-- <script src="js/general.min.js?v={{Config::get('app.version')}}"></script> -->
@stop