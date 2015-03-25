@extends('layouts.main')

@section('content')

{{ Form::open(array('url' => 'booking/booking2')) }}

{{ Form::label('Identification No') }}
{{ Form::text('id_no', null) }}

{{ Form::label('Start Date') }}
{{ Form::text('start_date', null) }}

{{ Form::label('End Date') }}
{{ Form::text('end_date', null) }}

{{ Form::label('No of Adults') }}
{{ Form::text('no_of_adults', null) }}

{{ Form::label('No of Kids') }}
{{ Form::text('no_of_kids', null) }}

{{ Form::label('No of Rooms') }}
{{ Form::text('no_of_rooms', null) }}

{{ Form::label('Promo Code') }}
{{ Form::text('promo_code', null) }}

{{ Form::submit('Proceed')}}
{{ Form::close() }}

@if(Session::has('message'))

	<p class="text-success">{{ Session::get('message') }}</p>

@endif

@foreach($errors->all() as $error)
	<p>{{ $error }}</p>
@endforeach

@stop