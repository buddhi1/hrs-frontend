@extends('layouts.main')

@section('content')

<h2>Edit Room price calendar record</h2>
<table>
	{{ Form::open(array('url'=>'/admin/calendar/update')) }}
	<tr>
		<td clospan="2"> 
			@if(Session::has('message'))
				<h3>{{ Session::get('message') }}</h3>
			@endif
		 </td>
	</tr>
	<tr>
		<td> {{ Form::label('lbluname', 'Room type') }} </td>
		<td> {{ Form::text('room_id', $record->room_type_id,array('readonly')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lblservice', 'Service') }} </td>
		<td> {{ Form::text('service', $record->service_id,array('readonly')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lblfrom', 'Start date: ') }} </td>
		<td>
			{{ Form::text('from', $record->start_date,array('readonly')) }} 
			{{ Form::label('lblend', 'End date: ') }}
		 	{{ Form::text('to', $record->end_date,array('readonly')) }} 
		</td>
	</tr>
	<tr>
		<td> {{ Form::label('lblprice', 'Room price') }} </td>
		<td> {{ Form::text('price', $record->price, array('required')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lbldiscount', 'Discount rate') }} </td>
		<td> {{ Form::text('discount', $record->discount_rate, array('required')) }} </td>
	</tr>
	<tr>
		<td colspan="2" align="center"> {{ Form::submit('Update calendar record') }} </td>
	</tr>
	{{ Form::close() }}	
</table>
@stop


 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script type="text/javascript" src="{{URL::to('/')}}/js/script.js"></script>