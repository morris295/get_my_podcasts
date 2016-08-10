@extends('layout.master') @section('content')
<div class="row" id="search-results">
	<div class="search-form">
		<form method="get" action="{{URL::to('/')}}/search" id="front-search">
			<div class="input-group stylish-input-group">
				<input type="text" id="search" placeholder="Search..."
					class="form-control" name="term" /> <span
					class="input-group-addon">
					<button type="submit">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</span>
			</div>
		</form>
	</div>
	<div class="col-lg-12">
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
	@endsection @section('footer')
	<div class="navbar navbar-default navbar-fixed-bottom">
		<div class="container">
			<span class="navbar-text"> Get My Podcasts is and will be free as
				long as I can keep it that way. </span>
		</div>
	</div>
	@endsection