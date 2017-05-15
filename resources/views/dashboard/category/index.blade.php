@extends('layouts.appDashBoard')

@section('content')

    	
	{{-- @include('dbd_shared.search') --}}

    <div class="clearfix">
    	<h3 class="page-header">カテゴリー一覧</h3>
    	<a href="{{ url('/dashboard/cates/create') }}" class="btn btn-success pull-right">新規追加</a>
    </div>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{ $cates->links() }}
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-4">名前</th>
              <th class="col-md-3">スラッグ</th>
              <th class="col-md-1">アイテム数</th>
              <th class="col-md-1">総秒数</th>
              <th class="col-md-1">記事数</th>
              <th></th>
              @if(Ctm::isDev())
              <th></th>
              @endif
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($cates as $cate)
        	<tr>
            	<td>
                	{{$cate->id}}
                </td>

				<td>
	        		<strong>{{$cate->name}}</strong>
                </td>
                                    
                <td>
                	{{ $cate->slug }}
                </td>

                <td>
					{{ $cateItem->where('cate_id', $cate->id)->count() }}
                </td>

                <td>
					{{ $cateItem->where('cate_id', $cate->id)->sum('second') }} s
                </td>

                <td>

                </td>

                {{--
                <td>
                	@if($cate->open_status)
					有効
                    @else
					<span class="text-danger">無効</span>
                    @endif
                </td>
                --}}


                <td>
                	<a href="{{ url('dashboard/cates/'.$cate->id) }}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>

				@if(Ctm::isDev())
                <td>
                	<form role="form" method="POST" action="{{ url('/dashboard/cates/'.$cate->id) }}">
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
    
    {{ $cates->links() }}
        
@endsection

