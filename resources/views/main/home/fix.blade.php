@extends('layouts.app')

@section('content')

<div id="main" class="fix-page">

    <div class="panel panel-default">
        <h2>{{ $fix->title }}</h2>

        <div class="panel-body">

            <div class="top-cont archive clear">
                {!! $fix->contents !!}
            </div>


		</div>

    </div>


</div>

@endsection






