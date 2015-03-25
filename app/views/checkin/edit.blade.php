@extends('layouts.main')

@section('content')
<h2>Edit checkin</h2>
<table>
	{{ Form::open(array('url' => 'admin/checkin/update')) }}

	<tr>
		<td>Authorizer</td>
		<td>{{ Form::text('auth', $identification_no) }}</td>
	</tr>

	<tr>
		<td>Booking ID</td>
		<td>{{ Form::text('booking_id', $booking_id) }}</td>
	</tr>
	@if( $check_in != null )
	<tr>
		
		<td> <h4>Checked in</h4>	</td>
		<td>&nbsp;</td>	
	</tr>	
	<tr>
		<td>Check Out</td>
		<td>{{ Form::checkbox('check_out') }}</td>
	</tr>	
	@else
	<tr>
		<td>Check out</td>
		<td>{{ Form::checkbox('check_in')}}</td>			
	</tr>
	<tr>
		<td>Advance Payment</td>
		<td>{{ Form::text('advance_payment', null) }}</td>
	</tr>
	@endif	
	<tr>
		<td>Payments so far</td>
		<td>{{ $payments }}</td>
	</tr>
	<tr>
		<td>Payment</td>
		<td>{{ Form::text('payment', null) }}</td>
	</tr>

	<tr>
		<td>{{ Form::submit('Submit') }}</td>
	</tr>

	{{ Form::close() }}
</table>

{{ HTML::link('admin/checkin/addpayment', 'Add a Payment to an exsisting Check in') }}

@if(Session::has('message'))

	<p class="text-success">{{ Session::get('message') }}</p>

@endif


@stop