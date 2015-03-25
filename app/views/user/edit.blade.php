@extends('layouts.main')

@section('content')
<table>
	{{ Form::open(array('url'=>'/admin/user/update')) }}
	{{ Form::hidden('id', $user->id) }}
	<tr>
		<td> {{ Form::label('lbluname', 'User name') }} </td>
		<td> {{ Form::text('uname',$user->name, array('required')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lblpermission', 'Permission Group') }} </td>
		<td> {{ Form::select('permission', $permissions, $user->permission_id, array('required')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lblpassword', 'Password') }} </td>
		{{ Form::hidden('hashPassword', $user->password) }}
		<td> {{ Form::password('password') }} </td>
	</tr>
	<tr>
		<td colspan="2" align="center"> {{ Form::submit('Update user') }} </td>
	</tr>
	{{ Form::close() }}
</table>
@stop