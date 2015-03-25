@extends('layouts.main')

@section('content')

	<h3>All Rooms</h3>

	<table border = "1">
		<th>Room Name</th>
		<th>Room Facilities</th>
		<th>Room Services</th>
		<th>No of Rooms</th>
		<th>Edit</th>
		<th>Delete</th>
	@foreach($rooms as $room)
	
		<tr>
			<td>{{ $room->name }}</td>
			<?php if(json_decode($room->facilities) !== null) { ?>
				<td>{{ implode(", ", json_decode($room->facilities)) }}</td>

				<?php }else { echo "<td></td>";} ?>
			<?php if(json_decode($room->services) !== null) { ?>
				<td>{{ implode(", ", json_decode($room->services)) }}</td>

				<?php }else { echo "<td></td>";} ?>
			<!--<td>{{ implode(", ", json_decode($room->facilities)) }}</td>
			<td>{{ implode(", ", json_decode($room->services)) }}</td>-->
			<td>{{ $room->no_of_rooms }}</td>
			<td>
				{{ Form::open(array('url' => 'admin/room/edit')) }}
				{{ Form::hidden('id', $room->id) }}
				{{ Form::submit('Edit') }}
				{{ Form::close() }}
			</td>
			<td>
				{{ Form::open(array('url' => 'admin/room/destroy')) }}
				{{ Form::hidden('id', $room->id) }}
				{{ Form::submit('Delete') }}
				{{ Form::close() }}
			</td>
		</tr>
	
	@endforeach
	</table>

	@if(Session::has('room_message_del'))

		<p>{{ Session::get('room_message_del') }}</p>
	
	@endif

	@if(Session::has('room_message_add'))

		<p>{{ Session::get('room_message_add') }}</p>
	
	@endif

@stop