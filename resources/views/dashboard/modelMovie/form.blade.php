@extends('layouts.appDashBoard')

@section('content')
	
	<h3 class="page-header">
	@if(isset($rel) && $rel->combine_status)
	動画結合（再結合）
	@else
    動画結合（新規）
    @endif
    </h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/model-movies') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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

        <div class="form-group clearfix">
            <label for="group" class="col-md-3 control-label text-right">撮影日</label>

            <div class="col-md-9">
                {{ $rel-> created_at }}
            </div>
        </div>

		<div class="form-group clearfix">
            <label for="group" class="col-md-3 control-label text-right">モデル</label>

            <div class="col-md-9">
                {{ $modelName }}
            </div>
        </div>

        <div class="form-group clearfix">
            <label for="group" class="col-md-3 control-label text-right">カテゴリー</label>

            <div class="col-md-9">
                {{ $cateName }}
            </div>
        </div>

        <div class="form-group clearfix">
            <label for="group" class="col-md-3 control-label text-right">メモ</label>

            <div class="col-md-9">
                {{ $rel->memo }}
            </div>
        </div>



		{{--
		<div class="form-group clearfix">
            <label for="group" class="col-md-3 control-label text-right">エリア</label>

            <div class="col-md-9">
                {{ $rel->area }}
            </div>
        </div>
        --}}

        <hr>

        <form class="form-horizontal" role="form" method="POST" action="/dashboard/model-movies" enctype="multipart/form-data">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

            {{ csrf_field() }}

            <input type="hidden" name="rel_id" value="{{ $relId }}">


            <div class="form-group{{ $errors->has('music_id') ? ' has-error' : '' }}">
                <label for="music_id" class="col-md-3 control-label">Music</label>
                <div class="col-md-6">
                    <select class="form-control" name="music_id">
						<option disabled selected>選択</option>
                        @foreach($musics as $music)

                            @if(old('music_id') !== NULL)
                                <option value="{{ $music->id }}"{{ old('music_id') == $music->id ? ' selected' : '' }}>{{ $music->name }} ({{ $music->second }}s)</option>
                            @else
                                <option value="{{ $music->id }}"{{ isset($combine) && $combine->music_id == $music->id ? ' selected' : '' }}>{{ $music->name }} ({{ $music->second }}s)</option>
                            @endif
                        @endforeach

                    </select>

                    @if ($errors->has('music_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('music_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

			<div class="form-group{{ $errors->has('filter_id') ? ' has-error' : '' }}">
                <label for="filter_id" class="col-md-3 control-label">フィルター</label>
                <div class="col-md-6">
                    <select class="form-control" name="filter_id">
						<?php $filters = [
                        	1=>'ノーマル',
                            2=>'モノクロ',
                            3=>'昔感',
                            4=>'色薄め',
                            5=>'色暗め',
                            6=>'色濃いめ',
                            7=>'白黒（ピンク味）',
                            8=>'ノイズ',
                            9=>'オーバーレイ',
                            10=>'ヴィンテージ（黄味）',
                        ];
                        ?>

						<option disabled selected>選択</option>
                        {{-- @foreach($filters as $filter) --}}

                            @if(old('filter_id') !== NULL)
                            	@foreach($filters as $key => $filter)
									<option value="{{ $key }}"{{ old('filter_id') == $key ? ' selected' : '' }}>{{ $filter }}</option>
                                @endforeach


                            @else
                            	@foreach($filters as $key => $filter)
									<option value="{{ $key }}"{{ isset($combine) && $combine->filter_id == $key ? ' selected' : '' }}>{{ $filter }}</option>
                                @endforeach

                            @endif
                        {{-- @endforeach --}}

                    </select>

                    @if ($errors->has('filter_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('filter_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>



			<?php $n = 0; ?>

            <div style="margin: 2.5em 0;">
            	<p style="font-weight:bold;">合計秒：{{ $branches->sum('second') }}秒</p>

                @foreach($branches as $obj)
                    <div class="clearfix">
                        <h5><i class="fa fa-square" aria-hidden="true"></i> {{ $obj->title }} [{{ $obj->second }}秒]</h5>

                        <div class="pull-left col-md-3">
                            <video src="{{ Storage::url($obj->movie_path) }}" width="200" height="auto" controls>
                        </div>

                        <div class="col-md-9 pull-left form-group{{ $errors->has('subtext.'.$n) ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input style="color:#222;" class="form-control" type="text" name="subtext[]" value="{{ isset($obj) && !count(old()) ? $obj->sub_text : old('subtext.'.$n) }}">

                                <input type="hidden" name="moviesec[]" value="{{ $obj->second }}">

                                @if ($errors->has('subtext.'.$n))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subtext.'.$n) }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <?php $n++; ?>

                @endforeach

            </div>


			<div class="form-group">
                <div class="col-md-offset-4">
                    <button type="submit" class="col-md-6 btn btn-primary">結　合</button>
                </div>
        	</div>

        </form>

    </div>

    

@endsection
