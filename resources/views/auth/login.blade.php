@extends('layouts.appModel')

@section('content')

    <div class="clearfix mt-5">
        <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-12 control-label">メールアドレス</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-12 control-label">パスワード</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group clear">
                            <div class="col-md-6 float-left">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 次回から自動でログイン
                                    </label>
                                </div>
                            </div>

							<div class="col-md-6 float-right text-right">
                                <a class="" href="{{ url('contribute/password/reset') }}">
                                    <i class="fa fa-angle-double-right" aria-hidden="true"></i> パスワードを忘れた <i class="fa fa-question" aria-hidden="true"></i> 
                                </a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info col-md-12 mt-3">
                                    ログイン
                                </button>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@endsection
