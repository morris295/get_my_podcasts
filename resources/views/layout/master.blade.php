<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="theme-color" content="#2196f3">
	    <meta name="csrf-token" content="{{csrf_token()}}">
		<title>@yield('title')</title>
		<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/bower_components/bootstrap/dist/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/style/default.css" />
		<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/style/paper.css" />
		<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/Alertify/themes/alertify.core.css" />
		<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/Alertify/themes/alertify.default.css" />
		<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/Alertify/themes/alertify.bootstrap.css" />
	</head>
	<body>
		@section('navbar')
			<nav class="navbar navbar-inverse navbar-fixed-top">
		      <div class="container">
		        <div class="navbar-header">
		        	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	          		<span class="sr-only">Toggle navigation</span>
	            	<span class="icon-bar"></span>
	            	<span class="icon-bar"></span>
	            	<span class="icon-bar"></span>
          		</button>
		          <a class="navbar-brand" href="{{URL::to('/')}}">Get My Podcasts</a>
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
		          <ul class="nav navbar-nav">
		            <li><a href="about">About</a></li>
		            <li><a href="contact">Contact</a></li>
	            @if (Auth::guest())
	            	<li><a href="register">Sign Up</a></li>
	          	  <li><a href="{{URL::to('/')}}/login">Login</a></li>
	          	@else
	          	  <li><a href="{{URL::to('/')}}/my-account/{{Auth::id()}}">My Account</a></li>
	          	  <li><a href="#/">Logout</a></li>
	          	@endif
		          </ul>
		        </div>
		      </div>
		    </nav>
		@show
		<div class="container">
      	  <div class="base-template">
	        @yield('content')
	      </div>
	    </div>
	    @yield('footer')
	    <script src="{{URL::to('/')}}/bower_components/jquery/dist/jquery.js"></script>
	    <script src="{{URL::to('/')}}/bower_components/bootstrap/dist/js/bootstrap.js"></script>
	    <script src="{{URL::to('/')}}/Alertify/src/alertify.js"></script>
	    <script src="{{URL::to('/')}}/subscribe.js"></script>
	    <script src="{{URL::to('/')}}/audio.js"></script>
	</body>
</html>