@extends('layouts.appModel')

@section('content')
<div class="clearfix mt-5">
        <div class="panel panel-default">
            <div class="panel-heading mb-4 col-md-12">
				@if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                </div>

                @else

                パスワードをリセットします。<br>登録したメールアドレスを入力して下さい。
            </div>
            <div class="panel-body">

                <form class="form-horizontal" role="form" method="POST" action="{{ url('contribute/password/email') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-12 control-label">メールアドレス</label>

                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="text-danger help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-info col-md-12 mt-3">
                                リセット用リンクを送信
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        @endif

</div>
@endsection
