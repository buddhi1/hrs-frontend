<?php

/*
	Name:		Promotion_calendar
	Purpose:	Database class for Promotion_calendar table

	History:	Created 02/03/2015 by buddhi ashan	 
*/


class Promotion extends Eloquent
{
	public $table = 'promotion_calenders';
	protected $guarded = array();

	public static $rules = array('service'=>'required');
}
