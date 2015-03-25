<?php

class Booking extends Eloquent {

	protected $guarded = array();
	public static $rules = array();
	
	public static $rules1 = array(
		'id_no'=> 'required',
		'start_date' => 'required|date',
		'end_date' => 'required|date',
		'no_of_adults'=>'required|numeric',
		'no_of_kids'=>'required|numeric',
		'no_of_rooms' => 'required|numeric',
		'promo_code'=>'required'
		);
}