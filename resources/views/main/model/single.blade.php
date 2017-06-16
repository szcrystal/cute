@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12 single">

            <div class="thumb-frame text-center">
                @if(isset($model->model_thumb))
                    <img src="{{ Storage::url($model->model_thumb) }}" width="100%" height="auto">
                @else
                    <span class="no-img">No Image</span>
                @endif

            </div>


            <div class="panel-body">
                <div class="cont-wrap">

                    <h2>{{ $model -> name }}</h2>

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
                                    <td><a href="https://twitter.com/{{ $twa->name }}" target="_brank">＠{{ $twa->name }}</a></td>
                                </tr>

                                <tr>
									<th>Instagram</th>
                                    <td><a href="https://www.instagram.com/{{ $model->instagram }}" target="_brank">{{ $model->instagram }}</a></td>
                                </tr>

                                <tr>
									<th>投稿した記事</th>
                                    <td></td>
                                </tr>



                            </tbody>
                		</table>
                    </div>

                    <div class="clearfix contents">
                        <div class="col-md-8 mx-auto">
                            {!! nl2br($model->per_info) !!}

                        </div>

                    </div>


                    <div class="snaps mt-5 pb-5">
                        <div class="snap-wrap">
                            @foreach($snaps as $snap)
                            	@if(isset($snap->snap_path))
                                <div style="background-image:url({{ Storage::url($snap->snap_path) }})"></div>

                                <h4>{{ $snap->ask }}</h4>
                                <p>{!! nl2br($snap->answer) !!}</p>

                                @endif
                            @endforeach
						</div>
                    </div>


                </div>
            </div><!-- panelbody -->

        </div>
    </div>
@endsection
