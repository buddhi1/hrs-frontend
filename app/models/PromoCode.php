<?php

class PromoCode extends Eloquent {

	public $table = 'promo_codes';
	protected $guarded = array();
	public static $rules = array('service'=>'required');
}