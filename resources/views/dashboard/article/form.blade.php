@extends('layouts.appDashBoard')

@section('content')



	<h3 class="page-header">
	@if(isset($edit))
    記事編集
	@else
	記事新規追加
    @endif
    </h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/articles') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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

        <div class="text-center">
        	@if(isset($mv) && $mv->movie_path != '')
            <video id="mainMv" width="800" height="500" poster="" controls>
                <source src="{{ Storage::url($mv->movie_path) }}">
            </video>
            @else
            <span>No Video</span>
            @endif

        </div>

        <hr>

        <div class="clearfix">
            <div class="col-md-6 btn-group-md pull-right">

                {{-- @if(Auth::guard('admin')->id() == 2) --}}
                	@if(isset($edit))
                	<div class="col-md-7 pull-left">
                        <div class="pull-left">
                            <ul>
                            	@if(!$atcl->yt_up)
								<li>YouTube：<span class="text-danger">未UP</span>
                                @else
                                <li>YouTube：<span class="text-success">UP済み</span>
                                @endif

                                @if(!$atcl->tw_up)
								<li>Twitter：<span class="text-danger">未UP</span>
                                @else
                                <li>Twitter：<span class="text-success">UP済み</span>
                                @endif

                                @if(!$atcl->fb_up)
								<li>FaceBook：<span class="text-danger">未UP</span>
                                @else
                                <li>FaceBook：<span class="text-success">UP済み</span>
                                @endif

                            </ul>
                        </div>
                    </div>


					<div class="col-md-4 pull-left">
                        <div class="pull-left">
                            <a href="{{ url('dashboard/articles/snsup/'. $id) }}" class="btn btn-success">Social UP Page >></a>
                        </div>
                    </div>
                {{-- @endif --}}

				{{--
                <div class="pull-left">
                    <form class="form-horizontal" role="form" method="POST" action="/dashboard/articles/ytup" enctype="multipart/form-data">
                    	{{ csrf_field() }}
                        <div class="col-md-6 pull-left">
                            <input id="ytUp" type="button" class="btn btn-danger center-block w-btn" value="YouTubeUP">
                        </div>
                    </form>
                </div>
                

				<div class="pull-left">
                    <form class="form-horizontal" role="form" method="POST" action="/dashboard/articles/twitter" enctype="multipart/form-data">
						{{ csrf_field() }}

                        <div class="col-md-4 pull-left">

                            <button type="submit" class="btn btn-success center-block w-btn">SNS UP</button>

                        </div>
                    </form>
                </div>
                --}}

                @endif

            </div>
        </div>

        <hr>


        <form class="form-horizontal" role="form" method="POST" action="/dashboard/articles" enctype="multipart/form-data">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

            {{ csrf_field() }}

            <input type="hidden" name="movie_id" value="{{ $mvId }}">

			{{--
            <div class="clearfix">
                <div class="btn-group-md pull-right">
                    @if(Ctm::isDev())
                        <div class="pull-left">
                                <div class="col-md-6 pull-left">
                                    <input type="submit" id="ytUp" class="btn btn-danger center-block w-btn" name="ytUp" value="YouTubeUP">
                                </div>
                        </div>
                    @endif
                </div>
            </div>
            --}}

            <div class="form-group">
                <div class="col-md-7 col-md-offset-3">
                    <div class="checkbox">
                        <label>
                        	<?php
                            	$checked = '';
                                if(Ctm::isOld()) {
                                    if(old('del_status'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($article) && $article->del_status) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="open_status" value="1"{{ $checked }}> この記事を非公開にする
                        </label>
                    </div>
                </div>
            </div>

			<div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">モデル名</label>

                <div class="col-md-9">
					<p style="margin-top: 0.3em;" class="">{{ $modelName }}</p>
                    <input type="hidden" name="model_id" value="{{ $mv->model_id}}"

                    @if ($errors->has('model_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('model_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

			<div class="clearfix thumb-wrap">
                <div class="col-md-3 pull-left thumb-prev">
                    @if(count(old()) > 0)
                        @if(old('post_thumb') != '' && old('post_thumb'))
                        <img src="{{ Storage::url(old('post_thumb')) }}" class="img-fluid">
                        @elseif(isset($atcl) && $atcl->post_thumb)
                        <img src="{{ Storage::url($atcl->post_thumb) }}" class="img-fluid">
                        @else
                        <span class="no-img">No Image</span>
                        @endif
                    @elseif(isset($atcl) && $atcl->post_thumb)
                        <img src="{{ Storage::url($atcl->post_thumb) }}" class="img-fluid">
                    @else
                        <span class="no-img">No Image</span>
                    @endif
                </div>

                <div class="col-md-9 pull-left text-left form-group{{ $errors->has('post_thumb') ? ' has-error' : '' }}">
					<label for="post_thumb" class="col-md-12">記事サムネイル</label><br>
                    <div class="col-md-12">
                        <input id="post_thumb" class="post_thumb thumb-file" type="file" name="post_thumb">
                    </div>
                </div>
            </div>




            <div class="form-group{{ $errors->has('group_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">カテゴリー</label>
                <div class="col-md-6">
                    <select class="form-control" name="cate_id">
						<option disabled selected>選択</option>
                        @foreach($cates as $cate)

                            @if(old('cate_id') !== NULL)
                                <option value="{{ $cate->id }}"{{ old('cate_id') == $cate->id ? ' selected' : '' }}>{{ $cate->name }}</option>
                            @else
                                <option value="{{ $cate->id }}"{{ isset($atcl) && $atcl->cate_id == $cate->id ? ' selected' : '' }}>{{ $cate->name }}</option>
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

			{{--
            <div class="form-group{{ $errors->has('group_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">位置情報</label>
                <div class="col-md-6">
                    <select class="form-control" name="group_id">
                    	<option disabled selected>選択</option>

                    
                        @foreach($groups as $group)
                            @if(old('group_id') !== NULL)
                                <option value="{{ $group->id }}"{{ old('group_id') == $group->id ? ' selected' : '' }}>{{ $group->name }}</option>
                            @else
                                <option value="{{ $group->id }}"{{ isset($tag) && $tag->group_id == $group->id ? ' selected' : '' }}>{{ $group->name }}</option>
                            @endif
                        @endforeach
                        

						<option>愛媛</option>
                        <option>香川</option>
                    </select>

                    @if ($errors->has('group_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('group_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            --}}



			<div class="form-group{{ $errors->has('area_info') ? ' has-error' : '' }}">
                <label for="area_info" class="col-md-3 control-label">住所</label>

                <div class="col-md-8">
                    <input id="area_info" type="text" class="form-control" name="area_info" value="{{ Ctm::isOld() ? old('area_info') : (isset($atcl) ? $atcl->area_info : '') }}">

                    @if ($errors->has('area_info'))
                        <span class="help-block">
                            <strong>{{ $errors->first('area_info') }}</strong>
                        </span>
                    @endif
                </div>
            </div>



            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title" class="col-md-3 control-label">タイトル</label>

                <div class="col-md-8">
                    <input id="title" type="text" class="form-control" name="title" value="{{ Ctm::isOld() ? old('title') : (isset($atcl) ? $atcl->title : '') }}" required>

                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

			{{--
            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                <label for="slug" class="col-md-3 control-label">スラッグ（URL）</label>

                <div class="col-md-8">
                    <input id="slug" type="text" class="form-control" name="slug" value="{{ Ctm::isOld() ? old('slug') : (isset($atcl) ? $atcl->slug : '') }}" required placeholder="半角英数字とハイフンのみ">

                    @if ($errors->has('slug'))
                        <span class="help-block">
                            <strong>{{ $errors->first('slug') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            --}}

            <div class="form-group{{ $errors->has('basic_info') ? ' has-error' : '' }}">
                <label for="basic_info" class="col-md-3 control-label">基本情報</label>

                <div class="col-md-8">
                    <textarea id="basic_info" type="text" class="form-control" name="basic_info" rows="15">{{ isset($atcl) && !count(old()) ? $atcl->basic_info : old('basic_info') }}</textarea>

                    @if ($errors->has('basic_info'))
                        <span class="help-block">
                            <strong>{{ $errors->first('basic_info') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('yt_description') ? ' has-error' : '' }}">
                <label for="yt_description" class="col-md-3 control-label">YouTube用 説明</label>

                <div class="col-md-8">
                    <textarea id="yt_description" type="text" class="form-control" name="yt_description" rows="10">{{ isset($atcl) && !count(old()) ? $atcl->yt_description : old('yt_description') }}</textarea>

                    @if ($errors->has('yt_description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('yt_description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="clearfix tag-wrap">

                <div class="tag-group form-group{{ $errors->has('tag-group') ? ' has-error' : '' }}">
                    <label for="tag-group" class="col-md-3 control-label">タグ</label>
                    <div class="col-md-9 clearfix">
                        <input id="tag-group" type="text" class="form-control tag-control" name="input-tag-group" value="" autocomplete="off">

                        <div class="add-btn" tabindex="0">追加</div>

                        <span style="display:none;">{{ implode(',', $allTags) }}</span>

                        <div class="tag-area">
                            @if(count(old()) > 0)
                                <?php
                                	//$tagNames = old($tag->slug);
                                	$tagNames = old('tags');
                                ?>
							@endif

                            @if(isset($tagNames))
                                @foreach($tagNames as $name)
                                <span><em>{{ $name }}</em><i class="fa fa-times del-tag" aria-hidden="true"></i></span>
                                <input type="hidden" name="tags[]" value="{{ $name }}">
                                @endforeach
                            @endif

                        </div>

                    </div>

                </div>

            </div><?php //tagwrap ?>


		<div class="form-group">
            <div class=" col-md-9 col-md-offset-3">
                <button type="submit" class="btn btn-primary col-md-6 w-btn">　更　新　</button>
            </div>
        </div>






        </form>
    </div>

    

@endsection
