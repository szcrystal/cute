@extends('layouts.appDashBoard')

@section('content')

	<div class="clearfix">
    <h3 class="page-header">都道府県一覧</h3>
    <a href="{{ url('/dashboard/states/create') }}" class="btn btn-success pull-right">新規追加</a>
    </div>

    {{ $states->links() }}
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-5">名前</th>
              <th class="col-md-5">スラッグ</th>

              <th></th>
              @if(Ctm::isDev())
              <th></th>
              @endif
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($states as $obj)
        	<tr>
            	<td>
                	{{$obj->id}}
                </td>

				<td>
	        		<strong>{{$obj->name}}</strong>
                </td>
                                    
                <td>
                	{{ $obj->slug }}
                </td>



                <td>
                	<a style="margin:auto;" href="{{url('dashboard/states/'.$obj->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>

				@if(Ctm::isDev())
                <td>
                	<form role="form" method="POST" action="{{ url('/dashboard/states/'.$obj->id) }}">
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
    
    {{ $states->links() }}
        
@endsection

