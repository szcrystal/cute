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
    
    use App\State;
    use App\Setting;
    
    $path = Request::path();
    $path = explode('/', $path);
    
    //$stateName = '';
    $stateSlug = '';
    
    $state = State::where('slug', $path[0])->first();
    if(isset($state)) {
        $stateSlug = $state->slug . '/';
    }
    else {
        //$stateName = Setting::first()->all_area; //env('AREA', '')
        $stateSlug = 'all/';
    }
    
?>


<section class="top-cont feature clear">

<h2><a href="{{ url($stateSlug . 'feature') }}">特集</a></h2>
    @foreach($features as $feature)
    <article style="background-image:url({{Storage::url($feature->cate_thumb)}})" class="float-left">

            <a href="{{ url(Ctm::getFeatureCateUrl($feature->id, Request::path())) }}">

            <div class="meta">
            	{{-- <h3>{{ $feature->name }}</h3> --}}
                {{-- <p>{{ User::find($feature->model_id)->name }}</p> --}}
            </div>

            <span><i class="fa fa-caret-right" aria-hidden="true"></i></span>
        </a>
    </article>
    @endforeach
</section>


@if(isset($pickUps))
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

                <div class="meta">
                    <?php $model = User::find($pickUp->model_id); ?>
                    <h3>{{ $pickUp->title }}</h3>
                    <p>{{ $model->name }}
                        @if($model->school != '')
                            ＠{{ $model->school }}
                        @endif
                    </p>
                </div>

                <span><i class="fa fa-caret-right" aria-hidden="true"></i></span>
            </a>
        </article>
        @endforeach
    </div>
    </section>
@endif


@foreach($atcls as $key => $obj)
	@if(Ctm::isAgent('sp'))
    <section class="top-cont clear">
    @else
    <section class="top-cont atcl clear">
    @endif

		<h2><a href="{{ url($stateSlug . $key) }}">{{ $key }}</a></h2>
		<div class="clear">
    	@foreach($obj as $atcl)
            <article style="background-image:url({{Storage::url($atcl->thumb_path)}})">

                <a href="{{ url(Ctm::getAtclUrl($atcl->id)) }}">
					<?php $model = User::find($atcl->model_id); ?>
                    <div class="meta">
                        <h3>{{ $atcl->title }}</h3>
                        <p>{{ $model->name }}
							@if($model->school != '')
                            	＠{{ $model->school }}
                            @endif
                        </p>
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


