@lang(Lang::setLocale(session('setLocale')))
@if(isset($target) && isset($id))
    @if($target=='status')
        <div class="panel-group col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><a data-toggle="collapse" href="#{{$id}}">{{trans('dictionary.Server')}}</a>
                    </h4>
                </div>
                <div id="{{$id}}" class="panel-collapse collapse in">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-md-4">{{trans('dictionary.User_Name')}}:</label>
                            <div class="col-md-8">
                                <p class="pd-best">{{$id}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">{{trans('dictionary.Domain_Name')}}:</label>
                            <div class="col-md-8">
                                <p class="pd-best" id="{{$id}}_domain"><i class="fa fa-spinner fa-pulse fa-fw"></i></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">{{trans('dictionary.IP_Address')}}:</label>
                            <div class="col-md-8">
                                <p class="pd-best" id="{{$id}}_externalIp"><i class="fa fa-spinner fa-pulse fa-fw"></i>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">{{trans('dictionary.CPU_Utilization')}}:</label>
                            <div class="col-sm-8 pd-best" style="display: none;" id="{{$id}}_cpu_row">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-info progress-bar-striped active" aria-valuenow="0" style="width: 0%" id="{{$id}}_cpu">
                                        0%
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8" id="{{$id}}_cpu_status_row">
                                <p id="cpu_status" class="pd-best"><i class="fa fa-spinner fa-pulse fa-fw"></i></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">{{trans('dictionary.Memory_Utilization')}}:</label>
                            <div class="col-sm-8 pd-best" style="display: none;" id="{{$id}}_mem_row">
                                <div class="progress">
                                    <div class="input-group">
                                        <div class="progress-bar progress-bar-info progress-bar-striped active" aria-valuenow="0" style="width: 0%" id="{{$id}}_mem">
                                            0%
                                        </div>
                                        <span class="input-group-addon" style="padding: 0px 12px; border: 1px solid #ccc"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8" id="{{$id}}_mem_status_row">
                                <p id="{{$id}}_mem_status" class="pd-best"><i class="fa fa-spinner fa-pulse fa-fw"></i>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">{{trans('dictionary.Disk_Utilization')}}:</label>
                            <div class="col-sm-8 pd-best" style="display: none;" id="{{$id}}_disk_row">
                                <div class="progress">
                                    <div class="input-group">
                                        <div class="progress-bar progress-bar-info progress-bar-striped active" aria-valuenow="0" style="width: 0%" id="{{$id}}_disk">
                                            0%
                                        </div>
                                        <span class="input-group-addon" style="padding: 0px 12px; border: 1px solid #ccc"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8" id="{{$id}}_disk_status_row">
                                <p id="{{$id}}_disk_status" class="pd-best"><i class="fa fa-spinner fa-pulse fa-fw"></i>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">{{trans('dictionary.Free_Space')}}:</label>
                            <div class="col-sm-8">
                                <p id="{{$id}}_free" class="pd-best"><i class="fa fa-spinner fa-pulse fa-fw"></i></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">{{trans('dictionary.Time_Zone')}}:</label>
                            <div class="col-sm-8">
                                <p id="{{$id}}_timezone" class="pd-best"><i class="fa fa-spinner fa-pulse fa-fw"></i>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">{{trans('dictionary.System_Time')}}:</label>
                            <div class="col-sm-8">
                                <p id="{{$id}}_date" class="pd-best"><i class="fa fa-spinner fa-pulse fa-fw"></i></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">{{trans('dictionary.Up_Time')}}:</label>
                            <div class="col-sm-8">
                                <p id="{{$id}}_uptime" class="pd-best"><i class="fa fa-spinner fa-pulse fa-fw"></i></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">{{trans('dictionary.Version')}}:</label>
                            <div class="col-sm-8">
                                <p id="{{$id}}_version" class="pd-best"><i class="fa fa-spinner fa-pulse fa-fw"></i></p>
                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                        {{--<label class="control-label col-sm-4">{{trans('dictionary.Networking')}}:</label>--}}
                        {{--<div class="col-sm-8">--}}
                        {{--<p id="{{$id}}_net" class="pd-best"><i class="fa fa-spinner fa-pulse fa-fw"></i></p>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                        {{--<label class="control-label col-md-4">{{trans('dictionary.VSS')}}:</label>--}}
                        {{--<div class="col-md-8">--}}
                        {{--<p class="pd-best" id="{{$id}}_vss"><i class="fa fa-spinner fa-pulse fa-fw"></i></p>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                        {{--<label class="control-label col-md-4">{{trans('dictionary.FIS')}}:</label>--}}
                        {{--<div class="col-md-8">--}}
                        {{--<p class="pd-best" id="{{$id}}_fis"><i class="fa fa-spinner fa-pulse fa-fw"></i></p>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
    @elseif($target=='setting')
        <div class="panel-group col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#{{$id}}"><i class="fa fa-server"> {{$id}}</i></a></h4>
                </div>
                <div id="{{$id}}" class="panel-collapse collapse in">
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-md-4">{{trans('dictionary.Keep_Space')}}:</label>
                            <div class="col-md-8">
                                <select class="selectpicker show-tick" id="{{$id}}_keepSpace">
                                    <option data-subtext="GB">10</option>
                                    <option data-subtext="GB">20</option>
                                    <option data-subtext="GB">50</option>
                                    <option data-subtext="GB">100</option>
                                    <option data-subtext="GB">200</option>
                                    <option data-subtext="GB">500</option>
                                    <option data-subtext="GB">1000</option>
                                    <option data-subtext="GB">3000</option>
                                    <option data-subtext="GB">5000</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Core:</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        Domain
                                    </span>
                                    <input type="text" class="form-control" id="{{$id}}_domain">
                                </div>
                                <div class="input-group" style="padding-top: 5px">
                                    <span class="input-group-addon">
                                        IP
                                    </span>
                                    <input type="text" class="form-control" id="{{$id}}_ip">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">VSS:</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        Domain
                                    </span>
                                    <input type="text" class="form-control" id="{{$id}}_vssDomain">
                                </div>
                                <div class="input-group" style="padding-top: 5px">
                                    <span class="input-group-addon">
                                        IP
                                    </span>
                                    <input type="text" class="form-control" id="{{$id}}_vssIp">
                                </div>
                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<label class="control-label col-md-4">FR:</label>--}}
                            {{--<div class="col-md-8">--}}
                                {{--<div class="input-group">--}}
                                    {{--<span class="input-group-addon">--}}
                                        {{--Domain--}}
                                    {{--</span>--}}
                                    {{--<input type="text" class="form-control" id="{{$id}}_frDomain">--}}
                                {{--</div>--}}
                                {{--<div class="input-group" style="padding-top: 5px">--}}
                                    {{--<span class="input-group-addon">--}}
                                        {{--IP--}}
                                    {{--</span>--}}
                                    {{--<input type="text" class="form-control" id="{{$id}}_frIp">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label class="control-label col-md-4">VA:</label>--}}
                            {{--<div class="col-md-8">--}}
                                {{--<div class="input-group">--}}
                                    {{--<span class="input-group-addon">--}}
                                        {{--Domain--}}
                                    {{--</span>--}}
                                    {{--<input type="text" class="form-control" id="{{$id}}_vaDomain">--}}
                                {{--</div>--}}
                                {{--<div class="input-group" style="padding-top: 5px">--}}
                                    {{--<span class="input-group-addon">--}}
                                        {{--IP--}}
                                    {{--</span>--}}
                                    {{--<input type="text" class="form-control" id="{{$id}}_vaIp">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <span class="col-md-8 col-md-push-4">
                                <button type="button" class="btn btn-primary" id="{{$id}}_apply" data-loading-text="<span class='spinner-grow spinner-grow-sm'></span> {{trans('dictionary.Processing')}}" disabled>
                                    {{trans('dictionary.Apply')}}
                                </button>
                                <button type="button" class="btn btn-default" id="{{$id}}_reset">
                                    {{trans('dictionary.Reset')}}
                                </button>
                                <button type="button" class="btn btn-warning">
                                    {{trans('server.restart')}}
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif