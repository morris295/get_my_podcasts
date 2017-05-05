<meta name="primaryColor" content="{{$primaryColor}}">
<meta name="contrastColor" content="{{$show->contrastColor}}">
<section class="scrollable">
	<div class="m-t-n-xxs item pos-rlt">
		<div class="top text-right wrapper-lg">
		@if($followers > 0)
			<span class="pull-right text-sm">{{$followers}} <br>
			@if($followers > 1)
				Followers
			@else
				Follower
			@endif
			</span>
		@endif
		</div>
		<div class="bottom gd bg-info wrapper-lg">
			@if(Auth::check())
				<span class="pull-right">
					<a href="#" class="pull-right" id="follow-{{$show->id}}" data-sub-show-id="{{$show->id}}" data-sub-user-id="{{Auth::id()}}" data-following="{{$subscribed}}">
					@if($subscribed)
						<i class="fa fa-heart text-danger" title="follow"></i>
					@else
						<i class="fa fa-heart-o" title="follow"></i>
					@endif
					</a>
				</span>
			@endif
			<span class="h2 font-thin" id="show-title">{{$show->title}}</span>
		</div>
		<center>
			<img src="{{$image}}" alt="..." style="width: 50%;">
		</center>
	</div>
	<div class="table-responsive">
		<div class="DataTables_Table_0_wrapper" class="dataTables_wrapper">
			<table class="table table-responsive dt-responsive nowrap"
				id="episode-table">
				<thead>
					<tr>
						<th>Recent Episodes</th>
						<th>Date</th>
						<th>Length</th>
						<th>Add Episode</th>
						<th>Play</th>
					</tr>
				</thead>
				<tbody>
					@foreach($episodes as $episode)
					<tr>
						<td>{{$episode["title"]}}</td>
						<td>{{$episode["published"]}}</td>
						<td>{{$episode["length"]}}</td>
						<td><a href="#/"><span><i class="fa fa-plus-circle"></i></span></a></td>
						<td><a href="#/" id="play-link"> <span
								id="play-episode-{{$episode['episode_num']}}"
								data-value="{{$episode['source']}}"
								data-episodeTitle="{{$episode['title']}}"
								class="icon-control-play"></span>
						</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>

