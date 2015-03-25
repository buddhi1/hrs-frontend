@extends('layouts.main')

@section('content')

@if(Session::has('message'))
	<h3>{{ Session::get('message') }}</h3>
@endif
<table border="1">
	<tr>
		<th>Room type</th>
		<th>Service</th>
		<th>Description</th>	
		<th colspan="2">Edit/Delete</th>	
	</tr>
	
		
		@foreach($rooms as $room)
		<tr>			
			<td> {{ $room->room_type_id }}</td>
			<td> {{ $room->service_id }}</td>
			<td>
			<table>
				<tr>
					@foreach($calendar as $type)
					<td> 
						<ul>
							@if($room->room_type_id == $type->room_type_id && $room->service_id == $type->service_id)
							<li>Duration:{{ $type->start_date." to ".$type->end_date }} </li>
							<li>Price:{{ $type->price }}</li>
							<li>Discount rate:{{ $type->discount_rate }}</li>
							<li>No. of days:{{ $type->days }}</li>
							<li>
								{{ Form::open(array('url'=>'admin/calendar/destroy')) }}	
								{{ Form::hidden('room_id',$type->room_type_id) }}
								{{ Form::hidden('service_id', $type->service_id) }}
								{{ Form::hidden('date',$type->end_date) }}
		 						{{ Form::submit('Delete') }}		
								{{ Form::close() }}
							</li>
							<li>
								{{ Form::open(array('url'=>'admin/calendar/edit')) }}
								{{ Form::hidden('id',$type->id) }}
								{{ Form::hidden('date',$type->end_date) }}
								{{ Form::submit('Edit') }} 
								{{ Form::close() }}	
							</li>
							@endif
						</ul>
					</td>
					@endforeach
				</tr>
			</table>
			</td>
			{{ Form::open(array('url'=>'admin/calendar/edittimeline')) }}
				{{ Form::hidden('room_id',$room->room_type_id) }}
				{{ Form::hidden('service_id',$room->service_id) }}
			<td>	{{ Form::submit('Edit time line') }} </td>
			{{ Form::close() }}			
			
			{{ Form::open(array('url'=>'admin/calendar/destroytimeline')) }}	
				{{ Form::hidden('room_id',$room->room_type_id) }}
				{{ Form::hidden('service_id', $room->service_id) }}
				{{-- Form::hidden('date',$room->end_date) --}}
		 		<td>{{ Form::submit('Delete time line') }} </td>		
			{{ Form::close() }}
						
		</tr>		
		@endforeach
</table>



@stop


	@for($i=date("m",strtotime($start_date)); $i <= date("m",strtotime($end_date)); $i++)
		<th>{{ date("F",strtotime($start_date))  }}</th>
		<?php
			$start_date = date("F",strtotime($start_date. '+1 month'));
		?>
	@endfor	
