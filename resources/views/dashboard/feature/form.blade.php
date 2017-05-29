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
                        <a href="{{ url('dashboard/articles/snsup/'. $ftId. '?feature=1') }}" class="btn btn-warning">Social UP Page >></a>
                    </div>
                </div>
            @endif

            </div>
        </div>

        <hr>

        <form class="form-horizontal" role="form" method="POST" action="/dashboard/features" enctype="multipart/form-data">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$ftId}}">
            @endif

            {{ csrf_field() }}


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
                    </div>
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








		<div style="margin:4em auto;" class="form-group">
            <div class=" col-md-9 col-md-offset-3">
                <button type="submit" class="btn btn-primary col-md-6">　更　新　</button>
            </div>
        </div>






        </form>
    </div>

    

@endsection
