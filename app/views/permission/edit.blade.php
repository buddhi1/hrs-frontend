@extends('layouts.main')

@section('content')
<div>
	@if($errors->has())
	<ul>
		@foreach($errors->all() as $error)			
				<li> {{ $error }} </li>			
		@endforeach
	</ul>
	@endif
	@if(Session::has('message'))
		<h3>{{ Session::get('message') }}</h3>
	@endif
</div>


<table>
	{{ Form::open(array('url'=>'/admin/permission/update')) }}
	{{ Form::hidden('id', $record->id) }}
	<tr>
		<td> {{ Form::label('name', 'Permission name: ') }} </td>
		<td> {{ Form::label('name',$record->name,array('required')) }} </td>
	</tr>
		
	@foreach($info as $data)
		<tr>
			<td>&nbsp;</td>
			<td>
				<?php $i=0; ?>
				@if($record->$data[1] == '1')
				<?php $i=1 ?>
					{{ Form::checkbox('permission[]', $data[1], array('required')) }}
				@endif
				@if($i ==0 )
					{{ Form::checkbox('permission[]', $data[1]) }}
				@endif
				{{ $data[0] }}
				<br />
			</td>
		</tr>
	@endforeach
	<tr>
		<td colspan="2" align="center"> {{ Form::submit('Add Permission group') }} </td>
	</tr>
	{{ Form::close() }}
</table>
@stop