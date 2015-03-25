@extends('layouts.main')

@section('content')

	<h3>All Promo Codes</h3>

	<table border = "1">
		<th>Promo Code</th>
		<th>Start Date</th>
		<th>End Date</th>
		<th>Price</th>
		<th>Stays</th>
		<th>Room Type</th>
		<th>No of Rooms</th>
		<th>Services</th>
		<th>Edit</th>
		<th>Delete</th>
	@foreach($promos as $promo)
	
		<tr>
			<td>{{ $promo->promo_code }}</td>
			<td>{{ $promo->start_date }}</td>
			<td>{{ $promo->end_date }}</td>
			<td>{{ $promo->price }}</td>
			<td>{{ $promo->days }}</td>

			<!-- Get the room type name instead of room_type_id -->
			@foreach($rooms as $room)
				@if($promo->room_type_id === $room->id)
				<td>{{ $room->name }}</td>
				@endif
			@endforeach

			<!-- end-->

			<td>{{ $promo->no_of_rooms }}</td>
			<?php if(json_decode($promo->services) !== null) { ?>
				<td>{{ implode(", ", json_decode($promo->services)) }}</td>

				<?php }else { echo "<td></td>";} ?>
			<td>
				{{ Form::open(array('url' => 'admin/promo/edit')) }}
				{{ Form::hidden('id', $promo->id) }}
				{{ Form::submit('Edit') }}
				{{ Form::close() }}
			</td>
			<td>
				{{ Form::open(array('url' => 'admin/promo/destroy')) }}
				{{ Form::hidden('id', $promo->id) }}
				{{ Form::submit('Delete') }}
				{{ Form::close() }}
			</td>
		</tr>
	
	@endforeach
	</table>

	@if(Session::has('promo_message'))

		<p>{{ Session::get('promo_message') }}</p>
	
	@endif

@stop