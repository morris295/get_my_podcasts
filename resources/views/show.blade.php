@extends('layout.master')

@section('title', 'Get My Podcasts!')

@section('content')
<input type="hidden" id="show-resource" data-value="{{$showResource}}" />
<div id="show-content-wrap"></div>
<!--<div class="col-md-12">
		<h3><a href="">Get all episodes...</a></h3>
	</div>-->
@endsection @section('footer')
<div class="navbar navbar-default navbar-fixed-bottom">
	<div class="container">
		<span class="navbar-text current-playing" id="episode-playing-title">
			Nothing playing: </span> <span class="navbar-text audio-control">
			<audio
				id="player" controls preload="auto">
				<source id="mpeg-source" src="" type="audio/mpeg">
			</audio>
		</span>
		<span class="navbar-text" style="margin-top: 28px;">
			<a id="popout" href="#">
				<i class="glyphicon glyphicon-new-window"></i>
			</a>
		</span>
	</div>
</div>
@endsection @section('js-libs')
<script src="{{URL::to('/')}}/bower_components/jquery/dist/jquery.js"></script>
<script
	src="{{URL::to('/')}}/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="{{URL::to('/')}}/Alertify/src/alertify.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.6/jq-2.2.3/dt-1.10.12/datatables.min.js"></script>
@endsection @section('scripts')
<script src="{{URL::to('/')}}/js/lib/config.js"></script>
<script src="{{URL::to('/')}}/js/lib/async.js"></script>
<script src="{{URL::to('/')}}/js/actions.js"></script>
<script src="{{URL::to('/')}}/js/subscribe.js"></script>
<script src="{{URL::to('/')}}/js/show.js"></script>
<script src="{{URL::to('/')}}/js/audio.js"></script>
<script src="{{URL::to('/')}}/js/scroll.js"></script>
@endsection
