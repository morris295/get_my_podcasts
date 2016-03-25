<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@yield('title')</title>
		<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/bower_components/bootstrap/dist/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/style/default.css" />
		<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/style/paper.css" />
	</head>
	<body>
		@section('navbar')
			<nav class="navbar navbar-inverse navbar-fixed-top">
		      <div class="container">
		        <div class="navbar-header">
		          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		          </button>
		          <a class="navbar-brand" href="{{URL::to('/')}}">Get My Podcasts</a>
		        </div>
		        <div id="navbar" class="collapse navbar-collapse">
		          <ul class="nav navbar-nav">
		            <li><a href="register">Sign Up</a></li>
		            <li><a href="about">About</a></li>
		            <li><a href="contact">Contact</a></li>
		          </ul>
		          <form class="navbar-form navbar-right">
		          	  {!! csrf_field() !!}
			          <div class="form-group">
			          	<input type="text" placeholder="EMail" class="form-control" />
			          	<input type="text" placeholder="Password" class="form-control" />
			          	<button type="submit" class="btn btn-default">Sign In</button>
			          </div>
		          </form>
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
	    <script src="{{URL::to('/')}}/audio.js"></script>
	</body>
</html>