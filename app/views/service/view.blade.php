@extends('layouts.main')

@section('content')
	<h3>Add a New Service</h3>
	{{ Form::open(array('url' => 'admin/service/create')) }}

	<table>
		<tr>
			<td>{{ Form::label('service_name', 'Service Name') }}</td>
			<td>{{ Form::text('name',null, array('required')) }}</td>
		</tr>

		<tr>
			<td colspan = "2" align = "right">{{ Form::submit('Submit') }}</td>
		</tr>

	</table>
	{{ Form::close()}}

	@if(Session::has('ser_message_add'))

	<p class="text-success">{{ Session::get('ser_message_add') }}</p>
		
	@endif

	@if(Session::has('ser_message_err'))

	<p class="text-danger">{{ Session::get('ser_message_err') }}</p>
	
	@endif


	<h3>All Services</h3>

	<div width = "500">
		<table border = "1">
			<th>Service Name</th>
			<th>Delete</th>
		@foreach($services as $service)
		
			<tr>
				<td>{{ $service->name }}</td>
				<td>
					{{ Form::open(array('url' => 'admin/service/destroy')) }}
					{{ Form::hidden('id', $service->id) }}
					{{ Form::submit('Delete') }}
					{{ Form::close() }}
				</td>
			</tr>
		
		@endforeach
		</table>

	@if(Session::has('ser_message_del'))

	<p class="text-success">{{ Session::get('ser_message_del') }}</p>
	
	@endif

@stop