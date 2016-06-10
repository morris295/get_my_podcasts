@extends('layout.master')

@section('title', 'Get My Podcasts!')

@section('content')
	<div class="jumbotron">
		<p>Get My Podcasts, your favorite podcatcher!</p>
	</div>
	<div class="col-md-12">
		<form method="get" action="{{URL::to('/')}}/search">
          	<div class="input-group stylish-input-group">
          		<input type="text" id="search" placeholder="Search..." class="form-control" name="term"/>
         		<span class="input-group-addon">
         			<button type="submit">
         				<span class="glyphicon glyphicon-search"></span>
         			</button>  
            	</span>
            </div>
        </form>
	</div>
	<div class=col-md-12" id="main-content-wrap">
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
@section('js-libs')
<script src="{{URL::to('/')}}/bower_components/jquery/dist/jquery.js"></script>
<script src="{{URL::to('/')}}/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="{{URL::to('/')}}/Alertify/src/alertify.js"></script>
<script src="{{URL::to('/')}}/twitter-typeahead/typeahead.js"></script>
@endsection
@section('scripts')
<script src="{{URL::to('/')}}/subscribe.js"></script>
<script src="{{URL::to('/')}}/async-ops.js"></script>
<script src="{{URL::to('/')}}/audio.js"></script>
<script src="{{URL::to('/')}}/search.js"></script>
@endsection