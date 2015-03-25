<?php
/*
	Name:		TaxController
	Purpose:	Controllers for Tax

	History:	Created 13/03/2015 by buddhi ashan	 
*/

class TaxController extends BaseController {

	public function __construct() {
		$this->beforeFilter('csrf',array('on' => 'post'));
		$this->beforeFilter('user_group');
	}

	//views the add tax page
	public function getCreate(){

		return View::make('tax.create');
	}

	//create tax operation
	public function postCreate(){

		$validator = Validator::make(Input::all(), Tax::$rules);	

		if($validator->passes()){
			$tax = new Tax;

			$tax->name = Input::get('name');
			$tax->rate = Input::get('rate');

			$tax->save();

			return Redirect::to('admin/tax/create')
				->with('message', 'New tax added successfully');
		}

		return Redirect::to('admin/tax/create')
			->withErrors($validator)
			->withInput();
	}


	//Views all tax page
	public function getIndex(){

		return View::make('tax.view')
			->with('taxes', Tax::all());
	}

	//views the tax edit page
	public function postEdit(){
	
		$tax = Tax::find(Input::get('id') );

		return View::make('tax.edit')
			->with('id', $tax->id)
			->with('name', $tax->name)
			->with('rate', $tax->rate);
	}

	//Edit operation
	public function postUpdate(){
		$validator = Validator::make(Input::all(), Tax::$rules);	

		if($validator->passes()){
			$tax = Tax::find(Input::get('id') );
			$tax->name = Input::get('name');
			$tax->rate = Input::get('rate');

			$tax->save();

			return Redirect::to('admin/tax')
				->with('message', 'Tax edited successfully');
		}

		return Redirect::to('admin/tax')
			->withErrors($validator);
	}

	//Delete existing tax
	public function postDestroy(){

		$tax = Tax::find(Input::get('id'));
		$tax->delete();

		return Redirect::to('admin/tax');
	}
}