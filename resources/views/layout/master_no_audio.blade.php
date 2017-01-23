<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>CastNinja</title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="csrf-token" content="{{csrf_token()}}">
  <link rel="stylesheet" href="{{URL::to('/')}}/js/jPlayer/jplayer.flat.css" type="text/css" />
  <link rel="stylesheet" href="{{URL::to('/')}}/bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="{{URL::to('/')}}/style/animate.css" type="text/css" />
  <link rel="stylesheet" href="{{URL::to('/')}}/style/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="{{URL::to('/')}}/style/simple-line-icons.css" type="text/css" />
  <link rel="stylesheet" href="{{URL::to('/')}}/style/font.css" type="text/css" />
  <link rel="stylesheet" href="{{URL::to('/')}}/style/app.css" type="text/css" />
  <link rel="stylesheet" href="{{URL::to('/')}}/style/default.css" type="text/css" />
  <link rel="stylesheet" href="{{URL::to('/')}}/style/search-results.css" type="text/css" />
  <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/Alertify/themes/alertify.core.css" />
  <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/Alertify/themes/alertify.default.css" />
  <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/Alertify/themes/alertify.bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/style/loader.css" />
    <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body class="loader-body">
  <div class="cs-loader">
    <div class="cs-loader-inner">
      <label>&#149;</label>
      <label>&#149;</label>
      <label>&#149;</label>
      <label>&#149;</label>
      <label>&#149;</label>
      <label>&#149;</label>
    </div>
  </div>
  <section class="vbox">
  	<!-- Page header -->
    <header class="bg-black lter header header-md navbar navbar-fixed-top-xs">
      <div class="navbar-header aside bg-info nav-xs">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
          <i class="icon-list"></i>
        </a>
        <a href="{{URL::to('/')}}" class="navbar-brand text-lt">
          <i class="icon-earphones"></i>
          <img src="images/logo.png" alt="." class="hide">
          <span class="hidden-nav-xs m-l-sm">CastNinja</span>
        </a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">
          <i class="icon-settings"></i>
        </a>
      </div>      <ul class="nav navbar-nav hidden-xs">
        <li>
          <a href="#nav,.navbar-header" data-toggle="class:nav-xs,nav-xs" class="text-muted">
            <i class="fa fa-indent text"></i>
            <i class="fa fa-dedent text-active"></i>
          </a>
        </li>
      </ul>
      <form class="navbar-form navbar-left input-s-lg m-t m-l-n-xs hidden-xs" method="get" action="{{URL::to('/')}}/search" role="search">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-sm bg-white btn-icon rounded" style="margin-right: 3px;">
              	<i class="fa fa-search"></i>
              </button>
            </span>
            <input type="text" name="term" class="form-control input-sm no-border rounded" placeholder="Search...">
          </div>
        </div>
      </form>
      <div class="navbar-right ">
      @if(!Auth::guest())
        <ul class="nav navbar-nav m-n hidden-xs nav-user user">
          <li class="hidden-xs">
