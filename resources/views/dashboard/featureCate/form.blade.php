@extends('layouts.appDashBoard')

@section('content')
	
	<h3 class="page-header">
	@if(isset($edit))
    特集カテゴリー編集
	@else
	特集カテゴリー新規追加
    @endif
    </h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/featurecates') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/featurecates" enctype="multipart/form-data">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

            {{ csrf_field() }}

            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <div class="checkbox">
                        <label>
                        	<?php
                            	$checked = '';
                                if(Ctm::isOld()) {
                                    if(old('status'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($cate) && ! $cate->status) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="status" value="1"{{ $checked }}> 非公開にする
                        </label>
                    </div>
                </div>
            </div>

			<div class="clearfix thumb-wrap">
                <div class="col-md-4 pull-left thumb-prev">
                    @if(count(old()) > 0)
                        @if(old('cate_thumb') != '' && old('cate_thumb'))
                        <img src="{{ Storage::url(old('cate_thumb')) }}" class="img-fluid">
                        @elseif(isset($cate) && $cate->cate_thumb)
                        <img src="{{ Storage::url($$cate->cate_thumb) }}" class="img-fluid">
                        @else
                        <span class="no-img">No Image</span>
                        @endif
                    @elseif(isset($cate) && $cate->cate_thumb)
                        <img src="{{ Storage::url($cate->cate_thumb) }}" class="img-fluid">
                    @else
                        <span class="no-img">No Image</span>
                    @endif
                </div>

                <div class="col-md-8 pull-left text-left form-group{{ $errors->has('cate_thumb') ? ' has-error' : '' }}">
					<label for="cate_thumb" class="col-md-12">サムネイル</label><br>
                    <div class="col-md-12">
                        <input id="cate_thumb" class="post_thumb thumb-file" type="file" name="cate_thumb">

                        @if ($errors->has('cate_thumb'))
                            <span class="help-block">
                                <strong>{{ $errors->first('cate_thumb') }}</strong>
                            </span>
                        @endif

                    </div>
                </div>
            </div>


            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-3 control-label">カテゴリー名</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') === NULL && isset($cate) ? $cate->name : old('name') }}" required>

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
                    <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug') === NULL && isset($cate) ? $cate->slug : old('slug') }}" required>

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
