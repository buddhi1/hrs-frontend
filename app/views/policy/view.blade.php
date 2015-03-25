@extends('layouts.main')

@section('content')
	<h3>Add a New Policy</h3>
	{{ Form::open(array('url' => 'admin/policy/create')) }}

	<table>
		<tr>
			<td>{{ Form::label('Policy Description') }}</td>
			<td>{{ Form::textarea('description',null, array('required', 'rows' => 5)) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('Tax Rate') }}</td>
			<td>{{ Form::text('tax', null) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('Cancellation') }}</td>
			<td>{{ Form::text('days', null, array('placeholder' => 'Number of days')) }} {{ Form::text('rate', null, array('placeholder' => 'Rate')) }}</td>
		</tr>

		<tr>
			<td colspan = "2" align = "right">{{ Form::submit('Submit') }}</td>
		</tr>

	</table>
	{{ Form::close()}}

	@if(Session::has('policy_message_add'))

	<p class="text-success">{{ Session::get('fac_message_add') }}</p>
		
	@endif

	@if(Session::has('policy_message_add'))

	<p class="text-danger">{{ Session::get('policy_message') }}</p>
	
	@endif


	<h3>All Policies</h3>

	<table border = "1">
		<th>Policy Description</th>
		<th>Variables</th>
		<th>Edit</th>
		<th>Delete</th>
	@foreach($policies as $policy)
	
		<tr>
			<td>{{ $policy->description }}</td>
			<td>{{ $policy->variables }}</td>
			<td>
				{{ Form::open(array('url' => 'admin/policy/edit')) }}
				{{ Form::hidden('id', $policy->id) }}
				{{ Form::submit('Edit') }}
				{{ Form::close() }}
			</td>
			<td>
				{{ Form::open(array('url' => 'admin/policy/destroy')) }}
				{{ Form::hidden('id', $policy->id) }}
				{{ Form::submit('Delete') }}
				{{ Form::close() }}
			</td>
		</tr>
	
	@endforeach
	</table>

	@if(Session::has('policy_message'))

	<p class="text-success">{{ Session::get('policy_message') }}</p>

	@endif

@stop