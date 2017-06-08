@extends('layouts.appDashBoard')

@section('content')

    <div class="clearfix">
    	<h3 class="page-header">特集一覧</h3>
		<a href="{{ url('/dashboard/features/create') }}" class="btn btn-success pull-right">新規追加</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{ $features->links() }}
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>

              <th class="col-md-2">動画</th>
              <th class="col-md-2">サムネイル</th>
              <th class="col-md-2">カテゴリー</th>
              <th class="col-md-3">タイトル</th>
              <th class="col-md-1">公開状態</th>
              <th class="col-md-2">公開日</th>
              <th></th>
              @if(Ctm::isDev())
              <th></th>
              @endif
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($features as $obj)
        	<tr>
            	<td>
                	{{$obj->id}}
                </td>

                <td>
                	@if($obj->movie_path)
					<video src="{{ Storage::url($obj->movie_path) }}" width=140 height=80 controls>
                    @else
                    <span class="no-img">No Image</span>
                    @endif
                </td>

                <td>
                	@if($obj->thumb_path)
					<img src="{{ Storage::url($obj->thumb_path) }}" width=120 height=80>
                    @else
                    <span class="no-img">No Image</span>
                    @endif
                </td>

                <td>
                	@if($obj->cate_id)
	        			{{ $cateModel->find($obj->cate_id)->name }}
                        @if(!$cateModel->find($obj->cate_id)->status)
							<small class="text-danger">非公開</small>
                        @endif
                    @else
                    --
                    @endif

                </td>

				<td>
					{{ $obj->title }}
                </td>


                <td>
                    @if($obj->open_status)
                    <span class="text-success">公開中</span>
                    @else
                    <span class="text-warning">未公開（保存済）</span>
                    @endif

                </td>


                <td>
                    {{ $obj->updated_at }}
                </td>


                <td>
                	<a style="margin:auto;" href="{{url('dashboard/features/'.$obj->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
                @if(Ctm::isDev())
                <td>
                	<form role="form" method="POST" action="{{ url('/dashboard/features/'.$obj->id) }}">
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
    
    {{ $features->links() }}
        
@endsection

