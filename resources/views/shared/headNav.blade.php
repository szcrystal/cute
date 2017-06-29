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
            //$stateName = Setting::first()->all_area; //env('AREA', '')
            $stateName = '';
        }
    ?>

    @if(Ctm::isAgent('sp'))
        <div id="menuButton" class="nav-tgl">
            <div>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    @endif

    <h1><a class="navbar-brand" href="{{ url('/'. $stateUrl) }}">
        <img src="{{ url('images/cc_logo.png') }}" alt="{{ config('app.name', 'Cute.Campus') }}">
		@if($stateName != '')
        <span>{{ $stateName }}</span>
        @endif
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

@if(Ctm::isAgent('sp'))
	@include('shared.navSp')
@else
	@include('shared.navPc')
@endif



</div>
