@extends('layouts.main')

@section('content')
	<h3>Edit a Policy</h3>
	{{ Form::open(array('url' => 'admin/policy/update')) }}
	{{ Form::hidden('id', $policies->id) }}

	<table>
		<tr>
			<td>{{ Form::label('Policy Description') }}</td>
			<td>{{ Form::textarea('description',$policies->description, array('required', 'rows' => 5)) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('Variables') }}</td>
			<td>{{ Form::textarea('variables',$policies->variables, array('required', 'rows' => 5)) }}</td>
		</tr>

		<tr>
			<td colspan = "2" align = "right">{{ Form::submit('Submit') }}</td>
		</tr>

	</table>
	{{ Form::close()}}

@stop