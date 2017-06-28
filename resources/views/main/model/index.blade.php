@extends('layouts.app')

@section('content')

@include('main.shared.carousel')

<div id="main" class="model-index">

        <div class="panel panel-default">
			<h2>モデル</h2>


            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

			<div class="main-list clearfix">
<?php
    use App\State;
?>

<div class="top-cont archive clear">

    @if(count($models) > 0)

    @foreach($models as $model)
    	<article style="background-image:url({{Storage::url($model->model_thumb)}})" class="float-left">

            <a href="{{ url(State::find($model->state_id)->slug . '/model/' . $model->id) }}">

            @if($model->model_thumb == '')
                <span class="no-img">No Image</span>
            @endif

            <?php
                $num = Ctm::isAgent('sp') ? 30 : 18;
            ?>

            <div class="meta">
            	<h3>{{ $model->name }}＠{{ $model->school }}</h3>
            </div>

            <span><i class="fa fa-caret-right" aria-hidden="true"></i></span>
        </a>
    </article>
    @endforeach

    @else
		<p>まだモデル記事がありません</p>
    @endif
    </div>




</div>

<div class="pagination-wrap">
{{ $models->links() }}
</div>




            </div>
        </div>

</div>

@endsection






