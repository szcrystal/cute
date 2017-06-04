@extends('layouts.appDashBoard')

@section('content')
	
	<h3 class="page-header">
	@if(isset($edit))
    カテゴリー編集
	@else
	カテゴリー新規追加
    @endif
    </h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/cates') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/cates">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-3 control-label">カテゴリー名</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') === NULL && isset($cate) ? $cate->name : old('name') }}" required>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                <label for="slug" class="col-md-3 control-label">スラッグ</label>

                <div class="col-md-6">
                    <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug') === NULL && isset($cate) ? $cate->slug : old('slug') }}" required>

                    @if ($errors->has('slug'))
                        <span class="help-block">
                            <strong>{{ $errors->first('slug') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <hr>
            <h4>アイテム</h4>

            <?php
                $n=0;
                use App\Setting;
                $setCount = Setting::get()->first()->item_count;
            ?>

            @while($n < $setCount)

                <div class="form-group text-right">
                	<div class="col-md-12 checkbox">
                        <label>
                        	<?php
                            	$checked = '';
                                if(Ctm::isOld()) {
                                    if(old('del_item.'.$n))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($article) && $article->del_item) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>

                            <input type="hidden" name="del_item[{{$n}}]" value="0">
                            <input type="checkbox" name="del_item[{{$n}}]" value="1"{{ $checked }}> この項目を削除
                        </label>
                    </div>
            	</div>

            	<div class="form-group{{ $errors->has('title.'. $n) ? ' has-error' : '' }}">
                    <label for="title" class="col-md-3 control-label">タイトル</label>

                    <div class="col-md-6">
                        <input id="title" type="text" class="form-control" name="title[]" value="{{ old('title')[$n] === NULL && isset($cateItem[$n]) ? $cateItem[$n]->title : old('title')[$n] }}">

                        @if ($errors->has('title.'. $n))
                            <span class="help-block">
                                <strong>{{ $errors->first('title.'. $n) }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div style="margin-bottom:4em;" class="clearfix form-group{{ $errors->has('second.'. $n) ? ' has-error' : '' }}">
                    <label for="second" class="col-md-3 control-label">秒数</label>

                    <div class="col-md-3">
                        <input id="second" type="text" class="form-control" name="second[]" value="{{ old('second')[$n] === NULL && isset($cateItem[$n]) ? $cateItem[$n]->second : old('second')[$n] }}">

                        @if ($errors->has('second.'. $n))
                            <span class="help-block">
                                <strong>{{ $errors->first('second.'. $n) }}</strong>
                            </span>
                        @endif
                    </div>
                    <p style="margin-top:0.4em;" class="pull-left text-left">秒</p>
                </div>

                <hr>

                <input type="hidden" name="item_num[]" value="{{ $n+1 }}">

                <?php $n++; ?>

            @endwhile



          <div class="form-group">
            <div class="col-md-4 col-md-offset-3">
                <button type="submit" class="btn btn-primary center-block w-btn"><span class="octicon octicon-sync"></span>更　新</button>
            </div>
        </div>

        </form>

    </div>

@endsection
