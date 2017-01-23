@extends ('layout.master') @section('title', 'Get My Podcasts!')
@section('content')
<section class="scrollable padder-lg w-f-md" id="bjax-target">
	<a href="#" class="pull-right text-muted m-t-lg" data-toggle="class:fa-spin" >
		<i class="icon-refresh i-lg  inline" id="refresh"></i>
	</a>
	<h2 class="font-thin m-b">Discover</h2>
	<div class="row row-sm" id="main-content-wrap"></div>
</section>
@endsection
@section('scripts')
<script src="{{URL::to('/')}}/js/lib/config.js"></script>
<script src="{{URL::to('/')}}/js/lib/async.js"></script>
<script src="{{URL::to('/')}}/js/audio.js"></script>
<script src="{{URL::to('/')}}/Alertify/src/alertify.js"></script>
<script src="{{URL::to('/')}}/js/img-handler.js"></script>
<script src="{{URL::to('/')}}/js/actions.js"></script>
<script src="{{URL::to('/')}}/js/follow.js"></script>
<script src="{{URL::to('/')}}/js/index.js"></script>
@endsection