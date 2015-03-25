<?php

/*
	Name:		Permission
	Purpose:	Database class for Permission table

	History:	Created 25/02/2015 by buddhi ashan	 
*/


class Permission extends Eloquent
{
	
	protected $guarded = array();

	public static $rules = array('permission'=>'required');
}
