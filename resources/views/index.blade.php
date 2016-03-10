@extends('layout.master')

@section('title', 'Get My Podcasts!')

@section('content')
	<div class="jumbotron">
		<p>Get My Podcasts, your favorite podcatcher!</p>
	</div>
	<div class="col-md-6">
		<table class="table table-bordered">
			<tr><th>Top shows yesterday</th></tr>
			@foreach ($topShows as $show)
				<tr>
					<td><a href="#">{{$show}}</a></td>
				</tr>
			@endforeach
		</table>
	</div>
	<div class="col-md-6">
		<table class="table table-bordered">
			<tr><th>Tastemakers</th></tr>
			@foreach ($tastemakers as $show)
				<tr>
					<td><a href="{{$show["url"]}}" target="_blank">{{$show["title"]}}</a></td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection