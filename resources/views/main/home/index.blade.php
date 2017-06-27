@extends('layouts.app')

@section('content')


	@include('main.shared.carousel')

<div id="main" class="top">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">
<?php
    use App\User;
    use App\Category;
    use App\FeatureCategory;
?>

@if(Ctm::isAgent('sp'))
<section class="top-cont clear">
@else
<section class="top-cont feature clear">
@endif

<h2>特集</h2>
    @foreach($features as $feature)
    <article style="background-image:url({{Storage::url($feature->thumb_path)}})" class="float-left">

            <a href="{{ url(Ctm::getAtclUrl($feature->id)) }}">

            @if($feature->thumb_path == '')
                <span class="no-img">No Image</span>
            @else
                <div class="main-thumb"></div>
            @endif

            <?php
                $num = Ctm::isAgent('sp') ? 30 : 18;
            ?>

            <div class="meta">
            	<h3>{{ $feature->title }}</h3>
                {{-- <p>{{ User::find($feature->model_id)->name }}</p> --}}
            </div>

            <span><i class="fa fa-caret-right" aria-hidden="true"></i></span>
        </a>
    </article>
    @endforeach
</section>

@if(Ctm::isAgent('sp'))
<section class="top-cont clear">
@else
<section class="top-cont pickup clear">
@endif

<h2>Pick Up</h2>
<div>
	@foreach($pickUps as $pickUp)
    <article style="background-image:url({{Storage::url($pickUp->thumb_path)}})" class="float-left">

            <a href="{{ url(Ctm::getAtclUrl($pickUp->id)) }}">

            @if($pickUp->thumb_path == '')
                <span class="no-img">No Image</span>
            @else
                <div class="main-thumb"></div>
            @endif

            <?php
                $num = Ctm::isAgent('sp') ? 30 : 18;
            ?>

            <div class="meta">
            	<h3>{{ $pickUp->title }}</h3>
                <p>{{ User::find($pickUp->model_id)->name }}</p>
            </div>

            <span><i class="fa fa-caret-right" aria-hidden="true"></i></span>
        </a>
    </article>
    @endforeach
</div>
</section>


@foreach($atcls as $key => $obj)
	@if(Ctm::isAgent('sp'))
    <section class="top-cont clear">
    @else
    <section class="top-cont atcl clear">
    @endif

		<h2>{{ $key }}</h2>
		<div class="clear">
    	@foreach($obj as $atcl)
            <article style="background-image:url({{Storage::url($atcl->thumb_path)}})">

                <a href="{{ url(Ctm::getAtclUrl($atcl->id)) }}">

                    @if($atcl->thumb_path == '')
                        <span class="no-img">No Image</span>
                    @else
                        <div class="main-thumb"></div>
                    @endif


                    <?php
                        $num = Ctm::isAgent('sp') ? 30 : 18;
                    ?>

                    <div class="meta">
                        <h3>{{ $atcl->title }}</h3>
                        <p>{{ User::find($atcl->model_id)->name }}</p>
                    </div>

                    <span><i class="fa fa-caret-right" aria-hidden="true"></i></span>

                </a>
            </article>
    	@endforeach
		</div>
    </section>
@endforeach



</div>

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


