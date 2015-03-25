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

{{ Form::open(array('url'=>'admin/tax/update')) }}
	{{ Form::hidden('id', $id) }}
	{{ Form::label('lblname', 'Tax name') }}
	{{ Form::text('name', $name) }} <br>
	{{ Form::label('lblname', 'Tax rate') }}
	{{ Form::text('rate', $rate) }}
	{{ Form::submit('Edit tax') }}
{{ Form::close() }}

@stop