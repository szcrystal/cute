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

                            @if ($errors->has('model_thumb'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('model_thumb') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>


				<div class="form-group{{ $errors->has('state_id') ? ' has-error' : '' }}">
                    <label for="group" class="col-md-3 control-label">都道府県</label>
                    <div class="col-md-8">
                        <select class="form-control" name="state_id">
                            <option disabled selected>選択</option>
                            @foreach($states as $state)

                                <?php
                                    $selected = '';
                                    if(isset($model)) {
                                        if($model->state_id == $state->id) {
                                            $selected = ' selected';
                                        }
                                    }
                                ?>

                                @if(old('state_id') !== NULL)
                                    <option value="{{ $state->id }}"{{ old('state_id') == $state->id ? ' selected' : '' }}>{{ $state->name }}</option>
                                @else
                                    <option value="{{ $state->id }}"{{ $selected }}>{{ $state->name }}</option>
                                @endif
                            @endforeach

                        </select>

                        @if ($errors->has('state_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('state_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>



                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-3 control-label">ニックネーム</small></label>

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
                    <label for="full_name" class="col-md-3 control-label">フルネーム</label>

                    <div class="col-md-8">
                        <input id="full_name" type="text" class="form-control" name="full_name" value="{{ isset($model) ? $model->full_name : old('full_name') }}">

                        @if ($errors->has('full_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('full_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-3 control-label">メールアドレス</label>

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
                        <label for="password" class="col-md-3 control-label">パスワード</label>

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

				<hr>
				<p><span style="font-weight:bold;">Twitter</span> <a href="https://apps.twitter.com" target="_brank">https://apps.twitter.com</a></p>
				<div class="form-group{{ $errors->has('tw_name') ? ' has-error' : '' }}">
                    <label for="tw_name" class="col-md-3 control-label">アカウント　@</label>

                    <div class="col-md-8">
                        <input id="tw_name" type="text" class="form-control" name="tw_name" value="{{ isset($twa) ? $twa->name : old('tw_name') }}">

                        @if ($errors->has('tw_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('tw_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('tw_pass') ? ' has-error' : '' }}">
                    <label for="tw_pass" class="col-md-3 control-label">パスワード</label>

                    <div class="col-md-8">
                    	<?php
                        	$pass = '';
                            if(isset($twa) && old('tw_pass')===null) {
                            	$pass = decrypt($twa->pass);
                            }
                            else if(old('tw_pass')!==null) {
                                $pass = old('tw_pass');
                            }
                        ?>
                        <input id="tw_pass" type="text" class="form-control" name="tw_pass" value="{{ $pass }}">

                        @if ($errors->has('tw_pass'))
                            <span class="help-block">
                                <strong>{{ $errors->first('tw_pass') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('consumer_key') ? ' has-error' : '' }}">
                    <label for="consumer_key" class="col-md-3 control-label">consumer_key</label>

                    <div class="col-md-8">
                        <input id="twitter" type="text" class="form-control" name="consumer_key" value="{{ isset($twa) ? $twa->consumer_key : old('consumer_key') }}">

                        @if ($errors->has('consumer_key'))
                            <span class="help-block">
                                <strong>{{ $errors->first('consumer_key') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('consumer_secret') ? ' has-error' : '' }}">
                    <label for="consumer_secret" class="col-md-3 control-label">consumer_secret</label>

                    <div class="col-md-8">
                        <input id="consumer_secret" type="text" class="form-control" name="consumer_secret" value="{{ isset($twa) ? $twa->consumer_secret : old('consumer_secret') }}">

                        @if ($errors->has('consumer_secret'))
                            <span class="help-block">
                                <strong>{{ $errors->first('consumer_secret') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('access_token') ? ' has-error' : '' }}">
                    <label for="access_token" class="col-md-3 control-label">access_token</label>

                    <div class="col-md-8">
                        <input id="access_token" type="text" class="form-control" name="access_token" value="{{ isset($twa) ? $twa->access_token : old('access_token') }}">

                        @if ($errors->has('access_token'))
                            <span class="help-block">
                                <strong>{{ $errors->first('access_token') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('access_token_secret') ? ' has-error' : '' }}">
                    <label for="access_token_secret" class="col-md-3 control-label">access_token_secret</label>

                    <div class="col-md-8">
                        <input id="access_token_secret" type="text" class="form-control" name="access_token_secret" value="{{ isset($twa) ? $twa->access_token_secret : old('access_token_secret') }}">

                        @if ($errors->has('access_token_secret'))
                            <span class="help-block">
                                <strong>{{ $errors->first('access_token_secret') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

				<hr>


                <div class="form-group{{ $errors->has('instagram') ? ' has-error' : '' }}">
                    <label for="instagram" class="col-md-3 control-label">インスタグラム</label>

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
                    <label for="school" class="col-md-3 control-label">学校名</label>

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
                    <label for="per_info" class="col-md-3 control-label">モデルインフォ</label>

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

				<div style="margin-bottom:3em;" class="clearfix">

				<?php
                	$n=0;
                	use App\Setting;
                    $setCount = Setting::get()->first()->snap_count;
                ?>
				@while($n < $setCount)

                <div class="form-group text-right">
                	<div class="col-md-12 checkbox">
                        <label>
                        	<?php
                            	$checked = '';
                                if(Ctm::isOld()) {
                                    if(old('del_snap.'.$n))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($article) && $article->del_snap) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>

                            <input type="hidden" name="del_snap[{{$n}}]" value="0">
                            <input type="checkbox" name="del_snap[{{$n}}]" value="1"{{ $checked }}> この項目を削除
                        </label>
                    </div>
            	</div>


				<div class="clearfix thumb-wrap">
                    <div class="col-md-4 pull-left thumb-prev">
                        @if(count(old()) > 0)
                            @if(old('snap_thumb.'.$n) != '' && old('snap_thumb.'.$n))
                            <img src="{{ Storage::url(old('snap_thumb.'.$n)) }}" class="img-fluid">
                            @elseif(isset($snaps[$n]) && $snaps[$n]->snap_path)
                            <img src="{{ Storage::url($snaps[$n]->snap_path) }}" class="img-fluid">
                            @else
                            <span class="no-img">No Image</span>
                            @endif
                        @elseif(isset($snaps[$n]) && $snaps[$n]->snap_path)
                            <img src="{{ Storage::url($snaps[$n]->snap_path) }}" class="img-fluid">
                        @else
                            <span class="no-img">No Image</span>
                        @endif
                    </div>

                    <div class="col-md-8 pull-left text-left form-group{{ $errors->has('snap_thumb.'.$n) ? ' has-error' : '' }}">
                        <label for="model_thumb" class="col-md-12 text-left">スナップ</label>
                        <div class="col-md-12">
                            <input id="model_thumb" class="thumb-file" type="file" name="snap_thumb[]">

                            @if ($errors->has('snap_thumb.'.$n))
                            <span class="help-block">
                                <strong>{{ $errors->first('snap_thumb.'.$n) }}</strong>
                            </span>
                        @endif
                        </div>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('ask.'.$n) ? ' has-error' : '' }}">
                    <label for="name" class="col-md-3 control-label">質問</label>

                    <div class="col-md-8">
                        <input id="school" type="text" class="form-control" name="ask[]" value="{{ isset($snaps[$n]) ? $snaps[$n]->ask : old('ask.'.$n) }}">

                        @if ($errors->has('ask.'.$n))
                            <span class="help-block">
                                <strong>{{ $errors->first('ask.'.$n) }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('answer.'.$n) ? ' has-error' : '' }}">
                    <label for="snap_answer" class="col-md-3 control-label">回答</label>

                    <div class="col-md-8">
                        <textarea id="snap_answer" class="form-control" name="answer[]" rows="8">{{ isset($snaps[$n]) && !count(old()) ? $snaps[$n]->answer : old('answer.'.$n) }}</textarea>

                        @if ($errors->has('answer.'.$n))
                            <span class="help-block">
                                <strong>{{ $errors->first('answer.'.$n) }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <hr>

                <input type="hidden" name="snap_count[]" value="{{ $n }}">

				<?php $n++; ?>
				@endwhile


			</div>





                <div class="form-group">
                    <div class="col-md-4 col-md-offset-4">
                        <button type="submit" class="btn btn-primary col-md-12">
                            更　新
                        </button>
                    </div>
                </div>
            </form>

        </div>




@endsection
