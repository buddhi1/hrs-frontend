<?php

class Tax extends Eloquent {
	
	protected $guarded = array();
	public static $rules = array(
		'name'=>'required',
		'rate'=>'required');
}