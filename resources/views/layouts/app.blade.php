@include('shared.header')
<body>

    <div id="app">

        @include('shared.headNav')

		<div class="container wrap-all">
			<div class="">
                <?php $className = isset($className) ? $className : ''; ?>
                <div class="{{ $className }}"><!-- offset-md-1-->
                    @yield('content')
                    {{-- @yield('leftbar') --}}
                </div>
            </div>

        </div>

    </div>

@include('shared.footer')


</body>
</html>
