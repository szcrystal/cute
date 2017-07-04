@extends('layouts.appDashBoard')

@section('content')



	<h3 class="page-header">
	@if(isset($edit))
    特集記事 編集
	@else
	特集記事 新規追加
    @endif
    </h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/features') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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

        <div class="clearfix">
        <div class="col-md-6 btn-group-md pull-right">

            @if(isset($edit))
                <div class="col-md-7 pull-left">
                    <div class="pull-left">
                        <ul>
                            @if(!$feature->yt_up)
                            <li>YouTube：<span class="text-danger">未UP</span>
                            @else
                            <li>YouTube：<span class="text-success">UP済み</span>
                            @endif

                            @if(!$feature->tw_up)
                            <li>Twitter：<span class="text-danger">未UP</span>
                            @else
                            <li>Twitter：<span class="text-success">UP済み</span>
                            @endif

                            @if(!$feature->fb_up)
                            <li>FaceBook：<span class="text-danger">未UP</span>
                            @else
                            <li>FaceBook：<span class="text-success">UP済み</span>
                            @endif

                        </ul>
                    </div>
                </div>


                <div class="col-md-4 pull-left">
                    <div class="pull-left">
                        <a href="{{ url('dashboard/articles/snsup/'. $ftId) }}" class="btn btn-info">SNS UP Page >></a>
                    </div>
                </div>
            @endif

            </div>
        </div>

        <hr>

        <form class="form-horizontal" role="form" method="POST" action="/dashboard/articles" enctype="multipart/form-data">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$ftId}}">
            @endif

            {{ csrf_field() }}

            <input type="hidden" name="feature" value="1">


            <div class="form-group">
                <div class="col-md-12 text-right">
                    <div class="checkbox">
                        <label>
                        	<?php
                            	$checked = '';
                                if(Ctm::isOld()) {
                                    if(old('open_status'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($feature) && ! $feature->open_status) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="open_status" value="1"{{ $checked }}> この記事を非公開にする
                        </label>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div style="margin-left: 1.5em;" class="col-md-10 text-left">
                    <div class="checkbox">
                        <label>
                        	<?php
                            	$checked = '';
                                if(Ctm::isOld()) {
                                    if(old('pick_up'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($atcl) && $atcl->pick_up) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="pick_up" value="1"{{ $checked }}> この記事をPickUpする
                        </label>
                    </div>
                </div>
            </div>


			<div class="clearfix thumb-wrap">
                <div class="col-md-4 pull-left thumb-prev">
                    @if(count(old()) > 0)
                        @if(old('post_movie') != '' && old('post_movie'))
                        <video src="{{ Storage::url(old('post_movie')) }}" class="img-fluid" controls>
                        @elseif(isset($feature) && $feature->movie_path)
                        <video src="{{ Storage::url($feature->movie_path) }}" class="img-fluid" controls>
                        @else
                        <span class="no-img">No Image</span>
                        @endif
                    @elseif(isset($feature) && $feature->movie_path)
                        <video src="{{ Storage::url($feature->movie_path) }}" class="img-fluid" controls>
                    @else
                        <span class="no-img">No Video</span>
                    @endif
                </div>

                <div class="col-md-8 pull-left text-left form-group{{ $errors->has('post_movie') ? ' has-error' : '' }}">
					<label for="post_movie" class="col-md-12">動画</label><br>
                    <div class="col-md-12">
                        <input id="post_movie" class="post_thumb post_movie video-file" type="file" name="post_movie">

                        @if ($errors->has('post_movie'))
                            <span class="help-block">
                                <strong>{{ $errors->first('post_movie') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>


            <div class="clearfix thumb-wrap">
                <div class="col-md-4 pull-left thumb-prev">
                    @if(count(old()) > 0)
                        @if(old('post_thumb') != '' && old('post_thumb'))
                        <img src="{{ Storage::url(old('post_thumb')) }}" class="img-fluid">
                        @elseif(isset($feature) && $feature->post_thumb)
                        <img src="{{ Storage::url($feature->thumb_path) }}" class="img-fluid">
                        @else
                        <span class="no-img">No Image</span>
                        @endif
                    @elseif(isset($feature) && $feature->thumb_path)
                        <img src="{{ Storage::url($feature->thumb_path) }}" class="img-fluid">
                    @else
                        <span class="no-img">No Image</span>
                    @endif
                </div>

                <div class="col-md-8 pull-left text-left form-group{{ $errors->has('post_thumb') ? ' has-error' : '' }}">
					<label for="post_thumb" class="col-md-12">サムネイル</label><br>
                    <div class="col-md-12">
                        <input id="post_thumb" class="post_thumb thumb-file" type="file" name="post_thumb">

                        @if ($errors->has('post_thumb'))
                            <span class="help-block">
                                <strong>{{ $errors->first('post_thumb') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>


            <div class="form-group{{ $errors->has('cate_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-2 control-label">特集カテゴリー</label>
                <div class="col-md-7">
                    <select class="form-control" name="cate_id" required>
						<option disabled selected>選択</option>
                        @foreach($cates as $cate)

                            <?php
                            	$selected = '';
                            	if(isset($feature)) {
                                	if($feature->cate_id == $cate->id) {
                                    	$selected = ' selected';
                                    }
                                }
                            ?>

                            @if(old('cate_id') !== NULL)
                                <option value="{{ $cate->id }}"{{ old('cate_id') == $cate->id ? ' selected' : '' }}>{{ $cate->name }}</option>
                            @else
                                <option value="{{ $cate->id }}"{{ $selected }}>{{ $cate->name }}</option>
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

            <div class="form-group{{ $errors->has('state_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-2 control-label">都道府県</label>
                <div class="col-md-7">
                    <select class="form-control" name="state_id" required>
						<option disabled selected>選択</option>
                        @foreach($states as $state)

                            <?php
                            	$selected = '';
                            	if(isset($feature)) {
                                	if($feature->state_id == $state->id) {
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




            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title" class="col-md-2 control-label">タイトル</label>

                <div class="col-md-9">
                    <input id="title" type="text" class="form-control" name="title" value="{{ Ctm::isOld() ? old('title') : (isset($feature) ? $feature->title : '') }}" required>

                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="address" class="col-md-2 control-label">住所</label>

                <div class="col-md-9">
                    <input id="address" type="text" class="form-control" name="address" value="{{ Ctm::isOld() ? old('address') : (isset($feature) ? $feature->address : '') }}">

                    @if ($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

			{{--
            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                <label for="slug" class="col-md-2 control-label">スラッグ（URL）</label>

                <div class="col-md-9">
                    <input id="slug" type="text" class="form-control" name="slug" value="{{ Ctm::isOld() ? old('slug') : (isset($atcl) ? $atcl->slug : '') }}" required placeholder="半角英数字とハイフンのみ">

                    @if ($errors->has('slug'))
                        <span class="help-block">
                            <strong>{{ $errors->first('slug') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            --}}

            <div class="form-group{{ $errors->has('contents') ? ' has-error' : '' }}">
                <label for="contents" class="col-md-2 control-label">コンテンツ</label>

                <div class="col-md-9">
                    <textarea id="contents" type="text" class="form-control" name="contents" rows="15">{{ isset($feature) && !count(old()) ? $feature->contents : old('feature') }}</textarea>

                    @if ($errors->has('contents'))
                        <span class="help-block">
                            <strong>{{ $errors->first('contents') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('yt_description') ? ' has-error' : '' }}">
                <label for="yt_description" class="col-md-2 control-label">YouTube用 説明</label>

                <div class="col-md-9">
                    <textarea id="yt_description" type="text" class="form-control" name="yt_description" rows="10">{{ isset($feature) && !count(old()) ? $feature->yt_description : old('yt_description') }}</textarea>

                    @if ($errors->has('yt_description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('yt_description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('yt_id') ? ' has-error' : '' }}">
                <label for="yt_id" class="col-md-2 control-label">YouTube ID</label>

                <div class="col-md-5">
                    <input id="yt_id" type="text" class="form-control" name="yt_id" value="{{ Ctm::isOld() ? old('yt_id') : (isset($feature) ? $feature->yt_id : '') }}" placeholder="既にYouTubeUP済の場合そのIDを入力">

                    @if ($errors->has('yt_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('yt_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="clearfix tag-wrap">

                <div class="tag-group form-group{{ $errors->has('tag-group') ? ' has-error' : '' }}">
                    <label for="tag-group" class="col-md-2 control-label">タグ</label>
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



		<div style="margin:4em auto;" class="form-group">
            <div class=" col-md-9 col-md-offset-3">
                <button type="submit" class="btn btn-primary col-md-6">　更　新　</button>
            </div>
        </div>






        </form>
    </div>

    

@endsection
