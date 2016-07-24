@foreach($episodes as $episode)
<tr>
	<td>{{$episode["title"]}}</td>
	<td>{{$episode["length"]}}</td>
	<td><a href="#/"> <span id="play-episode-{{$episode['episode_num']}}"
			data-value="{{$episode['source']}}"
			data-episodeTitle="{{$episode['title']}}"
			class="glyphicon glyphicon-play"> </span>
	</a></td>
</tr>
@endforeach
