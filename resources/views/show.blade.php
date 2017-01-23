@extends('layout.master')
@section('title', 'CastNinja')

@section('content')
<section>
	<input type="hidden" id="show-resource" data-value="{{$showResource}}" />
	<section class="hbox stretch">
		<section id="content">
			<section class="vbox">
				<section class="w-f-md">
					<section class="hbox stretch bg-black dker">
						<!-- side content -->
						<aside class="col-md-8 no-padder" id="sidebar">
							<section class="vbox animated fadeInUp" id="show-content-wrap">
								
							</section>
						</aside>
						<!-- / side content -->
						<section class="col-md-4 no-padder lt">
							<section class="vbox">
								<section class="scrollable hover">
									<div class="m-t-n-xxs">
									@for($i = 0; $i < 4; $i++)
										<div class="item pos-rlt">
											<a href="#" id="related_link-{{$i}}" class="item-overlay active opacity wrapper-md font-xs">
												<span class="block h3 font-bold text-info" id="related_title-{{$i}}"></span>
												<span class="bottom wrapper-md block">
													Related<i class="icon-arrow-right i-lg pull-right"></i>
												</span>
											</a>
											<center>
												<a href="#">
													<img id="related_img-{{$i}}" style="width: 50%" src="" alt="...">
												</a>
											</center>
										</div>
									@endfor
									</div>
								</section>
							</section>
						</section>
					</section>
				</section>
			</section>
			<a href="#" class="hide nav-off-screen-block"
				data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
		</section>
	</section>
</section>
<script src="{{URL::to('/')}}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{URL::to('/')}}/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="{{URL::to('/')}}/js/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{URL::to('/')}}/js/app.plugin.js"></script>
<script type="text/javascript" src="{{URL::to('/')}}/js/jPlayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="{{URL::to('/')}}/js/jPlayer/add-on/jplayer.playlist.min.js"></script>
@endsection
@section('scripts')
<script src="{{URL::to('/')}}/js/lib/config.js"></script>
<script src="{{URL::to('/')}}/js/lib/async.js"></script>
<script src="{{URL::to('/')}}/js/actions.js"></script>
<script src="{{URL::to('/')}}/js/show.js"></script>
<script src="{{URL::to('/')}}/js/audio.js"></script>
<script src="{{URL::to('/')}}/js/scroll.js"></script>
<script src="{{URL::to('/')}}/js/follow.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.6/jq-2.2.3/dt-1.10.12/datatables.min.js"></script>
@endsection
