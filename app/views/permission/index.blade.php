@extends('layouts.main')

@section('content')

@if(Session::has('message'))
	<h3>{{ Session::get('message') }}</h3>
@endif
@if($errors->has())
	<ul>
		@foreach($errors->all() as $error)			
				<li> {{ $error }} </li>			
		@endforeach
	</ul>
	@endif
<table border="1">
	</tr>
	<tr>
		<th>Permission id</th>
		<th>Permission group name</th>

		@foreach($info as $data)
			<th>{{ $data[0] }}</th>
		@endforeach
		<th colspan="2">Edit / Delete</th>
	</tr>
	@foreach($groups as $group)
	<tr>
		<td>{{$group->id}}</td>
		<td>{{$group->name}}</td>
		@foreach($info as $data)
			@if($group->$data[1] == '1')
				<td>{{ 'Yes' }}</td>
			@else
				<td>{{ 'No' }}</td>
			@endif
		@endforeach
		{{ Form::open(array('url'=>'admin/permission/edit')) }}
		<td>
			{{Form::hidden('id',$group->id)}} 
			{{ Form::submit('Edit') }} 
		</td>
		{{ Form::close() }}
		{{ Form::open(array('url'=>'admin/permission/destroy')) }}
		<td> 
			{{Form::hidden('id',$group->id)}}
			{{ Form::submit('Delete') }}
		 </td>
		{{ Form::close() }}
	</tr>
@endforeach	
</table>	


@stop