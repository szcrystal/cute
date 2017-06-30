@extends('layouts.app')

@section('content')

<div id="main" class="feature-index">

        <div class="panel panel-default">
        	@if(isset($cateObj))
			<h2>特集 : {{ $cateObj->name }}</h2>
            @else
        	<h2>特集ALL</h2>
			@endif

            <div class="panel-body">

			<div class="main-list clearfix">
<?php
    use App\User;
    use App\Category;
    use App\FeatureCategory;
    
    $n = 1;
?>

	@if(isset($allIndex) && $allIndex) <?php /*特集ALL*/ ?>
    	@if(count($features) > 0)
            @foreach($features as $feature)

                @if(Ctm::isAgent('sp'))
                	@if($n == 1 || $n == 5 || $n == 8 || $n == 11)
                		<div class="top-cont clear">
                    @endif
                @else
                	@if($n == 1 || $n == 4 || $n == 7 || $n == 10)
                        <div class="top-cont feature clear">
                    @endif
                @endif

                <article style="background-image:url({{Storage::url($feature->cate_thumb)}})" class="float-left">

                    <a href="{{ url(Ctm::getFeatureCateUrl($feature->id, Request::path())) }}">

                        <div class="meta">
                            <h3>{{ $feature->name }}</h3>
                            <p>{{-- User::find($feature->model_id)->name --}}</p>
                        </div>

                        <span><i class="fa fa-caret-right" aria-hidden="true"></i></span>
                    </a>
                </article>

				@if(Ctm::isAgent('sp'))
                	@if($n%4 == 0)
                    	</div>
                    @endif
                @else
                	@if($n%3 == 0)
                    	</div>
                    @endif
                @endif


            <?php $n++; ?>
            @endforeach
        @else
            <p class="mt-3">まだ記事がありません。</p>
        @endif

	@else <?php /*特集ALL以外の特集*/ ?>
        @if(count($features) > 0)
            @foreach($features as $feature)

            @if($n == 1 || $n == 4 || $n == 7 || $n == 10)
                @if(Ctm::isAgent('sp'))
                <div class="top-cont clear">
                @else
                <div class="top-cont feature clear">
                @endif
            @endif

            <article style="background-image:url({{Storage::url($feature->thumb_path)}})" class="float-left">

                <a href="{{ url(Ctm::getAtclUrl($feature->id)) }}">

                    <div class="meta">
                        <h3>{{ $feature->title }}</h3>
                        <p>{{ User::find($feature->model_id)->name }}</p>
                    </div>

                    <span><i class="fa fa-caret-right" aria-hidden="true"></i></span>
                </a>
            </article>

            @if($n%3 == 0)
            </div>
            @endif

            <?php $n++; ?>
            @endforeach
        @else
            <p class="mt-3">まだ記事がありません。</p>
        @endif

    @endif
    </div>




</div>

<div class="pagination-wrap">
{{ $features->links() }}
</div>




            </div>
        </div>

</div>

@endsection






