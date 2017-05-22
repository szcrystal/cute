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

            <form class="form-horizontal" role="form" method="POST" action="/dashboard/models" enctype="multipart/form-data">
                {{ csrf_field() }}

                @if(isset($modelId))
                	<input type="hidden" name="model_id" value="{{$modelId}}">
                @endif

                <div class="form-group">
                    <div class="col-md-2 col-md-offset-10">
                        <button type="submit" class="btn btn-primary col-md-12">
                            更　新
                        </button>
                    </div>
                </div>

				<div class="clearfix thumb-wrap">
                    <div class="col-md-4 pull-left thumb-prev">
                        @if(count(old()) > 0)
                            @if(old('model_thumb') != '' && old('model_thumb'))
                            <img src="{{ Storage::url(old('model_thumb')) }}" class="img-fluid">
                            @elseif(isset($model) && $model->model_thumb)
                            <img src="{{ Storage::url($model->model_thumb) }}" class="img-fluid">
                            @else
                            <span class="no-img">No Image</span>
                            @endif
                        @elseif(isset($model) && $model->model_thumb)
                            <img src="{{ Storage::url($model->model_thumb) }}" class="img-fluid">
                        @else
                            <span class="no-img">No Image</span>
                        @endif
                    </div>

                    <div class="col-md-8 pull-left text-left form-group{{ $errors->has('model_thumb') ? ' has-error' : '' }}">
                        <label for="model_thumb" class="col-md-12 text-left">サムネイル</label>
                        <div class="col-md-12">
                            <input id="model_thumb" class="thumb-file" type="file" name="model_thumb">
                        </div>
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

                    <div class="col-md-8">
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

				<div class="form-group{{ $errors->has('twitter') ? ' has-error' : '' }}">
                    <label for="twitter" class="col-md-2 control-label">Twitter</label>

                    <div class="col-md-8">
                        <input id="twitter" type="text" class="form-control" name="twitter" value="{{ isset($model) ? $model->twitter : old('twitter') }}">

                        @if ($errors->has('twitter'))
                            <span class="help-block">
                                <strong>{{ $errors->first('twitter') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('instagram') ? ' has-error' : '' }}">
                    <label for="instagram" class="col-md-2 control-label">インスタグラム</label>

                    <div class="col-md-8">
                        <input id="instagram" type="text" class="form-control" name="instagram" value="{{ isset($model) ? $model->instagram : old('instagram') }}">

                        @if ($errors->has('instagram'))
                            <span class="help-block">
                                <strong>{{ $errors->first('instagram') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('school') ? ' has-error' : '' }}">
                    <label for="school" class="col-md-2 control-label">学校名</label>

                    <div class="col-md-8">
                        <input id="school" type="text" class="form-control" name="school" value="{{ isset($model) ? $model->school : old('school') }}">

                        @if ($errors->has('school'))
                            <span class="help-block">
                                <strong>{{ $errors->first('school') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

				<div class="form-group{{ $errors->has('per_info') ? ' has-error' : '' }}">
                    <label for="per_info" class="col-md-2 control-label">モデルインフォ</label>

                    <div class="col-md-8">
                        <textarea id="per_info" class="form-control" name="per_info" rows="15">{{ isset($model) && !count(old()) ? $model->per_info : old('per_info') }}</textarea>

                        @if ($errors->has('per_info'))
                            <span class="help-block">
                                <strong>{{ $errors->first('per_info') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <hr>
				<?php //パーソナル ---------------- ?>

				<div style="margin-bottom:3em;">

				<?php $n=0; ?>
				@while($n < 7)

				<div class="clearfix thumb-wrap">
                    <div class="col-md-4 pull-left thumb-prev">
                        @if(count(old()) > 0)
                            @if(old('snap_thumb') != '' && old('snap_thumb'))
                            <img src="{{ Storage::url(old('snap_thumb')) }}" class="img-fluid">
                            @elseif(isset($modelSnap) && $modelSnap->snap_thumb)
                            <img src="{{ Storage::url($model->snap_thumb) }}" class="img-fluid">
                            @else
                            <span class="no-img">No Image</span>
                            @endif
                        @elseif(isset($modelSnap) && $modelSnap->snap_thumb)
                            <img src="{{ Storage::url($model->snap_thumb) }}" class="img-fluid">
                        @else
                            <span class="no-img">No Image</span>
                        @endif
                    </div>

                    <div class="col-md-8 pull-left text-left form-group{{ $errors->has('snap_thumb.'.$n) ? ' has-error' : '' }}">
                        <label for="model_thumb" class="col-md-12 text-left">スナップ</label>
                        <div class="col-md-12">
                            <input id="model_thumb" class="thumb-file" type="file" name="snap_thumb[]">
                        </div>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('pers_ask') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-2 control-label">質問</label>

                    <div class="col-md-8">
                        <input id="school" type="text" class="form-control" name="snap_ask[]" value="{{ isset($modelSnap) ? $modelSnap->school : old('school') }}">

                        @if ($errors->has('ask'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ask') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('snap_answer') ? ' has-error' : '' }}">
                    <label for="snap_answer" class="col-md-2 control-label">回答</label>

                    <div class="col-md-8">
                        <textarea id="snap_answer" class="form-control" name="snap_answer[]" rows="8">
                        {{ isset($modelSnap) && !count(old()) ? $modelSnap->snap_answer : old('snap_answer') }}</textarea>

                        @if ($errors->has('snap_answer'))
                            <span class="help-block">
                                <strong>{{ $errors->first('snap_answer') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <hr>

				<?php $n++; ?>
				@endwhile


			</div>




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
                            更　新
                        </button>
                    </div>
                </div>
            </form>

        </div>




@endsection
