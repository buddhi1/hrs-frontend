
@extends('layouts.main')

@section('content')
<table>
	{{ Form::open(array('url'=>'/admin/user/create')) }}
	<tr>
		<td clospan="2"> 
			@if(Session::has('message'))
				<h3>{{ Session::get('message') }}</h3>
			@endif
		 </td>
	</tr>
	<tr>
		<td> {{ Form::label('lbluname', 'User name') }} </td>
		<td> {{ Form::text('uname','', array('required')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lblpermission', 'Permission Group') }} </td>
		<td> {{ Form::select('permission', $permissions, null, array('required')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lblpassword', 'Password') }} </td>
		<td> {{ Form::password('password', array('required')) }} </td>
	</tr>
	<tr>
		<td colspan="2" align="center"> {{ Form::submit('Add user') }} </td>
	</tr>
	{{ Form::close() }}
</table>
@stop

