<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
/*
Route::get('/', function()
{
	return View::make('hello');
});
*/

Route::controller('admin/facility','FacilityController');

Route::controller('admin/service', 'ServiceController');

Route::controller('admin/room','RoomController');

Route::controller('admin/user', 'UserController');

Route::controller('admin/permission', 'PermissionController');

Route::controller('admin/calendar', 'CalendarController');

Route::controller('admin/promo', 'PromoController');

Route::controller('admin/promotion', 'PromotionController');

Route::controller('admin/policy', 'PolicyController');

Route::controller('booking', 'BookingController');

Route::post('/loadItem','BookingController@loaditem');

Route::controller('admin/checkin', 'CheckinController');

Route::controller('admin/booking', 'BookingController');

Route::controller('admin/tax', 'TaxController');

Route::controller('admin', 'LoginController');

Route::controller('customer', 'CustomerController');

Route::get('/', function(){
	return View::make('main');
});

