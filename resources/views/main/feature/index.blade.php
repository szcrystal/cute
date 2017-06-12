@extends('layouts.app')

@section('content')

<div id="main">

        <div class="panel panel-default">
        	@if(isset($cateName))
			<h2>特集 {{ $cateName }} 一覧</h2>
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
?>

<div class="top-cont feature clear">

    @foreach($features as $feature)
    <article style="background-image:url({{Storage::url($feature->thumb_path)}})" class="float-left">

            <?php
                //$fCateSlug = FeatureCategory::find($feature->cate_id)->slug;
            ?>

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
            	<h2>{{ $feature->title }}</h2>
                <p>{{ User::find($feature->model_id)->name }}</p>
            </div>
        </a>
    </article>
    @endforeach
    </div>




</div>


{{ $features->links() }}




            </div>
        </div>

</div>

@endsection






