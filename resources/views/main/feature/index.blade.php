@extends('layouts.app')

@section('content')

<div id="main" class="feature-index">

        <div class="panel panel-default">
        	@if(isset($cateObj))
			<h2>特集 : {{ $cateObj->name }}</h2>
            @else
        	<h2>特集一覧</h2>
			@endif

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

			<div class="main-list clearfix">
<?php
    use App\User;
    use App\Category;
    use App\FeatureCategory;
    
    $n = 1;
?>



	@if(count($features) > 0)
        @foreach($features as $feature)

		@if($n == 1 || $n == 4 || $n == 7 || $n == 10)
		<div class="top-cont feature clear">
        @endif

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
                    <p>{{ User::find($feature->model_id)->name }}</p>
                </div>
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
    </div>




</div>


{{ $features->links() }}




            </div>
        </div>

</div>

@endsection






