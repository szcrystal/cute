
<nav class="navbar fixed-top">
	<div>
    	<i class="fa fa-bars" aria-hidden="true"></i>

        <!-- Branding Image -->
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'MovieReview') }}
        </a>

        <i class="fa fa-search" aria-hidden="true"></i>
    </div>

    <div class="searchform">
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
    </div>

</nav>


