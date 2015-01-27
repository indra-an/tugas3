@extends("layouts.application")

  @section("content")

  <div>

    <h1>{{$photo->title}}</h1>

		{{ HTML::image($path.'/'.$photo->id.'/'.$photo->file) }}
	 
     <br/>   
     <br/>   
	 {{ Form::open(array('route' => array('img.destroy', $photo->id), 'method' => 'delete')) }}
        {{link_to('img/'.$photo->id.'/edit', 'Edit', array('class' => 'btn btn-warning'))}}
		{{ Form::submit('Delete', array('class' => 'btn btn-danger', "onclick" => "return confirm('are you sure?')")) }}
      {{ Form::close() }}
  </div>
	
  @stop