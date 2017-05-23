@extends('layouts.appModel')

@section('content')

<div class="well">

	{{--
    <div class="clearfix">
		<h5 class="my-5">最初にカテゴリーを選択して下さい。</h5>
    </div>
    --}}

	{{--
    @if (count($errors) > 0)
        <div class="alert alert-danger mx-2">
            <strong>Error!!</strong><br>
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
    --}}

    @if(isset($status))
    	<div class="alert alert-success my-4">
            {{ $status }}
        </div>
    @endif


	@if(count($rels) > 0)
        <h5 class="clearfix second"><i class="fa fa-play-circle" aria-hidden="true"></i> 投稿中の動画があります</h5>
        <div class="all-wrap">
            <ul class="noup-list">
                @foreach($rels as $rel)
                	<?php
                    	$branch = $branches->where('rel_id', $rel->id)->get();
                        //$total = count($branch);
                        $num = 0;
                        foreach($branch as $obj) {
                            if($obj->movie_path == '') $num++;
                        }
                    ?>

                    <li class="clearfix">
                        <a href="{{ url('/contribute/'.$rel->id.'/edit')}}">
                            <span>{{ $cates->find($rel->cate_id)->name }}：{{ mb_substr($rel->memo, 0, 10) }} <i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            <small>動画残数：{{ $num }}</small>
                        </a>
                    </li>
                @endforeach
            </ul>

        </div>
    @endif


    <h5 class="my-2 clearfix second"><i class="fa fa-play-circle" aria-hidden="true"></i> 新しく動画を投稿する</h5>
    <div class="all-wrap">

    <form class="form-horizontal" role="form" method="GET" action="/contribute/create">

        {{ csrf_field() }}


        <div class="mt-5 form-group{{ $errors->has('cate_id') ? ' has-error' : '' }}">
            <label for="group" class="control-label">カテゴリーは？</label>
            <div class="">
                <select class="form-control cate_id" name="cate_id">
                    <option disabled selected>選択</option>
                    @foreach($cates as $cate)

                        @if(old('cate_id') !== NULL)
                            <option value="{{ $cate->id }}"{{ old('cate_id') == $cate->id ? ' selected' : '' }}>{{ $cate->name }}</option>
                        @else
                            <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                        @endif
                    @endforeach

                </select>

                {{-- @if ($errors->has('cate_id')) --}}
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('cate_id') }}</strong>
                    </span>
                {{-- @endif --}}
            </div>
        </div>

        <div class="mb-5 form-group{{ $errors->has('memo') ? ' has-error' : '' }}">
            <label for="memo" class="control-label">メモ</label>

            <div>
                <input id="memo" type="text" class="form-control memo" name="memo" value="{{ old('memo')}}" placeholder="店名や行き先、場所など">

				{{-- @if ($errors->has('memo')) --}}
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('memo') }}</strong>
                    </span>
                {{-- @endif --}}

            </div>
        </div>



		<div class="form-group text-center mt-5 py-3">
        	<div class="">
            	<button id="modelNext" type="submit" class="btn btn-info btn-block py-3">　次 へ　>></button>
                <span class="help-block text-danger">
                    <strong></strong>
                </span>
            </div>
        </div>


        </form>

        </div>

</div>
        
@endsection

