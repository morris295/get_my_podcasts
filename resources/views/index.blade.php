@extends('layout.master')

@section('title', 'Get My Podcasts!')

@section('content')
	<div class="jumbotron">
		<p>Get My Podcasts, your favorite podcatcher!</p>
	</div>
	<div class="col-md-12">
		<form>
          	<div class="input-group stylish-input-group">
          		<input type="text" placeholder="Search..." class="form-control" />
         		<span class="input-group-addon">
         			<button type="submit">
         				<span class="glyphicon glyphicon-search"></span>
         			</button>  
            	</span>
            </div>
        </form>
	</div>
	<div class="col-md-6">
		<table class="table table-bordered">
			<tr>
				<th colspan="2">Top shows yesterday</th>
			</tr>
			@foreach ($topShows as $show)
				<tr>
					<td><a href="{{$show['url']}}"><img src="{{$show['image']}}"></a></td>
					<td><a href="{{$show['url']}}">{{$show["title"]}}</a></td>
				</tr>
			@endforeach
		</table>
	</div>
	<div class="col-md-6">
		<table class="table table-bordered">
			<tr>
				<th colspan="2">Most Popular</th>
			</tr>
			@foreach ($tastemakers as $show)
				<tr>
					<td><a href="{{$show['url']}}"><img src="{{$show['image']}}"></a></td>
					<td><a href="{{$show['url']}}">{{$show["title"]}}</a></td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection
