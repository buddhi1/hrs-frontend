@extends('layouts.main')

@section('content')

<h2>Room price calendar</h2>
<table>
	{{ Form::open(array('url'=>'/admin/calendar/create')) }}
	<tr>
		<td clospan="2"> 
			@if(Session::has('message'))
				<h3>{{ Session::get('message') }}</h3>
			@endif
		 </td>
	</tr>
	<tr>
		<td> {{ Form::label('lbluname', 'Room type') }} </td>
		<td> {{ Form::select('roomType', $roomTypes, null, array('id'=>'roomType')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lblservice', 'Service') }} </td>
		<td> {{ Form::select('service', $services, null, array('required', 'id'=>'service')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lblfrom', 'Start date') }} </td>
		<td>
			{{ Form::text('from', '', array('required', 'id'=>'from')) }} 
			{{ Form::label('lblend', 'End date') }}
		 	{{ Form::text('to', '', array('required', 'id'=>'to')) }} 
		</td>
	</tr>
	<tr>
		<td> {{ Form::label('lblprice', 'Room price') }} </td>
		<td> {{ Form::text('price', '', array('required')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lbldiscount', 'Discount rate') }} </td>
		<td> {{ Form::text('discount', '', array('required')) }} </td>
	</tr>
	<tr>
		<td colspan="2" align="center"> {{ Form::submit('Add to calendar') }} </td>
	</tr>
	{{ Form::close() }}
</table>
@stop


 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script type="text/javascript" src="{{URL::to('/')}}/js/script.js"></script>
