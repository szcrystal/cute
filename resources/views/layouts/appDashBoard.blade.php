@include('dashboard.shared.head')

<body class="dashboard">

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/dashboard">CuteCampus DashBoard</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
            	{{--
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                --}}
                <!-- /.dropdown -->
                {{--
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                --}}
                <!-- /.dropdown -->
                {{--
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                --}}
                <!-- /.dropdown -->

                <li class="dropdown">

                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>
                        {{--
                        @if (Auth::guard('admin')->viaRemember())
							viaRemember
                        @else
							NoViaRemember
                        @endif
						--}}
						{{ Auth::guard('admin')->user()->name }}
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        {{-- <li><a href="{{ url('dashboard/register/'. Auth::guard('admin')->user()->id) }}"><i class="fa fa-gear fa-fw"></i> 編集</a>
                        </li>
                        <li class="divider"></li>
                         --}}
                        <li><a href="{{ url('dashboard/logout') }}"><i class="fa fa-sign-out fa-fw"></i> ログアウト</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                        <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> 集計<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            	<li><a href="{{ url('/dashboard') }}">Daily ランキング</a></li>
                                <li><a href="{{ url('/dashboard/weekly') }}">Weekly ランキング</a></li>
                            </ul>

                        </li>

						<li>
                            <a href="#"><i class="fa fa-users"></i> 会員管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            	<li>
                                    <a href="{{ url('/dashboard/users') }}">会員一覧</a>
                                </li>


                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-tags"></i> タググループ設定<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            	<li><a href="{{ url('/dashboard/taggroups') }}">タググループ一覧</a></li>
                                <li><a href="{{ url('/dashboard/taggroups/create') }}">タググループ追加</a></li>

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-tag"></i> タグ設定<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            	<li><a href="{{ url('/dashboard/tags') }}">タグ一覧</a></li>
                            	<li><a href="{{ url('/dashboard/tags/create') }}">タグ新規追加</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

						<li>
                            <a href="#"><i class="fa fa-newspaper-o"></i> カテゴリー設定<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            	<li><a href="{{ url('/dashboard/categories') }}">カテゴリー一覧</a></li>
                            	<li><a href="{{ url('/dashboard/categories/create') }}">カテゴリー追加</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-video-camera"></i> 記事管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('dashboard/articles')}}">記事一覧</a>
                                </li>
                                <li>
                                    <a href="{{url('dashboard/articles/create')}}">新規追加</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-question-circle"></i> 問い合わせ管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ url('/dashboard/contacts') }}">問い合わせ一覧</a>
                                </li>
                                <li>
                                    <a href="{{ url('/dashboard/contacts/create') }}">問合せカテゴリー追加</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-file"></i> 固定ページ<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ url('/dashboard/fixes') }}">固定ページ一覧</a>
                                </li>
                                <li>
                                    <a href="{{ url('/dashboard/fixes/create') }}">固定ページ追加</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> 管理者/モデル設定<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ url('dashboard/register') }}">管理者追加／一覧</a>
                                </li>
                                <li>
                                    <a href="{{ url('dashboard/model/'. Auth::guard('admin')->id() . '/edit') }}">モデル情報編集</a>
                                </li>
                                <li>
                                    <a href="{{ url('dashboard/model/create') }}">モデル新規追加</a>
                                </li>

                                <li>
                                    <a href="{{ url('dashboard/movieup') }}">Upload</a>
                                </li>

                                <li>
                                    <a href="{{ url('dashboard/twtup') }}">twt Upload</a>
                                </li>
                                <li>
                                    <a href="{{ url('dashboard/fbup') }}">fb Upload</a>
                                </li>


                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <!--
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                        </li>
                        -->


                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            @yield('content')
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('/bootstrap/vendor/jquery/jquery.min.js') }}"></script>
    {{-- <script src="http://code.jquery.com/jquery-2.1.3.min.js"></script> --}}

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('/bootstrap/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('/bootstrap/vendor/metisMenu/metisMenu.min.js') }}"></script>

    <!-- Morris Charts JavaScript -->
    <script src="{{ asset('/bootstrap/vendor/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('/bootstrap/vendor/morrisjs/morris.min.js') }}"></script>
    <script src="{{ asset('/bootstrap/data/morris-data.js') }}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('/bootstrap/dist/js/sb-admin-2.js') }}"></script>

</body>
</html>
