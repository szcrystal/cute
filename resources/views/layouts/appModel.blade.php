@include('shared.headerModel')
<body style="background: #EFFBF7">

    <div id="app">
    	<h3 class="text-center mt-5">{{ config('app.name') }} {{ env('AREA') }}</h3>
        <p class="text-center">モデル投稿</p>

        <p class="col-md-6 mx-auto clearfix">
        	<a href="{{ url('contribute/login')}}" class="float-left">LogIn</a>
        	<a href="{{ url('contribute/register')}}" class="float-right">Register</a>
		</p>

        {{--
    	@if(Ctm::isAgent('sp'))
			@include('shared.headNavSp')
        @else
        	@include('shared.headNav')
        @endif
        --}}

		<div class="container wrap-all">
			<div class="row">

                <?php $className = isset($className) ? $className : ''; ?>
                <div class="col-md-6 mx-auto {{ $className }}"><!-- offset-md-1-->
                    @yield('content')

                </div>
            </div>

        </div>

    </div>

@include('shared.footer')


</body>
</html>
