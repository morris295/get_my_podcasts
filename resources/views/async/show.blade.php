<div class="jumbotron" id="show-artwork">
	<image class="img-responsive" src="{{$image}}" />
	<!--<p class="show-description">{{$show["description"]}}</p>-->
	<p></p>
	@if (!Auth::guest()) @if($subscribed == false)
	<div>
		<input type="hidden" id="sub-show-id" value="{{$podcastId}}" /> <input
			type="hidden" id="sub-user-id" value="{{Auth::id()}}" />
		<button class="btn btn-default sub-button" id="subscribe">
			Subscribe &nbsp; <span class="glyphicon glyphicon-save"
				id="sub-btn-icon"></span>
		</button>
	</div>
	@else
	<div>
		<input type="hidden" id="sub-show-id" value="{{$podcastId}}" /> <input
			type="hidden" id="sub-user-id" value="{{Auth::id()}}" />
		<button class="btn btn-default subbed-button" id="unsubscribe">
			Subscribed &nbsp; <span class="glyphicon glyphicon-ok"
				id="sub-btn-icon"></span>
		</button>
	</div>
	@endif @endif
</div>
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>{{$show->title}}</h3>
		</div>
		<div class="panel-body">
			<p>{{$show->description}}</p>
		</div>
		<table class="table table-responsive table-striped dt-responsive nowrap" id="episode-table">
			<thead>
				<tr>
	 				<th>Recent Episodes</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($episodes as $episode)
					<tr>
						<td>{{$episode["title"]}}</td>
						<td>{{$episode["published"]}}</td>
						<td>{{$episode["length"]}}</td>
						<td>
							<a href="#/"> <span
								id="play-episode-{{$episode['episode_num']}}"
								data-value="{{$episode['source']}}"
								data-episodeTitle="{{$episode['title']}}"
								class="glyphicon glyphicon-play"> </span>
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>