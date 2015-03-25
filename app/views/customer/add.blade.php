@extends('layouts.main')

@section('content')

	{{ Form::open(array('url' => 'customer/create')) }}

	<table>
		<tr>
			
			<td>{{ Form::label('Identification No') }}</td>
			<td>{{ Form::text('identification_no', null) }}</td>
		</tr>
		<tr>
			
			<td>{{ Form::label('Title') }}</td>
			<td>{{ Form::radio('title', "Mr.") }} Mr. &nbsp; {{ Form::radio('title', "Mrs.") }} Mrs.</td>
		</tr>
		<tr>
			
			<td>{{ Form::label('First Name') }}</td>
			<td>{{ Form::text('first_name', null) }}</td>
		</tr>
		<tr>
			
			<td>{{ Form::label('Last Name') }}</td>
			<td>{{ Form::text('last_name', null) }}</td>
		</tr>
		<tr>
			
			<td>{{ Form::label('Middle Name') }}</td>
			<td>{{ Form::text('middle_name', null) }}</td>
		</tr>
		<tr>
			
			<td>{{ Form::label('Gender') }}</td>
			<td>{{ Form::radio('sex', "M") }} Male &nbsp; {{ Form::radio('sex', "F") }} Female</td>
		</tr>
		<tr>
			
			<td>{{ Form::label('Country') }}</td>
			<td>{{ Form::text('country', null) }}</td>
		</tr>
		<tr>
			
			<td>{{ Form::label('Email') }}</td>
			<td>{{ Form::text('email', null) }}</td>
		</tr>
		<tr>
			
			<td>{{ Form::label('Phone Number') }}</td>
			<td>{{ Form::text('phone_no', null) }}</td>
		</tr>
		<tr>
			
			<td>{{ Form::label('Address') }}</td>
			<td>{{ Form::text('address', null) }}</td>
		</tr>
		<tr>
			
			<td>{{ Form::label('Flight Information') }}</td>
			<td>{{ Form::text('flight_info', null) }}</td>
		</tr>
		<tr>
			
			<td>{{ Form::label('Other Information') }}</td>
			<td>{{ Form::textarea('other', null) }}</td>
		</tr>
		<tr>
			
			<td></td>
			<td>{{ Form::submit('Submit') }}</td>
		</tr>
	</table>

	{{ Form::close() }}

	@if(Session::has('message'))

		<p>{{ Session::get('message') }}</p>
		
	@endif

	@foreach($errors->all() as $error)
		<p>{{ $error }}</p>
	@endforeach

@stop