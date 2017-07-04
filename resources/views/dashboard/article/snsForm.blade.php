@extends('layouts.appDashBoard')

@section('content')



	<h3 class="page-header">
	@if(isset($edit))
    SNS UP
	@else
	SNS UP
    @endif
    </h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
        	@if($mvId)
            <a href="{{ url('/dashboard/articles') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
            @else
            <a href="{{ url('/dashboard/features') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
            @endif
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
        <div class="alert alert-warning">
            {!! session('status') !!}
        </div>
    @endif
        
	<div class="well clearfix">

        <div class="text-left">
        	@if(isset($mv) && $mv->movie_path != '')
            <video id="mainMv" width="480" height="270" poster="" controls>
                <source src="{{ Storage::url($mv->movie_path) }}">
            </video>
            @else
            <span>No Video</span>
            @endif

        </div>

        <hr>

		{{--
		<div class="bs-component clearfix">
            <div class="pull-left">
            	@if($mvId)
                	<a href="{{ url('/dashboard/articles/'. $atclId) }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>編集へ戻る</a>
                @else
					<a href="{{ url('/dashboard/features/'. $atclId) }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>編集へ戻る</a>
                @endif
            </div>
        </div>
        --}}


    @if (session('ytStatus'))
        <div class="alert alert-success">
            {!! session('ytStatus') !!}
        </div>
    @endif

        <form class="form-horizontal" role="form" method="POST" action="/dashboard/articles/snsup/{{$atclId}}" enctype="multipart/form-data">
			@if(isset($edit))
                <input type="hidden" name="atcl_id" value="{{$atclId}}">
            @endif

            {{ csrf_field() }}

            <input type="hidden" name="movie_id" value="{{ $mvId }}">

            <div style="margin-bottom:2em;" class="clearfix">
            	<p class="pull-left col-md-12"><b>YouTubeへの送信内容</b><br>訂正する場合は戻って更新し直して下さい。</p>
                @if($atcl->feature)
                    <?php $backUrl = url('/dashboard/features/'. $atclId); ?>
                @else
                    <?php $backUrl = url('/dashboard/articles/'. $atclId); ?>
                @endif

                <a href="{{ $backUrl }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>編集へ戻る</a>

                <div class="btn-group-md pull-right col-md-7">
                        <div class="pull-right text-right">
                        	{{--
                            @if(!$atcl->yt_id)
								<p class="text-warning text-small">YouTubeにUP済みです</p>
                            @endif
                            --}}
                            <div class="col-md-12 pull-right">
                            	@if(! $atcl->feature && ! $mvId)
									<p class="text-warning text-small">この記事のYouTubeUPは出来ません。</p>
                                    <input type="submit" id="ytUp" class="btn btn-danger" name="ytUp" value="YouTubeUP" disabled>
                                @else
                                	<input type="submit" id="ytUp" class="btn btn-danger" name="ytUp" value="YouTubeUP">
                                @endif
                            </div>
                        </div>
            	</div>

            </div>


			<div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">タイトル</label>

                <div class="col-md-9">
					<p style="margin-top: 0.4em;" class="">{{ $atcl->title }}</p>
                    <input type="hidden" name="title" value="{{ $atcl->title }}">

                </div>
            </div>

            <div class="form-group{{ $errors->has('yt_description') ? ' has-error' : '' }}">
                <label for="yt_description" class="col-md-3 control-label">YouTube用 説明</label>

                <div class="col-md-9">
					<p style="margin-top: 0.4em;" class="">{!! nl2br($atcl->yt_description) !!}</p>
                    <input type="hidden" name="description" value="{{ $atcl->yt_description }}">

                </div>
            </div>

			<div class="tag-wrap clearfix form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">タグ</label>

                    <div class="tag-area">
                        <div class="col-md-9">
                        	<span><em>cute.campus</em></span>

                            @if(isset($tagNames))
                                @foreach($tagNames as $name)
                                <span><em>{{ $name }}</em></span>
                                <input type="hidden" name="tags[]" value="{{ $name }}">
                                @endforeach
                            @endif
                        </div>
                    </div>
            </div>



            <hr>



	@if (session('twStatus'))
        <div class="alert alert-success">
        	<ul>
        	@foreach(session('twStatus') as $s)
            	<li>{!! $s !!}
            @endforeach
            </ul>
        </div>
    @endif

		<div style="margin-bottom: 2em;" class="clearfix">
            <p class="pull-left col-md-12"><b>Twitter/FBへの送信内容</b><br>訂正する場合は戻って更新し直して下さい。</p>
            @if($atcl->feature)
            	<?php $backUrl = url('/dashboard/features/'. $atclId); ?>
            @else
            	<?php $backUrl = url('/dashboard/articles/'. $atclId); ?>
            @endif

            <a href="{{ $backUrl }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>編集へ戻る</a>
        </div>

		<div class="clearfix">
        	<div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">タイトル</label>

                <div class="col-md-9">
					<p style="margin-top: 0.4em;" class="">{{ $atcl->title }}</p>

                </div>
            </div>

        	<div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">コメント</label>

                <div class="col-md-9">
                	<?php $str = mb_substr($atcl->contents, 0, 30); ?>
					<p style="margin-top: 0.4em;" class="">{{ $str }}...</p>
                    <input type="hidden" name="tw_comment" value="{{ $str }}">

                </div>
            </div>


            <div class="form-group{{ $errors->has('addModel_id') ? ' has-error' : '' }}">
                <label for="addModel_id" class="col-md-3 control-label">追加モデル for Twitter</label>
                <div class="col-md-6">
                    <select class="form-control" name="addModel_id">
						<option disabled selected>選択</option>

                        <?php $idNum = 2; ?>

                        @if(Auth::guard('admin')->id() == 2)
                        	<?php $idNum = 1; ?>
                        @endif

                        @foreach($users as $user)
							@if($user->id > $idNum && $atcl->model_id != $user->id)
                                @if(old('user_id') !== NULL)
                                    <option value="{{ $user->id }}"{{ old('user_id') == $user->id ? ' selected' : '' }}>{{ $user->name }}</option>
                                @else
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endif
                        @endforeach

                    </select>

                    @if ($errors->has('addModel_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('addModel_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div style="padding-bottom:6em;" class="btn-group-md pull-right">
                    <div class="col-md-6 pull-left">
                    	{{--
                        @if($atcl->tw_up)
                            <p class="col-md-12 text-warning text-small">TwitterにUP済みです</p>
                        @endif
                        --}}
                        <input type="submit" id="twFbUp" class="btn btn-success center-block w-btn" name="twFbUp" value="TW FB UP">
                    </div>

            </div>

        </div>


	</form>




    </div>

    

@endsection
