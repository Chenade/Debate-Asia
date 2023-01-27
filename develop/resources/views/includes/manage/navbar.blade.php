@include('includes.language')
<header class="fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mobile-hidden">
        <div class="container">
            <a class="navbar-brand" href="/admin">
                <div class=""><img src="/img/logo.jpg" style="margin-bottom: 0px; height: 30px;"/>
                    <b>{{trans('dictionary.debateTournment')}}&ensp;{{trans('dictionary.admin')}}{{trans('dictionary.panel')}}</b>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="collapse navbar-collapse" id="navbarNavDropdown" style="margin: 0;">
                <ul class="navbar-nav w-100">
                    <div class="ml-auto"></div>
                    <li class="nav-item" style="margin: 0 0.5em;font-size:0.9em;"><a class="nav-link" href="/admin" data-admin="news">{{trans('dictionary.account')}}{{trans('dictionary.manage')}}</a></li>
                    <li class="nav-item" style="margin: 0 0.5em;font-size:0.9em;"><a class="nav-link" href="/admin/competition" data-admin="natural_8">{{trans('dictionary.competition')}}{{trans('dictionary.manage')}}</a></li>
                    <li class="nav-item" style="margin: 0 0.5em;font-size:0.9em;"><a class="nav-link" href="/admin/session" data-admin="course">{{trans('dictionary.competition')}}{{trans('dictionary.monitor')}}</a></li>
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
