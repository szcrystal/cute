@extends('layouts.appDashBoard')

@section('content')
	
	<h3 class="page-header">Music編集</h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/movies/music') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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
    
    @if (isset($status))
        <div class="alert alert-success">
            {{ $status }}
        </div>
    @endif
        
    <div class="well">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/movies/music/{{ $musicId }}" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-3 control-label">Music</label>
                <div class="col-md-7">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') !== NULL ? old('name') : $music->name }}" required>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('music_file') ? ' has-error' : '' }}">
            	<p class="col-md-9 col-md-offset-3">{{ str_replace('music/', '', $music->file) }}</p>
                <div class="col-md-9 col-md-offset-3">
                    <div class="form-group{{ $errors->has('music_file') ? ' has-error' : '' }}">

                        <div class="col-md-12">
                            <input id="music_file" class="" type="file" name="music_file">
                        </div>
                    </div>
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
