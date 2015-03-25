@extends('layouts.main')

@section('content')

Number of Rooms: {{ $summarys['room_no'] }}

Total Booking Price: {{ $summarys['price'] }}

{{ Form::open(array('url' => 'customer/customerform')) }}

{{ Form::submit('Customer Details') }}

{{ Form::close() }}


@stop