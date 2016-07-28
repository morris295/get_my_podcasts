<table class="table table-striped episode-sub-table">
	@foreach($episodes as $episode)
	<tr>
		<td>
			<div>
				<span class="pull-left" style="overflow: none;"> <small>{{$episode["title"]}}</small>
				</span>
			</div>
		</td>
		<td><span class="pull-right"> <a href="#"> <span
					id="play-episode-{{$episode['episode_num']}}"
					data-value="{{$episode['source']}}"
					data-episodeTitle="{{$episode['title']}}"
					class="glyphicon glyphicon-play"> </span>
			</a>
		</span></td>
	</tr>
	@endforeach
</table>