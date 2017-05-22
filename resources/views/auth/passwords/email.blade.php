@extends('layouts.appModel')

@section('content')
<div class="clearfix mt-5">
            <div class="panel panel-default">
                <div class="panel-heading mb-4 col-md-12">パスワードをリセットします。<br>登録したメールアドレスを入力して下さい。</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-12 control-label">メールアドレス</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-info">
                                    リセット用リンクを送信
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

</div>
@endsection
