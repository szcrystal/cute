@include('shared.headerModel')
<body style="background: #EFFBF7">

    <div id="app">
    	<h3 class="text-center mt-5">{{ config('app.name') }} {{ env('AREA') }}</h3>
        <p class="text-center">モデル投稿</p>

        {{--
    	@if(Ctm::isAgent('sp'))
			@include('shared.headNavSp')
        @else
        	@include('shared.headNav')
        @endif
        --}}

		<div class="container wrap-all">
			<div class="row col-md-8 mx-auto py-3">
                <?php $className = isset($className) ? $className : ''; ?>
                <div class="flex col-md-12 py-4 {{ $className }}"><!-- offset-md-1-->
                    @yield('content')

                </div>
            </div>

        </div>

    </div>

@include('shared.footer')


</body>
</html>
