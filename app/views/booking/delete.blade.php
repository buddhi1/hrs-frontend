@extends('layouts.main')

@section('content')

{{ Form::open(array('url' => 'booking/destroy')) }}

{{ Form::label('Booking ID') }}
{{ Form::text('booking_id') }}

{{ Form::submit('Delete') }}

{{ Form::close() }}

@if(Session::has('message'))

	<p class="text-success">{{ Session::get('message') }}</p>

@endif

@stop