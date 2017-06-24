<div class="fixed-top">

<header class="site-header clear">
	<!-- Branding Image -->
    <?php
        use App\State;
        use App\Setting;
        $path = Request::path();
        $path = explode('/', $path);
        
        $stateName = '';
        $stateUrl = '';
        
        $state = State::where('slug', $path[0])->first();
        if(isset($state)) {
            $stateName = $state->name;
            $stateUrl = $state->slug;
        }
        else {
            $stateName = Setting::first()->all_area; //env('AREA', '')
        }
    ?>

    <h1 class="float-left"><a class="navbar-brand" href="{{ url('/'. $stateUrl) }}">
        {{ config('app.name', 'Cute.Campus') }} <span>{{ $stateName }}</span>
    </a></h1>

	<div class="float-right clear s-form">
		<div class="float-left">
            <form class="my-1 my-lg-0" role="form" method="GET" action="{{ url('search') }}">
                {{-- csrf_field() --}}

                <div class="">
                    <input type="search" class="form-control" name="s" placeholder="Search...">
                </div>
            </form>
        </div>


        <button class="btn btn-s float-left" type="submit">
            <i class="fa fa-search"></i>
        </button>
    </div>
</header>


<nav class="main-navigation">

            <?php
                use App\Category;
                //use App\State;
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
                    		<li><a href="{{ url('/') }}" class="dropdown-item"><i class="fa fa-angle-double-right" aria-hidden="true"></i> 四国 TOP</a>
                    		<li><a href="{{ url('all/model') }}" class="dropdown-item"><i class="fa fa-angle-double-right" aria-hidden="true"></i> モデル</a>
                        </ul>
                    </div>

					<div class="float-left col-md-5">
                        <h2>カテゴリー</h2>
                        <ul class="clear">
                        @foreach($cates as $cate)
                            <li>
								<span class="rank-tag">
                            	<a href="{{ url('all/' . $cate->slug) }}">{{ $cate->name }}</a>
								</span>
                            </li>
                        @endforeach
                        </ul>
                    </div>

					<div class="float-left col-md-5">
                    	<h2>特集</h2>
						<ul class="clear">
                        	<li>
                            	<span class="rank-tag">
                            	<a href="{{ url('all/feature') }}">特集All</a>
                                </span>
                            </li>
                        	@foreach($fCates as $fCate)
								<li>
                                	<span class="rank-tag">
                                	<a href="{{ url('all/feature/' . $fCate->slug) }}">{{ $fCate->name }}</a>
                                    </span>
                                </li>
							@endforeach
                        </ul>
                    </div>

                </div>

				@foreach($states as $state)
                	<div class="menu-dropdown clear col-md-12" aria-labelledby="dropdown01" role="menu">
						<div class="float-left col-md-2">
                        	<ul class="clear">
                        		<li><a href="{{ url($state->slug) }}" class="dropdown-item"><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{ $state->name }} TOP</a>
                        		<li><a href="{{ url($state->slug .'/model') }}" class="dropdown-item"><i class="fa fa-angle-double-right" aria-hidden="true"></i> モデル</a>
                            </ul>
                        </div>

						<div class="float-left col-md-5">
                            <h2>カテゴリー</h2>
                            <ul class="clear">
                                @foreach($cates as $cate)
                                    <li>
                                    	<span class="rank-tag">
                                    	<a href="{{ url($state->slug .'/' .$cate->slug) }}">{{ $cate->name }}</a>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                    	</div>

                        <div class="float-left col-md-5">
                            <h2>特集</h2>
                            <ul class="clear">
                                <li>
                                	<span class="rank-tag">
                                	<a href="{{ url($state->slug .'/feature') }}">特集All</a>
                                    </span>
                                </li>
                                @foreach($fCates as $fCate)
                                    <li>
										<span class="rank-tag">
                                    	<a href="{{ url($state->slug .'/feature/' . $fCate->slug) }}">{{ $fCate->name }}</a>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach

            </div>

</nav>

</div>
