@extends('layouts.appDashBoard')

@section('content')
	
	<h3 class="page-header">
	@if(isset($edit))
    基本情報編集
	@else
	動画新規追加
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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/articles">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

            {{ csrf_field() }}

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
                            <input type="checkbox" name="del_status" value="1"{{ $checked }}> 非公開にする
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">オーナー</label>

                <div class="col-md-7">


                    @if ($errors->has('admin_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('admin_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            
            <div class="form-group{{ $errors->has('cate_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">カテゴリー</label>

                <div class="col-md-7">


                    @if ($errors->has('cate_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cate_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title" class="col-md-2 control-label">タイトル</label>

                <div class="col-md-10">
                    <input id="title" type="text" class="form-control" name="title" value="{{ Ctm::isOld() ? old('title') : (isset($article) ? $article->title : '') }}" required>

                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

                {{--
                <div class="form-group{{ $errors->has('sumbnail') ? ' has-error' : '' }}">
                    <label for="sumbnail" class="col-md-4 control-label">サムネイル</label>

                    <div class="col-md-6">
                        <input id="sumbnail" type="text" class="form-control" name="sumbnail" value="{{ isset($article) ? $article->sumbnail : old('sumbnail') }}" required autofocus>

                        @if ($errors->has('sumbnail'))
                            <span class="help-block">
                                <strong>{{ $errors->first('sumbnail') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('sumbnail_url') ? ' has-error' : '' }}">
                    <label for="sumbnail_url" class="col-md-4 control-label">サムネイル引用元URL</label>

                    <div class="col-md-6">
                        <input id="sumbnail_url" type="text" class="form-control" name="sumbnail_url" value="{{ isset($article) ? $article->sumbnail_url : old('sumbnail_url') }}" required autofocus>

                        @if ($errors->has('sumbnail_url'))
                            <span class="help-block">
                                <strong>{{ $errors->first('sumbnail_url') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                --}}

                {{--
                <div class="form-group{{ $errors->has('tag_1') ? ' has-error' : '' }}">
                    <label for="tag_1" class="col-md-4 control-label">タグ１</label>

                    <div class="checkbox">
                        @foreach($tags[0] as $tag)
                        <label>
                            <input type="checkbox" name="tag_1[]" value="{{$tag->id}}"{{isset($article) && strpos($article->tag_1, (string)$tag->id) !== false ? ' checked' : '' }}> {{$tag->name}}
                        </label>
                        @endforeach

                    </div>
                </div>

                <div class="form-group{{ $errors->has('tag_2') ? ' has-error' : '' }}">
                    <label for="tag_2" class="col-md-4 control-label">タグ２</label>

                    <div class="checkbox">
                        @foreach($tags[1] as $tag) {
                        <label>
                            <input type="checkbox" name="tag_2[]" value="{{$tag->id}}"{{isset($article) && strpos($article->tag_2, (string)$tag->id) !== false ? ' checked' : '' }}> {{$tag->name}}
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="form-group{{ $errors->has('tag_3') ? ' has-error' : '' }}">
                    <label for="tag_3" class="col-md-4 control-label">タグ３</label>

                    <div class="checkbox">
                        <div class="checkbox">
                        @foreach($tags[2] as $tag)
                        <label>
                            <input type="checkbox" name="tag_3[]" value="{{$tag->id}}"{{isset($article) && strpos($article->tag_3, (string)$tag->id) !== false ? ' checked' : '' }}> {{$tag->name}}
                        </label>
                        @endforeach
                    </div>
                    </div>
                </div>
                --}}

                <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                    <label for="slug" class="col-md-2 control-label">スラッグ（URL）</label>

                    <div class="col-md-10">
                        <input id="slug" type="text" class="form-control" name="slug" value="{{ Ctm::isOld() ? old('slug') : (isset($article) ? $article->slug : '') }}" required placeholder="半角英数字とハイフンのみ">

                        @if ($errors->has('slug'))
                            <span class="help-block">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>



        
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
                    <label for="story_sub_title" class="col-md-4 control-label">オプション（サブタイトル？）</label>

                    <div class="col-md-6">
                        <input id="story_sub_title" type="text" class="form-control" name="story_sub_title" value="{{ old('story_sub_title') }}" required autofocus>

                        @if ($errors->has('story_sub_title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('story_sub_title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('story_text') ? ' has-error' : '' }}">
                    <label for="story_text" class="col-md-4 control-label">テキスト</label>

                    <div class="col-md-6">
                        <textarea id="story_text" type="text" class="form-control" name="story_text" value="{{ old('story_text') }}" required></textarea>

                        @if ($errors->has('story_text'))
                            <span class="help-block">
                                <strong>{{ $errors->first('story_text') }}</strong>
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

    


          <div class="form-group">
            <div class="col-md-4 col-md-offset-3">
                <button type="submit" class="btn btn-primary center-block w-btn"><span class="octicon octicon-sync"></span>更　新</button>
            </div>
        </div>

        </form>

    </div>

    

@endsection
