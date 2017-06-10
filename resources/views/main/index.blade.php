@extends('layouts.app')

@section('content')

<div id="carouselIndicators" class="carousel slide" data-ride="carousel" data-interval="10000">
  <ol class="carousel-indicators">
    <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselIndicators" data-slide-to="1"></li>
    <li data-target="#carouselIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="carousel-item active">
      <img class="d-block img-fluid" src="/storage/article/1/thumbnail/items_1.jpg" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
        <h3>松山で一番美味しいランチはこれだ！</h3>
        <p>みいたけ＠松山大学</p>
      </div>

    </div>
    <div class="carousel-item">
      <img class="d-block img-fluid" src="/storage/article/1/thumbnail/items_1.jpg" alt="Second slide">
      <div class="carousel-caption d-none d-md-block">
        <h3>松山で一番美味しいランチはこれだ！</h3>
        <p>みいたけ＠松山大学</p>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block img-fluid" src="/storage/article/1/thumbnail/items_1.jpg" alt="Third slide">
      <div class="carousel-caption d-none d-md-block">
        <h3>松山で一番美味しいランチはこれだ！</h3>
        <p>みいたけ＠松山大学</p>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<div id="main">

        <div class="panel panel-default">

            <div class="panel-body">
                @include('main.shared.main')
            </div>
        </div>

        

</div>

@endsection


{{--
@section('leftbar')
    @include('main.shared.leftbar')
@endsection


@section('rightbar')
	@include('main.shared.rightbar')
@endsection
--}}


