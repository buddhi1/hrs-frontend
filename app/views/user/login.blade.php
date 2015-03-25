@extends('layouts.main')

@section('content')

@if(Session::has('message'))
	{{ Session::get('message') }}
@endif
@if($errors->has())
	<div>
		<p>Following errors occured:</p>
		<ul>
			@foreach($errors->all() as $error)
				<li>{{$error }}</li>
			@endforeach
		</ul>
	</div>
@endif
{{ Form::open(array('url'=>'admin/login')) }}
	{{ Form::text('name','', array('placeholder'=>'user name here')) }}
	{{ Form::password('password') }}
	{{ Form::submit('Login') }}
{{ Form::close() }}

@stop