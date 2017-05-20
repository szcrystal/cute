@extends('layouts.appModel')

@section('content')

    <div class="clearfix">


    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form class="form-horizontal" role="form" method="GET" action="/contribute/create">

            {{ csrf_field() }}


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






		<div style="margin-top: 4em;"class="form-group">
            <div class=" col-md-9 col-md-offset-3">
                <button type="submit" class="btn btn-primary w-btn">　次 へ　>></button>
            </div>
        </div>


        </form>
        
@endsection

