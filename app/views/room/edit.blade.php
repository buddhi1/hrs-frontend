@extends('layouts.main')

@section('content')

	<h3>Edit New Room Type</h3>
	{{ Form::open(array('url' => 'admin/room/update')) }}
	{{ Form::hidden('id', $rooms->id) }}
	<table>
		<tr>
			<td>{{ Form::label('room_name', 'Room Name') }}</td>
			<td>{{ Form::text('name',$rooms->name) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('room_no', 'No Rooms') }}</td>
			<td>{{ Form::text('no_of_room',$rooms->no_of_rooms) }}</td>
		</tr>

		<tr>
			<td>
				
				<strong>Facilities</strong><br>
				<!-- Populating the Facilities checkboxes -->

				@foreach($facilities as $facility)
				
					<input type = "checkbox" name = "facility[]" value = "<?php echo $facility['name']; ?>" <?php
						if(in_array($facility->name, json_decode($rooms->facilities,true))) {
							echo "checked";
						}
					?>>
					{{ $facility->name }}

					
					<br>
				@endforeach
			</td>
			<td>
				<strong>Services</strong><br>
				<!-- Populating the services checkboxes -->

				@foreach($services as $service)
					<input type = "checkbox" name = "service[]" value = "<?php echo $service['name']; ?>" <?php
						if(in_array($service->name, json_decode($rooms->services,true))) {
							echo "checked";
						}
					?>>
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