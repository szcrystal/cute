<div class="fixed-top">

<header class="site-header clear">
	<!-- Branding Image -->
    <h1 class="float-left"><a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'Cute.Campus') }} {{ env('AREA', '') }}
    </a></h1>

	<!--
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
    </form>
    -->

    <button style="display:inline;" class="btn float-right" type="submit">
        <i class="fa fa-search"></i>
    </button>
</header>


<nav class="main-navigation">

            <?php
                use App\Category;
                use App\State;
                use App\FeatureCategory;
                
                $states = State::all();
                $cates = Category::all();
                $fCates = FeatureCategory::where('status', 1)->get();
            ?>

            <ul class="state-nav clear">
            	<li class="dropdown nav-item" data-toggle="dropdown" role="button">
                    ALL <i class="fa fa-caret-down" aria-hidden="true"></i>
                </li>

				@foreach($states as $state)
                    <li class="dropdown nav-item" data-toggle="dropdown" role="button">
                    	{{ $state->name }} <i class="fa fa-caret-down" aria-hidden="true"></i>
                    </li>
                @endforeach

            </ul>

			<div class="menu-dropdown-wrap">
				<div class="menu-dropdown clear col-md-12" aria-labelledby="dropdown01" role="menu">
                	<div class="float-left col-md-2">
                    	<ul class="clear">
                    		<li><a href="{{ url('/') }}" class="dropdown-item">四国 TOP</a>
                    		<li><a href="{{ url('all/model') }}" class="dropdown-item">モデル</a>
                        </ul>
                    </div>

					<div class="float-left col-md-5">
                        <h2>カテゴリー</h2>
                        <ul class="clear">
                        @foreach($cates as $cate)
                            <li><a href="{{ url('all/' . $cate->slug) }}">{{ $cate->name }}</a></li>
                        @endforeach
                        </ul>
                    </div>

					<div class="float-left col-md-5">
                    	<h2>特集</h2>
						<ul class="clear">
                        	<li><a href="{{ url('all/feature') }}">特集All</a></li>
                        	@foreach($fCates as $fCate)
								<li><a href="{{ url('all/feature/' . $fCate->slug) }}">{{ $fCate->name }}</a></li>
							@endforeach
                        </ul>
                    </div>

                </div>

				@foreach($states as $state)
                	<div class="menu-dropdown clear col-md-12" aria-labelledby="dropdown01" role="menu">
						<div class="float-left col-md-2">
                        	<ul class="clear">
                        		<li><a href="{{ url($state->slug) }}" class="dropdown-item">{{ $state->name }} TOP</a>
                        		<li><a href="{{ url($state->slug .'/model') }}" class="dropdown-item">モデル</a>
                            </ul>
                        </div>

						<div class="float-left col-md-5">
                            <h2>カテゴリー</h2>
                            <ul class="clear">
                                @foreach($cates as $cate)
                                    <li><a href="{{ url($state->slug .'/' .$cate->slug) }}">{{ $cate->name }}</a>
                                @endforeach
                            </ul>
                    	</div>

                        <div class="float-left col-md-5">
                            <h2>特集</h2>
                            <ul class="clear">
                                <li><a href="{{ url($state->slug .'/feature') }}">特集</a>
                                @foreach($fCates as $fCate)
                                    <li><a href="{{ url($state->slug .'/feature/' . $fCate->slug) }}">{{ $fCate->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach

            </div>



</nav>

</div>
