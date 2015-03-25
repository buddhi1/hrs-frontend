@extends('layouts.main')

@section('content')

<h2>Promotion calendar</h2>
<table>
	{{ Form::open(array('url'=>'/admin/promotion/create')) }}
	<tr>
		<td clospan="2"> 
			@if(Session::has('message'))
				<h3>{{ Session::get('message') }}</h3>
			@endif
		 </td>
	</tr>

	<tr>
		<td> {{ Form::label('lbluname', 'Room type') }} </td>
		<td> {{ Form::select('room_id', $roomTypes, null) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lblservice', 'Service') }} </td>
		<td> 
			@foreach($services as $service)
				{{ Form::checkbox('service[]', $service->name) }}
				{{ $service->name }}
				<br>
			@endforeach

		</td>
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
		<td> {{ Form::label('lbldiscount', 'Number of stays') }} </td>
		<td> {{ Form::text('stays', '', array('required')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lblrooms', 'Number of rooms booked') }} </td>
		<td> {{ Form::text('rooms', '', array('required')) }} </td>
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
		<td colspan="2" align="center"> {{ Form::submit('Add promotion') }} </td>
	</tr>
	<div>
		@if($errors->has())
			<p>Following errors occured:</p>
			<ul>
				@foreach($errors->all() as $error)
					<li>{{$error }}</li>
				@endforeach
			</ul>
		@endif
	</div>	
	{{ Form::close() }}
</table>
@stop


 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script type="text/javascript" src="{{URL::to('/')}}/js/script.js"></script>