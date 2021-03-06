@extends('layouts.appDashBoard')

@section('content')

    	
	{{-- @include('dbd_shared.search') --}}

    <h3 class="page-header">モデル一覧</h3>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{ $users->links() }}

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>サムネイル</th>
              <th class="col-md-1">県名</th>
              <th class="col-md-2">名前</th>
              <th class="col-md-3">メールアドレス</th>
              <th class="col-md-2">フルネーム</th>
              <th class="col-md-2">登録日</th>
              <th></th>
              @if(Ctm::isDev())
              <th></th>
              @endif
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>

        <?php
            use App\State;
        ?>

    	@foreach($users as $obj)
        	<tr>
            	<td>
                	{{$obj->id}}
                </td>

                <td>
					@if($obj->model_thumb)
					<img src="{{ Storage::url($obj->model_thumb) }}" width=100 height=65>
                    @else
                    <span class="no-img">No Image</span>
                    @endif
                </td>

                <td>
					{{ State::find($obj->state_id)->name }}
                </td>

				<td>
	        		<strong>{{$obj->name}}</strong>
                </td>
                                    
                <td>
                	{{ $obj->email }}
                </td>

                <td>
					{{ $obj->full_name }}
                </td>

                <td>
                	{{ date('Y/m/d H:m', strtotime($obj->created_at)) }}
                </td>

                <td>
                	<a href="{{url('dashboard/models/'.$obj->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>

                {{--
                <td>
                	<a href="{{url('dashboard/userlogin/'.$obj->id)}}" class="btn btn-warning btn-sm center-block" target="_brank">Login</a>
                </td>
                --}}

                @if(Ctm::isDev())
                <td>
                	@if($obj->id == 1)
                    	<span class="btn center-block">--</span>
                    @else
                    <form role="form" method="POST" action="{{ url('/dashboard/users/'.$obj->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                	<input type="submit" class="btn btn-danger btn-sm center-block" value="削除">
                    </form>
                    @endif
                </td>
                @endif
        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
    
    {{ $users->links() }}
        
@endsection

