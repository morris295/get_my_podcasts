<table class="table table-striped episode-sub-table">
	<ol class="secondary-color">
		@foreach($episodes as $episode)
			<li>
				<a href="#/">
					<span id="play-episode-{{$episode['episode_num']}}" data-value="{{$episode['source']}}" data-episodeTitle="{{$episode['title']}}">
						{{$episode["title"]}}
					</span>
				</a>
			</li>
		@endforeach
	</ol>
</table>