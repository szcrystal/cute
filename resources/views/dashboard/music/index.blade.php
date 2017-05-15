@extends('layouts.appDashBoard')

@section('content')

    <div class="clearfix">
    	<h3 class="page-header">Music一覧</h3>
		<a href="{{ url('/dashboard/musics/create') }}" class="btn btn-success pull-right">新規追加</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{ $musics->links() }}
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th class="col-md-1">ID</th>
              <th class="col-md-1"></th>
              <th class="col-md-3">Music名</th>
              <th class="col-md-4">ファイル名</th>
              <th class="col-md-1">秒数</th>
              <th class="col-md-1"></th>
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
					<audio style="width:30px;" src="{{ Storage::url($music->file) }}" controls>
                </td>

				<td>
	        		{{$music->name}}
                </td>

                <td>
	        		{{ str_replace('music/', '', $music->file) }}
                </td>

                <td>
					<?php $s = $ffprobe->format(asset('storage/'. $music->file))->get('duration'); ?>
                    {{ floor($s) }} s

                </td>

                <td>
                	<a style="margin:auto;" href="{{url('dashboard/musics/'.$music->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>

                <td>
                	<form role="form" method="POST" action="{{ url('/dashboard/musics/'.$music->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                	<input type="submit" class="btn btn-danger btn-sm center-block" value="削除">
                    </form>
                </td>

        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
    
    {{ $musics->links() }}
        
@endsection

