@extends('layouts.main')

@section('content')

@if(Session::has('message'))
	<h3>{{ Session::get('message') }}</h3>
@endif

<table border="1">
	</tr>
	<tr>
		<th>User id</th>
		<th>User name</th>
		<th>permission group</th>
		<th colspan="2">Edit / Delete</th>
	</tr>
	@foreach($users as $user)
	<tr>
		<td>{{$user->uid}}</td>
		<td>{{$user->uname}}</td>
		<td>{{ $user->name }}</td>
		{{ Form::open(array('url'=>'admin/user/edit')) }}
		<td>
			{{Form::hidden('id',$user->uid)}} 
			{{ Form::submit('Edit') }} 
		</td>
		{{ Form::close() }}
		{{ Form::open(array('url'=>'admin/user/destroy')) }}
		<td> 
			{{Form::hidden('id',$user->uid)}}
			{{ Form::submit('Delete') }}
		 </td>
		{{ Form::close() }}
	</tr>
@endforeach	
</table>	


@stop