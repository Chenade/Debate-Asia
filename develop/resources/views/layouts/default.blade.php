@include('includes.language')
<!doctype html>
<html>
<head>
    @include('includes.head')
    <title>{{trans('dictionary.debateTournment')}}</title>
    <link rel="icon" href="/img/logo.ico">
    
</head>
<body style="">
@include('includes.navbar')
<main role="main" style="margin-top: 50px; height: 90vh">
    <div class="col" style="margin-bottom: 15px;display: none">
        <h2>{{$page_header}}</h2>
        <div class="border-bottom"></div>
    </div>
    <div class="main-page">
        @yield('content')
    </div>  
</main>

<!-- Modal -->
<div class="modal fade" id="livechatModal" tabindex="-1" role="dialog" aria-labelledby="livechatModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="livechatModalLabel">{{trans('dictionary.livechat')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-center align-items-center flex-column">
            <img src="/img/qrcode_wechat.png" />
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="loginModalLabel">{{trans('dictionary.login')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="col-auto" style="margin-top: 50px;">
                <div class="d-flex flex-wrap">
                    <div class="col-12 col-sm-3 d-flex justify-content-center">
                        <img class="center-block" style="height: 100px;" src="/img/logo.jpg"/>
                    </div>
                    <div class="col-12 col-sm-9">
                        <div class="col-auto">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                </div>
                                <input type="text" class="form-control" id="user" placeholder="account">
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-key"></i></div>
                                </div>
                                <input type="password" class="form-control" id="password" placeholder="password" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <p style="margin: 0;">＊ {{trans('rules.rlogin1')}}</p>
                <p style="margin: 0;">＊ {{trans('rules.rlogin2')}}</p>
                <p style="margin: 0;">＊ {{trans('rules.rlogin3')}}</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="login" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>">{{trans('dictionary.login')}}</button>
        </div>
    </div>
  </div>
</div>

{{--<p>{{ session() -> all()  }}</p>--}}
@include('includes.footer')
<script>
    $(document).ready(function() {
        $('.language').on('click', function () {
            var val = $(this).attr('id');
            window.location.href = '/language/' + val;
        });

        $('#login').on('click', function () {
            // window.localStorage['uuid'] || guid();
            var btn = $('#login');
            // btn.button('loading');
            var data = {
                'account': $('#user').val(),
                'password': $('#password').val(),
            };

            $.ajax({
                type: 'POST',
                url: '/api/users/login',
                contentType: "application/json; charset=utf-8",
                data: JSON.stringify(data),
                success: function (res) {
                    document.cookie = "Authorization=" + res.message;
                    window.location.href = res.url;
                }, error: function (err) {
                    console.log(err);
                    $.growl.error({message: err.message})
                }
            });
        });

        $('#logout').on("click", function () {
            document.cookie = "Authorization=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            setTimeout(() => {
                window.location.href = '/';
            }, 800);
        });
    });

</script>
@yield('end_script')
</body>
</html>
