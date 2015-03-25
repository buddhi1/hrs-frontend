<?php

class Customer extends Eloquent {

	protected $guarded = array();
	protected $fillable = array('identification_no', 'title', 'first_name', 'last_name', 'middle_name', 'sex', 'country', 'email', 'phone_no', 'address', 'flight_info', 'other');
	public static $rules = array(
		'identification_no' => 'required',
		'title' => 'required',
		'first_name' => 'required',
		'last_name' => 'required',
		'sex' => 'required',
		'country' => 'required',
		'email' => 'email|required',
		'phone_no' => 'required',
		'address' => 'required'
		);
}