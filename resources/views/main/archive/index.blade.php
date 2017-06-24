@extends('layouts.app')

@section('content')

<div id="main" class="archive-index">

    <div class="panel panel-default">
    	@if($type == 'cate')
        	<h2>カテゴリー {{ $archiveObj->name }}</h2>
        @elseif($type == 'tag')
			<h2>タグ {{ $archiveObj->name }}</h2>
		@elseif($type == 'search')
			<h2>Search {{ $archiveObj->name }}</h2>
        @endif


        <div class="panel-body">
            {{-- @include('main.shared.main') --}}

			<div class="main-list clear">
<?php
    use App\User;
//    use App\Category;
//    use App\FeatureCategory;
?>

<div class="top-cont archive clear">

    @if(count($atcls) > 0)

    @foreach($atcls as $atcl)
    	<article style="background-image:url({{Storage::url($atcl->thumb_path)}})" class="float-left">

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
        	</a>
    	</article>
    @endforeach

    @else
		<p class="mt-3">まだ記事がありません</p>
    @endif
</div>


</div>

    </div>

	<div class="pagination-wrap">
        {{ $atcls->links() }}
    </div>

    </div>

</div>

@endsection






