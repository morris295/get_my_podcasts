@extends('layout.master_no_audio')
@section('content')
<div class="scrollable padder-lg w-f-md" id="search-results" style="height: 100%">
	<div class="row row-sm">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				<h2>{{$count}} results found for <em>{{$term}}</em></h2>
			</div>
			<small>Request time ({{$execution}} seconds)</small>
			@foreach($items as $item)
			<div class="hr-line-dashed"></div>
				<div class="search-result">
					<h4>
						<a href="{{URL::to('/')}}/shows/{{$item['as_id']}}">
							{{$item["title"]}}
						</a>
					</h4>
						<a href="{{URL::to('/')}}/shows/{{$item['as_id']}}" class="search-link">{{$item["description"]}}</a>
                        <p></p>
            </div>
            @endforeach
		</div>
	</div>
	@endsection
	@section('scripts')
	<script src="{{URL::to('/')}}/js/search.js"></script>
	@endsection