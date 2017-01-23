@extends('layout.master')

@section('title', 'Playlists - CastNinja')

@section('content')
<section class="scrollable">
<section class="hbox stretch">
</section>
</section>
@endsection
@section('scripts')
<script src="{{URL::to('/')}}/js/lib/config.js"></script>
<script src="{{URL::to('/')}}/js/lib/async.js"></script>
<script src="{{URL::to('/')}}/js/actions.js"></script>
<script src="{{URL::to('/')}}/js/show.js"></script>
<script src="{{URL::to('/')}}/js/audio.js"></script>
<script src="{{URL::to('/')}}/js/follow.js"></script>
<script src="{{URL::to('/')}}/js/playlist.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.6/jq-2.2.3/dt-1.10.12/datatables.min.js"></script>
@endsection