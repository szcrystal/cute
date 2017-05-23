@extends('layouts.appModel')

@section('content')

    <div class="clearfix mb-3">
        <div class="pull-left">
            <a href="{{ url('/contribute') }}" class="btn btn-custom"><i class="fa fa-angle-double-left" aria-hidden="true"></i> BACK</a>
        </div>
    </div>

    <div class="alert alert-warning mb-5 pb-0">
        {{-- <strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></strong> <br> --}}
        <ul>
			<li>動画は横型で撮影して下さい
            <li>秒数を守ってね（大体でOK！）
        </ul>
    </div>
	
	<h4 class="page-header text-center my-4">
	@if(isset($edit))
    記事編集
	@else
	カテゴリー：{{ $cateName }}<br>{{ $memo }}
    @endif
    </h4>

	<div class="text-center mb-3">
    <span class="help-block text-danger">
        <strong></strong>
    </span>
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
        
    <div class="mt-3 clearfix">

        <form id="postMv" class="form-horizontal" role="form" method="POST" action="/contribute" enctype="multipart/form-data">
			@if(isset($editRelId))
                <input type="hidden" name="edit" value="{{$editRelId}}">
            @endif

            {{ csrf_field() }}

            <input type="hidden" name="cate_id" value="{{ $cateId }}">
            <input type="hidden" name="sum" value="{{ $items->sum('second') }}">
            <input type="hidden" name="item_count" value="{{ count($items) }}">
            <input type="hidden" name="memo" value="{{ $memo }}">


			<?php
            	$n = 0;
            	$accept = Ctm::isAgent('all') ? ' accept="video/*"' : ''; // capture="camera"
                $path = '';
                //print_r(old());
            ?>

            @foreach($items as $item)

                <input type="hidden" name="title[]" value="{{ $item->title }}">
                <input type="hidden" name="second[]" value="{{ $item->second }}">

                @if(isset($branches))
                    <?php
                        $branch = $branches->where('number', $item->item_num)->first();
                        $path = $branch ->movie_path;
                    ?>
                @endif

                <h5 class="clearfix second">
                    <i class="fa fa-play-circle" aria-hidden="true"></i> {{ $item->title }}

                    @if($path != '')
                    <small class="text-success">OK</small>
                    @else
                    <small class="text-danger">動画未UP</small>
                    @endif

                    <span class="pull-right">{{ $item->second }}秒</span>
                </h5>

            <div class="all-wrap">

                <div class="thumb-wrap clearfix">
                    <div class="thumb-prev">


                    	@if($path != '')
							<video src="{{ Storage::url($path) }}" class="mv" width="100%" preload="auto" controls>
                        @else
                        	<span class="no-img">No Video</span>
						@endif
                    </div>

                    <div class="form-group{{ $errors->has('movie.'.$n) ? ' has-error' : '' }}">
                        <div>
                            <input class="form-control-file post_thumb video-file" type="file" name="movie[]"{!! $accept !!} data-sec="{{ $item->second }}">

                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('movie.'. $n) }}</strong>
                                </span>
                        </div>
                    </div>

                </div>

                <div class="mb-5 form-group{{ $errors->has('subtext.'.$n) ? ' has-error' : '' }}">
                    <label for="subtext" class="control-label"></label>

                    <div>
                        <input id="subtext" type="text" class="form-control subtext" name="subtext[]" value="{{ Ctm::isOld() ? old('subtext.'.$n) : (isset($branch) ? $branch->sub_text : '') }}" placeholder="字幕用テキストを入力（20文字以内）">

                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('subtext.'.$n) }}</strong>
                            </span>

                    </div>
                </div>

                <input class="count" type="hidden" name="count[]" value="{{ $n }}">


                <hr>

                <?php $n++; ?>

            </div>

            @endforeach


		<div class="form-group text-center mt-5 py-3">
            <div class="">
                <button id="mvUp" type="submit" class="btn btn-info btn-block py-3"><i class="fa fa-cloud-upload" aria-hidden="true"></i> UPLOAD</button>
                <span class="help-block text-danger">
                    <strong></strong>
                </span>
            </div>
        </div>




        </form>

    </div>

    

@endsection
