@include('includes.language')
<!doctype html>
<html>
<head>
    @include('includes.head')
    <title>亚洲思辨写作对抗赛</title>
    <link rel="icon" href="/img/logo.ico">
</head>
<body>
@include('includes.manage.navbar')
<main role="main" style="margin-top: 80px;">
    <!-- <div class="col" style="">
        <h2>{{$page_header}}</h2>
        <div class="border-bottom"></div>
    </div> -->

    <div class="main-page">
        @yield('content')
    </div>
</main>
@yield('end_script')
</body>
</html>
