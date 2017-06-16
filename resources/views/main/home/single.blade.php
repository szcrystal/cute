@extends('layouts.app')

@section('content')

<?php
use App\User;

?>

    <div class="row">
        <div class="col-md-12 py-5 single">
            <div>
                <div class="movie-frame text-center">
                    {{-- @include('main.shared.movie') --}}
                    @if(isset($atcl->yt_id))

                        <?php $width = Ctm::isAgent('sp') ? '100%' : '1280'; ?>

                        <iframe width="{{ $width }}" height="720" src="https://www.youtube.com/embed/{{ $atcl->yt_id }}" frameborder="0" allowfullscreen></iframe>
                    @else
                        <span style="color:#fff;" class="no-video">No Video</span>
                    @endif

                </div>


            </div>

            <div class="panel-body">

                <div class="cont-wrap">
                	<h2>{{ $atcl -> title }}</h2>

                    <div class="table-responsive py-3">
                    	<table class="table table-bordered">
                            <colgroup>
                                <col class="cth">
                                <col class="ctd">
                            </colgroup>
                            
                            <tbody>
                                <tr>
                                    <th>
									@if(isset($feature))
									特集
                                    @else
                                    モデル
                                    @endif
                                    </th>
                                    <td>{{ User::find($atcl->model_id)->name }}</td>
                                </tr>

                                <tr>
                                    <th>エリア</th>
                                    <td>{{ $stateObj->name }}</td>
                                </tr>

                                <tr>
                                    <th>カテゴリー</th>
                                    <td>
                                    @if($cateObj)
                                    	@if(isset($feature))
											<a href="{{ url($stateObj->slug .'/feature/' . $cateObj->slug) }}">{{ $cateObj->name }}</a>
                                        @else
                                    		<a href="{{ url($stateObj->slug .'/' . $cateObj->slug) }}">{{ $cateObj->name }}</a>
                                        @endif
                                    @endif
                                    </td>
                                </tr>

                                <tr>
									<th>タグ</th>
                                    <td>
                                    	@foreach($tags as $tag)
                                            <span class="rank-tag">
                                            <i class="fa fa-tag" aria-hidden="true"></i>
                                            <a href="{{ url($stateObj->slug .'/tag/' . $tag->id) }}">{{ $tag->name }}</a>
                                            </span>
                                        @endforeach

                                    </td>
                                </tr>

								<tr>
									<th>このモデルが撮影した他の記事</th>
                                    <td>
                                    	<?php
                                        	use App\State;
                                        	use App\Category;
                                        ?>
                                    	@foreach($otherAtcl as $oAtcl)
                                        	<?php $url = State::find($oAtcl->state_id)->slug . '/' . Category::find($oAtcl->cate_id)->slug . '/' .$oAtcl->id; ?>
                                            <span class="rank-tag">
                                            <a href="{{ url($url) }}">{{ $oAtcl->title }}</a>
                                            </span>
                                        @endforeach

                                    </td>
                                </tr>

                            </tbody>
                		</table>
                    </div>


                    <div class="clear contents">
                    	<h4>Infomation</h4>
                        <div class="col-md-6 float-left">
                            @if($atcl -> thumb_path)
                            <img src="{{ Storage::url($atcl->thumb_path) }}" class="img-fluid">
                            @else
                            <span class="no-img">No Image</span>
                            @endif
                        </div>

                        <div class="col-md-6 float-right">
                            <p>{!! nl2br($atcl->contents) !!}</p>
                        </div>
                    </div>

                    <div class="rv-content mt-5 pb-5">
                        	@if($atcl->address != '')
                        	<div id="map" style="width:100%; height:500px; background:#fefcfb;" data-address="{{ $atcl->address }}"></div>

                            <script type="text/javascript" src="//maps.google.com/maps/api/js?key=AIzaSyCtPtTSkIY1yGa5Rt8klarv45YnPXVpenc&callback=initMap"></script>
                            <!-- ?sensor=false -->

                            <script>
                                function drawMap(address) {
                                    var geocoder = new google.maps.Geocoder();
                                    //住所から座標を取得する
                                    geocoder.geocode(
                                        {
                                            'address': address,//検索する住所　〒◯◯◯-◯◯◯◯ 住所　みたいな形式でも検索できる
                                            'region': 'jp'
                                        },
                                        
                                        function (results, status) {
                                            if (status == google.maps.GeocoderStatus.OK) {
                                                google.maps.event.addDomListener(window, 'load', function () {
                                                    var map_tag = document.getElementById('map');
                                                    // 取得した座標をセット緯度経度をセット
                                                    var map_location = new google.maps.LatLng(results[0].geometry.location.lat(),results[0].geometry.location.lng());
                                                    //マップ表示のオプション
                                                    var map_options =
                                                    {
                                                        zoom: 17,//縮尺
                                                        center: map_location,//地図の中心座標
                                                        //ここをfalseにすると地図上に人みたいなアイコンとか表示される
                                                        disableDefaultUI: true,
                                                        mapTypeId: google.maps.MapTypeId.ROADMAP//地図の種類を指定
                                                    };

                                                    //マップを表示する
                                                    var map = new google.maps.Map(map_tag, map_options);

                                                    //地図上にマーカーを表示させる
                                                    var marker = new google.maps.Marker({
                                                        position: map_location,//マーカーを表示させる座標
                                                        map: map//マーカーを表示させる地図
                                                    });
                                                });
                                            }
                                        }
                                    );
                                }

								var add = $('#map').data('address');
                                drawMap(add);
                            </script>

                            @else
								<span class="no-img">No Address</span>
                            @endif

                        </div>


                	</div>

				</div><!-- panelbody -->

            </div>
    </div>
@endsection
