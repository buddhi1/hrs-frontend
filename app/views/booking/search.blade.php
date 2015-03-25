@extends('layouts.main')

@section('content')

<h2>Search booking</h2>
<div>
	@if(Session::has('message'))
		{{ Session::get('message') }}
	@endif
</div>
<table>
	<tr>
	{{ Form::open(array('url'=>'admin/booking/search')) }}		
		<td> {{ Form::text('booking_id', '') }} </td>
		<td> {{ Form::submit('Search by booking id') }} </td>
	{{ Form::close() }}
	</tr>
	<tr>
	{{ Form::open(array('url'=>'admin/booking/search')) }}		
		<td> {{ Form::text('id', '') }} </td>
		<td> {{ Form::submit('Search by identification no') }} </td>
	{{ Form::close() }}
	</tr>
	
</table>

<div>
	@if(Session::has('booking_id'))
		{{ Session::get('room_type_id') }}
		{{ Session::get('no_of_rooms') }}
		{{ Session::get('no_of_adults') }}
		{{ Session::get('no_of_kids') }}
		{{ Session::get('services') }}
		{{ Session::get('total_charges') }}
		{{ Session::get('paid_amount') }}	
		@if( Session::get('check_in' ) == 0 )
			{{ Form::open(array('url'=>'admin/checkin/create', 'method'=>'GET')) }}
				{{ Form::hidden('booking_id', Session::get('booking_id')) }}
				{{ Form::hidden('identification_no', Session::get('identification_no')) }}
				{{ Form::hidden('check_in', Session::get('check_in')) }}
				{{ Form::hidden('check_out', Session::get('check_out')) }}
								
				{{ Form::submit('Mark Checkin') }}	
			{{ Form::close() }}
		@elseif( Session::get('check_out' ) == 0 )
			{{ Form::open(array('url'=>'admin/checkin/edit', 'method'=>'GET')) }}
				{{ Form::hidden('booking_id', Session::get('booking_id')) }}
				{{ Form::hidden('identification_no', Session::get('identification_no')) }}
				{{ Form::hidden('check_in', Session::get('check_in')) }}
				{{ Form::hidden('check_out', Session::get('check_out')) }}
				
							
				{{ Form::submit('Mark Checkout') }}
			{{ Form::close() }}			
			
		@endif
		

	@endif
</div>
{{ Form::close() }}
@stop