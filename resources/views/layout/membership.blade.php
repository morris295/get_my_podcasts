<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>@yield('title')</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="{{URL::to('/')}}/js/jPlayer/jplayer.flat.css" type="text/css" />
  <link rel="stylesheet" href="{{URL::to('/')}}/bower_components/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="{{URL::to('/')}}/style/animate.css" type="text/css" />
  <link rel="stylesheet" href="{{URL::to('/')}}/style/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="{{URL::to('/')}}/style/simple-line-icons.css" type="text/css" />
  <link rel="stylesheet" href="{{URL::to('/')}}/style/font.css" type="text/css" />
  <link rel="stylesheet" href="{{URL::to('/')}}/style/app.css" type="text/css" />  
    <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body class="bg-info dker">
  @yield('content')
  <!-- footer -->
  <footer id="footer">
    <div class="text-center padder clearfix">
      <p>
        <small>CastNinja is now, and hopefully always will be, free.</small>
      </p>
    </div>
  </footer>
  <!-- / footer -->
  <script src="{{URL::to('/')}}/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="{{URL::to('/')}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- App -->
  <script src="{{URL::to('/')}}/js/app.js"></script>  
  <script src="{{URL::to('/')}}/js/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="{{URL::to('/')}}/js/app.plugin.js"></script>
  <script type="text/javascript" src="{{URL::to('/')}}/js/jPlayer/jquery.jplayer.min.js"></script>
  <script type="text/javascript" src="{{URL::to('/')}}/js/jPlayer/add-on/jplayer.playlist.min.js"></script>
  <script type="text/javascript" src="{{URL::to('/')}}/js/jPlayer/demo.js"></script>
</body>
</html>