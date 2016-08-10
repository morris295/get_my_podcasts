<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#2196f3">
<meta name="csrf-token" content="{{csrf_token()}}">
<title>@yield('title')</title>
<link rel="stylesheet" type="text/css"
	href="{{URL::to('/')}}/bower_components/bootstrap/dist/css/bootstrap.css" />
<link rel="stylesheet" type="text/css"
	href="{{URL::to('/')}}/style/default.css" />
<link rel="stylesheet" type="text/css"
	href="{{URL::to('/')}}/style/paper.css" />
	<link rel="stylesheet" type="text/css"
	href="{{URL::to('/')}}/style/folders.css" />
<link rel="stylesheet" type="text/css"
	href="{{URL::to('/')}}/Alertify/themes/alertify.core.css" />
<link rel="stylesheet" type="text/css"
	href="{{URL::to('/')}}/Alertify/themes/alertify.default.css" />
<link rel="stylesheet" type="text/css"
	href="{{URL::to('/')}}/Alertify/themes/alertify.bootstrap.css" />
@yield('js-libs')
</head>
<body>
	@section('navbar')
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#navbar" aria-expanded="false"
					aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{URL::to('/')}}">Get My Podcasts</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="about">About</a></li>
					<li><a href="contact">Contact</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#/">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
	@show
	<div class="container">
		<div class="base-template">@yield('content')</div>
	</div>
	<div class="navbar navbar-default navbar-fixed-bottom">
		<div class="container">
			<span class="navbar-text current-playing" id="episode-playing-title">
				Nothing playing: </span> <span class="navbar-text audio-control"> <audio
					id="player" preload="auto" controls>
					<source id="mpeg-source" src="" type="audio/mpeg">
				</audio>
			</span>
		</div>
	</div>
	@yield('scripts')
</body>
</html>
