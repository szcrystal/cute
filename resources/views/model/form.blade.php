@extends('layouts.appModel')

@section('content')
	
	<h3 class="page-header">
	@if(isset($edit))
    記事編集
	@else
	{{ $cateName }}
    @endif
    </h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/contribute') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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

        <form class="form-horizontal" role="form" method="POST" action="/contribute" enctype="multipart/form-data">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

            {{ csrf_field() }}

            <input type="hidden" name="cate_id" value="{{ $cateId }}">
            <input type="hidden" name="sum" value="{{ $items->sum('second') }}">

			<?php
            	$n = 0;
            	$accept = Ctm::isAgent('all') ? ' accept="video/*"' : ''; // capture="camera"
                
                //print_r(old());
            ?>

            @foreach($items as $item)

            <h5 class="col-md-12">{{ $item->title }} <b>{{ $item->second }}秒</b></h5>

            <div class="thumb-wrap clearfix">
				<div class="col-md-4 pull-left thumb-prev">
                    <span class="no-img">No Video</span>
                </div>

                <div class="col-md12 form-group{{ $errors->has('movie.'.$n) ? ' has-error' : '' }}">

                    <div class="col-md-12">
                        <input id="post_thumb" class="post_thumb video-file" type="file" name="movie[]"{!! $accept !!} data-sec="{{ $item->second }}">

                        {{-- @if ($errors->has('movie.'. $n)) --}}
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('movie.'. $n) }}</strong>
                            </span>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>

                <div style="margin-bottom: 3em;" class="form-group{{ $errors->has('subtext.'.$n) ? ' has-error' : '' }}">
                    <label for="subtext" class="col-md-12 control-label">字幕テキスト</label>

                    <div class="col-md-12">
                        <input id="subtext" type="text" class="form-control subtext" name="subtext[]" value="{{ old('subtext.'.$n)}}" placeholder="字幕用テキスト 20文字以内">


                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('subtext.'.$n) }}</strong>
                            </span>

                    </div>
                </div>

                <input class="count" type="hidden" name="count[]" value="{{ $n }}">


                <hr>

            <?php $n++; ?>
            
            @endforeach


		<div style="margin-top: 4em;"class="form-group">
            <div class=" col-md-9 col-md-offset-3">
                <button id="mvUp" type="submit" class="btn btn-primary w-btn">　更　新　</button>
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('subtext.'.$n) }}</strong>
                </span>
            </div>
        </div>


        </form>

    </div>

    

@endsection
