@extends('layouts.appDashBoard')

@section('content')
	
	<h3 class="page-header">
	@if(isset($edit))
    サイト詳細設定
	@else
	サイト詳細設定
    @endif
    </h3>

	{{--
    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/states') }}"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
        </div>
    </div>
    --}}

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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/settings">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{ $settingId }}">
            @endif

            {{ csrf_field() }}


            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-3 control-label">管理者名</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') === NULL && isset($setting) ? $setting->name : old('name') }}" required>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-3 control-label">管理者メール</label>

                <div class="col-md-6">
                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') === NULL && isset($setting) ? $setting->email : old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('snap_count') ? ' has-error' : '' }}">
                <label for="snap_count" class="col-md-3 control-label">モデルスナップ数</label>

                <div class="col-md-6">
                    <input id="snap_count" type="text" class="form-control" name="snap_count" value="{{ old('snap_count') === NULL && isset($setting) ? $setting->snap_count : old('snap_count') }}" placeholder="半角英数字">

                    @if ($errors->has('snap_count'))
                        <span class="help-block">
                            <strong>{{ $errors->first('snap_count') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('item_count') ? ' has-error' : '' }}">
                <label for="item_count" class="col-md-3 control-label">カテゴリーアイテム数</label>

                <div class="col-md-6">
                    <input id="item_count" type="text" class="form-control" name="item_count" value="{{ old('item_count') === NULL && isset($setting) ? $setting->item_count : old('item_count') }}" placeholder="半角英数字">

                    @if ($errors->has('item_count'))
                        <span class="help-block">
                            <strong>{{ $errors->first('item_count') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


          <div class="form-group">
            <div class="col-md-4 col-md-offset-3">
                <button type="submit" class="btn btn-primary center-block w-btn"><span class="octicon octicon-sync"></span>更　新</button>
            </div>
        </div>

        </form>

    </div>

@endsection
