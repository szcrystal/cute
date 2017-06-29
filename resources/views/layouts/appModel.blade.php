@include('shared.headerModel')
<body>

<div class="waiting">
	<span><i class="fa fa-square" aria-hidden="true"></i></span>
    <small>UPLOADしています</small>
	{{-- <img src="{{ url('images/AjaxLoader.gif') }}"> --}}
</div>

    <div id="app">
        <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top">
			<div class="container">


        <!-- Branding Image -->

        <div class="collapse navbar-collapse" id="app-navbar-collapse">

            @if(Auth::user())

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav">

                    {{-- <li class="nav-link"><a href="{{ url('') }}"></a></li> --}}

                    <li class="dropdown nav-item">
                        <a href="#" class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdown01" role="menu">
                            {{-- <a href="{{ url('/contribute/'.Auth::id()) }}" class="dropdown-item">マイページ</a> --}}

                            <a href="{{ url('/contribute') }}" class="dropdown-item">TOP</a>
                            <a href="{{ url('/contribute/logout') }}" class="dropdown-item"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                ログアウト
                            </a>

                            <form id="logout-form" action="{{ url('/contribute/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>

            </ul>

            @else

                @if(strpos(Request::path(), 'login') !== FALSE)
                    <div class="regi-nav">
                        <a href="{{ url('/contribute/register') }}" class="btn btn-custom">新規登録</a>
                    </div>
                @else
                	<div class="regi-nav">
                        <a href="{{ url('/contribute/login') }}" class="btn btn-custom">ログイン</a>
                    </div>

                @endif



            @endif



        </div>

    </div>
</nav>


		<div class="container wrap-all">

        <?php
        	use App\Setting;
        ?>

    	<h3 style="color: #627883;" class="text-center mt-5">{{ config('app.name') }}{{-- Setting::first()->all_area --}}</h3>
        <p style="color: #627883;" class="text-center">モデル投稿</p>

		@if(!Auth::user())
        {{--
        <p class="col-md-6 mx-auto clearfix">
        	<a href="{{ url('contribute/login')}}" class="float-left">LogIn</a>
        	<a href="{{ url('contribute/register')}}" class="float-right">Register</a>
		</p>
        --}}
        @endif

        {{--
    	@if(Ctm::isAgent('sp'))
			@include('shared.headNavSp')
        @else
        	@include('shared.headNav')
        @endif
        --}}


			<div class="row">

                <?php $className = isset($className) ? $className : ''; ?>
                <div class="col-md-6 mx-auto {{ $className }}"><!-- offset-md-1-->
                    @yield('content')

                </div>
            </div>

        </div>

    </div>

@include('shared.modelFooter')


</body>
</html>
