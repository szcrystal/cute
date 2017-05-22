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
    --}}


    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif



    <form class="form-horizontal" role="form" method="GET" action="/contribute/create">

        {{ csrf_field() }}


        <div class="mt-5 form-group{{ $errors->has('cate_id') ? ' has-error' : '' }}">
            <label for="group" class="control-label">カテゴリーは？</label>
            <div class="">
                <select class="form-control" name="cate_id">
                    <option disabled selected>選択</option>
                    @foreach($cates as $cate)

                        @if(old('cate_id') !== NULL)
                            <option value="{{ $cate->id }}"{{ old('cate_id') == $cate->id ? ' selected' : '' }}>{{ $cate->name }}</option>
                        @else
                            <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                        @endif
                    @endforeach

                </select>

                @if ($errors->has('cate_id'))
                    <span class="help-block text-danger">
                        <strong><i class="fa fa-exclamation" aria-hidden="true"></i> {{ $errors->first('cate_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>






		<div class="form-group text-center mt-5 py-3">
        	<div class="">
            	<button type="submit" class="btn btn-info btn-block py-3">　次 へ　>></button>
            </div>
        </div>


        </form>

        </div>
        
@endsection

