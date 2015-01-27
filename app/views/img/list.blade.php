@extends("layouts.application")

@section("content")

  @if (Session::has('notice')) <div class="alert alert-info">{{Session::get('notice')}}</div>       @endif

  @if (Session::has('error')) <div class="alert alert-danger">{{Session::get('error')}}</div>       @endif
<div>
  @foreach ($photo as $photo)
	<a href="img/{{$photo->id}}">
		{{ HTML::image($path.'/'.$photo->id.'/thumb-'.$photo->file) }}
	</a>
	
  @endforeach
  </div>

@stop