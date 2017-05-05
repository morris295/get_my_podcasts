@extends('layout.membership')
@section('title', 'CastNinja - Login')
@section('content')
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<div class="container aside-xl">
		<a class="navbar-brand block" href="{{URL::to('/')}}"><span
			class="h1 font-bold">
				<img src="{{ url('/') }}/image/white_logo_transparent_background-1.png" style="max-height: 150px; max-width:200px;" />
			</span></a>
		<section class="m-b-lg">
			<header class="wrapper text-center">
				<strong>Sign in to save playlists and <br /> follow your favorite podcasts</strong>
			</header>
			<form action="{{ url('/login') }}" method="POST">
						{!! csrf_field() !!}
				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					<input type="email" placeholder="Email"
						class="form-control rounded input-lg text-center no-border" name="email">
						@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
				</div>
				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					<input type="password" placeholder="Password"
						class="form-control rounded input-lg text-center no-border" name="password">
						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
				</div>
				<button type="submit"
					class="btn btn-lg btn-warning lt b-white b-2x btn-block btn-rounded">
					<i class="icon-arrow-right pull-right"></i><span class="m-r-n-lg">Sign
						in</span>
				</button>
				<div class="text-center m-t m-b">
					<a href="#"><small>Forgot password?</small></a>
				</div>
				<div class="line line-dashed"></div>
				<p class="text-muted text-center">
					<small>Don't have an account?</small>
				</p>
				<a href="{{URL::to('/')}}/register" class="btn btn-lg btn-info btn-block rounded">Create
					an account</a>
			</form>
		</section>
	</div>
</section>
@endsection
