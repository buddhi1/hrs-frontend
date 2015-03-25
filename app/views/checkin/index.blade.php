@extends('layouts.main')

@section('content')

<h2>Search booking</h2>

@if( Session::has('message') )
	{{ Session::get('message') }}
@endif
<table border="1">
	<tr>
		<th>Checkin Id</th>
		<th>Booking Id</th>
		<th>Authorizer</th>
		<th>Check in</th>
		<th>Check out</th>
		<th>Advace payment</th>
		<th>Payments</th>
	</tr>
	<tr>
		@foreach($checkins as $checkin)
			<td>{{$checkin->id}}</td>
			<td>{{$checkin->booking_id}}</td>
			<td>{{$checkin->authorizer}}</td>
			<td>{{$checkin->check_in}}</td>
			<td>{{$checkin->check_out}}</td>
			<td>{{ $checkin->advance_payment }}</td>
			<td>{{ implode(",", json_decode($checkin->payment)) }}</td>

		@endforeach
	</tr>
</table>

<div>
	@if(Session::has('booking_id'))
		{{ Session::get('booking_id') }}

	@endif
</div>

@stop