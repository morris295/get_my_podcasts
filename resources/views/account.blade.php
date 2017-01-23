@extends('layout.master')

@section('title', 'Profile - CastNinja')

@section('content')
<section class="scrollable">
	<section class="hbox stretch">
		<aside class="aside-lg bg-light lter b-r">
			<section class="vbox">
				<section class="scrollable">
					<div class="wrapper">
						<div class="text-center m-b m-t">
 							<a href="#" class="thumb-lg"> <img src="{{URL::to('/')}}/image/icon-user-default.png" 
 								class="img-circle"> 
							</a>
							<div>
								<div class="h3 m-t-xs m-b-xs">{{Auth::user()->name}}</div>
								<small class="text-muted"><i class="fa fa-map-marker"></i></small>
							</div>
						</div>
						<div class="panel wrapper text-center">
							<div class="row text-center">
								<div class="col-xs-12">
									<a href="#"> <span class="m-b-xs h4 block">{{$totalFollowing}}</span> <small
										class="text-muted">Following</small>
									</a>
								</div>
							</div>
						</div>
						<div>
<!-- 							<small class="text-uc text-xs text-muted">about me</small> -->
<!-- 							<p>Say something about yourself...</p> -->
<!-- 							<small class="text-uc text-xs text-muted">info</small> -->
<!-- 							<p>I mean, please, say something about yourself...</p> -->
<!-- 							<div class="line"></div> -->
<!-- 							<small class="text-uc text-xs text-muted">Share</small> -->
<!-- 							<p class="m-t-sm"> -->
<!-- 								<a href="#" class="btn btn-rounded btn-twitter btn-icon"><i -->
<!-- 									class="fa fa-twitter"></i></a> <a href="#" -->
<!-- 									class="btn btn-rounded btn-facebook btn-icon"><i -->
<!-- 									class="fa fa-facebook"></i></a> <a href="#" -->
<!-- 									class="btn btn-rounded btn-gplus btn-icon"><i -->
<!-- 									class="fa fa-google-plus"></i></a> -->
<!-- 							</p> -->
						</div>
					</div>
				</section>
			</section>
		</aside>
		<aside class="bg-white">
			<section class="vbox">
				<header class="header bg-light lt">
					<ul class="nav nav-tabs nav-white">
						<li class="active"><a href="#following" data-toggle="tab">Following</a></li>
<!-- 						<li class=""><a href="#favorites" data-toggle="tab">Favorites</a></li> -->
					</ul>
				</header>
				<section class="scrollable" style="padding-bottom: 50px;">
					<div class="tab-content">
						<div class="tab-pane active" id="following">
							<ul	class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
							<li class="list-group-item">
								<div class="btn-group m-b">
									<a class="btn btn-success btn-rounded" id="play-all-following">
									<span class="text"> <i class="fa fa-play-circle"></i> Play all
									</a>
								</div>
								<div class="btn-group m-b pull-right">
									<a href="#" class="pull-right text-muted m-t-lg" data-toggle="class:fa-spin" style="margin-top: -0.2em;" >
										<i style="margin-top: 15px;" class="icon-refresh i-lg  inline" id="refresh"></i>
									</a>
								</div>
							</li>
								@foreach($userSubs as $sub)
								@if(isset($sub->episodes[0]))
								<li class="list-group-item"><a href="#" class="thumb-sm pull-left m-r-sm">
 								<img src="{{$sub->image_url}}" class="img-circle" data-value="{{$sub->as_id}}"> 
								</a> <a href="#" class="clear">
									<small class="pull-right">
										<a href="#" class="pull-right text-muted m-t-lg" id="play-latest-{{$sub->podcast_num}}" data-value="{{$sub->episodes[0]['audio_link']}}" data-info="{{$sub->episodes[0]['episode_title']}}" style="margin-top: -0.2em;" >
											<i class="fa fa-play-circle-o" style="font-size: 1.5em;"></i>
										</a>
									</small>
									<a href="{{URL::to('/')}}/{{$sub->resource}}"><strong class="block">{{$sub->title}}</strong></a>
										<small id="episode-{{$sub->podcast_num}}" data-value="{{$sub->episodes[0]['audio_link']}}">{{$sub->episodes[0]["episode_title"]}}</small>
								</a></li>
								@endif
								@endforeach
							</ul>
						</div>
						<div class="tab-pane" id="favorites">
							<div class="text-center wrapper">
								<p>In Progress</p>
								<i class="fa fa-spinner fa fa-spin fa fa-large"></i>
							</div>
						</div>
						<div class="tab-pane" id="interaction">
							<div class="text-center wrapper">
								<i class="fa fa-spinner fa fa-spin fa fa-large"></i>
							</div>
						</div>
					</div>
				</section>
			</section>
		</aside>
		<aside class="col-lg-3 b-l">
			<section class="vbox">
				<section class="scrollable padder-v">
					<div class="panel">
						<h4 class="font-thin padder">Most Popular</h4>
						<ul class="list-group">
							@foreach($topShows as $show)
							<li class="list-group-item">
								<a class="thumb-sm pull-left m-r-sm" href="{{URL::to('/')}}/{{$show['resource']}}">
									<img src="{{$show['image_url']}}" />
								</a>
								<p>
									<a href="{{URL::to('/')}}/{{$show['resource']}}">{{$show["title"]}}</a>
								</p>
								<a href="#" title="Follow">
									<small class="block text-muted">
										<i class="fa fa-heart-o" style="font-size: 1em;"></i>
									</small>
								</a>
							</li>
							@endforeach
						</ul>
					</div>
					<div class="panel clearfix">
<!-- 						<div class="panel-body"> -->
<!-- 							<a href="#" class="thumb pull-left m-r"> -->
<!--  							<img src="images/a0.png"  -->
<!--  								class="img-circle">  -->
<!-- 							</a> -->
<!-- 						</div> -->
					</div>
				</section>
			</section>
		</aside>
	</section>
</section>
@endsection @section('js-libs')
<script src="{{URL::to('/')}}/bower_components/jquery/dist/jquery.js"></script>
<script
	src="{{URL::to('/')}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{URL::to('/')}}/Alertify/src/alertify.js"></script>
@endsection @section('scripts')
<script src="{{URL::to('/')}}/js/lib/async.js"></script>
<script src="{{URL::to('/')}}/js/lib/config.js"></script>
<script src="{{URL::to('/')}}/js/audio.js"></script>
<script src="{{URL::to('/')}}/js/actions.js"></script>
<script src="{{URL::to('/')}}/js/follow.js"></script>
<script src="{{URL::to('/')}}/js/account.js"></script>
<script src="{{URL::to('/')}}/js/img-handler.js"></script>
<script src="{{URL::to('/')}}/js/folders.js"></script>
@endsection
