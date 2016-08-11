@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">绑定本站帐号</div>
                    <div class="panel-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#login" aria-controls="login" role="tab" data-toggle="tab">已有帐号</a></li>
                            <li role="presentation">
                                <a href="#register" aria-controls="profile" role="tab" data-toggle="tab">注册新帐号</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="login">
                                {{ Form::model($user, ['url'=>'/bind', 'class'=>'form-horizontal', 'role'=>'form']) }}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">电子邮件</label>

                                    <div class="col-md-6">
                                        {{ Form::email('email', null, ['class'=>'form-control']) }}

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">密码</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password">

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> 记住我
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-sign-in"></i> 绑定并登陆
                                        </button>

                                        <a class="btn btn-link" href="{{ url('/password/reset') }}">忘记密码</a>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                            <div role="tabpanel" class="tab-pane" id="register">
                                {{ Form::model($user, ['url'=>'/bind', 'class'=>'form-horizontal', 'role'=>'form']) }}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">用户名</label>

                                    <div class="col-md-6">
                                        {{ Form::text('name', null, ['class'=>'form-control']) }}

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">EMail</label>

                                    <div class="col-md-6">
                                        {{ Form::email('email', null, ['class'=>'form-control']) }}


                                        @if ($errors->has('email'))
                                            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                        @endif
                                        <p class="help-block text-muted">电子邮件将用于网站登录</p>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">登陆密码</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password">

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                                    <label for="confirm_password" class="col-md-4 control-label">确认密码</label>

                                    <div class="col-md-6">
                                        <input id="confirm_password" type="password" class="form-control" name="confirm_password">

                                        @if ($errors->has('confirm_password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> 记住我
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-sign-in"></i> 注册并绑定
                                        </button>

                                        <a class="btn btn-link" href="{{ url('/password/reset') }}">忘记密码</a>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
