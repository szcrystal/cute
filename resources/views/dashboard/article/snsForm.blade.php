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
            {!! session('status') !!}
        </div>
    @endif
        
	<div class="well clearfix">

        <div class="text-center">
        	@if(isset($mv) && $mv->movie_path != '')
            <video id="mainMv" width="480" height="270" poster="" controls>
                <source src="{{ Storage::url($mv->movie_path) }}">
            </video>
            @else
            <span>No Video</span>
            @endif

        </div>

        <hr>

		<div class="bs-component clearfix">
            <div class="pull-left">
                <a href="{{ url('/dashboard/articles/'. $atclId) }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>編集へ戻る</a>
            </div>
        </div>


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

            <div class="clearfix">
            	<p class="pull-left col-md-5">YouTubeには以下の情報が送信されます。<br>訂正する場合は戻って更新し直して下さい。</p>
                <div class="btn-group-md pull-right col-md-7">
                    @if(Ctm::isDev())
                        <div class="pull-right">
                            <div class="col-md-6 pull-left">
                                <input type="submit" id="ytUp" class="btn btn-danger center-block w-btn" name="ytUp" value="YouTubeUP">
                            </div>
                        </div>
                    @endif
            	</div>

            </div>


			<div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">タイトル</label>

                <div class="col-md-9">
					<p style="margin-top: 0.3em;" class="">{{ $atcl->title }}</p>
                    <input type="hidden" name="title" value="{{ $atcl->title }}">

                </div>
            </div>

            <div class="form-group{{ $errors->has('yt_description') ? ' has-error' : '' }}">
                <label for="yt_description" class="col-md-3 control-label">コメント</label>

                <div class="col-md-9">
					<p style="margin-top: 0.3em;" class="">{{ $atcl->yt_description }}</p>
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
            {!! session('twStatus') !!}
        </div>
    @endif



		<div class="clearfix">
        	<div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">タイトル</label>

                <div class="col-md-9">
					<p style="margin-top: 0.3em;" class="">{{ $atcl->title }}</p>

                </div>
            </div>

        	<div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">コメント</label>

                <div class="col-md-9">
                	<?php $str = mb_substr($atcl->basic_info,0, 15); ?>
					<p style="margin-top: 0.3em;" class="">{{ $str }}...</p>
                    <input type="hidden" name="tw_comment" value="{{ $str }}">

                </div>
            </div>


            <div class="form-group{{ $errors->has('group_id') ? ' has-error' : '' }}">
                <label for="group" class="col-md-3 control-label">Twitter モデル</label>
                <div class="col-md-6">
                    <select class="form-control" name="user_id">
						<option disabled selected>選択</option>
                        @foreach($users as $user)

                            @if(old('user_id') !== NULL)
                                <option value="{{ $user->id }}"{{ old('user_id') == $user->id ? ' selected' : '' }}>新田あやか</option>
                            @else
                                <option value="{{ $user->id }}"{{ isset($atcl) && $atcl->model_id == $user->id ? ' selected' : '' }}>新田あやか</option>
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

            <div class="btn-group-md pull-right">
                @if(Ctm::isDev())
                    <div class="pull-left">
                        <div class="col-md-6 pull-left">
                            <input type="submit" id="twFbUp" class="btn btn-info center-block w-btn" name="twFbUp" value="TW FB UP">
                        </div>
                    </div>
                @endif
            </div>

        </div>


	</form>




    </div>

    

@endsection
