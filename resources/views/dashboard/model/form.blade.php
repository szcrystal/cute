@extends('layouts.appDashBoard')

@section('content')

<?php
	use App\User;
?>

    <h3 class="page-header">
	@if(isset($modelId))
    {{ User::find($modelId)->name }}さんの編集
    @else
    モデル新規登録
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
                        <img src="{{ Storage::url($model->thumbnail) }}" class="img-fluid">
                        @else
                        <span class="no-img">No Image</span>
                        @endif
                    @elseif(isset($model) && $model->thumbnail)
                    <img src="{{ Storage::url($model->thumbnail) }}" class="img-fluid">
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
                    <label for="name" class="col-md-2 control-label">名前<small>（ニックネーム）</small></label>

                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" value="{{ isset($model) ? $model->name : old('name') }}">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                    <label for="full_name" class="col-md-2 control-label">フルネーム</label>

                    <div class="col-md-8">
                        <input id="full_name" type="text" class="form-control" name="full_name" value="{{ isset($model) ? $model->full_name : old('full_name') }}" autofocus>

                        @if ($errors->has('full_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('full_name') }}</strong>
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

				@if(!isset($modelId))
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
                @endif

				<div class="form-group{{ $errors->has('personal') ? ' has-error' : '' }}">
                    <label for="personal" class="col-md-2 control-label">モデルインフォ</label>

                    <div class="col-md-8">
                        <textarea id="personal" class="form-control" name="contents" rows="15">
                        {{ isset($fix) && !count(old()) ? $fix->contents : old('personal') }}</textarea>

                        @if ($errors->has('personal'))
                            <span class="help-block">
                                <strong>{{ $errors->first('personal') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


				<?php //パーソナル ---------------- ?>


				<?php $n=0; ?>
				@while($n < 8)

				<div class="col-md-4 thumb-prev">
                    @if(count(old()) > 0)
                        @if(old('thumbnail_outurl') != '' && old('thumb_choice'))
                        <img src="{{ Storage::url(old('snap')) }}" class="img-fluid">
                        @elseif(isset($model) && $model->thumbnail)
                        <img src="{{ Storage::url($model->thumbnail) }}" class="img-fluid">
                        @else
                        <span class="no-img">No Image</span>
                        @endif
                    @elseif(isset($model) && $model->thumbnail)
                    <img src="{{ Storage::url($model->thumbnail) }}" class="img-fluid">
                    @else
                    <span class="no-img col-md-offset-6">No Image</span>
                    @endif
                </div>

                <div class="col-md-12 form-group{{ $errors->has('snap') ? ' has-error' : '' }}">
                    <label for="snap" class="col-md-2 control-label">スナップ</label>
                    <div class="col-md-8">
                        <input class="snap" type="file" name="snap[]">
                    </div>
                </div>

                <div class="form-group{{ $errors->has('pers_ask') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-2 control-label">質問</label>

                    <div class="col-md-8">
                        <input id="school" type="text" class="form-control" name="ask[]" value="{{ isset($model) ? $model->school : old('school') }}">

                        @if ($errors->has('ask'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ask') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                    <label for="answer" class="col-md-2 control-label">回答</label>

                    <div class="col-md-8">
                        <textarea id="answer" class="form-control" name="answer[]" rows="8">
                        {{ isset($fix) && !count(old()) ? $model->answer : old('answer') }}</textarea>

                        @if ($errors->has('answer'))
                            <span class="help-block">
                                <strong>{{ $errors->first('answer') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

				<?php $n++; ?>
				@endwhile





{{--
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
--}}

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
