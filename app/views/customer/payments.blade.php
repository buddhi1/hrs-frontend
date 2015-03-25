@extends('layouts.main')

@section('content')

Card Type
{{ Form::select('card_type', array('Mastercard', 'Visa', 'American Expresse')) }}
<br>

{{ Form::open(array('url' => 'customer/booking')) }}

Total Amount: {{$total}}

{{ Form::select('paid_amount', array(
    'full' => 'Full Payment',
    'part' => '1st Night',
)) }}

<br>

Enter Promo Code {{ Form::text('promo_code', null) }}
<br>

{{ Form::submit('Reserve')}}

{{ Form::close() }}

@stop