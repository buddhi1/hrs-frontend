@extends('layouts.main')

@section('content')

	<h3>Edit a Promo Code</h3>
	{{ Form::open(array('url' => 'admin/promo/update')) }}
	{{ Form::hidden('id', $promos->id) }}

	<?php
		$rooms = RoomType::lists('name', 'id');
	?>
	<table>
		<tr>
			<td>{{ Form::label('Promo Code') }}</td>
			<td>{{ Form::text('promo_code',$promos->promo_code, array('readonly')) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('Room Type') }}</td>
			<td>{{ Form::select('room_type_id', $rooms , $promos->room_type_id) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('Start Date') }}</td>
			<td>{{ Form::text('start_date',$promos->start_date) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('End Date') }}</td>
			<td>{{ Form::text('end_date', $promos->end_date) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('Price') }}</td>
			<td>{{ Form::text('price', $promos->price) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('Stays') }}</td>
			<td>{{ Form::text('days', $promos->stays) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('No of Rooms') }}</td>
			<td>{{ Form::text('no_of_rooms', $promos->no_of_rooms) }}</td>
		</tr>


		<tr>
			<td>Services</td>
			<td>
				<!-- Populating the services checkboxes -->

				@foreach($services as $service)
					<input type = "checkbox" name = "service[]" value = "<?php echo $service['name']; ?>" <?php
						if(in_array($service->name, json_decode($promos->services,true))) {
							echo "checked";
						}
					?>>
					{{ $service->name }}
					<br>
				@endforeach
			</td>
		</tr>

		<tr>
			<td colspan = "2" align = "right">{{ Form::submit('Update') }}</td>
		</tr>

	</table>
	{{ Form::close()}}

	@if(Session::has('promo_message'))

		<p>{{ Session::get('promo_message') }}</p>
	
	@endif

	@if($promo_message)
		{{ $promo_message }}
	@endif

@stop