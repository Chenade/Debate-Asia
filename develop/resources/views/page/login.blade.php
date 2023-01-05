{{Lang::setLocale(session('setLocale'))}}
        <!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>
<div class="container" style="margin-top: 15%">
    <div class="col-auto" style="margin-bottom: 50px;margin-top: 50px;">
        <img class="center-block" style="height: 100px;" src="/img/logo.png"/>
    </div>
    <div class="col-auto">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
            </div>
            <input type="text" class="form-control" id="user" placeholder="{{trans('account.id')}}">
        </div>
    </div>
    <div class="col-auto">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-key"></i></div>
            </div>
            <input type="password" class="form-control" id="password" placeholder="{{trans('account.password')}}" autocomplete="off">
        </div>
    </div>
    <div class="col-auto">
        <div class="d-flex">
            <div class="w-100">
                <button type="button" class="btn btn-primary" id="login" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>">{{trans('dictionary.login')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newPassword-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <h5>{{trans('account.changePassword')}}</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form onsubmit="return false;" class="input-group" style="padding-bottom: 5px">
                    <div class="row col-12">
                        <div class="col">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('account.password')}}:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="newPassword" autocomplete="new-password" aria-autocomplete="none" placeholder="({{trans('dictionary.Unchanged')}})">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary edit-password-view">
                                            <i class="fas fa-eye"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12">
                        <div class="col">
                            <div class="form-group">
                                <label class="col-form-label">{{trans('account.confirmPassword')}}:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="newPassword2" autocomplete="new-password" aria-autocomplete="none" placeholder="({{trans('dictionary.Unchanged')}})">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary edit-password-view">
                                            <i class="fas fa-eye"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="password_confirm" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>">{{trans('dictionary.Apply')}}</button>
                <button type="button" class="btn btn-warning" id="password_cancel"  data-loading-text="<span class='spinner-grow spinner-grow-sm'></span>" data-dismiss="modal">{{trans('account.changeNextTime')}}</button>
            </div>
        </div>
    </div>
</div>

<script src="/js/login.min.js"></script>
<script src="/js/general.min.js"></script>
</body>
</html>