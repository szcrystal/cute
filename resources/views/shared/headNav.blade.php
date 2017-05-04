
<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top">
	<div class="container">
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>


        <!-- Branding Image -->
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'MovieReview') }}
        </a>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li class="nav-link"><a href="{{ url('/login') }}">Login</a></li>
                    <li class="nav-link"><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown nav-item">
                        <a href="#" class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdown01" role="menu">
                            <a href="{{ url('/mypage') }}" class="dropdown-item">マイページ</a>

                            <a href="{{ url('/logout') }}" class="dropdown-item"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                ログアウト
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                @endif
                <li class="nav-link"><a href="{{ url('/contact') }}">Contact</a></li>
            </ul>

            <form class="my-1 my-lg-0" role="form" method="GET" action="{{ url('search') }}">
                {{-- csrf_field() --}}
                <div class="row">
                    <div class="col-md-12">
                    <div class="input-group">
                      <input type="search" class="form-control" name="s" placeholder="Search...">
                      <span class="input-group-btn">
                        <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                      </span>
                    </div>
                  </div>
                </div>

                {{--<input style="width:15em; display:inline;" type="text" class="form-control" name="s" placeholder="Search...">
                <button style="display:inline;" class="btn btn-default my-2 my-sm-0" type="submit">
                    <i class="fa fa-search"></i>
                </button>
                --}}
            </form>

        </div>

    </div>
</nav>
