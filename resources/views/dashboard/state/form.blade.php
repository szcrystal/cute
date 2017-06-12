@extends('layouts.appDashBoard')

@section('content')
	
	<h3 class="page-header">
	@if(isset($edit))
    都道府県 編集
	@else
	都道府県 新規追加
    @endif
    </h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/states') }}"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
        </div>
    </div>

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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/states">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{ $stateId }}">
            @endif

            {{ csrf_field() }}


            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-3 control-label">県名</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') === NULL && isset($state) ? $state->name : old('name') }}" required>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                <label for="slug" class="col-md-3 control-label">スラッグ</label>

                <div class="col-md-6">
                    <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug') === NULL && isset($state) ? $state->slug : old('slug') }}" placeholder="半角英数字 ハイフンのみ" required>

                    @if ($errors->has('slug'))
                        <span class="help-block">
                            <strong>{{ $errors->first('slug') }}</strong>
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