<!--             <a href="#" class="dropdown-toggle lt" data-toggle="dropdown"> -->
<!--               <i class="icon-bell"></i> -->
<!--               <span class="badge badge-sm up bg-danger count">2</span> -->
<!--             </a> -->
<!--             <section class="dropdown-menu aside-xl animated fadeInUp"> -->
<!--               <section class="panel bg-white"> -->
<!--                 <div class="panel-heading b-light bg-light"> -->
<!--                   <strong>You have <span class="count">2</span> notifications</strong> -->
<!--                 </div> -->
<!--                 <div class="list-group list-group-alt"> -->
<!--                   <a href="#" class="media list-group-item"> -->
<!--                     <span class="pull-left thumb-sm"> -->
<!--                       <img src="images/a0.png" alt="..." class="img-circle"> -->
<!--                     </span> -->
<!--                     <span class="media-body block m-b-none"> -->
<!--                       Use awesome animate.css<br> -->
<!--                       <small class="text-muted">10 minutes ago</small> -->
<!--                     </span> -->
<!--                   </a> -->
<!--                   <a href="#" class="media list-group-item"> -->
<!--                     <span class="media-body block m-b-none"> -->
<!--                       1.0 initial released<br> -->
<!--                       <small class="text-muted">1 hour ago</small> -->
<!--                     </span> -->
<!--                   </a> -->
<!--                 </div> -->
<!--                 <div class="panel-footer text-sm"> -->
<!--                   <a href="#" class="pull-right"><i class="fa fa-cog"></i></a> -->
<!--                   <a href="#notes" data-toggle="class:show animated fadeInRight">See all the notifications</a> -->
<!--                 </div> -->
<!--               </section> -->
<!--             </section> -->
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle bg clear" data-toggle="dropdown">
              <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
              </span> {{Auth::user()->name}} <b class="caret"></b>
            </a>
            <ul class="dropdown-menu animated fadeInRight">            
              <li>
                <span class="arrow top"></span>
                <a href="#">Settings</a>
                {{-- TODO: Implement a settings page. --}}
              </li>
              <li>
                <a href="{{URL::to('/')}}/my-account/{{Auth::user()->id}}">Profile</a>
              </li>
              {{-- <li>
                <a href="#">
                  <span class="badge bg-danger pull-right">3</span>
                  Notifications
                </a>
              </li> --}}
              <li>
                <a href="docs.html">Help</a>
              </li>
              <li class="divider"></li>
              <li>
                <li><a href="{{URL::to('/')}}/auth/logout">Logout</a></li>
              </li>
            </ul>
          </li>
        </ul>
        @endif
        @if(Auth::guest())
        	<ul class="nav navbar-nav m-n hidden-xs nav-user user">
        		<li><a class="btn btn" href="{{URL::to('/')}}/register">Sign Up</a></li>
        		<li><a class="btn btn-primary" style="background-color: #1ab667;" href="{{URL::to('/')}}/login">Login</a></li>
        		<li style="width: 25px"></li>
        	</ul>
        @endif
      </div>      
    </header>
    <!-- End page header -->
    <section>
      <section class="hbox stretch">
        <!-- Left nav -->
        <aside class="bg-black dk nav-xs aside hidden-print" id="nav">          
          <section class="vbox">
            <section class="w-f-md scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
                


                <!-- nav -->                 
                <nav class="nav-primary hidden-xs">
                  <ul class="nav bg clearfix">
                    <li class="hidden-nav-xs padder m-t m-b-sm text-xs text-muted">
                      Discover
                    </li>
                    <li>
                      <a href="{{URL::to('/')}}">
                        <i class="icon-globe icon text-success"></i>
                        <span class="font-bold">Discover</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{URL::to('/')}}/genres">
                        <i class="icon-music-tone-alt icon text-info"></i>
                        <span class="font-bold">Genres</span>
                      </a>
                    </li>
                    @if(!Auth::guest())
                        <li>
                          <a href="{{URL::to('/')}}/my-account/{{Auth::id()}}">
                            <i class="icon-feed icon text-info-dker"></i>
                            <span class="font-bold">Following</span>
                          </a>
                        </li>
                    @endif
                    <li>
                      <a href="video.html" data-target="#content" data-el="#bjax-el" data-replace="true">
                        <i class="icon-social-youtube icon text-primary"></i>
                        <span class="font-bold">Video</span>
                      </a>
                    </li>
                    <li class="m-b hidden-nav-xs"></li>
                  </ul>
                  @if(!Auth::guest())
                      <ul class="nav text-sm">
                        <li>
                          <a href="#">
                            <i class="icon-music-tone icon"></i>
                            <span>Playlists</span>
                          </a>
                        </li>
                      </ul>
                  @endif
                </nav>
                <!-- / nav -->
              </div>
            </section>
            
            <footer class="footer hidden-xs no-padder text-center-nav-xs">   
			</footer> 
          </section>
        </aside>
        <!-- End left nav -->
        
        <!-- Central content -->
        <section id="content">
          <section class="hbox stretch">
            <section>
              <section class="vbox">
                @yield('content')
              </section>
            </section>
            <!-- side content -->
            <aside class="aside-md bg-light dk" id="sidebar">
              <section class="vbox animated fadeInRight">
                <section class="w-f-md scrollable hover">
                </section>
<!--                 <footer class="footer footer-md bg-black"></footer> -->
              </section>              
            </aside>
            <!-- / side content -->
          </section>
          <!-- End Central content -->
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
        </section>
      </section>
    </section>    
  </section>
  <script src="{{URL::to('/')}}/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="{{URL::to('/')}}/bower_components/bootstrap/dist/js/bootstrap.js"></script>
  <!-- App -->
  <script src="{{URL::to('/')}}/Alertify/lib/alertify.min.js"></script>
  <script src="{{URL::to('/')}}/js/lib/loader.js"></script>
  <script src="{{URL::to('/')}}/js/lib/async.js"></script>
  <script src="{{URL::to('/')}}/js/lib/config.js"></script>
  <script src="{{URL::to('/')}}/js/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="{{URL::to('/')}}/js/app.plugin.js"></script>
  <script type="text/javascript" src="{{URL::to('/')}}/js/jPlayer/jquery.jplayer.min.js"></script>
  <script type="text/javascript" src="{{URL::to('/')}}/js/jPlayer/add-on/jplayer.playlist.min.js"></script>
  <script src="{{URL::to('/')}}/js/app.js"></script>
  @yield('scripts')
</body>
</html>