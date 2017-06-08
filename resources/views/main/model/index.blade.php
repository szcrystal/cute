@extends('layouts.app')

@section('content')

<div id="main">

        <div class="panel panel-default">

            <div class="panel-body">
                @include('main.shared.main')
            </div>
        </div>

</div>

@endsection


@section('leftbar')
    @include('main.shared.leftbar')
@endsection


@section('rightbar')
	@include('main.shared.rightbar')
@endsection



