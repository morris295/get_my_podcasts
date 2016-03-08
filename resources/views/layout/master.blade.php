<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@yield('title')</title>
		<link rel="stylesheet" type="text/css" href="../public/bower_components/bootstrap/dist/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="../public/style/default.css" />
	</head>
	<body>
		@section('navbar')
			<nav class="navbar navbar-inverse navbar-fixed-top">
		      <div class="container">
		        <div class="navbar-header">
		          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		          </button>
		          <a class="navbar-brand" href="#">Get My Podcasts</a>
		        </div>
		        <div id="navbar" class="collapse navbar-collapse">
		          <ul class="nav navbar-nav">
		            <li class="active"><a href="{{URL::to('/')}}">Home</a></li>
		            <li><a href="about">About</a></li>
		            <li><a href="contact">Contact</a></li>
		          </ul>
		          <form class="navbar-form navbar-right">
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
	   	@section('footer')
	    <footer class="footer">
	    	<div class="container">
	    		<p class="text-muted">Get My Podcasts is provided completely free and is a labor of love.</p>
	    	</div>
	    </footer>
	</body>
</html>