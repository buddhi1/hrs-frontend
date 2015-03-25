<?php

class CustomerController extends BaseController {

	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('user_group');
	}

	public function getIndex() {
	// display the index page where customer can select dates
		return View::make('customer.index');
	}

	public function getRooms() {
		return View::make('customer.rooms');
	}

	public function postRooms() {

		Session::put('start_date', Input::get('start_date'));
		Session::put('end_date', Input::get('end_date'));

		$start_date = Session::get('start_date');
		$end_date = Session::get('end_date');

		//output array
		$all_available_rooms = array();

		//get all prices set rooms within given dates
		$calendar = DB::table('room_price_calenders')
								->select('room_type_id', 'price', 'service_id', 'discount_rate')
								->where('start_date', '>=', $start_date)
								->where('start_date', '<=', $end_date)
								->where('end_date', '>=', $end_date)
								->distinct()
								->get();

		foreach ($calendar as $room_types) {
			$single_room = array();

			// get the total of booked room types from the above selected room types

			$room_no = DB::select(DB::raw("SELECT SUM(no_of_rooms) as room_sum
											FROM bookings
											WHERE ((start_date >= '$start_date' AND start_date <= '$end_date') OR (end_date >= '$start_date' AND end_date <= '$end_date') OR ((start_date <= '$start_date' AND end_date >= '$end_date'))) AND room_type_id = $room_types->room_type_id AND check_out is null"));


			$cart_rooms = 0;

			//getting rooms in the cart
			foreach (Cart::contents() as $carts) {
				if($carts->id == $room_types->room_type_id) {
					$cart_rooms = $cart_rooms + $carts->quantity;
				}
			}


			//get room type details of the available rooms
			$available_room = RoomType::find($room_types->room_type_id);
			$available_service = Service::find($room_types->service_id);
			
			$single_room["id"] = $available_room['id'];
			$single_room["name"] = $available_room['name'];
			$single_room["service"] = $available_service['name'];
			$single_room["service_id"] = $room_types->service_id;
			$single_room["price"] = $room_types->price;
			$single_room["facility"] = $available_room['facilities'];

			//calculating the availble rooms
			$single_room["rooms_qty"] = $available_room['no_of_rooms']-$cart_rooms-intval($room_no[0]->room_sum);

			$all_available_rooms[] = $single_room;
			
		}

		// show the customer a to select the number of rooms
		return View::make('customer.rooms')
			->with('available_rooms',$all_available_rooms);
	}

	public function postBookingsummary() {
		$summary = array();

		// array that will be passed to the blade
		$summary['room_type'] = Input::get('id');
		$summary['name'] = Input::get('name');
		$summary['service'] = Input::get('service');
		$summary['service_id'] = Input::get('service_id');
		$summary['facility'] = Input::get('facility');
		$summary['price'] = Input::get('price')*Input::get('number');
		$summary['room_no'] = Input::get('number');
		$summary['no_of_adults'] = Input::get('no_of_adults');
		$summary['no_of_kids'] = Input::get('no_of_kids');
		$summary['start_date'] = Session::get('start_date');
		$summary['end_date'] = Session::get('end_date');

		//putting the values in the sessions which will be used at the final step
		Session::put('room_type_id', $summary['room_type']);
		Session::put('name', $summary['name']);
		Session::put('service', $summary['service']);
		Session::put('service_id', $summary['service_id']);
		Session::put('facility', $summary['facility']);
		Session::put('price', $summary['price']);
		Session::put('room_no', $summary['room_no']);
		Session::put('no_of_adults', $summary['no_of_adults']);
		Session::put('no_of_kids', $summary['no_of_kids']);

		// show the a summary of the reservation
		return View::make('customer.summary')
			->with('summarys', $summary);
	}

	public function getCustomerform() {
		return View::make('customer.add');
	}

	public function postCustomerform() {
		return View::make('customer.add');
	}

	public function postCreate() {

		$validator = Validator::make(Input::all(), Customer::$rules);

		if($validator->passes()) {
			$customer = New Customer();

			// putting customer details to sessions
			Session::put('cus_identification_no', Input::get('identification_no'));
			Session::put('cus_title', Input::get('title'));
			Session::put('cus_first_name', Input::get('first_name'));
			Session::put('cus_last_name', Input::get('last_name'));
			Session::put('cus_middle_name', Input::get('middle_name'));
			Session::put('cus_sex', Input::get('sex'));
			Session::put('cus_country', Input::get('country'));
			Session::put('cus_email', Input::get('email'));
			Session::put('cus_phone_no', Input::get('phone_no'));
			Session::put('cus_address', Input::get('address'));
			Session::put('cus_flight_info', Input::get('flight_info'));
			Session::put('cus_other', Input::get('other'));

			// saving customer details
			$customer->identification_no = Session::get('cus_identification_no');
			$customer->title = Session::get('cus_title');
			$customer->first_name = Session::get('cus_first_name');
			$customer->last_name = Session::get('cus_last_name');
			$customer->middle_name = Session::get('cus_middle_name');
			$customer->sex = Session::get('cus_sex');
			$customer->country = Session::get('cus_country');
			$customer->email = Session::get('cus_email');
			$customer->phone_no = Session::get('cus_phone_no');
			$customer->address = Session::get('cus_address');
			$customer->flight_info = Session::get('cus_flight_info');
			$customer->other = Session::get('cus_other');

			$customer->save();

			return Redirect::to('customer/payments')
				->with('message', 'Customer is Successfully Created');
		}


		return Redirect::to('customer/customerform')
			->withInput()
			->withErrors($validator);
	}

	public function getPayments() {
		$total_payment = Session::get('price');

		return View::make('customer.payments')
			->with('total', $total_payment);
	}

	public function postBooking() {

		$payment = Input::get('paid_amount');
		
		// checking the paid amount
		if($payment === 'full') {
			$payment_amount = floatval(Session::get('price'));
		} else {
			$room_price = DB::table('room_price_calenders')
						->select('price')
						->where('start_date', '=', Session::get('start_date'))
						->where('service_id', '=', Session::get('service_id'))
						->where('room_type_id', '=', Session::get('room_type_id'))
						->get();

			$payment_amount = floatval($room_price[0]->price);
		}

		$booking = New Booking();

		// saving booking details
		$booking->identification_no = Session::get('cus_identification_no');
		$booking->room_type_id = Session::get('room_type_id');
		$booking->no_of_rooms = Session::get('room_no');
		$booking->no_of_adults = Session::get('no_of_adults');
		$booking->no_of_kids = Session::get('no_of_kids');
		$booking->services = Session::get('service_id');
		$booking->total_charges = Session::get('price');
		$booking->paid_amount = $payment_amount;
		$booking->start_date = Session::get('start_date');
		$booking->end_date = Session::get('end_date');
		$booking->promo_code = Input::get('promo_code');

		if($booking) {
			$booking->save();
			return Redirect::to('customer')
				->with('message','Reserved');

			Session::flush();
		}
	}
}