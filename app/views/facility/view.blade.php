@extends('layouts.main')

@section('content')
	<h3>Add a New Facility</h3>
	{{ Form::open(array('url' => 'admin/facility/create')) }} 
	<table>
		<tr>
			<td>{{ Form::label('facility_name', 'Facility Name') }}</td>
			<td>{{ Form::text('name',null, array('required')) }}</td>
		</tr>

		<tr>
			<td colspan = "2" align = "right">{{ Form::submit('Submit') }}</td>
		</tr>

	</table>
	{{ Form::close()}}

	@if(Session::has('fac_message_add'))

	<p class="text-success">{{ Session::get('fac_message_add') }}</p>
		
	@endif

	@if(Session::has('fac_message_err'))

	<p class="text-danger">{{ Session::get('fac_message_err') }}</p>
	
	@endif


	<h3>All Facilities</h3>

	<table border = "1">
		<th>Facility Name</th>
		<th>Delete</th>
	@foreach($facilities as $facility)
	
		<tr>
			<td>{{ $facility->name }}</td>
			<td>
				{{ Form::open(array('url' => 'admin/facility/destroy')) }}
				{{ Form::hidden('id', $facility->id) }}
				{{ Form::submit('Delete') }}
				{{ Form::close() }}
			</td>
		</tr>
	
	@endforeach
	</table>

	@if(Session::has('fac_message_del'))

	<p class="text-success">{{ Session::get('fac_message_del') }}</p>

	@endif

@stop
