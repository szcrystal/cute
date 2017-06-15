@extends('layouts.appDashBoard')

@section('content')


    <div class="clearfix">
    	<h3 class="page-header">モデル投稿動画一覧</h3>
        @if(Ctm::isDev())
		<a href="{{ url('/dashboard/model-movies/create') }}" class="btn btn-success pull-right">新規追加</a>
        @endif
    </div>


    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{ $relObjs->links() }}
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-2">動画</th>
              <th class="col-md-2">カテゴリー</th>
              <th class="col-md-3">モデル [ID]</th>
              {{-- <th class="col-md-4">タイトル</th> --}}
              <th class="col-md-2">完成状態</th>
              <th class="col-md-2">位置情報</th>
              <th class="col-md-2">撮影日</th>

              <th></th>
              <th></th>
              @if(Ctm::isDev())
              <th></th>
              @endif
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($relObjs as $obj)
        	<?php
            	$branch = $branches->where('rel_id', $obj->id)->first();
            ?>
        	<tr>
            	<td>
                	{{$obj->id}}
                </td>

                <td>
					<video id="mainMv" width="180" height="100" controls>
                    <source src="{{ Storage::url($branch -> movie_path) }}">
        			</video>
                </td>



				<td>
                	@if($obj->cate_id)
	        		{{ $cateModel->find($obj->cate_id)->name }}
                    @else
                    --
                    @endif

                </td>

                <td>
                	@if($obj->model_id)
                    	{{ $users->find($obj->model_id)->name }}
                        [{{ $obj->model_id }}]
                    @endif
                </td>




                <td>
                    @if($obj->combine_status)
                    <span class="text-success">結合済</span>
                    @else
                    <span class="text-danger">未結合</span>
                    @endif

                </td>

                <td>
					{{ $obj->area_info }}
                </td>

                <td>
					@if($obj->created_at)
						{{ Ctm::changeDate($obj->created_at) }}
                    @else
						--
                    @endif
                </td>


                <td>
					@if($obj->combine_status)
                	<a style="margin:auto;" href="{{url('dashboard/model-movies/'.$obj->id)}}" class="btn btn-info btn-sm center-block">再結合</a>
                    @else
                    <a style="margin:auto;" href="{{url('dashboard/model-movies/'.$obj->id)}}" class="btn btn-primary btn-sm center-block">結合</a>
                    @endif
                </td>

                @if(Ctm::isDev())
                <td>
                	<form role="form" method="POST" action="{{ url('/dashboard/movies/'.$obj->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                	<input type="submit" class="btn btn-danger btn-sm center-block" value="削除">
                    </form>
                </td>
                @endif
        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
    
    {{ $relObjs->links() }}
        
@endsection

