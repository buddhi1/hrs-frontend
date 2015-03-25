<?php

/*
	Name:		Room_price_calendar
	Purpose:	Database class for Room_price_calendar table

	History:	Created 26/02/2015 by buddhi ashan	 
*/


class Calendar extends Eloquent
{
	public $table = 'room_price_calenders';
	protected $guarded = array();

	public static $rules = array();
}
