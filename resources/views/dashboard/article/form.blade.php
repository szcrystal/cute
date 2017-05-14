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
            <video id="mainMv" width="800" height="500" poster="" controls>
                <source src="{{ Storage::url($mv->movie_path) }}" type='video/mp4' />
            </video>
        </div>

        <hr>

        <form class="form-horizontal" role="form" method="POST" action="/dashboard/articles" enctype="multipart/form-data">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

            {{ csrf_field() }}

            <input type="hidden" name="movie_id" value="{{ $mvId }}">

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

            <div class="form-group{{ $errors->has('group_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">位置情報</label>
                <div class="col-md-6">
                    <select class="form-control" name="group_id">
                    	<option disabled selected>選択</option>

                        {{--
                        @foreach($groups as $group)
                            @if(old('group_id') !== NULL)
                                <option value="{{ $group->id }}"{{ old('group_id') == $group->id ? ' selected' : '' }}>{{ $group->name }}</option>
                            @else
                                <option value="{{ $group->id }}"{{ isset($tag) && $tag->group_id == $group->id ? ' selected' : '' }}>{{ $group->name }}</option>
                            @endif
                        @endforeach
                        --}}

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




            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title" class="col-md-3 control-label">タイトル</label>

                <div class="col-md-9">
                    <input id="title" type="text" class="form-control" name="title" value="{{ Ctm::isOld() ? old('title') : (isset($atcl) ? $atcl->title : '') }}" required>

                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                <label for="slug" class="col-md-3 control-label">スラッグ（URL）</label>

                <div class="col-md-9">
                    <input id="slug" type="text" class="form-control" name="slug" value="{{ Ctm::isOld() ? old('slug') : (isset($atcl) ? $atcl->slug : '') }}" required placeholder="半角英数字とハイフンのみ">

                    @if ($errors->has('slug'))
                        <span class="help-block">
                            <strong>{{ $errors->first('slug') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('basic_info') ? ' has-error' : '' }}">
                <label for="basic_info" class="col-md-3 control-label">基本情報</label>

                <div class="col-md-9">
                    <textarea id="basic_info" type="text" class="form-control" name="basic_info" rows="15">{{ isset($atcl) && !count(old()) ? $atcl->basic_info : old('basic_info') }}</textarea>

                    @if ($errors->has('basic_info'))
                        <span class="help-block">
                            <strong>{{ $errors->first('basic_info') }}</strong>
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



{{--
                <p>記事内容 ----------</p>

                <div class="form-group{{ $errors->has('story_title') ? ' has-error' : '' }}">
                    <label for="title" class="col-md-4 control-label">タイトル</label>

                    <div class="col-md-6">
                        <input id="story_title" type="text" class="form-control" name="story_title" value="{{ old('story_title') }}" required autofocus>

                        @if ($errors->has('story_title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('story_title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('story_sub_title') ? ' has-error' : '' }}">
                    <label for="story_sub_title" class="col-md-4 control-label">オプション（サブタイトル）</label>

                    <div class="col-md-6">
                        <input id="story_sub_title" type="text" class="form-control" name="story_sub_title" value="{{ old('story_sub_title') }}" required autofocus>

                        @if ($errors->has('story_sub_title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('story_sub_title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                

                <p>画像 -----------</p>
                <div class="form-group{{ $errors->has('image_title') ? ' has-error' : '' }}">
                    <label for="image_title" class="col-md-4 control-label">画像タイトル</label>

                    <div class="col-md-6">
                        <input id="image_title" type="text" class="form-control" name="image_title" value="{{ old('image_title') }}" required autofocus>

                        @if ($errors->has('image_title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image_title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('image_path') ? ' has-error' : '' }}">
                    <label for="image_path" class="col-md-4 control-label">画像パス</label>

                    <div class="col-md-6">
                        <input id="image_path" type="text" class="form-control" name="image_path" value="{{ old('image_path') }}" required autofocus>

                        @if ($errors->has('image_path'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image_path') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('image_url') ? ' has-error' : '' }}">
                    <label for="image_url" class="col-md-4 control-label">引用元URL</label>

                    <div class="col-md-6">
                        <input id="image_url" type="text" class="form-control" name="image_url" value="{{ old('image_url') }}" required autofocus>

                        @if ($errors->has('image_url'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image_url') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('image_comment') ? ' has-error' : '' }}">
                    <label for="image_comment" class="col-md-4 control-label">コメント</label>

                    <div class="col-md-6">
                        <textarea id="image_comment" type="text" class="form-control" name="image_comment" value="{{ old('image_comment') }}" required></textarea>

                        @if ($errors->has('image_comment'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image_comment') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <p>リンク -----------</p>
                <div class="form-group{{ $errors->has('link_title') ? ' has-error' : '' }}">
                    <label for="link_title" class="col-md-4 control-label">リンクタイトル</label>

                    <div class="col-md-6">
                        <input id="link_title" type="text" class="form-control" name="link_title" value="{{ old('link_title') }}" required autofocus>

                        @if ($errors->has('link_title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('link_title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('link_url') ? ' has-error' : '' }}">
                    <label for="link_url" class="col-md-4 control-label">リンクURL</label>

                    <div class="col-md-6">
                        <input id="link_url" type="text" class="form-control" name="link_url" value="{{ old('link_url') }}" required autofocus>

                        @if ($errors->has('link_url'))
                            <span class="help-block">
                                <strong>{{ $errors->first('link_url') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('link_image_url') ? ' has-error' : '' }}">
                    <label for="link_image_url" class="col-md-4 control-label">画像URL</label>

                    <div class="col-md-6">
                        <input id="link_image_url" type="text" class="form-control" name="link_image_url" value="{{ old('link_image_url') }}" required autofocus>

                        @if ($errors->has('link_image_url'))
                            <span class="help-block">
                                <strong>{{ $errors->first('link_image_url') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('link_option') ? ' has-error' : '' }}">
                        <label for="link_option" class="col-md-4 control-label">オプション</label>

                        <div class="col-md-6">
                            <select class="form-control" name="link_option">
                                <option value="通常リンク">通常リンク</option>
                                <option value="タイプA">ボタンタイプA</option>
                                <option value="タイプB">ボタンタイプB</option>
                            </select>

                            @if ($errors->has('link_option'))
                            <span class="help-block">
                                <strong>{{ $errors->first('link_option') }}</strong>
                            </span>
                            @endif
                        </div>
                </div>
--}}

		<div class="form-group">
            <div class=" col-md-9 col-md-offset-3">
                <button type="submit" class="btn btn-primary w-btn">　更　新　</button>
            </div>
        </div>


		<div class="clearfix">
                <div class="btn-group-md pull-right">
                    <div class="col-md-6 pull-left">
                        <button type="submit" class="btn btn-danger center-block w-btn">YouTube UP</button>
                    </div>

                    <div class="col-md-4 pull-left">
                        <button type="submit" class="btn btn-success center-block w-btn">SNS UP</button>
                    </div>
                </div>
            </div>



        </form>

    </div>

    

@endsection
