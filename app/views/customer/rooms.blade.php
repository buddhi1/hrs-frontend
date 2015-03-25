@extends('layouts.main')

@section('content')

@foreach($available_rooms as $room)
	<div>
		{{ Form::open(array('url' => 'customer/bookingsummary')) }}
		{{ Form::hidden('id', $room['id']) }}
		{{ Form::hidden('service_id', $room['service_id']) }}
		{{ $room['name'] }}{{ Form::hidden('name', $room['name']) }} with 
		{{ $room['service'] }}{{ Form::hidden('service', $room['service']) }}&nbsp;{{'||'}}Facilities - 
		<?php if(json_decode($room['facility']) !== null) { ?>
				{{ implode(", ", json_decode($room['facility'])) }}
		<?php } ?>{{ Form::hidden('facility', $room['facility']) }}{{'||'}}
		price - {{ $room['price'] }}{{ Form::hidden('price', $room['price']) }}
		No of Rooms - {{ Form::selectRange('number', 1, $room['rooms_qty']) }}
		No of Adults - {{ Form::selectRange('no_of_adults', 1, 2) }}
		No of Kids - {{ Form::selectRange('no_of_kids', 1, 2) }}
		{{ Form::submit('Reserve') }}
		{{ Form::close() }}
	</div>
@endforeach

@stop