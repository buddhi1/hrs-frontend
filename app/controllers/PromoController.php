<?php

class PromoController extends BaseController {

	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('user_group');
	}

	public function getIndex() {
	// display all the promo codes

		return View::make('promo.view')
			->with('promos', PromoCode::all())
			->with('rooms', RoomType::all());
	}

	public function getCreate() {
	// display the form to create the new promo code

		return View::make('promo.add')
			->with('services', Service::all())
			->with('rooms', RoomType::all());
	}

	public function postCreate() {
	// add a new promo code to the database

		$validator = Validator::make(Input::all(), PromoCode::$rules);

		if($validator->passes()) {
			$promo = New PromoCode();

			$promo->promo_code = Input::get('promo_code');
			$promo->start_date = Input::get('start_date');
			$promo->end_date = Input::get('end_date');
			$promo->price = Input::get('price');
			$promo->days = Input::get('days');
			$promo->room_type_id = Input::get('room_id');
			$promo->no_of_rooms = Input::get('no_of_rooms');
			$promo->services = json_encode(Input::get('service'));

			$promo->save();

			return Redirect::to('admin/promo')
				->with('promo_message','Promo Code is succesfully added');
		}

		return Redirect::to('admin/promo')
				->with('promo_message','Services cannot be empty');
	}

	public function postEdit() {

		return View::make('promo.edit')
			->with('promos', Promocode::find(Input::get('id')))
			->with('services', Service::all())
			->with('promo_message', ' ');
			//->with('promo_message', "Services cannot be empty");
	}

	public function postUpdate() {
	// update a existing Promo Code

		$validator = Validator::make(Input::all(), PromoCode::$rules);

		if($validator->passes()) {
			$promo = PromoCode::find(Input::get('id'));

			$promo->promo_code = Input::get('promo_code');
			$promo->start_date = Input::get('start_date');
			$promo->end_date = Input::get('end_date');
			$promo->price = Input::get('price');
			$promo->days = Input::get('days');
			$promo->room_type_id = Input::get('room_type_id');
			$promo->no_of_rooms = Input::get('no_of_rooms');
			$promo->services = json_encode(Input::get('service'));

			$promo->save();

			return Redirect::to('admin/promo')
				->with('promo_message','Promo Code is succesfully updated');
		}

		return View::make('promo.edit')
			->with('promo_message', 'Services cannot be empty')
			->with('promos', Promocode::find(Input::get('id')))
			->with('services', Service::all());
	}

	public function postDestroy() {
	// delete an existing Promo Code

		$promo = PromoCode::find(Input::get('id'));

		if($promo) {
			$promo->delete();
			return Redirect::To('admin/promo')
				->with('promo_message', "Promo Code has been deleted");
		}
	}

}