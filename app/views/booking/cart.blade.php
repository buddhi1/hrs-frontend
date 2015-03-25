@extends('layouts.main')

@section('content')

<table border = "1">
	<tr>
		<th>Room ID</th>
		<th>Room Name</th>
		<th>No of Rooms</th>
		<th>No of Adults</th>
		<th>No of Kids</th>
		<th>Service ID</th>
		<th>Paid Amount</th>
		<th>Promo Code</th>
		<th>Total Price</th>
		<th>Delete</th>
	</tr>
@foreach($rooms as $room)
	<tr>
		<td>{{ $room->id }}</td>
		<td>{{ $room->name }}</td>
		<td>{{ $room->quantity }}</td>
		<td>{{ $room->options["no_of_adults"] }}</td>
		<td>{{ $room->options["no_of_kids"] }}</td>
		<td>{{ $room->options["services"] }}</td>
		<td>{{ $room->options["paid_amount"] }}</td>
		<td>{{ $room->options["promo_code"] }}</td>
		<td>{{ $room->price }}</td>
		<td>
			<a href = "{{ URL::to('/') }}/booking/removeitem/{{$room->identifier}}">
				Remove product
			</a>
		</td>
	</tr>
@endforeach
</table>

{{ Cart::totalItems() }}

{{ HTML::link('booking/booking1', 'Place Another Booking') }}

{{ Form::open(array('url' => 'booking/placebooking')) }}
{{ Form::submit('Finish Booking') }}
{{ Form::close() }}

@stop