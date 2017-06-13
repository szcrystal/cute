@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12 py-5">
            <div>
                <div>
					<div class="movie-frame text-center">
                        @if(isset($model->model_thumb))
                        	<img src="{{ Storage::url($model->model_thumb) }}" width="100%" height="auto">
                        @else
                        	<span class="no-img">No Image</span>
                        @endif

                    </div>

                    <h2>{{ $model -> name }}</h2>
				</div>

                <div class="panel-body">
                    <div class="table-responsive py-3">
                    	<table class="table table-bordered">
                            <colgroup>
                                <col class="cth">
                                <col class="ctd">
                            </colgroup>
                            
                            <tbody>
                            	<tr>
                                    <th>名前</th>
                                    <td>{{ $model->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>ニックネーム</th>
                                    <td>{{ $model->name }}</td>
                                </tr>

                                <tr>
                                    <th>学校</th>
                                    <td>{{ $model->school }}</td>
                                </tr>

                                <tr>
                                    <th>Twitter</th>
                                    <td><a href="https://twitter.com/{{ $twa->name }}">＠{{ $twa->name }}</a></td>
                                </tr>

                                <tr>
									<th>Instagram</th>
                                    <td><a href="https://www.instagram.com/{{ $model->instagram }}">{{ $model->instagram }}</a></td>
                                </tr>



                            </tbody>
                		</table>
                    </div>

                    <div>
                    	<div class="clearfix">
                            <div class="col-md-8 mx-auto">
                                {{ $model->per_info }}

                            </div>

                            <div class="col-md-6 float-right">

                            </div>
                        </div>


                        <div class="rv-content mt-5 pb-5">

                                @foreach($snaps as $snap)
                                    <div class="snap-wrap">
                                    	@if(isset($snap->snap_path))
                                        <img src="{{ Storage::url($snap->snap_path)}}">
                                        @endif
                                        <h4>{{ $snap->ask }}</h4>
                                        <p>{{ $snap->answer}}</p>
                                    </div>
                                @endforeach

                        </div>


                	</div>

				</div><!-- panelbody -->

            </div>
        </div>
    </div>
@endsection
