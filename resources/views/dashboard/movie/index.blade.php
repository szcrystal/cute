@extends('layouts.appDashBoard')

@section('content')


    <div class="clearfix">
    	<h3 class="page-header">動画一覧</h3>
        @if(Ctm::isDev())
		<a href="{{ url('/dashboard/movies/create') }}" class="btn btn-success pull-right">新規追加</a>
        @endif
    </div>

    {{-- <span>＊動画の読み込みに時間が掛かります</span> --}}

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{ $mvObjs->links() }}
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-2">動画</th>
              <th class="col-md-2">カテゴリー</th>
              <th class="col-md-3">モデル [ID]</th>
              {{-- <th class="col-md-4">タイトル</th> --}}
              <th class="col-md-2">記事状態</th>
              {{-- <th class="col-md-2">位置情報</th> --}}
              <th class="col-md-2">撮影日</th>

              <th></th>
              @if(Ctm::isDev())
              <th></th>
              @endif
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($mvObjs as $obj)
        	<tr>
            	<td>
                	{{$obj->id}}
                </td>

                <td>
					<video id="mainMv" width="180" height="100" poster="" controls>
                    <source src="{{ Storage::url($obj -> movie_path) }}">
                    </video>

                </td>

				{{--
                <td>
                	@if($obj -> movie_thumb)
                        <img src="{{ Storage::url($obj -> movie_thumb) }}">
                    @else
                        <span class="no-img">No Image</span>
                    @endif
				</td>
                --}}

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
                	@if(!$obj->atcl_status)
                	<a style="margin:auto;" href="{{url('dashboard/articles/create?mvId='.$obj->id)}}" class="btn btn-info btn-sm center-block">記事作成</a>
                    @else
						<span class="text-primary">記事作成済</span>
                    @endif
                </td>

                {{--
                <td>
                	{{ $obj->title }}
                </td>
                

                <td>
                    @if($obj->open_status)
                    <span class="text-success">公開中</span>
                    @else
                    <span class="text-warning">未公開</span>
                    @endif

                </td>
                

                <td>
					{{ $obj->area }}
                </td>
                --}}

                <td>
					@if($obj->created_at)
						{{ Ctm::changeDate($obj->created_at) }}
                    @else
						--
                    @endif
                </td>


                <td>
                	<a style="margin:auto;" href="{{url('dashboard/movies/'.$obj->id)}}" class="btn btn-primary btn-sm center-block">動画</a>
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
    
    {{ $mvObjs->links() }}
        
@endsection

