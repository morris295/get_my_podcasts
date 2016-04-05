@extends('layout.master')

@section('title', 'Get My Podcasts!')

@section('content')
	<div class="jumbotron">
		<p>Get My Podcasts, your favorite podcatcher!</p>
	</div>
	<div class="col-md-12">
		<form method="get" action="{{URL::to('/')}}/search">
          	<div class="input-group stylish-input-group">
          		<input type="text" placeholder="Search..." class="form-control" name="term"/>
         		<span class="input-group-addon">
         			<button type="submit">
         				<span class="glyphicon glyphicon-search"></span>
         			</button>  
            	</span>
            </div>
        </form>
	</div>
	<div class="col-md-6">
		<table class="table table-responsive">
			<tr>
				<th colspan="2">Top shows yesterday</th>
			</tr>
			@foreach ($topShows as $show)
				<tr>
					<td><a href="shows/{{$show['as_id']}}"><img src="{{$show['image_url']}}"></a></td>
					<td><a href="shows/{{$show['as_id']}}">{{$show["title"]}}</a></td>
				</tr>
			@endforeach
		</table>
	</div>
	<div class="col-md-6">
		<table class="table table-responsive">
			<tr>
				<th colspan="2">Most Popular</th>
			</tr>
			@foreach ($tastemakers as $show)
				<tr>
					<td><a href="shows/{{$show['as_id']}}"><img src="{{$show['image_url']}}"></a></td>
					<td><a href="shows/{{$show['as_id']}}">{{$show["title"]}}</a></td>
				</tr>
			@endforeach
		</table>
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
