@include('includes.language')
<header class="fixed-top">

    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #ffffff;">
        <div class="container">
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
                    <!-- <li class="nav-item" style="margin: 0 1.5em;font-size:0.9em;">
                        <a class="nav-link" href="/guideline" style="">
                            <i class="fa-solid fa-book-open"></i>&emsp;{{trans('dictionary.competition')}}{{trans('dictionary.borcher')}}
                        </a>
                    </li> -->
                    <li class="nav-item" style="margin: 0 1.5em;font-size:0.9em;">
                        <a class="nav-link" href="/rules" style="">
                            <i class="fa-solid fa-scale-balanced"></i>&emsp;{{trans('dictionary.competition')}}{{trans('dictionary.rule')}}
                        </a>
                    </li>
                    <li class="nav-item" style="margin: 0 1.5em;font-size:0.9em;">
                        <a class="nav-link" data-toggle="modal" data-target="#livechatModal" style="">
                            <i class="fa-brands fa-weixin"></i>&emsp;{{trans('dictionary.livechat')}}
                        </a>
                    </li>
                    <li class="nav-item" id="nav_login" style="margin: 0 1.5em;font-size:0.9em;">
                        <a class="nav-link" data-toggle="modal" data-target="#loginModal" style="">
                            <i class="fa-solid fa-right-to-bracket"></i>&emsp;{{trans('dictionary.login')}}
                        </a>
                    </li>
                    <li class="nav-item nav-auth" id="nav_candidates" style="margin: 0 1.5em;font-size:0.9em; display:none;">
                        <a class="nav-link" href="/candidate" style="">
                            <i class="fa-solid fa-user"></i>&emsp;{{trans('dictionary.candidate')}}{{trans('dictionary.panel')}}
                        </a>
                    </li>
                    <li class="nav-item nav-auth" id="nav_admin" style="margin: 0 1.5em;font-size:0.9em; display:none;">
                        <a class="nav-link" href="/admin" style="">
                            <i class="fa-duotone fa-users"></i>&emsp;{{trans('dictionary.admin')}}{{trans('dictionary.panel')}}
                        </a>
                    </li>
                    <li class="nav-item nav-auth" id="nav_logout" style="margin: 0 1.5em; font-size:0.9em; display:none;">
                        <a class="nav-link" id="logout" style="">
                            <i class="fa-solid fa-right-from-bracket"></i>&emsp;{{trans('dictionary.logout')}}
                        </a>
                    </li>
                    @if(session('setLocale') == 'zh')
                        <li class="nav-item" style="margin: 0 1.5em; font-size:0.9em;">
                            <a class="nav-link" href="/language/cn" style="">
                                <i class="fa-solid fa-repeat"></i>&emsp;{{trans('dictionary.cn')}}
                            </a>
                        </li>
                    @else
                        <li class="nav-item" style="margin: 0 1.5em; font-size:0.9em;">
                            <a class="nav-link" href="/language/zh" style="">
                                <i class="fa-solid fa-repeat"></i>&emsp;{{trans('dictionary.zh')}}
                            </a>
                        </li>
                    @endif
                   
                </ul>
            </ul>
        </div>
    </nav>
</header>
