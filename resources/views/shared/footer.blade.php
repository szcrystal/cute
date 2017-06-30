<footer id="colop">
	<div class="container clear">

        <div class="float-left foot-wrap">
        	<div>
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Cute.Campus') }}
                </a>
                <p>あなたの身近な美人学生が<br>地元の情報を発信する動画マガジン</p>
            </div>
        </div>

        <div class="float-left foot-wrap">
        	<?php
            	use App\Fix;
            	$fixes = Fix::where('open_status', 1)->orderBy('id', 'asc')->get();
            ?>
        	@if($fixes)
			<ul>
            	@foreach($fixes as $fix)
				<li><a href="{{ url($fix->slug) }}">
					@if($fix->sub_title != '')
                    {{ $fix->sub_title }}
                    @else
                    {{ $fix->title }}
                    @endif
                </a></li>
				@endforeach


				<li class="nav-link"><a href="http://locofull.jp">運営会社</a></li>
                <li class="nav-link"><a href="{{ url('/contact') }}">お問合わせ</a></li>
            </ul>
            @endif
        </div>

        <div class="float-right foot-wrap">
			<div class="text-center">
            	<h6>ー 運営会社 ー</h6>
                <img src="{{ url('images/lcfl_logo.png') }}" alt="株式会社ロコフル">
				<a href="http://locofull.jp" target="_brank">locofull.jp</a>
            </div>
        </div>

    </div>
	<p><small><i class="fa fa-copyright" aria-hidden="true"></i> {{ config('app.name', 'Cute.Campus') }}</small></p>

</footer>

<span class="top_btn"><i class="fa fa-angle-up"></i></span>

<!-- Scripts -->
    {{-- <script src="/js/app.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

