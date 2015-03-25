<?php
/*
	Name:		 LoginController
	Purpose:	Controllers for login

	History:	Created 16/03/2015 by buddhi ashan	 
*/

class LoginController extends BaseController {

	//Views login page
	public function getLogin(){
		return View::make('user.login');
	}

	//lgin for users
	public function postLogin(){

		$rules = array(
		   'name'    => 'required', 
		   'password' => 'required' 
		);

		$validator = Validator::make(Input::all(), $rules);


		if ($validator->fails()) {
		    return Redirect::to('admin/login')
		        ->withErrors($validator) // send back all errors to the login form
		        ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		} else {

		    // create our user data for the authentication
		    $userdata = array(
		        'name'     => Input::get('name'),
		        'password'  =>  Input::get('password')
   	 			);

		 		if (Auth::attempt($userdata)) {

		        // validation successful!
		     		
		        	return Redirect::to('admin/user')
		        		->with('message', 'Login successfull'.Auth::user()->permission_id);

    			} else {        

		        // validation not successful, send back to form 
		        	return Redirect::to('admin/login')
		        		->with('message', 'Login unsuccessfull.Please try again');
    			}

			}
	}

	//User logout
	public function getLogout(){	//change get to post
		Auth::logout();

		return Redirect::to('admin/login')
			->with('message', 'Logout successfully');		
	}

}