@extends('layout.accountmaster')

@section('title', 'My Account - Get My Podcasts!')

@section('content')
<h3>Your Subscriptions</h3>
<div class="col-md-12" class="subscription-container">
	<div class="row">
		@foreach($userSubs as $sub)
		<div class="col-sm-4 col-md-4">
			<div class="thumbnail">
				<img src="{{$sub->image_url}}"
						 id="show-{{$sub->podcast_num}}"
						 data-value="{{$sub->podcast_num}}" />
				<div class="caption" id="episodes-{{$sub->podcast_num}}">
					<div class="row">
					<input type="hidden" id="unsub-{{$sub->podcast_num}}-podcast-id" value="{{$sub->id}}" />
					<input type="hidden" id="unsub-{{$sub->podcast_num}}-user-id" value="{{Auth::id()}}" />
						<div class="btn-group" role="group" aria-label="...">
  						<button type="button" class="btn btn-default">
  							Refresh
  							<i class="glyphicon glyphicon-refresh"></i>
  						</button>
  						<button type="button" class="btn btn-danger" 
  								id="unsub-show-{{$sub->podcast_num}}"
  								data-value="{{$sub->podcast_num}}">
  							Unsubscribe
  						</button>
						</div>
					</div>
					<div class="row" style="margin-bottom: 0.7em;"></div>	
					<table class="table table-striped episode-sub-table">
						@foreach($sub->episodes as $episode)
							<tr>
								<td>
									<div>
										<span class="pull-left" style="overflow: none;">
											<small>{{$episode["episode_title"]}}</small>
										</span>
									</div>
								</td>
								<td>
									<span class="pull-right">
											<a href="#">
												<span 
													id="play-episode-{{$episode['episode_num']}}"
													data-value="{{$episode['audio_link']}}"
													data-episodeTitle="{{$episode['episode_title']}}"
													class="glyphicon glyphicon-play">
													</span>
											</a>
										</span>
								</td>
							</tr>						
						@endforeach
					</table>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
<div id="detail-container" style="display: none;">
</div>
@endsection