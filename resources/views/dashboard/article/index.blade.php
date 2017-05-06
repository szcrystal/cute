@extends('layouts.appDashBoard')

@section('content')

    <div class="clearfix">
    	<h3 class="page-header">記事一覧</h3>
		<a href="{{ url('/dashboard/articles/create') }}" class="btn btn-success pull-right">新規追加</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{ $atclObjs->links() }}
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-2">カテゴリー</th>
              <th class="col-md-4">タイトル</th>
              <th class="col-md-2">公開状態</th>
              <th class="col-md-2">公開日</th>
              <th class="col-md-3">モデル（ID）</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($atclObjs as $obj)
        	<tr>
            	<td>
                	{{$obj->id}}
                </td>

				<td>

                	@if($obj->cate_id)
	        		{{ $cateModel->find($obj->cate_id)->name }}
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
					@if($obj->open_date)
						{{ $obj->open_date }}
                    @else
						--
                    @endif
                </td>
                <td>
                	@if($obj->model_id)
                    	{{ $users->find($obj->model_id)->name }}
                        （{{ $obj->model_id }}）
                    @endif
                </td>

                <td>
                	<a style="margin:auto;" href="{{url('dashboard/articles/'.$obj->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
                <td>
                	<form role="form" method="POST" action="{{ url('/dashboard/articles/'.$obj->id) }}">
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
    
    {{ $atclObjs->links() }}
        
@endsection

