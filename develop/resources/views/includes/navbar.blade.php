@include('includes.language')
<header class="fixed-top">

    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #ffffff;">
            <a class="navbar-brand" href="/">
                <div class="" style="font-size: 0.9em"><img src="/img/logo.jpg" style="margin-bottom: 0px; height: 30px;"/>
                    <b>{{trans('dictionary.DebateAsia')}}</b>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="collapse navbar-collapse" id="navbarNavDropdown" style="margin: 0;">
                <ul class="navbar-nav w-100">
                    <div class="ml-auto"></div>
                    <!-- <li class="nav-item" style="margin: 0 1em;font-size:0.9em;">
                        <a class="nav-link" href="/guideline" style="">
                            <i class="fa-solid fa-book-open"></i>&emsp;{{trans('dictionary.competition')}}{{trans('dictionary.borcher')}}
                        </a>
                    </li> -->
                    <li class="nav-item" style="margin: 0 1em;font-size:0.9em;">
                        <a class="nav-link" href="/rules" style="">
                            <i class="fa-solid fa-scale-balanced"></i>&emsp;{{trans('dictionary.competition')}}{{trans('dictionary.rule')}}
                        </a>
                    </li>
                    <li class="nav-item" style="margin: 0 1em;font-size:0.9em;">
                        <a class="nav-link" data-toggle="modal" data-target="#livechatModal" style="">
                            <i class="fa-brands fa-weixin"></i>&emsp;{{trans('dictionary.livechat')}}
                        </a>
                    </li>
                    <li class="nav-item" id="nav_login" style="margin: 0 1em;font-size:0.9em;">
                        <a class="nav-link" data-toggle="modal" data-target="#loginModal" style="">
                            <i class="fa-solid fa-right-to-bracket"></i>&emsp;{{trans('dictionary.login')}}
                        </a>
                    </li>
                    <li class="nav-item nav-auth" id="nav_candidates" style="margin: 0 1em;font-size:0.9em; display:none;">
                        <a class="nav-link" href="/candidate" style="">
                            <i class="fa-solid fa-user"></i>&emsp;{{trans('dictionary.candidate')}}{{trans('dictionary.panel')}}
                        </a>
                    </li>
                    <li class="nav-item nav-auth" id="nav_admin" style="margin: 0 1em;font-size:0.9em; display:none;">
                        <a class="nav-link" href="/admin" style="">
                             <i class="fa-solid fa-user"></i>&emsp;{{trans('dictionary.admin')}}{{trans('dictionary.panel')}}
                        </a>
                    </li>
                    <li class="nav-item nav-auth" id="nav_judge" style="margin: 0 1em;font-size:0.9em; display:none;">
                        <a class="nav-link" href="/judge" style="">
                             <i class="fa-solid fa-user"></i>&emsp;{{trans('dictionary.judge')}}{{trans('dictionary.panel')}}
                        </a>
                    </li>
                    <li class="nav-item nav-auth" id="nav_logout" style="margin: 0 1em; font-size:0.9em; display:none;">
                        <a class="nav-link" id="logout" style="">
                            <i class="fa-solid fa-right-from-bracket"></i>&emsp;{{trans('dictionary.logout')}}
                        </a>
                    </li>
                    <li class="nav-item dropdown" style="margin: 0 1em; font-size:0.9em;">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                            @if(session('setLocale') == 'zh')
                                <i class="fa-solid fa-repeat"></i>&emsp;{{trans('dictionary.cn')}}&ensp;/&ensp;{{trans('dictionary.en')}}
                            @elseif(session('setLocale') == 'cn')
                                <i class="fa-solid fa-repeat"></i>&emsp;{{trans('dictionary.zh')}}&ensp;/&ensp;{{trans('dictionary.en')}}
                            @elseif(session('setLocale') == 'en')
                                <i class="fa-solid fa-repeat"></i>&emsp;{{trans('dictionary.zh')}}&ensp;/&ensp;{{trans('dictionary.cn')}}
                            @else
                                <i class="fa-solid fa-repeat"></i>&emsp;{{trans('dictionary.zh')}}&ensp;/&ensp;{{trans('dictionary.en')}}
                            @endif
                        </a>
                        <div class="dropdown-menu">
                            <a class="nav-link lang-btn" data-lang="cn" style="">
                                &emsp;{{trans('dictionary.cn')}}
                            </a>
                            <a class="nav-link lang-btn" data-lang="zh" style="">
                                &emsp;{{trans('dictionary.zh')}}
                            </a>
                            <a class="nav-link lang-btn" data-lang="en" style="">
                                &emsp;{{trans('dictionary.en')}}
                            </a>
                        </div>
                    </li>
                    <li class="nav-item btn btn-primary" style="margin: 0 1em;font-size:0.9em; padding: 0;">
                        <a class="nav-link" href="/signup" style=" color: white;">
                            <i class="fa-solid fa-user-plus"></i>&emsp;{{trans('dictionary.signup')}}
                        </a>
                    </li>
                </ul>
            </ul>
    </nav>
</header>
