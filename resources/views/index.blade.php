@extends('layout.master') @section('title', 'Get My Podcasts!')

@section('content')
<!-- <div class="jumbotron"> -->
<header id="myCarousel" class="carousel slide">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner">
		<div class="item active">
			<a href="">
				<img src="" />
			</a>
		</div>
		<div class="item">
			<a href="">
				<img src="" />
			</a>
		</div>
		<div class="item">
			<a href="">
				<img src="" />
			</a>
		</div>
	</div>

	<!-- Controls -->
	<a class="left carousel-control" href="#myCarousel" data-slide="prev">
		<span class="icon-prev"></span>
	</a> <a class="right carousel-control" href="#myCarousel"
		data-slide="next"> <span class="icon-next"></span>
	</a>
</header>
</div>
<div class="col-md-12">
	<form method="get" action="{{URL::to('/')}}/search" id="front-search">
		<div class="input-group stylish-input-group">
			<input type="text" id="search" placeholder="Search..."
				class="form-control" name="term" /> <span class="input-group-addon">
				<button type="submit">
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</span>
		</div>
	</form>
</div>
<div class=col-md-12 " id="main-content-wrap"></div>
@endsection @section('footer')
<div class="navbar navbar-default navbar-fixed-bottom">
	<div class="container">
		<span class="navbar-text"> Get My Podcasts is and will be free as long
			as I can keep it that way. </span>
	</div>
</div>
@endsection @section('js-libs')
<script src="{{URL::to('/')}}/bower_components/jquery/dist/jquery.js"></script>
<script
	src="{{URL::to('/')}}/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="{{URL::to('/')}}/Alertify/src/alertify.js"></script>
@endsection @section('scripts')
<script src="{{URL::to('/')}}/subscribe.js"></script>
<script src="{{URL::to('/')}}/async-ops.js"></script>
<script src="{{URL::to('/')}}/audio.js"></script>
@endsection
