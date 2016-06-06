@extends('layout.master')

@section('title', 'Get My Podcasts!')

@section('content')
	<input type="hidden" id="show-resource" data-value="{{$showResource}}" />
	<div id="show-content-wrap"></div>
	<!--<div class="col-md-12">
		<h3><a href="">Get all episodes...</a></h3>
	</div>-->
@endsection

@section('footer')
<div class="navbar navbar-default navbar-fixed-bottom">
  <div class="container">
    <span class="navbar-text current-playing" id="episode-playing-title">
    	Nothing playing:
    </span>
    <span class="navbar-text audio-control">
    	<audio id="player" controls>
			<source id="mpeg-source" src="" type="audio/mpeg">
		</audio>
    </span>
  </div>
</div>
@endsection
