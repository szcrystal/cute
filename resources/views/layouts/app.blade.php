@include('shared.header')
<body>

    <div id="app">
    	@if(Ctm::isAgent('sp'))
			@include('shared.headNavSp')
        @else
        	@include('shared.headNav')
        @endif

		<div class="container wrap-all">
			<div class="">
                <?php $className = isset($className) ? $className : ''; ?>
                <div class="py-4 {{ $className }}"><!-- offset-md-1-->
                    @yield('content')
                    {{-- @yield('leftbar') --}}
                </div>
            </div>

        </div>

    </div>

@include('shared.footer')


</body>
</html>
