@extends('layouts.appDashBoard')

@section('content')
	
	<h3 class="page-header">
	@if(isset($edit))
    動画確認
	@else
	動画確認
    @endif
    </h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/movies') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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


    <div class="well clearfix">
        <div class="col-md-4 pull-right text-right">
			@if($mvCombine->atcl_status)
            	<small class="text-warning">記事作成済みです</small>
                <?php $atcl = $atcls->where('movie_id', $mvCombine->id)->first(); ?>
				<a href="{{ url('dashboard/articles/'. $atcl->id) }}" class="btn btn-success center-block">この動画の記事を編集 >></a>
            @else
            <a href="{{ url('dashboard/articles/create/?mvId='. $mvCombine->id) }}" class="btn btn-info center-block">この動画の記事を作成 >></a>
            @endif
        </div>

		<div class="text-center">
            <video id="mainMv" width="800" height="500" poster="" controls>
                <source src="{{ Storage::url($mvCombine -> movie_path) }}">
            </video>
        </div>

        <hr>

        <form class="form-horizontal" role="form" method="POST" action="/dashboard/articles" enctype="multipart/form-data">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

            {{ csrf_field() }}

			<div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">撮影日</label>

                <div style="margin-top:0.4em;" class="col-md-9">
                	{{ $mvCombine->created_at }}
                </div>
            </div>

            <div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">モデル</label>

                <div style="margin-top:0.4em;" class="col-md-9">
                	{{ $modelName }}
                </div>
            </div>

            <div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">カテゴリー</label>

                <div style="margin-top:0.4em;" class="col-md-9">
                	{{ $cates->find($mvCombine->cate_id)->name }}
                </div>
            </div>

            <div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">メモ</label>

                <div style="margin-top:0.4em;" class="col-md-9">
                	{{ $memo }}
                </div>
            </div>

            <div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">Music</label>

                <div style="margin-top:0.4em;" class="col-md-9">
                	<?php use App\Music;
                    	$music = Music::find($mvCombine->music_id);
                    ?>
                	{{ $music->name }} （{{ str_replace('music/', '', $music->file) }}）
                </div>
            </div>


			@if(Ctm::isDev())
            <div class="form-group{{ $errors->has('group_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">カテゴリー</label>
                <div class="col-md-6">
                    <select class="form-control" name="cate_id">
						<option disabled selected>選択</option>
                        @foreach($cates as $cate)

                            @if(old('cate_id') !== NULL)
                                <option value="{{ $cate->id }}"{{ old('cate_id') == $cate->id ? ' selected' : '' }}>{{ $cate->name }}</option>
                            @else
                                <option value="{{ $cate->id }}"{{ isset($mvCombine) && $mvCombine->cate_id == $cate->id ? ' selected' : '' }}>{{ $cate->name }}</option>
                            @endif
                        @endforeach

                    </select>

                    @if ($errors->has('cate_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cate_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

			<div class="form-group{{ $errors->has('area') ? ' has-error' : '' }}">
                <label for="title" class="col-md-3 control-label">位置情報</label>

                <div class="col-md-9">
                    <input id="area" type="text" class="form-control" name="area" value="{{ Ctm::isOld() ? old('area') : (isset($mvCombine) ? $mvCombine->area : '') }}" required>

                    @if ($errors->has('area'))
                        <span class="help-block">
                            <strong>{{ $errors->first('area') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            @endif



			@if(Ctm::isDev())

			<div class="form-group{{ $errors->has('group_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">フィルター</label>
                <div class="col-md-6">
                    <select class="form-control" name="cate_id">
						<option disabled selected>選択</option>
                        @foreach($cates as $cate)

                            @if(old('cate_id') !== NULL)
                                <option value="{{ $cate->id }}"{{ old('cate_id') == $cate->id ? ' selected' : '' }}>{{ $cate->name }}</option>
                            @else
                                <option value="{{ $cate->id }}"{{ isset($mvCombine) && $mvCombine->cate_id == $cate->id ? ' selected' : '' }}>{{ $cate->name }}</option>
                            @endif
                        @endforeach

                    </select>

                    @if ($errors->has('cate_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cate_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('group_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">音楽</label>
                <div class="col-md-6">
                    <select class="form-control" name="cate_id">
						<option disabled selected>選択</option>
                        @foreach($cates as $cate)

                            @if(old('cate_id') !== NULL)
                                <option value="{{ $cate->id }}"{{ old('cate_id') == $cate->id ? ' selected' : '' }}>{{ $cate->name }}</option>
                            @else
                                <option value="{{ $cate->id }}"{{ isset($mvCombine) && $mvCombine->cate_id == $cate->id ? ' selected' : '' }}>{{ $cate->name }}</option>
                            @endif
                        @endforeach

                    </select>

                    @if ($errors->has('cate_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cate_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            @endif

			@if(Ctm::isDev())
			<div class="form-group">
                <div class="col-md-4 col-md-offset-3">
                    <button type="submit" class="btn btn-primary center-block w-btn">更　新</button>
                </div>
        	</div>
            @endif

        </form>

		<div class="col-md-12 text-right">
            <a href="{{ url('dashboard/model-movies/' . $mvCombine->rel_id) }}" class="btn btn-warning center-block">この動画を結合し直す >></a>
        </div>

    </div>


    

@endsection
