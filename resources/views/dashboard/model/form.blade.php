@extends('layouts.appDashBoard')

@section('content')

<?php
	use App\Admin;
?>

    <h3 class="page-header">
	@if(isset($modelId))
    {{ Admin::find($modelId)->name }}さんの編集
    @else
    管理者登録
    @endif
    </h3>

    	@if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Error!!</strong> 追加できません<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    	@if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="well">

            <form class="form-horizontal" role="form" method="POST" action="/dashboard/model" enctype="multipart/form-data">
                {{ csrf_field() }}

                @if(isset($modelId))
                	<input type="hidden" name="model_id" value="{{$modelId}}">
                @endif


                <div class="col-md-4 thumb-prev">
                    @if(count(old()) > 0)
                        @if(old('thumbnail_outurl') != '' && old('thumb_choice'))
                        <img src="{{ Storage::url(old('thumbnail_outurl')) }}" class="img-fluid">
                        @elseif(isset($model) && $model->thumbnail)
                        <img src="{{ Storage::url($atcl->thumbnail) }}" class="img-fluid">
                        @else
                        <span class="no-img">No Image</span>
                        @endif
                    @elseif(isset($model) && $model->thumbnail)
                    <img src="{{ Storage::url($atcl->thumbnail) }}" class="img-fluid">
                    @else
                    <span class="no-img">No Image</span>
                    @endif
                </div>

                <div class="col-md-12 form-group{{ $errors->has('thumbnail') ? ' has-error' : '' }}">
                    <label for="thumbnail" class="col-md-2 control-label">サムネイル</label>
                    <div class="col-md-8">
                        <input id="thumbnail" class="thumb-file" type="file" name="thumbnail">
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-2 control-label">名前</label>

                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" value="{{ isset($model) ? $model->name : old('name') }}" autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('nick_name') ? ' has-error' : '' }}">
                    <label for="nick_name" class="col-md-2 control-label">ニックネーム</label>

                    <div class="col-md-8">
                        <input id="nick_name" type="text" class="form-control" name="nick_name" value="{{ isset($model) ? $model->nick_name : old('nick_name') }}">

                        @if ($errors->has('nick_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nick_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-2 control-label">メールアドレス</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ isset($model) ? $model->email : old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-2 control-label">パスワード</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" placeholder="8文字以上">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('school') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-2 control-label">学校</label>

                    <div class="col-md-6">
                        <input id="school" type="text" class="form-control" name="school" value="{{ isset($model) ? $model->school : old('school') }}">

                        @if ($errors->has('school'))
                            <span class="help-block">
                                <strong>{{ $errors->first('school') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('charm_point') ? ' has-error' : '' }}">
                    <label for="charm_point" class="col-md-2 control-label">チャームポイント</label>

                    <div class="col-md-6">
                        <input id="charm_point" type="text" class="form-control" name="charm_point" value="{{ isset($model) ? $model->charm_point : old('charm_point') }}">

                        @if ($errors->has('charm_point'))
                            <span class="help-block">
                                <strong>{{ $errors->first('charm_point') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('hobby') ? ' has-error' : '' }}">
                    <label for="hobby" class="col-md-2 control-label">趣味</label>

                    <div class="col-md-6">
                        <input id="hobby" type="text" class="form-control" name="hobby" value="{{ isset($model) ? $model->hobby : old('hobby') }}">

                        @if ($errors->has('hobby'))
                            <span class="help-block">
                                <strong>{{ $errors->first('hobby') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-2 col-md-offset-2">
                        <button type="submit" class="btn btn-primary col-md-12">
                            登録
                        </button>
                    </div>
                </div>
            </form>

        </div>




@endsection
