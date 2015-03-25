@extends('layouts.main')

@section('content')

	<h3>Add a New Promo Code</h3>
	{{ Form::open(array('url' => 'admin/promo/create')) }}

	<?php
		$rooms = RoomType::lists('name', 'id');
		$rand = rand(1000,9999);
	?>

	<table>
		<tr>
			<td>{{ Form::label('Promo Code') }}</td>
			<td>{{ Form::text('promo_code',$rand, array('required')) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('Room Type') }}</td>
			<td>{{ Form::select('room_id', $rooms ,null) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('Start Date') }}</td>
			<td>{{ Form::text('start_date',null) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('End Date') }}</td>
			<td>{{ Form::text('end_date',null) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('Price') }}</td>
			<td>{{ Form::text('price',null) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('Stays') }}</td>
			<td>{{ Form::text('days',null) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('No of Rooms') }}</td>
			<td>{{ Form::text('no_of_rooms',null) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('Services') }}</td>
			<td>
				@foreach($services as $service)
					{{ Form::checkbox('service[]', $service->name) }}
					{{ $service->name }}
					<br>
				@endforeach
			</td>
		</tr>

		<tr>
			<td colspan = "2" align = "right">{{ Form::submit('Submit') }}</td>
		</tr>

	</table>
	{{ Form::close()}}

	@if(Session::has('room_message_add'))

		<p>{{ Session::get('room_message_add') }}</p>
		
	@endif

@stop