@include('dashboard.shared.head')
	
		<div class="col-md-6 col-md-offset-3">
        		
			<div style="margin-top: 8em;" class="panel panel-default">
            		
				<div class="panel-heading">
                	CuteCampus DashBoard Login
                </div>
                	
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>ログイン出来ません</strong><br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

                    {{--
                    <script>
                    	$(function(){
                        	$('input:eq(1)').focus();
                        });
                    </script>
                    --}}                  
                    
                    <form class="form-horizontal" role="form" method="POST" action="">
                        {{ csrf_field() }}

                        @if(session('beforePath'))
                        <input type="hidden" name="beforePath" value="{{ session('beforePath') }}">
                        @endif

                        <div class="form-group">
                            <label class="col-md-3 control-label">メールアドレス</label>
                            <div class="col-md-8">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">パスワード</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" name="password" placeholder="8文字以上">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-3">
                                <div>
                                    <label>
                                        <input type="checkbox" name="remember"> ログイン状態を保存する
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-5">

                                <button type="submit" class="btn btn-primary">ログイン</button>
                                {{-- <a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a> --}}
                            </div>
                        </div>
                    </form>
                        
				 
                </div>
			</div>
		</div>

