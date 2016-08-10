@extends('layout.accountmaster') @section('title', 'My Account - Get My
Podcasts!') @section('content')
<div class="container app-folders-container" style="margin-top: 0px;">
	<!--  -->
	@foreach(array_chunk($userSubs, 4) as $subs)
	<div class="row jaf-row jaf-container">
		<!--  -->
		@foreach($subs as $sub)
		<div class="col-md-3 folder" id="{{$sub->podcast_num}}">
			<a href="#/"> <img class="art-icon app-icon-{{$sub->podcast_num}}"
				src="{{$sub->image_url}}" data-value="{{$sub->as_id}}" />
				<p class="album-name">{{$sub->title}}</p>
			</a> @if($sub == end($subs)) <br class="clear"> @endif
		</div>
		@endforeach
	</div>
	@endforeach @foreach($userSubs as $sub)
	<div class="row folderContent {{$sub->podcast_num}}">
		<div class="jaf-container">
			<div>
				<h3>{{$sub->title}}</h3>
				<div class="col-md-4 show-controls">
					<div class="row">
						<input type="hidden" id="unsub-{{$sub->podcast_num}}-podcast-id"
							value="{{$sub->id}}" /> <input type="hidden"
							id="unsub-{{$sub->podcast_num}}-user-id" value="{{Auth::id()}}" />
						<div class="btn-group" role="group" aria-label="...">
							<button type="button" class="btn btn-default"
								id="refresh-show-{{$sub->podcast_num}}"
								data-value="{{$sub->podcast_num}}" data-resource="{{$sub->id}}">
								Refresh <i class="glyphicon glyphicon-refresh"></i>
							</button>
							<button type="button" class="btn btn-danger"
								id="unsub-show-{{$sub->podcast_num}}"
								data-value="{{$sub->podcast_num}}">Unsubscribe</button>
						</div>
					</div>
				</div>
				<div class="multi" id="show-{{$sub->podcast_num}}-episode-wrap">
					<ol class="secondary-color">
						@foreach($sub->episodes as $episode)
						<li><a href="#/">
								<span id="play-episode-{{$episode['episode_num']}}" data-value="{{$episode['audio_link']}}" data-episodeTitle="{{$episode['episode_title']}}">
									{{$episode["episode_title"]}}
								</span>
								&nbsp;
								<span><i id="play-icon"></i></span>
							</a>
						</li>
						@endforeach
					</ol>
				</div>
			</div>
			<br class="clear">
		</div>
		<a href="#/" class="close" data-value="{{$sub->podcast_num}}">&times;</a>
	</div>
	@endforeach
</div>
@endsection @section('js-libs')
<script src="{{URL::to('/')}}/bower_components/jquery/dist/jquery.js"></script>
<script
	src="{{URL::to('/')}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{URL::to('/')}}/Alertify/src/alertify.js"></script>
@endsection @section('scripts')
<script src="{{URL::to('/')}}/js/lib/third-party/color-thief.js"></script>
<script src="{{URL::to('/')}}/js/lib/third-party/colibri.js"></script>
<script src="{{URL::to('/')}}/js/lib/third-party/jquery.app-folders.js"></script>
<script src="{{URL::to('/')}}/js/lib/async.js"></script>
<script src="{{URL::to('/')}}/js/lib/config.js"></script>
<script src="{{URL::to('/')}}/js/actions.js"></script>
<script src="{{URL::to('/')}}/js/subscribe.js"></script>
<script src="{{URL::to('/')}}/js/account.js"></script>
<script src="{{URL::to('/')}}/js/audio.js"></script>
<script src="{{URL::to('/')}}/js/img-handler.js"></script>
<script src="{{URL::to('/')}}/js/folders.js"></script>
@endsection

