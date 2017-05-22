@extends('layouts.appModel')

@section('content')

	
	{{-- <h4 class="page-header text-center my-4">UPLOADされました。</h4> --}}



    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Error!!</strong> 追加できません<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if(isset($status))
    	<div class="alert alert-success my-4">
            {{ $status }}
        </div>

    @endif
        
    <div class="well">

        <p class="text-center mb-4">ありがとうございます。<br>後ほど、編集部で編集をします。</p>

        <div class="clearfix my-3">
            <div class="pull-left">
                <a href="{{ url('/contribute') }}" class="btn btn-custom"><i class="fa fa-angle-double-left" aria-hidden="true"></i> TOPへ戻る</a>
            </div>
        </div>

    </div>



    

@endsection
