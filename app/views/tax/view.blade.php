@extends('layouts.main')

@section('content')
@if($errors->has())
	<div>
		<p>Following errors occured:</p>
		<ul>
			@foreach($errors->all() as $error)
				<li>{{$error }}</li>
			@endforeach
		</ul>
	</div>
@endif

@if(Session::has('message'))
	{{ Session::get('message') }}
@endif	
<table border="1">
	<tr>
		<th>Id</th>
		<th>Tax Name</th>
		<th>Tax Rate</th>
		<th colspan="2">Edit/Delete</th>
	</tr>
	@foreach($taxes as $tax)
	<tr>
		<td> {{ $tax->id }} </td>
		<td> {{ $tax->name }} </td>
		<td> {{ $tax->rate }} </td>
		<td> 
			{{ Form::open(array('url'=>'admin/tax/edit')) }}
			{{ Form::hidden('id', $tax->id) }}
			{{ Form::submit('Edit') }}
			{{ Form::close() }}
		</td>	
		<td> 
			{{ Form::open(array('url'=>'admin/tax/destroy')) }}
			{{ Form::hidden('id', $tax->id) }}
			{{ Form::submit('Delete') }}
			{{ Form::close() }}
		</td>
	</tr>
	@endforeach
</table>

@stop