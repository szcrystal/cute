@extends('layouts.appDashBoard')

@section('content')

    <div class="clearfix">
    	<h3 class="page-header">記事一覧</h3>
        @if(Ctm::isDev())
		<a href="{{ url('/dashboard/articles/create') }}" class="btn btn-success pull-right">新規追加</a>
        @endif
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
              <th>サムネイル</th>
              <th class="col-md-2">カテゴリー</th>
              <th class="col-md-1">県名</th>
              <th class="col-md-3">タイトル</th>
              <th class="col-md-2">公開状態</th>
              <th class="col-md-2">SNS</th>
              <th class="col-md-1">公開日</th>
              <th class="col-md-3">モデル [ID]</th>
              <th></th>
              @if(Ctm::isDev())
              <th></th>
              @endif
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
                	@if($obj->thumb_path)
					<img src="{{ Storage::url($obj->thumb_path) }}" width=120 height=80>
                    @else
                    <span class="no-img">No Image</span>
                    @endif
                </td>

				<td>
                	@if($obj->cate_id)
	        		{{ $cateModel->find($obj->cate_id)->name }}
                    @else
                    --
                    @endif

                </td>

                <td>
                	{{ $states->find($obj->state_id)->name }}
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
					<ul style="list-style:none; padding-left:0;">
                        @if(!$obj->yt_up)
                        <li>YT: <span class="text-danger">未UP</span>
                        @else
                        <li>YT: <span class="text-success">UP済み</span>
                        @endif

                        @if(!$obj->tw_up)
                        <li>TW: <span class="text-danger">未UP</span>
                        @else
                        <li>TW: <span class="text-success">UP済み</span>
                        @endif

                        @if(!$obj->fb_up)
                        <li>FB: <span class="text-danger">未UP</span>
                        @else
                        <li>FB: <span class="text-success">UP済み</span>
                        @endif

                    </ul>
                </td>

                <td>
					@if($obj->open_date)
						<small>{{ $obj->created_at }}</small>
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
                	<a style="margin:auto;" href="{{url('dashboard/articles/'.$obj->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
                @if(Ctm::isDev())
                <td>
                	<form role="form" method="POST" action="{{ url('/dashboard/articles/'.$obj->id) }}">
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
    
    {{ $atclObjs->links() }}
        
@endsection

