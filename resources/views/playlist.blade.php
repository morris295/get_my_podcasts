@extends('layout.master') @section('title', 'Playlists - CastNinja')

@section('content')
<section class="scrollable">
	<section class="hbox stretch">
		<aside class="aside-lg bg-light lter b-r">
			<section class="vbox">
				<section class="scrollable">
					<div class="wrapper">
						<ul
							class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
							@foreach($playlists as $playlist)
							<li class="list-group-item playlist-name-item">
							<a href="#contents" data-toggle="tab"><em>{{$playlist->name}}</em></a>
							<span class="pull-right list-tools" id="playlist-tools">
								<a href="#" title="Default">
									@if($playlist->default > 0)
										<i class="fa fa-star text-warning"></i>
									@else
										<i class="fa fa-star-o text-muted"></i>
									@endif
								</a>
								<a href="#" title="Edit">
									<i class="fa fa-pencil text-success"></i>
								</a>
								<a href="#" title="Delete">
									<i class="icon-trash text-danger"></i>
								</a>
							</span>
							</li> 
							@endforeach
							<li class="list-group-item">
								<button class="btn btn-success">Create Playlist</button>
							</li>
						</ul>
					</div>
				</section>
			</section>
		</aside>
		<aside class="bg-white">
			<section class="vbox">
				<header class="header bg-light lt">
					<ul class="nav nav-tabs nav-white">
<!-- 						@foreach($playlists as $playlist) -->
<!-- 						<li class="active"><a href="#contents" data-toggle="tab">Playlist: {{$playlist->name}}</a></li> -->
<!-- 						@endforeach -->
					</ul>
				</header>
				<section class="scrollable" style="padding-bottom: 50px;">
					@foreach($playlists as $playlist)
					<div class="tab-content">
						<div class="tab-pane active" id="contents">
							<ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
								@foreach($playlist->content as $item)
								<li class="list-group-item">
									{{$item["title"]}}
									<span class=pull-right">
									<!-- Get the name of the podcast and put it here. -->
									</span>
								</li>
								@endforeach
							</ul>
						</div>
					</div>
					@endforeach
					<div class="tab-pane" id="contents">
						<div class="text-center wrapper"></div>
					</div>
				</section>
			</section>
		</aside>
		<aside class="col-lg-3 b-l">
		</aside>
	</section>
	@endsection @section('scripts')
	<script src="{{URL::to('/')}}/js/lib/config.js"></script>
	<script src="{{URL::to('/')}}/js/lib/async.js"></script>
	<script src="{{URL::to('/')}}/js/actions.js"></script>
	<script src="{{URL::to('/')}}/js/show.js"></script>
	<script src="{{URL::to('/')}}/js/audio.js"></script>
	<script src="{{URL::to('/')}}/js/follow.js"></script>
	<script src="{{URL::to('/')}}/js/playlist.js"></script>
	<script type="text/javascript"
		src="https://cdn.datatables.net/v/bs-3.3.6/jq-2.2.3/dt-1.10.12/datatables.min.js"></script>
	@endsection