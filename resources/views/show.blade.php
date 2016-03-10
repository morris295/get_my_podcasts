@extends('layout.master')

@section('title', 'Get My Podcasts!')

@section('content')
	<h1>{{$show["title"]}}</h1>
	<div class="col-md-12">
		<table class="table table-bordered">
			<tr>
				<th colspan="4">Recent Episodes</th>
			</tr>
			@foreach($episodes as $episode)
			<tr>
				<td><image class="artwork" src="{{$image}}"/></td>
				<td>{{$episode["title"]}}</td>
				<td>{{$episode["description"]}}</td>
				<td>
					<audio controls>
						<source src="{{$episode['source']}}" type="audio/mpeg">
					</audio>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection