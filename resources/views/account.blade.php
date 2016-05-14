@extends('layout.accountmaster')

@section('title', 'My Account - Get My Podcasts!')

@section('content')
<h3>Your Subscriptions</h3>
<div class="col-md-12">
	<div class="table-responsive">
		@foreach($userSubs as $sub)
			<img style="width: 15%;" 
				 class="pull-left" 
				 src="{{$sub->image_url}}" 
				 id="show-{{$sub->podcast_num}}"
				 data-value="{{$sub->podcast_num}}"/>
				 
		    <table class="table table-striped" id="episodes-{{$sub->podcast_num}}">
				@foreach($sub->episodes as $episode)
					<tr>
						<td>
							<div>
								<span class="pull-left">
									{{$episode["episode_title"]}}
								</span>
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
							</div>
						</td>
					</tr>						
				@endforeach		
			</table>
		@endforeach
	</div>
</div>
<div id="detail-container" style="display: none;">
</div>
@endsection