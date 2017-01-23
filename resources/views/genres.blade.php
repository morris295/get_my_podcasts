@extends('layout.master') @section('title', 'Genres - CastNinja')

@section('content')
<section class="scrollable padder-lg w-f-md" id="bjax-target" style="top: 10px;">
	<div class="row row-sm">
		@if(count($genres) > 0) @foreach($genres as $genre)
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
			<div class="item">
				<div class="pos-rlt"></div>
				<div class="padder-v">
					<a href="{{URL::to('/')}}/genre/{{$genre['id']}}"
						class="text-ellipsis">{{$genre['name']}}</a>
				</div>
			</div>
		</div>
		@endforeach @elseif(count($shows) > 0) @foreach($shows as $show)
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
			<div class="item">
				<a href="{{URL::to('/')}}/shows/{{$show->as_id}}">
					<div class="pos-rlt">
						<div class="bottom">
							<span id="episode-count" class="badge bg-info m-l-sm m-b-sm">{{$show->total_episodes}}</span>
						</div>
						<div class="item-overlay opacity r r-2x bg-black"></div>
						<a href="#"><img src="{{$show->image_url}}" alt=""
							class="r r-2x img-full" data-value="{{$show->as_id}}"></a>
					</div>
				</a>
				<div class="padder-v">
					<a href="{{URL::to('/')}}/shows/{{$show->as_id}}"
						class="text-ellipsis">{{$show->title}}</a>
				</div>
			</div>
		</div>
		@endforeach @endif
	</div>
</section>
@endsection @section('scripts')
<script src="{{URL::to('/')}}/js/lib/config.js"></script>
<script src="{{URL::to('/')}}/js/lib/async.js"></script>
<script src="{{URL::to('/')}}/js/actions.js"></script>
<script src="{{URL::to('/')}}/js/show.js"></script>
<script src="{{URL::to('/')}}/js/audio.js"></script>
<script src="{{URL::to('/')}}/js/follow.js"></script>
<script src="{{URL::to('/')}}/js/genre.js"></script>
<script type="text/javascript"
	src="https://cdn.datatables.net/v/bs-3.3.6/jq-2.2.3/dt-1.10.12/datatables.min.js"></script>
@endsection
