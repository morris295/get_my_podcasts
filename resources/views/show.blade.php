@extends('layout.master')

@section('title', 'Get My Podcasts!')

@section('content')
	<div class="jumbotron">
		<image src="{{$image}}"/>
		<p class="show-description"><h3>{{$show["description"]}}</h3></p>
	</div>
	<div class="col-md-12">
		<table class="table table-bordered">
			<tr>
				<th colspan="4">Recent Episodes</th>
			</tr>
			@foreach($episodes as $episode)
			<tr>
				<td>{{$episode["title"]}}</td>
				<td><a href="#">
						<span id="play-episode-{{$episode['episode_num']}}" 
							data-value="{{$episode['source']}}" 
							data-episodeTitle="{{$episode['title']}}" 
							class="glyphicon glyphicon-play">
						</span>
					</a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	<!--<div class="col-md-12">
		<h3><a href="">Get all episodes...</a></h3>
	</div>-->
@endsection

@section('footer')
<div class="navbar navbar-default navbar-fixed-bottom">
  <div class="container">
    <span class="navbar-text" id="episode-playing-title">
    	Nothing playing:
    </span>
    <span class="navbar-text">
    	<audio id="player" controls>
			<source id="mpeg-source" src="" type="audio/mpeg">
		</audio>
    </span>
  </div>
</div>
@endsection
