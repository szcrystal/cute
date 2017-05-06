@extends('layouts.appDashBoard')

@section('content')

	<div class="clearfix">
    <h3 class="page-header">タグ一覧</h3>
    <a href="{{ url('/dashboard/tags/create') }}" class="btn btn-success pull-right">新規追加</a>
    </div>

    {{ $tags->links() }}
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-5">名前</th>
              <th class="col-md-5">スラッグ</th>

              <!-- <th class="col-md-2">View数</th> -->
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($tags as $tag)
        	<tr>
            	<td>
                	{{$tag->id}}
                </td>

				<td>
	        		<strong>{{$tag->name}}</strong>
                </td>
                                    
                <td>
                	{{ $tag->slug }}
                </td>



                <td>
                	<a style="margin:auto;" href="{{url('dashboard/tags/'.$tag->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>

                <td>
                	<form role="form" method="POST" action="{{ url('/dashboard/tags/'.$tag->id) }}">
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
    
    {{ $tags->links() }}
        
@endsection

