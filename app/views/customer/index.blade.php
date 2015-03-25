@extends('layouts.main')

@section('content')

{{ Form::open(array('url' => 'customer/rooms')) }}
{{ Form::label('Start Date')}}
{{ Form::text('start_date', null) }}
{{ Form::label('End Date')}}
{{ Form::text('end_date', null) }}

{{ Form::submit('Select Dates')}}

{{ Form::close() }}

@if(Session::has('message'))

	<p>{{ Session::get('message') }}</p>
	
@endif

@stop