
<div class="col-md-6">
	<table class="table table-responsive shows-table">
		<tr>
			<th colspan="2">Top shows this week</th>
		</tr>
		@foreach ($topShows as $show)
		<tr>
			<td class="artwork"><a href="shows/{{$show['as_id']}}"><img
					class="img-responsive" src="{{$show['image_url']}}"></a></td>
			<td><a href="shows/{{$show['as_id']}}">{{$show["title"]}}</a></td>
		</tr>
		@endforeach
	</table>
</div>
<div class="col-md-6">
	<table class="table table-responsive shows-table">
		<tr>
			<th colspan="2">Most Popular</th>
		</tr>
		@foreach ($tastemakers as $show)
		<tr>
			<td class="artwork"><a href="shows/{{$show['as_id']}}"><img
					class="img-responsive" src="{{$show['image_url']}}"></a></td>
			<td><a href="shows/{{$show['as_id']}}">{{$show["title"]}}</a></td>
		</tr>
		@endforeach
	</table>
</div>
