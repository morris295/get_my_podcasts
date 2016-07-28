@extends('layout.master') @section('title', 'Get My Podcasts!')

@section('content')
<div class="col-md-12">
	<form id="contact">
		<div class="form-group">
			<label for="first-name">Full Name</label> <input class="form-control"
				type="text" id="first-name" />
		</div>
		<div class="form-group">
			<label for="email">E-Mail</label> <input class="form-control"
				type="email" id="email" />
		</div>
		<div class="form-group">
			<label for="password">Comments</label><br />
			<textarea rows="8" cols="134"></textarea>
		</div>
		<div class="form-group" style="float: right;">
			<button type="submit" class="btn btn-default">Submit</button>
		</div>
	</form>
</div>
@endsection
