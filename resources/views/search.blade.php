@extends('layout.master')

@section('content')
	<h1>Search results</h1>
	<div class="row" id="search-results">
		<ul>
			@foreach($items as $item)
				<li>
				<a href="{{URL::to('/')}}/shows/{{$item['as_id']}}">
				{{$item["title"]}}</a></li>
			@endforeach
		</ul>
	</div>
@endsection

@section('footer')
   	<div class="navbar navbar-default navbar-fixed-bottom">
		  <div class="container">
		    <span class="navbar-text">
		    	Get My Podcasts is and will be free as long as I can keep it that way.
		    </span>
		  </div>
    </div>
@endsection