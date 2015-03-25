<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});


//user level filter
Route::filter('user_group', function($route)
{
		
	
	if(Auth::check()){

		$class = Request::segment(2); //reads the class of selected route
		$action = Request::segment(3); //reads the action of selected route

		if($action == 'update' || $action =='edittimeline' || $action == 'updatetimeline'){
			$action = 'edit';
		}elseif($action == null){
			$action = 'index';
		}elseif ($action == 'destroytimeline') {
			$action = 'destroy';
		}

		//validates the permission for the user group of selected route
	    $check = DB::table('permissions')
	    	->where('id', '=', Auth::user()->permission_id)
	    	->pluck($action.'_'. $class);
	  
	  	if($check == 0){
	  		return Redirect::to('/');
	  	}
	}else{
		return Redirect::to('admin/login');
	}

		
	
});


//Authenticating logedin users
Route::filter('login', function()
{
	if (!Auth::check()) return Redirect::to('admin/login');
});
