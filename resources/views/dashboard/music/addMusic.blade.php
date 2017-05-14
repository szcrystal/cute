@extends('layouts.appDashBoard')

@section('content')

    	
	{{-- @include('dbd_shared.search') --}}


    <h3 class="page-header">Music一覧</h3>

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

	<div class="row">
    <div class="table-responsive col-md-6">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th class="col-md-1">ID</th>
            	<th class="col-md-4">Music名</th>
              <th class="col-md-3">ファイル名</th>

              <th class="col-md-1"></th>
              
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($musics as $music)
        	<tr>
            	<td>
                	{{$music->id}}
                </td>

				<td>
	        		{{$music->name}}
                </td>

                <td>
	        		{{ str_replace('music/', '', $music->file) }}
                </td>

                <td>
                	<a style="margin:auto;" href="{{url('dashboard/movies/music/'.$music->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>

		<div class="col-md-5 col-md-offset-1">
		<form class="form-horizontal" role="form" method="POST" action="/dashboard/movies/music" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-10 text-left">Music 追加</label>
                    <div class="col-md-10">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Music名" required>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
			</div>

            <div class="form-group{{ $errors->has('music_file') ? ' has-error' : '' }}">
					<div class="col-md-10">
                        <div class="form-group{{ $errors->has('music_file') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <input id="music_file" class="" type="file" name="music_file">
                            </div>
                        </div>
                    </div>
            </div>

            <div class="form-group">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">追 加</button>
                </div>
            </div>
        </form>
        </div>
    
    <?php //echo $objs->render(); ?>
    </div>
@endsection

