<?php

class RoomType extends Eloquent {

	public $table = 'room_types';
	protected $guarded = array();
	public static $rules = array(
		'service'=>'required',
		'facility'=>'required');
}