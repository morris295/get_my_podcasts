@foreach($topShows as $show)
<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
	<div class="item">
		<div class="pos-rlt">
			<div class="bottom">
				<span id="episode-count" class="badge bg-info m-l-sm m-b-sm">{{$show->total_episodes}}</span>
			</div>
			<div class="item-overlay opacity r r-2x bg-black">
				<div class="text-info padder m-t-sm text-sm">
					<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
						class="fa fa-star"></i> <i class="fa fa-star"></i> <i
						class="fa fa-star-o text-muted"></i>
				</div>
				<div class="center text-center m-t-n">
					<a href="#" id="play-button-{{$show->as_id}}" data-value="{{$show->as_id}}">
						<i class="icon-control-play i-2x"></i>
					</a>
				</div>
				<div class="bottom padder m-b-sm">
					{{-- <a href="#" class="pull-right" id="follow-{{$show->id}}" data-sub-show-id="{{$show->id}}" data-sub-user-id="{{Auth::id()}}">
 						<i class="fa fa-heart-o"></i>
						<i class="fa fa-heart text-active text-danger"></i>
					</a> --}}
					<a href="#" id="pl-add-all-episodes" data-value="{{$show->as_id}}">
						<i class="fa fa-plus-circle"></i>
					</a>
				</div>
			</div>
			<a href="#"><img src="{{$show->image_url}}" alt=""
				class="r r-2x img-full" data-value="{{$show->as_id}}"></a>
		</div>
		<div class="padder-v">
			<a href="{{URL::to('/')}}/shows/{{$show->as_id}}" class="text-ellipsis">{{$show->title}}</a>
		</div>
	</div>
</div>
@endforeach