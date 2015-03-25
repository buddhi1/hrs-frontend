@extends('layouts.main')

@section('content')

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

@if(Session::has('message'))
	{{ Session::get('message') }}
@endif	

{{ Form::open(array('url'=>'admin/tax/create')) }}
	{{ Form::label('lblname', 'Tax name') }}
	{{ Form::text('name') }} <br>
	{{ Form::label('lblname', 'Tax rate') }}
	{{ Form::text('rate') }}
	{{ Form::submit('Add tax') }}
{{ Form::close() }}

@stop